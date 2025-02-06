add_action( 'woocommerce_before_main_content', 'category_main_banner', 10 );
function category_main_banner(){
	switch (true) {
		case (is_product_category('your-cat-1')):
		echo do_shortcode('[your_shortcode_1]');
		break;
		case (is_product_category('your-cat-2')):
		echo do_shortcode('[your_shortcode_2]');
		break;
		case (is_product_category('your-cat-NN')):
		echo do_shortcode('[your_shortcode_NN]');
		break;
		default:
		break;
	}
}
