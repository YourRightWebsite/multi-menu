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

                        <div class="menu form-group">
                            <label for="menu-<php echo $menu->term_id; ?>">
                                <?php echo $menu->name; ?> Menu Style:
                            </label>
                            <select id="menu-<php echo $menu->term_id; ?>" name="menu_<php echo $menu->term_id; ?>">
                                <option value="">-- Select Menu Style --</option>
                                <option value="fullscreen">Fullscreen Menu</option>
                                <option value="mega">Mega Menu</option>
                                <option value="slideout">Slideout Menu</option>
                            </select>
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