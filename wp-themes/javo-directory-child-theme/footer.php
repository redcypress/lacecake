<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Javo_Directory
 * @since Javo Themes 1.0
 */
?>
<?php global $javo_theme_option, $javo_tso; ?>
    <?php if( is_active_sidebar('footer-level1-1') || is_active_sidebar('footer-level1-2')  ) : ?>
<!-- SUPPORT & NEWSLETTER SECTION ================================================ -->
<div class="row footer-top-full-wrap">
    <div class="container footer-top">
        <section>
          <div id="support">
            <div class="row">
            </div><!--end row-->
          </div><!--end support-->
        </section>
    </div><!-- container-->
</div> <!-- footer-top-full-wrap -->
<!--END SUPPORT & NEWSLETTER SECTION-->
<?php endif; ?>

<footer class="footer-wrap <?php post_class(); ?>">
    <div class="container">
        <div class="row margin-sm">
            <div class="col-sm-3 col-xs-6">
                <ul class="list-unstyled">
                    <li>
                        <h4 class="text-uppercase">
                            About Us
                        </h4>
                    </li>
                    <li>
                        <h5>
                            <a href="/about-us">
                                About Us
                            </a>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <a href="/faqs">
                                FAQs
                            </a>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <a href="#" class="get-in-touch" data-toggle="modal" data-target="#contactForm">
                                Get in touch
                            </a>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <a href="/privacy-policy">
                                Privacy Policy
                            </a>
                        </h5>
                    </li>
                    <li>
                        <h5>
                            <a href="/terms-of-use">
                                Terms of Use
                            </a>
                        </h5>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3 col-xs-12">
                <ul class="list-unstyled">
                    <li>
                        <h4 class="text-uppercase">
                            Be Inspired
                        </h4>
                    </li>
                    <li>
                        <ul class="list-inline">
                            <li>
                                <a href="/blog" class="social-media-icon blog" target="_blank">
                                    <span class="letter">
                                        B
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="http://instagram.com/lace_and_cake" class="social-media-icon instagram" target="_blank">
                                    <i class="fa fa-instagram fa-lg text-white"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://facebook.com/laceandcake" class="social-media-icon facebook" target="_blank">
                                    <i class="fa fa-facebook fa-lg text-white"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://twitter.com/lace_and_cake" class="social-media-icon twitter" target="_blank">
                                    <i class="fa fa-twitter fa-lg text-white"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://pinterest.com/lace_and_cake" class="social-media-icon pinterest" target="_blank">
                                    <i class="fa fa-pinterest fa-lg text-white"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p class="text-center"><?php echo $javo_theme_option['copyright'];?></p>
            </div>
        </div>
    </div>
</footer>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top javo-dark admin-color-setting" role="button" title="<?php _e('Go to top', 'javo_fr');?>"><span class="glyphicon glyphicon-chevron-up"></span></a>




<?php
get_template_part('templates/parts/modal', 'login');		// modal login
get_template_part('templates/parts/modal', 'register');		// modal Register
get_template_part('templates/parts/modal', 'contact-us');	// modal contact us
get_template_part('templates/parts/modal', 'map-brief');	// Map Brief
get_template_part("templates/parts/modal", "emailme");		// Link address send to me
get_template_part("templates/parts/modal", "reviews");		// reviews
echo stripslashes($javo_tso->get('analytics'));
?>
<?php wp_footer(); ?>
    jQuery(document).ready(function($){
        "use strict";
        jQuery("a.javo_favorite").javo_favorite({
            url:"<?php echo admin_url('admin-ajax.php');?>"
            , user: "<?php echo get_current_user_id();?>"
            , str_nologin: "<?php echo $javo_favorite_alerts['nologin'];?>"
            , str_save: "<?php echo $javo_favorite_alerts['save'];?>"
            , str_unsave: "<?php echo $javo_favorite_alerts['unsave'];?>"
            , str_error: "<?php echo $javo_favorite_alerts['error'];?>"
            , str_fail: "<?php echo $javo_favorite_alerts['fail'];?>"
            , before: function(){
                if( !( jQuery('.javo-this-logged-in').length > 0 ) ){
                    jQuery('#login_panel').modal();
                    return false;
                };
                return;
            }
        });

        jQuery(".book").click(function() {
            jQuery('#contactFormLabel').text('Book Viewing');
            jQuery('#contactForm option:contains("Book")').prop('selected', true);
        });

        jQuery(".contact").click(function() {
            jQuery('#contactFormLabel').text('Contact Venue');
            jQuery('#contactForm option:contains("Inquiry")').prop('selected', true);
        });

        jQuery(".feedback").click(function() {
            jQuery('#contactFormLabel').text('Give us your feedback');
            jQuery('#contactForm option:contains("Feedback")').prop('selected', true);
        });


        jQuery(".get-in-touch").click(function() {
            jQuery('#contactFormLabel').text('Get in Touch');
            jQuery('#contactForm option:contains("touch")').prop('selected', true);
        });

        jQuery(".list").click(function() {
            jQuery('#contactFormLabel').text('List your Venue');
            jQuery('#contactForm option:contains("List")').prop('selected', true);
        });

    });
</script>
</div>
</body>
</html>