// Remove category from webshop
add_filter( 'get_terms', 'ts_get_subcategory_terms', 10, 3 );
function ts_get_subcategory_terms( $terms, $taxonomies, $args ) {
$new_terms = array();
// if it is a product category and on the shop page
if ( in_array( 'product_cat', $taxonomies ) &&! is_admin() &&is_shop()  ) {
foreach( $terms as $key => $term ) {
if ( !in_array( $term->slug, array( 'your-cat-1' , 'your-cat-2', 'your-cat-NN' ) ) ) { //pass the slug name here
$new_terms[] = $term;
}}
$terms = $new_terms;
}
return $terms;
}
