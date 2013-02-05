$(document).ready(function(){
    $('input[data-flag=arch_checkbox]').click(function(){
        if ($('input[data-flag=arch_checkbox]:checked').length && $('input[data-flag=arch_checkbox]:not(:checked)').length) {
            $('#zip_all').attr('checked', true).attr('disabled', 'disabled');
            $('#archive_dnld_btn').removeClass('disabled').removeAttr('disabled');
        }
        else if ($('input[data-flag=arch_checkbox]:checked').length) {
            $('#zip_all').attr('checked', true);
            $('#zip_all').removeAttr('disabled');
            $('#archive_dnld_btn').removeClass('disabled').removeAttr('disabled');
        } else {
            $('#zip_all').attr('checked', false);
            $('#zip_all').removeAttr('disabled');
            $('#archive_dnld_btn').addClass('disabled').attr('disabled', 'disabled');
        }
    });

    $('#zip_all').click(function(){
        if ($(this).attr('checked')) {
            $('input[data-flag=arch_checkbox]').attr('checked', true);
            $(this).removeAttr('disabled');
            $('#archive_dnld_btn').removeAttr('disabled').removeClass('disabled');
        } else {
            $('input[data-flag=arch_checkbox]').attr('checked', false);
            $(this).removeAttr('disabled');
            $('#archive_dnld_btn').addClass('disabled').attr('disabled', 'disabled');
        }
    })
});