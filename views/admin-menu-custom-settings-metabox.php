<div class="multi-menu-metabox multi-menu-custom-admin-settings-metabox">

    <div class="js-multi-alert js-multi-alert-success menu-save-alert" style="display: none;"><?php _e('Settings Saved Successfully!'); ?></div>

    <fieldset>
        <legend><?php _e('Multi Menu Activation'); ?></legend>

        <div class="fields">
            <div class="form-group menu-style">
                <label for="menu_style">
                    <?php _e('Multi Menu Style'); ?>:
                </label>
                <select id="menu_style" name="menu_style" class="js-multi-menu-select">
                    <option value=""<?php if(!isset($multi_menu_style) || $multi_menu_style == ""){ echo ' selected="selected"'; } ?>><?php _e('Disabled'); ?></option>
                    <option value="fullscreen"<?php if(isset($multi_menu_style) && $multi_menu_style == "fullscreen"){ echo ' selected="selected"'; } ?>><?php _e('Fullscreen Menu'); ?></option>
                    <option value="mega"<?php if(isset($multi_menu_style) && $multi_menu_style == "mega"){ echo ' selected="selected"'; } ?>><?php _e('Mega Menu'); ?></option>
                    <option value="slideout"<?php if(isset($multi_menu_style) && $multi_menu_style == "slideout"){ echo ' selected="selected"'; } ?>><?php _e('Slideout Menu'); ?></option>
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend><?php _e('Multi Menu Settings'); ?></legend>
        <p class="description"><?php _e('The settings below only take effect if a Multi Menu style is selected from the dropdown above.'); ?></p>

        <div class="fields">
            <div class="form-group menu-scheme">
                <label for="menu_css">
                    <?php _e('Menu CSS Styles To Load'); ?>:
                </label>
                <select id="menu_css" name="menu_css" class="js-multi-menu-select">
                    <option value=""<?php if(!isset($multi_menu_css ) || $multi_menu_css == ""){ echo ' selected="selected"'; } ?>><?php _e('None'); ?></option>
                    <option value="core"<?php if(isset($multi_menu_css) && $multi_menu_css == "core"){ echo ' selected="selected"'; } ?>><?php _e('Core Only'); ?></option>
                    <option value="light"<?php if(isset($multi_menu_css) && $multi_menu_css == "light"){ echo ' selected="selected"'; } ?>><?php _e('Core + Light'); ?></option>
                    <option value="dark"<?php if(isset($multi_menu_css) && $multi_menu_css == "dark"){ echo ' selected="selected"'; } ?>><?php _e('Core + Dark'); ?></option>
                </select>
            </div>

            <div class="form-group menu-scheme checkbox-container">
                <input type="checkbox" value="1" name="menu_invert_toggle_color" id="menu_invert_toggle_color"<?php echo (isset($multi_menu_invert_toggle_color) && boolval($multi_menu_invert_toggle_color) === true ? ' checked="checked"' : ''); ?>/>
                <label for="menu_invert_toggle_color"><?php _e('Invert Menu Toggle Color'); ?></label>
            </div>

            <div class="form-group menu-scheme checkbox-container">
                <input type="checkbox" value="1" name="menu_show_labels" id="menu_show_labels"<?php echo (isset($multi_menu_show_labels) && boolval($multi_menu_show_labels) === true ? ' checked="checked"' : ''); ?>/>
                <label for="menu_show_labels"><?php _e('Show Menu and Close Labels'); ?></label>
            </div>

            <div class="form-group menu-scheme checkbox-container">
                <input type="checkbox" value="1" name="menu_preserve_classes" id="menu_preserve_classes"<?php echo (isset($multi_menu_preserve_classes) && boolval($multi_menu_preserve_classes) === true ? ' checked="checked"' : ''); ?>/>
                <label for="menu_preserve_classes"><?php _e('Preserve Menu ID and Class'); ?></label>
            </div>

            <div class="form-group menu-scheme checkbox-container">
                <input type="checkbox" value="1" name="menu_load_theme_specific_css" id="menu_load_theme_specific_css"<?php echo (isset($multi_menu_load_theme_specific_css) && boolval($multi_menu_load_theme_specific_css) === true ? ' checked="checked"' : ''); ?>/>
                <label for="menu_load_theme_specific_css"><?php _e('Load Theme Specific CSS'); ?></label>
            </div>
            <p class="description">
                <?php _e('The above setting will load specific CSS overrides for popular themes designed to make the menu work properly with those themes.'); ?>
            </p>

            <div class="form-group menu-scheme input-container">
                <label for="menu_additional_classes">Additional CSS classes for menu:</label>
                <input type="text" name="menu_additional_classes" id="menu_additional_classes" value="<?php echo (isset($multi_menu_additional_classes) && $multi_menu_additional_classes != "" ? esc_html($multi_menu_additional_classes) : ''); ?>" />
            </div>
        </div>

    </fieldset>

    <input type="hidden" id="custom_menu_id" value="<?php echo esc_attr($menu_id); ?>" />

    <div class="save-button-container">
        <button type="button" id="custom-menu-setting-save" class="button button-primary">
            <?php _e('Save Settings'); ?>
        </button>
    </div>

    <div class="plugin-advertisement">
        <h5 class="header">Need some help using this plugin?</h5>
        <p>
            The <a href="https://yourrightwebsite.com/multi-menu-documentation/?source=multi-menu" target="_blank">plugin documentation</a> contains helpful information on how to use and customize the Multi Menu plugin.
        </p>
        <p>
            <a href="https://yourrightwebsite.com/?source=multimenu" target="_blank">Your Right Website</a> also offers <a href="https://yourrightwebsite.com/website-consulting/?source=multi-menu" target="_blank">website consulting services</a>, <a href="https://yourrightwebsite.com/custom-wordpress-plugin-development/?source=multi-menu" target="_blank">custom WordPress plugin development</a> and <a href="https://yourrightwebsite.com/website-design-and-development/?source=multi-menu" target="_blank">custom WordPress web design</a> to help you get the website that's right for you!
        </p>
    </div>

</div>