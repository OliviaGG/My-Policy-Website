<?php
/*
Plugin Name: Custom Layout Plugin
Description: Provides a reusable layout for new pages.
Version: 1.0
Author: Your Name
*/

// Register the custom page template
add_filter('theme_page_templates', function($templates) {
    $templates['custom-layout-template.php'] = 'Custom Layout';
    return $templates;
});

// Load the custom page template
add_filter('template_include', function($template) {
    if (is_page() && get_page_template_slug() === 'custom-layout-template.php') {
        $custom_template = plugin_dir_path(__FILE__) . 'custom-layout-template.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    return $template;
});
