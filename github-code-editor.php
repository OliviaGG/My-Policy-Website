<?php
/*
Plugin Name: GitHub Code Editor
Description: Admins can edit files and save directly to a GitHub repo.
Version: 0.1
Author: Your Name

INSTRUCTIONS:
1. Upload this file to your WordPress site's 'wp-content/plugins/github-code-editor/' directory. (Create the 'github-code-editor' folder if it doesn't exist.)
2. Go to your WordPress dashboard > Plugins and activate 'github-code-editor'.
3. You will see a new 'Team Members' section in the dashboard. Add/edit members there.
4. To display the plugin, add the shortcode [github-code-editor] to any page or post.
*/

// 1. Create the admin menu page
add_action('admin_menu', function() {
    add_menu_page(
        'GitHub Code Editor',
        'GitHub Code Editor',
        'manage_options',
        'github-code-editor',
        'wpge_admin_page',
        'dashicons-editor-code'
    );
});

function wpge_admin_page() {
    ?>
    <div class="wrap">
        <h1>GitHub Code Editor</h1>
        <div>
            <label for="ge-file-path">File Path in Repo:</label>
            <input type="text" id="ge-file-path" value="README.md" style="width: 300px;">
            <button id="ge-load">Load</button>
        </div>
        <div id="ge-editor" style="height:400px;border:1px solid #ddd;margin-top:10px;"></div>
        <button id="ge-save" style="margin-top:10px;">Save to GitHub</button>
        <div id="ge-status"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.45.0/min/vs/loader.js"></script>
    <script>
    let editor, sha = '';
    function wpge_setStatus(msg, isError = false) {
        document.getElementById('ge-status').textContent = msg;
        document.getElementById('ge-status').style.color = isError ? 'red' : 'green';
    }

    require.config({ paths: { 'vs': 'https://cdn.jsdelivr.net/npm/monaco-editor@0.45.0/min/vs' }});
    require(['vs/editor/editor.main'], function() {
        editor = monaco.editor.create(document.getElementById('ge-editor'), {
            value: '',
            language: 'javascript',
            theme: 'vs-dark'
        });
    });

    document.getElementById('ge-load').onclick = function() {
        let path = document.getElementById('ge-file-path').value;
        wpge_setStatus('Loading...');
        fetch(ajaxurl + '?action=wpge_load_file&path=' + encodeURIComponent(path), {
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                editor.setValue(atob(data.content));
                sha = data.sha || '';
                wpge_setStatus('Loaded: ' + path);
            } else {
                wpge_setStatus(data.data || 'Failed to load', true);
            }
        });
    };

    document.getElementById('ge-save').onclick = function() {
        let path = document.getElementById('ge-file-path').value;
        let content = editor.getValue();
        let msg = prompt('Commit message:', 'Update ' + path);
        if (!msg) return;
        wpge_setStatus('Saving...');
        fetch(ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                action: 'wpge_save_file',
                path,
                content: btoa(content),
                message: msg,
                sha
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                sha = data.sha || '';
                wpge_setStatus('Saved to GitHub!');
                document.getElementById('ge-preview-frame').src = '/path-to-preview/' + path; // Update preview
            } else {
                wpge_setStatus(data.data || 'Failed to save', true);
            }
        });
    };
    </script>
    <?php
}

// 2. AJAX handler to load file from GitHub
add_action('wp_ajax_wpge_load_file', function() {
    if (!current_user_can('manage_options')) wp_send_json_error('Not authorized');
    $repo = 'OliviaGG/My-Policy-Website'; // CHANGE to your repo
    $token = 'YOUR_GITHUB_TOKEN'; // SECURE THIS: Use env var, wp-config, or wp options (never commit real token)

    $path = sanitize_text_field($_GET['path']);
    $url = "https://api.github.com/repos/$repo/contents/$path";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        "User-Agent: WP-GitHub-Editor"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resp = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    if ($info['http_code'] == 200) {
        $data = json_decode($resp, true);
        wp_send_json_success([
            'content' => $data['content'],
            'sha' => $data['sha']
        ]);
    } else {
        wp_send_json_error('File not found or error');
    }
});

// 3. AJAX handler to save file to GitHub
add_action('wp_ajax_wpge_save_file', function() {
    if (!current_user_can('manage_options')) wp_send_json_error('Not authorized');
    $repo = 'OliviaGG/My-Policy-Website'; // CHANGE to your repo
    $token = 'YOUR_GITHUB_TOKEN'; // SECURE THIS better in production!

    $path = sanitize_text_field($_POST['path']);
    $content = $_POST['content'];
    $message = sanitize_text_field($_POST['message']);
    $sha = isset($_POST['sha']) ? sanitize_text_field($_POST['sha']) : null;

    $url = "https://api.github.com/repos/$repo/contents/$path";
    $data = [
        'message' => $message,
        'content' => $content,
        'branch' => 'main'
    ];
    if ($sha) $data['sha'] = $sha;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: token $token",
        "User-Agent: WP-GitHub-Editor",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $resp = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    if (in_array($info['http_code'], [200,201])) {
        $out = json_decode($resp, true);
        wp_send_json_success(['sha' => $out['content']['sha'] ?? '']);
    } else {
        wp_send_json_error('Failed to save file: ' . $resp);
    }
});

// 4. Code to show the edits (live preview)
<?php
<div id="ge-preview" style="height:400px;border:1px solid #ddd;margin-top:10px;">
    <iframe id="ge-preview-frame" style="width:100%;height:100%;border:none;"></iframe>
</div>
