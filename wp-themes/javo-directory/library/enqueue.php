<?php
class javo_enqueue_func
{
	function __construct()
	{
		add_action('wp_head', Array( __class__, 'javo_google_font_apply_callback'));
		add_action('wp_enqueue_scripts', Array( __class__, 'wp_enqueue_scripts_callback'), 9);
		add_action('admin_enqueue_scripts', Array( __class__, 'admin_enqueue_scripts_callback'), 9);
	}

	// WP_ENQUEUE_SCRIPTS
	static function wp_enqueue_scripts_callback()
	{
		global $javo_tso;

		$javo_general_styles = Array();

		$javo_single_assets_styles = Array(
			'wide-gallery-component.css'					=> 'wide-gallery-component'
			, 'wide-gallery-base.css'						=> 'wide-gallery-base'
			, 'single-reviews-style.css'					=> 'single-reviews-style'
		);

		$javo_assets_header_scripts = Array(
			'gmap3.js'										=> 'gmap3'
			, 'oms.min.js'									=> 'oms-same-position-script'
			, 'common.js'									=> 'Javo-common-script'
			, 'chosen.jquery.min.js'						=> 'jQuery-chosen-autocomplete'
			, 'jquery.javo.msg.js'							=> 'javoThemes-Message-Plugin'
			, 'jquery.parallax.min.js'						=> 'jQuery-Parallax'
			, 'jquery.favorite.js'							=> 'jQuery-javo-Favorites'
			, 'jquery_javo_search.js'						=> 'jQuery-javo-search'
			, 'jquery.flexslider-min.js'					=> 'jQuery-flex-Slider'
			, 'google.map.infobubble.js'					=> 'Google-Map-Info-Bubble'
			, 'pace.min.js'									=> 'Pace-Script'
			, 'single-reviews-modernizr.custom.79639.js'	=> 'single-reviews-modernizr.custom'
			, 'jquery.magnific-popup.js'					=> 'jquery.magnific-popup'
		);

		$javo_assets_scripts = Array(
			'bootstrap.min.js'								=> 'bootstrap'
			, 'jquery.easing.min.js'						=> 'jQuery-Easing'
			, 'jquery.form.js'								=> 'jQuery-Ajax-form'
			, 'sns-link.js'									=> 'sns-link'
			, 'jquery.raty.min.js'							=> 'jQuery-Rating'
			, 'jquery.spectrum.js'							=> 'jQuery-Spectrum'
			, 'jquery.parallax.min.js'						=> 'jQuery-parallax'
			, 'jquery.javo.mail.js'							=> 'jQuery-javo-Emailer'
			, 'common.js'									=> 'javo-assets-common-script'
			, 'bootstrap.hover.dropmenu.min.js'				=> 'bootstrap-hover-dropdown'
			, '../bootstrap/bootstrap-select.js'			=> 'bootstrap-select-script'
			, 'javo-footer.js'								=> 'javo-Footer-script'
			, 'bootstrap-markdown.js'						=> 'bootstrap-markdown'
			, 'bootstrap-markdown.fr.js'					=> 'bootstrap-markdown-fr'
			, 'jquery.quicksand.js'							=> 'jQuery-QuickSnad'
			, 'jquery.nouislider.min.js'					=> 'jQuery-nouiSlider'
			, 'okvideo.min.js'								=> 'okVideo-Plugin'
			, 'jquery.slight-submenu.min.js'				=> 'slight-submenu.min-Plugin'
		);

		$javo_single_assets_scripts = Array(
			'single-reviews-slider.js'						=> 'single-reviews-slider'
			, 'common-single-item.js'						=> 'common-single-item'

		);
		// add item page - tag
		if(JAVO_ADDITEM_SLUG == get_query_var('sub_page')){
			javo_get_asset_script('bootstrap-tagsinput.min.js', 'bootstrap-tagsinput.min');
		}
		// Theme Setting > General
		if( $javo_tso->get('smoothscroll', '') == '' ){
			$javo_assets_scripts['smoothscroll.js']	=  'smoothscroll';
		};

		$javo_google_api_uri = '//maps.googleapis.com/maps/api/js?sensor=false&libraries=places&v=3.exp';
		if( $javo_tso->get('google_api_key', null ) != null )
		{
			$javo_google_api_uri .= '&key='.$javo_tso->get('google_api_key');
		}
		wp_enqueue_script("google_map_API", $javo_google_api_uri, null, "0.0.1", false);
		/** Load Styles **/
		foreach( $javo_general_styles as $src => $id){ javo_get_style($src, $id); };
		if( is_singular('item') ){
			foreach( $javo_single_assets_styles as $src => $id){ javo_get_asset_style($src, $id); };
		}

		/** Load Scripts **/
		foreach( $javo_assets_header_scripts as $src => $id){ javo_get_asset_script($src, $id, null, false); }
		foreach( $javo_assets_scripts as $src => $id){ javo_get_asset_script($src, $id); }
		if( is_single() ){
			foreach( $javo_single_assets_scripts as $src => $id){ javo_get_asset_script($src, $id, null, false); }
		}

		// Styles css
		$theme_data = wp_get_theme();
		wp_enqueue_style( 'javoThemes-directory', get_stylesheet_uri(), array(), $theme_data['Version'] );

		// Custom css - Javo themes option
		$javo_upload_path	= wp_upload_dir();
		$javo_css_path		= get_option("javo_themes_settings_css");
		$javo_css_uri		= $javo_upload_path['url']."/".basename( get_option("javo_themes_settings_css") );

		if( file_exists( $javo_css_path ) )
		{
			wp_enqueue_style( "javo_drt_custom_style", $javo_css_uri);
		}
	}

	// ADMIN_ENQUEUE_SCRIPTS
	static function admin_enqueue_scripts_callback()
	{
		$javo_admin_css = Array(
			'javo_admin_theme_settings-extend.css'			=> 'javo-ts-extends'
			, 'javo_admin_post_meta.css'					=> 'javo-admin-post-meta-css'
		);
		$javo_admin_jss = Array();

		foreach( $javo_admin_css as $src => $id){ javo_get_asset_style($src, $id); };
		foreach( $javo_admin_jss as $src => $id){ javo_get_asset_script($src, $id); }


		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_style( "jQuery-chosen-autocomplete-style", JAVO_THEME_DIR."/assets/css/chosen.min.css", null, "0.1" );
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'my-script-handle', JAVO_THEME_DIR.'/assets/js/admin-color-picker.js', array( 'wp-color-picker' ), false, true );
		wp_enqueue_script( 'jQuery-chosen-autocomplete', JAVO_THEME_DIR.'/assets/js/chosen.jquery.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'thickbox');
		wp_enqueue_script( 'google_map_API', '//maps.google.com/maps/api/js?sensor=false&amp;language=en', null, '0.0.1', false);
		javo_get_script( 'gmap3.js', 'jQuery-gmap3', '5.1.1', false);
	}
	// WP_HEAD
	static function javo_google_font_apply_callback()
	{
		global $javo_tso;

		$protocol = is_ssl() ? 'https' : 'http';
		$javo_load_fonts = Array("basic_font", "h1_font", "h2_font", "h3_font", "h4_font", "h5_font", "h6_font");
		foreach($javo_load_fonts as $index=>$font){
			if( $javo_tso->get($font) == 'Nanum Gothic' ){
				wp_enqueue_style( "javo-$font-fonts", "$protocol://fonts.googleapis.com/earlyaccess/nanumgothic.css");
			}elseif($javo_tso->get($font) != ""){
				wp_enqueue_style( "javo-$font-fonts", "$protocol://fonts.googleapis.com/css?family=".$javo_tso->get($font));
			}
		} ?>
		<style type="text/css">
			<?php
			printf("*{ font-family:'%s', sans-seif; }", $javo_tso->get('basic_font', null));
			printf("h1{ font-family:'%s', sans-seif !important; }", $javo_tso->get('h1_font', null));
			printf("h2{ font-family:'%s', sans-seif !important; }", $javo_tso->get('h2_font', null));
			printf("h3{ font-family:'%s', sans-seif !important; }", $javo_tso->get('h3_font', null));
			printf("h4{ font-family:'%s', sans-seif !important; }", $javo_tso->get('h4_font', null));
			printf("h5{ font-family:'%s', sans-seif !important; }", $javo_tso->get('h5_font', null));
			printf("h6{ font-family:'%s', sans-seif !important; }", $javo_tso->get('h6_font', null));
			?>
		</style>
		<?php
	}
}
new javo_enqueue_func();