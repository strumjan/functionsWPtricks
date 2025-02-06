// Add the custom field to the product
add_action('woocommerce_product_options_general_product_data', 'add_custom_field');
function add_custom_field() {
    woocommerce_wp_text_input(
        array(
            'id' => '_reference_price',
            'label' => __('Reference price', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );
}
// Save the custom field value
add_action('woocommerce_process_product_meta', 'save_custom_field');
function save_custom_field($post_id) {
    $reference_price = $_POST['_reference_price'];
    if (!empty($reference_price)) {
        update_post_meta($post_id, '_reference_price', esc_attr($reference_price));
    }
}
// Display the custom field value on the product page
add_action('woocommerce_before_add_to_cart_form', 'display_reference_price', 0);
function display_reference_price() {
    global $product;
    $reference_price = get_post_meta($product->get_id(), '_reference_price', true);
    if (!empty($reference_price)) {
        echo '<div class="woocommerce-product-reference-price">';
        echo '<span class="woocommerce-Price-amount amount">';
        echo wc_price($reference_price);  // Display the reference price with WooCommerce formatting
        echo '</span>';
        echo '</div>';
    }
}
// Display custom field before price
add_filter( 'woocommerce_get_price_html', 'custom_single_price_html', 100, 2 );
function custom_single_price_html( $price, $product ) {
	$product_id = $product->get_id();
	$parent_id = $product->get_parent_id();

    $custom_field = get_post_meta( $product->get_id(), '_reference_price', true );
	//if ( is_product() && empty($custom_field) && !has_term('your_term', 'product_tag', $parent_id ? $parent_id : $product_id) )
        //$price1 = '<span class="our-price">Our price: </span>' . $price;
    if ( is_product() && ! empty($custom_field) )
        $price = '<p class="reference-price">Reference price: ' . $custom_field . '&nbsp;your-currency-sign</p>' . $price;
    return $price;
}
