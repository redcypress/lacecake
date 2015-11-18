<?php
class javo_item_time_line{
	public function __construct(){
		add_shortcode('javo_item_time_line', Array($this, 'javo_item_time_line_callback'));
		add_action('wp_ajax_javo_time_line', Array($this, 'time_line_ajax'));
		add_action('wp_ajax_nopriv_javo_time_line', Array($this, 'time_line_ajax'));
	}

	public function javo_item_time_line_callback($atts, $content=''){
		global $javo_tso;
		extract(shortcode_atts(
			Array(
				'title'=> __('Javo Timeline Posts', 'javo_fr')
				, 'items'=> 4
			), $atts)
		);
		$items = (int)$items <= 0? 1: $items;
		$javo_alert = Array(
			'eof'=> __('No Found Posts', 'javo_fr')
		);

		ob_start();?>
			<div class='row'>
				<div class='page-header'>
					<h2 id='jv_timeline'><?php echo $title;?></h2>
				</div>
				<ul class="jv_timeline"></ul>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<input type="button" class="btn btn-primary javo-timeline-more" value=<?php _e("More","javo_fr");?>>
				</div>
			</div>
			<script type="text/javascript">
			jQuery(document).ready(function($){
				"use strict";
				var param = { item:<?php echo (int)$items;?>, get:0 };
				$("body").on("click", ".javo-timeline-more", function(){
					var $this = $(this);
					var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
					var options = {};
					options.url			= ajaxurl;
					options.type		= 'post';
					options.data		= { count: param.item, offset: param.get, action:'javo_time_line' };
					options.dataType	= 'json';
					options.error		= function(e){  };
					options.complete	= function(){ $(window).trigger('resize');  };
					options.success		= function(d){
						if(  d.content !='' ){
							$('.jv_timeline').append( d.content );
							param.get += param.item;
						}else{
							javo_show_eol();
						};
						$this.button('reset');
					};
					$.ajax(options);
					$this.button('loading');
				});
				function javo_show_eol(){
					if( typeof( $('.javo-alert-eol')[0] ) != 'undefined' ) return;
					$('<div class="alert alert-warning javo-alert-eol text-center"><?php echo $javo_alert["eof"];?></div>').appendTo('.jv_timeline');
					var nTimeId = setInterval(function(){
						$('.javo-alert-eol').hide(500, function(){ $(this).remove(); });
						clearInterval(nTimeId);
					}, 850);


				};
				$('.javo-timeline-more').trigger('click');
			});
			</script>
		<?php
		$content = ob_get_clean();
		return $content;
	}

	public function time_line_ajax(){
		$javo_query = new javo_array($_POST);
		$javo_ajax_timeline_args = Array(
			'post_type'=> 'post'
			, 'post_status'=> 'publish'
			, 'offset'=> (int)$javo_query->get('offset')
			, 'posts_per_page'=> (int)$javo_query->get('count')
		);
		$javo_item_timeline = new wp_query($javo_ajax_timeline_args);
		ob_start();

		if( $javo_item_timeline->have_posts() ){
			$i=0;
			while( $javo_item_timeline->have_posts() ){
				$i++;
				$javo_item_timeline->the_post();
				switch( $i % 5){
					case 0: $javo_badge = "warning"; break;
					case 1: $javo_badge = "danger"; break;
					case 2: $javo_badge = "primary"; break;
					case 3: $javo_badge = "info"; break;
					case 4: $javo_badge = "success"; break;
					default: $javo_badge = "";
				};?>

				<li<?php echo $i % 2 == 0? ' class="jv_timeline-inverted"':'';?>>
					<div class="jv_timeline-badge <?php echo $javo_badge;?>"><i class="glyphicon glyphicon-check"></i></div>
					<div class="jv_timeline-panel">
						<div class="jv_timeline-heading">
							<h4 class="jv_timeline-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
							<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo get_the_date();?></small></p>
						</div>
						<div class="jv_timeline-body">
							<div class="row">
								<a href="<?php the_permalink();?>">
									<div class="col-md-6">
										<?php
										if ( has_post_thumbnail() ) {
											the_post_thumbnail('medium');
										};?>
									</div>
									<div class="col-md-6">
										<?php echo javo_str_cut(get_the_content(), 150);?>
									</div>
								</a>
							</div><!-- Close Row -->
						</div><!-- Timeline Body-->
					</div>
				</li>
			<?php
			}; // End While
		}; // End If
		$javo_timeline_content = ob_get_clean();
		wp_reset_query();
		echo json_encode(Array(
			'result'=> 'hi'
			, 'content'=> $javo_timeline_content
		));
		exit;
	}
}
new javo_item_time_line();