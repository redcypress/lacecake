<?php
/*
Template Name: Venue Not Found
<?php echo do_shortcode('[javo_slide_search]'); ?>
*/
get_header()
?>
<div class="container error-page-wrap venue-not-found">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">                
                <h2><?php _e("Venue Not Found", "javo_fr") ?></h2>
                <div class="error-details">
                    <?php _e("Oops, we can't that venue! <a href=".home_url().">Search again</a> or check out some of our top picks", "javo_fr") ?>
                </div>                
				<div class="clearfix light-green-bg">
                    <div class="container">
                        <div class="row margin-lg-top margin-md-bottom">
                            <div class="col-sm-12 text-center">
                                <div class="center">
                                    <span class="main-sprite leaf"></span>
                                </div>
                                <h3 class="text-uppercase text-green media-heading">Featured Venues</h3>
                                <p>Take a look at some of our top picks.</p>
                            </div>
                        </div>
                        <div class="row margin-lg-bottom">
                            <?php echo do_shortcode('[javo_featured_items]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>