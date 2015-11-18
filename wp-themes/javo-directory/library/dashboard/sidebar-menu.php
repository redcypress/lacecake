<?php
/**
*** Sidebar Menu
***/
global
	$javo_custom_item_label
	, $javo_custom_item_tab;
?>
	<div class="col-xs-6 col-sm-2 sidebar-offcanvas main-content-left my-page-nav" id="sidebar" role="navigation">
		<p class="visible-xs">
			<button type="button" class="btn btn-primary btn-xs" data-toggle="mypage-offcanvas">
				<i class="glyphicon glyphicon-chevron-left"><?php _e('Close', 'javo_fr');?></i>
			</button>
		</p>
		<div class="well sidebar-nav mypage-left-menu">
			<ul class="nav nav-sidebar">
				<li class="titles profile">
					<?php _e('PROFILE', 'javo_fr');?>
				</li>
				<!-- Profile -->
					<li class="side-menu home">
						<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login);?>">
							<i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Home', 'javo_fr');?>
						</a>
					</li>
					<li class="side-menu edit-profile">
						<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_PROFILE_SLUG);?>">
							<i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Edit My Profile', 'javo_fr');?>
						</a>
					</li>
					<li class="side-menu edit-password">
						<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_LOSTPW_SLUG);?>">
							<i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Change Password', 'javo_fr');?>
						</a>
					</li>
				<!-- Profile -->
			</ul>
			<ul class="nav nav-sidebar">
				<li class="titles my-shop">
					<?php _e('My Shops', 'javo_fr');?>
				</li>
				<!-- My Shops -->
					<li class="side-menu saved-shop">
						<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_FAVORITIES_SLUG);?>">
							<i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('Saved Shops', 'javo_fr');?>
						</a>
					</li>
					<?php if( $javo_custom_item_tab->get('reviews', '') == '' ):?>
						<li class="side-menu reviews">
							<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_REVIEWS_SLUG);?>">
								<i class="glyphicon glyphicon-cog"></i>&nbsp;<?php printf( __('My %s', 'javo_fr'), $javo_custom_item_label->get('reviews', __('Reviews', 'javo_fr')));?>
							</a>
						</li>
					<?php endif; ?>
					<?php if( $javo_custom_item_tab->get('ratings', '') == '' ):?>
						<li class="side-menu ratings">
							<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_RATINGS_SLUG);?>">
								<i class="glyphicon glyphicon-cog"></i>&nbsp;<?php printf( __('My %s', 'javo_fr'), $javo_custom_item_label->get('ratings', __('Ratings', 'javo_fr')));?>
							</a>
						</li>
					<?php endif; ?>
					<?php if( $javo_custom_item_tab->get('reviews', '') == '' ):?>
						<li class="side-menu add-review">
							<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_ADDREVIEW_SLUG);?>">
								<i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php printf( __('Add %s', 'javo_fr'), $javo_custom_item_label->get('reviews', __('Reviews', 'javo_fr')));?>
							</a>
						</li>
					<?php endif; ?>
				<!-- My Shops -->
			</ul>
			<ul class="nav nav-sidebar">
				<li class="titles my-listing">
					<?php _e('Listing Menu', 'javo_fr');?>
				</li>
				<!-- Listing Menu -->
					<li class="side-menu add-item">
						<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_ADDITEM_SLUG);?>">
							<i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php _e('Post an Item', 'javo_fr');?>
						</a>
					</li>
					<?php if( $javo_custom_item_tab->get('events', '') == '' ):?>
						<li class="side-menu add-event">
							<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_ADDEVENT_SLUG);?>">
								<i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php printf( __('Post an %s', 'javo_fr'), $javo_custom_item_label->get('event', __('Event', 'javo_fr')));?>
							</a>
						</li>
					<?php endif; ?>
					<li class="side-menu my-items">
						<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_ITEMS_SLUG);?>">
							<i class="glyphicon glyphicon-cog"></i>&nbsp;<?php _e('My Posted Items', 'javo_fr');?>
						</a>
					</li>
					<?php if( $javo_custom_item_tab->get('events', '') == '' ):?>
						<li class="side-menu my-events">
							<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_EVENTS_SLUG);?>">
							<i class="glyphicon glyphicon-cog"></i>&nbsp;
								<?php
								printf( __('My %s', 'javo_fr'), $javo_custom_item_label->get('events', __('Events', 'javo_fr')));
								printf(' %s', __('List', 'javo_fr'));
								?>
							</a>
						</li>
					<?php endif; ?>
				<!-- Listing Menu -->
			</ul>
		</div><!--/.well -->
	</div><!--/col-xs-->