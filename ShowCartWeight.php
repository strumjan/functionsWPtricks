add_action( 'woocommerce_before_checkout_form', 'bbloomer_print_cart_weight' );
add_action( 'woocommerce_before_cart', 'bbloomer_print_cart_weight' );
  
function bbloomer_print_cart_weight() {
   $notice = 'Your order weighs: ' . WC()->cart->get_cart_contents_weight() . get_option( 'woocommerce_weight_unit' );
   if ( is_cart() || is_checkout() ) {
      wc_print_notice( $notice, 'notice' );
   } else {
      wc_add_notice( $notice, 'notice' );
   }
}
