if(typeof gform != "undefined"){
    gform.addFilter('gform_spinner_target_elem', function( $targetElem, formId ) {
        return $('.gform_wrapper .form_submit');
    } );
}

$(document).on('submit', '.gform_wrapper form', function () {
	console.log('submit');
    $(this).parent('.gform_wrapper').addClass('form--loading');
});

$(document).bind('gform_confirmation_loaded', function(event, form_id){
	console.log('loaded');
	$('[id="gform_'+form_id+'"]').removeClass('form--loading');
})

$(document).on('gform_post_render', function(event, form_id, current_page){
	console.log('render');
	$('[id="gform_'+form_id+'"]').parent('.gform_wrapper').removeClass('form--loading');
});
