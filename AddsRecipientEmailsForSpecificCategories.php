add_filter( 'woocommerce_email_recipient_new_order', 'custom_email_recipient_new_order', 10, 2 );
function custom_email_recipient_new_order( $recipient, $order ) {
    // Not in backend when using $order (avoiding an error)
    if( ! is_a($order, 'WC_Order') ) return $recipient;

    // Define the email recipients / categories pairs in the array
    $recipients_categories = array(
        'yourEmail@at.com'   => 'your-term',
    );

    // Loop through order items
    foreach ( $order->get_items() as $item ) {
        // Loop through defined product categories
        foreach ( $recipients_categories as $email => $category ) {
            if( has_term( $category, 'product_cat', $item->get_product_id() ) && strpos($recipient, $email) === false ) {
                $recipient .= ',' . $email;
            }
        }
    }
    return $recipient;
}
