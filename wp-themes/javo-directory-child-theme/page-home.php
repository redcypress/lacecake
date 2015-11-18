<?php
/*
Template Name: Home Page
<?php echo do_shortcode('[javo_slide_search]'); ?>
*/
get_header();
include('templates/item-filter.php');

function display_dropdown($field) {
    ?>
    <input type="hidden" name="<?php echo $field['name']; ?>"
           value="-1" id="home-field-<?php echo $field['name']; ?>"/>
    <ul class="dropdown-menu lc-holds" role="menu">
        <?php foreach ($field['values'] as $value): ?>
            <li><a href="#"
                   onclick="jQuery('#home-field-<?php echo $field['name']; ?>').<?php
                   ?>val('<?php echo $value['idx']; ?>');">
                    <?php echo $value['display']; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php
}

function display_checkboxes($field) {
    ?>
    <?php foreach ($field['values'] as $value): ?>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="<?php echo $field['name']; ?>[]"
                    <?php
                    if (
                        isset($_GET[$field['name']])
                        &&
                        in_array($value['idx'], $_GET[$field['name']])
                    ) {
                        echo 'checked="checked"';
                    }
                    ?>
                       value="<?php echo $value['idx']; ?>"/>
                <?php echo $value['display']; ?>
            </label>
        </div>
    <?php endforeach; ?>
    <?php
}

function display_hidden($key) {
    global $my_filter_fields;
    $field = $my_filter_fields[$key];
    if (isset($_GET[$field['name']])):
        if ($field['is_checkbox']):
            foreach ($_GET[$field['name']] as $val):
                ?>
                <input type="hidden" name="<?php echo $field['name']; ?>[]"
                       value="<?php echo $val; ?>"/>
                <?php
            endforeach;
        else:
            ?>
            <input type="hidden" name="<?php echo $field['name']; ?>"
                   value="<?php echo $_GET[$field['name']]; ?>"/>
            <?php
        endif;
    endif;
}

function display_field($key) {
    global $my_filter_fields;
    $field = $my_filter_fields[$key];
    if ($field['is_checkbox']):
        display_checkboxes($field);
    else:
        display_dropdown($field);
    endif;
}

?>
<div class="feature-bg home"
     style="background:url('http://gymq.cdn.pageload.io/wp-content/themes/javo-directory-child-theme/assets/images/home-bg.jpg') no-repeat center center fixed;  -webkit-background-size: cover;  -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-attachment: fixed;">
    <div class="container">
        <div class="row margin-lg">
            <div class="col-sm-12">
                <div class="center margin-sm-bottom">
                    <span class="main-sprite leaf"></span>
                </div>
                <h1 class="text-white text-center media-heading">
                    My perfect Hunter Valley<br>
                    wedding venue...
                </h1>
            </div>
        </div>
        <div class="row margin-md-top margin-lg-bottom">
            <div class="col-md-10 col-md-offset-1 col-sm-12">
                <form method="GET" action="/search-demo/">
                    <div class="slider-search-part-wrap pull-center">
                        <div class="btn-group main">
                            <div class="btn-group sub first">
                                <button class="btn btn-default dropdown-toggle btn-block" type="button"
                                        data-toggle="dropdown">
                                    Holds <span class="selection"></span> <span class="caret"></span>
                                </button>
                                <?php display_field('holds'); ?>
                            </div>
                            <div class="btn-group sub">
                                <button class="btn btn-default dropdown-toggle btn-block" type="button"
                                        data-toggle="dropdown">
                                    Costs/pp <span class="selection"></span> <span class="caret"></span>
                                </button>
                                <?php display_field('food_minimum_food_package_cost_pp'); ?>
                            </div>
                            <div class="btn-group sub">
                                <button class="btn btn-default dropdown-toggle btn-block" type="button"
                                        data-toggle="dropdown">
                                    Style <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu lc-style keep-open" role="menu">
                                    <?php display_field('reception_type_checkboxes'); ?>
                                </div>
                            </div>
                            <div class="btn-group sub last">
                                <button class="btn btn-default dropdown-toggle btn-block" type="button"
                                        data-toggle="dropdown">
                                    Has <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu lc-has padding-sm keep-open" role="menu">
                                    <?php display_field('search_has'); ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-uppercase">Match Me</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row margin-lg">
        <div class="col-sm-3 text-center padding-sm">
            <div class="center margin-sm-bottom">
                <i class="fa fa-smile-o fa-3x text-green"></i>
            </div>
            <h3 class="text-uppercase margin-sm-bottom text-green">Simple <br>and Free</h3>

            <p>Find all venues in one spot! Brides and venues use our site for free,
                so you know you're being matched with the best venues for you.
            </p>
        </div>
        <div class="col-sm-3 text-center padding-sm">
            <div class="center margin-sm-bottom">
                <i class="fa fa-book fa-3x text-green"></i>
            </div>
            <h3 class="text-uppercase margin-sm-bottom text-green">We've Done <br>the Hard Work</h3>

            <p>We've asked every venue all the small, weird, wonderful questions
                you need to know so you can find your perfect match.
            </p>
        </div>
        <div class="col-sm-3 text-center padding-sm">
            <div class="center margin-sm-bottom">
                <i class="fa fa-search fa-3x text-green"></i>
            </div>
            <h3 class="text-uppercase margin-sm-bottom text-green">Detailed <br>Search</h3>

            <p>Need a venue with accommodation and a late finish time?...Quickly
                and easily shortlist venues based on criteria that's important to YOU!
            </p>
        </div>
        <div class="col-sm-3 text-center padding-sm">
            <div class="center margin-sm-bottom">
                <i class="fa fa-calendar fa-3x text-green"></i>
            </div>
            <h3 class="text-uppercase margin-sm-bottom text-green">Arrange <br>Viewings</h3>

            <p>See a venue you like? Simply click the 'Book Viewing'
                button to arrange a viewing.
            </p>
        </div>
    </div>
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
<?php
function dropdownClick() {

?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".dropdown-menu li a").click(function (e) {
            $(this).parents(".btn-group.sub").find('.selection').text('(' + $(this).text() + ')');
            e.preventDefault();
        });

        $(document).on('click', '.dropdown-menu', function (e) {
            $(this).hasClass('keep-open') && e.stopPropagation(); // This replace if conditional.
        });
    });
</script>
<?php }
add_action('wp_footer', 'dropdownClick', 99999)
?>
<?php get_footer(); ?>
