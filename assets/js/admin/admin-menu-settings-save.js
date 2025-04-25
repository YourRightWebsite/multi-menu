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
        var nonce = customMenuSettings.nonce;
        var button = $('#custom-menu-setting-save');

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

    // Update hidden menu ID field when a new menu is selected.
    $('#menu-to-edit').on('change', function() {
        var newMenuId = $(this).val();
        $('#custom_menu_id').val(newMenuId);

        // Optionally, fetch and update the custom setting for the new menu.
        if (newMenuId) {
            $.ajax({
                url: customMenuSettings.ajax_url,
                type: 'POST',
                data: {
                    action: 'save_custom_menu_setting', // Reuse the same action for fetching.
                    nonce: customMenuSettings.nonce,
                    menu_id: newMenuId,
                    fetch_only: true // Flag to fetch instead of save.
                },
                success: function(response) {
                    if (response.success && response.data.styleSetting && response.data.cssSetting) {
                        $('#menu_style').val(response.data.styleSetting);
                        $('#menu_css').val(response.data.cssSetting);
                    } else {
                        $('#menu_style').val('');
                        $('#menu_css').val('');
                    }
                }
            });
        }
    });
});