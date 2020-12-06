<?php
/****************************************************************
 * DO NOT DELETE
 ****************************************************************/
if (!defined('PXRTHEME_PATH')){
	if ( get_stylesheet_directory() == get_template_directory() ) {
		define('PXRTHEME_PATH', get_template_directory() . '/pxrtheme');
	}  else {
	    define('PXRTHEME_PATH', get_theme_root() . '/pxrcode/pxrtheme');
	}
}

require_once PXRTHEME_PATH . '/init.php';

load_theme_textdomain( 'pxrcode', get_template_directory() . '/lang' );
$locale = get_locale();
$locale_file = get_template_directory() . "/lang/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);
