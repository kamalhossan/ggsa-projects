<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$term_id = $args['term_id'];
$main_parent_name = $args['main_parent_name'];
$args = array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field'    => 'id', // You can use 'id', 'slug', or 'name' here
            'terms'    => $term_id, // Replace with the category IDs you want to include
        )
    ),
);

$query = new WP_Query($args);

if ($query->have_posts()) {

    $counter = 0;
    echo '<div class="d-flex align-items-start curr_cour_desc">';
    echo '<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">';
    while ($query->have_posts()) {
        $query->the_post();

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
            $imgEl = get_the_post_thumbnail( $course_id, 'pro-course-thumb', array( 'loading' => 'lazy', 'class' => 'link-img-course', 'alt' => $course_title ) );
        }

        ?>  
        <div class="lesson_list <?php echo ($main_parent_name == "School Improvement") ? 'si-course' : 'pro-learning';?>">
            <div class="item-course">
                <div class="custom-form-check">
                    <input class="course_checked_id" name="<?php echo $course_id; ?>" type="checkbox" id="<?php echo $course_id; ?>">
                    <label for="<?php echo $course_id; ?>" class="plus-checkbox" data-toggle="tooltip" data-bs-placement="top" title="select"></label>
                </div>
                <div class="img-course">
                    <?php echo $imgEl;?>
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
            
                if($main_parent_name == "School Improvement"){
                    get_template_part('new/pro-learning/si-summary-top', null, array(
                        'course_id' => $course_id
                    )); 
                } else {
                    get_template_part('new/pro-learning/summary-top', null, array(
                        'course_id' => $course_id
                    )); 
                }
                ?> 
                </div>
                <?php
                get_template_part('new/details-tab', null, array('course_id' => $course_id,'parent_id' =>  $term_id )) ?>
            </div>
        </div>
        <?php
        }
    echo '</div>';
    echo '</div>';
    wp_reset_postdata();
} else {
    echo 'No course found for this course category, please add course';
}
