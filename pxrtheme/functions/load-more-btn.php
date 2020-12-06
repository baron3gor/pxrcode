<?php
/**
 * Javascript for Load More
 *
 */

if ( !function_exists( 'pxr_load_more_js' ) ) {
	function pxr_load_more_js() {

		global $wp_query;

		$args = array(
			'nonce'       => wp_create_nonce( 'pxr-load-more-nonce' ),
			'url'         => admin_url( 'admin-ajax.php' ),
			'button_text' => esc_html__( 'Load More', 'pxrcode' ),
		);

		wp_enqueue_script( 'pxr-load-more',
			get_stylesheet_directory_uri() . '/js/libs/load-more-btn.js',
			array( 'jquery' ),
			'1.0',
			true );

		wp_localize_script( 'pxr-load-more', 'pxrloadmore', $args );

	}
}

add_action( 'pxr_load_more_scripts', 'pxr_load_more_js' );

/**
 * AJAX Load More
 *
 */
if ( !function_exists( 'pxr_ajax_load_more' ) ) {
	function pxr_ajax_load_more() {
		check_ajax_referer( 'pxr-load-more-nonce', 'nonce' );

		$pxr_current_page  = $_POST['page'];
		$pxr_per_page	   = $_POST['perpage'];
		$pxr_gallery_cat   = $_POST['cat'];

		if($pxr_gallery_cat == 0) {
		$args = array(
	        'post_type' 	 => 'projects',
	        'post_status' 	 => 'publish',
	        'posts_per_page' => $pxr_per_page,
	        'paged' 	 	 => $pxr_current_page,
	    );
		}  else {
			$args = array(
	            'post_type' 	 => 'projects',
	            'post_status'	 => 'publish',
	            'posts_per_page' => $pxr_per_page,
	            'paged' 		 => $pxr_current_page,
	            'tax_query' => array(
	                    array(
	                        'taxonomy'  => 'project-category',
	                        'field'     => 'term_id',
	                        'terms'     => $pxr_gallery_cat,
	                    )
	                ),
	      	    );
		}

		ob_start();
		$pxr_loop = new WP_Query( $args );
		if ( $pxr_loop->have_posts() ): while ( $pxr_loop->have_posts() ): $pxr_loop->the_post();

			$pxr_img_id    = get_post_thumbnail_id();
	        $pxr_term_list = get_the_term_list(get_the_ID(), 'project-category', '', ' / ', ''); 
	        $pxr_img_url   = wp_get_attachment_image_src( $pxr_img_id, 'full', true);
	            if( !empty($pxr_img_url)) : ?>
					<div class="content-wrapper-img current_gallery fade-animation">
				     	<div class="fade-image gallery-img">
				            <a href="<?php the_permalink() ;?>"><img src="<?php echo esc_url($pxr_img_url[0]); ?>" alt="<?php echo get_the_title(); ?>" class="img-gallery"></a>
				        </div>
				        <div class="title-wrapper">
				        	<?php if(taxonomy_exists('project-category')) : ?>
				                <h6 class="gallery-cat-list"><?php echo pxr_wp_kses($pxr_term_list, 'pxrcode');  ?></h6>
				            <?php endif; ?>
				            <h5><a class="gallery-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				        </div>
				    </div>
			    <?php endif; ?>

		<?php endwhile; endif;
		wp_reset_postdata();
		$data = ob_get_clean();
		wp_send_json_success( $data );
		wp_die();
	}
}

add_action( 'wp_ajax_pxr_ajax_load_more', 'pxr_ajax_load_more' );
add_action( 'wp_ajax_nopriv_pxr_ajax_load_more', 'pxr_ajax_load_more' );