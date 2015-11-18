<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Javo_Directory
 * @since Javo Themes 1.0
 */

// Get global post object
global $post;

// Variable initialize
$javo_sidebar_lr = "right";

// Post object exist?
if(!empty($post->ID)){

    // Get post object id
    $post_id = $post->ID;
    // Get display post sidebar option meta.
    $javo_sidebar_lr = trim( (string)get_post_meta( $post_id, 'javo_sidebar_type', true) );
    // Set not exist meta value to default 'Right'
    $javo_sidebar_lr = !empty($javo_sidebar_lr)? $javo_sidebar_lr : "right";
};?>

<div class="col-md-3 margin-lg-top sidebar-<?php echo $javo_sidebar_lr;?> hidden-xs">
    <div id="RHN">
        <div class="row hidden-xs">
            <a href="#" class="btn btn-lg btn-contact book margin-sm" data-toggle="modal" data-target="#reviewForm">
                <h5>Been to this venue?</h5> Help others - Add a review!
            </a>
        </div>
        <div class="row">
            <div class="col-lg-12 sidebar-style">
                <h3>Quick Facts</h3>
                <div class="section">
                    <ul>
                        <li class="row">
                            <div class="col-xs-12">
                                <h4 class="margin-none">Costs</h4>
                            </div>
                        </li>
                        <?php if (get_field('combined_minimum_food_and_drinks_package_pp_display') == "") : ?>
                        <li class="row">
                            <div class="col-xs-8">
                                Min. Food package pp
                            </div>
                            <div class="col-xs-4 text-right">
                                <strong><? echo get_field('food_minimum_food_package_cost_display') ?></strong>
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-8">
                                Min. Drinks package pp
                            </div>
                            <div class="col-xs-4 text-right">
                                <strong><? echo get_field('food_minimum_drinks_package_cost_display') ?></strong>
                            </div>
                        </li>
                        <?php else : ?>
                        <li class="row">
                            <div class="col-xs-8">
                                Min Food & Drinks pp
                            </div>
                            <div class="col-xs-4 text-right">
                                <strong><? echo get_field('combined_minimum_food_and_drinks_package_pp_display') ?></strong>
                            </div>
                        </li>
                        <?php endif; ?>
                        <li class="row">
                            <div class="col-xs-8">
                                Reception Venue hire
                            </div>
                            <div class="col-xs-4 text-right">
                                <strong><? echo get_field('about_venue_hire_cost_display') ?></strong>
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-8">
                                Ceremony site hire</label>
                            </div>
                            <div class="col-xs-4 text-right">
                                <strong><? echo get_field('ceremony_site_hire_cost_display') ?></strong>
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-8">
                                Min. Accommodation <small>(per room/pn)</small>
                            </div>
                            <div class="col-xs-4 text-right">
                                <strong><? echo get_field('accommodation_cheapest_room_rate_display') ?></strong>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php if(get_field('about_about_how_far_ahead_do_you_have_to_book')): ?>
                    <div class="when section">
                        <ul>
                            <li class="row">
                                <div class="col-xs-12">
                                    <h4 class="margin-none">How far ahead should you book?</h4>
                                </div>
                            </li>
                            <?php
                                $whenToBook = get_field('about_about_how_far_ahead_do_you_have_to_book');

                                $summer_midweek;
                                $summer_weekend;
                                $winter_midweek;
                                $winter_weekend;

                                if(in_array('Summer/Spring (weekend), 0-6 months', $whenToBook)) {
                                    $summer_weekend = '0-6 months';
                                }
                                if(in_array('Summer/Spring (weekend), 7-11 months', $whenToBook)) {
                                    $summer_weekend = '7-11 months';
                                }
                                if(in_array('Summer/Spring (weekend), 12-18 months', $whenToBook)) {
                                    $summer_weekend = '12-18 months';
                                }
                                if(in_array('Summer/Spring (weekend), 19-24 months', $whenToBook)) {
                                    $summer_weekend = '19-24 months';
                                }
                                if(in_array('Summer/Spring (weekend), 24 months+', $whenToBook)) {
                                    $summer_weekend = '24 months+';
                                }
                                if(in_array('Summer/Spring (mid-week), 0-6 months', $whenToBook)) {
                                    $summer_midweek = '0-6 months';
                                }
                                if(in_array('Summer/Spring (mid-week), 7-11 months', $whenToBook)) {
                                    $summer_midweek = '7-11 months';
                                }
                                if(in_array('Summer/Spring (mid-week), 12-18 months', $whenToBook)) {
                                    $summer_midweek = '12-18 months';
                                }
                                if(in_array('Summer/Spring (mid-week), 19-24 months', $whenToBook)) {
                                    $summer_midweek = '19-24 months';
                                }
                                if(in_array('Summer/Spring (mid-week), 24 months+', $whenToBook)) {
                                    $summer_midweek = '24 months+';
                                }
                                if(in_array('Autumn/Winter (weekend), 0-6 months', $whenToBook)) {
                                    $winter_weekend = '0-6 months';
                                }
                                if(in_array('Autumn/Winter (weekend), 7-11 months', $whenToBook)) {
                                    $winter_weekend = '7-11 months';
                                }
                                if(in_array('Autumn/Winter (weekend), 12-18 months', $whenToBook)) {
                                    $winter_weekend = '12-18 months';
                                }
                                if(in_array('Autumn/Winter (weekend), 19-24 months', $whenToBook)) {
                                    $winter_weekend = '19-24 months';
                                }
                                if(in_array('Autumn/Winter (weekend), 24 months+', $whenToBook)) {
                                    $winter_weekend = '24 months+';
                                }

                                if(in_array('Autumn/Winter (mid-week), 0-6 months', $whenToBook)) {
                                    $winter_midweek = '0-6 months';
                                }
                                if(in_array('Autumn/Winter (mid-week), 7-11 months', $whenToBook)) {
                                    $winter_midweek = '7-11 months';
                                }
                                if(in_array('Autumn/Winter (mid-week), 12-18 months', $whenToBook)) {
                                    $winter_midweek = '12-18 months';
                                }
                                if(in_array('Autumn/Winter (mid-week), 19-24 months', $whenToBook)) {
                                    $winter_midweek = '19-24 months';
                                }
                                if(in_array('Autumn/Winter (mid-week), 24 months+', $whenToBook)) {
                                    $winter_midweek = '24 months+';
                                }
                             ?>

                            <li class="row">
                                <div class="col-xs-12">
                                    <h5>Summer/Spring</h5>
                                </div>
                            </li>
                            <li class="row">
                                <div class="col-xs-6">
                                    Weekends
                                </div>
                                <div class="col-xs-6 text-right">
                                    <strong><?= $summer_weekend; ?></strong>
                                </div>
                            </li>
                            <li class="row">
                                <div class="col-xs-6">
                                    Mid-Week
                                </div>
                                <div class="col-xs-6 text-right">
                                    <strong><?= $summer_midweek; ?></strong>
                                </div>
                            </li>
                            <li class="row">
                                <div class="col-xs-12">
                                    <h5>Winter/Autumn</h5>
                                </div>
                            </li>
                            <li class="row">
                                <div class="col-xs-6">
                                    Weekends
                                </div>
                                <div class="col-xs-6 text-right">
                                    <strong><?= $winter_weekend; ?></strong>
                                </div>
                            </li>
                            <li class="row">
                                <div class="col-xs-6">
                                    Mid-Week
                                </div>
                                <div class="col-xs-6 text-right">
                                    <strong><?= $winter_midweek; ?></strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php endif ?>
                <div class="section">
                    <ul>
                        <li class="row">
                            <div class="col-xs-12">
                                <h4 class="margin-none">Friendly For</h4>
                            </div>
                        </li>
                    <?php
                        $get_field = get_field( 'about_friendly_for' );

                         $disabledguests = in_array( 'Disabled Guests', $get_field) ? 'yes' : 'no';
                         $children = in_array( 'Children', $get_field) ? 'yes' : 'no';
                         $pets = in_array( 'Pets', $get_field) ? 'yes' : 'no';
                     ?>
                         <li class="row">
                             <div class="col-xs-12">
                                 <span class="<?php echo $disabledguests; ?> icon-inline"></span> Disabled Guests <span class="wheelchair icon-inline"></span>
                             </div>
                         </li>
                         <li class="row">
                             <div class="col-xs-12">
                                 <span class="<?php echo $children; ?> icon-inline"></span> Children <span class="pram icon-inline"></span>
                             </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $pets; ?> icon-inline"></span> Pets <span class="dog icon-inline"></span>
                            </div>
                        </li>
                     </ul>
                </div>
                <div class="section">
                    <ul>
                        <li class="row">
                            <div class="col-xs-12">
                                <h4 class="margin-none">Need to Know</h4>
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <?php echo get_field('about_wedding_experience_display'); ?>
                            </div>
                        </li>
                        <?php

                            $get_field = get_field( 'about_need_to_know' );

                            $onsitereceptionvenue = in_array( 'Ceremony site/accommodation only', $get_field) ? 'no' : 'yes';
                            $onsiteceremonysite = in_array( 'On-site ceremony venue', $get_field) ? 'yes' : 'no';
                            $onsiteaccomodation = in_array( 'On-site accommodation', $get_field) ? 'yes' : 'no';
                            $onsiterestaurant = in_array( 'On-site restaurant/catering', $get_field) ? 'yes' : 'no';
                            $midweekweddings = in_array( 'Does mid-week weddings', $get_field) ? 'yes' : 'no';
                            $noplannedrenovations = in_array( 'No planned renovations', $get_field) ? 'yes' : 'no';
                            $exclusiveuse = in_array( 'Exclusive use possible', $get_field) ? 'yes' : 'no';
                            $nomultipleweddings = in_array( 'No multiple weddings on same day', $get_field) ? 'yes' : 'no';

                         ?>
                         <li class="row">
                             <div class="col-xs-12">
                                 <span class="<?php echo $onsitereceptionvenue; ?> icon-inline "></span> On-site reception venue
                             </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $onsiteceremonysite; ?> icon-inline "></span> On-site ceremony venue
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $onsiteaccomodation; ?> icon-inline "></span> On-site accommodation
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $onsiterestaurant; ?> icon-inline"></span> On-site restaurant/catering
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="
                                <?php
                                if( in_array( 'Self-catering/external catering required', get_field('food_food_service_options') ) ) {
                                    echo 'yes';
                                } else {
                                    echo 'no';
                                }
                                ?>
                                icon-inline"></span> Self/external catering allowed
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $midweekweddings; ?> icon-inline"></span> Does mid-week weddings
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $noplannedrenovations; ?> icon-inline"></span> No planned renovations
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $exclusiveuse; ?> icon-inline"></span> Exclusive use possible
                            </div>
                        </li>
                        <li class="row">
                            <div class="col-xs-12">
                                <span class="<?php echo $nomultipleweddings; ?> icon-inline"></span> No multiple weddings on same day
                            </div>
                        </li>
                        <?php if(get_field('about_evening_reception_display')): ?>
                            <li class="row">
                                <div class="col-xs-6">
                                    Latest finish time
                                </div>
                                <div class="col-xs-6 text-right">
                                    <strong><?php echo get_field('about_evening_reception_display') ?></strong>
                                </div>
                            </li>
                        <?php endif ?>
                        <?php
                            $about_number_of_parking_spaces_display = get_field('about_number_of_parking_spaces_display');

                            if($about_number_of_parking_spaces_display) {
                                echo '<li class="row"><div class="col-xs-8">Parking</div><div class="col-xs-4 text-right"><strong>', $about_number_of_parking_spaces_display , '</strong></div></li>';
                            }
                        ?>
                        <?php
                            $details_bathrooms_display = get_field('details_bathrooms_display');

                            if($details_bathrooms_display) {
                                echo '<li class="row"><div class="col-xs-8">Toilets</div><div class="col-xs-4 text-right"><strong>', $details_bathrooms_display , '</strong></div></li>';
                            }
                        ?>
                        <? foreach (get_field('about_transport_accessible_by') as $value) {
                                if ( $value == 'Car' ) {
                                    echo '<li class="row"><div class="col-xs-12"><span class="car icon-inline"></span> ', $value ,'</div></li>';
                                }
                                elseif ( $value == 'Taxi' ) {
                                    echo '<li class="row"><div class="col-xs-12"><span class="taxi icon-inline"></span> ', $value ,'</div></li>';
                                }
                                elseif ( $value == 'Private bus' ) {
                                    echo '<li class="row"><div class="col-xs-12"><span class="bus icon-inline"></span> ', $value ,'</div></li>';
                                }
                                elseif ( $value == 'Helicopter' ) {
                                    echo '<li class="row"><div class="col-xs-12"><span class="helicopter icon-inline"></span> ', $value ,'</div></li>';
                                }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <a href="#" class="btn btn-lg btn-contact book margin-sm hidden-xs" data-toggle="modal" data-target="#contactForm">
                Book Viewing
            </a>
        </div>
        <div class="row">
            <a href="#" class="btn btn-lg btn-contact contact margin-sm hidden-xs" data-toggle="modal" data-target="#contactForm">
                <h5>Have questions?</h5> Let us help you!
            </a>
        </div>
    </div>
</div>