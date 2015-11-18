<?php
/*
* Template Name: item List
*/
$javo_query = new javo_Array($_POST);
$javo_list_query = new javo_Array($javo_query->get('filter', []));

get_header();
include('item-filter.php');

function display_dropdown($field) {
    ?>
    <div class="form-group">
        <select name="<?php echo $field['name']; ?>"
                onchange="jQuery('#refine-form').submit()" class="form-control">
            <option value="-1">(all)</option>
            <?php foreach ($field['values'] as $value): ?>
                <option value="<?php echo $value['idx']; ?>"
                    <?php
                    if (
                        isset($_GET[$field['name']])
                        &&
                        $_GET[$field['name']] == $value['idx']
                    ) {
                        echo 'selected="selected"';
                    }
                    ?>
                    >
                    <?php echo $value['display']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php
}

function display_checkboxes($field) {
    ?>
    <?php foreach ($field['values'] as $value): ?>
        <?php if (
            $field['name'] != 'details_decorations_allowed'
            ||
            ! in_array($value['display'], ['Can bring own', 'Can hang from walls/ceiling'])
        ):
            if ($field['name'] == "ceremony_site_types" &&
                (
                    $value['display'] == 'Hall' ||
                    $value['display'] == 'Marquee' ||
                    $value['display'] == 'Garden' ||
                    $value['display'] == 'Restaurant' ||
                    $value['display'] == 'Courtyard'
                )
            ) {
                continue;
            }
            ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="<?php echo $field['name']; ?>[]"
                        <?php
                        if (in_array($value['idx'], $_GET[$field['name']])) {
                            echo 'checked="checked"';
                        }
                        ?>
                           value="<?php echo $value['idx']; ?>"
                           onchange="jQuery('#refine-form').submit()"/>
                    <?php echo $value['display']; ?>
                </label>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php
}

function display_hidden($key) {
    global $my_filter_fields;
    $field = $my_filter_fields[$key];
    if (isset($_GET[$field['name']])):
        if ($field['is_checkbox']):
            foreach ($_GET[$field['name']] as $val):
                ?>
                <input type="hidden" name="<?php echo $field['name']; ?>[]"
                       value="<?php echo $val; ?>"/>
                <?php
            endforeach;
        else:
            ?>
            <input type="hidden" name="<?php echo $field['name']; ?>"
                   value="<?php echo $_GET[$field['name']]; ?>"/>
            <?php
        endif;
    endif;
}

// function display_field($key) {
//     global $my_filter_fields;
//     $field = $my_filter_fields[$key];
//     if ($field['is_checkbox']):
//         display_checkboxes($field);
//     else:
//         display_dropdown($field);
//     endif;
// }

function display_field($key, $replace = false, $replace_needle = [], $replace_with = []) {
    global $my_filter_fields;
    $field = $my_filter_fields[$key];
    if ($field['is_checkbox']):
        if ($replace == true) {
            display_checkboxes($field, $replace_needle, $replace_with);
        } else {
            display_checkboxes($field);
        }
    else:
        display_dropdown($field);
    endif;
}

?>
    <form method="GET" id="refine-form">
        <div class="javo-page-variable-area">
            <?php
            $javo_item_filter_taxonomies = @unserialize(get_post_meta(get_the_ID(), "javo_item_tax", true));
            $javo_item_filter_terms = @unserialize(get_post_meta(get_the_ID(), "javo_item_terms", true));
            $javo_item_defult_type = get_post_meta(get_the_ID(), "javo_item_listing_type", true);
            if ( ! empty($javo_item_filter_taxonomies)) {
                foreach ($javo_item_filter_taxonomies as $index => $tax) {
                    if ( ! empty($javo_item_filter_terms[$index]) && ! empty($tax)) {
                        printf("<input type='hidden' class='javo_filter' data-tax='%s' data-term='%s'>",
                            $tax, $javo_item_filter_terms[$index]);
                    };
                }
            }; ?>
            <input type="hidden" value="<?php echo ! empty($javo_item_defult_type) ? $javo_item_defult_type : 2; ?>"
                   data-javo-item-listing-default-type>
        </div>
        <div class="feature-bg search"
             style="background:url('/wp-content/themes/javo-directory-child-theme/assets/images/home-bg.jpg') no-repeat center center fixed;  -webkit-background-size: cover;  -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-attachment: fixed;">
            <div class="container">
                <div class="row margin-md">
                    <div class="col-xs-6">
                        <h2 class="margin-sm text-white">
                            <?php echo my_found_posts(); ?> matches
                        </h2>
                    </div>
                    <div class="col-xs-6">
                        <!-- Single button -->
                        <div class="pull-right margin-sm form-group">
                            <select name="sort"
                                    onchange="jQuery('#refine-form').submit()" class="form-control">
                                <?php foreach ($my_sort_params as $val => $name): ?>
                                    <option value="<?php echo $val; ?>"
                                        <?php
                                        if ($my_sortby == $val):
                                            echo 'selected="selected"';
                                        endif;
                                        ?>
                                        >
                                        Sort: <?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-list-page-wrap" id="main-content">
            <div class="container main-content-wrap">
                <div class="row">
                    <div class="col-sm-12 margin-sm new-search">
                        <h4>
                            <a href="/">
                                Start a New Search
                            </a>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 refine-search">
                        <?php display_hidden('about_name'); ?>
                        <?php display_hidden('holds'); ?>
                        <?php display_hidden('about_reception_type'); ?>
                        <?php display_hidden('search_has'); ?>
                        <div class="panel panel-default panel-relative">
                            <div class="section">
                                <h4 class="text-uppercase margin-none text-pink">Refine Your Search</h4>
                            </div>
                            <div class="section">
                                <h5 class="margin-none text-uppercase">
                                    <a data-toggle="collapse" href="#refine-costs" aria-expanded="false"
                                       aria-controls="refine-costs">
                                        Costs <i class="fa fa-plus-circle pull-right"></i>
                                    </a>
                                </h5>

                                <div class="collapse" id="refine-costs">
                                    <h5>
                                        <strong>Food package pp:</strong>
                                    </h5>
                                    <?php display_field('food_minimum_food_package_cost_pp'); ?>
                                    <h5>
                                        <strong>Drinks package pp:</strong>
                                    </h5>
                                    <?php display_field('food_minimum_drinks_package_cost_pp'); ?>
                                    <h5>
                                        <strong>Venue hire cost:</strong>
                                    </h5>
                                    <?php display_field('about_venue_hire_cost'); ?>
                                    <h5>
                                        <strong>Ceremony site hire:</strong>
                                    </h5>
                                    <?php display_field('ceremony_minimum_site_hire'); ?>
                                    <h5>
                                        <strong>Accommodation (per room/pn):</strong>
                                    </h5>
                                    <?php display_field('accommodation_cheapest_room_rate'); ?>
                                </div>
                            </div>
                            <div class="section">
                                <h5 class="margin-none text-uppercase">
                                    <a data-toggle="collapse" href="#refine-need-to-know" aria-expanded="false"
                                       aria-controls="refine-need-to-know">
                                        Need to Know <i class="fa fa-plus-circle pull-right"></i>
                                    </a>
                                </h5>

                                <div class="collapse" id="refine-need-to-know">
                                    <h5>
                                        <strong>Food service:</strong>
                                    </h5>
                                    <?php display_field('search_food_service'); ?>
                                    <h5>
                                        <strong>Food extras:</strong>
                                    </h5>
                                    <?php display_field('search_food_extras'); ?>
                                    <h5>
                                        <strong>Decorations allowed:</strong>
                                    </h5>
                                    <?php display_field('details_decorations_allowed'); ?>
                                </div>
                            </div>
                            <div class="section">
                                <h5 class="margin-none text-uppercase">
                                    <a data-toggle="collapse" href="#refine-food" aria-expanded="false"
                                       aria-controls="refine-food">
                                        Ceremony <i class="fa fa-plus-circle pull-right"></i>
                                    </a>
                                </h5>

                                <div class="collapse" id="refine-food">
                                    <h5>
                                        <strong>Site type:</strong>
                                    </h5>
                                    <?php display_field('ceremony_site_types'); ?>
                                </div>
                            </div>
                            <div class="section">
                                <h5 class="margin-none text-uppercase">
                                    <a data-toggle="collapse" href="#refine-decorations" aria-expanded="false"
                                       aria-controls="refine-decorations">
                                        Accommodation <i class="fa fa-plus-circle pull-right"></i>
                                    </a>
                                </h5>

                                <div class="collapse" id="refine-decorations">
                                    <h5>
                                        <strong>Capacity:</strong>
                                    </h5>
                                    <?php display_field('accommodation_capacity'); ?>
                                    <h5>
                                        <strong>Features:</strong>
                                    </h5>
                                    <?php display_field('search_accommodation_features'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="margin-md-bottom">
                            <button id="reset-button" class="btn btn-default">
                                Reset Search
                            </button>
                            <script type="text/javascript">
                                jQuery(document).ready(function () {
                                    var options = {
                                        success: function (responseText) {
                                            var sels = [
                                                '.col-sm-9',
                                                '.margin-sm.text-white'
                                            ];
                                            var i;
                                            for (i = 0; i < sels.length; ++i) {
                                                var sel = sels[i];
                                                var elem = jQuery(responseText);
                                                jQuery(sel).replaceWith(jQuery(sel, elem));
                                            }
                                        }
                                    };
                                    jQuery('#refine-form').ajaxForm(options);
                                    jQuery('#reset-button').click(function () {
                                        location.reload();
                                    });
                                });
                            </script>
                        </div>
                        <div class="panel panel-default panel-relative hidden-xs">
                            <?php echo apply_filters('the_content', '[dd_lastviewed widget_id="2"]'); ?>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <?php
                        $i = 1;
                        echo '<div class="row">';
                        while (my_have_posts()) {
                            my_the_post();
                            $post_id = get_the_ID(); ?>
                            <div class="col-md-4 col-sm-6 col-xs-12 pull-left search-results">
                                <div class="panel panel-default panel-relative">
                                    <?php
                                    $detail_images = (Array)@unserialize(get_post_meta(get_the_ID(), "detail_images", true));
                                    $detail_images[] = get_post_thumbnail_id(get_the_ID());
                                    if ( ! empty($detail_images)):
                                        echo '<div class="javo_detail_slide">';
                                        $javo_this_image_meta = wp_get_attachment_image_src($detail_images, 'large');
                                        $javo_this_image = $javo_this_image_meta[0];
                                        ?>

                                        <?php echo '<ul class="slides list list-unstyled">';
                                        foreach ($detail_images as $index => $image) {
                                            $javo_this_image_meta = wp_get_attachment_image_src($image, 'full');
                                            $javo_this_image = $javo_this_image_meta[0];
                                            ?>
                                            <li>
                                                <u href="<?php echo $javo_this_image; ?>" style="cursor:pointer;">
                                                    <?php echo wp_get_attachment_image($image, "javo-box-v", true); ?>
                                                </u>
                                            </li>
                                            <?php
                                        };
                                        echo '</ul>';
                                        echo '</div>';
                                    endif; ?>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="<?php the_permalink(); ?>" class="javo-tooltip javo-igl-title"
                                                   title="<?php the_title(); ?>">
                                                    <div>
                                                        <h2 class="panel-title text-center">
                                                            <strong> <?php echo javo_str_cut(get_the_title(), 120); ?> </strong>
                                                        </h2>

                                                        <div class="text-center truncate">
                                                            <?php $directory_meta = get_field('directory_meta');
                                                            echo($directory_meta['address']);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($i % 3 == 0) {
                                echo '</div><div class="row">';
                            }
                            $i++;
                        };
                        echo '</div>';
                        wp_reset_postdata();
                        ?>
                    </div>
                    <!-- <div class="col-sm-9">
                <?php var_dump(my_filters()); ?>
            </div> -->
                </div>
            </div>
        </div>
        <!-- item-list-page-wrap -->
    </form>

    <script type="text/template" id="javo-loading-html">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <img src="<?php echo JAVO_IMG_DIR . '/loading_2.gif'; ?>">
                </div>
            </div>
        </div>
    </script>
    <script type="text/javascript">
        jQuery(function ($) {
            "use strict";

            var javo_listings = {
                parametter: {}
                , options: {}
                , init: function () {
                    this.options.post_type = "item";
                    this.options.type = $('[data-javo-item-listing-default-type]').val();
                    this.options.page = 1;
                    this.options.ppp = 9;
                    this.output = $(".javo_output");
                    this.output.css('marginTop', '50px');
                    this.events();

                    if ($('.javo_filter').length > 0) {
                        $('.javo_filter').each(function () {
                            $('[data-category="' + $(this).data('tax') + '"]')
                                .val($(this).data('term'))
                                .prev()
                                .val($('li[data-filter][value="' + $(this).data('term') + '"]').text());
                        });
                    }
                    ;
                    this.run();
                }, run: function () {
                    var $object = this;

                    this.parametter.url = "<?php echo admin_url('admin-ajax.php');?>";
                    this.parametter.loading = "<?php echo JAVO_IMG_DIR;?>/loading_1.gif";
                    this.parametter.txtKeyword = $('.javo-listing-search-field');
                    this.parametter.btnSubmit = $('.javo-listing-submit');
                    this.parametter.param = this.options;
                    this.parametter.selFilter = $("[name^='filter']");
                    this.parametter.map = $(".javo_map_visible");
                    this.parametter.before_callback = function () {
                        $object.output.html($('#javo-loading-html').html());
                    };
                    this.parametter.success_callback = function () {
                        var i = 0;
                        $object.refresh();
                        while (i <= 6) {
                            $($object.output.find('.javo-animation').get(i)).addClass('loaded');
                            i++;
                        }
                        ;
                        $('.javo_detail_slide').each(function () {
                            $(this).flexslider({
                                animation: "slide",
                                controlNav: false,
                                slideshow: true,
                            }).find('ul').magnificPopup({
                                gallery: {enabled: true}
                                , delegate: 'u'
                                , type: 'image'
                            });
                        });
                        $('.javo-tooltip').each(function (i, e) {
                            var options = {};
                            if (typeof( $(this).data('direction') ) != 'undefined') {
                                options.placement = $(this).data('direction');
                            }
                            ;
                            $(this).tooltip(options);
                        });
                    };

                    this.output.javo_search(this.parametter);

                }, events: function () {
                    var $object = this;
                    $('body').on('click', '.toggle-full-mode', function () {

                        $(document).toggleClass('content-full-mode');

                    }).on('click', 'li[data-javo-hmap-ppp]', function () {

                        $object.options.ppp = $(this).data('value');
                        $object.run();

                    }).on('click', 'li[data-filter]', function () {
                        $object.parametter.selFilter = $("[name^='filter']");
                        $object.run();
                    }).on('change', '[name="javo_btn_item_list_type"]', function () {
                        $object.options.type = $(this).val();
                        $object.options.page = 1;
                        $object.run();
                    });
                    $('.javo-this-filter').each(function (c, v) {
                        var _this = $(this);
                        $(this).on('click', 'a', function () {
                            $(this).closest('.btn-group').children('button:first-child').children('a').text($(this).text());
                            $(this).closest('ul').next().val($(this).data('term'));

                            $object.parametter.selFilter = $("[name^='filter']");
                            $object.run();
                        });
                    });
                }, refresh: function () {
                    $('.javo-rating-registed-score').each(function (k, v) {
                        $(this).raty({
                            starOff: '<?php echo JAVO_IMG_DIR?>/star-off-s.png'
                            , starOn: '<?php echo JAVO_IMG_DIR?>/star-on-s.png'
                            , starHalf: '<?php echo JAVO_IMG_DIR?>/star-half-s.png'
                            , half: true
                            , readOnly: true
                            , score: $(this).data('score')
                        }).css('width', '');
                    });
                }
            };
            javo_listings.init();

            $('.collapse').on('show.bs.collapse', function () {
                $(this).parent('.section').find('.fa').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            })

            $('.collapse').on('hide.bs.collapse', function () {
                $(this).parent('.section').find('.fa').removeClass('fa-minus-circle').addClass('fa-plus-circle');
            })
        });
    </script>
<?php get_footer();
