<?php
global
	$javo_tso
	, $javo_custom_item_label
	, $javo_custom_item_tab;
?>
<header class="main" id="header-one-line">
<?php if($javo_tso->get('topbar_use')){ ?>
<div class="javo-topbar" style="background:<?php echo $javo_tso->get('topbar_bg_color');?>; color:<?php echo $javo_tso->get('topbar_text_color'); ?>">
	<div class="container">
		<div class="pull-left javo-topbar-left">
			<?php if($javo_tso->get('topbar_phone_hidden')!='disabled' && $javo_tso->get("phone")){?>
				<span class="javo-topbar-phone">
					<i class="glyphicon glyphicon-phone"></i>
					<?php echo $javo_tso->get("phone"); ?>
				</span>
			<?php }
				if($javo_tso->get('topbar_phone_hidden')!='disabled' && $javo_tso->get("phone") && $javo_tso->get('topbar_email_hidden')!='disabled' && $javo_tso->get("phone")) echo '/';
				if($javo_tso->get('topbar_email_hidden')!='disabled' && $javo_tso->get("email")){
			?>
			<span class="javo-topbar-email">
				<i class="glyphicon glyphicon-envelope"></i>
				<?php echo $javo_tso->get("email"); ?>
			</span>
			<?php } ?>
		</div><!-- javo-topbar-left -->
		<div class="pull-right javo-topbar-right">
			<div class="topbar-wpml">
				<?php if($javo_tso->get('topbar_wpml_hidden')!='disabled') do_action('icl_language_selector'); ?>
			</div><!-- topbar-wpml -->
			<div class="topbar-sns">
			<?php
				if($javo_tso->get('topbar_sns_hidden')!='disabled'){
					if($javo_tso->get('facebook') && $javo_tso->get('topbar_facebook_hidden')!='disabled') printf('<a href="%s" target="_blank"><img src="%s"></a>'
						, $javo_tso->get('facebook'), JAVO_IMG_DIR.'/sns/foot-facebook.png');
					if($javo_tso->get('twitter') && $javo_tso->get('topbar_twitter_hidden')!='disabled') printf('<a href="%s" target="_blank"><img src="%s"></a>'
					, $javo_tso->get('twitter'), JAVO_IMG_DIR.'/sns/foot-twitter.png');
					if($javo_tso->get('google') && $javo_tso->get('topbar_google_hidden')!='disabled') printf('<a href="%s" target="_blank"><img src="%s"></a>'
					, $javo_tso->get('google'), JAVO_IMG_DIR.'/sns/foot-googleplus.png');
					if($javo_tso->get("dribbble") && $javo_tso->get('topbar_dribbble_hidden')!='disabled') printf('<a href="%s" target="_blank"><img src="%s"></a>'
					, $javo_tso->get("dribbble"), JAVO_IMG_DIR.'/sns/foot-dribbble.png');
					if($javo_tso->get("forrst") && $javo_tso->get('topbar_forrst_hidden')!='disabled') printf('<a href="%s" target="_blank"><img src="%s"></a>'
					, $javo_tso->get("forrst"), JAVO_IMG_DIR.'/sns/foot-forrst.png');
					if($javo_tso->get("pinterest") && $javo_tso->get('topbar_pinterest_hidden')!='disabled') printf('<a href="%s" target="_blank"><img src="%s"></a>'
					, $javo_tso->get("pinterest"), JAVO_IMG_DIR.'/sns/foot-pinterest.png');
					if($javo_tso->get("instagram") && $javo_tso->get('topbar_instagram_hidden')!='disabled') printf('<a href="%s" target="_blank"><img src="%s"></a>'
					, $javo_tso->get("instagram"), JAVO_IMG_DIR.'/sns/foot-instagram.png');
				}
			?>
			</div><!-- topbar-sns -->
		</div><!-- javo-topbar-right -->
	</div><!-- container-->
</div><!-- javo-topbar -->
<?php } ?>

	<nav class="navbar navbar-inverse navbar-static-top javo-main-navbar javo-navi-bright" role="navigation">
		<div class="container">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#javo-navibar">
						<span class="sr-only"><?php _e('Toggle navigation', 'javo_fr');?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo home_url('/');?>">
						<?php // setting logos
						if ( is_singular('item'	) ) {
							printf('<img src="%s">', $javo_tso->get('single_item_logo', JAVO_IMG_DIR.'/javo-directory-logo-v1-3.png')); // show adv. #1
						}else{
							printf('<img src="%s">', $javo_tso->get('logo_url', JAVO_IMG_DIR.'/javo-directory-logo-v1.png')); // show adv. #2
						};?>
					</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="javo-navibar">
					<?php
					wp_nav_menu( array(
						'menu_class' => 'nav navbar-nav navbar-left',
						'theme_location' => 'primary',
						'depth' => 3,
						'container' => false,
						'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
						'walker' => new wp_bootstrap_navwalker()
					)); ?>
					<ul class="nav navbar-nav navbar-right">
						<?php
						if (is_user_logged_in() && $javo_tso->get('nav_show_mypage', null) == 'use' ):
							$javo_this_user					= wp_get_current_user();
							$javo_this_user_avatar_id		= get_user_meta($javo_this_user->ID, 'avatar', true);
							$javo_this_user_avatar_meta		= wp_get_attachment_image_src( $javo_this_user_avatar_id, 'javo-tiny');
							$javo_this_user_avatar			= $javo_this_user_avatar_meta[0] != "" ? $javo_this_user_avatar_meta[0] : $javo_tso->get('no_image', JAVO_IMG_DIR.'/no-image.png');?>
							<li>
								<a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/').JAVO_MEMBER_SLUG; ?>" class="topbar-ser-image">
									<img src="<?php echo $javo_this_user_avatar;?>" width="25" height="25">
								</a>
							</li>
							<li class="dropdown right-menus">
								<a href="#" class="dropdown-toggle nav-right-button icon-talk" data-toggle="dropdown" data-javo-hover-menu><span class="ico-talk dark"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_ADDITEM_SLUG);?>"><?php _e('Post an Item', 'javo_fr'); ?></a></li>
									<?php if( $javo_custom_item_tab->get('reviews', '') == '' ): ?>
										<li><a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_ADDREVIEW_SLUG);?>">
										<?php printf( __('Post a %s', 'javo_fr'), $javo_custom_item_label->get('review', __('Review', 'javo_fr')));?></a></li>
									<?php endif; ?>
								</ul>
							</li> <!-- right-menus -->

							<li class="dropdown right-menus">
								<a href="#" class="dropdown-toggle nav-right-button button-icon-fix" data-toggle="dropdown" data-javo-hover-menu><span class="glyphicon glyphicon-cog"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_PROFILE_SLUG);?>"><?php _e('Edit Profile', 'javo_fr'); ?></a></li>
									<li><a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_ITEMS_SLUG);?>"><?php _e('My Items', 'javo_fr'); ?></a></li>
									<?php if( $javo_custom_item_tab->get('reviews', '') == '' ): ?>
										<li><a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_REVIEWS_SLUG);?>">
										<?php printf( __('My %s', 'javo_fr'), $javo_custom_item_label->get('reviews', __('Reviews', 'javo_fr')));?></a></li>
									<?php endif; ?>
									<?php if( $javo_custom_item_tab->get('ratings', '') == '' ): ?>
										<li><a href="<?php echo home_url(JAVO_DEF_LANG.JAVO_MEMBER_SLUG.'/'.wp_get_current_user()->user_login.'/'.JAVO_RATINGS_SLUG);?>">
										<?php printf( __('My %s', 'javo_fr'), $javo_custom_item_label->get('ratings', __('Ratings', 'javo_fr')));?></a></li>
									<?php endif; ?>
									<li><a href="<?php echo wp_logout_url( home_url() );?>"><?php _e('Log Out', 'javo_fr');?></a></li>
								</ul>
							</li> <!-- right-menus -->
						<?php elseif( !is_user_logged_in() && $javo_tso->get('nav_show_mypage', null) == 'use' ): // not logged in ?>
							<li class="dropdown right-menus">
								<a href="#" data-toggle="modal" data-target="#login_panel" class="nav-right-button javo-tooltip" title="<?php _e('Register', 'javo_fr');?>"><span class="glyphicon glyphicon-user"></span></a>
							</li> <!-- right-menus -->
							<li class="dropdown right-menus">
								<a href="#" class="dropdown-toggle nav-right-button button-icon-notice" data-toggle="dropdown" data-javo-hover-menu><span class="glyphicon glyphicon-pencil"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#" data-toggle="modal" data-target="#login_panel"><?php _e('Post an Item', 'javo_fr'); ?></a></li>
									<?php if( $javo_custom_item_tab->get('reviews', '') == '' ): ?>
										<li><a href="#" data-toggle="modal" data-target="#login_panel"><?php printf( __('Post a %s', 'javo_fr'), $javo_custom_item_label->get('review', __('Review', 'javo_fr')));?></a></li>
									<?php endif; ?>
								</ul>
							</li> <!-- right-menus -->
						<?php endif; ?>
							<li class="dropdown right-menus"></li> <!-- right-menus -->
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</div> <!-- container -->
	</nav>
</header>