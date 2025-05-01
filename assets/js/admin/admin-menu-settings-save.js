jQuery(document).ready(function($) {
    // Save button click handler.
    $('#custom-menu-setting-save').on('click', function() {
        saveCustomSetting();
    });

    $('.js-multi-menu-select').on('change', function() {
        $('.js-multi-alert').hide();
    });

    function saveCustomSetting() {
        var menuId = $('#custom_menu_id').val();
        var styleSetting = $('#menu_style').val();
        var cssSetting = $('#menu_css').val();
        var additionalClasses = $('#menu_additional_classes').val();
        var nonce = customMenuSettings.nonce;
        var button = $('#custom-menu-setting-save');

        // Checkbox Values
        var invertToggle = 0;

        if($('#menu_invert_toggle_color').is(':checked')) {
            invertToggle = 1;
        }

        var showLabels = 0;

        if($('#menu_show_labels').is(':checked')) {
            showLabels = 1;
        }

        var preserveClasses = 0;

        if($('#menu_preserve_classes').is(':checked')) {
            preserveClasses = 1;
        }

        var themeOverrideCSS = 0;

        if($('#menu_load_theme_specific_css').is(':checked')) {
            themeOverrideCSS = 1;
        }

        button.html('Loading...').attr('disabled', 'disabled');

        $('js-multi-alert').hide();

        $.ajax({
            url: customMenuSettings.ajax_url,
            type: 'POST',
            data: {
                action: 'save_custom_menu_setting',
                nonce: nonce,
                menu_id: menuId,
                menu_style: styleSetting,
                menu_css: cssSetting,
                menu_invert_toggle_color: invertToggle,
                menu_show_labels: showLabels,
                menu_preserve_classes: preserveClasses,
                menu_load_theme_specific_css: themeOverrideCSS,
                menu_additional_classes: additionalClasses,
            },
            success: function(response) {
                if (response.success) {
                    $('.js-multi-alert-success').show();
                } else {
                    alert('Error: ' + response.data);
                }

                button.removeAttr('disabled').html('Save Settings');
            },
            error: function() {
                alert('AJAX request failed.');

                button.removeAttr('disabled').html('Save Settings');
            }
        });
    }
});