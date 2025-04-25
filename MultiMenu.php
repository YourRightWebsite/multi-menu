<?php

namespace MultiMenu;

/*
Plugin Name: Multi Menu
Description: This is a plugin that allows for many different types of navigation menus.
Version: 1.0.0
Author: Your Right Website
Author URI: https://www.yourrightwebsite.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class MultiMenu {
    
    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'loadScriptsAndStyles']);
        add_action('admin_init', [$this, 'renderMenuCustomMetaBox']);
        add_action('wp_ajax_save_custom_menu_setting', [$this, 'saveCustomMenuSettings']);
    }

    /*
        A function to check whether the current user has the "edit_theme_options" permission.
        If they don't, they don't have the proper permissions to change the menu settings.
    */

    public function checkPermissions() {
        if (current_user_can('edit_theme_options'))  {
            return true;
        }

        return false;
    }

    /*
        A function for loading any CSS or Javascript needed by our plugin.
    */

    public function loadScriptsAndStyles() {

        // Check if we are inside of the WordPress Dashboard

        if(is_admin()) {

            // Get the current screen and see if we're on the nav-menus.php page
            $screen = get_current_screen();

            // Check if we are on the menu editor in the Dashboard

            if ($screen && 'nav-menus' === $screen->id) {

                // Enqueue our global level admin CSS
                wp_enqueue_style('multi-menu-admin-metabox', plugin_dir_url(__FILE__) . 'assets/css/admin/admin-menu-metabox.css', [], null);

                // Enqueue our Javascript for saving the custom menu settings
                wp_enqueue_script(
                    'admin-menu-settings-save',
                    plugin_dir_url(__FILE__) . 'assets/js/admin/admin-menu-settings-save.js',
                    array('jquery'),
                    '1.0',
                    true
                );

                // Localize script to pass AJAX URL and nonce.
                wp_localize_script(
                    'admin-menu-settings-save', // Must match the script handle above.
                    'customMenuSettings',
                    array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'nonce'    => wp_create_nonce('custom_menu_setting_ajax_nonce'),
                    )
                );

            }

        }
    }

    /*
        Displays the Menu Type Selection interface inside of the WordPress Dashboard
    */

    public function displayMenuTypeSelection() {
        $this->checkPermissions();

        $menus = wp_get_nav_menus(); // Used by our view file

        require_once(plugin_dir_path(__FILE__) . "/views/admin-menu-style-selection.php");
    }

    public function renderMenuCustomMetaBox() {
        add_meta_box(
            'multi-menu-settings',                      // ID of the meta box
            'Multi Menu Settings',                      // Title of the meta box
            [$this, 'loadMenuCustomMetaBoxHTML'],       // Callback function to render the meta box
            'nav-menus',                                // Screen ID (for Appearance > Menus)
            'side',                                     // Context (side, normal, or advanced)
            'high'                                      // Priority
        );
    }

    public function loadMenuCustomMetaBoxHTML() {

        $menu_id = 0;

        // Get the correct menu to edit

        if ( isset($_GET['menu']) && $_GET['menu'] && is_numeric($_GET['menu'])) {
            $menu_id = intval($_GET['menu']);   // Get the menu id via a URL parameter
        } 
        elseif(is_numeric(get_user_option('nav_menu_recently_edited'))) {
            $menu_id = get_user_option('nav_menu_recently_edited');     // Get the menu id via the last menu viewed in WordPress
        }
        else {
            // Default to getting the first menu ID from the database
            // We should never get here unless maybe the user is creating their first menu
            $menus = wp_get_nav_menus(array('orderby' => 'id', 'order' => 'DESC'));
            $menu_id = !empty($menus) ? $menus[0]->term_id : 0;
        }

        // Retrieve existing custom settings (if any)
        $multi_menu_style   = get_term_meta($menu_id, 'multimenu_menu_style', true);
        $multi_menu_css     = get_term_meta($menu_id, 'multimenu_menu_css', true);

        require_once(plugin_dir_path(__FILE__) . "/views/admin-menu-custom-settings-metabox.php");
    }

    function saveCustomMenuSettings() {

        if (!isset($_POST['nonce']) || !check_ajax_referer('custom_menu_setting_ajax_nonce', 'nonce', false)) {
            wp_send_json_error('Invalid or missing nonce.', 403);
        }
    
        // Check user capabilities.
        if ( !$this->checkPermissions() ) {
            wp_send_json_error('Insufficient permissions.');
        }
    
        // Get the menu ID
        $menu_id = isset($_POST['menu_id']) ? intval($_POST['menu_id']) : 0;
    
        if (!$menu_id ) {
            wp_send_json_error('Invalid menu ID.');
        }

        // Handle fetch request.
        if ( isset($_POST['fetch_only']) && $_POST['fetch_only'] ) {
            $fetch_multimenu_menu_style = get_term_meta($menu_id, 'multimenu_menu_style', true);
            $fetch_multimenu_menu_css = get_term_meta($menu_id, 'multimenu_menu_css', true);
            wp_send_json_success(array('styleSetting' => $fetch_multimenu_menu_style, 'cssSetting' => $fetch_multimenu_menu_css));
        }

        // Get the term meta data
        $multi_menu_style   = isset($_POST['menu_style']) ? sanitize_text_field($_POST['menu_style']) : '';
        $multi_menu_css     = isset($_POST['menu_css']) ? sanitize_text_field($_POST['menu_css']) : '';
    
        // Save the term meta.
        $status_style   = update_term_meta($menu_id, 'multimenu_menu_style', $multi_menu_style);
        $status_css     = update_term_meta($menu_id, 'multimenu_menu_css', $multi_menu_css);
    
        wp_send_json_success('Setting saved successfully.');
    }

}

// Initialize the plugin
$multi_menu = new MultiMenu();


