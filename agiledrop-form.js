jQuery(document).ready(function( $ ) {
    $('#agiledrop-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var name     = form.find('#name').val(),
            email    = form.find( '#email' ).val(),
            location = form.find( '#location').val(),
            status   = $('input[name=status]:checked', form).val(),
            job      =  form.find( '#zaposlitev').prop("checked"),
            dataProcessing = form.find( '#obdelava-podatkov').prop("checked"),
            ajaxUrl  = form.data( 'url');


        if ( name === '') {
            $('#name-error').css("display", "grid");
            $('#name-error').text( 'Name field required' );
            return;
        }
        if ( email === '') {
            $('#email-error').css("display", "grid");
            $('#email-error').text( 'Email field required' );
            return;
        }
        if ( location === '') {
            $('#location-error').css("display", "grid");
            $('#location-error').text( 'Location is required' );
            return;
        }


        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                name: name,
                email: email,
                location: location,
                status: status,
                job: job,
                dataProcessing: dataProcessing,
                action: 'agiledrop_save_form'
            },
            error: function ( response ) {
                $('#form-status').text( 'Something went wrong please try later.');
            },
            success: function( response ) {
                if ( response === false) {
                    $('#form-status').text( 'Something went wrong please try later.');
                }
                else {
                    $('#form-status').text( 'Your message was successfully send.');
                    $('#agiledrop-form')[0].reset();
                }
            }
        })

    })

});