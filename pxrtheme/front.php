<?php

/**
 * Enqueue Theme Styles
 */

if (!function_exists('pxr_enqueue_styles')) {
   function pxr_enqueue_styles()
   {

      //Add general css files
      wp_register_style('pxr-general-css', PXR_THEME_URL . '/css/general.css', array(), PXR_THEME_VERSION, 'all');

      //Icon fonts
      wp_register_style('pxr-font-awesome', PXR_THEME_URL . '/css/font-awesome.min.css', array(), PXR_THEME_VERSION, 'all');
      wp_register_style('pxr-elegant-icons', PXR_THEME_URL . '/css/elegant-icons.css', array(), PXR_THEME_VERSION, 'all');
      wp_register_style('pxr-ion-icons', PXR_THEME_URL . '/css/ionicons.min.css', array(), PXR_THEME_VERSION, 'all');
      wp_register_style('pxr-themify-icons', PXR_THEME_URL . '/css/themify-icons.css', array(), PXR_THEME_VERSION, 'all');
      wp_register_style('pxr-icon-font', PXR_THEME_URL . '/css/pxr-icon-font.css', array(), PXR_THEME_VERSION, 'all');

      //Register libs
      wp_register_style('pxr-nice-select-css', PXR_THEME_URL . '/css/libs/nice-select.css', array(), PXR_THEME_VERSION, 'all');
      wp_register_style('pxr-magnific-css', PXR_THEME_URL . '/css/libs/magnific-popup.min.css', array(), PXR_THEME_VERSION, 'all');
      wp_register_style('pxr-swiper-css', PXR_THEME_URL . '/css/libs/swiper-bundle.min.css', array(), PXR_THEME_VERSION, 'all');

      //Load general css
      wp_enqueue_style('pxr-general-css');

      //Load Icon Fonts and Libraries
      wp_enqueue_style('pxr-icon-font');
      //wp_enqueue_style('pxr-nice-select-css');
      //wp_enqueue_style('pxr-magnific-css');
      //wp_enqueue_style('pxr-swiper-css');
      //wp_enqueue_style('pxr-font-awesome');
      //wp_enqueue_style('pxr-elegant-icons');
      //wp_enqueue_style('pxr-ion-icons');
      //wp_enqueue_style('pxr-themify-icons');

   }
}

add_action('wp_enqueue_scripts', 'pxr_enqueue_styles');



/**
 * Enqueue Theme Scripts
 */
if (!function_exists('pxr_enqueue_scripts')) {
   function pxr_enqueue_scripts()
   {

      // add html5 for old browsers.
      wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array('jquery'), PXR_THEME_VERSION, false);

      //Libs Register
      wp_register_script('pxr-velocity-js', PXR_THEME_URL . '/js/libs/velocity.min.js', array('jquery'), PXR_THEME_VERSION, true);
      wp_register_script('pxr-nice-select', PXR_THEME_URL . '/js/libs/jquery.nice-select.min.js', array('jquery'), PXR_THEME_VERSION, true);
      wp_register_script('pxr-magnific', PXR_THEME_URL . '/js/libs/jquery.magnific-popup.min.js', array('jquery'), PXR_THEME_VERSION, true);
      wp_register_script('pxr-jqvalidation', PXR_THEME_URL . '/js/libs/jquery.validate.min.js', array('jquery'), PXR_THEME_VERSION, true);
      wp_register_script('pxr-swiper', PXR_THEME_URL . '/js/libs/swiper-bundle.min.js', array('jquery'), PXR_THEME_VERSION, true);
      wp_register_script('pxr-mask', PXR_THEME_URL . '/js/libs/jquery.mask.min.js', array('jquery'), PXR_THEME_VERSION, true);



      //Custom JS Code
      wp_register_script('pxr-scripts', PXR_THEME_URL . '/js/scripts.js', array('jquery'), PXR_THEME_VERSION, true);

      wp_enqueue_script('html5-shim');
      wp_script_add_data('html5-shim', 'conditional', 'lt IE 9');

      //Load Libs
      wp_enqueue_script('pxr-velocity-js');
      // wp_enqueue_script( 'pxr-nice-select' );
      // wp_enqueue_script( 'pxr-jqvalidation' );
      // wp_enqueue_script( 'pxr-magnific' );
      // wp_enqueue_script( 'pxr-swiper' );
      // wp_enqueue_script( 'pxr-mask' );
      wp_enqueue_script('pxr-scripts');

      if (is_singular() && comments_open() && get_option('thread_comments')) {
         wp_enqueue_script('comment-reply');
      }
   }

   add_action('wp_enqueue_scripts', 'pxr_enqueue_scripts');
}



/**
 * Preload fonts
 */
if (!function_exists('pxr_preload_enqueue_scripts')) {

   function pxr_preload_enqueue_scripts()
   {
      wp_enqueue_style('pxr-icon-handle', PXR_THEME_URL . '/fonts/pxriconfont/pxriconfont.woff', array(), null);
   }

   add_filter('style_loader_tag', 'pxr_font_loader_filter', 10, 2);
}

if (!function_exists('pxr_font_loader_filter')) {

   function pxr_font_loader_filter($html, $handle)
   {

      $handles = array(
         'pxr-icon-handle',
      );

      foreach ($handles as $font) {
         if ($font === $handle) {
            return str_replace(
               "rel='stylesheet'",
               "rel='preload' as='font' type='font/woff' crossorigin='anonymous'",
               $html
            );
         }
      }

      return $html;
   }

   add_action('wp_enqueue_scripts', 'pxr_preload_enqueue_scripts');
}



/**
 * ADD Defer to js
 */
if (!function_exists('pxr_add_defer_attribute')) {
   function pxr_add_defer_attribute($tag, $handle)
   {

      $handles = array(
         'pxr-scripts',
      );

      foreach ($handles as $defer_script) {
         if ($defer_script === $handle) {
            return str_replace(' src', ' defer="defer" src', $tag);
         }
      }

      return $tag;
   }

   add_filter('script_loader_tag', 'pxr_add_defer_attribute', 10, 2);
}
