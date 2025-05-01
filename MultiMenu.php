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
        add_filter('wp_nav_menu_args', [$this, 'assignMenuNavWalkers'], 1);
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
        $multi_menu_style                           = get_term_meta($menu_id, 'multimenu_menu_style', true);
        $multi_menu_css                             = get_term_meta($menu_id, 'multimenu_menu_css', true);
        $multi_menu_invert_toggle_color             = get_term_meta($menu_id, 'multimenu_invert_toggle_color', true);
        $multi_menu_show_labels                     = get_term_meta($menu_id, 'multimenu_show_labels', true);
        $multi_menu_preserve_classes                = get_term_meta($menu_id, 'multimenu_preserve_classes', true);
        $multi_menu_load_theme_specific_css         = get_term_meta($menu_id, 'multimenu_load_theme_specific_css', true);
        $multi_menu_additional_classes              = get_term_meta($menu_id, 'multimenu_additional_classes', true);

        require_once(plugin_dir_path(__FILE__) . "/views/admin-menu-custom-settings-metabox.php");
    }

    public function saveCustomMenuSettings() {

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

        // Get the term meta data
        $multi_menu_style                   = isset($_POST['menu_style']) ? sanitize_text_field($_POST['menu_style']) : '';
        $multi_menu_css                     = isset($_POST['menu_css']) ? sanitize_text_field($_POST['menu_css']) : '';
        $multi_menu_toggle_color            = isset($_POST['menu_invert_toggle_color']) ? sanitize_text_field($_POST['menu_invert_toggle_color']) : '';
        $multi_menu_show_labels             = isset($_POST['menu_show_labels']) ? sanitize_text_field($_POST['menu_show_labels']) : '';
        $multi_menu_preserve_classes        = isset($_POST['menu_preserve_classes']) ? sanitize_text_field($_POST['menu_preserve_classes']) : '';
        $multi_menu_load_theme_specific_css = isset($_POST['menu_load_theme_specific_css']) ? sanitize_text_field($_POST['menu_load_theme_specific_css']) : '';
        $multi_menu_additional_classes      = isset($_POST['menu_additional_classes']) ? sanitize_text_field($_POST['menu_additional_classes']) : '';

        // Save the term meta.
        update_term_meta($menu_id, 'multimenu_menu_style', $multi_menu_style);
        update_term_meta($menu_id, 'multimenu_menu_css', $multi_menu_css);
        update_term_meta($menu_id, 'multimenu_invert_toggle_color', $multi_menu_toggle_color );
        update_term_meta($menu_id, 'multimenu_show_labels', $multi_menu_show_labels);
        update_term_meta($menu_id, 'multimenu_preserve_classes', $multi_menu_preserve_classes);
        update_term_meta($menu_id, 'multimenu_load_theme_specific_css', $multi_menu_load_theme_specific_css);
        update_term_meta($menu_id, 'multimenu_additional_classes', $multi_menu_additional_classes);
    
        wp_send_json_success('Setting saved successfully.');
    }

    public function assignMenuNavWalkers($args) {

        if(isset($args['theme_location']) && $args['theme_location'] != "") {

            $current_menu_theme_location = $args['theme_location'];
        
            $menu_locations = get_nav_menu_locations();     // Information about where each menu is located in the template

            if(isset($menu_locations[$current_menu_theme_location]) && is_numeric($menu_locations[$current_menu_theme_location])) {
                $menu_id = $menu_locations[$current_menu_theme_location];

                $multimenu_menu_style                       = get_term_meta($menu_id, 'multimenu_menu_style', true);
                $multimenu_menu_css                         = get_term_meta($menu_id, 'multimenu_menu_css', true);
                $multi_menu_invert_toggle_color             = get_term_meta($menu_id, 'multimenu_invert_toggle_color', true);
                $multi_menu_show_labels                     = get_term_meta($menu_id, 'multimenu_show_labels', true);
                $multi_menu_preserve_classes                = get_term_meta($menu_id, 'multimenu_preserve_classes', true);
                $multi_menu_load_theme_specific_css         = get_term_meta($menu_id, 'multimenu_load_theme_specific_css', true);
                $multi_menu_additional_classes              = get_term_meta($menu_id, 'multimenu_additional_classes', true);

                if($multimenu_menu_style != false && $multimenu_menu_style != "") {

                    $menu_params = [];  // Any optional parameters we want to pass to our nav walker
                    $menu_params["invert_toggle"] = boolval($multi_menu_invert_toggle_color);
                    $menu_params["show_labels"] = boolval($multi_menu_show_labels);
                    $menu_params['additional_classes'] = $multi_menu_additional_classes;
                    $menu_params["id"] = $menu_id;

                    if($menu_params['additional_classes'] == "") {
                        $menu_params['additional_classes'] = "no-additional-classes";
                    }

                    if($multi_menu_preserve_classes != true) {
                        $args["menu_class"]     = "";
                        $args["menu_id"]        = "multi-menu-wrapper-" . $menu_id;
                    }

                    $current_theme = wp_get_theme();
                    $current_theme_name = "";

                    if(isset($current_theme->template) && $current_theme->template != "") {
                        $current_theme_name = $current_theme->template;
                    }
                    

                    if($multimenu_menu_style == "fullscreen") {

                        require_once(plugin_dir_path(__FILE__) . "/fullscreen-menu/FullscreenMenuNavWalker.php");

                        $args['walker'] = new FullscreenMenuNavWalker();

                        // Load the appropriate CSS for this menu

                        if($multimenu_menu_css != "") {

                            // If there's a value, we're always loading the core styles
                            wp_enqueue_style('multi-menu-fullscreen-core', plugin_dir_url(__FILE__) . 'fullscreen-menu/css/fullscreen-core.css', [], null);

                            if($multimenu_menu_css == "light") {
                                wp_enqueue_style('multi-menu-fullscreen-light', plugin_dir_url(__FILE__) . 'fullscreen-menu/css/fullscreen-light.css', [], null);
                            }
                            elseif($multimenu_menu_css == "dark") {
                                wp_enqueue_style('multi-menu-fullscreen-dark', plugin_dir_url(__FILE__) . 'fullscreen-menu/css/fullscreen-dark.css', [], null);
                            }

                        }

                        // Load the appropriate JS for this menu

                        wp_enqueue_script(
                            'multi-menu-fullscreen-js',
                            plugin_dir_url(__FILE__) . 'fullscreen-menu/js/fullscreen-menu.js',
                            array('jquery'),
                            '1.0',
                            true
                        );

                    }
                    elseif($multimenu_menu_style == "mega") {

                        require_once(plugin_dir_path(__FILE__) . "/mega-menu/MegaMenuNavWalker.php");

                        $args['walker'] = new MegaMenuNavWalker();

                        // Load the appropriate CSS for this menu

                        if($multimenu_menu_css != "") {

                            // If there's a value, we're always loading the core styles
                            wp_enqueue_style('multi-menu-mega-core', plugin_dir_url(__FILE__) . 'mega/css/mega-core.css', [], null);

                            if($multimenu_menu_css == "light") {
                                wp_enqueue_style('multi-menu-mega-light', plugin_dir_url(__FILE__) . 'mega-menu/css/mega-light.css', [], null);
                            }
                            elseif($multimenu_menu_css == "dark") {
                                wp_enqueue_style('multi-menu-mega-dark', plugin_dir_url(__FILE__) . 'mega-menu/css/mega-dark.css', [], null);
                            }

                        }

                        // Load the appropriate JS for this menu

                        wp_enqueue_script(
                            'multi-menu-mega-js',
                            plugin_dir_url(__FILE__) . 'mega-menu/js/mega-menu.js',
                            array('jquery'),
                            '1.0',
                            true
                        );

                    }
                    elseif($multimenu_menu_style == "slideout") {

                        require_once(plugin_dir_path(__FILE__) . "/slideout-menu/SlideoutMenuNavWalker.php");

                        $args['walker'] = new SlideoutMenuNavWalker($multimenu_menu_css, $menu_params);

                        // Load the appropriate CSS for this menu

                        if($multimenu_menu_css != "") {

                            // If there's a value, we're always loading the core styles
                            wp_enqueue_style('multi-menu-slideout-core', plugin_dir_url(__FILE__) . 'slideout-menu/css/slideout-core.css', [], null);

                            if($multimenu_menu_css == "light") {
                                wp_enqueue_style('multi-menu-slideout-light', plugin_dir_url(__FILE__) . 'slideout-menu/css/slideout-light.css', [], null);
                            }
                            elseif($multimenu_menu_css == "dark") {
                                wp_enqueue_style('multi-menu-slideout-dark', plugin_dir_url(__FILE__) . 'slideout-menu/css/slideout-dark.css', [], null);
                            }

                        }

                        if(boolval($multi_menu_load_theme_specific_css) === true && preg_match('/^[a-zA-Z0-9_-]+$/', $current_theme_name)) {

                            // Check if we have any theme specific CSS to load
                            
                            /*
                                Common popular theme names include:
                                astra
                                blocksy
                                generatepress
                                kadence
                                neve
                            */

                            $filepath = 'slideout-menu/css/theme-overrides/'. basename($current_theme_name) . '.css';

                            if(file_exists(plugin_dir_path(__FILE__) . $filepath)) {
                                wp_enqueue_style('multi-menu-overrides-' . $current_theme_name, plugin_dir_url(__FILE__) . $filepath, [], null);
                            }

                        }

                        // Load the appropriate JS for this menu

                        wp_enqueue_script(
                            'multi-menu-slideout-js',
                            plugin_dir_url(__FILE__) . 'slideout-menu/js/slideout-menu.js',
                            array('jquery'),
                            '1.0',
                            true
                        );

                    }
                }
            }
        }

        return $args;

    }

}

// Initialize the plugin
$multi_menu = new MultiMenu();


