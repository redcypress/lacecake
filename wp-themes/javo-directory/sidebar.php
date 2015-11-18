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


<div class="col-md-3 sidebar-<?php echo $javo_sidebar_lr;?>">

	<div class="row" id="RHN">
		<div class="col-lg-12 siderbar-inner">
			<h3>Quick Facts</h3>
			<div class="costs">
				<h4>Costs</h4>
				<ul>
					<li><label>Food package pp</label><strong><? echo get_field('food_minimum_food_package_cost_display') ?></strong></li>
					<li><label>Drinks package pp</label><strong><? echo get_field('food_minimum_drinks_package_cost_display') ?></strong></li>
					<li><label>Venue hire</label><strong><? echo get_field('about_venue_hire_cost_display') ?></strong></li>
					<li><label>Ceremony site hire</label><strong><? echo get_field('ceremony_site_hire_cost_display') ?></strong></li>
					<li><label>Accommodation <small>(per room/pn)</small></label><strong><? echo get_field('accommodation_cheapest_room_rate_display') ?></strong></li>
				</ul>
			</div>
			<div class="when">
				<h4>When to Book</h4>
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

					/*
					Summer/Spring (weekend), 0-6 months
					Summer/Spring (weekend), 7-11 months
					Summer/Spring (weekend), 12-18 months
					Summer/Spring (weekend), 19-24 months
					Summer/Spring (weekend), 24 months+

					Summer/Spring (mid-week), 0-6 months
					Summer/Spring (mid-week), 7-11 months
					Summer/Spring (mid-week), 12-18 months
					Summer/Spring (mid-week), 19-24 months
					Summer/Spring (mid-week), 24 months+

					Autumn/Winter (weekend), 0-6 months
					Autumn/Winter (weekend), 7-11 months
					Autumn/Winter (weekend), 12-18 months
					Autumn/Winter (weekend), 19-24 months
					Autumn/Winter (weekend), 24 months+

					Autumn/Winter (mid-week), 0-6 months
					Autumn/Winter (mid-week), 7-11 months
					Autumn/Winter (mid-week), 12-18 months
					Autumn/Winter (mid-week), 19-24 months
					Autumn/Winter (mid-week), 24 months+
					*/

				 ?>
				<ul>
					<li><h5>Summer/Spring</h5>
						<ul>
							<li><label>Weekends</label><strong><?= $summer_weekend; ?></strong></li>
							<li><label>Mid-Week</label><strong><?= $summer_midweek; ?></strong></li>
						</ul>
					</li>
					<li><h5>Winter/Autumn</h5>
						<ul>
							<li><label>Weekends</label><strong><?= $winter_weekend; ?></strong></li>
							<li><label>Mid-Week</label><strong><?= $winter_midweek; ?></strong></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="friendly">
				<h4>Friendly For</h4>
				<?php
					if( count(get_field('about_friendly_for')) ){
					    echo "<ul class='icons'>";
					    foreach(get_field('about_friendly_for') as $item){
					    	$friendlyforClass = "";
					    	if ( strpos($item,'Disabled Guests') !== false ) {
					    		$friendlyforClass = "wheelchair";
					    	}
					    	elseif ( strpos($item,'Children') !== false ) {
					    		$friendlyforClass = "pram";
					    	}
					    	elseif ( strpos($item,'Pets') !== false ) {
					    		$friendlyforClass = "dog";
					    	}
					       echo "<li class='".$friendlyforClass."'><span>$item</span></li>";
					    }
					    echo "</ul>";
					 }
				 ?>
				<!--<ul class="clearfix">
					<li class="wheelchair">Wheelchair</li>
					<li class="pram">Pram</li>
					<li class="dog">Dog</li>
				</ul>-->
			</div>
			<div class="need-to-know">
				<h4>Need to Know</h4>

				<ul>
					<li><?php echo get_field('about_wedding_experience_display'); ?></li>
					<?php
						if( count(get_field('about_need_to_know')) ){
						    // echo "<ul>";
						    foreach(get_field('about_need_to_know') as $item){
						    	if ( $item == 'On-site ceremony venue' ) {
						    		echo "<li class='icon church'>$item</li>";
						    	}
						    	elseif ( $item == 'On-site accommodation' ) {
						    		echo "<li class='icon bed'>$item</li>";
						    	}
						    	else {
						    		echo "<li>$item</li>";
						    	}
						    }
						    // echo "</ul>";
						 }
					 ?>
					<!--<li>Does mid-week weddings</li>
					<li>Exclusive use possible</li>
					<li>No planned renovations</li>
					<li>No photographer/videographer restrictions</li>
					<li>Doesn't hold multiple wedings on same day</li>-->
					<li>
						<label>Parking</label><strong><?php echo get_field('about_number_of_parking_spaces_display') ?></strong>
						<label>Toilets</label><strong><?php echo get_field('details_bathrooms_display') ?></strong>
					</li>

						<? foreach (get_field('about_transport_accessible_by') as $value) {
							if ( $value == 'Car' ) {
								echo '<li class="icon car">', $value ,'</li>';
							}
							elseif ( $value == 'Taxi' ) {
								echo '<li class="icon taxi">', $value ,'</li>';
							}
							elseif ( $value == 'Private bus' ) {
								echo '<li class="icon bus">', $value ,'</li>';
							}
							elseif ( $value == 'Helicopter' ) {
								echo '<li class="icon helicopter">', $value ,'</li>';
							}
						}  ?>
				</ul>
			</div>
			<div class="action">
				<a href="#" class="book" data-toggle="modal" data-target="#contactForm">Book Viewing</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 siderbar-inner">
			<?php
				$template_name = is_page()? basename(get_page_template()) : null;
			if(
				is_singular("item") ||
				$template_name == "tp-item.php"
			){
				dynamic_sidebar("item Sidebar");
			}elseif(
				is_singular("post") ||
				$template_name == "tp-blogs.php"
			){
				dynamic_sidebar("Blog Sidebar");
			}else{
				dynamic_sidebar("default Sidebar");
			};
			?>
		</div> <!-- pp-siderbar inner -->
	</div> <!-- new row -->
</div><!-- Side bar -->
