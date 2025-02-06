function wc_add_long_description() {
	global $product;
	?>
        <div class="product-desc-on-archive" itemprop="description">
            <?php echo substr( apply_filters( 'the_content', $product->post->post_excerpt ), 0,200 ); echo '...' ?>
        </div>
	<?php
}
add_action( 'ocean_after_archive_product_add_to_cart', 'wc_add_long_description' );
