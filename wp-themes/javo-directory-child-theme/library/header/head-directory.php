<?php
global
$javo_tso
, $javo_custom_item_label
, $javo_custom_item_tab;
?>
<header class="main" id="header-one-line">
    <nav class="navbar navbar-inverse navbar-fixed-top javo-main-navbar javo-navi-bright" role="navigation">
        <div class="container">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#javo-navibar">
                        <span class="sr-only"><?php _e('Toggle navigation', 'javo_fr');?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <button type="button" class="search-toggle" data-toggle="collapse" data-target="#javo-search">
                        <i class="fa fa-search fa-lg"></i>
                    </button>
                    <a class="navbar-brand" href="<?php echo home_url('/');?>">
                        <span class="main-sprite logo-header"></span>
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="javo-navibar">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/blog">
                                <i class="fa fa-gift"></i> Blog
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#reviewForm">
                                <i class="fa fa-gift"></i> Review a Venue
                            </a>
                        </li>
                        <li class="hidden-xs">
                            <div class="searchform">
                                <div class="input-group">
                                    <input type="text" placeholder="Search by Venue" class="form-control name-autocomplete">
                                    <span class="input-group-btn">
                                        <button class="btn btn-search" type="button">
                                            <i class="fa fa-search text-green"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <?php
                            function jQueryUI() {
                            ?>
                            <script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
                            <?php
                            }
                            function checkResults() {
                            ?>
                            <script type="text/javascript">
                                function checkResults() {
                                    var containResults = (jQuery("ul.ui-autocomplete.ui-menu").css('display') == "block") ? true : false;
                                    var firstListItem = jQuery("ul.ui-autocomplete.ui-menu li:first a").attr("href");
                                    jQuery("ul.ui-autocomplete.ui-menu").hide();
                                    if (containResults == true) {
                                        location.href = firstListItem;
                                    } else {
                                        location.href = "<?php echo get_permalink( get_page_by_path( 'venue-not-found' ) ) ?>";
                                    }
                                }
                                jQuery(function ($) {
                                    /* Handle clicking on the search icon */
                                    jQuery('.btn-search').click(function () {
                                        jQuery('.name-autocomplete').autocomplete('search').promise().done(checkResults());
                                    });

                                    /* Handle clicking on the enter button */
                                    jQuery(".name-autocomplete").keydown(function (event) {
                                        if (event.keyCode == 13) {
                                            event.preventDefault();
                                            checkResults();
                                            return false;
                                        }
                                    });

                                    $('.name-autocomplete').autocomplete({
                                        autoFocus: true,
                                        select: function (evt, ui) {
                                            evt.preventDefault();
                                            location.href = ui.item.value;
                                        },
                                        // response: function(evt, ui) {
                                        //     // ui.content is the array that's about to be sent to the response callback.
                                        //     if (ui.content.length === 0) {
                                        //         console.log("No results");
                                        //     }
                                        // },
                                        focus: function (evt, ui) {
                                            evt.preventDefault();
                                        },
                                        source: [
                                            <?php
                                            $q = new WP_Query('post_type=item&nopaging=true&orderby=meta_value&meta_key=about_name&order=ASC');
                                            while ($q->have_posts()):
                                                $q->the_post();
                                            ?>
                                            {
                                                label: "<?php echo the_field('about_name', get_the_ID());?>",
                                                value: "<?php echo the_permalink()?>"
                                            },
                                            <?php endwhile;?>
                                            {label: "%%%%%%%%%%%%%", value: "/"}
                                        ]
                                    }).data("ui-autocomplete")._renderItem = function (evt, ui) {
                                        return $("<li></li>")
                                            .data("item.autocomplete", ui)
                                            .append('<a href="' + ui.value + '"> ' + ui.label + '</a>  ')
                                            .appendTo(evt);
                                    };
                                });
                                <?php
                            }
                            add_action( 'wp_footer', 'jQueryUI', 9999999 );
                            add_action( 'wp_footer', 'checkResults', 10000000 );
                         wp_reset_postdata();
                         ?>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
                <div class="visible-xs">
                    <div class="collapse navbar-collapse" id="javo-search">
                        <div class="searchform">
                            <div class="input-group">
                                <input type="text" placeholder="Search by Venue" class="form-control name-autocomplete">
                                <span class="input-group-btn">
                                    <button class="btn btn-search" type="button">
                                        <i class="fa fa-search text-green"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <?php wp_reset_postdata();?>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div> <!-- container -->
    </nav>
</header>

<!-- Modal -->
<div class="modal fade" id="contactForm" tabindex="-1" role="dialog" aria-labelledby="contactFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="contactFormLabel">Book Viewing</h4>
      </div>
      <div class="modal-body">
          <?php echo do_shortcode('[contact-form-7 id="4" title="Contact form 1"]');?>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="reviewForm" tabindex="-1" role="dialog" aria-labelledby="reviewFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="contactFormLabel">Venue Review</h4>
            </div>
            <div class="modal-body">
                <?php echo do_shortcode('[contact-form-7 id="257" title="Review Venue"]');?>
            </div>
        </div>
    </div>
</div>