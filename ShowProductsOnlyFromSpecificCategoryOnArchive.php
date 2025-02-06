// Show products only from desired category if archive set to show products
add_action('pre_get_posts','shop_filter_cat');
function shop_filter_cat($query) {
    if (!is_admin() && is_post_type_archive('product') && $query->is_main_query()) {
        $query->set('tax_query', array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => array('your-term'),
                'operator' => 'IN'
            )
        ));
    }
}
