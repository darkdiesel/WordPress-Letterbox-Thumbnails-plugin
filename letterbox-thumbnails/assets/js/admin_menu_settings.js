(function ($) {
    var ajaxQueue = $({});

    $.ajaxQueue = function(ajaxOpts) {
        var oldComplete = ajaxOpts.complete;

        ajaxQueue.queue(function(next) {
            ajaxOpts.complete = function() {
                if (oldComplete) oldComplete.apply(this, arguments);
                next();
            };

            $.ajax(ajaxOpts);
        });
    };

    function hexToRgb(hex) {
        var arrBuff = new ArrayBuffer(4);
        var vw = new DataView(arrBuff);
        vw.setUint32(0,parseInt(hex, 16),false);
        var arrByte = new Uint8Array(arrBuff);

        return arrByte[1] + "," + arrByte[2] + "," + arrByte[3];
    }

    $(document).ready(function () {
        $('#color').wpColorPicker({
            change: function(event, ui){
                var curColor = ui.color.toRgb();
                $('#rgb-r').val(curColor.r);
                $('#rgb-g').val(curColor.g);
                $('#rgb-b').val(curColor.b);
            },
            clear: function(){
                $('#rgb-r').val('');
                $('#rgb-g').val('');
                $('#rgb-b').val('');
            },
        });

        $('form#letterbox-thumbnails-settings-form').on('submit', function (e) {
            e.preventDefault();

            var form = $(this);

            form.find('.ajax-process').show();

            var params = {
                action: 'letterbox_thumbnails_settings_save',
                wpnonce: letterbox_thumbnails_menu_settings_vars.wpnonce_settings,
                form: form.serializeArray()
            };

            // setup ajax request options
            $.ajaxSetup({
                dataType: "json"
            });

            var ajax_response = $.post(ajaxurl, params);

            ajax_response.success(function (response) {
                if (!$.isEmptyObject(response)) {
                    if ('message' in response) {
                        $('#wpbody-content').find('.wrap-header').append('<div class="notice notice-success lt-notice"><p>' + response.message + '</p></div>');

                        setTimeout(function () {
                            $('.lt-notice').slideUp();
                        }, 5000);
                    }

                    if ('fields' in response) {
                        $.each(response['fields'], function (key, value) {
                            form.find("[name='" + key + "']").val(value);
                        });
                    }
                }
            });

            ajax_response.always(function (responce_data) {
                form.find('.ajax-process').hide();
            })
        });
    });
})(jQuery);