// remove add to cart button for specific product
add_filter( 'woocommerce_get_availability', 'remove_add_to_cart_button', 1, 2);
add_action( 'woocommerce_single_product_summary', 'remove_add_to_cart_button' );
// Outputing a custom button in Single product pages (you need to set the button link)
function replacement_add_button( ) {
?>
<script>
jQuery.noConflict()(function ($) {
	//jQuery(document).ready(function($)
	jQuery( window ).on( "load", function() {
 $('.panel-heading.cwginstock-panel-heading h4').text('');
 $('input.cwgstock_button').val('Order');
	});
});
</script>
<?php
}
function remove_add_to_cart_button() {
	global $product;
	$current_product_id = get_the_ID(); // get ID of the current post
    $current_product_title = get_the_title(); // get the title of the current post
    //$product = wc_get_product( $current_product_id ); // get the product object
	if ( is_shop() || is_product() || is_product_category() || is_archive() ) {
		if ( $product->is_on_backorder( $item['quantity'] ) ) {
		#### Removing the add-to-cart button ####
		remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
		## Other products types
        // remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
        // remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
        // remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
        // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
         remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );


		#### Adding a custom replacement button ####
		add_action( 'woocommerce_simple_add_to_cart', 'replacement_add_button', 30 );
		add_action( 'woocommerce_single_variation', 'replacement_add_button', 30 );
		}	
    }
}

// Replacing the ajax add to cart button by a link to the product when cart is empty
add_filter( 'woocommerce_loop_add_to_cart_link', 'replace_loop_add_to_cart_button', 10, 2 );
function replace_loop_add_to_cart_button( $button, $product  ) {
	$terms = array( 'myorders' );
    if( WC()->cart->is_empty() && has_term( $terms, 'product_tag', $product->get_id() ) ){
        $button_text = __( "Look at", "woocommerce" );
        $button = '<a class="button product_type_simple" href="' . $product->get_permalink() . '">' . $button_text . '</a>';
    }
    return $button;
}
