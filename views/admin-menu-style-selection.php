<div class="multi-menu-admin menu-style-selection">

    <div class="header-intro">
        <h1 class="header">Select Menu Styles</h1>
        <p>
            Use this interface to select a menu style for each of the menus on your site.
        </p>
    </div>

    <div class="menus-listing">

        <form action="" method="POST">

            <div class="form-submit-container">

                <div class="menus-listing-each">

                    <?php

                        if(is_array($menus) && count($menus) > 0) {
                            foreach($menus as $menu) {
                                
                    ?>

                        <div class="menu">
                            <div class="form-group menu-style">
                                <label for="menu-style-<?php echo $menu->term_id; ?>">
                                    Multi Menu Style:
                                </label>
                                <select id="menu-style-<?php echo $menu->term_id; ?>" name="menu_style_<?php echo $menu->term_id; ?>">
                                    <option value="">Disabled</option>
                                    <option value="fullscreen">Fullscreen Menu</option>
                                    <option value="mega">Mega Menu</option>
                                    <option value="slideout">Slideout Menu</option>
                                </select>
                            </div>
                            <div class="form-group menu-scheme">
                                <label for="menu-css-<?php echo $menu->term_id; ?>">
                                    Menu CSS styles to load:
                                </label>
                                <select id="menu-css-<?php echo $menu->term_id; ?>" name="menu_css_<?php echo $menu->term_id; ?>">
                                    <option value="">Default / None</option>
                                    <option value="core">Core Only</option>
                                    <option value="light">Core + Light</option>
                                    <option value="dark">Core + Dark</option>
                                </select>
                            </div>

                            <div class="form-group menu-scheme">
                                <label for="menu-socials-<?php echo $menu->term_id; ?>">
                                    Show menu social media links:
                                </label>
                                <select id="menu-socials-<?php echo $menu->term_id; ?>" name="menu_socials_<?php echo $menu->term_id; ?>">
                                    <option value="">Default / None</option>
                                    <option value="social-only">Show Social Links Only</option>
                                    <option value="additional-content-only">Show Additional Content Only</option>
                                    <option value="socials-plus-content">Show Social Links And Additional Content</option>
                                </select>
                            </div>
                        </div>

                    <?php

                            }
                        }

                    ?>

                </div>

                <button type="submit">Submit Changes</button>

            </div>

        </form>

    </div>

</div>