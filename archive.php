<?php get_header(); ?>

	<div class="pxr-page" role="main">

	    <?php get_template_part('partials/content-page-header'); ?>

	    <div class="pxr-page-archive-wrapper pxr-wrapper pxr-page-inner">
	        <div class="pxr-page-archive">     
	        	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		            <article <?php post_class() ?>>
		                <div class="pxr-post-container">                                
		                    <?php get_template_part( '/post-contents/content', get_post_format() ); ?>
		                </div>
		            </article>
		        <?php endwhile; else: ?>
		            <?php get_template_part('partials/notfound')?>
		        <?php endif; ?>
		    </div>
		</div>
		<div class="pxr-pagination-wrapper">
		    <?php pxr_page_links(); ?>
		</div>

	</div>

<?php get_footer(); ?>