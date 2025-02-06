add_filter('wc_add_to_cart_message', 'handler_function_name', 10, 2);
function handler_function_name($message, $product_id) {
	$linkkopche = "<a href=\"https://your_link_to_cart/\" tabindex=\"1\" class=\"button wc-forward wp-element-button\">See your cart</a>";
    return "Product is added to cart. ".$linkkopche;
}
