<?php

namespace MultiMenu;

class MegaMenuNavWalker extends \Walker_Nav_Menu {

    private $css_classes;
    private $params;

    // Track the current item index
    private $toplevel_item_index = 0;
    private $toplevel_total_items = 0;

    public function __construct( $css_classes = '', $params = [] ) {
        $this->css_classes = $css_classes;
        $this->params = $params;
    }

    function walk( $elements, $max_depth, ...$args ) {
        // Count only top-level items (depth 0)
        $this->toplevel_total_items = count( array_filter( $elements, function( $element ) {
            return $element->menu_item_parent == 0;
        } ) );
        $this->toplevel_item_index = 0; // Reset index
        return parent::walk( $elements, $max_depth, ...$args );
    }

    function start_lvl(&$output, $depth=0, $args=null) { 

        $output .= "<div class='submenu-outer-wrapper depth-" . $depth . "'><div class='submenu-middle-wrapper'><div class='submenu-inner-wrapper'><ul class='submenu-list depth-" . $depth . "'>";
    }

    function end_lvl(&$output, $depth=0, $args=null) { 
        
        $output .= '</ul></div></div></div>';
    }

    function start_el(&$output, $item, $depth=0, $args=null, $id=0) { 

        // Determine if this is the first or last item
        $is_first = ( $this->toplevel_item_index === 0 );
        $is_last = ( $this->toplevel_item_index === ($this->toplevel_total_items - 1));
        
        if($depth === 0 && $is_first) {

            $this->toplevel_item_index++;

            $menu_text = __("Menu");
            $close_text = __("Close");

            if(isset($this->params) && isset($this->params['menu_toggle_text'])) {
                $menu_text = $this->params['menu_toggle_text'];
            }

            if(isset($this->params) && isset($this->params['menu_close_text'])) {
                $menu_text = $this->params['menu_close_text'];
            }

            $menu_button_open_text = "";
            $menu_button_close_text = "";

            if(boolval($this->params["show_labels"])) {
                $menu_button_open_text = "<span class='button-text'>". $menu_text ."</span>";
                $menu_button_close_text = "<span class='button-text'>". $close_text ."</span>";
            }

            $menu_invert_class = "no-invert";

            if(boolval($this->params['invert_toggle']) === true) {
                $menu_invert_class = "invert";
            }

            $output .= "
                <li class='multi-menu js-multi-menu-mega multi-menu-mega count-items-" . $this->toplevel_total_items . " ". $this->css_classes . " " . $this->params['additional_classes'] ." multi-menu-mega-" . $this->params['id'] . " " . $menu_invert_class . "'>

                    <div class='menu-toggle-container'>
                        <button class='js-multi-menu-mega-toggle-open'>
                            ".$menu_button_open_text."
                            <span class='button-icon'>
                                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                    <path stroke-linecap='round' stroke-linejoin='round' d='M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5' />
                                </svg>
                            </span>
                        </button>
                    </div>

                    <div class='menu-mega-container'>

                        <div class='menu-mega-container-close-container'>
                            <button class='js-multi-menu-mega-toggle-close'>
                                ". $menu_button_close_text ."
                                <span class='button-icon'>
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='size-6'>
                                        <path stroke-linecap='round' stroke-linejoin='round' d='M6 18 18 6M6 6l12 12' />
                                    </svg>
                                </span>
                            </button>
                        </div>

                        <ul class='menu-mega-container-inner'>

            ";
        }

        $output .= "<li class='menu-item menu-item-depth-". $depth . " " . ($args->walker->has_children ? 'has-children' : 'no-children') . " " .  implode(" ", $item->classes) . "'>";
 
		if ($item->url && $item->url != '#') {
			$output .= '<a class="menu-clickable depth-'. $depth . ' ' . ($args->walker->has_children ? 'has-children' : 'no-children') . '" href="' . $item->url . '"><span>';
		} else {
			$output .= '<button class="menu-clickable js-menu-clickable-toggle is-button depth-'. $depth . ' ' . ($args->walker->has_children ? 'has-children' : 'no-children') . '"><span>';
		}

        if($depth === 1) {

            if(isset($item->object_id) && is_numeric($item->object_id)) {
                $featured_image = get_the_post_thumbnail_url($item->object_id, "large");

                if($featured_image !== false && $featured_image != "") {
                    $output .= '
                        <div class="featured-image-wrapper">
                            <img src="'.$featured_image.'" alt="" class="mm-featured-image" />
                        </div>
                    ';
                }
            }
        }
 
		$output .= '<span class="item-title">'.$item->title.'</span>';

        if($args->walker->has_children) {
            // Output the arrow toggle

            $output .= '
                <span class="js-menu-clickable-toggle arrow-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </span>
            ';
        }

        if($depth === 1) {

            $description = !empty( $item->description ) ? esc_html( $item->description ) : '';

            if($description != "") {
                $output .= '<div class="menu-item-description">'. $description .'</div>';
            }
        }
 
		if ($item->url && $item->url != '#') {
			$output .= '</span></a>';
		} else {
			$output .= '</span></button>';
		}
    }

    function end_el(&$output, $item, $depth=0, $args=null) { 
        
        $is_first = ($this->toplevel_item_index === 0);
        $is_last = ($this->toplevel_item_index === $this->toplevel_total_items);

        $output .= "</li>";

        if($depth === 0 && $is_last) {

            $output .= "
            <li class='mega-menu-tray'>
                <div class='mega-menu-tray-outer'>
                    <div class='js-mega-menu-tray-inner mega-menu-tray-inner'>
                        <!-- Menu contents from Javascript goes here -->
                    </div>
                </div> 
            </li>
            ";

            $output .= "</ul></div></li>";
        }

        if($depth === 0) {
            $this->toplevel_item_index++;
        }
    }

}
