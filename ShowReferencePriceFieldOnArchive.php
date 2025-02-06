add_action( 'ocean_after_archive_product_title', 'action_woocommerce_after_shop_loop_item', 9 );
function action_woocommerce_after_shop_loop_item() {
    global $product;
    $display_field = get_post_meta( $product->get_id(), '_reference_price', true );
    if ( is_archive() && $display_field ) {
        echo '<p class="reference-price">Reference price: ' . $display_field . '&nbsp;your-currency-sign</p>';
    }
}
