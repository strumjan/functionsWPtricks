add_filter('woocommerce_package_rates', 'shipping_cost_based_on_weight', 12, 2);
function shipping_cost_based_on_weight( $rates, $package ){
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return $rates;

    // HERE define the differents costs
    $cost1 = 150; // Up to 5 Kg
    $cost2 = 180; // Above 5 Kg and below 10 kg
    $cost3 = 250; // Above 10 kg

    // The cart total Weight
    $total_weight = WC()->cart->get_cart_contents_weight();

    // Loop through the shipping taxes array
    foreach ( $rates as $rate_key => $rate ){
        $has_taxes = false;
        // Targetting "flat rate"
        if( 'flat_rate' === $rate->method_id ){
            // Get the initial cost
            $initial_cost = $new_cost = $rates[$rate_key]->cost;

            // Calculate new cost
            if( $total_weight <= 5 ) { // Below 5 Kg
                $new_cost = $cost1;
            }
            elseif( $total_weight > 5 && $total_weight <= 10 ) { // Between 5 and 10 Kg
                $new_cost = $cost2;
            }
            else { // Above 10 Kg
                $new_cost = $cost3;
            }

            // Set the new cost
            $rates[$rate_key]->cost = $new_cost;

            // Taxes rate cost (if enabled)
            $taxes = [];
            // Loop through the shipping taxes array (as they can be many)
            foreach ($rates[$rate_key]->taxes as $key => $tax){
                if( $rates[$rate_key]->taxes[$key] > 0 ){
                    // Get the initial tax cost
                    $initial_tax_cost = $new_tax_cost = $rates[$rate_key]->taxes[$key];
                    // Get the tax rate conversion
                    $tax_rate    = $initial_tax_cost / $initial_cost;
                    // Set the new tax cost
                    $taxes[$key] = $new_cost * $tax_rate;
                    $has_taxes   = true; // Enabling tax
                }
            }
            if( $has_taxes )
                $rates[$rate_key]->taxes = $taxes;
        }
    }
    return $rates;
}
