<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$parent_term_slug = $args['parent_term_slug'];
$category_id = $args['id'];
$terms = get_term_by('term_id', $category_id, 'ld_course_category');
$term_id = $terms -> term_id;
$term_name = $terms -> name;
$taxonomy = 'ld_course_category';

get_template_part('new/modal', null, array(
    'category_id' => $category_id,
    'category_name' => $term_name
));

$args = array(
    'post_type'			=>	'sfwd-courses',
    'post_status'		=>	'publish',
    'fields'			=>	'ids',
    'orderby'			=>	'title',
    'order'				=>	'ASC',
    'nopaging'			=>	true, 	// Turns OFF paging logic to get ALL courses
    'tax_query'         => array(
        array(
        'taxonomy' => $taxonomy,
        'field' => 'term_id',
        'terms' => $term_id,
        )
    ),
  );
  $query = new WP_Query($args);
  $course_quantity = $query -> found_posts;

  get_template_part('new/course-quantity', null, array(
    'term_name' => $term_name,
    'course_quantity' => $course_quantity,
    'category_id' => $term_id,
    'parent_term_slug' => $parent_term_slug,
    'main_parent_tab' => 'School Improvement'
  ));

echo '<div class="search-result mt-2 curriculum-table-container" id="accordion-for-' . $category_id . '">';?>
    <div id="heading-<?php echo $term_id;?>" class="d-flex align-items-center justify-content-between">
    </div>
    <div id="collapse-<?php echo $term_id;?>" class="hidden-content block?>" aria-labelledby="heading-<?php echo $term_id;?>">
    <?php

    $counter = 0;
    if ($query->have_posts()) {

    echo '<div class="d-flex align-items-start curr_cour_desc">';
    echo '<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">';
    while($query-> have_posts()){
        $query->the_post();
        $category = get_the_terms(get_the_ID(), $taxonomy);
        $term_id = $category[0] -> term_id;
        $term_name = $category[0] -> name;
        $counter++;

        if ($counter == 1) {
            $active_class = 'active show';
        } else {
            $active_class = '';
        }
        $course_id = get_the_ID();
        $course_title = get_the_title($course_id);
        $features_image = get_the_post_thumbnail_url($course_id);

        if ( empty($features_image)){
            $url =  get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
            $imgEl = '<img src="'. $url .'" alt="'. $course_title .'" class="link-img-course">';
          } else {
            $imgEl = get_the_post_thumbnail( $course_id, 'course-thumb', array( 'loading' => 'lazy', 'class' => 'link-img-course', 'alt' => $course_title ) );
        }

        ?>  
        <div class="lesson_list si-course">
            <div class="item-course">
                <div class="custom-form-check">
                    <input class="course_checked_id" name="<?php echo $course_id; ?>" type="checkbox" id="<?php echo $course_id; ?>">
                    <label for="<?php echo $course_id; ?>" class="plus-checkbox" data-toggle="tooltip" data-bs-placement="top" title="select"></label>
                </div>
                <div class="img-course">
                    <?php echo $imgEl; ?>
                </div>
                <div class="info-course">
                    <h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_title;?>">
                        <?php echo $course_title;?>
                    </h5>          
                </div>
                <div class="show-course">
                    <button class="btn-secondary <?php echo $active_class; ?> >" id="v-pills-<?php echo $course_id ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $course_id; ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $course_id; ?>" aria-selected="false">View Details</button>
                </div>
            </div>
        </div>
        <?php
    }
    echo '</div>';
    echo ' <div class="tab-content lessons" id="v-pills-tabContent">';
    wp_reset_postdata();

    $counterTwo = 0;
    while ($query->have_posts()) {
        $query->the_post();

        $counterTwo++;

        if ($counterTwo == 1) {
            $active_class = 'active show';
        } else {
            $active_class = '';
        }

        $course_id = get_the_ID();

        ?>

        <div class="tab-pane fade <?php echo $active_class ?>" id="v-pills-<?php echo $course_id; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $course_id; ?>-tab">
            <div class="course_summary lesson-<?php echo $course_id; ?>">
                <div class="course_highlight">
                <?php 
                    get_template_part('new/pro-learning/si-summary-top', null, array(
                        'course_id' => $course_id
                    )); 
                ?> 
                </div>
                <?php
                get_template_part('new/details-tab', null, array(
                    'course_id' => $course_id,
                    'parent_id' =>  $term_id 
                    )) ?>
            </div>
        </div>
        <?php  
        }
    echo '</div>';
    echo '</div>';
    wp_reset_postdata();
    echo '</div>';
} else {
    echo '<div class="py-3 hidden-content block">';
    echo 'no course found for this terms ' . $term_name . ' and course title of ';
    echo '</div>';
}
echo '</div>';