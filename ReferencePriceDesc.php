add_action('woocommerce_before_add_to_cart_form', 'display_reference_price_desc', 20);
function display_reference_price_desc() {
		global $product;
		$product_id2 = $product->get_id();
		$parent_id2 = $product->get_parent_id();
		if ( is_product() && empty($custom_field) && !has_term('your-term', 'product_tag', $parent_id2 ? $parent_id2 : $product_id2) ) {
		echo '<div class="woocommerce-product-price-desc">';
        echo '<p class="price-desc">You will receive the discounted price expressed on the total amount at the end of the order.</strong></p>';
        echo '</div>';	
		}
}
