add_filter( 'woocommerce_after_order_notes' , 'custom_override_checkout_fields');
// Our hooked in function – $fields is passed via the filter!
function custom_override_checkout_fields( $checkout ) {
	 echo '<div id="custom_checkout_field"><h3>' . __('Само за My World членови:') . '</h3>';
		woocommerce_form_field('pole_myworld', array(
		'type' => 'text',
		'class' => array('my-field-class form-row-wide'),
		'label' => __('Внесете го вашиот MyWorld код'),
		'placeholder' => __('Вашето ID'),
		),
		$checkout->get_value('pole_myworld'));
	 echo '</div>';
	      //return $fields;
}
// Sočuvaj pole za MyWorld kod vo baza
//add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['pole_myworld'] ) ) {
        update_post_meta( $order_id, 'pole_myworld', sanitize_text_field( $_POST['pole_myworld'] ) );
    }
}
// Dodaj pole za MyWorld kod vo administracija na naračkata
//add_action( 'woocommerce_admin_order_data_after_order_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta($order){
	$rjedan_value = get_post_meta( $order->id, 'pole_myworld', true );
    echo '<p><strong>'.__('Мојот MyWorld код е').':</strong> ' . $rjedan_value . '</p>';
}
// Dodaj pole za MyWorld kod vo mejl
//add_action( 'woocommerce_email_order_meta','rjedan_email_template');
function rjedan_email_template($order_obj){
    $is_set = get_post_meta( $order_obj->get_order_number());           
    // return if no custom field is set
    if( empty( $is_set ) )
	return; 
	// ok, we go ahead and echo custom field
    $rjedan_email = get_post_meta( $order_obj->get_order_number(), 'pole_myworld', true );
    echo '<p><strong>Мојот MyWorld код е: '.$rjedan_email.'</strong></p>';
}
