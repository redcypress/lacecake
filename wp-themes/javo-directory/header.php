<?php
/**
 * The Header template for Javo Theme
 *
 * @package WordPress
 * @subpackage Javo_Directory
 * @since Javo Themes 1.0
 */
// Get Options
global $javo_tso;
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="icon" type="image/x-icon" href="<?php echo $javo_tso->get('favicon_url', '');?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $javo_tso->get('favicon_url', '');?>" />

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lte IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
// Custom CSS AREA
if($javo_tso->get('custom_css', '') != ''){
	printf('<style type="text/css">%s</style>', stripslashes( $javo_tso->get('custom_css', '') ) );
};?>

<?php wp_head(); ?>
</head>
<style type="text/css">
.admin-color-setting,
.btn.admin-color-setting,
.javo-txt-meta-area.admin-color-setting,
.javo-left-overlay.bg-black .javo-txt-meta-area.admin-color-setting,
.javo-left-overlay.bg-red .javo-txt-meta-area.admin-color-setting,
.javo-txt-meta-area.custom-bg-color-setting
{
	background-color: <?php echo $javo_tso->get('total_button_color');?>;
	<?php if( $javo_tso->get('total_button_border_use') == 'use'): ?>
	border-style:solid;
	border-width:1px;
	border-color: <?php echo $javo_tso->get('total_button_border_color');?>;
	<?php else:?>
	border:none;
	<?php endif;?>
}
.javo-left-overlay .corner-wrap .corner-background.admin-color-setting,
.javo-left-overlay .corner-wrap .corner.admin-color-setting{
	border:2px solid <?php echo $javo_tso->get('total_button_color');?>;
	border-bottom-color: transparent !important;
	border-left-color: transparent !important;
	background:none !important;
}
.admin-border-color-setting{
	border-color:<?php echo $javo_tso->get('total_button_border_color');?>;
}
.custom-bg-color-setting,
#javo-events-gall .event-tag.custom-bg-color-setting{
	background-color: <?php echo $javo_tso->get('total_button_color');?>;
}
.custom-font-color{
	color:<?php echo $javo_tso->get('total_button_color');?>;
}
.javo_pagination > .page-numbers.current{
	background-color:<?php echo $javo_tso->get('total_button_color');?>;
	color:#fff;
}
.progress .progress-bar{border:none; background-color:<?php echo $javo_tso->get('total_button_color');?>;}
<?php echo $javo_tso->get('preloader_hide') == 'use'? '.pace{ display:none !important; }' : '';?>

<?php if($javo_tso->get('single_page_menu_other_bg_color')=='use'){ ?>
.single-item #header-one-line,
.single-item #header-one-line>nav{background-color:<?php echo $javo_tso->get('single_page_menu_bg_color'); ?> !important;}
.single-item #header-one-line .navbar-nav>li>a,
.single-item #header-one-line #javo-navibar .navbar-right>li>a>span,
.single-item #header-one-line #javo-navibar .navbar-right>li>a>img{color:<?php echo $javo_tso->get('single_page_menu_text_color'); ?> !important; border-color:<?php echo $javo_tso->get('single_page_menu_text_color'); ?>;}
<?php } ?>
#javo-archive-sidebar-nav > li > a { background: <?php echo $javo_tso->get('total_button_color');?>; }
#javo-archive-sidebar-nav > li.li-with-ul > span{ color:#fff; }
#javo-archive-sidebar-nav .slight-submenu-button{ color: <?php echo $javo_tso->get('total_button_color');?>; }
.javo-archive-header-search-bar>.container{background:<?php echo $javo_tso->get('archive_searchbar_bg_color'); ?>; border-color:<?php echo $javo_tso->get('archive_searchbar_border_color'); ?>;}
ul#single-tabs li.active{ background: <?php echo $javo_tso->get('total_button_color');?> !important; border-color: <?php echo $javo_tso->get('total_button_color');?> !important;}
ul#single-tabs li.active a:hover{ color:#ddd !important; background: <?php echo $javo_tso->get('total_button_color');?> !important; }
ul#single-tabs li a:hover{ color: <?php echo $javo_tso->get('total_button_color');?> !important; }
</style>
<body <?php body_class();?>>
<?php do_action('javo_after_body_tag');?>
<?php if( defined('ICL_LANGUAGE_CODE') ){ ?>
	<input type="hidden" name="javo_cur_lang" value="<?php echo ICL_LANGUAGE_CODE;?>">
<?php }; ?>
<div id="page-style" class="<?php echo $javo_tso->get('layout_style_boxed') == "active"? "boxed":""; ?>">
	<div class="loading-page<?php echo $javo_tso->get('preloader_hide') == 'use'? ' hidden': '';?>">
		<div id="status" style="background-image:url(<?php echo $javo_tso->get('logo_url', JAVO_IMG_DIR.'/javo-directory-logo-v1-3.png');?>);">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div><!-- /.spinner -->
    </div><!-- /.loading-page -->
</div><!-- /.page-style -->


<?php

require_once JAVO_HDR_DIR . '/head-directory.php';
if(is_singular()){
	get_template_part("library/header/post", "header");
};