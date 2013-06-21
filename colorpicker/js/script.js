(function($) {
    var lb_color = $('#colorSelector').attr('data-color');
    $('#colorSelector div').css('backgroundColor', lb_color);
    $('#colorSelector').ColorPicker({
        color: lb_color,
        onShow: function(colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function(colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function(hsb, hex, rgb) {
            $('#colorSelector div').css('backgroundColor', '#' + hex);
            $('#dev_ipa_letterboxing_thumb_color_r').val(rgb.r);
            $('#dev_ipa_letterboxing_thumb_color_g').val(rgb.g);
            $('#dev_ipa_letterboxing_thumb_color_b').val(rgb.b);
        }
    });
})(jQuery)