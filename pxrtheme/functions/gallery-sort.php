<?php
/**
 * Javascript for Gallery Sorting
 *
 */

if ( !function_exists( 'pxr_gallery_sort_js' ) ) {
	function pxr_gallery_sort_js() {

		global $wp_query;

		$args = array(
			'nonce'       => wp_create_nonce( 'pxr-gallery-sort-nonce' ),
			'url'         => admin_url( 'admin-ajax.php' ),
		);
		wp_enqueue_script( 'pxr-gallery_sort',
			get_stylesheet_directory_uri() . '/js/libs/gallery-sort.js',
			array( 'jquery' ),
			'1.0',
			true );
		wp_localize_script( 'pxr-gallery_sort', 'pxrgallerysort', $args );
	}

}

add_action( 'pxr_gallery_scripts', 'pxr_gallery_sort_js');



/**
 * AJAX Load More
 *
 */
if ( !function_exists( 'pxr_ajax_gallery_sort' ) ) {
	function pxr_ajax_gallery_sort() {
		check_ajax_referer( 'pxr-gallery-sort-nonce', 'nonce' );

		$pxr_cat_id 		= $_POST['post'];
		$pxr_style_gallery1 = $_POST['galstyle'];
		$pxr_post_count1 	= $_POST['galpostcount'];


		if($pxr_cat_id == 0) {
			$args = array(
		        'post_type' => 'projects',
		        'post_status'    => 'publish',
		        'posts_per_page' => $pxr_post_count1,
		    );
		} else {
			$args = array(
		        'post_type' 	 => 'projects',
		        'post_status'    => 'publish',
		        'posts_per_page' => $pxr_post_count1,
		        'tax_query' 	 => array(
		        	array(
		        		'taxonomy' => 'project-category',
		        		'field' => 'id',
		        		'terms' => $pxr_cat_id
		        	)
		        )
		    );
		}

	    $pxr_gallery = new \WP_Query($args);

	    $pxr_max_cat_page = $pxr_gallery->max_num_pages;

		ob_start(); ?>

		<div class="content-wrapper-gallery" data-perpage="<?php echo esc_attr($pxr_post_count1, 'pxrcode'); ?>" data-maxpage="<?php echo esc_attr($pxr_max_cat_page, 'pxrcode') ?>" data-btn="<?php echo esc_attr($pxr_style_gallery1, 'pxrcode') ?>">
		<?php if ($pxr_gallery->have_posts()) : while ($pxr_gallery->have_posts()) : $pxr_gallery->the_post();
			
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
					<?php endif;  
				endwhile;
	        else: ?>
		        <?php get_template_part('partials/notfound')?>
		    <?php endif; ?>
	</div>
		<?php
		$data = ob_get_clean();
		wp_send_json_success( $data );
		wp_die();
	}
}

add_action( 'wp_ajax_pxr_ajax_gallery_sort', 'pxr_ajax_gallery_sort' );
add_action( 'wp_ajax_nopriv_pxr_ajax_gallery_sort', 'pxr_ajax_gallery_sort' );