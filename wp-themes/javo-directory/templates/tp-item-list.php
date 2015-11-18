<?php
/*
* Template Name: item List
*/

global $javo_tso;
$javo_query			= new javo_Array( $_POST );
$javo_list_query	= new javo_Array( $javo_query->get('filter', Array()));

get_header();?>
<div class="javo-page-variable-area">
	<?php
	$javo_item_filter_taxonomies = @unserialize(get_post_meta( get_the_ID() , "javo_item_tax", true));
	$javo_item_filter_terms = @unserialize(get_post_meta( get_the_ID() , "javo_item_terms", true));
	$javo_item_defult_type = get_post_meta( get_the_ID() , "javo_item_listing_type", true);
	if(!empty($javo_item_filter_taxonomies)){
		foreach($javo_item_filter_taxonomies as $index=> $tax){
			if(!empty($javo_item_filter_terms[$index]) && !empty($tax) ){
				printf("<input type='hidden' class='javo_filter' data-tax='%s' data-term='%s'>",
						$tax, $javo_item_filter_terms[$index]);
			};
		}
	};?>
	<input type="hidden" value="<?php echo !empty($javo_item_defult_type)? $javo_item_defult_type : 2;?>" data-javo-item-listing-default-type>
	<input type="hidden" javo-cluster-multiple value="<?php _e("This place contains multiple places. please select one.", 'javo_fr');?>">
</div>
<div class="item-list-page-wrap" id="main-content">
	<div class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="nav-col">
			<form class="navbar-form" role="search">
				<div class="container">
					<ul class="nav navbar-nav navbar-left">
						<li>
							<div class="input-group input-group-md">
								<input type="text" class="form-control javo-listing-search-field" placeholder="<?php _e('Search', 'javo_fr');?>">
								<div class="input-group-btn">
									<button class="btn btn-default javo-listing-submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
						</li>
						<li>
							<!-- Category Filter -->
							<div class="btn-group">
								<select name="filter[item_category]">
									<option value=""><?php _e('Category', 'javo_fr');?></option>
									<?php echo apply_filters('javo_get_selbox_child_term_lists', 'item_category', null, 'select', $javo_list_query->get('category', null), 0, 0, "-");?>
								</select>
							</div><!-- /.btn-group -->

							<!-- Location Filter -->
							<div class="btn-group">
								<select name="filter[item_location]">
									<option value=""><?php _e('Location', 'javo_fr');?></option>
									<?php echo apply_filters('javo_get_selbox_child_term_lists', 'item_location', null, 'select', $javo_list_query->get('location', null), 0, 0, "-");?>
								</select>
							</div><!-- /.btn-group -->

							<?php if( $javo_tso->get('item_listing_field_views', null) != 'hide' ){ ?>
								<!-- Display Post -->
								<div class="btn-group">
									<div class="sel-box">
										<div class="sel-container">
											<i class="sel-arraow"></i>
											<input type="text" readonly value="<?php _e("Views","javo_fr"); ?>" class="form-control input-md">
											<input type="hidden">
										</div><!-- /.sel-container -->
										<div class="sel-content">
											<ul>
												<li data-javo-hmap-ppp data-value='' value=''><?php _e('Views' ,'javo_fr');?></li>
												<li data-javo-hmap-ppp data-value='9' value='9'><?php _e('9 Views' ,'javo_fr');?></li>
												<li data-javo-hmap-ppp data-value='15' value='15'><?php _e('15 Views' ,'javo_fr');?></li>
												<li data-javo-hmap-ppp data-value='30' value='30'><?php _e('30 Views' ,'javo_fr');?></li>
												<li data-javo-hmap-ppp data-value='45' value='45'><?php _e('45 Views' ,'javo_fr');?></li>
												<li data-javo-hmap-ppp data-value='60' value='60'><?php _e('60 Views' ,'javo_fr');?></li>
												<li data-javo-hmap-ppp data-value='102' value='102'><?php _e('102 Views' ,'javo_fr');?></li>
											</ul>
										</div><!-- /.sel-content -->
									</div><!-- /.sel-box -->
								</div>
							<?php } ?>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-dark btn-sm<?php echo $javo_item_defult_type == 2 ? ' active':'';?>">
								<input type="radio" name="javo_btn_item_list_type" value="2" <?php checked(2 == $javo_item_defult_type);?>>
								<i class="glyphicon glyphicon-th"></i>
							</label>
							<label class="btn btn-dark btn-sm<?php echo $javo_item_defult_type == 4 ? ' active':'';?>">
								<input type="radio" name="javo_btn_item_list_type" value="4" <?php checked(4 == $javo_item_defult_type);?>>
								<i class="glyphicon glyphicon-th-list"></i>
							</label>
						</div>
					</ul>
				</div><!-- /.container -->
			</form><!-- /.nav-form -->
		</div><!-- /.navbar-collapse -->
	</div><!-- /.navbar-->

	<div class="container main-content-wrap">
	<?php
	if(have_posts()){
		the_post();
		$post_id = get_the_ID();
		printf('<div class="row"><div class="javo_output"></div></div>');
	};?>
	</div>
</div> <!-- item-list-page-wrap -->

<script type="text/template" id="javo-loading-html">
	<div class="row">
		<div class="col-md-12">
			<div class="text-center">
				<img src="<?php echo JAVO_IMG_DIR.'/loading_2.gif';?>">
			</div>
		</div>
	</div>
</script>
<script type="text/javascript">
jQuery(function($){
	"use strict";

	window.javo_search_map_once = true;
	var javo_listings = {
		parametter:{}
		, options:{}
		, init: function(){
			this.options.post_type		= "item";
			this.options.type			= $('[data-javo-item-listing-default-type]').val();
			this.options.page			= 1;
			this.options.ppp			= 9;
			this.options.lang			= $('[name="javo_cur_lang"]').val();
			this.output					= $(".javo_output");
			this.output.css('marginTop', '50px');
			this.events();

			if( $('.javo_filter').length > 0){
				$('.javo_filter').each(function(){
					$('[name="filter[' + $(this).data('tax')  + ']"]').val( $(this).data('term') );
					/* Block
					$('[data-category="' + $(this).data('tax') + '"]')
						.val( $(this).data('term') )
						.prev()
						.val( $('li[data-filter][value="' + $(this).data('term') + '"]').text() );
					*/
				});
			};
			this.run();

			$('[name^="filter"]').chosen();






		}, run: function(){
			var $object = this;

			this.parametter.url					= "<?php echo admin_url('admin-ajax.php');?>";
			this.parametter.loading				= "<?php echo JAVO_IMG_DIR;?>/loading_1.gif";
			this.parametter.txtKeyword			= $('.javo-listing-search-field');
			this.parametter.btnSubmit			= $('.javo-listing-submit');
			this.parametter.param				= this.options;
			this.parametter.selFilter			= $("[name^='filter']");
			this.parametter.map					= $(".javo_map_visible");
			this.parametter.before_callback		= function(){
				$object.output.html( $('#javo-loading-html').html() );
			};
			this.parametter.success_callback	= function(){
				var i = 0;
				$object.refresh();
				while( i <= 6 ){
					$( $object.output.find('.javo-animation').get(i) ).addClass('loaded');
					i++;
				};
				$('.javo_detail_slide').each(function(){
					$(this).flexslider({
						animation:"slide",
						controlNav:false,
						slideshow:true,
					}).find('ul').magnificPopup({
						gallery:{ enabled: true }
						, delegate: 'u'
						, type: 'image'
					});
				});
				$('.javo-tooltip').each(function(i, e){
					var options = {};
					if( typeof( $(this).data('direction') ) != 'undefined' ){
						options.placement = $(this).data('direction');
					};
					$(this).tooltip(options);
				});
			};

			this.output.javo_search(this.parametter);

		}, events:function(){
			var $object = this;
			$('body').on('click', '.toggle-full-mode', function(){

				$(document).toggleClass('content-full-mode');

			}).on('click', 'li[data-javo-hmap-ppp]', function(){

				$object.options.ppp = $(this).data('value');
				$object.run();

			}).on('change', '[name^="filter"]', function(){
				$object.parametter.selFilter = $("[name^='filter']");
				$object.run();
			}).on('change', '[name="javo_btn_item_list_type"]', function(){
				$object.options.type = $(this).val();
				$object.options.page = 1;
				$object.run();
			});
			$('.javo-this-filter').each( function(c, v){
				var _this = $(this);
				$(this).on('click', 'a', function(){
					$(this).closest('.btn-group').children('button:first-child').children('a').text( $(this).text() );
					$(this).closest('ul').next().val( $(this).data('term') );

					$object.parametter.selFilter = $("[name^='filter']");
					$object.run();
				});
			});
		}, refresh:function(){
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
	};
	javo_listings.init();
});
</script>
<?php get_footer();