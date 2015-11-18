<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Javo_Directory
 * @since Javo Themes 1.0
 */

// Get global post object
global $post;

// Variable initialize
$javo_sidebar_lr = "right";

// Post object exist?
if(!empty($post->ID)){

    // Get post object id
    $post_id = $post->ID;
    // Get display post sidebar option meta.
    $javo_sidebar_lr = trim( (string)get_post_meta( $post_id, 'javo_sidebar_type', true) );
    // Set not exist meta value to default 'Right'
    $javo_sidebar_lr = !empty($javo_sidebar_lr)? $javo_sidebar_lr : "right";
};?>

<div class="col-md-3 sidebar-<?php echo $javo_sidebar_lr;?> hidden-xs">
    <div id="RHN">
        <div class="row">
            <div class="col-sm-12 margin-sm-bottom">
                <a href="#" class="btn btn-lg btn-contact book" data-toggle="modal" data-target="#followBlog">
                    Follow
                </a>
                <div class="modal fade" id="followBlog" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">
                                    Subscribe to our blog
                                </h4>
                            </div>
                            <div class="modal-body">
                                <!-- Begin MailChimp Signup Form -->
                                    <div id="mc_embed_signup">
                                        <form action="//laceandcake.us10.list-manage.com/subscribe/post?u=76213175a68a07783deac79b7&amp;id=e5017598b6" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                            <div id="mc_embed_signup_scroll">
                                                <div class="indicates-required pull-right clearfix">
                                                    <span class="asterisk">*</span> indicates required
                                                </div>
                                                <div class="mc-field-group form-group">
                                                    <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
                                                    </label>
                                                    <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL">
                                                </div>
                                                <div class="mc-field-group form-group">
                                                    <label for="mce-FNAME">First Name </label>
                                                    <input type="text" value="" name="FNAME" class="form-control" id="mce-FNAME">
                                                </div>
                                                <div class="mc-field-group form-group">
                                                    <label for="mce-LNAME">Last Name </label>
                                                    <input type="text" value="" name="LNAME" class="form-control" id="mce-LNAME">
                                                </div>
                                                <div id="mce-responses" class="clear">
                                                    <div class="response" id="mce-error-response" style="display:none"></div>
                                                    <div class="response" id="mce-success-response" style="display:none"></div>
                                                </div>
                                                <div style="position: absolute; left: -5000px;"><input type="text" name="b_76213175a68a07783deac79b7_e5017598b6" tabindex="-1" value=""></div>
                                                <div class="form-group clearfix">
                                                    <div class="pull-right align-right">
                                                        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
                                <!--End mc_embed_signup-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 margin-sm-bottom">
                <?php echo do_shortcode('[javo_featured_items_sidebar]'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 margin-sm-bottom cloud-tags">
                <h4 class="text-uppercase">
                    Topics
                </h4>
                <?php
                    $args = array(
                        'taxonomy' => array( 'category' ),
                        'smallest' => 14,
                        'largest' => 28,
                        'number' => 10,
                    );
                    wp_tag_cloud($args); ?>
            </div>
        </div>
    </div>
</div>