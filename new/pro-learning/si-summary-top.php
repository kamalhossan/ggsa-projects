<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$theme_url = get_stylesheet_directory_uri();

$course_id = $args['course_id'];
$course_title = get_the_title($course_id);

$features_image = get_the_post_thumbnail_url($course_id);

if ( empty($features_image)){
    $url =  get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
    $imgEl = '<img src="'. $url .'" alt="'. $course_title .'" class="link-img-course">';
  } else {
    $imgEl = get_the_post_thumbnail( $course_id, 'course-thumb', array( 'loading' => 'lazy', 'class' => 'link-img-course', 'alt' => $course_title ) );
}

$counter = 0;
$counterTwo = 0;
// $lessons = get_posts(array(
//     'post_type' => 'sfwd-lessons', // LearnDash lesson post type.
//     'numberposts' => -1, // Retrieve all lessons for the course.
//     'meta_key' => 'course_id',
//     'meta_value' => $course_id,
// ));

// $lesson_count = count($lessons);

?>

<div class="item-course">
    <div class="img-course">
        <?php echo $imgEl;?>
    </div>
    <div class="info-course">
        <h5 class="title-course"><?php echo $course_title;?></h5>
        <div class="course-duration">
            <div class="number-lesson">
                <div class="icon-lesson">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/document.svg'?>" alt="school improvement">
                </div>
                <span class="text-number-lesson"><?php 
                    // $course_progress_summary = learndash_user_get_course_progress(get_current_user_id(), $course_id, 'summary');

                    // if (isset($course_progress_summary['status'])) {
                    //     $course_status_slug = esc_attr($course_progress_summary['status']);
                    // }

                    // if (isset($course_progress_summary['completed'])) {
                    //     $coursep['completed'] = absint($course_progress_summary['completed']);
                    // }

                    // if (isset($course_progress_summary['total'])) {
                    //     $coursep['total'] = absint($course_progress_summary['total']);
                    // }
                    // if(  $coursep['total'] == 0 ||  $coursep['total'] == 1 ) {
                    //     echo ' ' . wp_kses_post(sprintf(_x('%s document ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
                    // }
                    // else{
                    //     echo ' ' . wp_kses_post(sprintf(_x('%s documents ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
                    // }
                    $step_lesson_count = get_post_meta( $course_id , '_ld_course_steps_count' , true );
                    if( $step_lesson_count == 0 ||  $step_lesson_count == 1 ) {
                        echo ' ' . wp_kses_post(sprintf(_x('%s Lesson ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $step_lesson_count));
                    }
                    else{
                        echo ' ' . wp_kses_post(sprintf(_x('%s Lessons ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $step_lesson_count));   
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>