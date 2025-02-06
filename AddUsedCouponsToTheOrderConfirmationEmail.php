function add_payment_method_to_admin_new_order( $order, $is_admin_email ) {
		if( $order->get_used_coupons() ) {
			$coupons_count = count( $order->get_used_coupons() );
		    $i = 1;
		    $coupons_list = '';
		    foreach( $order->get_used_coupons() as $coupon) {
		        $coupons_list .=  $coupon;
		        if( $i < $coupons_count )
		        	$coupons_list .= ', ';
		        $i++;
		    }
		    echo '<p></p>';
		    echo '<p><strong>(' . $coupons_count . ') Coupon:</strong> ' . $coupons_list . '</p>';
		}
}
add_action( 'woocommerce_email_after_order_table', 'add_payment_method_to_admin_new_order', 15, 2 );
