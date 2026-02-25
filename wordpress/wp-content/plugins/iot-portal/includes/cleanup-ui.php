<?php

add_action('admin_menu', 'iot_remove_default_menus', 999);

function iot_remove_default_menus() {

    remove_menu_page('index.php');          // Dashboard
    remove_menu_page('edit.php');           // Posts
    remove_menu_page('upload.php');         // Media
    remove_menu_page('edit.php?post_type=page'); // Pages
    remove_menu_page('edit-comments.php');  // Comments
    remove_menu_page('themes.php');         // Appearance
    remove_menu_page('plugins.php');        // Plugins
    remove_menu_page('users.php');          // Users
    remove_menu_page('tools.php');          // Tools
    remove_menu_page('options-general.php'); // Settings

}

add_action('wp_dashboard_setup', 'iot_remove_dashboard_widgets');

function iot_remove_dashboard_widgets() {

    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');

}

add_action('load-index.php', 'iot_redirect_dashboard');

function iot_redirect_dashboard() {
    wp_redirect(admin_url('admin.php?page=iot-dashboard'));
    exit;
}

add_action('admin_bar_menu', 'iot_remove_logo', 999);

function iot_remove_logo($wp_admin_bar) {
    $wp_admin_bar->remove_node('wp-logo');
}