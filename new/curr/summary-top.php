<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$theme_url = get_stylesheet_directory_uri();

$course_id = $args['course_id'];
$active_class = $args['active_class'];
$term_id = $args['term_id'];
$term_name = get_term_by('id', $term_id, 'ld_course_category');


$course_title = get_the_title($course_id);

// $lessons = get_posts(array(
//     'post_type' => 'sfwd-lessons',
//     'numberposts' => -1, 
//     'meta_key' => 'course_id',
//     'meta_value' => $course_id,
// ));
// $lesson_count = count($lessons);


$features_image = get_the_post_thumbnail_url($course_id);

if ( empty($features_image)){
    $url =  get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
    $imgEl = '<img src="'. $url .'" alt="'. $course_title .'" class="link-img-course">';
  } else {
    $imgEl = get_the_post_thumbnail( $course_id, 'course-thumb', array( 'loading' => 'lazy', 'class' => 'link-img-course', 'alt' => $course_title ) );
}
?>

<div class="item-course">
    <div class="img-course">
        <?php echo $imgEl;?>
    </div>
    <div class="info-course">
        <h3 class="category-title"><?php echo $term_name-> name;?></h3>
        <h4 class="course-title"><?php echo  $course_title;?></h4>
    </div>
</div>