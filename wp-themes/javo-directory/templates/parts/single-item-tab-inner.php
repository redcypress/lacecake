<?php
$javo_directory_query			= new javo_get_meta( get_the_ID() );
$javo_rating					= new javo_Rating( get_the_ID() );
global
	$javo_custom_field
	, $post
	, $javo_custom_item_label
	, $javo_custom_item_tab
	, $javo_tso;
$javo_this_author				= get_userdata($post->post_author);
$javo_this_author_avatar_id		= get_the_author_meta('avatar');
$javo_directory_query			= new javo_get_meta( get_the_ID() );
$javo_rating = new javo_Rating( get_the_ID() );
?>
<div class="tabs-wrap">
	<ul id="single-tabs" class="nav nav-pills nav-justified" data-tabs="single-tabs">
		
		<li class="active tab-about">
			<a href="#single-tab-about" data-toggle="tab">About</a>
		</li>
		<? if ( !in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))  ) :?>
		<li class="tab-food">
			<a href="#single-tab-food" data-toggle="tab">Food &amp; Drink</a>
		</li>
		<li class="tab-rooms"><a href="#single-tab-rooms" data-toggle="tab">Rooms &amp; Decorations</a></li>
		<?	endif; 
			if ( in_array("On-site ceremony venue", get_field('about_need_to_know'))  ) :?>
		<li class="tab-ceremony"><a href="#single-tab-ceremony" data-toggle="tab">Ceremony</a></li>
		<? 	endif;
			if ( in_array("On-site accommodation", get_field('about_need_to_know'))  ) :	
		?>
		<li class="tab-accomodation"><a href="#single-tab-accomodation" data-toggle="tab">Accomodation</a></li>
		<? 	endif; ?>
	
	</ul>
    <div id="javo-single-tab" class="tab-content">
            
    		<div class="tab-pane active" id="single-tab-about">
    			<div class="cost">
    				
    				<?php 
    				
    					$minFoodCost = filter_var(get_field('food_minimum_food_package_cost_display'), FILTER_SANITIZE_NUMBER_INT);
    					$minFoodCostDisplay = "";
    					
    					if ( $minFoodCost <= 40 ) {
    						$minFoodCostDisplay = "one";
    					}
    					elseif ( $minFoodCost > 40 && $minFoodCost <= 80  ) {
    						$minFoodCostDisplay = "two";	
    					}
    					elseif ( $minFoodCost > 80 && $minFoodCost <= 120 ) {
    						$minFoodCostDisplay = "three";	
    					}
    					elseif ( $minFoodCost > 120 && $minFoodCost <= 200 ) {
    						$minFoodCostDisplay = "four";	
    					}
    					elseif ( $minFoodCost > 200 ) {
    						$minFoodCostDisplay = "five";	
    					} 
    				
    				?>
    			
    				Cost: <span class="<?= $minFoodCostDisplay; ?>">$</span>
    			</div>
    			<div class="blocks clearfix">
    				<div class="block vibe">
    					<h4>Vibe</h4>
    					<?php 
    						if( count(get_field('about_look_feel')) ){
    						    echo "<ul>";
    						    foreach(get_field('about_look_feel') as $item){
    						       echo "<li>$item</li>";
    						    }
    						    echo "</ul>";
    						 }
    					 ?>
    					<!--<ul>
    						<li>Casual</li> 
    						<li>Formal</li> 
    						<li>Funky</li>
    						<li>Glamorous</li> 
    						<li>Intimate</li>
    					</ul>-->
    				</div>
    				<div class="block views">
    					<h4>Views</h4>
    					<?php 
    						if( count(get_field('about_scenery')) ){
    						    echo "<ul>";
    						    foreach(get_field('about_scenery') as $item){
    						       echo "<li>$item</li>";
    						    }
    						    echo "</ul>";
    						 }
    					 ?>
    					<!--<ul>
    						<li>Harbour</li>
    						<li>Ocean</li>
    						<li>City</li>
    						<li>Country</li>
    						<li>Bush</li>
    					</ul>-->
    				</div>
    				<div class="block knownfor">
    					<h4>Known For</h4>
    					<?php 
    						if( count(get_field('about_known_for')) ){
    						    echo "<ul>";
    						    foreach(get_field('about_known_for') as $item){
    						       echo "<li>$item</li>";
    						    }
    						    echo "</ul>";
    						 }
    					 ?>
    					<!--<ul>
    						<li>Food</li>
    						<li>Wine</li>
    						<li>Service</li>
    						<li>Location</li>
    						<li>Views</li>
    						<li>Attention to detail</li>
    					</ul>-->
    				</div>
    			</div>
    			
    			<? if ( !in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))  ) :?>
    				
    				<section class="section">
    					<h2><span>Need to Know</span></h2>
    					<table cellpadding="0" cellspacing="0">
    						<thead>
    							<tr>
    								<th></th>
    								<th>Capacity</th>
    								<th>Daytime</th>
    								<th>Evening</th>
    								<th>Indoor</th>
    								<th>Outdoor</th>
    							</tr>
    						</thead>
    						<tbody>
    							<tr>
    								<th>Seated reception</th>
    								<td><?= get_field('about_maximum_seated'); ?></td>
    								<td>
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
    										$tick = '<span class="tick">Yes</span>';
    										// if(count(array_intersect($about_reception_type, $DaytimeSeated)) == count($DaytimeSeated)){
    										
    										if( in_array($DaytimeSeated, $about_reception_type) ) {
    									    	echo $tick;
    										}
    									?>
    								</td>
    								<td>
    									<? if( in_array($EveningSeated, $about_reception_type) ) {
    										echo $tick;
    									} ?>
    								</td>
    								<td><? if( in_array($IndoorSeated, $about_reception_type) ) {
    									echo $tick;
    								} ?></td>
    								<td><? if( in_array($OutdoorSeated, $about_reception_type) ) {
    									echo $tick;
    								} ?></td>
    							</tr>
    							<tr>
    								<th>Cocktail reception</th>
    								<td><?= get_field('about_maximum_cocktail'); ?></td>
    								<td><? if( in_array($DaytimeCocktail, $about_reception_type) ) {
    									echo $tick;
    								} ?></td>
    								<td><? if( in_array($EveningCocktail, $about_reception_type) ) {
    									echo $tick;
    								} ?></td>
    								<td><? if( in_array($IndoorCocktail, $about_reception_type) ) {
    									echo $tick;
    								} ?></td>
    								<td><? if( in_array($OutdoorCocktail, $about_reception_type) ) {
    									echo $tick;
    								} ?></td>
    							</tr>
    							<tr>
    								<th>Latest finish time</th>
    								<td></td>
    								<td><?php echo get_field('about_daytime_reception_display'); ?></td>
    								<td><?php echo get_field('about_evening_reception_display'); ?></td>
    								<td></td>
    								<td></td>
    							</tr>
    						</tbody>
    					</table>
    					
    					<div class="sub-section">
    						<!-- .pull-left -->
    						<div class="pull-left">
    							<h3>Minimum guest numbers</h3>
    							<table cellpadding="0" cellspacing="0">
    								<thead>
    									<tr>
    										<th></th>
    										<th>Weekend</th>
    										<th>Mid-Week</th>
    									</tr>
    								</thead>
    								<tbody>
    									<tr>
    										<th>Seated Reception</th>
    										<td>
    											<?= get_field('about_minimum_seated_weekend'); ?></td>
    										<td><?= get_field('about_minimum_seated_mid_week'); ?></td>
    									</tr>
    									<tr>
    										<th>Cocktail Reception</th>
    										<td><?= get_field('about_minimum_cocktail_weekend'); ?></td>
    										<td><?= get_field('about_minimum_cocktail_mid_week'); ?></td>
    									</tr>
    								</tbody>
    							</table>
    						</div>
    						<!-- /.pull-left -->
    						<!-- .pull-right -->
    						<div class="pull-right">
    							<h3>Venue Costs</h3>
    							<table cellpadding="0" cellspacing="0" id="VenueCosts">
    								<thead>
    									<tr><th colspan="2" class="center"><?= get_field('about_venue_hire_duration_display'); ?></th></tr>
    								</thead>
    								<tbody>
    									
    									<tr>
    										<!--<td rowspan="5">Venue Icon</td>-->
    										<td><?php echo get_field('about_venue_hire_cost_display') ?> Room Hire</td>
    										<td><?php echo get_field('about_venue_hire_extension_display') ?>/hour Extension</td>
    									</tr>
    									<tr>
    										<td><?php 
    												$depositReq = get_field('about_deposit_needed_display');
    												if ( $depositReq ) {
                                                        echo $depositReq . ' Deposit';
    												} else {
    													echo 'No Deposit Required';
    												}
    											?></td>
    										<td>
    											<? 
    											$about_minimum_spend = get_field('about_minimum_spend');
    											if ($about_minimum_spend == "Yes"): ?>
    											Minimum spend required
    											<? elseif ($about_minimum_spend == "No"):  ?>
    											No minimum spend
    											<? endif; ?>
    										</td>
    									</tr>
    								</tbody>
    							</table>
    						</div>
    						<!-- /.pull-right -->
    					</div>
    					
    					
    				</section>
    				
    				<section>
    					<h2><span>The details</span></h2>
    					
    					<div>
    						<div class="pull-left">
    							<h3>Help</h3>
    							<table>
    								<tbody>
    									<?php  if( count( get_field('about_support') ) ) : ?>
    									<tr>
    										<? 
    									    	$venueHelp = array();
    									    	
    									    	foreach (get_field('about_support') as $item) {
    									    		// echo($item);
    									    		if ($item == "Wedding Coordinator") {
    									    			$venueHelp[] = $item;
    									    		} 
    									    		elseif ($item == "In-house Decorator") {
    									    			$venueHelp[] = $item;
    									    		}
    									    	}
    									    	print_r($venueHelp,1);
    									    	
    									    	if ( count($venueHelp) > 1 ) {
    									    		echo '<td>',$venueHelp[0],'</td>';
    									    		echo '<td>',$venueHelp[1],'</td>';
    									    	} 
    									    	else {
    									    		echo '<td colspan="2">',$venueHelp[0],'</td>';
    									    	}
    									    ?>	 
    									</tr>
    									<? endif; ?>
    									<tr>
    										<td colspan="2">
    											<h5>Venue Can:</h5>
    											<?php 
    												if( count( get_field('about_support') ) ){
    												    echo "<ul>";
    												    
    												    if ( count($venueHelp) > 1 ) {
    												    	$venueCan = array_slice(get_field('about_support'),2);
    												    } else {
    												    	$venueCan = array_slice(get_field('about_support'),1);
    												    }
    												    foreach($venueCan  as $item){
    												       echo "<li>$item</li>";
    												    }
    												    echo "</ul>";
    												 }
    											 ?>
    										</td>
    									</tr>
    								</tbody>
    							</table>	
    						</div>
    						<div class="pull-right">
    							<h3>Venue Features</h3>
    							<table class="venue">
    								<tbody>
    								<tr>
    									<td>
    									<?php 
    										if( count(get_field('about_venue_features')) ){
    										    echo "<ul class='icons'>";
    										    foreach(get_field('about_venue_features') as $item){
    										       
    										       $venueFeaturesClass = "";
    										       if (strpos($item,'Helipad') !== false) {
    										       	   $venueFeaturesClass = "helipad";
    										       }
    										       elseif (strpos($item,'On-site parking') !== false) {
    										       	   $venueFeaturesClass = "parking";
    										       }
    										       elseif (strpos($item,'Has extra/outdoor breakout spaces') !== false) {
    										       	   $venueFeaturesClass = "breakout";
    										       }
    										       elseif (strpos($item,'Gift storage space') !== false) {
    										       	   $venueFeaturesClass = "storage";
    										       }
    										       elseif (strpos($item,'Bridal party relaxation space') !== false) {
    										       	   $venueFeaturesClass = "relax";
    										       }
    										       elseif (strpos($item,'Marquee') !== false) {
    										       	   $venueFeaturesClass = "marquee";
    										       }
    										       elseif (strpos($item,'Can set up day before') !== false) {
    										       	   $venueFeaturesClass = "yes";
    										       }
    										       elseif (strpos($item,'No photographer/videographer restrictions') !== false) {
    										       	   $venueFeaturesClass = "yes";
    										       }
    										       elseif (strpos($item,'Lawn games') !== false) {
    										       	   $venueFeaturesClass = "lawn";
    										       }
    										       
    										       echo "<li class='".$venueFeaturesClass."'>$item</li>";
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
    				
    				<? endif; 
    				   if ( get_field('about_text') != '' ) :
    				?>
    				
    				<section class="fw">
    					<h2><span>Tell me more</span></h2>
    					<table cellpadding="0" cellspacing="0" class="min">
    						<tbody>
    							<tr>
    								<td>
    									<div class="more-less">
    									    <div class="more-block">
    									    	<div id="about_text"><?= get_field('about_text'); ?></div>
    									    </div>
    									    <a href="#" class="more"><span>+ More</span></a>
    									</div>
    									
    								</td>
    							</tr>
    						</tbody>
    					</table>
    				</section>
    				
    				<? endif; ?>
    				<?   if ( !in_array("Ceremony site/accommodation only", get_field('about_need_to_know'))  ) : ?> 
    				<?   if ( get_field('about_awards_description') ) : ?>
    				
    				
    				<section class="fw">
    					<h2><span>Awards</span></h2>
    					<table cellpadding="0" cellspacing="0" class="min">
    						<tbody>
    							<tr>
    							 	<td><?= get_field('about_awards_description'); ?></td>
    							 </tr>
    							
    						</tbody>
    					</table>
    				</section>
    				
    				<? endif; endif; ?>
    				
    				<? if ( get_field('about_description') != '' ) : ?>
    				<section class="fw">
    					<h2><span>Unique Features</span></h2>
    					<table cellpadding="0" cellspacing="0" class="min">
    						<tbody>
    							<tr>
    								<td colspan="3"><?= get_field('about_description'); ?></td>
    							</tr>
    						</tbody>
    					</table>
    				</section>
    				<? endif; ?>
    				
    				<section class="fw">
    					<h2><span>Contact</span></h2>
    					<table cellpadding="0" cellspacing="0" class="min" >
    						<tr><td><ul class="center">
    							<?php $directory_meta = get_field('directory_meta');
    								// echo print_r($directory_meta, 1);
    							?>
    							<li>Website: <a href="<? if(strpos($directory_meta['website'], "http") !== true) { echo "http://",$directory_meta['website']; } ?>" target="_blank"><?php echo $directory_meta['website']; ?></a></li>
    							<li class="social">
    								<a href="<?= get_field('about_facebook_page_name') ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/icons/ico_facebook.png" alt="" /></a>
    								<a href="<?= get_field('about_twitter_handle') ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/icons/ico_twitter.png" alt="" /></a>
    							</li>
    							<li>Phone: <a href="callto:<?php echo($directory_meta['phone']); ?>"></a> <?php echo($directory_meta['phone']); ?></li>
    							<li>Email:
    							<a href="mailto:<?php echo($directory_meta['email']); ?>?&bcc=sarah@laceandcake.com.au"><?php echo($directory_meta['email']); ?></a></li>
    						</ul></td>
    						</tr>
    					</table>
    				</section>
    				
    				<table id="call2action" cellpadding="0" cellspacing="0">
    					<tr>
    						<td>Like what you see? <a href="#" class="book" data-toggle="modal" data-target="#contactForm">Book Viewing</a></td>
    						<td>Have Questions? <a href="#" class="contact" data-toggle="modal" data-target="#contactForm">Contact Venue</a></td>
    					</tr>
    				</table>
    				
    				<p class="disclaimer">Prices and details are correct at time of publication but are subject to change. Contact venue to confirm details.</p>
    				
    			</div>
    		
    		<div class="tab-pane" id="single-tab-food">
    			<section class="section">
    				<h2><span>Need to Know</span></h2>
    				
    				<table cellpadding="0" cellspacing="0">
    					<tbody class="thAlRt">
    						<tr>
    							<th>Minimum food package <small>cost pp</small></th>
    							<td><?php echo get_field('food_minimum_food_package_cost_display') ?></td>
    							<th>Minimum drinks package <small>cost pp</small></th>
    							<td><?php echo get_field('food_minimum_drinks_package_cost_display') ?></td>
    						</tr>
    						<tr>
    							<th>Vendor meal <small>cost pp</small></th>
    							<td>$<?= get_field('food_vendor_meals_cost_pp') ?></td>
    							<th>Kids' meal <small>cost pp</small></th>
    							<td>$<?= get_field('food_kids_meals_cost_pp') ?></td>
    						</tr>
    						<tr>
    							<th>Package duration</th>
    							<td>
    								<?php 
    									$FoodPackageDuration = get_field('food_package_duration_display');
    									echo $FoodPackageDuration[0];
    								 ?> hours
    							</td>
    							<th>Package extension <small>per hour pp</small></th>
    							<td><?php echo get_field('food_drinks_package_extension_display') ?></td>
    						</tr>
    						<tr>
    							
    						</tr>
    					</tbody>
    				</table>
    				
    			</section>
    			
    			<section class="fw">
    				<h2><span>Let's Eat</span></h2>
    				
    				<table cellpadding="0" cellspacing="0" class="min">
    					<tbody>
    						<tr>
    							<th>Cuisine</th>	
    							<td>
    							<?php 
    								if( count(get_field('food_cuisine')) ){
    								    echo "<ul>";
    								    foreach(get_field('food_cuisine') as $item){
    								       echo "<li>$item</li>";
    								    }
    								    echo "</ul>";
    								 }
    							 ?>
    							</td>
    						</tr>
    						<tr>
    							<th>How's it served?</th>
    							<td>
    								<?php 
    									if( count(get_field('food_food_service_options')) ){
    									    echo "<ul>";
    									    foreach(get_field('food_food_service_options') as $item){
    									       echo "<li>$item</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    						<tr>
    							<th>Waiters</th>
    							<td><!--<strong>1</strong> waiter to <strong>20</strong> Guests (approx)-->
    								<?php echo get_field('food_waitstaff_to_guest_ratio_display') ?>
    							</td>
    						</tr>
    						<tr>
    							<th>What's included?</th>
    							<td>
    								<?php 
    									if( count(get_field('food_food_package_inclusions')) ){
    									    echo "<ul>";
    									    foreach(get_field('food_food_package_inclusions') as $item){
    									    	if ( $item == "Kids' meals" ) {
    									    		echo "<li>".$item." (".get_field('food_kids_meals_included').")</li>";	
    									    	}
    									    	elseif ( $item == "Vendor meals" ) {
    									    		echo "<li>".$item." (".get_field('food_vendor_meals_included').")</li>";	
    									    	}
    									    	else {
    									    		echo "<li>$item</li>";	
    									    	}
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    						<tr>
    							<th>Extras</th>
    							<td>
    								<?php 
    									if( count(get_field('food_food_package_extras')) ){
    									    echo "<ul>";
    									    foreach(get_field('food_food_package_extras') as $item){
    									       echo "<li>$item</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    						<tr>
    							<th class="center">
    								<img src="<?php echo get_template_directory_uri(); ?>/icons/cake2.png" alt="" />
    							</th>
    							<td>
    								<?php 
    									if( count(get_field('food_cake')) ){
    									    echo "<ul>";
    									    foreach(get_field('food_cake') as $item){
    									       echo "<li>$item</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    					</tbody>
    				</table>
    				
    			</section>
    			
    			<section class="fw">
    				<h2><span>Let's Drink</span></h2>
    				<?
    					$food_drinks_package_options = get_field('food_drinks_package_options');
    					$how_its_charged = array("Charged per head", "Charged on consumption");
    					$whats_included = array("Complimentary wine tasting", "Complimentary soft drinks/juice", "Complimentary sparkling wine for toast");
    					$drink_options = array("BYO allowed", "Can upgrade", "Can extend", "Private bar");
    				?>
    				<table cellpadding="0" cellspacing="0" class="min">
    					<tbody>
    						<tr>
    							<th>How's it charged?</th>
    							<td>
    								<? 		echo "<ul>";
    								    	foreach( array_intersect($food_drinks_package_options, $how_its_charged) as $item){
    								    		echo '<li>',$item,'</li>';
    								    	}
    								    	echo "</ul>";
    								?>
    							</td>
    						</tr>
    						<tr>
    							<th>What's included?</th>
    							<td>
    								<? 		
    									echo "<ul>";
    									foreach( array_intersect($food_drinks_package_options, $whats_included) as $item){
    										echo '<li>',$item,'</li>';
    									}
    									echo "</ul>";
    								?>
    							</td>
    						</tr>
    						<tr>
    							<th>Options</th>
    							<td>
    								<? 		
    									echo "<ul>";
    									foreach( array_intersect($food_drinks_package_options, $drink_options) as $item){
    										echo '<li>',$item,'</li>';
    									}
    									echo "</ul>";
    								?>
    							</td>
    						</tr>
    					</tbody>
    				</table>
    			</section>
    			
    			<section>
    				<h2><span>Description</span></h2>
    				<table>
    					<tr>
    						<td>
    							<div class="more-less">
    							    <div class="more-block">
    							    	<div id="food_text"><?= get_field('food_text'); ?></div>
    							    </div>
    							    <a href="#" class="more"><span>+ More</span></a>
    							</div>
    						</td>
    					</tr>
    				</table>
    			</section>
    			
    			<section>
    				<h2><span>The Details</span></h2>
    				
    				<h3>Food Packages</h3>
    				<table cellpadding="0" cellspacing="0" id="food-packages">
    					<tbody>
    						<?php  
    						function clean($string) {
    						   $string = str_replace(' ', '', $string);
    						   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    						   return $string;
    						}
    						for ($i = 1; $i <= 15; $i++): ?>
    						<?		${'food_package_name_' . $i} = get_field('food_package_name_'.$i);
    								${'food_package_cost_' . $i} = get_field('food_package_cost_'.$i);
    								${'food_package_style_' . $i} = get_field('food_package_style_'.$i);
    								${'food_package_number_of_courses_' . $i} = get_field('food_package_number_of_courses_'.$i); 
                                    ${'food_package_guest_numbers_' . $i} = get_field('food_package_guest_numbers_'.$i);
                                    ${'food_package_time_of_day_' . $i} = get_field('food_package_time_of_day_'.$i);
                                    ${'food_package_lightbox_' . $i} = get_field('food_package_lightbox_'.$i);
                                    ?>
    
    							
    								<? if ( !empty(${'food_package_name_' . $i}) ): ?>
    									<tr>
    									<td><div class="food-package"><h4><a href="#" data-toggle="modal" data-target="#foodPackage-<?= clean(${'food_package_name_' . $i}) ?>"><?= ${'food_package_name_' . $i} ?></a></h4>
    										<ul class="cake">
    											<li class="pricing"><?= ${'food_package_cost_' . $i} ?><small>pp</small></li>
    											<li class="layer layer1">
    												<p><strong>Pre-Dinner Canapes</strong>
    												<?= ${'food_package_pre_dinner_canapes_' . $i} ?></p>
    											</li>
    											<li class="layer layer2">
    												<p><strong>MAIN MEAL</strong>
    												<?= ${'food_package_entrees_' . $i} ?> + <?= ${'food_package_mains_' . $i} ?><br />
    												Sides: <?= ${'food_package_sides_' . $i} ?><br />
    												Incl: <?= ${'food_package_includes_' . $i} ?></p>
    											</li>
    											<li class="layer layer3">
    												<p><strong>DESSERT</strong>
    												<? if (${'food_package_desserts_' . $i} && ${'food_package_wedding_cake_' . $i}) {
    													echo ${'food_package_desserts_' . $i}.' OR<br />'.${'food_package_wedding_cake_' . $i};
    												} 
    												elseif ( ${'food_package_desserts_' . $i} ) {
    													echo ${'food_package_desserts_' . $i};
    												}
    												elseif ( ${'food_package_wedding_cake_' . $i} ) {
    													echo ${'food_package_wedding_cake_' . $i};
    												}
    												?>
    												</p>
    											</li>
    											<li><a href="#" data-toggle="modal" data-target="#foodPackage-<?= clean(${'food_package_name_' . $i}) ?>" class="include">More Info +</a></li>
    										</ul>
    									</div>
    									<!-- Modal -->
    									<div class="modal fade" id="foodPackage-<?= clean(${'food_package_name_' . $i}) ?>" tabindex="-1" role="dialog" aria-labelledby="foodPackage-<?= clean(${'food_package_name_' . $i}) ?>-label" aria-hidden="true">
    									  <div class="modal-dialog">
    									    <div class="modal-content">
    									      <div class="modal-header">
    									        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    									        <h4 class="modal-title" id="foodPackage-<?= clean(${'food_package_name_' . $i}) ?>-label"><?= ${'food_package_name_' . $i} ?></h4>
    									      </div>
    									      <div class="modal-body">
    									      	<table cellpadding="0" cellspacing="0">
    									      		<thead>
    									      			<tr>
    									      				<th>Time of day</th>	
    									  					<th>Style</th>	
    									  					<th>Guest Numbers</th>	
    									  					<th>Package upgrade</th>	
    									  					<th>Number of courses</th>
    									      			</tr>
    									      		</thead>
    									      		<tbody>
    									      			<tr>
    									      				<td><?php foreach (${'food_package_time_of_day_' . $i} as $value) {
    									      					if ($value === end(${'food_package_time_of_day_' . $i})) {
    									  							echo $value;
    									  							continue;
    									  						}
    									      					echo $value, ", ";
    									      				} ?></td>	
    									  					<td><?= ${'food_package_style_' . $i} ?></td>	
    									  					<td><?= ${'food_package_guest_numbers_' . $i} ?></td>	
    									  					<td><?= ${'food_package_upgrade_' . $i} ?></td>	
    									  					<td><?= ${'food_package_number_of_courses_' . $i} ?></td>
    									      			</tr>
    									      		</tbody>
    									      	</table>
    									      	<table>
    									      		<tr>
    									      			<td>
    									      				<?= ${'food_package_lightbox_' . $i} ?>
    									      			</td>
    									      		</tr>
    									      	</table>
    									      	
    									      </div>
    									    </div>
    									  </div>
    									</div>
    									</td>
    									</tr>
    							<? endif; endfor; ?>
    					</tbody>
    				</table>
    				
    				<h3>Drink Packages</h3>
    				<table cellpadding="0" cellspacing="0" id="drink-packages">
    					<tbody>
    						
    							
    								<? for ($i = 1; $i <= 15; $i++): ?>
    								<?	${'food_drink_package_name_' . $i} = get_field('food_drink_package_name_'.$i);
    									${'food_drink_package_cost_' . $i} = get_field('food_drink_package_cost_'.$i);
    									${'food_drink_package_duration_' . $i} = get_field('food_drink_package_duration_'.$i);
    									${'food_drink_package_upgrades_' . $i} = get_field('food_drink_package_upgrades_'.$i);
    									${'food_drink_package_extend_' . $i} = get_field('food_drink_package_extend_'.$i);
    									${'food_drink_package_lightbox_' . $i} = get_field('food_drink_package_lightbox_'.$i); ?>
    									
    								<? if ( !empty(${'food_drink_package_name_' . $i}) ): ?>
    								
    								<tr><td>
    								<div class="drink-package">
    									<h4><a href="#" data-toggle="modal" data-target="#drinkPackage-<?= clean(${'food_drink_package_name_' . $i}) ?>"><?= ${'food_drink_package_name_' . $i} ?></a></h4>
    									<ul class="drink">
    										<li class="pricing"><?= ${'food_drink_package_cost_' . $i} ?><sup>pp</sup></li>
    										<li class="package-info">
    											<?= ${'food_drink_package_duration_' . $i} ?><br />
    											Upgrades <?= ${'food_drink_package_upgrades_' . $i} ?><br />
    											Extend <?= ${'food_drink_package_extend_' . $i} ?><br />
    										</li>
    										<li><a href="#" class="include" data-toggle="modal" data-target="#drinkPackage-<?= clean(${'food_drink_package_name_' . $i}) ?>">Includes +</a></li>
    									</ul>
    								</div>
    								
    								<!-- Modal -->
    								<div class="modal fade" id="drinkPackage-<?= clean(${'food_drink_package_name_' . $i}) ?>" tabindex="-1" role="dialog" aria-labelledby="<?= clean(${'food_drink_package_name_' . $i})?>Label" aria-hidden="true">
    								  <div class="modal-dialog">
    								    <div class="modal-content">
    								      <div class="modal-header">
    								        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    								        <h4 class="modal-title" id="<?= clean(${'food_drink_package_name_' . $i})?>Label"><?= ${'food_drink_package_name_' . $i}?> Includes</h4>
    								      </div>
    								      <div class="modal-body">
    								      	<?= ${'food_drink_package_lightbox_' . $i} ?>
    								      </div>
    								      
    								    </div>
    								  </div>
    								</div>	
    							</td></tr>
    							<? endif; endfor; ?>
    							
    					</tbody>
    				</table>
    			</section>
    			
    			<section>
    				<h2><span>Menus</span></h2>
    				
    				<div class="accordion">
    					
                        <?php
                        function display_food_menu($field_name, $title) {
                            $value = get_field($field_name);
                            $actual_content = trim(strip_tags($value));
                            if ($actual_content) {
                                ?><div class="dt package-option">
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
                        <?php display_food_menu('food_canapes', 'Canapes'); ?>
                        <?php display_food_menu('food_entrees', 'Entrees'); ?>
                        <?php display_food_menu('food_mains', 'Mains'); ?>
                        <?php display_food_menu('food_sides', 'Sides'); ?>
                        <?php display_food_menu('food_desserts', 'Desserts'); ?>
                        <?php display_food_menu('food_childrens', 'Children\'s'); ?>
                        <?php display_food_menu('food_bbq', 'BBQ'); ?>
                        <?php display_food_menu('food_buffet', 'Buffet'); ?>
                        
    					
    				</div>	
    				
    			</section>
    			
    			<table id="call2action" cellpadding="0" cellspacing="0">
    				<tr>
    					<td>Like what you see? <a href="#" class="book" data-toggle="modal" data-target="#contactForm">Book Viewing</a></td>
    					<td>Have Questions? <a href="#" class="contact" data-toggle="modal" data-target="#contactForm">Contact Venue</a></td>
    				</tr>
    			</table>
    			
    			<p class="disclaimer">Prices and details are correct at time of publication but are subject to change. Contact venue to confirm details.</p>
    			
    		</div>
    		<div class="tab-pane" id="single-tab-rooms">
    			
    			
    				
    				<section>
    					<h2><span>Need to Know</span></h2>
    				
    				
    				
    				<h3>Room Details</h3>
    				<table cellpadding="0" cellspacing="0">
    					<tbody>
    						<tr>
    							<th>Music/dancing	</th>
    							<td>
    								<?php 
    									if( count(get_field('details_room_features')) ){
    									    echo "<ul class='icons'>";
    									    foreach(get_field('details_room_features') as $item){
    									       
    									       $musicClass = "";
    									       if (strpos($item,'Dance floor') !== false) {
    									       	   $musicClass = "dance-floor";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Space for a DJ') !== false) {
    									       	   $musicClass = "dj";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Space for a band') !== false) {
    									       	   $musicClass = "band";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Sound system an iPod') !== false) {
    									       	   $musicClass = "ipod";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    								
    							</td>
    							</tr><tr>
    							<th>Speeches</th>	
    							<td>
    								<?php 
    									if( count(get_field('details_room_features')) ){
    									    echo "<ul class='icons'>";
    									    foreach(get_field('details_room_features') as $item){
    									       
    									       $musicClass = "";
    									       if (strpos($item,'A/V equipment for slideshows/videos') !== false) {
    									       	   $musicClass = "slideshow";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Stage') !== false) {
    									       	   $musicClass = "stage";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Microphone/PA system for speeches') !== false) {
    									       	   $musicClass = "mic";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    							</tr>
    							<th>Features</th>
    							<td>
    								<?php 
    									if( count(get_field('details_room_features')) ){
    									    echo "<ul class='icons'>";
    									    foreach(get_field('details_room_features') as $item){
    									       
    									       $musicClass = "";
    									       if (strpos($item,'Back up power supply') !== false) {
    									       	   $musicClass = "power";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Special lighting') !== false) {
    									       	   $musicClass = "lighting";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Heating') !== false) {
    									       	   $musicClass = "heating";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									       elseif (strpos($item,'Airconditioning') !== false) {
    									       	   $musicClass = "ac";
    									       	   echo "<li class='". $musicClass ."'>$item</li>";
    									       }
    									    }
    									    if (get_field('details_must_select_from_preferred_vendor_list') == "No") {
    									    	  $musicClass = 'vendor vendorNo yes';
    									      	  echo "<li class='". $musicClass ."'>Can select own vendors</li>";
    									    } 
    									    else {
    									    	$musicClass = 'vendor vendorYes no';
    									    	echo "<li class='". $musicClass ."'>Must select vendors from preferred list</li>";
    									    }
    									    if (get_field('details_reception_set_up_timing')) {
    									    		$musicClass = 'access time';
    									    		echo "<li class='". $musicClass ."'>Venue access - ".get_field('details_reception_set_up_timing')."</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    					</tbody>
    				</table>
    				
    				<h3>Tables</h3>
    				<table cellpadding="0" cellspacing="0">
    					<tbody>
    						<tr>
    							<th>Shape	</th>
    							<td colspan="2">
    								<?php if(in_array('Square', get_field('details_tables'))): ?>
    								<img class="icon-sm" src="<?php echo get_template_directory_uri(); ?>/icons/square.png" alt="" />
    								<?php endif; ?>
    								<?php if(in_array('Round', get_field('details_tables'))): ?>
    								<img class="icon-sm" src="<?php echo get_template_directory_uri(); ?>/icons/circle.png" alt="" />
    								<?php endif; ?>
    								<?php if(in_array('Long/rectangle', get_field('details_tables'))): ?>
    								<img class="icon-sm" src="<?php echo get_template_directory_uri(); ?>/icons/rectangle.png" alt="" />
    								<?php endif; ?>
    							</td>
    						</tr>
    						<tr>
    							<th><img class="icon-sm" src="<?php echo get_template_directory_uri(); ?>/icons/person1.png" alt="" /></th>
    							<td colspan="2"><?
    								
    								foreach(array_slice(get_field('details_tables'),2) as $item){
    									if ( strpos($item,'per table') !== false) {
    										echo($item);
    									}
    								}
    							 ?></td>
    						</tr>
    						<tr>
    							<th>Layout	</th>
    							<td colspan="2">
    								<?php 
    									if( count(get_field('details_tables')) ){
    									    echo "<ul>";
    									    foreach(array_slice(get_field('details_tables'),2) as $item){
    									    	$liClass;
    									    	if ( strpos($item,'Long/rectangle') !== false || strpos($item,'Round') !== false || strpos($item,'Square') !== false || strpos($item,'per table') !== false) {
    									    		$liClass = "hidden";
    									    	} 
    									    	else {
    									    		echo "<li>$item</li>";	
    									    	}
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    							
    						</tr>
    						<tr>
    							<th>Chair type	</th>
    							<td colspan="2">
    								<?php 
    									if( count(get_field('details_chairs')) ){
    									    echo "<ul>";
    									    foreach(get_field('details_chairs') as $item){
    									       echo "<li>$item</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    						
    					</tbody>
    				</table>
    				
    				
    				
    				<h3>Decorations</h3>
    				<table cellpadding="0" cellspacing="0">
    					<tbody>
    						<tr>
    							<th>Decorations allowed</th>	
    							<td>
    								<?php 
    									if( count(get_field('details_decorations_allowed')) ){
    									    echo "<ul class='icons'>";
    									    foreach(get_field('details_decorations_allowed') as $item){
    									    
    									    	$decorationsClass = "";
    									    	if (strpos($item,'Candles') !== false || strpos($item,'Candles/candelabras') !== false) {
    									    		   $decorationsClass = "candles";
    									    	}
    									    	elseif (strpos($item,'Fairy lights') !== false) {
    									    		   $decorationsClass = "lights";
    									    	}
    									    	elseif (strpos($item,'Balloons') !== false) {
    									    		   $decorationsClass = "balloons";
    									    	}
    									    	elseif (strpos($item,'Fireworks') !== false) {
    									    		   $decorationsClass = "fireworks";
    									    	}
    									    	elseif (strpos($item,'Photo booth') !== false) {
    									    		   $decorationsClass = "photobooth";
    									    	}
    									    	elseif (strpos($item,'Can hang from walls/ceiling') !== false) {
    									    		   $decorationsClass = "hang";
    									    	}
    									    	elseif (strpos($item,'Cutlery, crockery, glassware') !== false) {
    									    		   $decorationsClass = "cutlery";
    									    	}
    									    	elseif (strpos($item,'Linens & napkins') !== false) {
    									    		   $decorationsClass = "linens";
    									    	}
    									    	elseif (strpos($item,'Chair covers/sashes') !== false) {
    									    		   $decorationsClass = "chairs";
    									    	}
    									    	elseif (strpos($item,'Table arrangements') !== false) {
    									    		   $decorationsClass = "tablearr";
    									    	}
    									    	elseif (strpos($item,'Bonbonnieres') !== false) {
    									    		   $decorationsClass = "bonbonnieres";
    									    	}
    									    	else {
    									    		   $decorationsClass = "yes";
    									    	}
    									    	
    									       echo "<li class='".$decorationsClass."'>$item</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    						<tr>
    							<th>Decorations included in packages	</th>
    							<td>
    								<?php 
    									if( count(get_field('details_decorations_included_in_packages')) ){
    									    echo "<ul class='icons'>";
    									    foreach(get_field('details_decorations_included_in_packages') as $item){
    									    	$decorationsClass = "";
    									    	if (strpos($item,'Candles') !== false || strpos($item,'Candles/candelabras') !== false) {
    									    		   $decorationsClass = "candles";
    									    	}
    									    	elseif (strpos($item,'Fairy lights') !== false) {
    									    		   $decorationsClass = "lights";
    									    	}
    									    	elseif (strpos($item,'Balloons') !== false) {
    									    		   $decorationsClass = "balloons";
    									    	}
    									    	elseif (strpos($item,'Fireworks') !== false) {
    									    		   $decorationsClass = "fireworks";
    									    	}
    									    	elseif (strpos($item,'Photo booth') !== false) {
    									    		   $decorationsClass = "photobooth";
    									    	}
    									    	elseif (strpos($item,'Can hang from walls/ceiling') !== false) {
    									    		   $decorationsClass = "hang";
    									    	}
    									    	elseif (strpos($item,'Cutlery, crockery, glassware') !== false) {
    									    		   $decorationsClass = "cutlery";
    									    	}
    									    	elseif (strpos($item,'Linens & napkins') !== false) {
    									    		   $decorationsClass = "linens";
    									    	}
    									    	elseif (strpos($item,'Chair covers/sashes') !== false) {
    									    		   $decorationsClass = "chairs";
    									    	}
    									    	elseif (strpos($item,'Table arrangements') !== false) {
    									    		   $decorationsClass = "tablearr";
    									    	}
    									    	elseif (strpos($item,'Bonbonnieres') !== false) {
    									    		   $decorationsClass = "bonbonnieres";
    									    	}
    									    	else {
    									    		   $decorationsClass = "yes";
    									    	}
    									       echo "<li class='".$decorationsClass."'>$item</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    						<tr>
    							<th>Venue will set up</th>
    							<td>
    								<?php 
    									if( count(get_field('details_venue_will_set_up')) ){
    									    echo "<ul class='icons'>";
    									    foreach(get_field('details_venue_will_set_up') as $item){
    									       $decorationsClass = "";
    									       if (strpos($item,'Candles') !== false || strpos($item,'Candles/candelabras') !== false) {
    									       	   $decorationsClass = "candles";
    									       }
    									       elseif (strpos($item,'Fairy lights') !== false) {
    									       	   $decorationsClass = "lights";
    									       }
    									       elseif (strpos($item,'Balloons') !== false) {
    									       	   $decorationsClass = "balloons";
    									       }
    									       elseif (strpos($item,'Fireworks') !== false) {
    									       	   $decorationsClass = "fireworks";
    									       }
    									       elseif (strpos($item,'Photo booth') !== false) {
    									       	   $decorationsClass = "photobooth";
    									       }
    									       elseif (strpos($item,'Can hang from walls/ceiling') !== false) {
    									       	   $decorationsClass = "hang";
    									       }
    									       elseif (strpos($item,'Cutlery, crockery, glassware') !== false) {
    									       	   $decorationsClass = "cutlery";
    									       }
    									       elseif (strpos($item,'Linens & napkins') !== false) {
    									       	   $decorationsClass = "linens";
    									       }
    									       elseif (strpos($item,'Chair covers/sashes') !== false) {
    									       	   $decorationsClass = "chairs";
    									       }
    									       elseif (strpos($item,'Table arrangements') !== false) {
    									       	   $decorationsClass = "tablearr";
    									       }
    									       elseif (strpos($item,'Bonbonnieres') !== false) {
    									       	   $decorationsClass = "bonbonnieres";
    									       }
    									       else {
    									       	   $decorationsClass = "yes";
    									       }
    									       echo "<li class='".$decorationsClass."'>$item</li>";
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    								
    							</td>
    						</tr>
    					</tbody>
    				</table>
    				
    				</section>
    				
    				<section>
    					<h2><span>Description</span></h2>
    					<table cellpadding="0" cellspacing="0" class="min">
    						<tbody>
    							<tr>
    								<td>
    									<div class="more-less">
    									    <div class="more-block">
    									    	<div id="details_text"><?= get_field('details_text') ?></div>
    									    </div>
    									    <a href="#" class="more"><span>+ More</span></a>
    									</div>
    								</td>
    							</tr>
    						</tbody>
    					</table>
    				</section>
    				
    				
    						<? if ( get_field('details_decoration_package_name_1') ) : ?>
    						
    						<section>
    						<h2><span>Decoration Packages</span></h2>
    						<table cellpadding="0" cellspacing="0">
    							<tbody>
    						
    						<?   for ($i = 1; $i <= 15; $i++): ?>
    						<?  ${'details_decoration_package_name_' . $i} = get_field('details_decoration_package_name_'.$i);
    							${'details_decoration_package_information_' . $i} = get_field('details_decoration_package_information_'.$i); 
    						 	if ( !empty(${'details_decoration_package_name_' . $i}) ): ?>
    							<tr>
    								<th><h4><?= ${'details_decoration_package_name_' . $i} ?></h4></th>
    								<td><?= ${'details_decoration_package_information_' . $i} ?></td>
    							</tr>
    						<? endif; endfor; ?>
    							
    							</tbody>
    							</table>
    							</section>
    							
    						<? endif; ?>
    				
    				<section class="fw">
    					<h2><span>Room Details</span></h2>
    					
    					<table cellpadding="0" cellspacing="0" class="min">
    						<thead>
    							<tr>
    								<th></th>
    								<th>Capacity <br />Seated</th>	
    								<th>Capacity <br />Cocktail</th>	
    								<th>Hire Cost</th>	
    								<th>Hire Time</th> 	
    								<th>Hire extension <br />(cost per hour)</th>
    							</tr>
    						</thead>
    						<tbody>
    							<?php 
    								for ($i = 1; $i <= 15; $i++) {
    									
    									${'details_room_name_' . $i} = get_field('details_room_name_'.$i);
    									${'details_room_photo_' . $i} = get_field('details_room_photo_'.$i);
    									${'details_room_capacity_seated_' . $i} = get_field('details_room_capacity_seated_'.$i);
    									${'details_room_capacity_cocktail_' . $i} = get_field('details_room_capacity_cocktail_'.$i);
    									${'details_room_hire_cost_' . $i} = get_field('details_room_hire_cost_'.$i);
    									${'details_room_hire_time_' . $i} = get_field('details_room_hire_time_'.$i);
    									${'details_room_hire_extension_' . $i} = get_field('details_room_hire_extension_'.$i);
    									${'details_room_information_' . $i} = get_field('details_room_information_'.$i);
    								
    									// echo '<pre>'.${'details_room_name_' . $i}.'</pre>';
    								
    									// if (!isset(${'details_room_name_' . $i})) continue;
    									if ( !empty(${'details_room_name_' . $i}) ) {
    										echo '<tr><th class="roomName" rowspan="2"><h4>' . ${'details_room_name_' . $i} . '</h4>';
    										echo '<span class="frame"><img src="'.${'details_room_photo_' . $i}['sizes']['javo-box'].'" /></span></th>';
    										echo '<td>' . ${'details_room_capacity_seated_' . $i} . '</td>';
    										echo '<td>' . ${'details_room_capacity_cocktail_' . $i} . '</td>';
    										echo '<td>' . ${'details_room_hire_cost_' . $i} . '</td>';
    										echo '<td>' . ${'details_room_hire_time_' . $i} . '</td>';
    										echo '<td>' . ${'details_room_hire_extension_' . $i} . '</td></tr>';
    										echo '<tr><td colspan="5">' . ${'details_room_information_' . $i} . '</td></tr>';	
    									} else {
    										break;
    									}
    								}
    							 ?>
    							
    						</tbody>
    					</table>
    					
    						
    				</section>
    				
    				<table id="call2action">
    					<tr>
    						<td>Like what you see? <a href="#" class="book" data-toggle="modal" data-target="#contactForm">Book Viewing</a></td>
    						<td>Have Questions? <a href="#" class="contact" data-toggle="modal" data-target="#contactForm">Contact Venue</a></td>
    					</tr>
    				</table>
    				
    				<p class="disclaimer">Prices and details are correct at time of publication but are subject to change. Contact venue to confirm details.</p>
    				
    				
    		</div>
    		<div class="tab-pane" id="single-tab-ceremony">
    			<section class="fw">
    				<h2><span>Need to Know</span></h2>
    				<table cellpadding="0" cellspacing="0" cellpadding="min">
    					<thead>
    						<tr>
    							<th>Site type</th>	
    							<th>Space</th>
    							<th>Hire Cost</th>	
    							<th>Hire Length</th>
    							<th>Minimum Guests</th>	
    							<th>Maximum Guests</th>	
    							<th>Chairs <small>included in package</small></th>	
    							<th>Extra <small>cost per chair</small></th>
    						</tr>
    					</thead>
    					<tbody>
    					
    						<?php 
    							
    							if ( get_field('ceremony_site_type') ) {
    								$ceremony_site_type =  get_field('ceremony_site_type');
    								$ceremony_site_photo = get_field('ceremony_site_photo');
    								$ceremony_site_space;
    
    								if ( $ceremony_site_type[1] == 'Cellar door'  ) {
    									$ceremony_site_space = $ceremony_site_type[0];
    									$ceremony_site_type =  $ceremony_site_type[1];
    								}
    								else {
    									$ceremony_site_space = $ceremony_site_type[1];
    									$ceremony_site_type =  $ceremony_site_type[0];
    								}
    								
    								echo '<tr><th width="300px"><h4>' . $ceremony_site_type . '</h4>';
    								echo '<span class="frame"><img src="'.$ceremony_site_photo['sizes']['javo-box'].'" /></span></th>'; 
    								/*if( in_array('Is outdoor', get_field('ceremony_site_type')) ) {
    									echo '<td>Is outdoor</td>';
    								} 
    								if(in_array('Is indoor', get_field('ceremony_site_type')) ) {
    									echo '<td>Is indoor</td>';
    								}*/
    								echo '<td>' . $ceremony_site_space . '</td>';
    								echo '<td>' . get_field('ceremony_site_hire_cost_display') . '</td>';
    								echo '<td>' . get_field('ceremony_site_hire_duration_display') . '</td>';
    								echo '<td>' . get_field('ceremony_site_minimum_guest_numbers_display') . '</td>';
    								echo '<td>' . get_field('ceremony_site_maximum_guest_numbers_display') . '</td>';
    								echo '<td>' . get_field('ceremony_number_of_chairs_provided_display') . '</td>';
    								echo '<td>$' . get_field('ceremony_chair_hire_cost_per_chair') . '</td></tr>';
    							}
    							
    							for ($i = 2; $i <= 15; $i++) {
    								
    								/*${'ceremony_site_type_' . $i} = get_field('ceremony_site_type_'.$i);
    								${'ceremony_site_space_' . $i};
    								if(in_array('Is outdoor', ${'ceremony_site_type_' . $i})) {
    									${'ceremony_site_space_' . $i} = "Is outdoor";
    								} 
    								elseif(in_array('Is indoor', ${'ceremony_site_type_' . $i})) {
    									${'ceremony_site_space_' . $i} = "Is indoor";
    								}*/
    								
    								${'ceremony_site_type_' . $i} = get_field('ceremony_site_type_'.$i);
    								${'ceremony_site_space_' . $i};
    								if ( ${'ceremony_site_type_' . $i}[1] == 'Cellar door'  ) {
    									${'ceremony_site_space_' . $i} = ${'ceremony_site_type_' . $i}[0];
    									${'ceremony_site_type_' . $i} =  ${'ceremony_site_type_' . $i}[1];
    								}
    								else {
    									${'ceremony_site_space_' . $i} = ${'ceremony_site_type_' . $i}[1];
    									${'ceremony_site_type_' . $i} =  ${'ceremony_site_type_' . $i}[0];
    								}
    								
    								${'ceremony_site_photo_' . $i} = get_field('ceremony_site_photo_'.$i);
    								${'ceremony_site_hire_cost_display_' . $i} = get_field('ceremony_site_hire_cost_display_'.$i);
    								${'ceremony_site_hire_duration_display_' . $i} = get_field('ceremony_site_hire_duration_display_'.$i);
    								${'ceremony_site_minimum_guest_numbers_display_' . $i} = get_field('ceremony_site_minimum_guest_numbers_display_'.$i);
    								${'ceremony_site_maximum_guest_numbers_display_' . $i} = get_field('ceremony_site_maximum_guest_numbers_display_'.$i);
    								${'number_of_chairs_provided_display_' . $i} = get_field('number_of_chairs_provided_display_'.$i);
    								${'chair_hire_cost_per_chair_' . $i} = get_field('chair_hire_cost_per_chair_'.$i);
    								
    								// echo '<pre>'.print_r(${'ceremony_site_type_' . $i},1).'</pre>';
    							
    								if ( !empty(${'ceremony_site_type_' . $i}) ) {
    									echo '<tr><th width="300px"><h4>' . ${'ceremony_site_type_' . $i} . '</h4>';
    									echo '<span class="frame"><img src="'.${'ceremony_site_photo_' . $i}['sizes']['javo-box'].'" /></span></th>';
    									echo '<td>' . ${'ceremony_site_space_' . $i} . '</td>';
    									echo '<td>' . ${'ceremony_site_hire_cost_display_' . $i} . '</td>';
    									echo '<td>' . ${'ceremony_site_hire_duration_display_' . $i} . '</td>';
    									echo '<td>' . ${'ceremony_site_minimum_guest_numbers_display_' . $i} . '</td>';
    									echo '<td>' . ${'ceremony_site_maximum_guest_numbers_display_' . $i} . '</td>';
    									echo '<td>' . ${'number_of_chairs_provided_display_' . $i} . '</td>';
    									echo '<td>$' . ${'chair_hire_cost_per_chair_' . $i} . '</td></tr>';
    								} else {
    									break;
    								}
    							}
    						?>
    					</tbody>
    				</table>
    					
    			</section>
    			
    			<section class="fw">
    				<h2><span>The Details</span></h2>
    				<table cellpadding="0" cellspacing="0" class="min">
    					<tbody>
    						<tr>
    							<th>Friendly For</th>
    							<td>
    								<?php 
    									if( count(get_field('ceremony_site_features')) ){
    									    echo "<ul class='icons'>";
    									    foreach(get_field('ceremony_site_features') as $item){
    									    	$friendlyforClass = "";
    									    	if ( strpos($item,'Disabled accessable') !== false ) {
    									    		$friendlyforClass = "wheelchair";
    									    		echo "<li class='".$friendlyforClass."'><span>Disabled Guests</span></li>";
    									    	}
    									    	elseif ( strpos($item,'Child friendly') !== false ) {
    									    		$friendlyforClass = "pram";
    									    		echo "<li class='".$friendlyforClass."'><span>Children</span></li>";
    									    	}
    									    	elseif ( strpos($item,'Pet friendly') !== false ) {
    									    		$friendlyforClass = "dog";
    									    		echo "<li class='".$friendlyforClass."'><span>Pets</span></li>";
    									    	}
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    						<tr>
    							<th>Features</th>
    							<td>
    							<?php 
    								if( count(get_field('ceremony_site_features')) ){
    								    echo "<ul>";
    								    foreach(get_field('ceremony_site_features') as $item){
    								       if ( strpos($item,'Disabled accessable') !== false || strpos($item,'Child friendly') !== false || strpos($item,'Pet friendly') !== false) { 
    								       		continue;
    								       }
    								       else {
    								       		echo "<li>$item</li>";	
    								       }
    								    }
    								    echo "</ul>";
    								 }
    							 ?>
    							</td>
    						</tr>
    						<tr>
    							<th>Decorations included </th>
    							<td>
    								<?php 
    									if( count(get_field('ceremony_site_decorations')) ){
    									    echo '<ul class="icons">';
    									    foreach(get_field('ceremony_site_decorations') as $item){
    									       // echo "<li>$item</li>";
    									       $decorIncClass = "";
    									       if ( strpos($item,'Can throw confetti/rice') !== false ) {
    									       		$decorIncClass = "confetti";
    									       		echo "<li class='".$decorIncClass."'><span>$item</span></li>";
    									       }
    									       elseif ( strpos($item,'Chairs') !== false ) {
    									       		$decorIncClass = "chairs";
    									       		echo "<li class='".$decorIncClass."'><span>$item</span></li>";
    									       }
    									       elseif ( strpos($item,'Wedding arbour') !== false ) {
    									       		$decorIncClass = "arbour";
    									       		echo "<li class='".$decorIncClass."'><span>$item</span></li>";
    									       }
    									       elseif ( strpos($item,'Signing table') !== false ) {
    									       		$decorIncClass = "stable";
    									       		echo "<li class='".$decorIncClass."'><span>$item</span></li>";
    									       }
    									       elseif ( strpos($item,'Microphone/PA system') !== false ) {
    									       		$decorIncClass = "mic";
    									       		echo "<li class='".$decorIncClass."'><span>$item</span></li>";
    									       }
    									       elseif ( strpos($item,'Aisle runner') !== false ) {
    									       		$decorIncClass = "vineyard";
    									       		echo "<li class='".$decorIncClass."'><span>$item</span></li>";
    									       }
    									    }
    									    echo "</ul>";
    									 }
    								 ?>
    							</td>
    						</tr>
    					</tbody>
    				</table>
    			</section>
    			
    			<section class="fw">
    				<h2><span>Description</span></h2>
    				<table cellpadding="0" cellspacing="0" class="min">
    					<tbody>
    						<tr>
    							<td>
    								
    								<div class="more-less">
    								    <div class="more-block">
    								    	<div id="details_text"><?= get_field('ceremony_text'); ?></div>
    								    </div>
    								    <a href="#" class="more"><span>+ More</span></a>
    								</div>
    							</td>
    						</tr>
    					</tbody>
    				</table>
    			</section>
    			
    			<table id="call2action">
    				<tr>
    					<td>Like what you see? <a href="#" class="book" data-toggle="modal" data-target="#contactForm">Book Viewing</a></td>
    					<td>Have Questions? <a href="#" class="contact" data-toggle="modal" data-target="#contactForm">Contact Venue</a></td>
    				</tr>
    			</table>
    			
    			<p class="disclaimer">Prices and details are correct at time of publication but are subject to change. Contact venue to confirm details.</p>
    			
    			
    		</div>
    		<div class="tab-pane" id="single-tab-accomodation">
    				<section class="fw">
    					<h2><span>Need to Know</span></h2>
    					
    					<div class="sub-section min">
    							<table cellpadding="0" cellspacing="0" cellpadding="min">
    								<tr>
    									<th>Accomodation type</th>
    									<td><?= get_field('accommodation_type'); ?></td>
    								</tr>
    								<tr>
    									<th>Number of rooms</th>	
    									<td><?= get_field('accommodation_number_of_rooms_display'); ?></td>
    								</tr>
    								<tr>
    									<th>People</th>	
    									<td><?= get_field('accommodation_capacity_display'); ?></td>
    								</tr>
    								<tr>
    									<th>Cheapest Room 
    									<small>(per room/per night)</small> 	</th>
    									<td><?= get_field('accommodation_cheapest_room_rate_display'); ?></td>							
    								</tr>
    								<tr>
    									<th>Friendly For</th>
    									<td>
    										<!--<ul class="hlist">
    											<li class="wheelchair"><span>Wheelchair</span></li>
    											<li class="pram"><span>Pram</span></li>
    											<li class="dog"><span>Dog</span></li>
    										</ul>-->
    										<?php if( count(get_field('accommodation_features')) ){
    										    echo "<ul class='icons'>";
    										    foreach(get_field('accommodation_features') as $item){
    										    	$friendlyforClass = "";
    										    	if ( strpos($item,'Wheelchair friendly rooms') !== false ) {
    										    		$friendlyforClass = "wheelchair";
    										    		echo "<li class='".$friendlyforClass."'><span>Disabled Guests</span></li>";
    										    	}
    										    	elseif ( strpos($item,'Pet friendly rooms') !== false ) {
    										    		$friendlyforClass = "dog";
    										    		echo "<li class='".$friendlyforClass."'><span>Pets</span></li>";
    										    	}
    										       // echo "<li class='".$friendlyforClass."'><span>$item</span></li>";
    										    }
    										    echo "</ul>";
    										 } ?>
    									</td>
    								</tr>
    								<tr>
    									<th>Features</th>
    									<td>
    									<?php 
    										if( count(get_field('accommodation_features')) ){
    										    echo "<ul class='icons'>";
    										    foreach(get_field('accommodation_features') as $item){
    										       $accomodationFeaturesClass = "";
    										      
    										       
    										       if (strpos($item,'Easy access to vineyards') !== false) {
    										       	   $accomodationFeaturesClass = "vineyard";
    										       }
    										       elseif (strpos($item,'Tennis court') !== false) {
    										       	   $accomodationFeaturesClass = "tennis";
    										       }
    										       elseif (strpos($item,'Golf course') !== false) {
    										       	   $accomodationFeaturesClass = "golf";
    										       }
    										       elseif (strpos($item,'Scenic gardens') !== false) {
    										       	   $accomodationFeaturesClass = "gardens";
    										       }
    										       elseif (strpos($item,'Swimming pool') !== false) {
    										       	   $accomodationFeaturesClass = "pool";
    										       }
    										       elseif (strpos($item,'Spa/sauna') !== false) {
    										       	   $accomodationFeaturesClass = "spa";
    										       }
    										       elseif (strpos($item,'Beautician') !== false) {
    										       	   $accomodationFeaturesClass = "beautician";
    										       }
    										       elseif (strpos($item,'Hairdresser') !== false) {
    										       	   $accomodationFeaturesClass = "hair";
    										       }
    										       elseif (strpos($item,'Exclusive use possible') !== false) {
    										       	   $accomodationFeaturesClass = "exclusive";
    										       }
    										       elseif (strpos($item,'Exclusive use discount') !== false) {
    										       	   $accomodationFeaturesClass = "discount hidden";
    										       }
    										       elseif (strpos($item,'Arranges guest activities') !== false) {
    										       	   $accomodationFeaturesClass = "yes";
    										       }
    										       elseif (strpos($item,'Single night bookings ok') !== false) {
    										       	   $accomodationFeaturesClass = "yes";
    										       }
    										       elseif (strpos($item,'Mid-week discount') !== false) {
    										       	   $accomodationFeaturesClass = "discount hidden";
    										       }
    										       elseif (strpos($item,'Wheelchair friendly rooms') !== false) {
    										       	   $accomodationFeaturesClass = "wheelchair hidden";
    										       }
    										       elseif (strpos($item,'Pet friendly rooms') !== false) {
    										       	   $accomodationFeaturesClass = "pet hidden";
    										       }
    										       elseif (strpos($item,'Babysitting') !== false) {
    										       	   $accomodationFeaturesClass = "babysitting";
    										       }
    										       elseif (strpos($item,'Cellar door') !== false) {
    										       	   $accomodationFeaturesClass = "cellar";
    										       }
    										       elseif (strpos($item,'Mid-week stays possible') !== false) {
    										       	   $accomodationFeaturesClass = "yes";
    										       }
    										       elseif (strpos($item,'Free bride/groom accommodation') !== false) {
    										       	   $accomodationFeaturesClass = "offer hidden";
    										       }
    										       elseif (strpos($item,'Free anniversary night accommodation') !== false) {
    										       	   $accomodationFeaturesClass = "offer";
    										       }
    										       else {
    										       		$accomodationFeaturesClass = "yes";
    										       }
    										       echo "<li class='".$accomodationFeaturesClass."'>$item</li>";
    										    }
    										    echo "</ul>";
    										 }
    									 ?>
    										
    									</td>
    								</tr>
    								
    							</table>
    						
    					</div>
    					
    								
    				</section>
    				
    				
    				<section>
    					<h2><span>Costs</span></h2>
                                <?php    							
    							if( get_field('accommodation_discounts') ) : ?>
    							
    							<h3>Discounts</h3>
    							<table cellpadding="0" cellspacing="0">
    							
    							    
    							<?    foreach(get_field('accommodation_discounts') as $item){
    							       echo "<tr><th>$item</th>";
    							       echo "<td>";
    							       if (strpos($item,'Bride/groom') !== false) {
    							           echo get_field('accommodation_discounts_bride_groom');
    							       } 
    							       elseif (strpos($item,'Bridal party') !== false) {
    							       		echo get_field('accommodation_discounts_bridal_party');
    							       }
    							       elseif (strpos($item,'Guest') !== false) {
    							       		echo get_field('accommodation_discounts_guest');
    							       }
    							       elseif (strpos($item,'Exclusive Use') !== false) {
    							       		echo get_field('accommodation_discounts_exclusive_use');
    							       }
    							       elseif (strpos($item,'Mid-week') !== false) {
    							       		echo get_field('accommodation_discounts_mid_week');
    							       }
    							       elseif (strpos($item,'Large group') !== false) {
    							       		echo get_field('accommodation_discounts_large_group');
    							       }
    							       elseif (strpos($item,'Long stay') !== false) {
    							       		echo get_field('accommodation_discounts_long_stay');
    							       }
    							       elseif (strpos($item,'Family') !== false) {
    							       		echo get_field('accommodation_discounts_family');
    							       }
    							       echo "</td></tr>";
    							    } ?>
    							 
    							 </table>
    							 </section>
    							
    						 <? endif; ?>
    					
    			
    					
    					<section>
    					<h2><span>Room Descriptions</span></h2>
    					<table cellpadding="0" cellspacing="0">
    						<?php 
    							for ($i = 1; $i <= 15; $i++) {
    								
    								${'accommodation_room_name_' . $i} = get_field('accommodation_room_name_'.$i);
    								${'accommodation_room_description_' . $i} = get_field('accommodation_room_description_'.$i);
    								${'accommodation_room_photo_' . $i} = get_field('accommodation_room_photo_'.$i);
    								
    								// echo '<pre>'.${'accommodation_room_name_' . $i}.'</pre>';
    							
    								if ( !empty(${'accommodation_room_name_' . $i}) ) {
    									echo '<tr><th width="300px"><h4>' . ${'accommodation_room_name_' . $i} . '</h4>';
    									echo '<span class="frame"><img src="'.${'accommodation_room_photo_' . $i}['sizes']['javo-box'].'" /></span></th>';
    									echo '<td>' . ${'accommodation_room_description_' . $i} . '</td></tr>';
    								} else {
    									break;
    								}
    							}
    						?>
    						
    					</table>
    				</section>
    				
    				<table id="call2action" cellpadding="0" cellspacing="0">
    					<tr>
    						<td>Like what you see? <a href="#" class="book" data-toggle="modal" data-target="#contactForm">Book Viewing</a></td>
    						<td>Have Questions? <a href="#" class="contact" data-toggle="modal" data-target="#contactForm">Contact Venue</a></td>
    					</tr>
    				</table>
    				
    				<p class="disclaimer">Prices and details are correct at time of publication but are subject to change. Contact venue to confirm details.</p>
    				
    		</div>
    		
        </div>
</div> <!-- tabs-wrap -->

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#single-tabs').tab();
		// link to specific single-tabs
		var hash = location.hash
		  , hashPieces = hash.split('?')
		  , activeTab = hashPieces[0] != '' ? $('[href=' + hashPieces[0] + ']') : null;
		activeTab && activeTab.tab('show');
		
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
		
		$(".more").toggle(function() {
				$(this).parents("div:first").find(".more-block").css('height', 'auto').css('overflow', 'visible');
				// Hide the [...] when expanded
				$(this).parents("div:first").find("p.continued").css('display', 'none');
				$(this).text(lessText);
			}, function() {
				$(this).parents("div:first").find(".more-block").css('height', adjustheight).css('overflow', 'hidden');
				$(this).parents("div:first").find("p.continued").css('display', 'block');
				$(this).text(moreText);
		});
		
		var ntabs = $('#single-tabs li').length;
		// console.log(ntabs);
		if ( ntabs != 5 ) {
			$('#single-tabs li').css({'width': (99.5/ntabs)+'%'});	
		}
		if ( ntabs == 4 ) {
			$('#single-tabs li').css({'width': (99.0/ntabs)+'%'});	
		}
		
		$( ".contact" ).click(function() {
			$('#contactFormLabel').text('Contact Venue');
			$('#contactForm option:contains("Inquiry")').prop('selected', true);
		});
		
		$( ".book" ).click(function() {
			$('#contactFormLabel').text('Book Viewing');
			$('#contactForm option:contains("Book")').prop('selected', true);
		});
		
		$('.accordion').find('.accordion-toggle').click(function(){
		  $(this).next().slideToggle('fast');
		  $(".accordion-content").not($(this).next()).slideUp('fast');
		});
		
    });
</script>