<?php
/*
Plugin Name: Leadership Team
Description: Easily manage and display your leadership team.
Version: 1.0
Author: Your Name

INSTRUCTIONS:
1. Upload this file to your WordPress site's 'wp-content/plugins/leadership-team/' directory. (Create the 'leadership-team' folder if it doesn't exist.)
2. Go to your WordPress dashboard > Plugins and activate 'Leadership Team'.
3. You will see a new 'Team Members' section in the dashboard. Add/edit members there.
4. To display the team, add the shortcode [leadership_team] to any page or post.
*/

// Register custom post type
function lt_register_team_member() {
    register_post_type('team_member', array(
        'labels' => array(
            'name' => 'Team Members',
            'singular_name' => 'Team Member',
            'add_new_item' => 'Add New Team Member',
            'edit_item' => 'Edit Team Member'
        ),
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'editor', 'thumbnail')
    ));
}
add_action('init', 'lt_register_team_member');

// Add custom fields (position)
function lt_add_team_member_meta_box() {
    add_meta_box('lt_team_member_position', 'Position/Title', 'lt_team_member_position_callback', 'team_member', 'normal', 'default');
}
add_action('add_meta_boxes', 'lt_add_team_member_meta_box');

function lt_team_member_position_callback($post) {
    $value = get_post_meta($post->ID, '_lt_position', true);
    echo '<input type="text" name="lt_position" value="' . esc_attr($value) . '" style="width:100%;" />';
}

function lt_save_team_member_position($post_id) {
    if (array_key_exists('lt_position', $_POST)) {
        update_post_meta($post_id, '_lt_position', sanitize_text_field($_POST['lt_position']));
    }
}
add_action('save_post', 'lt_save_team_member_position');

// Shortcode to display team
function lt_team_shortcode($atts) {
    $args = array('post_type' => 'team_member', 'posts_per_page' => -1);
    $query = new WP_Query($args);
    $output = '<div class="lt-team-grid">';
    while ($query->have_posts()) {
        $query->the_post();
        $position = get_post_meta(get_the_ID(), '_lt_position', true);
        $output .= '<div class="leader-card">';
        if (has_post_thumbnail()) {
            $output .= '<img src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '" alt="' . esc_attr(get_the_title()) . ', ' . esc_attr($position) . '" />';
        } else {
            $output .= '<img src="' . get_stylesheet_directory_uri() . '/images/default-placeholder.png" alt="Default Image" />';
        }
        $output .= '<h2>' . get_the_title() . '</h2>';
        $output .= '<p class="title">' . esc_html($position) . '</p>';
        $output .= '<p class="bio">' . get_the_content() . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';
    wp_reset_postdata();
    return $output;
}
add_shortcode('leadership_team', 'lt_team_shortcode');

// Optional: Add some basic styles
function lt_team_styles() {
    echo '<style>
    .lt-team-grid { display: flex; flex-wrap: wrap; gap: 2em; justify-content: center; }
    .lt-team-member { border: 1px solid #ddd; padding: 1em; border-radius: 8px; width: 250px; background: #fafafa; box-sizing: border-box; }
    .lt-team-member img { max-width: 100%; border-radius: 50%; }
    </style>';
}
add_action('wp_head', 'lt_team_styles');
