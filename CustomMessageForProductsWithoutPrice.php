// Add "ask for price" message for products without a set price on single product and archive pages
add_filter('woocommerce_get_price_html', 'custom_price_message', 10, 2);
function custom_price_message($price, $product) {
    if ( $product->get_price() == '') {
        return '<span class="ask-for-price">On order!</span>';
    }
    return $price;
}
