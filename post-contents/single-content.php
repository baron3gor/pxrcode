<?php if(has_post_thumbnail()) : ?>
	<figure class="pxr-post-thumb-wrapper">
 		<?php the_post_thumbnail();?>
	</figure>
<?php endif; ?>
<div>
	<div class="pxr-single-title-wrapper">
		<span class="pxr-single-post-cats"><?php echo the_category(', ');?></span>
    	<h2 class="pxr-single-post-title"><?php the_title(); ?></h2>
    </div>
    <div class="pxr-single-content-wrapper">
    	<?php the_content(); ?>
    </div>
</div>