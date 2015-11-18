<?php

include('item-fields.php');

function my_filter_fields() {
    global $my_fields;
    $my_checkboxes = array(
        'about_name'                          => 0,
        'holds'                               => 0,
        'food_minimum_food_package_cost_pp'   => 0,
        'about_reception_type'                => 1,
        'search_has'                          => 1,
        'food_minimum_drinks_package_cost_pp' => 0,
        'about_venue_hire_cost'               => 0,
        'ceremony_minimum_site_hire'          => 0,
        'accommodation_cheapest_room_rate'    => 0,
        'food_food_service_options'           => 1,
        'food_food_package_extras'            => 1,
        'details_decorations_allowed'         => 1,
        'ceremony_site_types'                 => 1,
        'accommodation_type'                  => 1,
        'accommodation_capacity'              => 0,
        'search_food_extras'                  => 1,
        'search_site_type'                    => 1,
        'search_accommodation_features'       => 1,
        'search_food_service'                 => 1,
        'reception_type_checkboxes'           => 1
    );
    $my_filter_fields = array();

    foreach ($my_fields as $field) {
        $name = $field['name'];
        if ($name && array_key_exists($name, $my_checkboxes)) {
            $values = array();
            $values_by_idx = array_keys($field['choices']);
            // sort($values_by_idx);
            $values_by_key = array_flip($values_by_idx);
            foreach ($field['choices'] as $key => $val) {
                $value = array();
                $value['key'] = $key;
                $value['display'] = $val;
                $value['idx'] = $values_by_key[$key];
                $values[$key] = $value;
            }
            $my_filter_fields[$name] = array(
                'name'        => $name,
                'is_checkbox' => $my_checkboxes[$name],
                'values'      => $values,
                'by_idx'      => $values_by_idx,
                'by_key'      => $values_by_key,
            );
        }
    }

    return $my_filter_fields;
}

$my_filter_fields = my_filter_fields();

function my_append_filter_for_field($field, $filters) {
    global $_GET;
    if ( ! array_key_exists($field['name'], $_GET)) return $filters;
    $qstring = $_GET[$field['name']];
    $valid = 0;
    if ( ! $field['is_checkbox']) {
        $filter = array(
            'key' => $field['name'],
        );
        $filter['compare'] = 'IN';
        $filter['value'] = array();
        if ('holds' == $field['name']) {
            $byidx = $field['by_idx'];
            for ($i = $qstring + 1 - 1; array_key_exists($i, $byidx); $i++) {
                $filter['value'][] = $byidx[$i];
                $valid = 1;
            }
        } else {
            for ($i = 0; $i <= $qstring; $i++) {
                $filter['value'][] = $field['by_idx'][$i];
                $valid = 1;
            }
        }
        if ($valid) {
            $filters[] = $filter;
        }
    } else {
        if (is_array($qstring)) {
            foreach ($field['by_idx'] as $idx => $key) {
                if (in_array($idx, $qstring)) {
                    $filter = array(
                        'key' => $field['name'],
                    );
                    $filter['compare'] = 'LIKE';
                    $filter['value'] = '"' . $key . '"';
                    $filters[] = $filter;
                }
            }
        } else {
            $filter = array(
                'key' => $field['name'],
            );
            $filter['compare'] = 'LIKE';
            $filter['value'] = '"' . $qstring . '"';
            $filters[] = $filter;
        }
    }

    return $filters;
}

function my_filters() {
    global $my_filter_fields;
    $filters = array();
    foreach ($my_filter_fields as $field) {
        $filters = my_append_filter_for_field($field, $filters);
    }

    return $filters;
}

$my_sortby = '';
$my_sort_params = array(
    // 'food_minimum_food_package_cost_pp' => 'Cost',
    'about_name'   => 'Venue Name',
    'about_region' => 'Region',
);
function my_sort_params() {
    global $my_sortby;
    global $my_sort_params;
    if (isset($_GET['sort'])
        &&
        in_array($_GET['sort'], array_keys($my_sort_params))
    ) {
        $my_sortby = $_GET['sort'];
    } else {
        $my_sortby = 'about_name';
    }
    $args = array(
        'orderby'  => 'meta_value',
        'meta_key' => $my_sortby,
        'order'    => 'ASC',
    );

    return $args;
}

function my_query_args() {
    $query = my_sort_params();
    $query['post_type'] = 'item';
    $query['meta_query'] = my_filters();
    $query['posts_per_page'] = -1;
    $query['posts_per_archive_page'] = -1;
    /* #191 - Remove the Tempus Two Barrel Room from the search results page */
    $query['post__not_in'] = array("800");

    return $query;
}

$my_query = new WP_Query(my_query_args());

function my_found_posts() {
    global $my_query;

    return $my_query->found_posts;
}

function my_have_posts() {
    global $my_query;

    return $my_query->have_posts();
}

function my_the_post() {
    global $my_query;
    $my_query->the_post();
}
