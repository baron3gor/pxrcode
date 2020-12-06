<?php
/**
 * Enqueue Theme Styles
 */

if ( !function_exists( 'pxr_enqueue_styles' ) ) {
	function pxr_enqueue_styles() {

		//Add general css files
		wp_register_style( 'pxr-general-css', PXR_THEME_URL . '/css/general.css', array(), PXR_THEME_VERSION, 'all');

		//Register libs
		wp_register_style( 'pxr-font-awesome', PXR_THEME_URL . '/css/font-awesome.min.css', array(), PXR_THEME_VERSION, 'all');
		wp_register_style( 'pxr-elegant-icons', PXR_THEME_URL . '/css/elegant-icons.css', array(), PXR_THEME_VERSION, 'all');
		wp_register_style( 'pxr-ion-icons', PXR_THEME_URL . '/css/ionicons.min.css', array(), PXR_THEME_VERSION, 'all');
		wp_register_style( 'pxr-themify-icons', PXR_THEME_URL . '/css/themify-icons.css', array(), PXR_THEME_VERSION, 'all');
		wp_register_style( 'pxr-icon-font', PXR_THEME_URL . '/css/pxr-icon-font.css', array(), PXR_THEME_VERSION, 'all');

		//Load general css
		wp_enqueue_style('pxr-general-css');

		//Load Icon Fonts and Libraries
		wp_enqueue_style('pxr-font-awesome');
		//wp_enqueue_style('pxr-elegant-icons');
		//wp_enqueue_style('pxr-ion-icons');
		//wp_enqueue_style('pxr-themify-icons');
		//wp_enqueue_style('pxr-icon-font');
	}
}

add_action( 'wp_enqueue_scripts', 'pxr_enqueue_styles' );



/**
 * Enqueue Theme Scripts
 */
if ( !function_exists( 'pxr_enqueue_scripts' ) ) {
	function pxr_enqueue_scripts() {

		// add html5 for old browsers.
		wp_register_script( 'html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array( 'jquery' ), PXR_THEME_VERSION, false );

	    //Libs Register
	    wp_register_script( 'pxr-megamenu', PXR_THEME_URL . '/js/libs/megamenu.js',array( 'jquery' ), PXR_THEME_VERSION, true );
	    wp_register_script( 'pxr-locomotive', PXR_THEME_URL . '/js/libs/locomotive-scroll.min.js',array( 'jquery' ), PXR_THEME_VERSION, true );
	    wp_register_script( 'pxr-velocity-js', PXR_THEME_URL . '/js/libs/velocity.min.js', array( 'jquery' ), PXR_THEME_VERSION, true );
	    wp_register_script( 'pxr-scrollup', PXR_THEME_URL . '/js/libs/jquery.scrollUp.min.js', array( 'jquery' ), PXR_THEME_VERSION, true );

		//Custom JS Code
		wp_register_script( 'pxr-scripts', PXR_THEME_URL . '/js/scripts.js', array( 'jquery' ), PXR_THEME_VERSION, true );

		wp_enqueue_script( 'html5-shim' );
		wp_script_add_data( 'html5-shim', 'conditional', 'lt IE 9' );

		//Load Libs
	    wp_enqueue_script( 'pxr-velocity-js' );
	    wp_enqueue_script( 'pxr-scripts' );
		//wp_enqueue_script( 'pxr-megamenu' );
		//wp_enqueue_script( 'pxr-locomotive' );
		//wp_enqueue_script( 'pxr-scrollup' );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	        wp_enqueue_script( 'comment-reply' );
	    }
	}
}

add_action( 'wp_enqueue_scripts', 'pxr_enqueue_scripts');

