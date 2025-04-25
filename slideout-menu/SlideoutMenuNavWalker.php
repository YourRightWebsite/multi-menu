<?php

namespace MultiMenu;

class SlideoutMenuNavWalker extends \Walker_Nav_Menu {

    function start_lvl(&$output, $depth=0, $args=null) { 
        // Outputs the starting <ul>
        $output .= "<div><p>Slideout Menu Nav Walker</p></div><div class='submenu-outer-wrapper depth-" . $depth . "'><div class='submenu-middle-wrapper'><div class='submenu-inner-wrapper'><ul class='submenu-list depth-" . $depth . "'>";
    }

    function end_lvl(&$output, $depth=0, $args=null) { 
        // Outputs the ending </ul>
        $output .= '</ul></div></div></div>';
    }

    function start_el(&$output, $item, $depth=0, $args=null, $id=0) { 
        // Outputs the <li> tag with the <a> tag inside

        $output .= "<li class='menu-item menu-item-depth-". $depth . " " . ($args->walker->has_children ? 'has-children' : 'no-children') . " " .  implode(" ", $item->classes) . "'>";
 
		if ($item->url && $item->url != '#') {
			$output .= '<a class="menu-clickable depth-'. $depth . '" href="' . $item->url . '">';
		} else {
			$output .= '<button class="menu-clickable js-menu-clickable-button depth-'. $depth . '" aria-expanded="false">';
		}
 
		$output .= $item->title;
 
		if ($item->url && $item->url != '#') {
			$output .= '</a>';
		} else {
			$output .= '</button>';
		}
    }

    function end_el(&$output, $item, $depth=0, $args=null) { 
        // Outputs the closing </li> tag
        $output .= "</li>";
    }

}
