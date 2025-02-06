add_action('woocommerce_archive_description', 'show_category_title', 1, 1);
function show_category_title() {
	$cat_title = single_tag_title("", false);
	echo '<h1>' . $cat_title . '</h1>';
}
