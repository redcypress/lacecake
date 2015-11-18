<?php
class javo_post_meta_func
{
	public function __construct()
	{
		add_action('add_meta_boxes'	, Array( __CLASS__, 'javo_post_meta_box_init'), 30);
		add_action('save_post'		, Array( __CLASS__, 'javo_post_meta_box_save'));
		//add_action('admin_footer'	, Array( __CLASS__, 'javo_post_meta_scripts_callback'));
		add_action('dbx_post_sidebar'	, Array( __CLASS__, 'javo_post_meta_scripts_callback'));
	}

	public static function javo_post_meta_box_init()
	{
		$javo_meta_boxes = Array(
			// Post Meta ID.							MetaBox Callback				Post Type		Position	Level		Description
			// =============================================================================================================================
			'javo_page_options'				=> Array( 'javo_page_option_box'			, 'page'		, 'side'	, 'high', __('Item Listing Filter (only for item listing pages)', 'javo_fr'))
			, 'javo_page_item_listing'		=> Array( 'javo_page_item_listing_callback'	, 'page'		, 'side'	, 'core', __('Item Listing Page Setup', 'javo_fr'))
			, 'javo_blog_options'			=> Array( 'javo_blog_option_box'			, 'page'		, 'side'	, 'high', __('Blogs Listing Filter (only for post listing pages)', 'javo_fr'))
			, 'javo_item_options'			=> Array( 'javo_item_option_box'			, 'item'		, 'normal'	, 'high', __('Item Meta', 'javo_fr'))
			, 'javo_special_item'			=> Array( 'javo_special_item_callback'		, 'item'		, 'side'	, 'high', __('Item Setting', 'javo_fr'))
			, 'javo_payment_item'			=> Array( 'javo_payment_item_callback'		, 'item'		, 'side'	, 'high', __('Payment', 'javo_fr'))
			, 'javo_event_options'			=> Array( 'javo_event_metabox_callback'		, 'jv_events'	, 'normal'	, 'core', __('Event Setting', 'javo_fr'))
			, 'javo_partners_options'		=> Array( 'javo_partners_callback'			, 'jv_partners'	, 'normal'	, 'core', __('Partners Attribute', 'javo_fr'))
			, 'javo_review_otions'			=> Array( 'javo_review_metabox_callback'	, 'review'		, 'normal'	, 'core', __('Review Setting', 'javo_fr'))
			, 'javo_item_author'			=> Array( 'javo_item_author_callback'		, 'item'		, 'side'	, 'core', __('Assign (Author/Owner)', 'javo_fr'))
		);

		$javo_meta_boxes_post_and_page = Array(
			// Post Meta ID.							MetaBox Callback						Position	Level		Description
			// =============================================================================================================================
			'javo_post_sidebar_options'		=> Array( 'javo_post_sidebar_option_box'	, null , 'side'		, 'high', __('Sidebar Options', 'javo_fr'))
			, 'javo_post_header_options'	=> Array( 'javo_post_header_option_box'		, null , 'normal'	, 'high', __('Header Options', 'javo_fr'))
			, 'javo_post_header_fancy'		=> Array( 'javo_post_header_fancy_option'	, null , 'normal'	, 'high', __('Fancy header options', 'javo_fr'))
			, 'javo_post_header_slide'		=> Array( 'javo_post_header_slide_option'	, null , 'normal'	, 'high', __('Slide header options', 'javo_fr'))
		);

		foreach( $javo_meta_boxes as $boxID => $attribute )
		{
			add_meta_box( $boxID, $attribute[4], Array( __CLASS__, $attribute[0] ), $attribute[1], $attribute[2], $attribute[3]);
		}

		foreach( Array( 'post', 'page' ) as $post_type )
		{
			foreach( $javo_meta_boxes_post_and_page as $boxID => $attribute )
			{
				add_meta_box( $boxID, $attribute[4], Array( __CLASS__, $attribute[0] ), $post_type, $attribute[2], $attribute[3]);
			}
		}
	}

	public static function javo_post_meta_scripts_callback( $post )
	{
		global $javo_tso;

		$javo_ts_map	= new javo_ARRAY( (Array)$javo_tso->get('map', Array() ) );
		$javo_fancy		= @unserialize(get_post_meta($post->ID, "javo_fancy_options", true));
		$get_javo_opt_slider = get_post_meta($post->ID, "javo_slider_type", true);
		$get_javo_opt_fancy = get_post_meta($post->ID, "javo_header_fancy_type", true);
		$javo_blog_term_array = @unserialize(get_post_meta($post->ID, "javo_blog_terms", true));
		$get_javo_opt_header = get_post_meta($post->ID, "javo_header_type", true);

		$alerts			= Array(
			"address_search_fail" => __('Sorry, find address failed', 'javo_fr')
		);

		ob_start();
		?>

		<script type='text/javascript'>

		jQuery( function( $ ){

			window.javo_post_meta_scripts = {

				init:function()
				{
					this.item_meta();
					this.payment_extend();
					this.others();

					$( document )
						.on( "change", "select[name='page_template']", this.template_meta )
						.on( 'keypress keyup blur', '.only-number', this.only_number )
						.on( 'keyup', '[name="javo_pt[map][lat]"], [name="javo_pt[map][lng]"]', this.type_latLgn )
						.on( 'click', '[name="javo_pt[map][street_visible]"]', this.toggle_streetview )

					;$("select[name='page_template']").trigger('change')											
					;$("select[data-autocomplete]").chosen();
				}

				, template_meta: function()
				{

					var current_template = $(this).val();

					var javo_templates = {
						"#javo_page_options"			: "templates/tp-item-list.php"
						, "#javo_page_item_listing"		: "templates/tp-item-list.php"
						, "#javo_blog_options"			: "templates/tp-blogs.php"
					};

					$.each( javo_templates, function( i, k )
					{
						if( current_template == k )
						{
							$( i ).removeClass('hidden').show();
						}else{
							$( i ).addClass('hidden').hide();
						}
					});
				}

				, item_meta: function()
				{

					this.el			= $(".javo-item-map-container");
					this.st_el		= $(".javo-item-streetview-container");
					this.streetView = $("[name='javo_pt[map][street_visible]']").is(":checked");

					this.st_el.height(350);

					// This Item get Location
					this.latLng = $("input[name='javo_pt[map][lat]']").val() != "" && $("input[name='javo_pt[map][lng]']").val() != "" ?
						new google.maps.LatLng($("input[name='javo_pt[map][lat]']").val(), $("input[name='javo_pt[map][lng]']").val()) :
						new google.maps.LatLng(<?php echo $javo_ts_map->get('default_lat', 40.7143528);?>, <?php echo $javo_ts_map->get('default_lng', -74.0059731);?>);

					// Initialize Map Options
					this.map_options = {
						map:{ options:{ zoom:10, center: this.latLng } }
						, marker:{
							latLng		: this.latLng
							, options:{
								draggable	: true
							}
							, events:{
								position_changed: function( m )
								{
									$('input[name="javo_pt[map][lat]"]').val( m.getPosition().lat() );
									$('input[name="javo_pt[map][lng]"]').val( m.getPosition().lng() );
									$('input[name="javo_pt[map][street_lat]"]').val( m.getPosition().lat() );
									$('input[name="javo_pt[map][street_lng]"]').val( m.getPosition().lng() );

									if( $("[name='javo_pt[map][street_visible]']").is(":checked") )
									{

										$(this).gmap3({
											get:{
												name:'streetviewpanorama'
												, callback: function( streetView )
												{
													if( typeof streetView != 'undefined' )
													{
														streetView.setPosition( m.getPosition() );
														streetView.setVisible();
													}
												}
											}
										});
									}
								}

							}
						}, streetviewpanorama:{
							options:{
								container: this.st_el
								, opts:{
									position: new google.maps.LatLng( $('[name="javo_pt[map][street_lat]"]').val(), $('[name="javo_pt[map][street_lng]"]').val() )
									, pov:{
										heading: parseFloat( $('[name="javo_pt[map][street_heading]"]').val() )
										, pitch: parseFloat( $('[name="javo_pt[map][street_pitch]"]').val() )
										, zoom: parseFloat( $('[name="javo_pt[map][street_zoom]"]').val() )
									}
									, addressControl	: false
									, clickToGo			: true
									, panControl		: true
									, linksControl		: true
								}
							}
							, events:{
								pov_changed:function( pano ){
									$('[name="javo_pt[map][street_heading]"]').val( parseFloat( pano.pov.heading ) );
									$('[name="javo_pt[map][street_pitch]"]').val( parseFloat( pano.pov.pitch ) );
									$('[name="javo_pt[map][street_zoom]"]').val( parseFloat( pano.pov.zoom ) );
								}
								, position_changed: function( pano ){
									$('[name="javo_pt[map][street_lat]"]').val( parseFloat( pano.getPosition().lat() ) );
									$('[name="javo_pt[map][street_lng]"]').val( parseFloat(  pano.getPosition().lng() ) );
								}
							}
						}
					};

					this.el.css("height", 300).gmap3( this.map_options );
					this.map = this.el.gmap3('get');

					if( !this.streetView && this.el.length > 0 ){
						this.map.getStreetView().setVisible( false );
					}

					$( document )
						.on("click", ".javo_pt_detail_del", function(){
							var t = $(this);
							t.parents(".javo_pt_field").remove();
						})
						.on("click", ".javo_pt_detail_add", function(e){
							e.preventDefault();
							var attachment;
							var file_frame, t = $(this);
							if(file_frame){ file_frame.open(); return; }
							file_frame = wp.media.frames.file_frame = wp.media({
								title: jQuery( this ).data( 'uploader_title' ),
								button: {
									text: jQuery( this ).data( 'uploader_button_text' ),
								},
								multiple: false
							});
							file_frame.on( 'select', function(){
								var str ="";
								attachment = file_frame.state().get('selection').first().toJSON();

								str += "<div class='javo_pt_field' style='float:left;'>";
								str += "<img src='" + attachment.url + "' width='150'> <div align='center'>";
								str += "<input name='javo_pt_detail[]' value='" + attachment.id + "' type='hidden'>";
								str += "<input class='javo_pt_detail_del button' type='button' value='Delete'>";
								str += "</div></div>";
								t.parents("td").find(".javo_pt_images").append(str);
							});
							file_frame.open();
						})
						.on("keyup", ".javo_txt_find_address", function(e){
							e.preventDefault();

							if(e.keyCode == 13){
								$(".javo_btn_find_address").trigger("click");
							}
							return false;
						})
						.on("click", ".javo_btn_find_address", function(){

							var _addr = $(".javo_txt_find_address").val();
							$(".javo-item-map-container").gmap3({
								getlatlng:{
									address:_addr,
									callback:function(r){
										if(!r){
											alert('<?php echo $alerts["address_search_fail"];?>');
											return false;
										}
										var _find = r[0].geometry.location;
										$("input[name='javo_pt[map][lat]']").val(_find.lat());
										$("input[name='javo_pt[map][lng]']").val(_find.lng());
										$(".javo-item-map-container").gmap3({
											get:{
												name:"marker",
												callback:function(m){
													m.setPosition(_find);
													$(".javo-item-map-container").gmap3({map:{options:{center:_find}}});
												}
											}
										});
									}
								}
							});
						});
				}

				, toggle_streetview: function( e )
				{
					var obj = window.javo_post_meta_scripts;

					if( $(this).is(":checked") )
					{
						obj.st_el.removeClass('hidden');
						obj.map.getStreetView().setVisible( true );
					}else{
						obj.st_el.addClass('hidden');
						obj.map.getStreetView().setVisible( false );
					}
				}

				, type_latLgn: function( e )
				{
					var _this		= this;
					var obj			= window.javo_post_meta_scripts;
					this.lat		= parseFloat( $('[name="javo_pt[map][lat]"]').val() );
					this.lng		= parseFloat( $('[name="javo_pt[map][lng]"]').val() );

					if( isNaN( this.lat ) || isNaN( this.lng ) ){ return; }

					this.latLng		= new google.maps.LatLng( this.lat, this.lng );

					obj.el.gmap3({
						get:{
							name: "marker"
							, callback: function( marker )
							{
								if( typeof window.nTimeID != "undefiend" ){
									clearInterval( window.nTimeID );
								};
								window.nTimeID = setInterval( function(){
									marker.setPosition( _this.latLng );
									obj.el.gmap3('get').setCenter( _this.latLng );
									clearInterval( window.nTimeID );
								}, 1000 );
							}
						}
					});
				}
				, only_number		: function( e ){

					$(this).val($(this).val().replace(/[^0-9\.-]/g,''));

					if (
						(e.which != 45 || $(this).val().indexOf('-') != -1) &&
						(e.which != 46 || $(this).val().indexOf('.') != -1) &&						
						(e.which < 48 || e.which > 57)
					){
						e.preventDefault();
					}
				}

				, payment_extend: function(){
					this.submit			= $("[data-javo-payment-submit]");
					this.once			= true;

					this.submit.on('click', function( e ){
						e.preventDefault();

						var obj				= window.javo_post_meta_scripts;
						var $this			= $(this);
						var _this			= this;
						this.input			= $("[data-javo-payment-set-expire-day]").val();
						this.input_empty	= $("[data-javo-payment-empty-expire-day]").val();
						this.ajax_url		= $("[data-ajax-url]").val();
						this.post			= $("[data-post-id]").val();
						this.el				= $("[data-javo-payment-state]");

						if( parseInt( this.input ) <= 0 || isNaN( this.input ) ){

							alert( this.input_empty );
							return false;
						};

						this.options			= {};
						this.options.type		= "post";
						this.options.url		= this.ajax_url;
						this.options.dataType	= "json";
						this.options.data		= { post_id: this.post, expire: this.input, action: "javo_admin_payment_expire"  };
						this.options.error		= function( response )
						{
							console.log( response.responseText );
							alert( "Server Error" );
							obj.once			= true;
							$this.removeClass('disabled');
						}
						this.options.success	= function( response )
						{
							// response.state

							alert( response.notice );
							if( response.state == "success" )
							{
								_this.el.html( response.expire );
							}

							obj.once			= true;
							$this.removeClass('disabled');
						}

						$(this).addClass('disabled');

						if( obj.once ){
							obj.once			= false;
							$.ajax( this.options );
						}
					});
				}

				, others: function(){


					$( document ).on("click", ".javo_pmb_option", function(){
						if( $(this).hasClass("sidebar") ) $(".javo_pmb_option.sidebar").removeClass("active");
						if( $(this).hasClass("header") ) $(".javo_pmb_option.header").removeClass("active");
						if( $(this).hasClass("fancy") ) $(".javo_pmb_option.fancy").removeClass("active");
						if( $(this).hasClass("slider") ) $(".javo_pmb_option.slider").removeClass("active");
						$(this).addClass("active");
					}).on("change", "input[name='javo_opt_header']", function(){
						$("#javo_post_header_fancy, #javo_post_header_slide").hide();
						switch( $(this).val() ){
							case "fancy": $("#javo_post_header_fancy").show(); break;
							case "slider": $("#javo_post_header_slide").show(); break;
						};
					});




					$('.javo_item_listing_filter').each(function(){
						var $this = $(this);
						$this.find('select').on('change', function(){
							$this.find('[data-javo-il]').addClass('hidden');
							$this.find('[data-javo-il="' + $(this).val() + '"]').removeClass('hidden').show();
						}).trigger('change');
					});




					var t = new Array( $("select[name='javo_fancy[bg_repeat]']"), $("select[name='javo_fancy[bg_position_x]']"), $("select[name='javo_fancy[bg_position_y]']") );
					var r = new Array("<?php echo $javo_fancy['bg_repeat'];?>", "<?php echo $javo_fancy['bg_position_x'];?>", "<?php echo $javo_fancy['bg_position_y'];?>");
					$.each(r, function(i, v){
						if(v != "") t[i].val(v);
					});




					var t = "<?php echo $get_javo_opt_header;?>";
					if(t != "")$("input[name='javo_opt_header'][value='" + t + "']").trigger("click");









					$("body").on("change", "input[name='javo_opt_slider']", function(){
						$(".javo_pmb_tabs.slider")
							.children("div")
							.removeClass("active");
						$("div[tab='" + $(this).val() + "']").addClass("active");
					});
					var t = "<?php echo $get_javo_opt_slider;?>";
					if(t != "")$("input[name='javo_opt_slider'][value='" + t + "']").trigger("click");








					var current_blog_term = new Array();
					var current_blog_tax = "<?php echo get_post_meta($post->ID, 'javo_blog_tax', true);?>";
					<?php
					if( !empty( $javo_blog_term_array ) ){
						foreach( $javo_blog_term_array as $term=>$value){
							printf("current_blog_term.push(%s);\n", $term);
						};
					};
					?>
					for(i in current_blog_term){
						$("input[name='javo_blog_terms[" + current_blog_term[i] + "]']").trigger("click");
					}
					$("div[class^='javo_blog_tax_']").hide();
					$("select[name='javo_blog_tax']").on("change", function(){
						$("div[class^='javo_blog_tax_']").hide();
						$(".javo_blog_tax_" + $(this).children("option:selected").text()).show();
					});
					if(current_blog_tax != ""){
						$("select[name='javo_blog_tax']").val(current_blog_tax).trigger("change");
					}

					var t = "<?php echo $get_javo_opt_fancy;?>";
					if(t != "")$("input[name='javo_opt_fancy'][value='" + t + "']").trigger("click");

					$("body").on("click", ".fileupload", function(e){
						var attachment;
						var t = $(this).attr("tar");
						e.preventDefault();
						var file_frame;
						if(file_frame){ file_frame.open(); return; }
						file_frame = wp.media.frames.file_frame = wp.media({
							title: jQuery( this ).data( 'uploader_title' ),
							button: {
								text: jQuery( this ).data( 'uploader_button_text' ),
							},
							multiple: false
						});
						file_frame.on( 'select', function(){
							attachment = file_frame.state().get('selection').first().toJSON();
							$(t).val(attachment.url);
							$(".javo_bg_img_preview").prop("src", attachment.url);
						});
						file_frame.open();
					}).on("click", ".fileuploadcancel", function(){
						var t = $(this).attr("tar");
						$(t).val("");
						$(".javo_bg_img_preview").prop("src", "");
					});

				// End Other Function
				}
			};

			window.javo_post_meta_scripts.init();


		});
		</script>

		<?php
		ob_end_flush();
	}
	public static function javo_page_option_box($post)
	{
		$taxs = get_taxonomies(Array("object_type"=> Array("item")));
		$tax_array = @unserialize(get_post_meta($post->ID, 'javo_item_tax', true));
		$term_array = @unserialize(get_post_meta($post->ID, "javo_item_terms", true));

		ob_start();
		?>

		<h3><?php _e('Filtering 1.', 'javo_fr');?></h3>
		<div class="javo_item_listing_filter">
			<select name="javo_item_tax[tax1]">
				<option value=""><?php _e('None', 'javo_fr');?></option>
				<?php
				foreach($taxs as $tax){
					printf('<option value="%s" %s>%s</option>'
						, $tax, ((!empty($tax_array['tax1']) && $tax == $tax_array['tax1'])? ' selected': '')
						, get_taxonomy($tax)->label);
				};?>
			</select>
			<?php
			foreach($taxs as $tax){?>
				<div class="hidden" data-javo-il="<?php echo $tax;?>">
				<?php
					$terms = get_terms($tax, Array("hide_empty" => 0, 'parent' => 0	));
					foreacH($terms as $term)
						printf("<label><input name='javo_item_terms[tax1]' value='%s' type='radio' %s>&nbsp;%s</label><br>"
							, $term->term_id
							, checked(!empty($term_array['tax1']) && $term_array['tax1'] == $term->term_id, true, false)
							, $term->name
						);
				?>
				</div>
			<?php }	?>
		</div>
		<hr>
		<h3><?php _e('Filtering 2.', 'javo_fr');?></h3>
		<div class="javo_item_listing_filter">
			<select name="javo_item_tax[tax2]">
				<option value=""><?php _e('None', 'javo_fr');?></option>
				<?php
				foreach($taxs as $tax){
					printf('<option value="%s" %s>%s</option>'
						, $tax, ((!empty($tax_array['tax2']) && $tax == $tax_array['tax2']) ? ' selected': '')
						, get_taxonomy($tax)->label);
				};?>
			</select>
			<?php
			foreach($taxs as $tax){?>
				<div class="hidden" data-javo-il="<?php echo $tax;?>">
				<?php
				$terms = get_terms($tax, Array("hide_empty"=>0));
				foreacH($terms as $term)
					printf("<label><input name='javo_item_terms[tax2]' value='%s' type='radio' %s>&nbsp;%s</label><br>"
						, $term->term_id
						, checked( !empty( $term_array['tax2'] ) && $term_array['tax2'] == $term->term_id, true, false )
						, $term->name
					);
				?>
				</div>
			<?php }	?>
		</div>
		<?php
		ob_end_flush();
	}
	public static function javo_page_item_listing_callback($post)
	{
		$javo_this_types = Array(
			__('Grid Style', 'javo_fr')			=> 2
			, __('Line List Style', 'javo_fr')	=> 4
		);
		$javo_pre_values = get_post_meta($post->ID, 'javo_item_listing_type', true);

		ob_start();
		?>
		<h4><?php _e('Default Listing Type', 'javo_fr');?></h4>
		<select name="javo_il[type]">
			<?php
			foreach($javo_this_types as $label => $type){
				printf('<option value="%s"%s>%s</option>', $type, ($javo_pre_values == $type ? ' selected':''), $label);
			};?>
		</select>
		<?php
		ob_end_flush();
	}
	public static function javo_blog_option_box($post)
	{
		$javo_blog_tax = get_taxonomies(Array("object_type"=> Array("post")));
		$javo_blog_term_array = @unserialize(get_post_meta($post->ID, "javo_blog_terms", true));

		ob_start();

		printf('<select name="javo_blog_tax"><option value="">%s</option>', __('None', 'javo_fr'));
		foreach($javo_blog_tax as $tax)
			printf("<option value='%s'>%s</option>"
				, $tax
				, get_taxonomy($tax)->label
			);
		echo "</select>";

		foreach($javo_blog_tax as $tax)
		{
			?>
			<div class="javo_blog_tax_<?php echo get_taxonomy($tax)->label;?>">
				<?php
					$javo_blog_terms = get_terms($tax, Array("hide_empty"=>0));
					foreacH($javo_blog_terms as $term)
						printf("<label><input name='javo_blog_terms[%s]' value='use' type='checkbox'>&nbsp;%s</label><br>"
							, $term->term_id
							, $term->name
						);
				?>
			</div>
			<?php
		} ?>
		<hr>
		<?php
		ob_end_flush();
	}

	public static function javo_item_option_box($post)
	{
		global $javo_tso;
		$javo_ts_map	= new javo_ARRAY( (Array)$javo_tso->get('map', Array() ) );
		$javo_meta		= new javo_get_meta($post->ID);
		$javo_latLng	= new javo_ARRAY( @unserialize( $javo_meta->_get('latlng') ) );
		ob_start();
		?>

		<table class="form-table">
			<tr>
				<th colspan="2"><?php _e('Additional Item Information', 'javo_fr');?></th>
			</tr>
			<tr>
				<th><?php _e('Address', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][address]" value="<?php echo $javo_meta->get('address');?>"></td>
			</tr>
			<tr>
				<th><?php _e('Telephone', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][phone]" value="<?php echo $javo_meta->get('phone');?>"></td>
			</tr>
			<tr>
				<th><?php _e('Email Address', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][email]" value="<?php echo $javo_meta->get('email');?>"></td>
			</tr>
			<tr>
				<th><?php _e('Website Address', 'javo_fr');?></th>
				<td><input name="javo_pt[meta][website]" value="<?php echo $javo_meta->get('website');?>"></td>
			</tr>
			<tr>
				<th><?php _e('Video', 'javo_fr');?></th>
				<td>
					<?php
					$javo_video_portals		= Array('youtube', 'vimeo', 'dailymotion', 'yahoo', 'bliptv', 'veoh', 'viddler');
					$javo_get_video_meta	= (Array)get_post_meta($post->ID, 'video', true);
					$javo_video_meta		= new javo_ARRAY( $javo_get_video_meta );
					$javo_get_video			= Array(
						"portal"			=> $javo_video_meta->get('portal', NULL)
						, "video_id"		=> $javo_video_meta->get('video_id', NULL)
					);
					$javo_this_selbox_options = Array(
						__('With slider (first)', 'javo_fr')					=> 'slide'
						, __('Header ( only "Youtube", "vimeo")', 'javo_fr')	=> 'header'
						, __('After Description Section', 'javo_fr')			=> 'descript'
						, __('After Contact Section', 'javo_fr')				=> 'contact'
						, __('Hide / Disable', 'javo_fr')						=> 'disabled'
					);?>

					<select name="javo_video[portal]">
					<option value=""><?php _e('None', 'javo_fr');?></option>
					<?php
					foreach($javo_video_portals as $portal){
						printf('<option value="%s"%s>%s</option>'
							, $portal
							, ($portal ==  $javo_get_video['portal'] ? ' selected':'')
							,$portal
						);
					};?>
					</select>
					<input name="javo_video[video_id]" value="<?php echo $javo_get_video['video_id'];?>">

					<div class="javo_iclbox_wrap">
						<br>
						<h4><?php _e('Video Location', 'javo_fr');?></h4>
						<div>
							<select name="javo_video[single_position]">
								<?php
								foreach( $javo_this_selbox_options as $text => $value ){
									printf('<option value="%s"%s>%s</option>'
										, $value
										, ( $javo_video_meta->get('single_position', '') == $value ? ' selected' : '' )
										, $text
									);
								};?>
							</select>
						</div>
					</div>
				</td>
			</tr>

			<tr>
				<th><?php _e('Item Location', 'javo_fr');?></th>
				<td>
					<input class="javo_txt_find_address" type="text"><a class="button javo_btn_find_address"><?php _e('Find', 'javo_fr');?></a>
					<div class="javo-item-map-container"></div>
					<?php
					echo "Latitude : <input name='javo_pt[map][lat]' value='{$javo_latLng->get('lat')}' type='text' class='only-number'>" . ', ';
					echo "Longitude : <input name='javo_pt[map][lng]' value='{$javo_latLng->get('lng')}' type='text' class='only-number'>"; ?>
				</td>
			</tr>

			<tr>
				<th><?php _e('StreetView', 'javo_fr');?></th>
				<td>
					<label>
						<input type="checkbox" name="javo_pt[map][street_visible]" value="1" <?php checked(1 == $javo_latLng->get('street_visible', 0) );?>>
						<?php _e("Use StreetView", 'javo_fr');?>
					</labeL>
					<div class="javo-item-streetview-container<?php echo $javo_latLng->get('street_visible', 0) == 0? ' hidden': '';?>"></div>
					<fieldset class="hidden">
						<?php
						echo "Latitude : <input name='javo_pt[map][street_lat]' value='{$javo_latLng->get('street_lat', 0)}' type='text'>";
						echo "Longitude : <input name='javo_pt[map][street_lng]' value='{$javo_latLng->get('street_lng', 0)}' type='text'>";
						echo "Heading : <input name='javo_pt[map][street_heading]' value='{$javo_latLng->get('street_heading', 0)}' type='text'>";
						echo "pitch: <input name='javo_pt[map][street_pitch]' value='{$javo_latLng->get('street_pitch', 0)}' type='text'>";
						echo "zoom : <input name='javo_pt[map][street_zoom]' value='{$javo_latLng->get('street_zoom', 0)}' type='text'>"; ?>
					</fieldset>
				</td>
			</tr>

			<tr>
				<th><?php _e('Description Images', 'javo_fr');?></th>
				<td>
					<div class="">
						<a href="javascript:" class="button button-primary javo_pt_detail_add"><?php _e('Add Images', 'javo_fr');?></a>
					</div>
					<div class="javo_pt_images">
						<?php
						$images = @unserialize(get_post_meta($post->ID, "detail_images", true));
						if(is_Array($images)){
							foreach($images as $iamge=>$src){
								$url = wp_get_attachment_image_src($src, 'thumbnail');
								printf("
								<div class='javo_pt_field' style='float:left;'>
									<img src='%s'><input name='javo_pt_detail[]' value='%s' type='hidden'>
									<div class='' align='center'>
										<input class='javo_pt_detail_del button' type='button' value='Delete'>
									</div>
								</div>
								", $url[0], $src);
							};
						};?>
					</div>
				</td>
			</tr>
			<tr>
				<th><?php _e('Custom Field Information', 'javo_fr');?></th>
				<td>
					<?php
					global $javo_custom_field, $edit;
					$edit = $post;
					echo $javo_custom_field->form();?>
				</td>
			</tr>
		</table>
		<?php
		ob_end_flush();

	}

	public static function javo_special_item_callback($post)
	{
		$javo_get_this_item_featured = get_post_meta($post->ID, 'javo_this_featured_item', true);
		ob_start();
		?>
		<table class="form-table">
		<tr>
			<input name="javo_item_attribute[featured]" value="nouse" type="hidden">
			<th><?php _e('Featured Item', 'javo_fr');?></th>
			<td><input name="javo_item_attribute[featured]" value="use" type="checkbox"<?php checked($javo_get_this_item_featured == 'use');?>></td>
		</tr>
		</table>
		<?php
		ob_end_flush();
	}
	public static function javo_payment_item_callback( $post )
	{
		$pay_state = get_post_meta( $post->ID, 'javo_paid_state', true );

		ob_start();
		?>
		<p>
			<div><strong><?php _e('Current Payment Status', 'javo_fr');?></strong></div>
			<div>
				<?php
				if( $pay_state != "" )
				{
					echo strtoupper( $pay_state );
				}else{
					_e("Not Paid Yet.", 'javo_fr');
				} ?>
			</div>
		</p>
		<p>
			<div><strong><?php _e('Expired Day', 'javo_fr');?></strong></div>
			<div data-javo-payment-state><?php echo javo_custom_paid_memberships_plugin::check_expire($post->ID, __('Expired', 'javo_fr'), "label label-danger");?></div>
		</p>
		<p>
			<div><strong><?php _e('Add Expired Days', 'javo_fr');?></strong></div>
			<div><input type="text" value="0" data-javo-payment-set-expire-day><?php _e('days', 'javo_fr');?></div>
			<div><button type="button" class="button button-primary" data-javo-payment-submit><?php _e('Extend', 'javo_fr');?></button></div>
		</p>
		<fieldset>
			<input type="hidden" value="<?php _e("Please input numbers", 'javo_fr');?>" data-javo-payment-empty-expire-day>
			<input type="hidden" value="<?php echo admin_url('admin-ajax.php');?>" data-ajax-url>
			<input type="hidden" value="<?php echo (int)$post->ID;?>" data-post-id>
		</fieldset>

		<?php
		ob_end_flush();
	}
	public static function javo_event_metabox_callback($post){
		$javo_meta_query		= new javo_GET_META( $post );
		$javo_get_items_args	= Array(
			'post_type'			=> 'item'
			, 'post_status'		=> 'publish'
			, 'showposts'		=> -1
			, 'author'			=> $post->post_author
		);
		$javo_get_items		= get_posts( $javo_get_items_args );
		ob_start();
		?>
		<table class="form-table">
		<tr>
			<th><?php _e('Target Item', 'javo_fr');?></th>
			<td>
				<select name="javo_event[parent_post_id]">
					<option value=""><?php _e('Not Selected','javo_fr');?></option>
					<?php
					if( !empty($javo_get_items ) ){
						foreach($javo_get_items as $item){
							setup_postdata($item);
							printf('<option value="%s"%s>%s</option>'
								, $item->ID
								, ( $javo_meta_query->_get('parent_post_id', 0) == $item->ID? ' selected':'')
								, $item->post_title
							);
						};	// End Foreach
					};		// End If
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e('Brand Tag', 'javo_fr');?></th>
			<td><input type="text" name="javo_event[brand]" class="large-text" value="<?php echo $javo_meta_query->_get('brand');?>" placeholder="<?php _e('e.g) 40~50%	OFF', 'javo_fr');?>"></td>

		</tr>
		<tr></tr></table>
		<?php
		ob_end_flush();
	}
	public static function javo_partners_callback( $post )
	{
		$javo_meta_query		= new javo_GET_META( $post );
		ob_start();
		?>
		<div id="postcustomstuff">
			<table id="list-table">
				<thead>
					<tr>
						<th class="left"><?php _e('Option Name', 'javo_fr');?></th>
						<th><?php _e('Value', 'javo_fr');?></th>
					</tr>
				</thead>
				<tbody id="the-list" data-wp-lists="list:meta">
					<tr class="alternate">
						<td align="center"><p><?php _e("Link URL", 'javo_fr');?></p></td>
						<td>
							<input type="text" name="javo_partners[website]" value="<?php echo $javo_meta_query->_get('javo_partner_website');?>">
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- /#postcustomstuff -->

		<?php
		ob_end_flush();
	}
	public static function javo_review_metabox_callback($post)
	{
		$javo_meta_query		= new javo_GET_META( $post );
		$javo_get_items_args	= Array(
			'post_type'			=> 'item'
			, 'post_status'		=> 'publish'
			, 'showposts'		=> -1
		);
		$javo_get_items		= get_posts( $javo_get_items_args );
		ob_start();
		?>
		<table class="form-table">
		<tr>
			<th><?php _e('Target Item', 'javo_fr');?></th>
			<td>
				<select name="javo_event[parent_post_id]">
					<option value=""><?php _e('No Select', 'javo_fr');?></option>
					<?php
					if( !empty($javo_get_items ) ){
						foreach($javo_get_items as $item){
							setup_postdata($item);
							printf('<option value="%s"%s>%s</option>'
								, $item->ID
								, ( $javo_meta_query->_get('parent_post_id', 0) == $item->ID? ' selected':'')
								, $item->post_title
							);
						};	// End Foreach
					};		// End If
					?>
				</select>
			</td>
		</tr>
		<tr></tr></table>
		<?php
		ob_end_flush();
	}
	public static function javo_item_author_callback($post)
	{
		$javo_get_all_user = get_users();

		ob_start();
		?>
		<label>
			<input type="radio" name="item_author" value="" checked>
			<?php _e('My Profile', 'javo_fr');?>
		</label>
		<br>
		<label>
			<input type="radio" name="item_author" value="other">
			<?php _e('Other User', 'javo_fr');?>
			<select name="item_author_id" data-autocomplete>
				<?php
				if( !empty( $javo_get_all_user ) )
				{
					foreach( $javo_get_all_user as $user )
					{
						printf('<option value="%s">%s %s (%s)</option>'
							, $user->ID
							, $user->first_name
							, $user->last_name
							, $user->user_login
						);
					}
				}?>
			</select>
		</label>
		<?php
		ob_end_flush();
	}
	public static function javo_post_sidebar_option_box($post)
	{
		// Sidebar LEFT / CENTER / RIGHTER Setting
		$get_javo_opt_sidebar = get_post_meta($post->ID, 'javo_sidebar_type', true);
		ob_start();
		?>
		<h5 class="javo_pmb_title"><?php _e("Sidebar position","javo_fr"); ?></h5>
		<label class="javo_pmb_option sidebar op_s_left<?php echo $get_javo_opt_sidebar == 'left'? ' active':'';?>">
			<span class="ico_img"></span>
			<p><input name="javo_opt_sidebar" value="left" type="radio" <?php checked($get_javo_opt_sidebar == 'left');?>> <?php _e("Left","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option sidebar op_s_right<?php echo $get_javo_opt_sidebar == 'right'? ' active':'';?>">
			<span class="ico_img"></span>
			<p><input name="javo_opt_sidebar" value="right" type="radio" <?php checked($get_javo_opt_sidebar == 'right');?>> <?php _e("Right","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option sidebar op_s_full <?php echo $get_javo_opt_sidebar == 'full' || $get_javo_opt_sidebar == ''? ' active':'';?>">
			<span class="ico_img"></span>
			<p><input name="javo_opt_sidebar" value="full" type="radio" <?php checked($get_javo_opt_sidebar == 'full' || $get_javo_opt_sidebar == '');?>> <?php _e("Fullwidth","javo_fr"); ?></p>
		</label>
		<?php
		ob_end_flush();
	}


	public static function javo_post_header_option_box($post){
		// Header  Fancy / Slider settings
		$get_javo_opt_header = get_post_meta($post->ID, "javo_header_type", true);

		ob_start();
		?>
		<label class="javo_pmb_option header op_h_title_show active">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="default"  checked="checked"> <?php _e("Show page title","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_hide">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="notitle"> <?php _e("Hide page title","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_fancy">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="fancy"> <?php _e("Fancy Header","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_slide">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="slider"> <?php _e("Slide Show","javo_fr"); ?></p>
		</label>
		<label class="javo_pmb_option header op_h_title_map">
			<span class="ico_img"></span>
			<p><input name="javo_opt_header" type="radio" value="map"> <?php _e("Map","javo_fr"); ?></p>
		</label>
		<?php
		ob_end_flush();
	}

	public static function javo_post_header_fancy_option($post)
	{
		// Fancy Option
		$get_javo_opt_fancy = get_post_meta($post->ID, "javo_header_fancy_type", true);
		$javo_fancy = @unserialize(get_post_meta($post->ID, "javo_fancy_options", true));
		ob_start();
		?>

		<div class="">
			<label class="javo_pmb_option fancy op_f_left active">
				<span class="ico_img"></span>
				<p><input name="javo_opt_fancy" type="radio" value="left" checked="checked"> <?php _e("Title left","javo_fr"); ?></p>
			</label>
			<label class="javo_pmb_option fancy op_f_center">
				<span class="ico_img"></span>
				<p><input name="javo_opt_fancy" type="radio" value="center"> <?php _e("Title center","javo_fr"); ?></p>
			</label>
			<label class="javo_pmb_option fancy op_f_right">
				<span class="ico_img"></span>
				<p><input name="javo_opt_fancy" type="radio" value="right"> <?php _e("Title right","javo_fr"); ?></p>
			</label>
		</div>
		<hr>
		<div class="javo_pmb_field">
			<dl>
				<dt><label for="javo_fancy_field_title"><?php _e("Title","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[title]" id="javo_fancy_field_title" type="text" value="<?php echo $javo_fancy['title'];?>"></dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_title_color"><?php _e("Title Color","javo_fr"); ?></label></dt>
				<dd>
					<input name="javo_fancy[title_color]" type="text" value="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['title_color']:"#000000";?>" id="javo_fancy_field_title_color" class="wp_color_picker" data-default-color="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['title_color']:"#000000";?>">
				</dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_subtitle"><?php _e("Subtitle","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[subtitle]" id="javo_fancy_field_subtitle" type="text" value="<?php echo $javo_fancy['subtitle'];?>"></dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_subtitle_color"><?php _e("Subtitle color","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[subtitle_color]" value="<?php echo !empty($javo_fancy['subtitle_color'])?$javo_fancy['subtitle_color']:"#000000";?>" id="javo_fancy_field_subtitle_color" type="text" class="wp_color_picker" data-default-color="<?php echo ($javo_fancy['subtitle_color'] != "")?$javo_fancy['subtitle_color']:"#000000";?>"></dd>
			</dl>
			<hr>
			<dl>
				<dt><label for="javo_fancy_field_bg_color"><?php _e("Background color","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[bg_color]" value="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['bg_color']:"#FFFFFF";?>" id="javo_fancy_field_bg_color" type="text" class="wp_color_picker" data-default-color="<?php echo ($javo_fancy['title_color'] != "")?$javo_fancy['bg_color']:"#FFFFFF";?>"></dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_bg_image"><?php _e("Background Image","javo_fr"); ?></label></dt>
				<dd><input name="javo_fancy[bg_image]" id="javo_fancy_field_bg_image" type="text" value="<?php echo $javo_fancy['bg_image'];?>"><button class="fileupload button button-primary" tar="#javo_fancy_field_bg_image"><?php _e('Upload', 'javo_fr');?></button><input class="fileuploadcancel button" tar="#javo_fancy_field_bg_image" value="Delete" type="button"></dd>
			</dl>
			<dl>
				<dt><?php _e("Background image preview","javo_fr"); ?></dt>
				<dd><img src="<?php echo $javo_fancy['bg_image'];?>" width="200" height="150" border="1" class="javo_bg_img_preview"></dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_bg_image"><?php _e("Repeat Option","javo_fr"); ?></label></dt>
				<dd>
					<select name="javo_fancy[bg_repeat]" id="javo_fancy_field_bg_image">
						<option value="no-repeat"><?php _e("no-repeat","javo_fr"); ?></option>
						<option value="repeat-x"><?php _e("repeat-x","javo_fr"); ?></option>
						<option value="repeat-y"><?php _e("repeat-y","javo_fr"); ?></option>
					</select>
				</dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_position_x"><?php _e("Position X","javo_fr"); ?></label></dt>
				<dd>
					<select name="javo_fancy[bg_position_x]" id="javo_fancy_field_position_x">
						<option value="left"><?php _e("Left","javo_fr"); ?></option>
						<option value="center"><?php _e("Center","javo_fr"); ?></option>
						<option value="right"><?php _e("Right","javo_fr"); ?></option>
					</select>
				</dd>
			</dl>
			<dl>
				<dt><label for="javo_fancy_field_position_y"><?php _e("Position Y","javo_fr"); ?></label></dt>
				<dd>
					<select name="javo_fancy[bg_position_y]" id="javo_fancy_field_position_y">
						<option value="top"><?php _e("Top","javo_fr"); ?></option>
						<option value="center"><?php _e("Center","javo_fr"); ?></option>
						<option value="bottom"><?php _e("Bottom","javo_fr"); ?></option>
					</select>
				</dd>
			</dl>
			<hr>
			<dl>
				<dt><label for="javo_fancy_field_fullscreen"><?php _e("Height(pixel)","javo_fr"); ?> </label></dt
				>
				<dd><input name="javo_fancy[height]" id="javo_fancy_field_fullscreen" value="<?php echo $javo_fancy['height'];?>" type="text"></dd>
			</dl>

		</div>
		<?php
		ob_end_flush();
	}

	public static function javo_post_header_slide_option($post)
	{
		// Slide Option
		$javo_slider = @unserialize(get_post_meta($post->ID, "javo_slider_options", true));
		$get_javo_opt_slider = get_post_meta($post->ID, "javo_slider_type", true);

		ob_start();
		?>
		<div class="">
			<label class="javo_pmb_option slider op_d_rev active">
				<span class="ico_img"></span>
				<p><input name="javo_opt_slider" type="radio" value="rev" checked="checked"> <?php _e("Revolution","javo_fr"); ?></p>
			</label>
		</div>

		<!-- section  -->
		<div class="javo_pmb_tabs slider javo_pmb_field">
			<div class="javo_pmb_tab active" tab="rev">
				<dl>
					<dt><label><?php _e("Choose slider","javo_fr"); ?></label></dt>
					<dd>
						<?php
						$javo_slider = @unserialize(get_post_meta($post->ID, "javo_slider_options", true));
						if(class_exists('RevSlider')){
							$rev = new RevSlider();
							$arrSliders = $rev->getArrSliders();
							echo '<select name="javo_slide[rev_slider]">';
							foreach ( (array) $arrSliders as $revSlider ) {
								$act = ($javo_slider['rev_slider'] == $revSlider->getAlias())? " selected='selected'" : "";
								printf("<option value='%s'%s>%s</option>", $revSlider->getAlias(), $act, $revSlider->getTitle());
							}
							echo '</select>';
						}else{
							printf('<label>%s</label>', __('Please install revolition slider plugin or create slide item.', 'javo_fr'));
						};?>
					</dd>
				</dl>
			</div>
		</div>
		<?php
		ob_end_flush();
	}

	public static function javo_post_meta_box_save($post_id)
	{

		if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE){ return $post_id; };

		/*
		 *		Variables Initialize
		 *
		 *======================================================================================*
		 */
			$javo_query				= new javo_ARRAY($_POST);
			$javo_itemlist_query	= new javo_ARRAY( $javo_query->get('javo_il', Array()) );


		/*
		 *		Page Template Layout Setup
		 *
		 *======================================================================================*
		 */
			// Result Save
			if( $javo_query->get('javo_opt_header') != null ){
				update_post_meta($post_id, "javo_header_type"			, $javo_query->get('javo_opt_header'));
			};
			if( $javo_query->get('javo_opt_fancy') != null ){
				update_post_meta($post_id, "javo_header_fancy_type"		, $javo_query->get('javo_opt_fancy'));
			};
			if( $javo_query->get('javo_opt_sidebar') != null ){
				update_post_meta($post_id, "javo_sidebar_type"			, $javo_query->get('javo_opt_sidebar'));
			};
			if( $javo_itemlist_query->get('type', null) != null){
				update_post_meta($post_id, "javo_item_listing_type"		, $javo_itemlist_query->get('type'));

			};

			// Fancy options
			if( $javo_query->get('javo_fancy', null) != null){
				update_post_meta($post_id, "javo_fancy_options", @serialize( $javo_query->get('javo_fancy', null ) ) );
			};
			if( $javo_query->get('javo_slide', null) != null){
				update_post_meta($post_id, "javo_slider_options", @serialize( $javo_query->get('javo_slide', null ) ) );
			};
			$javo_controller_setup = !empty($_POST['javo_post_control'])? @serialize($_POST['javo_post_control']) : "";
			update_post_meta($post_id, "javo_control_options", $javo_controller_setup);

		/*
		 *		Set Page Template Default Values
		 *
		 *======================================================================================*
		 */
			update_post_meta($post_id, "javo_slider_type"			, $javo_query->get('javo_opt_slider'));
			update_post_meta($post_id, "javo_posts_per_page"		, $javo_query->get('javo_posts_per_page'));
			update_post_meta($post_id, "javo_item_tax"				, @serialize((array)$javo_query->get('javo_item_tax')));
			update_post_meta($post_id, "javo_blog_tax"				, $javo_query->get('javo_blog_tax'));
			update_post_meta($post_id, "javo_item_terms"			, @serialize($javo_query->get('javo_item_terms', null)));
			update_post_meta($post_id, "javo_blog_terms"			, @serialize($javo_query->get('javo_blog_terms', null)));

		/*
		 *		Custom Post Types Meta Save
		 *
		 *======================================================================================*
		 */
		switch( get_post_type($post_id) ){
		case "item":
			$javo_item_query = new javo_ARRAY( $javo_query->get('javo_item_attribute', Array()) );

			if( $javo_item_query->get('featured', null) != null ){
				update_post_meta($post_id, "javo_this_featured_item", $javo_item_query->get('featured', ''));
			};

			// item meta
			if(isset($_POST['javo_pt'])){
				$ppt_meta = $_POST['javo_pt'];
				$javo_pt_query = new javo_array($ppt_meta);
				$ppt_images = !empty($_POST['javo_pt_detail'])? $_POST['javo_pt_detail'] : null;

				$map_area_settings = !empty($ppt_meta['item_map_positon'])? $ppt_meta['item_map_positon'] : Array();
				$map_area_settings = @serialize($map_area_settings);
				$map_type_settings = !empty($ppt_meta['item_map_type'])? $ppt_meta['item_map_type'] : Array();
				$map_type_settings = @serialize($map_type_settings);

				// is Assign ?
				if( $javo_query->get('item_author') == 'other'){
					remove_action('save_post', Array( __CLASS__, 'javo_post_meta_box_save'));
					$post_id = wp_update_post(Array(
						'ID'				=> $post_id
						, 'post_author'		=> $javo_query->get('item_author_id')

					));
					add_action('save_post', Array( __CLASS__, 'javo_post_meta_box_save'));
				};

				// Upload Video
				$javo_video_query = new javo_ARRAY( $javo_query->get('javo_video', Array() ) );
				$javo_video = null;
				if( $javo_video_query->get('portal', NULL) != NULL ){
					switch( $javo_video_query->get('portal') ){
						case 'youtube': $javo_attachment_video = 'http://www.youtube-nocookie.com/embed/'.$javo_video_query->get('video_id', 0); break;
						case 'vimeo': $javo_attachment_video = 'http://player.vimeo.com/video/'.$javo_video_query->get('video_id', 0); break;
						case 'dailymotion': $javo_attachment_video = 'http://www.dailymotion.com/embed/video/'.$javo_video_query->get('video_id', 0); break;
						case 'yahoo': $javo_attachment_video = 'http://d.yimg.com/nl/vyc/site/player.html#vid='.$javo_video_query->get('video_id', 0); break;
						case 'bliptv': $javo_attachment_video = 'http://a.blip.tv/scripts/shoggplayer.html#file=http://blip.tv/rss/flash/'.$javo_video_query->get('video_id', 0); break;
						case 'veoh': $javo_attachment_video = 'http://www.veoh.com/static/swf/veoh/SPL.swf?videoAutoPlay=0&permalinkId='.$javo_video_query->get('video_id', 0); break;
						case 'viddler': $javo_attachment_video = 'http://www.viddler.com/simple/'.$javo_video_query->get('video_id', 0); break;
					};
					$javo_video = Array(
						'portal'			=> $javo_video_query->get('portal', null)
						, 'video_id'		=> $javo_video_query->get('video_id', null)
						, 'url'				=> $javo_attachment_video
						, 'html'			=> (!empty($javo_attachment_video)? sprintf('<iframe width="100%%" height="370" src="%s"></iframe>', $javo_attachment_video) : null)
						, 'single_position'	=> $javo_video_query->get('single_position', null)
					);
				};
				update_post_meta($post_id, "video", $javo_video);
				update_post_meta($post_id, "latlng", @serialize( $javo_pt_query->get('map') ) );
				update_post_meta($post_id, "directory_meta", esc_sql( @serialize( $ppt_meta['meta'] ) ) );
				update_post_meta($post_id, "detail_images", @serialize( $ppt_images));
				update_post_meta($post_id, "item_map_positon", $map_area_settings);
				update_post_meta($post_id, "item_map_type", $map_type_settings);
			};
		break; case 'jv_events':
			$javo_event_query = new javo_ARRAY( $javo_query->get('javo_event', Array()) );
			update_post_meta($post_id, "parent_post_id", $javo_event_query->get('parent_post_id', null));
			update_post_meta($post_id, "brand", $javo_event_query->get('brand', null));
		break; case 'review':
			$javo_event_query = new javo_ARRAY( $javo_query->get('javo_event', Array()) );
			update_post_meta($post_id, "parent_post_id", $javo_event_query->get('parent_post_id', null));
			update_post_meta($post_id, "brand", $javo_event_query->get('brand', null));
		break; case 'jv_partners':
			$javo_partners_query = new javo_ARRAY( $javo_query->get('javo_partners', Array()) );
			update_post_meta($post_id, 'javo_partner_website', $javo_partners_query->get('website', null));
		break;
		}; // End Switch
	}
}
new javo_post_meta_func();