jQuery(document).ready(function( $ ) {

    $('#agiledrop-form').on('submit', function(e) {

        e.preventDefault();
        var form = $(this);
        var formData = form.serializeArray();

        var ajaxUrl = form.data( 'url'),
            action  = form.attr( 'action' ),
            nonce   = form.find( '#agiledrop_form_nonce').val();

        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                fields: formData,
                action: action,
                nonce: nonce
            },
            error: function () {
                $('#form-status').text( 'Something went wrong please try later.');
            },
            success: function( response ) {
                var output = JSON.parse(response);
                if ( response != 0 ) {
                    $('#form-status').text( output.message );
                }
                else {
                    $('#form-status').text( 'Your message was successfully send.');
                    $('#agiledrop-form')[0].reset();
                }
            }
        })

    })

});