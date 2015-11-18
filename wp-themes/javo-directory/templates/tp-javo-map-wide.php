<?php
/* Template Name: Map (Wide Style) */

get_header();

global
	$javo_tso
	, $javo_tso_map;
$javo_this_tax_common_args = Array( 'hide_empty'=> 0, 'parent'=> 0);
$javo_this_filter_taxoomies = Array();

if( $javo_tso->get('map_wide_hide_category', 'on') != 'off' ){
	$javo_this_filter_taxoomies[] = 'item_category';
};
if( $javo_tso->get('map_wide_hide_location', 'on') != 'off' ){
	$javo_this_filter_taxoomies[] = 'item_location';
};

$mail_alert_msg = Array(
	'to_null_msg'			=> __('Please, insert recipient`s email address.', 'javo_fr')
	, 'from_null_msg'		=> __('Please, insert sender`s email address.', 'javo_fr')
	, 'subject_null_msg'	=> __('Please, insert your name.', 'javo_fr')
	, 'content_null_msg'	=> __('Please, insert message content.', 'javo_fr')
	, 'failMsg'				=> __('Sorry, your message could not be sent.', 'javo_fr')
	, 'successMsg'			=> __('Successfully sent!', 'javo_fr')
	, 'confirmMsg'			=> __('Do you want to send this message?', 'javo_fr')
);

// Setup Agrumnets
$javo_this_posts_args = Array(
	'post_status'			=> 'publish'
	, 'post_type'			=> 'item'
	, 'posts_per_page'		=> -1
	, 'suppress_filters '	=> false
);

// Return Variables
$javo_this_return = Array();

// Queries Loop
$javo_this_posts = get_posts($javo_this_posts_args);
foreach( $javo_this_posts as $post)
{
	setup_postdata($post);
	$javo_meta_query	= new javo_get_meta( $post->ID );

	$javo_latlng		= @unserialize( $javo_meta_query->_get('latlng', Array() ) );
	$javo_latlng		= new javo_ARRAY( $javo_latlng );

	$javo_set_icon		= '';
	$javo_marker_term_id = wp_get_post_terms( $post->ID , 'item_category');
	if( !empty( $javo_marker_term_id ) ){
		$javo_set_icon = get_option('javo_item_category_'.$javo_marker_term_id[0]->term_id.'_marker', '');
		if( $javo_set_icon == ''){
			$javo_set_icon = $javo_tso->get('map_marker', '');
		};
	};

	$javo_this_return[ $post->ID ] = Array(
		'post_title'		=> $post->post_title
		, 'contents'		=> javo_str_cut( $post->content , 300 )
		, 'thumbnail'		=> get_the_post_thumbnail($post->ID, Array(50, 50))
		, 'permalink'		=> get_permalink( $post->ID )
		, 'category'		=> $javo_meta_query->cat('item_category', __('No Category', 'javo_fr'))
		, 'location'		=> $javo_meta_query->cat('item_location', __('No Location', 'javo_fr'))
		, 'lat'				=> $javo_latlng->get('lat')
		, 'lng'				=> $javo_latlng->get('lng')
		, 'icon'			=> $javo_set_icon
		, 'phone'			=> $javo_meta_query->get('phone')
		, 'address'			=> $javo_meta_query->get('address')
		, 'mobile'			=> $javo_meta_query->get('mobile')
		, 'website'			=> $javo_meta_query->get('website')
		, 'email'			=> $javo_meta_query->get('email')
		, 'rating'			=> $javo_meta_query->get_child_count('ratings')
		, 'review'			=> $javo_meta_query->get_child_count('review')

	);
}
wp_reset_postdata();?>

<!-- Javo Map Options -->
<fieldset class="hidden">
	<input type="hidden" javo-map-distance-unit value="<?php echo $javo_tso_map->get('distance_unit', __('km', 'javo_fr'));?>">
	<input type="hidden" javo-map-distance-max value="<?php echo (float)$javo_tso_map->get('distance_max', '500');?>">
	<input type="hidden" javo-map-read-more value="<?php echo $javo_tso_map->get('map_wide_read_more', 'pagination');?>">
	<input type="hidden" javo-map-all-items value="<?php echo htmlspecialchars(json_encode($javo_this_return));?>">
	<input type="hidden" name="javo_google_map_poi" value="<?php echo $javo_tso_map->get('poi', 'on');?>">
	<input type="hidden" javo-cluster-multiple value="<?php _e("This place contains multiple places. please select one.", 'javo_fr');?>">
	<input type="hidden" javo-marker-trigger-zoom value="<?php echo $javo_tso_map->get('trigger_zoom', 18);?>">
</fieldset>

<!-- Javo Map Options End -->

<div id="javo-map-wide-wrapper">
	<div class="javo_somw_panel row mobile-hidden-panel <?php echo $javo_tso_map->get('map_wide_content_overflow', null) == 'overflow'? 'no-scroll':'';?>">
		<div class="col-md-12">

			<?php if($javo_tso->get('map_wide_multitab', null) != 'off'): ?>
				<div class="row map-top-btns">
					<div class="col-md-12">
						<div class="btn-group btn-group-justified" data-toggle="buttons">
							<a class="btn btn-dark active" data-javo-map-mode="list"><?php _e('Filter', 'javo_fr');?></a>
							<a class="btn btn-dark" data-javo-map-mode="featured"><?php _e('Featured', 'javo_fr');?></a>
							<a class="btn btn-dark" data-javo-map-mode="favorite"><?php _e('Favorites', 'javo_fr');?></a>
						</div><!-- /.btn-Grouop -->
					</div><!-- /.col-md-12 -->
				</div> <!-- map-top-btns -->
			<?php endif; ?>

			<div class="row category-btns-wrap">
				<form role="form" onsubmit="return false">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<?php
								// Filter Element Type
								echo apply_filters('javo_wide_map_control_filter', $javo_this_filter_taxoomies, $javo_tso_map->get('map_wide_filter_type', 'button'));
								?>
							</div><!-- /.col-md-12 -->
						</div><!-- /.row -->

						<?php
						// Use Keyword Input
						if( $javo_tso->get('map_keyword', null) != 'off'): ?>
							<div class="row">
								<div class="col-md-12">
									<h4 class="title"><?php _e('Keyword', 'javo_fr');?></h4>
									<input id="javo_keyword" type="text" class="form-control input-md">
								</div><!-- /.col-md-12 -->
							</div><!-- /.row -->
						<?php endif;?>



						<div class="row my-location">
							<div class="col-md-12">
								<h4 class="title"><?php _e('My Location', 'javo_fr'); ?></h4>
								<div class="pull-left my-location-btn">
									<button type="button" class="btn-map-panel active javo-tooltip javo-map-wide-goto-my-position" title="<?php _e('Please accept to access your location.', 'javo_fr');?>"><span class="glyphicon glyphicon-map-marker"></span>&nbsp;<?php _e('My Location', 'javo_fr'); ?></button>
								</div> <!-- col-md-6 -->
								<div class="pull-left distance">
									<div class="javo-geoloc-slider"></div>
									<input type="hidden" javo-wide-map-round>
								</div> <!-- col-md-6 -->
							</div><!-- /.col-md-12 -->
						</div><!-- /.row -->

					</div> <!-- col-md-12 -->
				</form>
			</div><!-- /.category-btns-wrap -->

			<section class="newrow">
				<article class="javo_somw_list_content"></article>
			</section>

		</div> <!-- col-md-12 -->

	</div> <!-- javo_somw_panel row -->
	<div class="javo-wide-map-container">
		<div class="map_cover"></div>
		<div class="map_area"></div> <!-- map_area : it shows map part -->
		<a class="btn btn-default active wide-map" data-map-move-allow><i class="fa fa-unlock"></i></a>
	</div>
	<div class="javo_somw_panel row mobile-display-panel">
		<div class="col-md-12">

			<?php if($javo_tso->get('map_wide_multitab', null) != 'off'): ?>
				<div class="row map-top-btns">
					<div class="col-md-12">
						<div class="btn-group btn-group-justified" data-toggle="buttons">
							<a class="btn btn-dark active" data-javo-map-mode="list"><?php _e('Total', 'javo_fr');?></a>
							<a class="btn btn-dark" data-javo-map-mode="featured"><?php _e('Features', 'javo_fr');?></a>
							<a class="btn btn-dark" data-javo-map-mode="favorite"><?php _e('Favorite', 'javo_fr');?></a>
						</div><!-- /.btn-Grouop -->
					</div><!-- /.col-md-12 -->
				</div> <!-- map-top-btns -->
			<?php endif; ?>

			<div class="row category-btns-wrap">
				<form role="form" onsubmit="return false">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<?php
								// Filter Element Type
								echo apply_filters('javo_wide_map_control_filter', $javo_this_filter_taxoomies, $javo_tso_map->get('map_wide_filter_type', 'button'));
								?>
							</div><!-- /.col-md-12 -->
						</div><!-- /.row -->

						<?php
						// Use Keyword Input
						if( $javo_tso->get('map_keyword', null) != 'off'): ?>
							<div class="row">
								<div class="col-md-12">
									<h4 class="title"><?php _e('Keyword', 'javo_fr');?></h4>
									<input id="javo_keyword" type="text" class="form-control input-md">
								</div><!-- /.col-md-12 -->
							</div><!-- /.row -->
						<?php endif;?>



						<div class="row my-location">
							<div class="col-md-12">
								<h4 class="title"><?php _e('My Location', 'javo_fr'); ?></h4>
								<div class="pull-left my-location-btn">
									<button type="button" class="btn-map-panel active javo-tooltip javo-map-wide-goto-my-position" title="<?php _e('Please accept to access your location.', 'javo_fr');?>"><span class="glyphicon glyphicon-map-marker"></span>&nbsp;<?php _e('My Location', 'javo_fr'); ?></button>
								</div> <!-- col-md-6 -->
								<div class="pull-left distance">
									<div class="javo-geoloc-slider"></div>
									<input type="hidden" javo-wide-map-round>
								</div> <!-- col-md-6 -->
							</div><!-- /.col-md-12 -->
						</div><!-- /.row -->

					</div> <!-- col-md-12 -->
				</form>
			</div><!-- /.category-btns-wrap -->

			<section class="newrow">
				<article class="javo_somw_list_content"></article>
			</section>

		</div> <!-- col-md-12 -->
	</div> <!-- javo_somw_panel row -->
	<div class="mobile-map">
		<a class="go-under-map"><?php _e('Move to search form', 'javo_fr');?></a>
	</div> <!-- mobile-map-->
</div><!-- Gmap -->



<script type="text/template" id="javo-map-wide-content-loading">
<div class="text-center">
	<img src="<?php echo JAVO_THEME_DIR;?>/assets/images/loading.gif" width="64">
	<span><?php _e('Loading', 'javo_fr');?></span>
</div><!-- /.text-center -->
</script>
<script type="text/template" id="javo-map-wide-content-not-found">
<div class="text-center">
	<h2><?php _e('Not Found Items.', 'javo_fr');?></h2>
</div><!-- /.text-center -->
</script>

<script type="text/template" id="javo-map-wide-panel-content">
<div class='row javo_somw_list_inner'>
	<div class='col-sm-3 col-xs-2'>{thumbnail}</div><!-- col-md-3 thumb-wrap -->
	<div class='col-sm-9 col-xs-10 meta-wrap'>
		<div class='javo_somw_list'>
			<a href='javascript:' class='javo-hmap-marker-trigger' data-id="mid_{post_id}" data-post-id="{post_id}">{post_title}</a>
		</div>
		<div class='javo_somw_list'>{category} / {location}</div>
	</div><!-- col-md-9 meta-wrap -->
</div><!-- row -->
</script>
<script type="text/template" id="javo-map-wide-infobx-content">

	<div class="javo_somw_info panel" style="min-height:220px;">
		<div class="des">
			<ul class="list-unstyled">
				<li><div class="prp-meta"><h4><strong>{post_title}</h4></strong></div></li>
				<li><div class="prp-meta">{phone}</div></li>
				<li><div class="prp-meta">{mobile}</div></li>
				<li><div class="prp-meta">{website}</div></li>
				<li>
					<div class="prp-meta">{address}
						<a href="{permalink}#item-location" class="btn btn-primary btn-get-direction btn-sm"><?php _e("Get directions", "javo_fr"); ?></a>
					</div>
				</li>
			</ul>
		</div> <!-- des -->

		<div class="pics">
			<div class="thumb">
				<a href="{permalink}" target="_blank">{thumbnail}</a>
			</div> <!-- thumb -->
			<div class="img-in-text">{category}</div>
			<div class="javo-left-overlay">
				<div class="javo-txt-meta-area custom-bg-color-setting">{location}</div> <!-- javo-txt-meta-area -->

				<div class="corner-wrap">
					<div class="corner admin-color-setting"></div>
					<div class="corner-background admin-color-setting"></div>
				</div> <!-- corner-wrap -->
			</div> <!-- javo-left-overlay -->
		</div> <!-- pic -->

		<div class="row">
			<div class="col-md-12">
				<div class="btn-group btn-group-justified pull-right">
					<a class="btn btn-primary btn-sm" onclick="javo_map.brief_run(this);" data-id="{post_id}">
						<i class="fa fa-user"></i> <?php _e("Brief", "javo_fr"); ?>
					</a>
					<a href="{permalink}" class="btn btn-primary btn-sm">
						<i class="fa fa-group"></i> <?php _e("Detail", "javo_fr"); ?>
					</a>
					<a href="javascript:" class="btn btn-primary btn-sm" onclick="javo_map.contact_run(this)" data-to="{email}" data-username="{author_name}" data-itemname="{post_title}">
						<i class="fa fa-envelope"></i> <?php _e("Contact", "javo_fr"); ?>
					</a>
				 </div><!-- btn-group -->
			</div> <!-- col-md-12 -->
		</div> <!-- row -->
	</div> <!-- javo_somw_info -->
</script>

<script type="text/javascript">
jQuery(function($){
	"use strict";
	var javo_map = {
		root:null
		, el			: $('.map_area')
		, map			: null
		, target		: null
		, remote		: {}
		, distance_unit	: $('[javo-map-distance-unit]').val()
		, distance		: $('[javo-map-distance-unit]').val() == 'mile' ? 1609.344 : 1000
		, distance_max	: $('[javo-map-distance-max]').val()
		, options:{
			map_init:{
				map:{
					options:{
						mapTypeId: google.maps.MapTypeId.ROADMAP
						, mapTypeControl: false
						, panControl: false
						, scrollwheel: false
						, streetViewControl: true
						, zoomControl: true
					}
				}
				,panel:{
					options:{
						content:'<span class="javo_somw_opener active"><?php _e('Hide', 'javo_fr');?></span>'
						, top: '50%'
						, left: 0
					}
				}
			}
			, map_style:[
				{
					featureType: "poi"
					, elementType: "labels"
					, stylers: [
						{ visibility: "off" }
					]
				}
			]
			, ajax_options:{
				url: null
				, type: 'post'
				, data:{
					filter:{}
				}, dataType: 'json'
			}
			, ajax_list_options:{
				url: null
				, type: 'post'
				, data:{
					filter:{}
				}, dataType: 'json'
			}
			, ajax_slider_options:{
				url: null
				, type: 'post'
				, data:{}
				, dataType: 'json'
			}
			, javo_mail:{
				subject: $("input[name='contact_name']")
				, from: $("input[name='contact_email']")
				, content: $("textarea[name='contact_content']")
				, to_null_msg: "<?php echo $mail_alert_msg['to_null_msg'];?>"
				, from_null_msg: "<?php echo $mail_alert_msg['from_null_msg'];?>"
				, subject_null_msg: "<?php echo $mail_alert_msg['subject_null_msg'];?>"
				, content_null_msg: "<?php echo $mail_alert_msg['content_null_msg'];?>"
				, successMsg: "<?php echo $mail_alert_msg['successMsg'];?>"
				, failMsg: "<?php echo $mail_alert_msg['failMsg'];?>"
				, confirmMsg: "<?php echo $mail_alert_msg['confirmMsg'];?>"
				, url:"<?php echo admin_url('admin-ajax.php');?>"
			}
		}
		, variable:{
			top_offset: $('header > nav').outerHeight() + $('#wpadminbar').outerHeight()

		}
		, map_clear:function(){
			this.el.gmap3({clear:{ name:"marker" }});
			this.marker_clear();

		}
		, ajax_slider:function(t){
			var $this = $(t);

			this.options.ajax_slider_options.url = this.options.ajax_options.url;
			this.options.ajax_slider_options.data = {};
			this.options.ajax_slider_options.data.action = 'get_detail_images';
			this.options.ajax_slider_options.data.post_id = $this.data('post-id');
			this.options.ajax_slider_options.error = function(e){};
			this.options.ajax_slider_options.success = function(d){

				$this
					.find('.javo-hmap-flexslider ul')
					.append( d.result );

				$this
					.find('.javo-hmap-flexslider')
					.flexslider({
						animation: "slide"
						, controlNav: false
					});
			};

			jQuery.ajax(this.options.ajax_slider_options);
		}
		, marker_clear:function(){ this.el.gmap3({ clear:{ name:["marker", "circle"] }}); }
		, overlay_clear:function(){ this.el.gmap3({ clear:{ name:"overlay" }}); }
		, info_clear:function(){
			var markers = this.el.gmap3({ get:{ name:"marker", all:true } });
			this.infoWindo.close();
			$(markers).each(function(k, v){
				v.setAnimation(null);
			});
		}
		, resize:function(){

			var $offsetY = 0;
			var javoMapPanel = $('.javo_somw_panel.row.mobile-hidden-panel');

			if( javoMapPanel.hasClass('no-scroll') ){
				this.el.height( javoMapPanel.outerHeight() );
				this.el.gmap3({ trigger:'resize' });
			}
			else
			{
				$offsetY += $('#wpadminbar').outerHeight(true);
				$offsetY += $('#header-one-line').outerHeight(true);
				$offsetY = $(window).height() - $offsetY;
				this.el.height( $offsetY );
				javoMapPanel.height( $offsetY );
			}
		}
		, setMarker: function( result ){
			var $object = this;
			var markers = new Array();
			var avg = new google.maps.LatLngBounds();

			$object.getList();

			// Define Markers
			$.each( result, function(k, v){

				// Create Markers
				markers.push({
					latLng: new google.maps.LatLng( v.lat, v.lng )
					, options:{ animation:google.maps.Animation.DROP, icon:v.icon }
					, id: 'mid_' + k
					, data: $.extend(v, { post_id : k })
				});

				// Geo Location
				avg.extend( new google.maps.LatLng(v.lat, v.lng) );
			});

			// Set Marker Values
			$object.el.gmap3({
				map:{ events:{
					click:function(){ $object.info_clear(); }
				}}, marker:{
					values: markers
					, cluster:{
						radius:100
						, 0:{ content:'<div class="javo-map-cluster admin-color-setting">CLUSTER_COUNT</div>', width:52, height:52 }
						, events:{
							click:function(c, e, d){

								var $map = $(this).gmap3('get');
								var maxZoom = new google.maps.MaxZoomService();
								var c_bound = new google.maps.LatLngBounds();


								// IF Cluster Max Zoom ?
								maxZoom.getMaxZoomAtLatLng( d.data.latLng , function( response ){
									if( response.zoom <= $map.getZoom() && d.data.markers.length > 0 )
									{
										var str = '';
										str += "<ul class='list-group'>";

										str += "<li class='list-group-item disabled text-center'>";
											str += "<strong>";
												str += $("[javo-cluster-multiple]").val();
											str += "</strong>";
										str += "</li>";



										$.each( d.data.markers, function( i, k ){
											console.log( k );
											str += "<a onclick=\"javo_map.cluster_trigger('" + k.id +"');\" ";
												str += "class='list-group-item'>";
												str += "Post " + k.data.post_title;
											str += "</a>";
										});

										str += "</ul>";
										$object.infoWindo.setContent( str );
										$object.infoWindo.setPosition( c.main.getPosition() );
										$object.infoWindo.open( $map );

									}else{
										$map.panTo( c.main.getPosition() );
										$map.setZoom( $map.getZoom() + 2 );

										/*
										$.each( d.data.markers, function(i, k){
											c_bound.extend( k.latLng );
										});
										$map.fitBounds( c_bound );
										console.log( c_bound );
										*/
									}
								} );


							}
						}
					}
					, events:{
						click:function(m, e, c){
							$object.info_clear();
							$object.infoWindo.close();

							var str = "";
							str = $('#javo-map-wide-infobx-content').html();

							str = str.replace(/{post_id}/g, c.data.post_id);
							str = str.replace(/{post_title}/g, c.data.post_title);
							str = str.replace(/{author_name}/g, c.data.author_name || '');
							str = str.replace(/{address}/g, c.data.address || '');
							str = str.replace(/{permalink}/g, c.data.permalink);
							str = str.replace(/{thumbnail}/g, c.data.thumbnail);
							str = str.replace(/{category}/g, c.data.category);
							str = str.replace(/{location}/g, c.data.location);
							str = str.replace(/{phone}/g, c.data.phone || '');
							str = str.replace(/{mobile}/g, c.data.mobile || '');
							str = str.replace(/{website}/g, c.data.website || '');
							str = str.replace(/{email}/g, c.data.email || '');

							$object.infoWindo.setContent(str);
							$object.infoWindo.open( $(this).gmap3('get'), m);

							$object.map.setCenter( m.getPosition() );

							m.setAnimation( google.maps.Animation.BOUNCE );
						}
					}
				}
			});

			if( markers.length > 0 ){
				// Bounding
				$object.map.fitBounds(avg);
			}
		}
		, cluster_trigger: function( marker_id ){
			this.el.gmap3({
				get:{
					name		: "marker"
					, id		: marker_id
					, callback	: function(m){
						google.maps.event.trigger(m, 'click');
					}
				}
			});
		}
		, getList: function(){
			var $object = this;
			this.options.ajax_list_options.data.ppp			= 10;
			this.options.ajax_list_options.data.action		= "javo_map";
			this.options.ajax_list_options.data.post_type	= "item";
			this.options.ajax_list_options.data.pagination	= $('[javo-map-read-more]').val()
			this.options.ajax_list_options.data.lang		= $('[name="javo_cur_lang"]').val();
			this.options.ajax_list_options.error			= function(e)
			{
				console.log( e.responseText );
				$.javo_msg({content: "Error" + e.state(), delay:10000});
			}
			this.options.ajax_list_options.complete			= function(d)
			{
				$(window).trigger('resize');
			}
			this.options.ajax_list_options.success			= function(d)
			{
				if( $('[javo-map-read-more]').val() != 'read_more' )
				{
					$('.javo_somw_list_content').empty();
				}
				else
				{
					$('.javo-wide-map-read-more').remove();
				}

				if( d.result != '' ){
					$.each( d.result , function( i, k ){
						var str = "";
						str = $('#javo-map-wide-panel-content').html();

						str = str.replace(/{post_id}/g, i);
						str = str.replace(/{post_title}/g, k.post_title);
						str = str.replace(/{thumbnail}/g, k.thumbnail);
						str = str.replace(/{category}/g, k.category);
						str = str.replace(/{location}/g, k.location);

						$('.javo_somw_list_content').append( str );
					});
					$('.javo_somw_list_content').append( d.pagination );

					if( $('[javo-map-read-more]').val() == 'read_more' ){
						$object.options.ajax_list_options.data.offset += $object.options.ajax_list_options.data.ppp;
					}

				}else{
					$('.javo_somw_list_content').append( $('#javo-map-wide-content-not-found').html()  );
				}
			}
			if( $('[javo-map-read-more]').val() != 'read_more' ){
				$('.javo_somw_list_content').html($('#javo-map-wide-content-loading').html());
			}
			$.ajax( this.options.ajax_list_options );
		}
		, run:function(){
			var $cover = $('.javo-wide-map-container > .map_cover');

			$cover.addClass('active');
			$('.javo_somw_list_content').empty();

			var $object = this;
			this.options.ajax_options.data.action		= "javo_map";
			this.options.ajax_options.data.post_type	= "item";
			this.options.ajax_options.data.ppp			= -1;
			this.options.ajax_options.data.lang			= $('[name="javo_cur_lang"]').val();
			this.options.ajax_list_options.data.offset	= 0;
			this.options.ajax_options.success = function(d){

				// Clear Map
				$object.marker_clear();
				$object.info_clear();
				$object.setMarker( d.result );

				$cover.removeClass('active');
			};

			this.options.ajax_options.error = function(e){
				$.javo_msg({ content:"<?php _e('Fail to load this Page. Please Refresh Again.', 'javo_fr');?>", delay:3000});
				console.log( e.responseText );
			};
			$.ajax( this.options.ajax_options );
		}
		, onError:function(str){
			$('.javo-map-wide-error-panel')
				.html(str)
				.removeClass('hidden')
				.css({
					background		: '#fff'
					, padding		: '5px'
					, width			: '100%'
				});
		}
		, events:function(){
			var $object = this;


			$(document).on('keyup', '#javo_ac_keyword', function(e){



			}).on('keyup', '#javo_keyword', function(e){

				if( e.keyCode == 13 ){

					$object.options.ajax_options.data.keyword = $(this).val();
					$object.options.ajax_list_options.data.keyword = $(this).val();
					$object.run();
				}

			}).on('click', 'button[data-filter]', function(e){

				var $this_category = $(this).data('filter');
				e.preventDefault();
				$('button[data-filter="' + $this_category + '"]').removeClass('active');
				$(this).addClass('active');
				$object.options.ajax_options.data.current						= 1;
				$object.options.ajax_list_options.data.current					= 1;
				$object.options.ajax_options.data.filter[ $this_category ]	= $(this).data('value');
				$object.options.ajax_list_options.data.filter[ $this_category ]	= $(this).data('value');
				$object.run();

			}).on('change', 'select[name^="filter"]', this.setFilter)
			.on('change', 'select[data-javo-hmap-sort]', function(){
				$object.options.ajax_options.data.order = $(this).val();
				$object.options.ajax_list_options.data.order = $(this).val();
				$object.run();
			}).on('change', 'select[data-javo-hmap-ppp]', function(){
				$object.options.ajax_options.data.ppp = $(this).val();
				$object.options.ajax_list_options.data.ppp = $(this).val();
				$object.run();

			}).on('change', 'select[data-column-remote]', function(){
				$object.options.ajax_options.data.column = $(this).val();
				$object.options.ajax_list_options.data.column = $(this).val();
				$object.run();

			}).on('click', '.javo-hmap-marker-trigger', function(){
				var $this = $(this);

				$object.el.gmap3({
					get:{
							  name:"marker"
						,		id: $this.data('id')
						, callback: function(m){
							google.maps.event.trigger(m, 'click');
						}
					}
				});

				$object.map.setZoom( parseInt( $("[javo-marker-trigger-zoom]").val() ) );

			}).on('click', '.javo-hmap-switch-type', function(){
				$('.javo-hmap-switch-type').removeClass('active');
				$(this).addClass('active');
				$object.options.ajax_options.data.listing_type = $(this).data('value');
				$object.options.ajax_list_options.data.listing_type = $(this).data('value');
				$object.run();
			}).on('click', '.page-numbers', function(e){
				e.preventDefault();
				var _cur = $(this).prop('href').split('?');
				_cur = parseInt( typeof(_cur[1]) != 'undefined' ? _cur[1] : 1 );

				$object.options.ajax_list_options.data.current = _cur;
				$object.getList();

			}).on('click', '.javo-mhome-sidebar-onoff', function(){
				if( $(this).hasClass('active') ){
					$(this).removeClass('active');
					$object.side_out();
				}else{
					$(this).addClass('active');
					$object.side_move();
				}
			}).on("click", ".javo_somw_opener", function(){
				var _panel = $(".javo_somw_panel");
				if( $(this).hasClass("active") ){

					//$(this).animate({marginLeft:-(parseInt(_panel.outerWidth())) + "px" }, 500);
					_panel.animate({marginLeft:-(parseInt(_panel.outerWidth())) + "px"}, 500);
					$(".map_area").animate({marginLeft:0}, 500, function(){
						$(".map_area").gmap3({ trigger:"resize" });
					});
					$(this).text("<?php _e('Show','javo_fr'); ?>").removeClass('active');
				}else{
					//$(this).animate({marginLeft:0}, 500);
					_panel.animate({marginLeft:0}, 500);
					$(".map_area").animate({marginLeft:parseInt(_panel.outerWidth(	)) + "px"}, 500, function(){
						$(".map_area").gmap3({ trigger:"resize" });
					});
					$(this).text("<?php _e('Hide','javo_fr'); ?>").addClass('active');
				};

			}).on('click', '#contact_submit', function(){

				var $_this = $(this);
				var $_this_form =  $(this).closest('form');
				$object.options.javo_mail.to = $_this_form.find('input[name="contact_this_from"]').val();
				$object.options.javo_mail.item_name = $_this_form.find('input[name="contact_item_name"]').val();
				$.javo_mail( $object.options.javo_mail, function(){
					$_this.button('loading');
				}, function(){
					$('#author_contact').modal('hide');
					$_this.button('reset');
				});

			}).on('click', 'a[data-javo-map-mode]', function(){
				$(this).parent().find('a').removeClass('active');
				$('.category-btns-wrap').addClass('hidden');

				if( $(this).data('javo-map-mode') == 'list' ){
					$('.category-btns-wrap').removeClass('hidden');
					$('[name^="filter"]').val('').trigger('chosen:updated');

				}else if( $(this).data('javo-map-mode') == 'favorite' ){
					if( !$('body').hasClass('logged-in') ){
						$("#login_panel").modal();
						return false;
					}
				};

				$object.options.ajax_options.data				= {filter:{}};
				$object.options.ajax_list_options.data			= {filter:{}};
				$object.options.ajax_options.data.panel			= $(this).data('javo-map-mode');
				$object.options.ajax_list_options.data.panel	= $(this).data('javo-map-mode');
				$object.options.ajax_list_options.data.offset	= 0;
				$('.javo_somw_list_content').empty();
				$object.run();
			}).on('click', '.javo-map-wide-goto-my-position', function(e){
				e.preventDefault();
				var $radius = $('[javo-wide-map-round]').val();

				$object.el.gmap3({
					getgeoloc:{
						callback : function(latLng){
							if( !latLng ) return false;
							$(this).gmap3({ clear:'circle' });
							$(this).gmap3({
								map:{
									options:{ center:latLng, zoom:12 }
								}, circle:{
									options:{
										center:latLng
										, radius:$radius * parseFloat( $object.distance )
										, fillColor:'#464646'
										, strockColor:'#000000'
									}
								}
							});
							$(this).gmap3({
								get:{
									name: 'circle'
									, callback: function(c){

										$(this).gmap3('get').fitBounds( c.getBounds() );
									}
								}
							});
						}
					}
				});
			}).on( 'click', '.javo-wide-map-read-more', function(){
				$(this).button('loading');
				$object.getList();

			}).on( 'click', '.go-under-map', function(){
				$('body, html').animate({ scrollTop: ( $('.map_area').outerHeight(true)-8) + 'px' }, 500);
			}).on('click', '[data-map-move-allow]', function(){

				$(this).toggleClass('active');
				if( $(this).hasClass('active') )
				{
					// Allow
					$object.map.setOptions({draggable:true});
					$(this).find('i').removeClass('fa fa-lock').addClass('fa fa-unlock');
				}
				else
				{
					// Not Allowed
					$object.map.setOptions({draggable:false});
					$(this).find('i').removeClass('fa fa-unlock').addClass('fa fa-lock');
				}
			})
		}
		, setFilter: function(){
			var $object = javo_map;
			var rtn_filter = {};

			$object.options.ajax_options.data.current	= 1;
			$object.options.ajax_list_options.data.current	= 1;
			$object.options.ajax_options.data.filter	= {};
			$object.options.ajax_list_options.data.filter	= {};

			$('select[name^="filter"]').each(function(){
				var n = this.name.replace("]", "").split("[")[1];

				if( parseInt( $(this).val() ) > 0 ){
					$object.options.ajax_options.data.filter[n]	= $(this).val();
					$object.options.ajax_list_options.data.filter[n]	= $(this).val();
				};
			});
			$object.run();
		}
		, side_move: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({ marginLeft: 0 }, 100);

			$('.javo_mhome_wrap').clearQueue().animate({
				paddingLeft: $this.outerWidth() + 'px'
			}, 100);
		}
		, side_out: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({
				marginLeft: ( -$this.outerWidth()) + 'px'
			}, 100);
			$('.javo_mhome_wrap').animate({ paddingLeft: 0 }, 100);
		}
		, brief_run: function(e){
			var brief_option = {};
			brief_option.type = "post";
			brief_option.dataType = "json";
			brief_option.url = "<?php echo admin_url('admin-ajax.php');?>";
			brief_option.data = { "post_id" : $(e).data('id'), "action" : "javo_map_brief"};
			brief_option.success = function(db){
				$(".javo_map_breif_modal_content").html(db.html);
				$("#map_breif").modal("show");
				$(e).button('reset');
			};
			$(e).button('loading');
			$.ajax(brief_option);
		}
		, contact_run: function(e){
			$('.javo-contact-user-name').html( $(e).data('username') );
			$('input[name="contact_item_name"]').val($(e).data('itemname'))
			$('input[name="contact_this_from"]').val( $(e).data('to') );
			$("#author_contact").modal('show');
		}
		, init:function(){

			var $object		= this;

			var is_poi_hidden = $('[name="javo_google_map_poi"]').val() == 'off';


			// Initialize Map
			this.el			= $('.map_area');
			this.el.gmap3( this.options.map_init );

			// Initalize DOC
			$('body').css('overflow', 'hidden');

			// Initialize Variables
			this.map		= this.el.gmap3('get');

			// Map Style

			if ( is_poi_hidden )
			{
				this.map_style = new google.maps.StyledMapType( this.options.map_style, {name:'Javo Wide Map'});
				this.map.mapTypes.set('map_style', this.map_style);
				this.map.setMapTypeId('map_style');
			}




			// Settings
			this.options.ajax_options.url = "<?php echo admin_url('admin-ajax.php');?>";
			this.options.ajax_options.data.ppp = -1;
			this.options.ajax_options.data.listing_type = 'page';

			this.options.ajax_list_options.url = "<?php echo admin_url('admin-ajax.php');?>";
			this.options.ajax_list_options.data.action		= "javo_map";
			this.options.ajax_list_options.data.post_type	= "item";
			this.options.ajax_list_options.data.offset		= 0;
			this.options.ajax_list_options.data.lang		= $('[name="javo_cur_lang"]').val();

			// Filter Example
			// this.options.ajax_options.data.filter = { taxomony_name : term_id };

			// Initialize Layout
			this.resize();

			this.events();

			// Setup first load Marker
			this.first_marker = JSON.parse( $('[javo-map-all-items]').val() );
			this.setMarker( this.first_marker );



			$(window).load(function(){
				$('.javo_somw_panel')
					.removeClass('hidden')
					.css({
						marginLeft: ( -$('.javo_mhome_sidebar').outerWidth()) + 'px'
					});
				$(".map_area").css({marginLeft:parseInt($('.javo_somw_panel').outerWidth()) + "px"});
				$(".javo_somw_opener").css({
					marginTop: -( $(".javo_somw_opener").outerHeight() / 2 ) + 'px'
				});
			});

			this.infoWindo = new InfoBubble({
				minWidth:362
				, minHeight:180
				, overflow:true
				, shadowStyle: 1
				, padding: 5
				, borderRadius: 10
				, arrowSize: 20
				, borderWidth: 1
				, disableAutoPan: false
				, hideCloseButton: true
				, arrowPosition: 50
				, arrowStyle: 0
			});



			var javo_PriceSlider_option = {
				start: [300]
				, step: 1
				, range:{ min:[1], max:[ parseInt( javo_map.distance_max ) ] }
				, serialization:{
					lower:[
						$.Link({
							target: $('[javo-wide-map-round]')
							, format:{ decimals:0 }
						})
						, $.Link({
							target: '-tooltip-<div class="javo-slider-tooltip"></div>'
							, method: function(v){
								$(this).html('<span>' + v + '&nbsp;' + javo_map.distance_unit + '</span>');
							}, format:{ decimals:0, thousand:',' }
						})
					]
				}
			};
			$(".javo-geoloc-slider").noUiSlider(javo_PriceSlider_option);
			$('select[name^="filter"]').chosen({ width:"100%" });
		}
	};
	javo_map.init();
	window.javo_map = javo_map;
	$(window).on('resize', function(){ javo_map.resize(); });

	$('.container.footer-top').remove();

});
</script>
<?php

if($javo_tso_map->get('map_wide_visible_footer', null) == 'hidden'){
	get_footer('no-widget');
}else{
	get_footer();
}