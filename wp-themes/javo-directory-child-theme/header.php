<?php
/**
 * The Header template for Javo Theme
 *
 * @package    WordPress
 * @subpackage Javo_Directory
 * @since      Javo Themes 1.0
 */
// Get Options
global $javo_theme_option;
global $javo_tso;
$javo_theme_option = @unserialize(get_option("javo_themes_settings"));
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
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>


    <?php
    // Custom CSS AREA
    if ($javo_tso->get('custom_css', '') != '') {
        printf('<style type="text/css">%s</style>', stripslashes($javo_tso->get('custom_css', '')));
    }; ?>

    <?php wp_head(); ?>


    <?php function htmlAndPinterestScripts() { ?>
        <!--[if lte IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <script type="text/javascript" async defer data-pin-hover="true" data-pin-height="28"
                src="//assets.pinterest.com/js/pinit.js"></script>
        <script> (function (f, b) {
                var c;
                f.hj = f.hj || function () {
                        (f.hj.q = f.hj.q || []).push(arguments)
                    };
                f._hjSettings = {hjid: 19936, hjsv: 3};
                c = b.createElement("script");
                c.async = 1;
                c.src = "//static.hotjar.com/c/hotjar-19936.js?sv=3";
                b.getElementsByTagName("head")[0].appendChild(c);
            })(window, document); </script>
    <?php }

    add_action('wp_footer', 'htmlAndPinterestScripts', 9999999); ?>
</head>
<style type="text/css">
    .admin-color-setting,
    .btn.admin-color-setting,
    .javo-txt-meta-area.admin-color-setting,
    .javo-left-overlay.bg-black .javo-txt-meta-area.admin-color-setting,
    .javo-left-overlay.bg-red .javo-txt-meta-area.admin-color-setting,
    .javo-txt-meta-area.custom-bg-color-setting {
        background-color: <?php echo $javo_tso->get('total_button_color');?>;
    <?php if( $javo_tso->get('total_button_border_use') == 'use'): ?> border-style: solid;
        border-width: 1px;
        border-color: <?php echo $javo_tso->get('total_button_border_color');?>;
    <?php else:?> border: none;
    <?php endif;?>
    }

    .javo-left-overlay .corner-wrap .corner-background.admin-color-setting,
    .javo-left-overlay .corner-wrap .corner.admin-color-setting {
        border: 2px solid <?php echo $javo_tso->get('total_button_color');?>;
        border-bottom-color: transparent !important;
        border-left-color: transparent !important;
        background: none !important;
    }

    .admin-border-color-setting {
        border-color: <?php echo $javo_tso->get('total_button_border_color');?>;
    }

    .custom-bg-color-setting,
    #javo-events-gall .event-tag.custom-bg-color-setting {
        background-color: <?php echo $javo_tso->get('total_button_color');?>;
    }

    .custom-font-color {
        color: <?php echo $javo_tso->get('total_button_color');?>;
    }

    .javo_pagination > .page-numbers.current {
        background-color: <?php echo $javo_tso->get('total_button_color');?>;
        color: #fff;
    }

    .progress .progress-bar {
        border: none;
        background-color: <?php echo $javo_tso->get('total_button_color');?>;
    }

    <?php echo $javo_tso->get('preloader_hide') == 'use'? '.pace{ display:none !important; }' : '';?>


</style>
<body <?php body_class(); ?>>
<div id="page-style" class="<?php echo $javo_tso->get('layout_style_boxed') == "active" ? "boxed" : ""; ?>">
    <div class="loading-page<?php echo $javo_tso->get('preloader_hide') == 'use' ? ' hidden' : ''; ?>">
        <div id="status"
             style="background-image:url(<?php echo $javo_tso->get('logo_url', JAVO_IMG_DIR . '/javo-directory-logo-v1-3.png'); ?>);">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
<?php
require_once $javo_tso->get('header_file', 'library/header/head-directory.php');
if (is_singular()) {
    get_template_part("library/header/post", "header");
}; ?>