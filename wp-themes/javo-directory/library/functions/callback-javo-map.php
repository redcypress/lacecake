<?php
class javo_wide_map_func{

	public function __construct()
	{
		add_action('wp_ajax_nopriv_javo_map', Array( __class__, 'javo_map_callback' ));
		add_action('wp_ajax_javo_map', Array( __class__, 'javo_map_callback' ));
	}
	static function javo_map_callback()
	{

		// Get Theme Settings
		global
			$javo_tso
			, $javo_tso_map
			, $javo_favorite;

		// Get Parameter of Queries
		$javo_query = new javo_array($_POST);

		// Setup Agrumnets
		$javo_this_posts_args = Array(
			'post_status'=> 'publish'
			, 'post_type'=> $javo_query->get('post_type', 'post')
			, 'posts_per_page'=> $javo_query->get('ppp', 10)
			, 'paged'=> (int) $javo_query->get('current', 1)
			, 'order'=> $javo_query->get('order', 'DESC')
		);

		// WPML
		if( $javo_query->get( 'lang', null ) != null ){
			global $sitepress;
			if( !empty( $sitepress ) ){
				$sitepress->switch_lang($javo_query->get( 'lang'), true);
			};
		};

		// Apply Filter
		if( $javo_query->get('filter', null) != null)
		{
			if( is_Array( $javo_query->get('filter') ) )
			{
				foreach( $javo_query->get('filter') as $taxonomy => $terms )
				{

					if( !empty( $terms) )
					{
						$javo_this_posts_args['tax_query']['relation'] = 'AND';
						$javo_this_posts_args['tax_query'][] = Array(
							'taxonomy'	=> $taxonomy
							, 'field'	=> 'term_id'
							, 'terms'	=> $terms
						);
					}
				}
			}
		}

		// Set Keyword
		if( $javo_query->get('keyword', null) != null )
		{
			$javo_this_posts_args['s'] = $javo_query->get('keyword');
		}

		switch( $javo_query->get('panel', 'list') ){
			case 'featured':
				$javo_this_posts_args['meta_query']['relation'] = 'AND';
				$javo_this_posts_args['meta_query'][]			= Array(
					'key'		=> 'javo_this_featured_item'
					, 'compare'	=> '='
					, 'value'	=> 'use'
				);
			break;
			case 'favorite':
				$javo_this_posts_args							= Array( 'post_type'=> $javo_query->get('post_type', 'post')	);
				$javo_this_user_favorite						= (Array)get_user_meta( get_current_user_id(), 'favorites', true);
				$javo_this_user_favorite_posts					= Array('0');
				if( !empty($javo_this_user_favorite) ){
					foreach( $javo_this_user_favorite as $favorite ){
						if(!empty($favorite['post_id'] ) ){
							$javo_this_user_favorite_posts[]	= $favorite['post_id'];
						};
					}; // End foreach
				}; // End if
				$javo_this_posts_args['post__in']				= (Array)$javo_this_user_favorite_posts;
			break;
			case 'list':
			default:
		};

		// Set Read More
		if( $javo_query->get('offset', null) != null )
		{
			$javo_this_posts_args['offset'] = $javo_query->get('offset');
		}

		// Return Variables
		$javo_this_return = Array();

		// Queries Loop
		$javo_this_posts = new WP_Query($javo_this_posts_args);
		if( $javo_this_posts->have_posts() )
		{
			while( $javo_this_posts->have_posts() )
			{
				$javo_this_posts->the_post();

				$javo_meta_query	= new javo_get_meta( get_the_ID() );

				$javo_rating		= new javo_RATING( get_the_ID() );

				$javo_latlng		= @unserialize( $javo_meta_query->_get('latlng', Array() ) );
				$javo_latlng		= new javo_ARRAY( $javo_latlng );

				$javo_set_icon		= '';
				$javo_marker_term_id = wp_get_post_terms( get_the_ID() , 'item_category');
				if( !empty( $javo_marker_term_id ) ){
					$javo_set_icon = get_option('javo_item_category_'.$javo_marker_term_id[0]->term_id.'_marker', '');
					if( $javo_set_icon == ''){
						$javo_set_icon = $javo_tso->get('map_marker', '');
					};
				};

				$javo_this_thumbnail			= get_the_post_thumbnail( get_the_ID(), Array(50, 50) );
				$javo_this_thumbnail			= $javo_this_thumbnail != '' ? $javo_this_thumbnail : sprintf('<img src="%s" class="img-responsive wp-post-image" style="width:50px; height:50px;">', $javo_tso->get('no_image', JAVO_IMG_DIR.'/no-image.png'));

				$javo_this_thumbnail_large		= get_the_post_thumbnail( get_the_ID(), 'javo-box-v', Array('class'=> 'group list-group-image item-thumbs'));
				$javo_this_thumbnail_large		= $javo_this_thumbnail_large != '' ? $javo_this_thumbnail_large : sprintf('<img src="%s" style="width:100%%; height:219px;">', $javo_tso->get('no_image', JAVO_IMG_DIR.'/no-image.png'));

				$javo_this_author_avatar_id = get_the_author_meta('avatar');
				$javo_this_author_avatar		= wp_get_attachment_image($javo_this_author_avatar_id, 'javo-tiny', true, Array('class'=> 'img-circle', 'style'=>'width:50px; height:50px;'));



				$javo_this_return[ get_the_ID() ] = Array(
					'post_title'		=> get_the_title()
					, 'contents'		=> javo_str_cut( strip_shortcodes( get_the_excerpt() ), 300 )
					, 'thumbnail'		=> $javo_this_thumbnail
					, 'thumbnail_large'	=> $javo_this_thumbnail_large
					, 'avatar'			=> $javo_this_author_avatar
					, 'author_name'		=> get_the_author_meta('display_name')
					, 'permalink'		=> get_permalink()
					, 'category'		=> $javo_meta_query->cat('item_category', __('No Category', 'javo_fr'))
					, 'location'		=> $javo_meta_query->cat('item_location', __('No Location', 'javo_fr'))
					, 'favorite'		=> $javo_favorite->on( get_the_ID(), ' saved')
					, 'lat'				=> $javo_latlng->get('lat')
					, 'lng'				=> $javo_latlng->get('lng')
					, 'icon'			=> $javo_set_icon
					, 'phone'			=> $javo_meta_query->get('phone')
					, 'mobile'			=> $javo_meta_query->get('mobile')
					, 'website'			=> $javo_meta_query->get('website')
					, 'email'			=> $javo_meta_query->get('email')
					, 'address'			=> $javo_meta_query->get('address')
					, 'rating'			=> $javo_rating->parent_rating_average
					, 'rating_count'	=> $javo_meta_query->get_child_count('ratings')
					, 'review_count'	=> $javo_meta_query->get_child_count('review')

				);
			}
		}
		wp_reset_query();

		$javo_this_pagination = '';

		if( $javo_query->get('pagination') == 'read_more' )
		{
			$javo_this_pagination = sprintf('<a class="btn btn-primary btn-block javo-wide-map-read-more">%s</a>', __('Read More', 'javo_fr'));
		}
		else
		{
			$javo_this_pagination = sprintf('<div class="javo_pagination">%s</div>'
				, paginate_links( array(
					'base'				=> "%_%",
					'format'			=> '?%#%',
					'current'			=> (int) $javo_query->get('current', 1),
					'total'				=> $javo_this_posts->max_num_pages
				))
			);


		}

		echo json_encode(Array(
			'state'						=> 'success'
			, 'result'					=> $javo_this_return
			, 'pagination'				=> $javo_this_pagination
		));
		exit;

	} // End self::javo_map_callback

}
new javo_wide_map_func();