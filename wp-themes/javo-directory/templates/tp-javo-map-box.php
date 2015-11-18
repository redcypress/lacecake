<?php
/* Template Name: Map (Box Style) */
get_header();

global
	$javo_tso
	, $javo_tso_map
	, $javo_custom_item_tab;

$javo_query						= new javo_Array( $_REQUEST );
$javo_map_query					= new javo_Array( $javo_query->get('filter', Array()));
$javo_this_map_label			= Array(
	'category'					=> $javo_map_query->get('item_category', null) != null ? get_term( $javo_map_query->get('item_category'), 'item_category' )->name: __('All Category', 'javo_fr')
	, 'location'				=> $javo_map_query->get('item_location', null) != null ? get_term( $javo_map_query->get('item_location'), 'item_location' )->name: __('All Location', 'javo_fr')
);
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
	'post_status'=> 'publish'
	, 'post_type'=> 'item'
	, 'posts_per_page'=> -1
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
		, 'contents'		=> javo_str_cut( $post->post_content , 300 )
		, 'thumbnail'		=> get_the_post_thumbnail($post->ID, Array(50, 50))
		, 'permalink'		=> get_permalink( $post->ID )
		, 'category'		=> $javo_meta_query->cat('item_category', __('No Category', 'javo_fr'))
		, 'location'		=> $javo_meta_query->cat('item_location', __('No Location', 'javo_fr'))
		, 'lat'				=> $javo_latlng->get('lat')
		, 'lng'				=> $javo_latlng->get('lng')
		, 'icon'			=> $javo_set_icon
		, 'phone'			=> $javo_meta_query->get('phone')
		, 'mobile'			=> $javo_meta_query->get('mobile')
		, 'website'			=> $javo_meta_query->get('website')
		, 'address'			=> $javo_meta_query->get('address')
		, 'email'			=> $javo_meta_query->get('email')
		, 'rating'			=> $javo_meta_query->get_child_count('ratings')
		, 'review'			=> $javo_meta_query->get_child_count('review')

	);
}
wp_reset_postdata();?>

<div class="javo_mhome_wrap">
	<div class="javo_mhome_sidebar_wrap">
		<div class="javo-mhome-sidebar-onoff"></div>
		<div class="javo_mhome_sidebar hidden"></div>
	</div>
	<!-- MAP Area -->
	<div class="map_cover"></div>
	<div class="javo_mhome_map_area"></div>
	<div class="category-menu-bar"></div>

	<!-- Right Sidebar Content -->
	<div class="javo_mhome_map_lists">
		<!-- Right Sidebar Inner -->
		<!-- Control & Filter Area -->
		<div class="main-map-search-wrap">
			<div class="row">

				<div class="col-md-6 text-left">
					<div class="javo-filter-column">
						<select name="filter[item_category]">
							<option value=""><?php _e('All Category', 'javo_fr');?></option>
							<?php echo apply_filters('javo_get_selbox_child_term_lists', 'item_category', null, 'select', $javo_map_query->get('item_category', null), 0, 0, "-");?>
						</select>
					</div>
					<div class="javo-filter-column">
						<select name="filter[item_location]">
							<option value=""><?php _e('All Location', 'javo_fr');?></option>
							<?php echo apply_filters('javo_get_selbox_child_term_lists', 'item_location', null, 'select', $javo_map_query->get('item_location', null), 0, 0, "-");?>
						</select>
					</div>
					<?php if( $javo_tso_map->get('box_hide_field_views', null) != 'hide' ){ ?>
						<div class="javo-filter-column">
							<div class="sel-box">
								<div class="sel-container">
									<i class="sel-arraow"></i>
									<input type="text" readonly value="<?php _e("Views","javo_fr"); ?>">
									<input type="hidden" name="type">
								</div><!-- /.sel-container -->
								<div class="sel-content">
									<ul>
										<li data-javo-hmap-ppp data-value='' value=''><?php _e('Views' ,'javo_fr');?></li>
										<li data-javo-hmap-ppp data-value='5' value='5'><?php _e('5 views' ,'javo_fr');?></li>
										<li data-javo-hmap-ppp data-value='10' value='10'><?php _e('10 views' ,'javo_fr');?></li>
										<li data-javo-hmap-ppp data-value='15' value='15'><?php _e('15 views' ,'javo_fr');?></li>
										<li data-javo-hmap-ppp data-value='30' value='30'><?php _e('30 views' ,'javo_fr');?></li>
										<li data-javo-hmap-ppp data-value='60' value='60'><?php _e('60 views' ,'javo_fr');?></li>
										<li data-javo-hmap-ppp data-value='100' value='100'><?php _e('100 views' ,'javo_fr');?></li>
									</ul>
								</div><!-- /.sel-content -->
							</div><!-- /.sel-box -->
						</div>
					<?php } // End if ?>

				</div>

				<div class="col-md-3">
					<div class="input-group input-group-sm" data-javo-hmap-keyword-search>
						<input type="text" class="form-control" value="<?php echo $javo_query->get("keyword", null);?>">
						<span class="input-group-btn">
							<button class="btn btn-dark"><span class="glyphicon glyphicon-search"></span></button>
						</span>
					</div><!-- /input-group -->
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-8">
							<div class="btn-group btn-group-justified" data-toggle="buttons">
								<label class="btn btn-default btn-sm active" id="grid">
									<input type="radio" name="btn_viewtype_switch" checked>
									<i class="glyphicon glyphicon-th-list"></i>
								</label>
								<label class="btn btn-default btn-sm" id="list">
									<input type="radio" name="btn_viewtype_switch">
									<i class="fa fa-list-ul"></i>
								</label>
							</div>

						</div>
						<div class="col-md-4">
							<div class="btn btn-default btn-sm" data-javo-hmap-sort><span class="glyphicon glyphicon-open"></span></div>
						</div>
					</div>
				</div>

			</div><!-- row-->
		</div> <!-- main-map-search-wrap -->
		<!-- Control & Filter Area Close -->

		<input type="hidden" name="javo_is_search" value="<?php echo isset( $_POST['filter'] );?>">

		<!-- Ajax Results Output Element-->

		<div class="javo_mhome_map_output item-list-page-wrap">
			<div class="body-content">
				<div class="col-md-12">
					<div id="products" class="list-group"></div><!-- /#prodicts -->
				</div><!-- /.col-md-12 -->
			</div><!-- /.body-content -->
		</div>

		<div class="mobile-map">
		<a class="go-under-map"><?php _e('Move to search form', 'javo_fr');?></a>
	</div> <!-- mobile-map-->
	</div><!-- Right Sidebar Content Close -->
</div>

<fieldset>
	<input type="hidden" name="javo-box-map-item-count" value="<?php echo (int)$javo_tso_map->get('box_item_count', -1);?>">
	<input type="hidden" javo-map-distance-max value="<?php echo (float)$javo_tso_map->get('distance_max', '500');?>">
	<input type="hidden" javo-map-distance-unit value="<?php echo $javo_tso_map->get('distance_unit', __('km', 'javo_fr'));?>">
	<input type="hidden" javo-wide-map-round>
	<input type="hidden" javo-map-read-more value="pagination">
	<input type="hidden" javo-map-all-items value="<?php echo htmlspecialchars(json_encode($javo_this_return));?>">
	<input type="hidden" name="javo_google_map_poi" value="<?php echo $javo_tso_map->get('poi', 'on');?>">
	<input type="hidden" javo-cluster-multiple value="<?php _e("This place contains multiple places. please select one.", 'javo_fr');?>">
	<input type="hidden" javo-marker-trigger-zoom value="<?php echo $javo_tso_map->get('trigger_zoom', 18);?>">
</fieldset>
<script type="text/template" id="javo-map-box-content-not-found">
<div class="text-center">
	<h3><?php _e('Not Found Items.', 'javo_fr');?></h3>
</div><!-- /.text-center -->
</script>

<script type="text/template" id="javo_map_this_loading">
	<h2 class="text-center">
		<img src="<?php echo JAVO_IMG_DIR.'/loading_6.gif';?>" width='50%'>
	</h2>
</script>
<script type="text/template" id="javo-map-box-panel-content">
	<div class="item col-md-6 col-xs-12">
		<div class="thumbnail item-list-box-map">
			<div class="thumb-wrap">
				{thumbnail_large}
				<div class="javo-left-overlay">
					<div class="javo-txt-meta-area admin-color-setting">{category}</div> <!-- javo-txt-meta-area -->
					<div class="corner-wrap">
						<div class="corner"></div>
						<div class="corner-background"></div>
					</div> <!-- corner-wrap -->
				</div>
				<div class="rate-icons">
					<?php if( $javo_custom_item_tab->get('ratings', '') == ''): ?>
						<div class="col-md-2">
							<div class="col-md-12 javo-rating-registed-score" data-score="{rating}"></div>
						</div>
					<?php endif; ?>
				</div> <!-- rate-icons -->
				<div class="intro">
					<h2 class="group inner list-group-item-heading">{post_title}</h2>
				</div> <!-- intro -->
				<div class="location">{avatar}</div> <!-- location -->
				<div class="three-inner-button">
					<a class="javo-hmap-marker-trigger three-inner-move" data-id="mid_{post_id}" data-post-id="{post_id}"><?php _e('Move', 'javo_fr');?></a>
					<a href="{permalink}" class="three-inner-detail"><?php _e('Detail', 'javo_fr');?></a>
					<a href="{permalink}" target="_brank" class="three-inner-popup"><?php _e('Popup', 'javo_fr');?></a>
				</div><!-- three-inner-button -->
			</div> <!-- thumb-wrap -->

			<div class="caption">
				<p class="group inner list-group-item-text">
				</p> <!-- list-group-item-text -->
				<div class="row">
					<div class="item-title-list">
						<a href="{permalink}">{post_title}</a>
					</div>
					<div class="group inner list-group-item-text item-excerpt-list">{excerpt}</div> <!-- list-group-item-text -->
					<div class="col-xs-8 col-sm-8 col-md-8">
						<div class="row">
							<div class="col-md-12">{location}</div><!-- col md 8 -->
						</div><!-- Row -->
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="social-wrap pull-right">
							<span class="javo-sns-wrap">
								<i class="sns-facebook" data-title="{post_title}" data-url="{permalink}">
									<a class="facebook"></a>
								</i>
								<i class="sns-twitter" data-title="{post_title}" data-url="{permalink}">
									<a class="twitter"></a>
								</i>
								<i class="sns-heart">
									<a class="favorite javo_favorite{favorite}"  data-post-id="{post_id}"></a>
								</i>
							</span>
						</div>
					</div><!-- socail -->
				</div><!-- row-->
			</div><!-- Caption -->
		</div><!-- Thumbnail -->
	</div><!-- Col-md-4 -->
</script>
<script type="text/template" id="javo-map-wide-infobx-content">

	<div class="javo_somw_info panel" style="min-height:220px;">
		<div class="des">
			<ul class="list-unstyled">
				<li><div class="prp-meta"><h4><strong>{post_title}</h4></strong></div></li>
				<li><div class="prp-meta">{phone}</div></li>
				<li><div class="prp-meta">{mobile}</div></li>
				<li><div class="prp-meta">{website}</div></li>
				<?php if ($javo_tso->get('javo_location_tab_get_direction')!='disabled'){?>
				<li>
					<div class="prp-meta">{address}
						<a href="{permalink}#item-location" class="btn btn-primary btn-get-direction btn-sm"><?php _e("Get directions", "javo_fr"); ?></a>
					</div>
				</li>
				<?php } ?>
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
<script type="text/template" id="javo-map-box-content-loading">
	<div class="row">
		<div class="col-md-12 text-center">
			<img src="<?php echo JAVO_THEME_DIR;?>/assets/images/loading.gif" width="150">
		</div><!-- /.text-center -->
	</div><!-- /.row -->
	<div class="row">
		<div class="col-md-12 text-center">
			<h3><?php _e('Loading', 'javo_fr');?></h3>
		</div><!-- /.text-center -->
	</div><!-- /.row -->
</script>
<script type="text/template" id="javo-map-inner-control-template">
	<div class="javo-map-inner-control-wrap">
		<div class="btn-group">
			<a class="btn btn-default active" data-map-move-allow><i class="fa fa-unlock"></i></a>
			<div class="btn btn-default default-cursor">
				<div class="inline-block"><i class="fa fa-compass"></i></div>
				<div class="javo-geoloc-slider inline-block" ></div>
			</div>
		</div><!-- /.btn-group -->
	</div><!-- /.javo-map-inner-control-wrap -->
</script>
<script type="text/javascript">



jQuery(function($){
	"use strict";
	var javo_map = {
		root:null
		, map:null
		, target:null
		, infoWindo:null
		, sidebar:null
		, distance_unit	: $('[javo-map-distance-unit]').val()
		, distance		: $('[javo-map-distance-unit]').val() == 'mile' ? 1609.344 : 1000
		, distance_max	: $('[javo-map-distance-max]').val()
		, remote:{}
		, options:{
			config:{
				items_per: $('[name="javo-box-map-item-count"]').val()

			}
			, map_init:{
				map:{
					options:{
						mapTypeId: google.maps.MapTypeId.ROADMAP
						, mapTypeControl: false
						, panControl: false
						, scrollwheel: false
						, streetViewControl: true
						, zoomControl: true
						, zoomControlOptions: {
							position: google.maps.ControlPosition.RIGHT_BOTTOM
							, style: google.maps.ZoomControlStyle.SMALL
						 }
					}
				}
				, panel:{
					options:{
						content:$('#javo-map-inner-control-template').html()
					}
				}
			}
			, ajax_options:{
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
			, ajax_list_options:{
				url: null
				, type: 'post'
				, data:{
					filter:{}
				}, dataType: 'json'
			}
			, ajax_favorite_options:{
				url: null
				, type: 'post'
				, data:{
					filter:{}
				}, dataType: 'json'
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
			, map_style:[
				{
					featureType: "poi",
					elementType: "labels",
					stylers: [
						{ visibility: "off" }
					]

				}
			]
		}
		,variable:{
			top_offset:
				$('header > nav').outerHeight()
				+ $('#wpadminbar').outerHeight()
				// Topbar is entered into Header Navigation.
				// + $('.javo-topbar').outerHeight()

		}
		, map_clear:function(){
			var $object = this;
			this.target.gmap3({ clear:{ name:["marker", "circle"] }});
		}
		, ajax_slider:function(t){
			var $this = $(t);

			this.options.ajax_slider_options.url = this.options.ajax_options.url;
			this.options.ajax_slider_options.data = {};
			this.options.ajax_slider_options.data.action = 'get_detail_images';
			this.options.ajax_slider_options.data.post_id = $this.data('post-id');
			this.options.ajax_slider_options.error = function(e){ console.log( e.responseText ); };
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
		, ajax_favorite:function(){
			var $object = this;

			$object.sidebar = $('.javo_mhome_sidebar');
			$object.sidebar.html( $('#javo_map_this_loading').html() );
			this.options.ajax_favorite_options.url = this.options.ajax_options.url;
			this.options.ajax_favorite_options.data = {};
			this.options.ajax_favorite_options.data.action = 'get_hmap_favorite_lists';
			this.options.ajax_favorite_options.error = function(e){};
			this.options.ajax_favorite_options.success = function(d){

				$object.sidebar.html( d.html );
			};
			jQuery.ajax(this.options.ajax_favorite_options);

		}
		, marker_clear:function(){
			this.target.gmap3({ clear:{ name:'marker' }});

		}
		, resize:function(){
			var winX = $(window).width();
			var winY = 0;

			winY += $('header.main').outerHeight(true);
			winY += $('#wpadminbar').outerHeight(true);
			// Topbar is entered into Header Navigation.
			// winY += $('div.javo-topbar').outerHeight(true);

			$('.javo_mhome_map_lists').css( 'top', winY);
			$('.javo_mhome_map_output').css( 'marginTop', $('.main-map-search-wrap').outerHeight(true) );

			if( parseInt( winX ) >= 992 )
			{
				$('html, body').css( 'overflowY', 'hidden' );
			}else{
				$('html, body').css( 'overflowY', 'auto' );
			}



			// Setup Map Height
			this.target.height( $(window).height() - winY );

			if( winX > 1500 ){
				$('.body-content').find('.item').addClass('col-lg-4');
			}else{
				$('.body-content').find('.item').removeClass('col-lg-4');
			};

		}
		, geolocation: function(){
			var $this		= $(this);
			var $object		= javo_map;
			var $radius = $('[javo-wide-map-round]').val();

			$object.target.gmap3({
				getgeoloc:{
					callback:function(latlng){
						if( !latlng ){
							$.javo_msg({content:'Your position access failed.'});
							return false;
						};
						$(this).gmap3({ clear:'circle' });
							$(this).gmap3({
								map:{
									options:{ center:latlng, zoom:12 }
								}, circle:{
									options:{
										center:latlng
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
		}
		, setMarker: function( result ){
			var $object = this;
			var markers = new Array();
			var avg = new google.maps.LatLngBounds();

			$object.getList();
			$object.map_clear();

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
					click:function(){
						$object.infoWindo.close();
					}
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
										*/
									}
								} );

							}
						}
					}
					, events:{
						click:function(m, e, c){
							$object.infoWindo.close();

							var str = '', nstr = '';
							str = $('#javo-map-wide-infobx-content').html();
							str = str.replace(/{post_id}/g, c.data.post_id);
							str = str.replace(/{post_title}/g, c.data.post_title);
							str = str.replace(/{permalink}/g, c.data.permalink);
							str = str.replace(/{thumbnail}/g, c.data.thumbnail);
							str = str.replace(/{category}/g, c.data.category);
							str = str.replace(/{location}/g, c.data.location);
							str = str.replace(/{phone}/g, c.data.phone || nstr);
							str = str.replace(/{mobile}/g, c.data.mobile || nstr);
							str = str.replace(/{website}/g, c.data.website || nstr);
							str = str.replace(/{email}/g, c.data.email || nstr);
							str = str.replace(/{address}/g, c.data.address || nstr);
							str = str.replace(/{author_name}/g, c.data.author_name || nstr);

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
			this.target.gmap3({
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
			this.options.ajax_list_options.data.action		= "javo_map";
			this.options.ajax_list_options.data.post_type	= "item";
			this.options.ajax_list_options.data.pagination	= $('[javo-map-read-more]').val()
			this.options.ajax_list_options.data.lang		= $('[name="javo_cur_lang"]').val();
			this.options.ajax_list_options.data.keyword = $('[data-javo-hmap-keyword-search]').find('[type="text"]').val();
			this.options.ajax_list_options.error			= function(e)
			{
				console.log( e.responseText );
				$.javo_msg({content: "Error" + e.state(), delay:10000});
			}
			this.options.ajax_list_options.success			= function(d)
			{
				if( $('[javo-map-read-more]').val() != 'read_more' )
				{
					$('.javo_mhome_map_output #products').empty();
				}
				else
				{
					$('.javo-wide-map-read-more').remove();
				}

				if( d.result != '' ){
					$.each( d.result , function( i, k ){
						var str = "";
						str = $('#javo-map-box-panel-content').html();

						str = str.replace(/{post_id}/g, i);
						str = str.replace(/{post_title}/g, k.post_title || '');
						str = str.replace(/{excerpt}/g, k.contents || '');
						str = str.replace(/{thumbnail_large}/g, k.thumbnail_large || '');
						str = str.replace(/{permalink}/g, k.permalink || '');
						str = str.replace(/{avatar}/g, k.avatar || '');
						str = str.replace(/{rating}/g, k.rating || 0);
						str = str.replace(/{favorite}/g, k.favorite || '' );
						str = str.replace(/{category}/g, k.category || '');
						str = str.replace(/{location}/g, k.location || '');

						$('.javo_mhome_map_output #products').append( str );
					});

					$('.javo_mhome_map_output #products').append( d.pagination );

					if( $('[javo-map-read-more]').val() == 'read_more' ){
						$object.options.ajax_list_options.data.offset += $object.options.ajax_list_options.data.ppp;
					}
					$object.refresh();
					$object.resize();

				}else{
					$('.javo_mhome_map_output #products').append( $('#javo-map-box-content-not-found').html()  );
				}
			}
			if( $('[javo-map-read-more]').val() != 'read_more' ){
				$('.javo_mhome_map_output #products').html($('#javo-map-box-content-loading').html());
			}
			$.ajax( this.options.ajax_list_options );
		}
		, run:function(){

			var $cover = $('.javo_mhome_wrap > .map_cover');
			var $object		= this;
			var markers		= new Array();
			var avg			= new google.maps.LatLngBounds();
			$cover.addClass('active');

			$('.javo_mhome_map_output #products').html($('#javo-map-box-content-loading').html());

			this.options.ajax_options.data.lang = $('[name="javo_cur_lang"]').val();
			this.options.ajax_options.data.keyword = $('[data-javo-hmap-keyword-search]').find('[type="text"]').val();
			this.options.ajax_options.complete = function(){
				$cover.removeClass('active');
			}
			this.options.ajax_options.success = function(d){

				// Get Contents
				$object.getList();

				// Clear Map
				$object.setMarker( d.result );
			};

			this.options.ajax_options.error = function(e){
				var jv_alert = "<div class='jv_alert'>";
				jv_alert += "Error : ";
				jv_alert += e.state();
				jv_alert += "<br>d</div>";

				$(jv_alert).appendTo( $object.target );

				$(".jv_alert")
				.css({
					top:"0px"
					, left:"20%"
					, background:"#f00"
					, color:"#fff"
					, position:"fixed"
					, zIndex: "9999"
					, padding: "15px"
					, opacity: 0
					, marginTop: "-300px"
				}).animate({ marginTop:0, opacity:0.8 }, 500, function(){

					var _this = $(this);
					_this.animate({ opacity:0, marginTop:"-5px" }, 5000, function(){ _this.remove(); });

				});
				console.log( e.responseText );
			};
			$.ajax( this.options.ajax_options );
		}
		, refresh:function(){
			$('.javo-rating-registed-score').each(function(k,v){
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
		, events:function(){
			var $object = this;
			$(document)
			.on('click', 'li[data-filter]', this.filter )
			.on('change', 'select[name^="filter"]', this.filter )
			.on('click', 'div[data-javo-hmap-sort]', function(){
				if( $(this).hasClass('asc') ){

					$object.options.ajax_list_options.data.order = 'desc';
					$(this)
						.removeClass('asc')
						.find('span').attr('class', 'glyphicon glyphicon-open');

				}else{
					$object.options.ajax_list_options.data.order = 'asc';
					$(this)
						.addClass('asc')
						.find('span').attr('class', 'glyphicon glyphicon-save');
				}
				$object.getList();

			}).on('click', 'li[data-javo-hmap-ppp]', function(){

				$object.options.ajax_list_options.data.ppp = $(this).data('value');
				$object.getList();

			}).on('change', 'select[data-column-remote]', function(){

				$object.options.ajax_options.data.column = $(this).val();
				$object.run();

			}).on('click', '.javo-hmap-marker-trigger', function(){
				var $this = $(this);
				$object.target.gmap3({
					get:{
						name:"marker"
					,		id: $this.data('id')
					, callback: function(m){
						google.maps.event.trigger(m, 'click');

						// Lists Move CLick Map Zoom
						$(this).gmap3('get').setZoom( parseInt( $("[javo-marker-trigger-zoom]").val() ) );	
					}
					}
				});
			}).on('click', '.javo-hmap-marker-trigger', function(){
				/*
				if( !$(this).hasClass('active')){
					$object.ajax_slider(this);
					$(this).addClass('active');
				};
				*/
			}).on('click', '.javo-hmap-switch-type', function(){
				$('.javo-hmap-switch-type').removeClass('active');
				$(this).addClass('active');
				$object.options.ajax_options.data.listing_type = $(this).data('value');
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
					$object.ajax_favorite();
				}
			}).on('click', '#contact_submit', function(){
				var $_this_form		= $(this).closest('form');
				var $_this			= $(this);
				$object.options.javo_mail.to = $_this_form.find('input[name="contact_this_from"]').val();
				$object.options.javo_mail.item_name = $_this_form.find('input[name="contact_item_name"]').val();
				$.javo_mail( $object.options.javo_mail, function(){
					$_this.button('loading');
				},function(){
					$('#author_contact').modal('hide');
					$_this.button('reset');

				});
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
			.on('click', '.go-under-map', function(){
				$('body, html')
					.animate({ scrollTop: ( $('.javo_mhome_map_area').outerHeight(true)-8) + 'px'	 }, 500);

			});
			$('[data-javo-hmap-keyword-search]').each(function(){
				var $this = $(this);
				$this
					.on('keypress', '[type="text"]', function(e){
						if( e.keyCode == 13 ){
							$this.find('button').trigger('click');
						};
					})
					.on('click', 'button', function(){
						$object.run();

					});
			});
		}
		, filter: function(){
			var $object = javo_map;

			var data = {};

			$('select[name^="filter"]').each(function(k, v){
				var $this = $(this);
				if( parseInt( this.value ) > 0 ){
					var n = this.name.replace("]", "").split("[")[1];
					data[n] = this.value;
				};
			});

			console.log( data );

			$object.options.ajax_options.data.filter = data;
			$object.options.ajax_list_options.data.filter = data;
			$object.options.ajax_options.data.current = 1;
			$object.options.ajax_list_options.data.current = 1;
			$object.run();
		}
		, side_move: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({ marginLeft: 0 }, 300);

			$('.javo_mhome_wrap').clearQueue().animate({
				// paddingLeft: $this.outerWidth() + 'px'
			}, 300);
		}
		, side_out: function(){
			var $this = $('.javo_mhome_sidebar');
			$this.clearQueue().animate({
				marginLeft: ( -$this.outerWidth()) + 'px'
			}, 300);
			$('.javo_mhome_wrap').animate({ paddingLeft: 0 }, 300);
		}
		, brief_run: function(e){
			var brief_option = {};
			brief_option.type = "post";
			brief_option.dataType = "json";
			brief_option.url = "<?php echo admin_url('admin-ajax.php');?>";
			brief_option.data = { "post_id" : $(e).data('id'), "action" : "javo_map_brief"};
			brief_option.error = function(e){ console.log( e.responseText ); };
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

			var is_poi_hidden = $('[name="javo_google_map_poi"]').val() == 'off';

			// Initialize Map
			this.target = $('.javo_mhome_map_area');
			this.el = $('.javo_mhome_map_area');
			this.target.gmap3( this.options.map_init );

			// Initalize DOC
			$('body').css('overflow', 'hidden');

			// Initialize Variables
			this.map = this.target.gmap3('get');

			if ( is_poi_hidden )
			{
				// Map Style
				this.map_style = new google.maps.StyledMapType( this.options.map_style, {name:'Javo Box Map'});
				this.map.mapTypes.set('map_style', this.map_style);
				this.map.setMapTypeId('map_style');
			}

			// Settings
			this.options.ajax_options.url					= "<?php echo admin_url('admin-ajax.php');?>";
			this.options.ajax_options.data.action			= "javo_map";
			this.options.ajax_options.data.post_type		= "item";
			this.options.ajax_options.data.ppp				= -1;
			this.options.ajax_options.data.listing_type		= 'page';

			this.options.ajax_list_options.url				= "<?php echo admin_url('admin-ajax.php');?>";
			this.options.ajax_list_options.data.action		= "javo_map";
			this.options.ajax_list_options.data.post_type	= "item";
			this.options.ajax_list_options.data.ppp			= this.options.config.items_per > 0 ? this.options.config.items_per : -1;
			this.options.ajax_list_options.data.offset		= 0;
			this.options.ajax_list_options.data.lang		= $('[name="javo_cur_lang"]').val();

			// Filter Examp
			// this.options.ajax_options.data.filter = { taxomony_name : term_id };

			// Initialize Layout
			this.resize();

			// Event Handlers
			this.events();

			if( $('[name="javo_is_search"]').val() ){
				// Set Request Filter or Initialize map
				this.filter();
			}else{
				// Setup first load Marker
				this.first_marker = JSON.parse( $('[javo-map-all-items]').val() );
				this.setMarker( this.first_marker );
			}

			$(window).load(function(){
				$('.javo_mhome_sidebar')
					.removeClass('hidden')
					.css({
						marginLeft: ( -$('.javo_mhome_sidebar').outerWidth(true)) + 'px'
						, marginTop: javo_map.variable.top_offset + 'px'
					});
			});

			this.infoWindo = new InfoBubble({
				minWidth:362
				, minHeight:225
				, overflow:true
				, shadowStyle: 1
				, padding: 5
				, borderRadius: 10
				, arrowSize: 20
				, borderWidth: 1
				, disableAutoPan: false
				, hideCloseButton: false
				, arrowPosition: 50
				, arrowStyle: 0
			});

			$('.javo-map-remote-panel').css('height', $('.javo-map-remote-item').outerHeight() );
			var javo_map_remote_items_w = $('.javo-map-remote-item').length <= 3 ? $('.javo-map-remote-item').length : 3;
			$('.javo-map-remote-panel').hover(function(){
				$(this).animate({
					width: javo_map_remote_items_w * $('.javo-map-remote-item').outerWidth() + 2
				}, 300, function(){
					$(this).css('height', 'auto');

				});
			}, function(){
				$(this).animate({
					width: $('.javo-map-remote-item').outerWidth() + 2
					, height: $('.javo-map-remote-item').outerHeight()
				}, 40);

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
			$(".javo-geoloc-slider")
				.noUiSlider(javo_PriceSlider_option)
				.on('set', this.geolocation);


			$('[name^="filter"]').chosen({ width:'100%' });


		} // End funciton _init



	};
	javo_map.init();
	window.javo_map = javo_map;
	$(window).on('resize', function(){ javo_map.resize(); });
	$('.container.footer-top').remove();
});
</script>
<?php get_footer( 'no-widget' );