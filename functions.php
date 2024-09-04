//Hide Shipping on the Cart page
add_filter( 'woocommerce_cart_needs_shipping', 'filter_cart_needs_shipping' );
function filter_cart_needs_shipping( $needs_shipping ) {
    if ( is_cart() ) {
        $needs_shipping = false;
		echo "<style>tr.cart-subtotal {display: none !important;}</style>";
    }
    return $needs_shipping;
}



// Addition of delivery according to the number of boxes, depending on the size of the pots
add_action('woocommerce_checkout_init', 'check_cart_session'); // when entering Checkout
//add_action('woocommerce_cart_actions', 'check_cart_session'); // when entering the Cart
//add_action('woocommerce_after_cart_item_quantity_update', 'check_cart_session', 20, 4); // when updating the quantity in the Cart

function check_cart_session() {
    // Get the user's session
    $session = WC()->session;

    // Get the session data
    $cart = $session->get('cart');
    $cart_totals = $session->get('cart_totals'); // Get the totals data

    // Extract the shipping value
	$flat_rate_settings = get_option('woocommerce_flat_rate_2_settings'); // flat_rate_2, the name depends on your settings
	$flat_rate_default_cost = isset($flat_rate_settings['cost']) ? floatval($flat_rate_settings['cost']) : 0;
    $chosen_shipping_methods = $session->get('chosen_shipping_methods');
    $shipping_for_package = $session->get('shipping_for_package_0'); // Get your delivery details. shipping_for_package_0,  the name depends on your settings
	// local_pickup:3, the name depends on your settings
    if ($chosen_shipping_methods[0] == "local_pickup:3") {
        $shipping_cost = 0;
    } else {
            $shipping_cost = $flat_rate_default_cost;
    }

    // Subtract the subtotal
    $subtotal = isset($cart_totals['subtotal']) ? floatval($cart_totals['subtotal']) : 0;

    // Check the data in the session
    if (!empty($cart)) {
        $total_boxes_needed = 0;
		$product_area = 0;
		
        foreach ($cart as $cart_item_key => $cart_item) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];

            // Get the product post
            $product_post = get_post($product_id);

            // Check if the post exists and get the excerpt
            if ($product_post) {
                $post_excerpt = $product_post->post_excerpt;

                // Use a regular expression to find the piece of text
				// My key expression is "Promjer posude: XX cm" from where I extract XX as the dimensions.
                if (preg_match('/Promjer posude:\s*([^\s]+)\s*cm/', $post_excerpt, $matches)) {
                    $promjer_posude = (float) $matches[1];
					// The cases depend on your dimensions, so you can change them according to your needs.
					switch ($promjer_posude) {
						case 10.5 :
							$dodatak_za_nadzemni_dio = 4/3;
							break;
						case 12 :
							$dodatak_za_nadzemni_dio = 3/4;
							break;
						case 13 :
							$dodatak_za_nadzemni_dio = 1/3;
							break;
						case 15 :
							$dodatak_za_nadzemni_dio = 4/3;
							break;
						case 17 :
							$dodatak_za_nadzemni_dio = 3/5;
							break;
						case 19 :
							$dodatak_za_nadzemni_dio = 1/6;
							break;
						default :
						$dodatak_za_nadzemni_dio = 1/6;
					}
                } else {
					$promjer_posude = 10.5;
					$dodatak_za_nadzemni_dio = 4/3;
                    error_log("Pan diameter not found for Product ID: $product_id.");
                }
				$product_area += (($promjer_posude * ($promjer_posude+($promjer_posude*$dodatak_za_nadzemni_dio))) * $promjer_posude) * $quantity;
            } else {
                error_log("Product ID: $product_id not found.");
            }
        }

		$total_boxes_needed = calculate_products_in_box($product_area);

        // Calculate the total shipping value based on the subtotal
        if ($subtotal < 100) {
            $total_shipping_cost = $shipping_cost * $total_boxes_needed;
        } else {
            if ($total_boxes_needed == 1) {
                $total_shipping_cost = $shipping_cost;
            } else {
                $total_shipping_cost = $shipping_cost + (5 * ($total_boxes_needed-1));
            }
        }
		// Check if the shipping value has already been updated
		if ($chosen_shipping_methods[0] == "flat_rate:2") {
			if ($shipping_for_package['rates']['flat_rate:2']->get_cost() != $total_shipping_cost) {
				// Update the delivery value in the session
				$shipping_for_package['rates']['flat_rate:2']->set_cost($total_shipping_cost);
				$session->set('shipping_for_package_0', $shipping_for_package);
			}
        }
    } else {
        echo "Cart is empty.";
    }
}

// Calculation of how much it collects in a box
function calculate_products_in_box($product_area) {
    // Box dimensions, replace with your box dimensions
    $box_width = 48; // cm
    $box_length = 34; // cm
    $box_height = 45; // cm
    $box_area = $box_width*$box_length *20;
	$box_area_both_row = ($box_area + ($box_area/2));

    $total_products = ceil($product_area / $box_area_both_row);

    return $total_products;
}
