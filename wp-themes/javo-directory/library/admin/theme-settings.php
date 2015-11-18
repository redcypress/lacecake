<?php
class javo_theme_settings{
	var $pages;
	public function __construct(){

		/* Option Set */
		add_action("admin_init", Array( __class__, "javo_theme_settings_reg"));
		/* Add Admin Page and Register */
		add_action("admin_menu", Array($this, "javo_theme_settings_page_reg"));
		/* Need script and style load */
		add_action("admin_enqueue_scripts", Array($this, "javo_theme_admin_enqueue"));
		add_action( 'wp_before_admin_bar_render', array( $this, "javo_ts_admbar_function"));

		add_action("wp_ajax_nopriv_ts_update", Array($this, "save"));
		add_action("wp_ajax_ts_update", Array($this, "save"));

		// Settings page tab menus items defined
		$pages = Array(
			"general"		=> Array(__("General", "javo_fr"), "<i class='fa fa-th-large'></i>")
			, "font"		=> Array(__("Fonts", "javo_fr"), "<i class='fa fa-text-height'></i>")
			, "contact"		=> Array(__("Contact Info", "javo_fr"), "<i class='fa fa-rss-square'></i>")
			, "archive"		=> Array(__("Archive", "javo_fr"), "<i class='fa fa-archive'></i>")
			, "page"		=> Array(__("Item Pages", "javo_fr"), "<i class='fa fa-indent'></i>")
			, "itemfield"	=> Array(__("Item Fields", "javo_fr"), "<i class='fa fa-edit'></i>")
			, "rating"		=> Array(__("Rating", "javo_fr"), "<i class='fa fa-star'></i>")
			, "map"			=> Array(__("Maps", "javo_fr"), "<i class='fa fa-map-marker'></i>")
			, "footer"		=> Array(__("Footer", "javo_fr"), "<i class='fa fa-caret-square-o-down'></i>")
			, "banners"		=> Array(__("Banners", "javo_fr"), "<i class='fa fa-caret-square-o-right'></i>")
			, "notifier"	=> Array(__("Notification", "javo_fr"), "<i class='fa fa-warning'></i>")
			, "custom"		=> Array(__("Custom CSS", "javo_fr"), "<i class='fa fa-floppy-o'></i>")
			, "import"		=> Array(__("Import/Export", "javo_fr"), "<i class='fa fa-files-o'></i>")

		);
		$this->pages = $pages;
	}
	function add_root_menu($name, $id, $href = FALSE){
		global $wp_admin_bar;

		if(!is_super_admin()||!is_admin_bar_showing()) return;
		$wp_admin_bar->add_node(array('id'=> $id, 'meta'=> array(),'title' => $name,'href'=> $href));
	}

	function add_sub_menu($name, $link, $root_menu, $id, $meta = FALSE){
		global $wp_admin_bar;

		if(!is_super_admin()||!is_admin_bar_showing())return;
		$wp_admin_bar->add_menu(array('parent'=> $root_menu, 'id' => $id, 'title'=> $name, 'href'=> $link, 'meta'=> $meta));
	}

	function javo_ts_admbar_function(){
		$this->add_root_menu(__("Theme settings", "javo_fr"), "javo_ts_admbar", admin_url("admin.php?page=javo-directory-settings"));
		$pages = $this->pages;
		foreach($pages as $id => $page)
			$this->add_sub_menu(
				$page[0]
				, admin_url("admin.php?page=javo-directory-settings-".$id)
				, "javo_ts_admbar"
				, "javo_ts_admbar_".$id
			);
	}



	public static function javo_theme_settings_reg(){
		/* Setting option Initialize */
		register_setting("javo_settings", "javo_themes_settings");
		register_setting("javo_settings", "javo_themes_settings_current");
		add_option("javo_themes_settings_css");
	}
	public function javo_theme_admin_enqueue(){
		/* Get jQuery noUISlider Plug-in Style and Script */
		javo_get_asset_style('jquery.nouislider.min.css', 'jquery.nouislider');
		javo_get_asset_style('javo_admin_theme_settings.css', 'javo-themes-settings-css');

		if( isset( $_GET['page'] ) && $_GET['page'] != "" )
		{
			$javo_split_string = @explode('-', $_GET['page']);
			$javo_ts_cur = end( $javo_split_string);

			if(
				"toplevel_page_javo-directory-settings" == get_current_screen()-> id ||
				array_key_exists( $javo_ts_cur, $this->pages )
			){
				javo_get_asset_script('jquery.nouislider.min.js', 'jquery-nouislider-script');
			}
		}		
	}
	public function javo_theme_settings_page_reg(){
		$pages = $this->pages;
		/* Add theme settings page in Admin panel */
		add_menu_page(
			__("Business Directory / Event Theme Settings", "javo_fr")
			, __("Theme Settings", "javo_fr")
			, "manage_options"
			, "javo-directory-settings"
			, Array($this, "settings_page_initialize")
			, ""
			,58
		);

		foreach($pages as $id => $args)
			add_submenu_page(
				"javo-directory-settings"
				, sprintf('%s option', $args[0])
				, $args[0]
				, "manage_options"
				, sprintf('javo-directory-settings-%s', $id)
				, Array($this, "settings_page_initialize")
			);
	}

	/* Get to find word "head" from filename */
	public function _header(){
		// Variable Initialize
		$output = Array();

		// Get Directory string
		$dic = opendir( JAVO_SYS_DIR."/header" );

		// Repeat find file form directory
		while($fn = readdir($dic)):
			$fn_slice = @explode("-", $fn);
			if($fn_slice[0] == "head"){
				$output[$fn] = JAVO_SYS_DIR."/header/".$fn;
			};
		endwhile;

		// Return variable
		return $output;
	}
	// Display and create setting form
	public function settings_page_initialize(){
		$current = explode("-", $_GET['page']);
		$pages = $this->pages;

		// Variable initialize
		$content = "";
		$add_tabs = "";

		// Repeat create tab menus items
		foreach($pages as $page=>$value){
			$active = ($page == $current)? " nav-tab-active" : "";
			$add_tabs .= sprintf("<li class='javo-opts-group-tab-link-li'>
				<a href='javascript:void(0);' class='javo-opts-group-tab-link-a' tar='%s'>
				%s %s</a></li>"
				, $page
				, $value[1]
				, $value[0]);
		} ?>
		<!-- Theme settings options form -->
		<form id="javo_ts_form" onsubmit="return false">
			<input type="hidden" name="action" value="ts_update">
			<?php // Setting options update message
			if(isset($_GET['settings-updated'])){?>
			<!-- Setting options update alert -->
			<div class="updated">
				<!-- Alert Header -->
				<h3 style="display:inline-block;"><?php _e("Javo Directory", "javo_fr");?></h3>
				<!-- Alert Content -->
				<p style="display:inline-block;"><?php _e("Theme settings save successfully.", "javo_fr");?></p>

			</div>
			<?php };?>
			<div class="javo_ts_header_div">
				<div class="javo_ts_header logo">
					<img src="<?php echo JAVO_IMG_DIR;?>/javo-directory-logo-v02.png">
				</div>
				<?php
					/* Get Javo Theme Information */
					$theme_data = wp_get_theme();
					echo "<div class='javo-version-info'><span>By&nbsp;&nbsp;".$theme_data['Author']."</Author></span>";
					echo "<span>&nbsp;&nbsp;V&nbsp;".$theme_data['Version']."</Author></span></div>";
				?>
				<div class="javo_ts_header save_area">
					<a href="http://javothemes.com/forum/" target="_blank" class="button button-default"><?php _e('Support', 'javo_fr');?></a>
					<a href="http://javothemes.com/forum/" target="_blank" class="button button-default"><?php _e('Documentation', 'javo_fr');?></a>
					<input value="Save Settings" class="button button-primary javo_btn_ts_save" type="button">

				</div>

			</div>

			<div id="javo-opts-sidebar">
				<ul id="javo-opts-group-menu">
				<?php echo $add_tabs;?>
				</ul>
			</div>
			<div id="javo-opts-main">
			<?php
			// Tabs contents includes
			$javo_theme_option = @unserialize(get_option("javo_themes_settings"));
			global
				$javo_tso
				, $javo_map_strings
				, $javo_ts_map
				, $javo_ts_archive;
			$javo_map_strings	= new javo_ARRAY( (Array)$javo_tso->get('map_message', Array() ) );
			$javo_ts_map		= new javo_ARRAY( (Array)$javo_tso->get('map', Array() ) );
			$javo_ts_archive	= new javo_ARRAY( (Array)$javo_tso->get('archive', Array() ) );
			ob_start();
			foreach($pages as $index=>$page){
				require_once JAVO_ADM_DIR."/assets/theme-settings"."-".$index.".php";
			};
			$content = ob_get_clean();
			echo $content;?>
			</div>
			<div class="javo-opts-footer">
				<input name="javo_themes_update" value="<?php echo md5(date("y-m-d"));?>" type="hidden">
			</div>
		</form>
		<script type="text/javascript">
		jQuery(function($){
			$('.only_number').each( function(){
				$(this).on('keyup', function(e){
					this.value = this.value.replace(/[^0-9.]/g, '');


				});
			});
		});




		jQuery(document).ready(function($){
			"use strict";
			$(".javo_setting_slider").each(function(){
				$(this).noUiSlider({
					start: $(this).data('val')
					, step:1
					, range:{ min:[7], max:[100] }
					, connect:'lower'
					, serialization:{
						lower:[$.Link({
							target: $($(this).data('tar'))
							, format:{decimals:0}
						})]
					}
				});
			});
			$('.javo_setting_slider.noUi-connect').css('background', '#454545');
		});
		</script>
		<!-- Reset & Import Form -->
		<form method="post" action="options.php" id="javo-ts-admin-form">
			<?php settings_fields("javo_settings");?>
			<input type="hidden" name="javo_themes_settings" id="javo-ts-admin-field">
		</form>
		<?php
			$reset_alert = Array(
				'reset'=> __('Warning : All option results remove and Style initialize. \\n Continue?', 'javo_fr')
				,'import'=> __('Warning : Change option. can`t option restore. \\n Continue?', 'javo_fr')
			);
		?>
		<script type="text/javascript">
			(function($){
				"use strict";
				$("body").on("click", ".javo-btn-ts-reset", function(){
					if(!confirm("<?php echo $reset_alert['reset'];?>")) return false;
					$("#javo-ts-admin-field").val('');

					if( $(this).hasClass('default') ){
						$('#javo-ts-admin-field').val( $('[data-javo-ts-default-value]').val() );
					}; // Set Default ThemeSettings Values.

					$("form#javo-ts-admin-form").submit();
				}).on("click", ".javo-btn-ts-import", function(){
					if( $('.javo-ts-import-field').val() == "") return false;
					if(!confirm("<?php echo $reset_alert['import'];?>")) return false;
					$("#javo-ts-admin-field").val( $('.javo-ts-import-field').val() );
					$("form#javo-ts-admin-form").submit();
				});
			})(jQuery);
		</script>



		<!-- Serialized options transmission from options.php form -->
		<form id="javo_ts_post_options" method="post" action="options.php">
			<!-- Field set -->
			<?php
			settings_fields( 'javo_settings');
			do_settings_sections( 'javo_settings' ); ?>

			<input name="javo_themes_settings" value="" type="hidden">
			<input type="hidden" name="javo_themes_settings_current" value="<?php echo esc_attr( get_option( 'javo_themes_settings_current') ); ?>">
		</form>

		<?php
		$javo_ts_cur_tab = isset( $_GET['page'] ) && $_GET['page'] != "" ? $_GET['page'] : null;
		if( $javo_ts_cur_tab != null )
		{
			$javo_ts_cur_tab = explode('-', $javo_ts_cur_tab);
			$javo_ts_cur_tab = isset( $javo_ts_cur_tab[3] ) && $javo_ts_cur_tab[3] != "" ? $javo_ts_cur_tab[3] : 'general';
		} ?>
		<input type="hidden" name="javo_ts_current_tab" value="<?php echo $javo_ts_cur_tab;?>">
		<input type="hidden" name="javo_ts_after_saved" value="<?php echo isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] != '' ? 'updated':'';?>">

		<script type="text/javascript">
		jQuery(function($){
			var javo_ts_tabs_script = {

				contents			: $('.javo_ts_tab')
				, cur_uri			: $('[name="javo_ts_current_tab"]').val()
				, slice_cookie		: document.cookie.split(";")
				, is_updated		: $('[name="javo_ts_after_saved"]').val() != '' ? true : false

				, init:function()
				{
					this.form	= $( '#javo_ts_post_options' );
					this.el_cur = this.form.find('input[name="javo_themes_settings_current"]');
					$(document).on('click', 'a.javo-opts-group-tab-link-a', this.switchTab);
					if( this.is_updated )
					{
						/*
						for( var i in this.slice_cookie )
						{
							if( this.slice_cookie[i].indexOf( 'javo_ts_current=' ) != -1 ){
								this.cur_uri = this.slice_cookie[i].substring( 'javo_ts_current='.length + 1, this.slice_cookie[i].length );
							}
						} */
						this.cur_uri = this.el_cur.val();
					}
					this.include_tab( this.cur_uri );
				}

				, switchTab: function(e)
				{
					e.preventDefault();

					var _object = javo_ts_tabs_script;
					var _target = $(this).attr('tar');

					_object.include_tab( _target );
				}

				, include_tab: function( tab_name )
				{
					var _object = javo_ts_tabs_script;

					$('.javo-opts-group-tab-link-a').closest('ul').children('li').removeClass('active');
					$('.javo-opts-group-tab-link-a[tar="' + tab_name + '"]').closest('li').addClass('active');

					//document.cookie = 'javo_ts_current=' + tab_name;

					this.el_cur.val( tab_name );

					_object.contents
						.addClass('hidden')
						.closest('#javo-opts-main')
						.find(".javo_ts_tab[tar='" + tab_name + "']")
						.removeClass('hidden');
				}

			}
			javo_ts_tabs_script.init();
		});
		</script>




		<script type="text/javascript">
			(function($){
				"use strict";
				// Tab menus items responsive

				// Setup options to serialized and transmission from options.php
				$("body").on("click", ".javo_btn_ts_save", function(){
					var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
					var f = $("form#javo_ts_form").serialize();
					var $form = $("#javo_ts_post_options");
					var option = { url:ajaxurl, type:"post", data:f, dataType:"json", error:function(e){ alert("Error: " + e.state());}};
					option.success = function(d){
						;$form.find("input[name='javo_themes_settings']")
							.val(d.result)
						;$form
							.submit();
					};
					$.ajax(option);
				});
				// Wordpress media upload button command.
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
						$("input[type='text'][tar='" + t + "']").val(attachment.url);
						$("img[tar='" + t + "']").prop("src", attachment.url);
					});
					file_frame.open();
					// Upload field reset button
				}).on("click", ".fileuploadcancel", function(){
					var t = $(this).attr("tar");
					$("input[type='text'][tar='" + t + "']").val("");
					$("img[tar='" + t + "']").prop("src", "");
				});
			})(jQuery);
		</script>


<?php }
	/* Coverter Serialized functions */
	public function save(){
		$javo_ts = $_POST["javo_ts"];
		update_option("javo_themes_settings_css", $this->create_css($javo_ts));
		$javo_ts = @serialize($javo_ts);
		$args = Array( "result"=> $javo_ts );
		echo json_encode($args);
		exit(0);
	}
	public function create_css($args=NULL){
		global $javo_tso;
		$wpdir = wp_upload_dir();
		$wpdir = $wpdir['path'];
		$fn = $wpdir."/style".date("-Y-m-d-h-i-s").".css";
		$fh = @fopen($fn, "w");
		$args = new javo_array($args);
ob_start(); ?>
/* Themes settings css */
<?php
printf("
	body{
		font-size:%dpx;
		line-height:%dpx;
		font-family:%s;
	}\n"
	, $args->get('basic_normal_size')
	, $args->get('basic_line_height')
	, $args->get('basic_font')
);
/** Color accent **/
printf(".accent{ background-color:%s;}\n"
	, $args->get('accent_color')." !important"
);
printf(".accent:hover{ background-color:%s; }\n"
	, $args->get('accent_color')." !important"
);
/* Panel Color setting*/
printf(".javo_somw_panel, .javo_somw_list_inner, .javo_somw_panel form button{ background-color:%s; }\n"
	, $args->get('panel_bg_color')." !important"
);
printf(".javo_somw_panel::-webkit-scrollbar-button:start:decrement, ::-webkit-scrollbar-button:end:increment, .javo_somw_panel::-webkit-scrollbar-track{ background:%s; }\n"
	, $args->get('panel_bg_color')." !important"
);
printf(".javo_somw_panel .newrow button, .javo_somw_panel form select, .javo_somw_panel form .newrow input, .javo_somw_panel .newrow .javo_somw_onoff{ background-color:%s; }\n"
	, $args->get('panel_bt_color')." !important"
);
printf(".javo_somw_panel .newrow button.active{ background-color:%s; border:1px %s solid; }\n"
	, $args->get('panel_active_bt_color')." !important",$args->get('panel_active_bt_color')
);
printf(".gmap .javo_somw_opener_type1{ background:%s; }\n"
	, $args->get('panel_hide_bt_color')." !important"
);
printf(".javo_somw_panel form button, .javo_somw_panel form select, .javo_somw_panel form select, .javo_somw_panel form .newrow input, .gmap .javo_somw_opener_type1{ color:%s; }\n"
	, $args->get('panel_bt_text_color')." !important"
);
printf(".javo_somw_panel form button.active,  .gmap .javo_somw_opener_type1{ color:%s; }\n"
	, $args->get('panel_bt_active_text_color')." !important"
);
printf(".javo_somw_panel .newrow .title, .javo_somw_panel .newrow .javo_somw_list_title, .javo_somw_list a{ color:%s; }\n"
	, $args->get('panel_title_color')." !important"
);
printf(".javo_somw_panel .javo_somw_list_inner .meta-wrap .javo_somw_list{ color:%s; }\n"
	, $args->get('panel_text_color')." !important"
);
/*Map Size*/
printf(".gmap, .gmap .map_area{height:%spx !important;}\n",$args->get('map_size'));
/** Header tag group **/
printf("h1{font:%spx/%spx '%s';}\n", $args->get('h1_normal_size'), $args->get('h1_line_height'), $args->get('h1_font'));
printf("h2{font:%spx/%spx '%s';}\n", $args->get('h2_normal_size'), $args->get('h2_line_height'), $args->get('h2_font'));
printf("h3{font:%spx/%spx '%s';}\n", $args->get('h3_normal_size'), $args->get('h3_line_height'), $args->get('h3_font'));
printf("h4{font:%spx/%spx '%s';}\n", $args->get('h4_normal_size'), $args->get('h4_line_height'), $args->get('h4_font'));
printf("h5{font:%spx/%spx '%s';}\n", $args->get('h5_normal_size'), $args->get('h5_line_height'), $args->get('h5_font'));
printf("h6{font:%spx/%spx '%s';}\n", $args->get('h6_normal_size'), $args->get('h6_line_height'), $args->get('h6_font'));

/** header **/
printf(".navbar {background:%s;}\n", $args->get('header_bg_color')); // navi background color
printf(".navbar {height: %spx;}\n", $args->get('header_background_height'));  // height
printf(".nav>li>a {font:%spx/%spx '%s';}\n", $args->get('header_font_size'), $args->get('header_line_height'), $args->get('navi_font_family'));  // font
printf(".navbar-nav>li>a {line-height: %spx; color:%s;}\n", $args->get('header_line_height'), $args->get('header_layout_font_color'));  // height

printf(".navbar-nav>.active>a, .navbar-nav>.active>a:hover, .navbar-nav>.active>a:focus {color:%s;background:%s;}\n", $args->get('header_font_color_current'), $args->get('header_bg_color_current')); // top bar background color

printf(".navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:hover, .navbar-default .navbar-nav>.open>a:focus {color:%s;background:%s; border-bottom:4px %s solid;}\n", $args->get('header_font_color_current'), $args->get('header_bg_color_current'), $args->get('header_bottom_color_current')); // top bar background color

/** dropdown css **/

printf(".dropdown-menu {background:%s;}\n", $args->get('header_submenu_bg_color'));  // background
printf(".dropdown-menu > li > a{font:%spx/%spx '%s'; color:%s;}\n", $args->get('header_sub_font_size'), $args->get('header_sub_font_line_height'), $args->get('navi_font_family'), $args->get('header_submenu_font_color'));
if($args->get('panel_display') == 'hide'){
	printf("
		.javo_somw_panel{ display:none !important; }
		.javo_somw_opener_type1 {display:none;}
		.map_area {margin-left:0px !important;}
	");
};?>
<?php
		$content = ob_get_clean();
		@fwrite($fh, $content);
		@fclose($fh);
		return $fn;
	}
}
new javo_theme_settings();