function my_woo_outofstock_text( $text ) {
	$text = __( 'SOLD – Expected', 'ocean' );
// For specific term different text
	if ( has_term( 'radionice', 'product_cat' )) {
		$text = __( 'Soldout', 'ocean' );
	}
	return $text;
}
add_filter( 'ocean_woo_outofstock_text', 'my_woo_outofstock_text', 20 );
