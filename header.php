<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width,initial-scale=1.0" >
	<?php  wp_head(); global $pxr_red_option; ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="pxr-main-site-wrapper">
        <div class="pxr-main-site-container"><!-- Wrapper start -->
            <div class="pxr-main-site"><!-- Main Container Start -->
                <header class="pxr-header-wrapper">
                    <div class="pxr-header-top-line">
                        <div class="pxr-header-top-line__wrapper pxr-megamenu-container">
                            <div class="pxr-header-top-line__logo">
                                <a href="<?php echo esc_url(home_url("/")); ?>">
                                    <?php if(!empty($pxr_red_option['logo-img']['url'])) { ;?>
                                        <img src="<?php echo esc_url($pxr_red_option['logo-img']['url']); ?>" alt="<?php the_title(); ?>" srcset="<?php echo esc_url($pxr_red_option['logo-img']['url']) . ' 2x'; ?>">
                                    <?php } else { ?>
                                        <h1><?php esc_html(bloginfo('title')); ?></h1>
                                    <?php } ;?>
                                </a>
                            </div>
                            <?php if ( has_nav_menu( 'pxr_header_menu' ) ) { ?>
                                <?php
                                wp_nav_menu(array(
                                    'theme_location'  => 'pxr_header_menu',
                                    'menu'            => 'Header Menu',
                                    'menu_class'      => 'pxr-navigation-list',
                                    'walker'          => new pxrframework_menu_walker,
                                    'container'       => 'nav',
                                    'container_class' => 'pxr-header-top-line__nav pxr-nav-wrapper',
                                    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                                    'container_id'    => '',
                                )); ?>
                            <?php } ?>
                            <div class="pxr-header-top-line__icon pxr-top-line-menu">
                                <div class="pxr-top-line-menu__wrapper">
                                    <span class="pxr-top-line-menu__icon">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
                                        <circle fill="#4e413b" cx="4" cy="4" r="2"/>
                                        <circle fill="#4e413b" cx="12" cy="4" r="2"/>
                                        <circle fill="#4e413b" cx="20" cy="4" r="2"/>
                                        <circle fill="#4e413b" cx="4" cy="12" r="2"/>
                                        <circle fill="#4e413b" cx="12" cy="12" r="2"/>
                                        <circle fill="#4e413b" cx="20" cy="12" r="2"/>
                                        <circle fill="#4e413b" cx="4" cy="20" r="2"/>
                                        <circle fill="#4e413b" cx="12" cy="20" r="2"/>
                                        <circle fill="#4e413b" cx="20" cy="20" r="2"/>
                                        </svg>            
                                    </span>
                                </div>                                  
                            </div>
                        </div>
                    </div>
                </header>
                <div class="pxr-site-content-wrapper">
