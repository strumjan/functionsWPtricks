function extra_text() {
	global $post, $product;
    // Regular price min
    $price = get_post_meta($post->ID, '_regular_price');
		if ( !has_term( 'where-not-need-change', 'product_cat' ) ) {
			if( $product->is_type( 'simple' ) ){
        // Change number in condition for your needs
				if ($price[0] >= 10000) {
		 		echo '<div id="free-shipping">';
		 		echo '<img src="url of your picture" alt="free-shipping" width="200" height="103" >';
				echo '</div>';
				}
			} elseif( $product->is_type( 'variable' ) ){
				// Regular price min for variable products
				$min_regular_price = $product->get_variation_sale_price( 'min' );
        // Change number in condition for your needs
				if ($min_regular_price >= 10000) {
 				echo '<div id="free-shipping">';
 				echo '<img src="url of your picture" alt="free-shipping" width="200" height="103" >';
				echo '</div>';
				}
			}
	}	
}
add_action( 'woocommerce_product_meta_start', 'extra_text' );
