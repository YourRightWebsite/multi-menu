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
        </div>

    </fieldset>

    <input type="hidden" id="custom_menu_id" value="<?php echo esc_attr($menu_id); ?>" />

    <div class="save-button-container">
        <button type="button" id="custom-menu-setting-save" class="button button-primary">
            <?php _e('Save Settings'); ?>
        </button>
    </div>

</div>