//Hide Shipping on the Cart page
add_filter( 'woocommerce_cart_needs_shipping', 'filter_cart_needs_shipping' );
function filter_cart_needs_shipping( $needs_shipping ) {
    if ( is_cart() ) {
        $needs_shipping = false;
		echo "<style>tr.cart-subtotal {display: none !important;}</style>";
    }
    return $needs_shipping;
}
