<?php
// File Security Check
if (!empty($_SERVER['SCRIPT_FILENAME']) && basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    die ('You do not have sufficient permissions to access this page');
}

add_filter( 'gform_ajax_spinner_url', 'gform_custom_spinner_url', 10, 2 );
function gform_custom_spinner_url( $image_src, $form ) {
    return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // relative to you theme images folder
}

add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );
function form_submit_button( $button, $form ) {
	if(is_admin()) return $button;

	return '<div class="form_submit"><button class="button gform_button btn-rounded btn--arrow" id="gform_submit_button_'.$form['id'].'"><span>'. $form['button']['text'] .'</span></button></div>';
}

// Change textarea rows to 2 instead of 10
add_filter( 'gform_field_content', function ( $field_content, $field ) {
    if ( $field->type == 'textarea' ) {
        return str_replace( "rows='10'", "rows='5'", $field_content );
    }
    return $field_content;
}, 10, 2 );
