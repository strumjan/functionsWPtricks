add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );
add_filter( 'woocommerce_checkout_fields' , 'njengah_order_notes' );
function njengah_order_notes( $fields ) {
unset($fields['order']['order_comments']);
return $fields;
}
