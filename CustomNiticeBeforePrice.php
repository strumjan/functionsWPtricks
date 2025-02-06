add_action( 'woocommerce_before_cart_totals', 'bbloomer_print_notice' );
function bbloomer_print_notice() {
   $notice = '<p class="custom-notice">Your custom notice before cart total.</strong></p>';
   if ( is_cart() || is_checkout() ) {
      wc_print_notice( $notice, 'notice' );
   } else {
      wc_add_notice( $notice, 'notice' );
   }
}
