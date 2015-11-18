<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
        <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search by Venue" class="form-control">
        <span class="input-group-btn" type="submit" id="searchsubmit">
            <button class="btn btn-search" type="button">
                <i class="fa fa-search text-green"></i>
            </button>
        </span>
    </div>
</form>

