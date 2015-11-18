/*
* jQuery javo Search Plugin; v1.2.1
* Last Modified	: 2014-11-11
* Copyright (C) 2014 javo
*/

/* How to use (Examps) :
$(".javo_item_output").javo_search({
	url: "<?php echo admin_url('admin_ajax.php');?>",
	loading: "<?php echo JAVO_THEME_DIR;?>/images/loading.gif",
	selFilter:$(".javo_sel_filter"),
	btnSubmit:$(".javo_search_field_submit"),
	txtKeyword:$("input[name='s']"),
	param:{
		type:11,
		post_type:"item"
	}
});
*/
(function($){
	window.javo_search_map_once = false;
	$.fn.javo_search = function(d){
		var a = $(this);
		var o = {}, p = {}, data={};

		window.javo_search_map_element = d.map.val();
		if( !window.javo_search_map_once )
		{
			var el, parent;
			el = $( d.map.val() );
			parent = el.parent();
			el.remove();
			parent.prepend( '<div class="' + d.map.val().replace('.', '') + '"></div>' );

			// Rebind
			el = $( d.map.val() );
			el.css({
				height				: '400px'
				, textAlign			: 'center'
				, verticalAlign		: 'middle'
				, paddingTop		: '30px'
			});
			el.html( '<strong>Google Map</strong> Initializing...<br>Please Wait' );
			window.javo_search_map_once = true;
		}

		// Ajax Initialize
		o.type = "post";
		o.dataType = "json";
		o.url = d.url;

		o.success = function(data){
			var bound = new google.maps.LatLngBounds();
			var markers = new Array();
			if(data.result == "success"){
				a.fadeOut('fast', function(){
					$(this).html(data.html).fadeIn('fast');
					if( d.success_callback != null && typeof( d.success_callback) != 'undefined' ){
						d.success_callback();
					}
				});
			}else{
				a.html("Fail to load posts!");
			};
			if(typeof(d.map) != "undefined"){
				var tar = d.map.val();
				if(tar != ""){
					if( typeof($(tar).get(0)) != "undefined" ){
						var t = $(tar);
						if( typeof(jQuery.fn.gmap3) != "undefined"){
							$.each(data.markers, function(i, v){
								if(v.lat != "", v.lng != ""){
									markers.push({ id: v.id, latLng:[v.lat, v.lng], data:v.info, options:{icon:v.icon}});
									bound.extend( new google.maps.LatLng(v.lat, v.lng));
								}
							});
							var m_options = { map:{ options:{
								/*center: bound.getCenter(), */
								zoom:6
								, mapTypeId			: google.maps.MapTypeId.ROADMAP
								, mapTypeControl	: false
								, navigationControl	: true
								, scrollwheel		: false
								, streetViewControl	: true
								} }
								,marker:{}
								, panel:{
									options:{
										content: "<div class='btn-group'><a class='btn btn-default active' data-listing-map-move-allow><i class='fa fa-unlock'></i></a></div>"
										, right: true
										, middle: true


								}
							}};
							m_options.marker = {
								values: markers,
								events:{
									click:
										function(m, e, c){
											var map = $(this).gmap3("get"), infoBox = $(this).gmap3({get:{name:"infowindow"}});
											if(infoBox){
												infoBox.open(map, m);
												console.log( c.data.content );
												infoBox.setContent(c.data.content);
											}else{
												$(this).gmap3({ infowindow:{ anchor:m, options:{content: c.data.content, maxWidth:500} } });
											};
										}
								}
								, cluster:{
									radius:100
									, 0:{ content:'<div class="javo-map-cluster admin-color-setting">CLUSTER_COUNT</div>', width:52, height:52 }
									, events:{
										click:function(c, e, d){

											var $map		= $(this).gmap3('get');
											var $el			= $( window.javo_search_map_element );
											var $infoBox	= $(this).gmap3({get:{name:"infowindow"}});
											var maxZoom		= new google.maps.MaxZoomService();
											var c_bound		= new google.maps.LatLngBounds();
											var c_anchor	= new google.maps.MVCObject;

											// IF Cluster Max Zoom ?
											maxZoom.getMaxZoomAtLatLng( d.data.latLng , function( response ){
												if( response.zoom <= $map.getZoom() && d.data.markers.length > 0 )
												{
													var str = '';
													str += "<div class='list-group'>";

													str += "<a class='list-group-item disabled text-center'>";
														str += "<strong>";
															str += $("[javo-cluster-multiple]").val();
														str += "</strong>";
													str += "</a>";
													$.each( d.data.markers, function( i, k ){
														str += "<a href=\"javascript:javo_search_marker_trigger('" + k.id +"');\" ";
															str += "class='list-group-item'>";
															str += "<span class='badge pull-left'>" + parseInt( i + 1 ) +  "</span>&nbsp;&nbsp;";
															str += k.data.post_title;
														str += "</a>";
													});

													str += "</div>";

													//c_anchor.set( 'position', c.main.getPosition() );
													c_anchor.set( 'position', c.main.getPosition() );

													if( $infoBox )
													{
														$infoBox.setContent( str );
														$infoBox.setPosition( c.main.getPosition() );
														$infoBox.open( $map );
													} else {
														$el.gmap3({ infowindow:{ options:{ content: str, maxWidth:500, position: c.main.getPosition() } } });
													}

												}else{

													$.each( d.data.markers, function(i, k){
														c_bound.extend( new google.maps.LatLng( k.latLng[0], k.latLng[1] ) );
													});
													$map.fitBounds( c_bound );
												}
											} );

										// Cluster Marker Click Func Close -->
										}
									}
								}
							};

							$( d.map.val() )
								.height(400)
								.gmap3({ clear:{ name:[ 'marker', 'infowindow'] }})
								.gmap3(m_options);
							var _m = $( d.map.val() ).gmap3("get");
							if( markers.length > 0 ){
								_m.fitBounds(bound);
							};
						}else{
							t.html("<h1>Please, install to jQuery gmap3.</h1>");
						}
					}
				}
			}
		}

		o.error = function(e){ alert("Error : " + e.state()); console.log( e.responseText ); };

		// Ajax Parametter Initialize
		p = $.extend({
			type				: 1
			, ppp				: 10
			, featured			: "image"
			, page				: "widget"
			, post_type			: "item"
			, meta_term			: false
			, success_callback	: null
			, before_callback	: null
			, start				: true
		}, d.param);


		if( p.start ) rsearch(p);

		$( document ).on( 'click', '[data-listing-map-move-allow]', function( e ){

			var $map = $( d.map.val() ).gmap3('get');
			$(this).toggleClass('active');
			if( $(this).hasClass('active') )
			{
				// Allow
				$map.setOptions({draggable:true});
				$(this).find('i').removeClass('fa fa-lock').addClass('fa fa-unlock');
			}
			else
			{
				// Not Allowed
				$map.setOptions({draggable:false});
				$(this).find('i').removeClass('fa fa-unlock').addClass('fa fa-lock');
			}

		});

		// Buttons Functions
		$(document).find(d.btnView).off().on("change", function(){
			if(typeof(d.btnView) != "undefined"){
				p.type = $(this).val();
				rsearch(p);
			};
		});

		$(document).find(a).off().on("click", ".page-numbers", function(e){
			if(!p.start ) return;
			e.preventDefault();
			var pn = $(this).attr("href").split("=");
			p.page = (typeof(pn[1]) != "undefined")? pn[1] : 1;
			rsearch(p);
		});

		$(d.btnSubmit).on("click", function(e){
			e.preventDefault();
			if(typeof(d.btnSubmit) != "undefined"){
				rsearch(p);
			};
		});
		$(d.txtKeyword).on("keyup", d.txtKeyword, function(e){
			if(e.keyCode == 13){
				p.page = 1;
				rsearch(p);
			};
		});
		function rsearch(p){
			p.start = true;

			if(typeof(d.selFilter) != "undefined"){
				$.each(d.selFilter, function(){
					if( this.value != "" && this.value > 0){
						var n = this.name.replace("]", "").split("[")[1];
						data[n] = this.value;
					};
				});

				p.tax = data;
			};
			if(typeof(d.txtKeyword) != "undefined"){
				p.keyword = d.txtKeyword.val();
			};
			if( typeof(d.post_id) != "undefined" ){
				p.post_id = d.post_id;
			}
			if( d.meta_term != false && typeof(d.meta_term) != "undefined"){
				data = {};
				$.each(d.meta_term, function(i, v){
					var n = this.name.replace("]", "").split("[")[1];
					data[n] = this.value;
				});
				p.term_meta = data;
			};
			if( d.price_term != false && typeof(d.price_term) != "undefined"){
				data = {};
				$.each(d.price_term, function(i, v){
					var n = this.name.replace("]", "").split("[")[1];
					data[n] = this.value;
				});
				p.price_term = data;
			};
			if( d.area_term != false && typeof(d.area_term) != "undefined"){
				data = {};
				$.each(d.area_term, function(i, v){
					var n = this.name.replace("]", "").split("[")[1];
					data[n] = this.value;
				});
				p.area_term = data;
			};
			p.action = "post_list";
			o.data = p;
			if( d.before_callback != null && typeof( d.before_callback) != 'undefined' ){
				d.before_callback();
			}
			$.ajax(o);
		}
		window.javo_search_marker_trigger = function( marker_id ){

			var el = jQuery( window.javo_search_map_element );
			el.gmap3({
				get:{
					name: 'marker'
					, id: marker_id
					, callback: function( marker ){
						google.maps.event.trigger( marker, 'click' );
					}

				}
			});
		}
	};
})(jQuery);
