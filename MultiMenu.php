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
        add_action('admin_menu', [$this, 'addMenuTypeAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'loadScriptsAndStyles']);
    }

    public static function checkPermissions() {
        if ( !current_user_can( 'manage_options') )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
    }

    public static function loadScriptsAndStyles() {
        if(is_admin()) {

            $allowed_pages = [];
            $allowed_pages[] = "menu-style";

            if (isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) {
                wp_enqueue_style('multi-menu-admin-global', plugin_dir_url(__FILE__) . 'assets/css/admin/admin-global.css', [], null);

                if($_GET['page'] == "menu-style") {
                    wp_enqueue_style('multi-menu-admin-selection', plugin_dir_url(__FILE__) . 'assets/css/admin/admin-menu-style-selection.css', [], null);
                }
            }

        }
    }

    public function addMenuTypeAdminMenu() {

        add_submenu_page("themes.php", 'Menu Style', 'Menu Style', 'manage_options', 'menu-style', function() {
            $this->displayMenuTypeSelection();
        });

    }

    public function displayMenuTypeSelection() {
        self::checkPermissions();

        echo "<h1>This loaded!</h1>";
    }

}

// Initialize the plugin
$multi_menu = new MultiMenu();


