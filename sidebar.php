<?php if(is_active_sidebar( 'pxr-blog-sidebar' )) { ?>
	<aside class="pxr-sidebar-aside cf">
        <div class="pxr-sidebar-wrapper">
            <?php dynamic_sidebar( 'pxr-blog-sidebar' ); ?>
        </div>
    </aside>
<?php } ?>