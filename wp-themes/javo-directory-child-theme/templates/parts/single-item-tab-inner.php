<?php
$javo_directory_query = new javo_get_meta(get_the_ID());
$javo_rating = new javo_Rating(get_the_ID());
global
$javo_custom_field
, $post
, $javo_custom_item_label
, $javo_custom_item_tab
, $javo_tso;
$javo_this_author = get_userdata($post->post_author);
$javo_this_author_avatar_id = get_user_meta($javo_this_author->ID, 'avatar', true);
$javo_directory_query = new javo_get_meta(get_the_ID());
$javo_rating = new javo_Rating(get_the_ID());
?>

<style>
    /** item tabs **/
    .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
        background: rgba(0, 0, 0, 0);
        border-radius: 0px;
    }

    .single-item-tab #single-tabs li.active {
        background: #0083db;
        border-top: 1px #0083db solid;
        border-bottom: 1px #0083db solid;
    }

    .single-item-tab ul#single-tabs {
        border-left: 1px #ddd solid;
        border-right: 1px #ddd solid;
    }

    .single-item-tab .nav > li > a:hover {
        border-radius: 0;
        background: #fff;
        color: #0083db;
    }

    .single-item-tab .nav > li.active > a:hover {
        background: #0083db;
        color: #fff !important;
    }

    ul#single-tabs li.active {
        background: <?php echo $javo_tso->get('total_button_color');?> !important;
        border-color: <?php echo $javo_tso->get('total_button_color');?> !important;
    }

    ul#single-tabs li.active a:hover {
        color: #ddd !important;
        background: <?php echo $javo_tso->get('total_button_color');?> !important;
    }

    ul#single-tabs li a:hover {
        color: <?php echo $javo_tso->get('total_button_color');?> !important;
    }
</style>
<div class="row">
    <div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1  margin-lg-top">
        <?php if (the_content()) : ?>
            <?php the_content(); ?>
        <?php endif; ?>
    </div>
</div>
<section class="contact margin-lg-top">
    <div class="row">
        <div class="col-sm-8">
            <ul class="list-inline">
                <?php $directory_meta = get_field('directory_meta'); ?>
                <li>
                    <h5>
                        <a href="<?php if (strpos($directory_meta['website'], "http") !== true) {
                            echo $directory_meta['website'];
                        } ?>" target="_blank"><?php echo($directory_meta['website']); ?></a>
                    </h5>
                </li>
                <li>
                    &middot;
                </li>
                <li>
                    <h5>
                        <a href="tel:<?php echo($directory_meta['phone']); ?>">
                            <?php echo($directory_meta['phone']); ?>
                        </a>
                    </h5>
                </li>
                <li>
                    &middot;
                </li>
                <li>
                    <h5>
                        <a href="mailto:<?php echo($directory_meta['email']); ?>"><?php echo($directory_meta['email']); ?></a>
                    </h5>
                </li>
            </ul>
        </div>
        <div class="col-sm-4">
            <ul class="list-inline pull-right flip-left">
                <?php if (get_field('about_facebook_page_name') != '') : ?>
                    <li class="social">
                        <a href="<?php echo get_field('about_facebook_page_name') ?>" target="_blank"
                           class="social-media-icon facebook">
                            <i class="fa fa-facebook fa-lg fa-fw text-white"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('about_twitter_handle') != '') : ?>
                    <li class="social">
                        <a href="<?php echo get_field('about_twitter_handle') ?>" target="_blank"
                           class="social-media-icon twitter">
                            <i class="fa fa-twitter fa-lg fa-fw text-white"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('about_pinterest_details') != '') : ?>
                    <li class="social">
                        <a href="<?php echo get_field('about_pinterest_details') ?>" target="_blank"
                           class="social-media-icon pinterest">
                            <i class="fa fa-pinterest fa-lg fa-fw text-white"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('about_instagram_details') != '') : ?>
                    <li class="social">
                        <a href="<?php echo get_field('about_instagram_details') ?>" target="_blank"
                           class="social-media-icon instagram">
                            <i class="fa fa-instagram fa-lg fa-fw text-white"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>
<div class="visible-xs">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group mobile-tabs">
                <button class="btn btn-mobile-venue dropdown-toggle btn-block" type="button" data-toggle="dropdown">
                    <span class="active-tab">Quick Facts</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu mobile-menu" role="menu">
                    <li class="active js-facts">
                        <a href="#single-tab-facts">
                            Quick Facts
                        </a>
                    </li>
                    <li class="js-about">
                        <a href="#single-tab-about">
                            About
                        </a>
                    </li>
                    <?php if ( ! in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))) : ?>
                        <li class="js-food">
                            <a href="#single-tab-food">
                                Food &amp; Drink
                            </a>
                        </li>
                        <li class="js-rooms">
                            <a href="#single-tab-rooms">
                                Rooms &amp; Decorations
                            </a>
                        </li>
                    <?php endif;
                    if (in_array("On-site ceremony venue", get_field('about_need_to_know'))) :?>
                        <li class="js-ceremony">
                            <a href="#single-tab-ceremony">
                                Ceremony
                            </a>
                        </li>
                    <?php endif;
                    if (in_array("On-site accommodation", get_field('about_need_to_know'))) :?>
                        <li class="js-accomodation">
                            <a href="#single-tab-accomodation">
                                Accomodation
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mobile-content" id="mobile-content">
        <div class="col-sm-12 clearfix">
            <div class="tab-content">
            </div>
        </div>
    </div>
</div>
<div class="tabs-wrap hidden-xs">
    <ul id="single-tabs" class="nav nav-pills nav-justified" data-tabs="single-tabs">
        <li class="active tab-about">
            <a href="#single-tab-about" data-toggle="tab">
                About
            </a>
        </li>
        <?php if ( ! in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))) : ?>
            <li class="tab-food">
                <a href="#single-tab-food" data-toggle="tab">
                    Food &amp; Drink
                </a>
            </li>
            <li class="tab-rooms">
                <a href="#single-tab-rooms" data-toggle="tab">
                    Rooms &amp; Decorations
                </a>
            </li>
        <?php endif;
        if (in_array("On-site ceremony venue", get_field('about_need_to_know'))) :?>
            <li class="tab-ceremony">
                <a href="#single-tab-ceremony" data-toggle="tab">
                    Ceremony
                </a>
            </li>
        <?php endif;
        if (in_array("On-site accommodation", get_field('about_need_to_know'))) :?>
            <li class="tab-accomodation">
                <a href="#single-tab-accomodation" data-toggle="tab">
                    Accomodation
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <div id="javo-single-tab" class="tab-content clearfix">
        <div class="tab-pane active clearfix" id="single-tab-about">
            <section class="section">
                <div class="row clearfix">
                    <div class="col-sm-4 margin-sm-bottom">
                        <div class="block">
                            <h4>Vibe</h4>
                            <?php
                            if (count(get_field('about_look_feel'))) {
                                echo "<ul>";
                                foreach (get_field('about_look_feel') as $item) {
                                    echo "<li>$item</li>";
                                }
                                echo "</ul>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4 margin-sm-bottom">
                        <div class="block">
                            <h4>Views</h4>
                            <?php
                            if (count(get_field('about_scenery'))) {
                                echo "<ul>";
                                foreach (get_field('about_scenery') as $item) {
                                    echo "<li>$item</li>";
                                }
                                echo "</ul>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4 margin-sm-bottom">
                        <div class="block">
                            <h4>Known For</h4>
                            <?php
                            if (count(get_field('about_known_for'))) {
                                echo "<ul>";
                                foreach (get_field('about_known_for') as $item) {
                                    echo "<li>$item</li>";
                                }
                                echo "</ul>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php if ( ! in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))) : ?>
                <section class="section">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>
                                <span>
                                    Need to Know
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <table cellpadding="0" cellspacing="0">
                                <thead>
                                <tr>
                                    <th colspan="3" class="highlight">
                                        <h3>
                                            Reception Type
                                        </h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="width-50"></th>
                                    <th class="width-25">Seated</th>
                                    <th class="width-25">Cocktail</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $about_reception_type = get_field('reception_type_checkboxes');

                                $DaytimeSeated = "Seated - Daytime";
                                $EveningSeated = "Seated - Evening";
                                $IndoorSeated = "Seated - Indoor";
                                $OutdoorSeated = "Seated - Outdoor";
                                $DaytimeCocktail = "Cocktail - Daytime";
                                $EveningCocktail = "Cocktail - Evening";
                                $IndoorCocktail = "Cocktail - Indoor";
                                $OutdoorCocktail = "Cocktail - Outdoor";
                                $tick = '<span class="tick icon-inline"></span>';
                                $no = '<span class="no icon-inline"></span>';
                                ?>
                                <tr>
                                    <td class="highlight width-50">Daytime</td>
                                    <td class="text-center width-25">
                                        <?php if (in_array($DaytimeSeated, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                    <td class="text-center width-25">
                                        <?php if (in_array($DaytimeCocktail, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="highlight">Evening</td>
                                    <td class="text-center">
                                        <?php if (in_array($EveningSeated, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (in_array($EveningCocktail, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="highlight">Indoor</td>
                                    <td class="text-center">
                                        <?php if (in_array($IndoorSeated, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (in_array($IndoorCocktail, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="highlight">Outdoor</td>
                                    <td class="text-center">
                                        <?php if (in_array($OutdoorSeated, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (in_array($OutdoorCocktail, $about_reception_type)) {
                                            echo $tick;
                                        } else {
                                            echo $no;
                                        } ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table cellpadding="0" cellspacing="0">
                                <thead>
                                <tr>
                                    <th colspan="3" class="highlight">
                                        <h3>
                                            Guest Numbers
                                        </h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="width-50"></th>
                                    <th class="width-25">Seated</th>
                                    <th class="width-25">Cocktail</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="highlight">Minimum Weekend</td>
                                    <td>
                                        <?php echo get_field('about_minimum_seated_weekend'); ?>
                                    </td>
                                    <td>
                                        <?php echo get_field('about_minimum_cocktail_weekend'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="highlight">Minimum Mid-Week</td>
                                    <td>
                                        <?php echo get_field('about_minimum_seated_mid_week'); ?>
                                    </td>
                                    <td>
                                        <?php echo get_field('about_minimum_cocktail_mid_week'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="highlight">Capacity</td>
                                    <td>
                                        <?php echo get_field('about_maximum_seated'); ?>
                                    </td>
                                    <td>
                                        <?php echo get_field('about_maximum_cocktail'); ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table cellpadding="0" cellspacing="0" id="VenueCosts">
                                <thead>
                                <tr>
                                    <th colspan="2" class="highlight">
                                        <h3>
                                            Venue Hire Costs
                                        </h3>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="2" class="center">
                                        <?php echo get_field('about_venue_hire_duration_display'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="width-50"><?php echo get_field('about_venue_hire_cost_display') ?> Room
                                        Hire
                                    </td>
                                    <td class="width-50"><?php echo get_field('about_venue_hire_extension_display') ?>
                                        /hour Extension
                                    </td>
                                </tr>
                                <tr>
                                    <td class="width-50"><?php
                                        $depositReq = get_field('about_deposit_needed_display');
                                        if ($depositReq) {
                                            echo $depositReq . ' Deposit';
                                        } else {
                                            echo 'No Deposit Required';
                                        }
                                        ?>
                                    </td>
                                    <td class="width-50">
                                        <?
                                        $about_minimum_spend = get_field('about_minimum_spend');
                                        if ($about_minimum_spend == "Yes"): ?>
                                            Minimum spend required
                                        <?php elseif ($about_minimum_spend == "No"): ?>
                                            No minimum spend
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <thead>
                            <tr>
                                <th class="highlight">
                                    <h3>
                                        What's Included?
                                    </h3>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $about_support = get_field('about_support');

                            $weddingcoordinator = in_array('Wedding Coordinator', $about_support) ? 'yes' : 'no';
                            $inhousedecorator = in_array('In-house Decorator', $about_support) ? 'yes' : 'no';
                            $receptionvenue = in_array('Sets up reception venue', $about_support) ? 'yes' : 'no';
                            $ceremonysite = in_array('Sets up ceremony site', $about_support) ? 'yes' : 'no';
                            $vendorrecommendations = in_array('Provides vendor recommendations', $about_support) ? 'yes' : 'no';
                            $venderdiscounts = in_array('Negotiates vendor discounts', $about_support) ? 'yes' : 'no';
                            $arrangestransport = in_array('Arranges transport', $about_support) ? 'yes' : 'no';
                            $arrangesaccomodation = in_array('Arranges accommodation', $about_support) ? 'yes' : 'no';

                            ?>
                            <tr>
                                <td>
                                    <ul class="list-unstyled">
                                        <li>
                                            <span class="<?php echo $weddingcoordinator; ?> icon-inline "></span>
                                            On-site Wedding Coordinator
                                        </li>
                                        <li>
                                            <span class="<?php echo $inhousedecorator; ?> icon-inline "></span> In-house
                                            Decorator
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Venue Can:</h5>
                                    <ul class="list-unstyled">
                                        <li>
                                            <span class="<?php echo $receptionvenue; ?> icon-inline "></span> Set up
                                            reception venue
                                        </li>
                                        <li>
                                            <span class="<?php echo $ceremonysite; ?> icon-inline "></span> Set up
                                            ceremony site
                                        </li>
                                        <li>
                                            <span class="<?php echo $vendorrecommendations; ?> icon-inline "></span>
                                            Provide vendor recommendations
                                        </li>
                                        <li>
                                            <span class="<?php echo $venderdiscounts; ?> icon-inline "></span> Negotiate
                                            vendor discounts
                                        </li>
                                        <li>
                                            <span class="<?php echo $arrangestransport; ?> icon-inline "></span> Arrange
                                            transport
                                        </li>
                                        <li>
                                            <span class="<?php echo $arrangesaccomodation; ?> icon-inline "></span>
                                            Arrange accommodation
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="venue">
                            <thead>
                            <tr>
                                <th class="highlight">
                                    <h3>
                                        Venue Features
                                    </h3>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <?php
                                    if (count(get_field('about_venue_features'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('about_venue_features') as $item) {

                                            $venueFeaturesClass = "";
                                            if (strpos($item, 'Helipad') !== false) {
                                                $venueFeaturesClass = "helipad";
                                            } elseif (strpos($item, 'On-site parking') !== false) {
                                                $venueFeaturesClass = "parking";
                                            } elseif (strpos($item, 'Has extra/outdoor breakout spaces') !== false) {
                                                $venueFeaturesClass = "breakout";
                                            } elseif (strpos($item, 'Gift storage space') !== false) {
                                                $venueFeaturesClass = "storage";
                                            } elseif (strpos($item, 'Bridal party relaxation space') !== false) {
                                                $venueFeaturesClass = "relax";
                                            } elseif (strpos($item, 'Marquee') !== false) {
                                                $venueFeaturesClass = "marquee";
                                            } elseif (strpos($item, 'Can set up day before') !== false) {
                                                $venueFeaturesClass = "yes";
                                            } elseif (strpos($item, 'No photographer/videographer restrictions') !== false) {
                                                $venueFeaturesClass = "yes";
                                            } elseif (strpos($item, 'Lawn games') !== false) {
                                                $venueFeaturesClass = "lawn";
                                            }

                                            echo "<li class='" . $venueFeaturesClass . "'>$item</li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <?php if (get_field('about_text') != '') : ?>
                <section class="fw">
                    <h2>
                    <span>
                        Tell Me More
                    </span>
                    </h2>
                    <table cellpadding="0" cellspacing="0" class="min">
                        <tbody>
                        <tr>
                            <td>
                                <div class="more-less">
                                    <div class="more-block">
                                        <div id="about_text" class="text-block">
                                            <?php echo get_field('about_text'); ?>
                                        </div>
                                    </div>
                                    <a href="#" class="more">
                                        <span>+ More</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>
            <?php if ( ! in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))) : ?>
                <?php if (get_field('about_awards_description')) : ?>
                    <section class="fw">
                        <h2><span>Awards</span></h2>
                        <table cellpadding="0" cellspacing="0" class="min text-block">
                            <tbody>
                            <tr>
                                <td><?php echo get_field('about_awards_description'); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                <?php endif; endif; ?>
            <?php if (get_field('about_description') != '') : ?>
                <section class="fw">
                    <h2>
                    <span>
                        Unique Features
                    </span>
                    </h2>
                    <table cellpadding="0" cellspacing="0" class="min text-block">
                        <tbody>
                        <tr>
                            <td colspan="3">
                                <?php echo get_field('about_description'); ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>
        </div>

        <div class="tab-pane clearfix" id="single-tab-food">
            <section>
                <h2>
                    <span>Description</span>
                </h2>
                <table>
                    <tr>
                        <td>
                            <div class="more-less">
                                <div class="more-block">
                                    <div id="food_text" class="text-block"><?php echo get_field('food_text'); ?></div>
                                </div>
                                <a href="#" class="more"><span>+ More</span></a>
                            </div>
                        </td>
                    </tr>
                </table>
            </section>
            <?php
            if (in_array('Self-catering/external catering required', get_field('food_food_service_options'))) {
            } else {
                ?>
                <?php if (get_field('food_canapes') || get_field('food_entrees') || get_field('food_mains') || get_field('food_sides') || get_field('food_desserts') || get_field('food_childrens') || get_field('food_bbq') || get_field('food_buffet')): ?>
                    <section>
                        <h2><span>Menus</span></h2>

                        <div class="accordion">
                            <?php
                            function display_food_menu($field_name, $title) {
                                $value = get_field($field_name);
                                $actual_content = trim(strip_tags($value));
                                if ($actual_content) {
                                    ?>
                                    <div class="dt package-option">
                                    <div class="dcap accordion-toggle">
                                        <?php echo $title; ?>
                                    </div>
                                    <div class="dr accordion-content">
                                        <?php echo $value; ?>
                                    </div>
                                    </div><?php
                                }
                            }

                            ?>
                            <?php display_food_menu('food_canapes', 'Canap&eacute;s'); ?>
                            <?php display_food_menu('food_entrees', 'Entrees'); ?>
                            <?php display_food_menu('food_mains', 'Mains'); ?>
                            <?php display_food_menu('food_sides', 'Sides'); ?>
                            <?php display_food_menu('food_desserts', 'Desserts'); ?>
                            <?php display_food_menu('food_childrens', 'Children\'s'); ?>
                            <?php display_food_menu('food_bbq', 'BBQ'); ?>
                            <?php display_food_menu('food_buffet', 'Buffet'); ?>
                        </div>
                    </section>
                <?php endif; ?>
                <?php if (get_field('food_cusine') || get_field('food_waitstaff_to_guest_ratio_display') || get_field('food_food_package_inclusions') ||
                    get_field('food_kids_meals_included') || get_field('food_vendor_meals_included') || get_field('food_food_package_extras') || get_field('food_kids_meals_cost_pp')
                    || get_field('food_vendor_meals_cost_pp') || get_field('food_cake') || get_field('food_package_name_1')
                ): ?>
                    <section class="fw">
                        <h2><span>Food packages and costs</span></h2>
                        <table cellpadding="0" cellspacing="0" class="min text-block">
                            <tbody>
                            <?php if (get_field('food_cusine')): ?>
                                <tr>
                                    <td class="highlight width-25">Cuisine</td>
                                    <td class="width-75">
                                        <?php
                                        if (count(get_field('food_cuisine'))) {
                                            echo "<ul>";
                                            foreach (get_field('food_cuisine') as $item) {
                                                echo "<li>$item</li>";
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (get_field('food_waitstaff_to_guest_ratio_display')): ?>
                                <tr>
                                    <td class="highlight width-25">Waiters</td>
                                    <td class="width-75">
                                        <?php echo get_field('food_waitstaff_to_guest_ratio_display') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (get_field('food_food_package_inclusions') || get_field('food_kids_meals_included') || get_field('food_vendor_meals_included')): ?>
                                <tr>
                                    <td class="highlight width-25">What's included?</td>
                                    <td class="width-75">
                                        <?php
                                        if (count(get_field('food_food_package_inclusions'))) {
                                            echo "<ul>";
                                            foreach (get_field('food_food_package_inclusions') as $item) {
                                                if ($item == "Kids' meals") {
                                                    echo "<li>" . $item;
                                                    if (get_field('food_kids_meals_included')) {
                                                        echo ' (' . get_field('food_kids_meals_included') . ')';
                                                    }
                                                    echo "</li>";
                                                } elseif ($item == "Vendor meals") {
                                                    echo "<li>" . $item;
                                                    if (get_field('food_vendor_meals_included')) {
                                                        echo ' (' . get_field('food_vendor_meals_included') . ')';
                                                    }
                                                    echo "</li>";
                                                } else {
                                                    echo "<li>$item</li>";
                                                }
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (get_field('food_food_package_extras')): ?>
                                <tr>
                                    <td class="highlight width-25">Extras</td>
                                    <td class="width-75">
                                        <?php
                                        if (count(get_field('food_food_package_extras'))) {
                                            echo "<ul>";
                                            foreach (get_field('food_food_package_extras') as $item) {
                                                echo "<li>$item</li>";
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (get_field('food_kids_meals_cost_pp')): ?>
                                <tr>
                                    <td class="highlight width-25">Kids meal cost pp</td>
                                    <td class="width-75">
                                        $<?php echo get_field('food_kids_meals_cost_pp') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (get_field('teenager_meal_cost_pp_display')): ?>
                                <tr>
                                    <td class="highlight width-25">Teenager meal cost pp</td>
                                    <td class="width-75">
                                        <?php echo get_field('teenager_meal_cost_pp_display') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (get_field('food_vendor_meals_cost_pp')): ?>
                                <tr>
                                    <td class="highlight width-25">Vendor meal cost pp</td>
                                    <td class="width-75">
                                        <?php echo get_field('food_vendor_meals_cost_pp') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (get_field('food_cake')): ?>
                                <tr>
                                    <td class="highlight center width-25">
                                        <img src="<?php echo get_template_directory_uri(); ?>/icons/cake2.png" alt=""/>
                                    </td>
                                    <td class="width-75">
                                        <?php
                                        if (count(get_field('food_cake'))) {
                                            echo "<ul>";
                                            foreach (get_field('food_cake') as $item) {
                                                echo "<li>$item</li>";
                                            }
                                            echo "</ul>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if (get_field('food_package_name_1')): ?>
                            <div class="margin-md-bottom">
                                <h3 class="text-green">Food Packages</h3>

                                <div class="accordion">
                                    <?php
                                    function clean($string) {
                                        $string = str_replace(' ', '', $string);
                                        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

                                        return $string;
                                    }

                                    for ($i = 1; $i <= 15; $i++): ?>
                                        <?php ${'food_package_name_' . $i} = get_field('food_package_name_' . $i);
                                        ${'food_package_lightbox_' . $i} = get_field('food_package_lightbox_' . $i);
                                        ${'food_package_cost_' . $i} = get_field('food_package_cost_' . $i);
                                        ${'food_package_pre_dinner_canapes_' . $i} = get_field('food_package_pre_dinner_canapes_' . $i);
                                        ${'food_package_entrees_' . $i} = get_field('food_package_entrees_' . $i);
                                        ${'food_package_mains_' . $i} = get_field('food_package_mains_' . $i);
                                        ${'food_package_sides_' . $i} = get_field('food_package_sides_' . $i);
                                        ${'food_package_includes_' . $i} = get_field('food_package_includes_' . $i);
                                        ${'food_package_desserts_' . $i} = get_field('food_package_desserts_' . $i);
                                        ${'food_package_wedding_cake_' . $i} = get_field('food_package_wedding_cake_' . $i);
                                        ${'food_package_time_of_day_' . $i} = get_field('food_package_time_of_day_' . $i);
                                        ${'food_package_style_' . $i} = get_field('food_package_style_' . $i);
                                        ${'food_package_guest_numbers_' . $i} = get_field('food_package_guest_numbers_' . $i);
                                        ${'food_package_upgrade_' . $i} = get_field('food_package_upgrade_' . $i);
                                        ${'food_package_number_of_courses_' . $i} = get_field('food_package_number_of_courses_' . $i); ?>

                                        <?php if ( ! empty(${'food_package_name_' . $i})): ?>
                                            <div class="dt package-option">
                                                <div class="dcap accordion-toggle">
                                                    <div class="row">
                                                        <div class="col-xs-6 text-left">
                                                            <h3><?php echo ${'food_package_name_' . $i} ?></h3>
                                                        </div>
                                                        <div class="col-xs-6 text-right">
                                                            <h3><?php echo ${'food_package_cost_' . $i} ?><sup>pp</sup>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dr accordion-content">
                                                    <table cellpadding="0" cellspacing="0">
                                                        <thead>
                                                        <tr>
                                                            <th>Style</th>
                                                            <th>Number of courses</th>
                                                            <th>Guest Numbers</th>
                                                            <th>Time of day</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><?php echo ${'food_package_style_' . $i} ?></td>
                                                            <td><?php echo ${'food_package_number_of_courses_' . $i} ?></td>
                                                            <td><?php echo ${'food_package_guest_numbers_' . $i} ?></td>
                                                            <td><?php foreach (${'food_package_time_of_day_' . $i} as $value) {
                                                                    if ($value === end(${'food_package_time_of_day_' . $i})) {
                                                                        echo $value;
                                                                        continue;
                                                                    }
                                                                    echo $value, ", ";
                                                                } ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?php echo ${'food_package_lightbox_' . $i} ?>
                                                </div>
                                            </div>
                                        <?php endif; endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>
                <?php if (get_field('food_drinks_package_options') || get_field('food_drink_package_name_1')): ?>
                    <section class="fw">
                        <h2>
                        <span>
                            Drinks Packages and Costs
                        </span>
                        </h2>
                        <?
                        $food_drinks_package_options = get_field('food_drinks_package_options');
                        $how_its_charged = ["Charged per head", "Charged on consumption"];
                        $whats_included = ["Complimentary wine tasting", "Complimentary soft drinks/juice", "Complimentary sparkling wine for toast"];
                        $drink_options = ["BYO allowed", "Can upgrade", "Can extend", "Private bar"];
                        ?>
                        <table cellpadding="0" cellspacing="0" class="min text-block">
                            <tbody>
                            <?php if (is_array($food_drinks_package_options) && array_intersect($how_its_charged, $food_drinks_package_options)): ?>
                                <tr>
                                    <td class="highlight width-25">How's it charged?</td>
                                    <td class="width-75">
                                        <?php echo "<ul>";
                                        foreach (array_intersect($food_drinks_package_options, $how_its_charged) as $item) {
                                            echo '<li>', $item, '</li>';
                                        }
                                        echo "</ul>";
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (is_array($food_drinks_package_options) && array_intersect($whats_included, $food_drinks_package_options)): ?>
                                <tr>
                                    <td class="highlight width-25">What's included?</td>
                                    <td class="width-75">
                                        <?php echo "<ul>";
                                        foreach (array_intersect($food_drinks_package_options, $whats_included) as $item) {
                                            echo '<li>', $item, '</li>';
                                        }
                                        echo "</ul>";
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (is_array($food_drinks_package_options) && array_intersect($drink_options, $food_drinks_package_options)): ?>
                                <tr>
                                    <td class="highlight width-25">Options</td>
                                    <td class="width-75">
                                        <?php echo "<ul>";
                                        foreach (array_intersect($food_drinks_package_options, $drink_options) as $item) {
                                            echo '<li>', $item, '</li>';
                                        }
                                        echo "</ul>";
                                        ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if (get_field('food_drink_package_name_1')): ?>
                            <div class="margin-md-bottom">
                                <h3 class="text-green">Drinks Packages</h3>

                                <div class="accordion">
                                    <?php for ($i = 1; $i <= 15; $i++): ?>
                                        <?php ${'food_drink_package_name_' . $i} = get_field('food_drink_package_name_' . $i);
                                        ${'food_drink_package_cost_' . $i} = get_field('food_drink_package_cost_' . $i);
                                        ${'food_drink_package_duration_' . $i} = get_field('food_drink_package_duration_' . $i);
                                        ${'food_drink_package_upgrades_' . $i} = get_field('food_drink_package_upgrades_' . $i);
                                        ${'food_drink_package_extend_' . $i} = get_field('food_drink_package_extend_' . $i);
                                        ${'food_drink_package_lightbox_' . $i} = get_field('food_drink_package_lightbox_' . $i); ?>
                                        <?php if ( ! empty(${'food_drink_package_name_' . $i})): ?>
                                            <div class="dt package-option">
                                                <div class="dcap accordion-toggle">
                                                    <div class="row">
                                                        <div class="col-xs-6 text-left">
                                                            <h3><?php echo ${'food_drink_package_name_' . $i} ?></h3>
                                                        </div>
                                                        <div class="col-xs-6 text-right">
                                                            <h3><?php echo ${'food_drink_package_cost_' . $i} ?>
                                                                <sup>pp</sup></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dr accordion-content">
                                                    <?php echo ${'food_drink_package_lightbox_' . $i} ?>
                                                </div>
                                            </div>
                                        <?php endif; endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </section>
                <?php endif; ?>
            <?php } ?>
        </div>
        <div class="tab-pane clearfix" id="single-tab-rooms">
            <?php if (get_field('details_text')): ?>
                <section>
                    <h2><span>Description</span></h2>
                    <table cellpadding="0" cellspacing="0" class="min">
                        <tbody>
                        <tr>
                            <td>
                                <div class="more-less">
                                    <div class="more-block">
                                        <div id="details_text"
                                             class="text-block"><?php echo get_field('details_text') ?></div>
                                    </div>
                                    <a href="#" class="more"><span>+ More</span></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>
            <?php if (get_field('details_room_name_1')) : ?>
                <section class="fw">
                    <h2><span>Room Details</span></h2>

                    <div class="accordion">
                        <?php
                        for ($i = 1; $i <= 15; $i++) {

                            ${'details_room_name_' . $i} = get_field('details_room_name_' . $i);
                            ${'details_room_photo_' . $i} = get_field('details_room_photo_' . $i);
                            ${'details_room_capacity_seated_' . $i} = get_field('details_room_capacity_seated_' . $i);
                            ${'details_room_capacity_cocktail_' . $i} = get_field('details_room_capacity_cocktail_' . $i);
                            ${'details_room_hire_cost_' . $i} = get_field('details_room_hire_cost_' . $i);
                            ${'details_room_hire_time_' . $i} = get_field('details_room_hire_time_' . $i);
                            ${'details_room_hire_extension_' . $i} = get_field('details_room_hire_extension_' . $i);
                            ${'details_room_information_' . $i} = get_field('details_room_information_' . $i);

                            if ( ! empty(${'details_room_name_' . $i})) {
                                echo '<div class="dt package-option"><div class="dcap accordion-toggle">' . ${'details_room_name_' . $i} . '</div><div class="dr accordion-content">';
                                echo '<table cellpadding="0" cellspacing="0" cellpadding="min">';
                                echo '<thead><tr><th>Capacity<br/>Seated</th><th>Capacity<br/>Cocktail</th><th>Hire Cost</th><th>Hire Time</th><th>Hire extension <small>(cost per hour)</small></th></tr></thead>';
                                echo '<tbody>';
                                echo '<tr>';
                                echo '<td>' . ${'details_room_capacity_seated_' . $i} . '</td>';
                                echo '<td>' . ${'details_room_capacity_cocktail_' . $i} . '</td>';
                                echo '<td>' . ${'details_room_hire_cost_' . $i} . '</td>';
                                echo '<td>' . ${'details_room_hire_time_' . $i} . '</td>';
                                echo '<td>' . ${'details_room_hire_extension_' . $i} . '</td>';
                                echo '</tr>';
                                if ( ! empty(${'details_room_information_' . $i})) {
                                    echo '<tr><td colspan="5">';
                                    echo '<div class="media">';
                                    if ( ! empty(${'details_room_photo_' . $i})) {
                                        echo '<div class="pull-right frame"><img src="' . ${'details_room_photo_' . $i}['sizes']['javo-box'] . '" class="img-responsive media-object"></div>';
                                    }
                                    echo '<div class="media-body text-block">' . ${'details_room_information_' . $i} . '</div>';
                                    echo '</div>';
                                    echo '</td></tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div></div>';
                            } else {
                                break;
                            }
                        }
                        ?>
                    </div>
                </section>
            <?php endif; ?>
            <section>
                <?php if (get_field('details_room_features') || get_field('details_decorations_allowed') || get_field('details_decorations_included_in_packages') || get_field('details_venue_will_set_up')): ?>
                    <h2><span>Need to Know</span></h2>
                <?php endif; ?>
                <?php if (get_field('details_room_features') || get_field('details_must_select_from_preferred_vendor_list') || get_field('details_reception_set_up_timing')): ?>
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th colspan="2" class="highlight"><h3>Room Details</h3></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $details_room_features = get_field('details_room_features');

                        $musicdancing = ['Dance floor', 'Space for a DJ', 'Space for a band', 'Sound system an iPod'];
                        $speeches = ['A/V equipment for slideshows/videos', 'Stage', 'Microphone/PA system for speeches'];
                        $features = ['Back up power supply', 'Special lighting', 'Heating', 'airconditioning'];
                        ?>
                        <?php if (is_array($details_room_features) && array_intersect($musicdancing, $details_room_features)): ?>
                            <tr>
                                <td class="highlight width-25">Music/dancing</td>
                                <td class="width-75">
                                    <?php
                                    if (count(get_field('details_room_features'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('details_room_features') as $item) {

                                            $musicClass = "";
                                            if (strpos($item, 'Dance floor') !== false) {
                                                $musicClass = "dance-floor";
                                                echo "<li class='" . $musicClass . "'>$item</li>";
                                            } elseif (strpos($item, 'Space for a DJ') !== false) {
                                                $musicClass = "dj";
                                                echo "<li class='" . $musicClass . "'>$item</li>";
                                            } elseif (strpos($item, 'Space for a band') !== false) {
                                                $musicClass = "band";
                                                echo "<li class='" . $musicClass . "'>$item</li>";
                                            } elseif (strpos($item, 'Sound system an iPod') !== false) {
                                                $musicClass = "ipod";
                                                echo "<li class='" . $musicClass . "'>$item</li>";
                                            }
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (is_array($details_room_features) && array_intersect($speeches, $details_room_features)): ?>
                            <tr>
                                <td class="highlight">Speeches</td>
                                <td>
                                    <?php
                                    if (count(get_field('details_room_features'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('details_room_features') as $item) {

                                            $musicClass = "";
                                            if (strpos($item, 'A/V equipment for slideshows/videos') !== false) {
                                                $musicClass = "slideshow";
                                                echo "<li class='" . $musicClass . "'>$item</li>";
                                            } elseif (strpos($item, 'Stage') !== false) {
                                                $musicClass = "stage";
                                                echo "<li class='" . $musicClass . "'>$item</li>";
                                            } elseif (strpos($item, 'Microphone/PA system for speeches') !== false) {
                                                $musicClass = "mic";
                                                echo "<li class='" . $musicClass . "'>$item</li>";
                                            }
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if ((is_array($details_room_features) && array_intersect($features, $details_room_features)) || get_field('details_must_select_from_preferred_vendor_list') || get_field('details_reception_set_up_timing')): ?>
                            <tr>
                                <td class="highlight width-25">Features</td>
                                <td class="width-75">
                                    <ul class='icons'>
                                        <?php
                                        if (is_array($details_room_features) && array_intersect($features, $details_room_features)) {
                                            if (count(get_field('details_room_features'))) {
                                                foreach (get_field('details_room_features') as $item) {

                                                    $musicClass = "";
                                                    if (strpos($item, 'Back up power supply') !== false) {
                                                        $musicClass = "power";
                                                        echo "<li class='" . $musicClass . "'>$item</li>";
                                                    } elseif (strpos($item, 'Special lighting') !== false) {
                                                        $musicClass = "lighting";
                                                        echo "<li class='" . $musicClass . "'>$item</li>";
                                                    } elseif (strpos($item, 'Heating') !== false) {
                                                        $musicClass = "heating";
                                                        echo "<li class='" . $musicClass . "'>$item</li>";
                                                    } elseif (strpos($item, 'Airconditioning') !== false) {
                                                        $musicClass = "ac";
                                                        echo "<li class='" . $musicClass . "'>$item</li>";
                                                    }
                                                }
                                            }
                                        }
                                        if (get_field('details_must_select_from_preferred_vendor_list') == "No") {
                                            $musicClass = "yes";
                                            echo "<li class='" . $musicClass . "'>Can select own vendors</li>";
                                        } elseif (get_field('details_must_select_from_preferred_vendor_list') == "Yes") {
                                            $musicClass = "list";
                                            echo "<li class='" . $musicClass . "'>Must use preferred vendors</li>";
                                        }
                                        if (get_field('details_reception_set_up_timing')) {
                                            $musicClass = 'access time';
                                            echo "<li class='" . $musicClass . "'>Venue access - " . get_field('details_reception_set_up_timing') . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <?php if (get_field('details_tables') || get_field('details_chairs')): ?>
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="highlight" colspan="3">
                                <h3>Tables</h3>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $details_tables = (get_field('details_tables'));

                        $tableshape = ['Square', 'Round', 'Long/rectangle'];
                        $tablespeople = ['4 guests per table', '5 guests per table', '6 guests per table', '7 guests per table', '8 guests per table', '9 guests per table', '10 guests per table', '10+ guests per table'];
                        $tableslayout = ['Traditional (tables all around floor)', 'Horseshoe (tables in u shape facing head table/dance floor)', 'Hollow (tables connected into a square shape)', 'Row/Long banquet (tables arranged in parallel rows)', 'Sweetheart table available', 'Head table available', 'Gift/sign in table available'];
                        ?>
                        <?php if (is_array($details_tables) && array_intersect($tableshape, $details_tables)): ?>
                            <tr>
                                <td class="highlight width-25">Shape</td>
                                <td class="width-75" colspan="2">
                                    <?php if (in_array('Square', get_field('details_tables'))): ?>
                                        <img class="icon-sm"
                                             src="<?php echo get_template_directory_uri(); ?>/icons/square.png" alt=""/>
                                    <?php endif; ?>
                                    <?php if (in_array('Round', get_field('details_tables'))): ?>
                                        <img class="icon-sm"
                                             src="<?php echo get_template_directory_uri(); ?>/icons/circle.png" alt=""/>
                                    <?php endif; ?>
                                    <?php if (in_array('Long/rectangle', get_field('details_tables'))): ?>
                                        <img class="icon-sm"
                                             src="<?php echo get_template_directory_uri(); ?>/icons/rectangle.png"
                                             alt=""/>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (is_array($details_tables) && array_intersect($tablespeople, $details_tables)): ?>
                            <tr>
                                <td class="highlight width-25">
                                    <img class="icon-sm"
                                         src="<?php echo get_template_directory_uri(); ?>/icons/person1.png" alt=""/>
                                </td>
                                <td class="width-75" colspan="2"><?
                                    foreach (get_field('details_tables') as $item) {
                                        if (strpos($item, 'per table') !== false) {
                                            echo($item);
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (is_array($details_tables) && array_intersect($tableslayout, $details_tables)): ?>
                            <tr>
                                <td class="highlight width-25">Layout</td>
                                <td class="width-75" colspan="2">
                                    <?php
                                    if (count(get_field('details_tables'))) {
                                        echo "<ul>";
                                        foreach (get_field('details_tables') as $item) {
                                            $liClass;
                                            if (strpos($item, 'Long/rectangle') !== false || strpos($item, 'Round') !== false || strpos($item, 'Square') !== false || strpos($item, 'per table') !== false) {
                                                $liClass = "hidden";
                                            } else {
                                                echo "<li>$item</li>";
                                            }
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (get_field('details_chairs')): ?>
                            <tr>
                                <td class="highlight width-25">Chair type</td>
                                <td class="width-75" colspan="2">
                                    <?php
                                    if (count(get_field('details_chairs'))) {
                                        echo "<ul>";
                                        foreach (get_field('details_chairs') as $item) {
                                            echo "<li>$item</li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <?php if (get_field('details_decorations_allowed') || get_field('details_decorations_included_in_packages') || get_field('details_venue_will_set_up')): ?>
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="highlight" colspan="2">
                                <h3>Decorations</h3>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (get_field('details_decorations_allowed')): ?>
                            <tr>
                                <td class="highlight width-25">Decorations allowed</td>
                                <td class="width-75">
                                    <?php
                                    if (count(get_field('details_decorations_allowed'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('details_decorations_allowed') as $item) {

                                            $decorationsClass = "";
                                            if (strpos($item, 'Candles') !== false || strpos($item, 'Candles/candelabras') !== false) {
                                                $decorationsClass = "candles";
                                            } elseif (strpos($item, 'Fairy lights') !== false) {
                                                $decorationsClass = "lights";
                                            } elseif (strpos($item, 'Balloons') !== false) {
                                                $decorationsClass = "balloons";
                                            } elseif (strpos($item, 'Fireworks') !== false) {
                                                $decorationsClass = "fireworks";
                                            } elseif (strpos($item, 'Photo booth') !== false) {
                                                $decorationsClass = "photobooth";
                                            } elseif (strpos($item, 'Can hang from walls/ceiling') !== false) {
                                                $decorationsClass = "hang";
                                            } elseif (strpos($item, 'Cutlery, crockery, glassware') !== false) {
                                                $decorationsClass = "cutlery";
                                            } elseif (strpos($item, 'Linens & napkins') !== false) {
                                                $decorationsClass = "linens";
                                            } elseif (strpos($item, 'Chair covers/sashes') !== false) {
                                                $decorationsClass = "chairs";
                                            } elseif (strpos($item, 'Table arrangements') !== false) {
                                                $decorationsClass = "tablearr";
                                            } elseif (strpos($item, 'Bonbonnieres') !== false) {
                                                $decorationsClass = "bonbonnieres";
                                            } else {
                                                $decorationsClass = "yes";
                                            }

                                            echo "<li class='" . $decorationsClass . "'>$item</li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (get_field('details_decorations_included_in_packages')): ?>
                            <tr>
                                <td class="highlight width-25">Decorations included in packages</td>
                                <td class="width-75">
                                    <?php
                                    if (count(get_field('details_decorations_included_in_packages'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('details_decorations_included_in_packages') as $item) {
                                            $decorationsClass = "";
                                            if (strpos($item, 'Candles') !== false || strpos($item, 'Candles/candelabras') !== false) {
                                                $decorationsClass = "candles";
                                            } elseif (strpos($item, 'Fairy lights') !== false) {
                                                $decorationsClass = "lights";
                                            } elseif (strpos($item, 'Balloons') !== false) {
                                                $decorationsClass = "balloons";
                                            } elseif (strpos($item, 'Fireworks') !== false) {
                                                $decorationsClass = "fireworks";
                                            } elseif (strpos($item, 'Photo booth') !== false) {
                                                $decorationsClass = "photobooth";
                                            } elseif (strpos($item, 'Can hang from walls/ceiling') !== false) {
                                                $decorationsClass = "hang";
                                            } elseif (strpos($item, 'Cutlery, crockery, glassware') !== false) {
                                                $decorationsClass = "cutlery";
                                            } elseif (strpos($item, 'Linens & napkins') !== false) {
                                                $decorationsClass = "linens";
                                            } elseif (strpos($item, 'Chair covers/sashes') !== false) {
                                                $decorationsClass = "chairs";
                                            } elseif (strpos($item, 'Table arrangements') !== false) {
                                                $decorationsClass = "tablearr";
                                            } elseif (strpos($item, 'Bonbonnieres') !== false) {
                                                $decorationsClass = "bonbonnieres";
                                            } else {
                                                $decorationsClass = "yes";
                                            }
                                            echo "<li class='" . $decorationsClass . "'>$item</li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (get_field('details_venue_will_set_up')): ?>
                            <tr>
                                <td class="highlight width-25">Venue will set up</td>
                                <td class="width-75">
                                    <?php
                                    if (count(get_field('details_venue_will_set_up'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('details_venue_will_set_up') as $item) {
                                            $decorationsClass = "";
                                            if (strpos($item, 'Candles') !== false || strpos($item, 'Candles/candelabras') !== false) {
                                                $decorationsClass = "candles";
                                            } elseif (strpos($item, 'Fairy lights') !== false) {
                                                $decorationsClass = "lights";
                                            } elseif (strpos($item, 'Balloons') !== false) {
                                                $decorationsClass = "balloons";
                                            } elseif (strpos($item, 'Fireworks') !== false) {
                                                $decorationsClass = "fireworks";
                                            } elseif (strpos($item, 'Photo booth') !== false) {
                                                $decorationsClass = "photobooth";
                                            } elseif (strpos($item, 'Can hang from walls/ceiling') !== false) {
                                                $decorationsClass = "hang";
                                            } elseif (strpos($item, 'Cutlery, crockery, glassware') !== false) {
                                                $decorationsClass = "cutlery";
                                            } elseif (strpos($item, 'Linens & napkins') !== false) {
                                                $decorationsClass = "linens";
                                            } elseif (strpos($item, 'Chair covers/sashes') !== false) {
                                                $decorationsClass = "chairs";
                                            } elseif (strpos($item, 'Table arrangements') !== false) {
                                                $decorationsClass = "tablearr";
                                            } elseif (strpos($item, 'Bonbonnieres') !== false) {
                                                $decorationsClass = "bonbonnieres";
                                            } else {
                                                $decorationsClass = "yes";
                                            }
                                            echo "<li class='" . $decorationsClass . "'>$item</li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
            <?php if (get_field('details_decoration_package_name_1')) : ?>
                <section>
                    <h2><span>Decoration Packages</span></h2>

                    <div class="accordion">
                        <?php for ($i = 1; $i <= 15; $i++): ?>
                            <?php ${'details_decoration_package_name_' . $i} = get_field('details_decoration_package_name_' . $i);
                            ${'details_decoration_package_information_' . $i} = get_field('details_decoration_package_information_' . $i);
                            if ( ! empty(${'details_decoration_package_name_' . $i})): ?>
                                <div class="dt package-option">
                                    <div class="dcap accordion-toggle">
                                        <?php echo ${'details_decoration_package_name_' . $i} ?>
                                    </div>
                                    <div class="dr accordion-content">
                                        <?php echo ${'details_decoration_package_information_' . $i} ?>
                                    </div>
                                </div>
                            <?php endif; endfor; ?>

                    </div>
                </section>
            <?php endif; ?>
        </div>
        <div class="tab-pane clearfix" id="single-tab-ceremony">
            <?php if (get_field('ceremony_text')): ?>
                <section class="fw">
                    <h2><span>Description</span></h2>
                    <table cellpadding="0" cellspacing="0" class="min">
                        <tbody>
                        <tr>
                            <td>
                                <div class="more-less">
                                    <div class="more-block">
                                        <div id="details_text"
                                             class="text-block"><?php echo get_field('ceremony_text'); ?></div>
                                    </div>
                                    <a href="#" class="more"><span>+ More</span></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>
            <?php if (get_field('ceremony_site_type')): ?>
                <section class="fw">
                    <h2><span>Need to Know</span></h2>

                    <div class="accordion">
                        <?php

                        if (get_field('ceremony_site_type')) {
                            $ceremony_site_type = get_field('ceremony_site_type');
                            $ceremony_site_photo = get_field('ceremony_site_photo');
                            $ceremony_site_space;

                            if ($ceremony_site_type[1] == 'Cellar door') {
                                $ceremony_site_space = $ceremony_site_type[0];
                                $ceremony_site_type = $ceremony_site_type[1];
                            } else {
                                $ceremony_site_space = $ceremony_site_type[1];
                                $ceremony_site_type = $ceremony_site_type[0];
                            }

                            echo '<div class="dt package-option"><div class="dcap accordion-toggle">' . $ceremony_site_type . '</div><div class="dr accordion-content">';
                            echo '<table cellpadding="0" cellspacing="0" cellpadding="min">';
                            echo '<thead><tr><th>Space</th><th>Hire Cost</th><th>Hire Length</th><th>Min Guests</th><th>Max Guests</th><th>Chairs <small>in package</small></th><th>Extra <small>$ per chair</small></th></tr></thead>';
                            echo '<tbody>';
                            echo '<td>' . $ceremony_site_space . '</td>';
                            echo '<td>' . get_field('ceremony_site_hire_cost_display') . '</td>';
                            echo '<td>' . get_field('ceremony_site_hire_duration_display') . '</td>';
                            echo '<td>' . get_field('ceremony_site_minimum_guest_numbers_display') . '</td>';
                            echo '<td>' . get_field('ceremony_site_maximum_guest_numbers_display') . '</td>';
                            echo '<td>' . get_field('ceremony_number_of_chairs_provided_display') . '</td>';
                            $chair_hire_cost = get_field('ceremony_chair_hire_cost_per_chair');
                            if ( ! $chair_hire_cost) {
                                $chair_hire_cost = 'N/A';
                            } else {
                                $chair_hire_cost = '$' . $chair_hire_cost;
                            }
                            echo '<td>' . $chair_hire_cost . '</td>';
                            echo '</tr>';
                            if ( ! empty($ceremony_site_photo)) {
                                echo '<tr><td colspan="7"><div class="frame"><img src="' . $ceremony_site_photo['sizes']['javo-box'] . '" class="img-responsive"></div></td></tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div></div>';
                        }

                        for ($i = 2; $i <= 15; $i++) {

                            ${'ceremony_site_type_' . $i} = get_field('ceremony_site_type_' . $i);
                            ${'ceremony_site_space_' . $i};
                            if (${'ceremony_site_type_' . $i}[1] == 'Cellar door') {
                                ${'ceremony_site_space_' . $i} = ${'ceremony_site_type_' . $i}[0];
                                ${'ceremony_site_type_' . $i} = ${'ceremony_site_type_' . $i}[1];
                            } else {
                                ${'ceremony_site_space_' . $i} = ${'ceremony_site_type_' . $i}[1];
                                ${'ceremony_site_type_' . $i} = ${'ceremony_site_type_' . $i}[0];
                            }

                            ${'ceremony_site_photo_' . $i} = get_field('ceremony_site_photo_' . $i);
                            ${'ceremony_site_hire_cost_display_' . $i} = get_field('ceremony_site_hire_cost_display_' . $i);
                            ${'ceremony_site_hire_duration_display_' . $i} = get_field('ceremony_site_hire_duration_display_' . $i);
                            ${'ceremony_site_minimum_guest_numbers_display_' . $i} = get_field('ceremony_site_minimum_guest_numbers_display_' . $i);
                            ${'ceremony_site_maximum_guest_numbers_display_' . $i} = get_field('ceremony_site_maximum_guest_numbers_display_' . $i);
                            ${'number_of_chairs_provided_display_' . $i} = get_field('number_of_chairs_provided_display_' . $i);
                            ${'chair_hire_cost_per_chair_' . $i} = get_field('chair_hire_cost_per_chair_' . $i);
                            if ( ! ${'chair_hire_cost_per_chair_' . $i}) {
                                ${'chair_hire_cost_per_chair_' . $i} = 'N/A';
                            } else {
                                ${'chair_hire_cost_per_chair_' . $i} =
                                    '$' . ${'chair_hire_cost_per_chair_' . $i};
                            }

                            if ( ! empty(${'ceremony_site_type_' . $i})) {
                                echo '<div class="dt package-option"><div class="dcap accordion-toggle">' . ${'ceremony_site_type_' . $i} . '</div><div class="dr accordion-content">';
                                echo '<table cellpadding="0" cellspacing="0" cellpadding="min">';
                                echo '<thead><tr><th>Space</th><th>Hire Cost</th><th>Hire Length</th><th>Min Guests</th><th>Max Guests</th><th>Chairs <small>in package</small></th><th>Extra <small>$ per chair</small></th></tr></thead>';
                                echo '<tbody>';
                                echo '<td>' . ${'ceremony_site_space_' . $i} . '</td>';
                                echo '<td>' . ${'ceremony_site_hire_cost_display_' . $i} . '</td>';
                                echo '<td>' . ${'ceremony_site_hire_duration_display_' . $i} . '</td>';
                                echo '<td>' . ${'ceremony_site_minimum_guest_numbers_display_' . $i} . '</td>';
                                echo '<td>' . ${'ceremony_site_maximum_guest_numbers_display_' . $i} . '</td>';
                                echo '<td>' . ${'number_of_chairs_provided_display_' . $i} . '</td>';
                                echo '<td>' . ${'chair_hire_cost_per_chair_' . $i} . '</td>';
                                echo '</tr>';
                                if ( ! empty(${'ceremony_site_photo_' . $i})) {
                                    echo '<tr><td colspan="7"><div class="frame"><img src="' . ${'ceremony_site_photo_' . $i}['sizes']['javo-box'] . '" class="img-responsive"></div></td></tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div></div>';
                            } else {
                                break;
                            }
                        }
                        ?>
                    </div>
                </section>
            <?php endif; ?>
            <section class="fw">
                <h2><span>The Details</span></h2>
                <table cellpadding="0" cellspacing="0" class="min">
                    <tbody>
                    <?php if (get_field('ceremony_site_features')): ?>
                        <tr>
                            <td class="highlight width-25">Friendly For</td>
                            <td class="width-75">
                                <?php
                                if (count(get_field('ceremony_site_features'))) {
                                    echo "<ul class='icons'>";
                                    foreach (get_field('ceremony_site_features') as $item) {
                                        $friendlyforClass = "";
                                        if (strpos($item, 'Disabled accessable') !== false) {
                                            $friendlyforClass = "wheelchair";
                                            echo "<li class='" . $friendlyforClass . "'><span>Disabled Guests</span></li>";
                                        } elseif (strpos($item, 'Child friendly') !== false) {
                                            $friendlyforClass = "pram";
                                            echo "<li class='" . $friendlyforClass . "'><span>Children</span></li>";
                                        } elseif (strpos($item, 'Pet friendly') !== false) {
                                            $friendlyforClass = "dog";
                                            echo "<li class='" . $friendlyforClass . "'><span>Pets</span></li>";
                                        }
                                    }
                                    echo "</ul>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if (get_field('ceremony_site_features')): ?>
                        <tr>
                            <td class="highlight width-25">Features</td>
                            <td class="width-75">
                                <?php

                                $about_need_to_know = get_field('ceremony_site_features');

                                $disbledaccessable = in_array('Disabled accessable', $about_need_to_know) ? 'yes' : 'no';
                                $allowsreligiousceremonies = in_array('Allows religious ceremonies', $about_need_to_know) ? 'yes' : 'no';
                                $allowcivilceremonies = in_array('Allows civil ceremonies', $about_need_to_know) ? 'yes' : 'no';
                                $seperatespace = in_array('Is a separate space to reception room', $about_need_to_know) ? 'yes' : 'no';
                                $providesrehearsal = in_array('Provides rehearsal', $about_need_to_know) ? 'yes' : 'no';
                                $wetweatherplan = in_array('Wet weather plan', $about_need_to_know) ? 'yes' : 'no';
                                $roomforbride = in_array('Room for bride to get ready', $about_need_to_know) ? 'yes' : 'no';
                                $venuewillsetup = in_array('Venue will set up', $about_need_to_know) ? 'yes' : 'no';
                                $cansetupbefore = in_array('Can set up day/night before', $about_need_to_know) ? 'yes' : 'no';
                                ?>
                                <ul>
                                    <li>
                                        <span class="<?php echo $disbledaccessable; ?> icon-inline "></span>
                                        Disabled accessable
                                    </li>
                                    <li>
                                        <span class="<?php echo $allowsreligiousceremonies; ?> icon-inline "></span>
                                        Allows religious ceremonies
                                    </li>
                                    <li>
                                        <span class="<?php echo $allowcivilceremonies; ?> icon-inline "></span>
                                        Allows civil ceremonies
                                    </li>
                                    <li>
                                        <span class="<?php echo $seperatespace; ?> icon-inline "></span> Is a
                                        separate space to reception room
                                    </li>
                                    <li>
                                        <span class="<?php echo $providesrehearsal; ?> icon-inline "></span>
                                        Provides rehearsal
                                    </li>
                                    <li>
                                        <span class="<?php echo $wetweatherplan; ?> icon-inline "></span> Wet
                                        weather plan
                                    </li>
                                    <li>
                                        <span class="<?php echo $roomforbride; ?> icon-inline "></span> Room for
                                        bride to get ready
                                    </li>
                                    <li>
                                        <span class="<?php echo $venuewillsetup; ?> icon-inline "></span> Venue will
                                        set up
                                    </li>
                                    <li>
                                        <span class="<?php echo $cansetupbefore; ?> icon-inline "></span> Can set up
                                        day/night before
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if (get_field('ceremony_site_decorations')): ?>
                        <tr>
                            <td class="highlight width-25">Decorations included</td>
                            <td class="width-75">
                                <?php
                                if (count(get_field('ceremony_site_decorations'))) {
                                    echo '<ul class="icons">';
                                    foreach (get_field('ceremony_site_decorations') as $item) {
                                        $decorIncClass = "";
                                        if (strpos($item, 'Can throw confetti/rice') !== false) {
                                            $decorIncClass = "confetti";
                                            echo "<li class='" . $decorIncClass . "'><span>$item</span></li>";
                                        } elseif (strpos($item, 'Chairs') !== false) {
                                            $decorIncClass = "chairs";
                                            echo "<li class='" . $decorIncClass . "'><span>$item</span></li>";
                                        } elseif (strpos($item, 'Wedding arbour') !== false) {
                                            $decorIncClass = "arbour";
                                            echo "<li class='" . $decorIncClass . "'><span>$item</span></li>";
                                        } elseif (strpos($item, 'Signing table') !== false) {
                                            $decorIncClass = "stable";
                                            echo "<li class='" . $decorIncClass . "'><span>$item</span></li>";
                                        } elseif (strpos($item, 'Microphone/PA system') !== false) {
                                            $decorIncClass = "mic";
                                            echo "<li class='" . $decorIncClass . "'><span>$item</span></li>";
                                        } elseif (strpos($item, 'Aisle runner') !== false) {
                                            $decorIncClass = "vineyard";
                                            echo "<li class='" . $decorIncClass . "'><span>$item</span></li>";
                                        } elseif (strpos($item, 'Rose petals/Bubbles ok') !== false) {
                                            $decorIncClass = "rose";
                                            echo "<li class='" . $decorIncClass . "'><span>$item</span></li>";
                                        }
                                    }
                                    echo "</ul>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
        <div class="tab-pane clearfix" id="single-tab-accomodation">
            <?php if (get_field('accommodation_text')): ?>
                <section class="fw">
                    <h2><span>Description</span></h2>
                    <table cellpadding="0" cellspacing="0" class="min text-block">
                        <tbody>
                        <tr>
                            <td>
                                <div class="more-less">
                                    <div class="more-block">
                                        <div id="details_text" class="text-block">
                                            <?php echo get_field('accommodation_text'); ?>
                                        </div>
                                    </div>
                                    <a href="#" class="more"><span>+ More</span></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>
            <section class="fw">
                <h2>
                    <span>Need to Know</span>
                </h2>

                <div class="sub-section min">
                    <table cellpadding="0" cellspacing="0" cellpadding="min">
                        <?php if (get_field('accommodation_type')): ?>
                            <tr>
                                <td class="highlight width-25">
                                    Accomodation type
                                </td>
                                <td class="width-75">
                                    <?php echo get_field('accommodation_type'); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (get_field('accommodation_number_of_rooms_display')): ?>
                            <tr>
                                <td class="highlight width-25">
                                    Number of rooms
                                </td>
                                <td class="width-75">
                                    <?php echo get_field('accommodation_number_of_rooms_display'); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (get_field('accommodation_capacity_display')): ?>
                            <tr>
                                <td class="highlight width-25">
                                    Capacity
                                </td>
                                <td class="width-75">
                                    <?php echo get_field('accommodation_capacity_display'); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (in_array('Wheelchair friendly rooms', get_field('accommodation_features')) || in_array('Pet friendly rooms', get_field('accommodation_features'))): ?>
                            <tr>
                                <td class="highlight width-25">
                                    Friendly For
                                </td>
                                <td class="width-75">
                                    <?php if (count(get_field('accommodation_features'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('accommodation_features') as $item) {
                                            $friendlyforClass = "";
                                            if (strpos($item, 'Wheelchair friendly rooms') !== false) {
                                                $friendlyforClass = "wheelchair";
                                                echo "<li class='" . $friendlyforClass . "'><span>Disabled Guests</span></li>";
                                            } elseif (strpos($item, 'Pet friendly rooms') !== false) {
                                                $friendlyforClass = "dog";
                                                echo "<li class='" . $friendlyforClass . "'><span>Pets</span></li>";
                                            }
                                        }
                                        echo "</ul>";
                                    } ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?
                        $accomodation_features = (get_field('accommodation_features'));
                        $accomodation_features_options = ['Easy access to vineyards', 'Tennis court', 'Golf course', 'Scenic gardens', 'Swimming pool', 'Spa/sauna', 'Beautician',
                            'Hairdresser', 'Exclusive use possible', 'Exclusive use discount', 'Arranges guest activities', 'Single night bookings ok', 'Mid-week discount', 'Babysitting', 'Cellar door', 'Mid-week stays possible', 'Free bride/groom accommodation',
                            'Free anniversary night accommodation'];

                        if (is_array($accomodation_features) && array_intersect($accomodation_features_options, $accomodation_features)):

                            ?>
                            <tr>
                                <td class="highlight width-25">
                                    Features
                                </td>
                                <td class="width-75">
                                    <?php
                                    if (count(get_field('accommodation_features'))) {
                                        echo "<ul class='icons'>";
                                        foreach (get_field('accommodation_features') as $item) {
                                            $accomodationFeaturesClass = "";
                                            if (strpos($item, 'Easy access to vineyards') !== false) {
                                                $accomodationFeaturesClass = "vineyard";
                                            } elseif (strpos($item, 'Tennis court') !== false) {
                                                $accomodationFeaturesClass = "tennis";
                                            } elseif (strpos($item, 'Golf course') !== false) {
                                                $accomodationFeaturesClass = "golf";
                                            } elseif (strpos($item, 'Scenic gardens') !== false) {
                                                $accomodationFeaturesClass = "gardens";
                                            } elseif (strpos($item, 'Swimming pool') !== false) {
                                                $accomodationFeaturesClass = "pool";
                                            } elseif (strpos($item, 'Spa/sauna') !== false) {
                                                $accomodationFeaturesClass = "spa";
                                            } elseif (strpos($item, 'Beautician') !== false) {
                                                $accomodationFeaturesClass = "beautician";
                                            } elseif (strpos($item, 'Hairdresser') !== false) {
                                                $accomodationFeaturesClass = "hair";
                                            } elseif (strpos($item, 'Exclusive use possible') !== false) {
                                                $accomodationFeaturesClass = "exclusive";
                                            } elseif (strpos($item, 'Exclusive use discount') !== false) {
                                                $accomodationFeaturesClass = "discount hidden";
                                            } elseif (strpos($item, 'Arranges guest activities') !== false) {
                                                $accomodationFeaturesClass = "yes";
                                            } elseif (strpos($item, 'Single night bookings ok') !== false) {
                                                $accomodationFeaturesClass = "yes";
                                            } elseif (strpos($item, 'Mid-week discount') !== false) {
                                                $accomodationFeaturesClass = "discount hidden";
                                            } elseif (strpos($item, 'Wheelchair friendly rooms') !== false) {
                                                $accomodationFeaturesClass = "wheelchair hidden";
                                            } elseif (strpos($item, 'Pet friendly rooms') !== false) {
                                                $accomodationFeaturesClass = "pet hidden";
                                            } elseif (strpos($item, 'Babysitting') !== false) {
                                                $accomodationFeaturesClass = "babysitting";
                                            } elseif (strpos($item, 'Cellar door') !== false) {
                                                $accomodationFeaturesClass = "cellar";
                                            } elseif (strpos($item, 'Mid-week stays possible') !== false) {
                                                $accomodationFeaturesClass = "yes";
                                            } elseif (strpos($item, 'Free bride/groom accommodation') !== false) {
                                                $accomodationFeaturesClass = "offer hidden";
                                            } elseif (strpos($item, 'Free anniversary night accommodation') !== false) {
                                                $accomodationFeaturesClass = "offer";
                                            } else {
                                                $accomodationFeaturesClass = "yes";
                                            }
                                            echo "<li class='" . $accomodationFeaturesClass . "'>$item</li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </section>
            <?php if (get_field('accommodation_room_name_1')): ?>
                <section>
                    <h2>
                        <span>Room Details</span>
                    </h2>
                    <table cellpadding="0" cellspacing="0">
                        <?php
                        for ($i = 1; $i <= 15; $i++) {

                            ${'accommodation_room_name_' . $i} = get_field('accommodation_room_name_' . $i);
                            ${'accommodation_room_description_' . $i} = get_field('accommodation_room_description_' . $i);
                            ${'accommodation_room_photo_' . $i} = get_field('accommodation_room_photo_' . $i);

                            if ( ! empty(${'accommodation_room_name_' . $i})) {
                                echo '<tr><td><div class="media">';
                                if ( ! empty(${'accommodation_room_photo_' . $i})) {
                                    echo '<div class="frame pull-right"><img src="' . ${'accommodation_room_photo_' . $i}['sizes']['javo-box'] . '" class="img-responsive media-object"></div>';
                                }
                                echo '<div class="media-object"><h3 class="accomodation-name">' . ${'accommodation_room_name_' . $i} . '</h3><div class="text-block">' . ${'accommodation_room_description_' . $i} . '</div></div></div></td></tr>';
                            } else {
                                break;
                            }
                        }
                        ?>
                    </table>
                </section>
            <?php endif; ?>
            <?php if (get_field('accommodation_rate_description') || get_field('accommodation_discounts')): ?>
                <section>
                    <h2>
                        <span>Costs</span>
                    </h2>

                    <div class="accordion">
                        <?php if (get_field('accommodation_rate_description')): ?>
                            <div class="dt package-option">
                                <div class="dcap accordion-toggle">
                                    Rates
                                </div>
                                <div class="dr accordion-content">
                                    <?php echo get_field('accommodation_rate_description') ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (get_field('accommodation_discounts')) : ?>
                            <div class="dt package-option">
                                <div class="dcap accordion-toggle">
                                    Discounts
                                </div>
                                <div class="dr accordion-content">
                                    <table cellpadding="0" cellspacing="0" class="text-block">
                                        <?php foreach (get_field('accommodation_discounts') as $item) {
                                            echo "<tr><td class='highlight'>$item</td>";
                                            echo "<td>";
                                            if (strpos($item, 'Bride/groom') !== false) {
                                                echo get_field('accommodation_discounts_bride_groom');
                                            } elseif (strpos($item, 'Bridal party') !== false) {
                                                echo get_field('accommodation_discounts_bridal_party');
                                            } elseif (strpos($item, 'Guest') !== false) {
                                                echo get_field('accommodation_discounts_guest');
                                            } elseif (strpos($item, 'Exclusive use') !== false) {
                                                echo get_field('accommodation_discounts_exclusive_use');
                                            } elseif (strpos($item, 'Mid-week') !== false) {
                                                echo get_field('accommodation_discounts_mid_week');
                                            } elseif (strpos($item, 'Large group') !== false) {
                                                echo get_field('accommodation_discounts_large_group');
                                            } elseif (strpos($item, 'Long stay') !== false) {
                                                echo get_field('accommodation_discounts_long_stay');
                                            } elseif (strpos($item, 'Family') !== false) {
                                                echo get_field('accommodation_discounts_family');
                                            }
                                            echo "</td></tr>";
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="margin-md-top">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group btn-group-lg btn-group-justified">
                <a href="#" class="btn btn-contact book" data-toggle="modal" data-target="#contactForm">
                    Like what you see?
                    <h4>
                        Book Viewing
                    </h4>
                </a>
                <a href="#" class="btn btn-contact contact" data-toggle="modal" data-target="#contactForm">
                    Have Questions?
                    <h4>
                        Let Us Help You
                    </h4>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p class="disclaimer">Prices and details are correct at time of publication but are subject to change.
                Contact venue to confirm details.</p>
        </div>
    </div>
</div>
<div class="visible-xs">
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group mobile-tabs">
                <button class="btn btn-mobile-venue dropdown-toggle btn-block" type="button" data-toggle="dropdown">
                    <span class="active-tab">Quick Facts</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu mobile-menu" role="menu">
                    <li class="active js-facts">
                        <a href="#single-tab-facts">
                            Quick Facts
                        </a>
                    </li>
                    <li class="js-about">
                        <a href="#single-tab-about">
                            About
                        </a>
                    </li>
                    <?php if ( ! in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))) : ?>
                        <li class="js-food">
                            <a href="#single-tab-food">
                                Food &amp; Drink
                            </a>
                        </li>
                        <li class="js-rooms">
                            <a href="#single-tab-rooms">
                                Rooms &amp; Decorations
                            </a>
                        </li>
                    <?php endif;
                    if (in_array("On-site ceremony venue", get_field('about_need_to_know'))) :?>
                        <li class="js-ceremony">
                            <a href="#single-tab-ceremony">
                                Ceremony
                            </a>
                        </li>
                    <?php endif;
                    if (in_array("On-site accommodation", get_field('about_need_to_know'))) :?>
                        <li class="js-accomodation">
                            <a href="#single-tab-accomodation">
                                Accomodation
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="room-details" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#single-tabs').tab();
        // link to specific single-tabs
        var hash = location.hash
            , hashPieces = hash.split('?')
            , activeTab = hashPieces[0] != '' ? $('[href=' + hashPieces[0] + ']') : null;
        activeTab && activeTab.tab('show');
        var content = $('.sidebar-right').html();
        $('.mobile-content .tab-content').empty().append(content);

        // The height of the content block when it's not expanded
        var adjustheight = 115;
        // The "more" link text
        var moreText = "+  More";
        // The "less" link text
        var lessText = "- Less";

        // Sets the .more-block div to the specified height and hides any content that overflows
        $(".more-less .more-block").css('height', adjustheight).css('overflow', 'hidden');

        // The section added to the bottom of the "more-less" div
        // $("a.adjust").after('[…]');
        // Set the "More" text
        $("a.adjust").text(moreText);

        $(document).on('click', '.more', function (e) {
            e.preventDefault();
            if (!$(this).attr('data-toggled') || $(this).attr('data-toggled') == 'off') {
                $(this).parents("div:first").find(".more-block").css('height', 'auto').css('overflow', 'visible');
                $(this).parents("div:first").find("p.continued").css('display', 'none');
                $(this).text(lessText);
                $(this).attr('data-toggled', 'on');
            }
            else if ($(this).attr('data-toggled') == 'on') {
                $(this).parents("div:first").find(".more-block").css('height', adjustheight).css('overflow', 'hidden');
                $(this).parents("div:first").find("p.continued").css('display', 'block');
                $(this).text(moreText);
                $(this).attr('data-toggled', 'off');
            }

        });

        $(document).on('click', '.frame img', function () {
            var ogImage = new Image();
            ogImage.src = $(this).attr('src');

            var imageWidth = ogImage.width;

            var modalImage = '<img src="' + ogImage.src + '" class="img-responsive">';
            var modalWidth = imageWidth + 32;

            $('#room-details').modal();
            $("#room-details .modal-dialog").attr('style', 'width:' + modalWidth + 'px');
            ;
            $('#room-details').on('shown.bs.modal', function () {
                $('#room-details .modal-body').html(modalImage);
            });
            $('#room-details').on('hidden.bs.modal', function () {
                $('#room-details .modal-body').html('');
            });
        });

        $(document).on('click', '.accordion-toggle', function () {
            $(this).next().slideToggle('fast');
        });

        $('.mobile-menu a').click(function (e) {
            $('.mobile-menu').find('li.active').removeClass('active');
            e.preventDefault();
            var clicked = $(this).parent().attr('class');
            var title = $(this).html();
            $('.dropdown-menu').find('.' + clicked).addClass('active');
            $('.dropdown-toggle').find('.active-tab').html(title);
            var selectedDiv = $(this).attr('href');
            if (selectedDiv == '#single-tab-facts') {
                var content = $('.sidebar-right').html();
                $('.mobile-content .tab-content').empty().append(content);
            } else {
                var content = $(selectedDiv).html();
                $('.mobile-content .tab-content').empty().append(content);
            }
            $('html, body').animate({
                scrollTop: $(".mobile-content").offset().top - 130
            });
        });

    });
</script>
