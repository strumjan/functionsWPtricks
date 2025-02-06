add_filter( 'woocommerce_related_products', 'mysite_filter_related_products', 10, 1 );
function mysite_filter_related_products( $related_product_ids ) {

    foreach( $related_product_ids as $key => $value ) {
        $relatedProduct = wc_get_product( $value );
        if( ! $relatedProduct->is_in_stock() ) {
            unset( $related_product_ids["$key"] );
        }
    }

    return $related_product_ids;
}
