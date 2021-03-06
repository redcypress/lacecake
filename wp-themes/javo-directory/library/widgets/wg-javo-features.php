<?php
class javo_featured_widget extends WP_Widget {
	public function __construct(){

		add_action( 'widgets_init', Array( 'javo_featured_widget', 'javo_featured_widget_callback'));

		parent::__construct(
			'javo_featured_widget', // Base ID
			__('[JAVO] Featured Widget', JAVO_FR), // Name
			array( 'description' => __( 'Javo features item widget', JAVO_FR ), ) // Args
		);

	}
	static function javo_featured_widget_callback(){
		register_widget( 'javo_featured_widget' );
	}

	public function widget( $args, $instance ) {
		global $javo_tso;

		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		};
		$javo_wg_featured_args	= Array(
			'post_type'					=> 'item'
			, 'post_status'				=> 'publish'
			, 'posts_per_page'			=> 6
			, 'orderby' => ''
			, 'meta_query'				=> Array(
				Array(
					'key'			=> 'javo_this_featured_item'
					, 'compare'		=> '='
					, 'value'		=> 'use'
				)
			)
		);
		if( isset( $instance['random'] ) && $instance['random'] == 1 ) $javo_wg_featured_args['orderby']='rand';
		$javo_wg_featured = new WP_Query($javo_wg_featured_args);?>
		<div class="widget_posts_wrap">
			<ul class="latest-posts items list-unstyled">
				<?php
				if( $javo_wg_featured->have_posts() ){
					$i = 1;
					while( $javo_wg_featured->have_posts() ){
						$javo_wg_featured->the_post();
						?>
						<li class="col-xs-4 col-sm-4 col-md-4">
							<span class="thumb">
								<a href="<?php the_permalink();?>">
									<div class="img-wrap-shadow">
										<?php
										if( has_post_thumbnail() ){
											the_post_thumbnail('javo-tiny');
										}else{
											printf('<img src="%s" class="wp-post-image" style="width:80px; height:80px;">', $javo_tso->get('no_image', JAVO_IMG_DIR.'/no-image.png'));
										};?>
									</div>
								</a>
							</span>
						</li><!-- /.col-md-4 -->
						<?php
					}
				}else{
					_e('Not Found Features Items.', JAVO_FR);
				};?>

			</ul><!-- /.row -->
		</div><!-- /.widget_posts_wrap -->

		<?php
		wp_reset_query();
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Featured Item', 'javo_fr' );
		}
		$random=false;
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'javo_fr' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<input class="widefat" id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" type="checkbox" value="1" <?php checked($instance['random'] == '1');?>>
		<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Random Ordering','javo_fr' ); ?></label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['random'] = ( ! empty( $new_instance['random'] ) ) ? strip_tags( $new_instance['random'] ) : '';

		return $instance;
	}

}

new javo_featured_widget();