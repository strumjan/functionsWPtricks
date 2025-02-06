add_filter( 'woocommerce_get_price_html', 'cw_change_product_price_display', 10, 2 );
add_action( 'woocommerce_after_single_product_summary', 'cw_change_product_price_display' );
add_action( 'woocommerce_before_add_to_cart_button', 'cw_change_product_price_display' );
add_filter( 'woocommerce_cart_item_price', 'cw_change_product_price_display' );
function cw_change_product_price_display( $price ) {
	global $product;
	$price_regular_field = get_post_meta($product->get_id(), '_regular_price', true);
	$price_discounted_field = round($price_regular_field-(($price_regular_field*3)/100)); //multiply by your discount percentage
	
	$product_id = $product->get_id();
	$parent_id = $product->get_parent_id();

	if (has_term('your-term', 'product_tag', $parent_id ? $parent_id : $product_id)) {
		$text3 = '<div class="woocommerce-product-package-price"><p class="discounted-price">Package price: <strong>'.$price_regular_field.' your-currency-sign </strong></p></div>';
        return $text3; // returning the text before the price
	}
    else if ( is_archive() || is_product() || has_term('related', 'product_cat', $product->id) ) {
        $text = __('<span class="price">Our price: </span>'); // Your additional text
		$text2 = '<div class="woocommerce-product-discounted-price"><p class="discounted-price">With discount: <strong>'.$price_discounted_field.' your-currency-sign </strong></p></div>';
        return $text . ' ' . $price . $text2; // returning the text before the price
    }
    return $price;
}
