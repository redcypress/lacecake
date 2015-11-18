<?php
function theme_enqueue_styles() {
    wp_enqueue_style('parent-bootstrap-css', get_template_directory_uri() . '/assets/bootstrap/bootstrap.min.css');
    wp_enqueue_style('parent-bootstrap-select-css', get_template_directory_uri() . '/assets/bootstrap/bootstrap-select.css');
    wp_enqueue_style('parent-fontawesome-css', get_template_directory_uri() . '/assets/css/font-awesome.css');
    wp_enqueue_style('parent-archive-css', get_template_directory_uri() . '/assets/css/archive.css');
    wp_enqueue_style('parent-common-css', get_template_directory_uri() . '/assets/css/common.css');
    wp_enqueue_style('parent-header-css', get_template_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('parent-my-page-css', get_template_directory_uri() . '/assets/css/my-page.css');
    wp_enqueue_style('parent-custom-bootstrap-css', get_template_directory_uri() . '/assets/css/custom-bootstrap.css');
    wp_enqueue_style('parent-grid-list-listing-css', get_template_directory_uri() . '/assets/css/grid-list-listing.css');
    wp_enqueue_style('parent-single-spy-css', get_template_directory_uri() . '/assets/css/single-spy.css');
    wp_enqueue_style('parent-single-item-tab-css', get_template_directory_uri() . '/assets/css/single-item-tab.css');
    wp_enqueue_style('parent-listing-css', get_template_directory_uri() . '/assets/css/listing.css');
    wp_enqueue_style('parent-loading-css', get_template_directory_uri() . '/assets/css/loading.css');
    wp_enqueue_style('parent-dashboard-css', get_template_directory_uri() . '/assets/css/dashboard.css');
    wp_enqueue_style('parent-footer-top-css', get_template_directory_uri() . '/assets/css/footer-top.css');
    wp_enqueue_style('parent-archive-list-css', get_template_directory_uri() . '/assets/css/archive-list.css');
    wp_enqueue_style('parent-archive-2-column-css', get_template_directory_uri() . '/assets/css/archive-2-column.css');
    wp_enqueue_style('parent-responsive-css', get_template_directory_uri() . '/assets/css/responsive.css');
    wp_enqueue_style('parent-shortcodes-css', get_template_directory_uri() . '/assets/css/shortcodes.css');
    wp_enqueue_style('parent-bootstrap-tagsinput-css', get_template_directory_uri() . '/assets/css/bootstrap-tagsinput.css');
    wp_enqueue_style('parent-home-map-layout-css', get_template_directory_uri() . '/assets/css/home-map-layout.css');
    wp_enqueue_style('parent-chosen-css', get_template_directory_uri() . '/assets/css/chosen.min.css');
    wp_enqueue_style('parent-custom-chosen-css', get_template_directory_uri() . '/assets/css/custom-chosen.css');
    wp_enqueue_style('parent-magnific-popup-css', get_template_directory_uri() . '/assets/css/magnific-popup.css');
    wp_enqueue_style('parent-jquery-nouislider-css', get_template_directory_uri() . '/assets/css/jquery.nouislider.min.css');
    wp_enqueue_style('parent-maps-css', get_template_directory_uri() . '/assets/css/maps.css');
    wp_enqueue_style('parent-spectrum-css', get_template_directory_uri() . '/assets/css/spectrum.css');
    wp_enqueue_style('parent-bootstrap-markdown-css', get_template_directory_uri() . '/assets/css/bootstrap-markdown.min.css');
    wp_enqueue_style('parent-pace-theme-big-counter-css', get_template_directory_uri() . '/assets/css/pace-theme-big-counter.css');
    wp_enqueue_style('parent-theme-css', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-theme-css', get_stylesheet_uri(), array());
}

function javo_dequeue_scripts() {

    $javo_dequeue_scripts = array(
        'bootstrap'
    , 'jQuery-Easing'
    , 'jQuery-Ajax-form'
    , 'sns-link'
    , 'jQuery-Rating'
    , 'jQuery-Spectrum'
    , 'jQuery-parallax'
    , 'jQuery-javo-Emailer'
    , 'javo-assets-common-script'
    , 'bootstrap-hover-dropdown'
    , 'bootstrap-select-script'
    , 'javo-Footer-script'
    , 'bootstrap-markdown'
    , 'bootstrap-markdown-fr'
    , 'jQuery-QuickSnad'
    , 'jQuery-nouiSlider'
    , 'okVideo-Plugin'
    , 'slight-submenu.min-Plugin'
    , 'gmap3'
    , 'oms-same-position-script'
    , 'Javo-common-script'
    , 'jQuery-chosen-autocomplete'
    , 'javoThemes-Message-Plugin'
    , 'jQuery-Parallax'
    , 'jQuery-javo-Favorites'
    , 'jQuery-javo-search'
    , 'jQuery-flex-Slider'
    , 'Google-Map-Info-Bubble'
    , 'Pace-Script'
    , 'single-reviews-modernizr.custom'
    , 'jquery.magnific-popup'
    );

    foreach ($javo_dequeue_scripts as $javo_dequeue_script) {
        wp_dequeue_script($javo_dequeue_script);
    }
}

add_action('init', 'addImageSizes');
function addImageSizes() {
    add_image_size("javo-small", 250, 207, true);  // small size
}

function javo_enqueue_scripts() {

    $javo_assets_header_scripts = array(
        '../bootstrap/bootstrap-select.js'       => 'bootstrap-select-scriptss'
    , 'jquery.easing.min.js'                     => 'jQuery-Easingss'
    , 'jquery.form.js'                           => 'jQuery-Ajax-formss'
    , 'sns-link.js'                              => 'sns-linkss'
    , 'jquery.raty.min.js'                       => 'jQuery-Ratingss'
    , 'jquery.spectrum.js'                       => 'jQuery-Spectrumss'
    , 'jquery.parallax.min.js'                   => 'jQuery-parallaxss'
    , 'jquery.javo.mail.js'                      => 'jQuery-javo-Emailerss'
    , 'common.js'                                => 'javo-assets-common-scriptss'
    , 'bootstrap.hover.dropmenu.min.js'          => 'bootstrap-hover-dropdownss'
    , 'javo-footer.js'                           => 'javo-Footer-scriptss'
    , 'bootstrap-markdown.js'                    => 'bootstrap-markdownss'
    , 'bootstrap-markdown.fr.js'                 => 'bootstrap-markdown-frss'
    , 'jquery.quicksand.js'                      => 'jQuery-QuickSnadss'
    , 'jquery.nouislider.min.js'                 => 'jQuery-nouiSliderss'
    , 'okvideo.min.js'                           => 'okVideo-Pluginss'
    , 'jquery.slight-submenu.min.js'             => 'slight-submenu.min-Pluginss'
    , 'gmap3.js'                                 => 'gmap3ss'
    , 'oms.min.js'                               => 'oms-same-position-scriptss'
    , 'common.js'                                => 'Javo-common-scriptss'
    , 'chosen.jquery.min.js'                     => 'jQuery-chosen-autocompletess'
    , 'jquery.javo.msg.js'                       => 'javoThemes-Message-Pluginss'
    , 'jquery.parallax.min.js'                   => 'jQuery-Parallaxss'
    , 'jquery.favorite.js'                       => 'jQuery-javo-Favoritesss'
    , 'jquery_javo_search.js'                    => 'jQuery-javo-searchss'
    , 'jquery.flexslider-min.js'                 => 'jQuery-flex-Sliderss'
    , 'google.map.infobubble.js'                 => 'Google-Map-Info-Bubbless'
    , 'pace.min.js'                              => 'Pace-Scriptss'
    , 'single-reviews-modernizr.custom.79639.js' => 'single-reviews-modernizr.customss'
    , 'jquery.magnific-popup.js'                 => 'jquery.magnific-popupss'
    , 'bootstrap.min.js'                         => 'bootstrapss'
    );

    foreach ($javo_assets_header_scripts as $src => $id) {
        javo_get_asset_child_script($src, $id, null, false);
    }
}

add_action('wp_print_scripts', 'javo_dequeue_scripts', 0);
add_action('wp_enqueue_scripts', 'javo_enqueue_scripts', 100);

function javo_get_asset_child_script($fn = null, $name = "javo", $ver = "0.01", $bottom = true) {
    wp_register_script($name, get_stylesheet_directory_uri() . '/assets/js/' . $fn, ['jquery'], $ver, true);
    wp_enqueue_script($name);
}

require_once dirname(__FILE__) . '/library/shortcodes/featured-items/javo-featured-items.php';
require_once dirname(__FILE__) . '/library/shortcodes/featured-items/javo-featured-items-sidebar.php';
require_once dirname(__FILE__) . '/library/functions/callback-post-list.php';

add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 10000000);

function hook_google_analytics() {
    ?>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-59213900-1', 'auto');
        ga('send', 'pageview');

    </script>
    <?php
}

add_action('wp_footer', 'hook_google_analytics', 1000);


// //remove inline width and height added to images
// add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
// add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
//
// // Removes attached image sizes as well
// add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );
// function remove_thumbnail_dimensions( $html ) {
//     $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
//     return $html;
// }
