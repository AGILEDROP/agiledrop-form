jQuery(document).ready(function( $ ) {
    $("#agiledrop_field_type").change(function(){
       var type = $(this).val();
       if ( type === 'checkbox') {
           $(".placeholder").hide();
       }
       else {
           $(".placeholder").show();
       }
    });
});