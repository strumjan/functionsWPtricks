add_action( 'woocommerce_checkout_process', 'wc_kopche_continue' );
add_action( 'woocommerce_before_cart' , 'wc_kopche_continue' );
function wc_kopche_continue() {
        if( is_cart() ) {
            wc_print_notice( 
                sprintf( '<a href="https://your-site/">Continue with shopping</a> ' , 
                    wc_price( WC()->cart->total ), 
                    wc_price( $minimum )
                ), 'error' 
            );
        } else {
            wc_add_notice( 
                sprintf( '<a href="https://your-site/">Continue with shopping</a> ' , 
                    wc_price( WC()->cart->total ), 
                    wc_price( $minimum )
                ), 'error' 
            );
        }
}
