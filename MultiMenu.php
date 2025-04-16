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

    // An array of all of the page slugs we will use for our admin interfaces
    // We'll use this for selectively loading CSS as well as disabling admin notices on those pages
    public $admin_pages = ["menu-style"];
    
    public function __construct() {
        add_action('admin_menu', [$this, 'addMenuTypeAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'loadScriptsAndStyles']);
        add_action('in_admin_header', [$this, 'hideAdminNotices'], 20);
    }

    /*
        A function to check whether the current user has the "manage_options" permission.
        If they don't, we just stop execution of the script and show an error message.
        This is used to ensure that only admins can make changes to the settings in the dashboard.
    */

    public function checkPermissions() {
        if ( !current_user_can( 'manage_options') )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
    }

    /*
        A function for loading any CSS or Javascript needed by our plugin.
    */

    public function loadScriptsAndStyles() {

        // Check if we are inside of the WordPress Dashboard

        if(is_admin()) {

            // Get the current page slug and see if it matches one of our admin pages
            // We don't want to be loading our CSS for every page of the Dashboard, just our pages

            if (isset($_GET['page']) && in_array($_GET['page'], $this->admin_pages)) {

                // Enqueue our global level admin CSS
                wp_enqueue_style('multi-menu-admin-global', plugin_dir_url(__FILE__) . 'assets/css/admin/admin-global.css', [], null);

                // Enqueue admin CSS for a specific admin page in the dashboard
                if($_GET['page'] == "menu-style") {
                    wp_enqueue_style('multi-menu-admin-selection', plugin_dir_url(__FILE__) . 'assets/css/admin/admin-menu-style-selection.css', [], null);
                }
            }

        }
    }

    /*
        Hide WordPress admin notices that will interfere with the look of our custom plugin.
    */

    public function hideAdminNotices() {

        // Get the current screen, which is similar to but slightly different from the current page slug
        $current_screen = get_current_screen();

        /*
            Check if the ID of the current screen matches our custom page slug.
            WordPress will append the name of the parent screen, such as "appearance_page" so we need to strip it out
            in order to test for a matching page.
        */

        if ( in_array($current_screen->id, $this->admin_pages) || in_array(str_replace("appearance_page_", "", $current_screen->id), $this->admin_pages)) {
            
            // Hide the admin notices for pages within our plugin's admin interface
            
            remove_all_actions( 'admin_notices' );
            remove_all_actions( 'all_admin_notices' );
        }

    }

    /*
        A function for adding the "Menu Style" menu option in the Dashboard under the Appearance section.
    */

    public function addMenuTypeAdminMenu() {

        add_submenu_page("themes.php", 'Menu Style', 'Menu Style', 'manage_options', 'menu-style', function() {
            $this->displayMenuTypeSelection();  // Load the HTML for the Menu Style page from another function
        });

    }

    /*
        Displays the Menu Type Selection interface inside of the WordPress Dashboard
    */

    public function displayMenuTypeSelection() {
        $this->checkPermissions();

        echo "<h1>This loaded!</h1>";
    }

}

// Initialize the plugin
$multi_menu = new MultiMenu();


