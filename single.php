<?php
/*
*Template for display all single posts
*/

get_header();

global $pxr_red_option;  ?>

<div class="pxr-page" role="main">

    <?php get_template_part('partials/content-page-header'); ?>

	<div class="pxr-page-single-wrapper pxr-wrapper pxr-page-inner">
        <div class="pxr-page-single">  
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			    <article <?php post_class(); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
			    	<?php get_template_part( '/post-contents/single-content', get_post_format() ); ?>
				</article>
				<?php endwhile;
			else:
			    get_template_part( 'partials/notfound' );
			endif; ?>	
		</div>
		<?php if(is_active_sidebar( 'pxr-blog-sidebar' )) { ?>
			<aside class="pxr-sidebar-aside cf">
		        <div class="pxr-sidebar-wrapper">
		            <?php dynamic_sidebar( 'pxr-blog-sidebar' ); ?>
		        </div>
		    </aside>
		<?php } ?>	
		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	</div>

</div>
    
<?php get_footer(); ?>