<?php
$post_id = get_the_ID();
$post = get_post($post_id);

if($post_id != "" && $post_id > 0){
	$header_type = get_post_meta($post_id, "javo_header_type", true);
	$javo_fancy = @unserialize(get_post_meta($post->ID, "javo_fancy_options", true));
	$javo_slider = @unserialize(get_post_meta($post->ID, "javo_slider_options", true));
	switch($header_type){
	case "notitle":?>
		<!-- No title -->

	<?php break; case "fancy":
		$fancy_title_type = get_post_meta($post_id, "javo_header_fancy_type", true);
		$header_fancy_css = sprintf("
			position:relative;
			background-color:%s;
			background-image:url('%s');
			background-repeat:%s;
			background-position:%s %s;
			height:%spx;",
			$javo_fancy['bg_color'],
			$javo_fancy['bg_image'],
			$javo_fancy['bg_repeat'],
			$javo_fancy['bg_position_x'],
			$javo_fancy['bg_position_y'],
			$javo_fancy['height']
		);
		$header_fancy_title_wrap_css = sprintf("
			left:0px;
			width:100%%;
			height:%spx;
			display:table-cell;
			vertical-align:middle;
			text-align:%s;",
			$javo_fancy['height'],
			$fancy_title_type
		);
		$header_fancy_title_css = sprintf("
			color:%s; font-size:%s"
			, $javo_fancy['title_color']
			, '20pt'
		);
		$header_fancy_subtitle_css = sprintf("
			color:%s;",
			$javo_fancy['subtitle_color']
		);?>
		<div class="javo_post_header_fancy" style="<?php echo $header_fancy_css;?>">
			<div class="container" style="display:table;">
				<div style="<?php echo $header_fancy_title_wrap_css;?>">
					<h1 style="<?php echo $header_fancy_title_css;?>"><?php echo $javo_fancy['title'];?></h1>
					<h4 style="<?php echo $header_fancy_subtitle_css;?>"><?php echo $javo_fancy['subtitle'];?></h4>
				</div>
			</div>
		</div>
		<?php
	break; case "map":
		?>
		<div class="javo_map_area"></div>
		<input type='hidden' class='javo_map_visible' value='.javo_map_area'>
		<?php
	break; case "slider":
		$sliderType = get_post_meta($post_id, "javo_slider_type", true);
		switch($sliderType){
			case "rev":
				if($javo_slider['rev_slider'] != "") echo do_shortcode("[rev_slider ".$javo_slider['rev_slider']."]");
			break;
			default:
				_e("No select slider.", "javo_fr");
		}
	break; case "default": default:
		if( !is_singular("item") ){
			?>'
			<div class="container">
				<h1 class="custom-header"><?php the_title();?></h1>
			</div>
			<?php
		};
	};
};
