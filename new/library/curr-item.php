<?php

$course_id = $args['course_id'];

$course_name = get_the_title($course_id);
$permalink = get_the_permalink($course_id);

$features_image = get_the_post_thumbnail_url($course_id);

if ( empty($features_image)){
    $url =  get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
    $imgEl = '<img src="'. $url .'" alt="'. $course_name .'" class="link-img-course">';
  } else {
    $imgEl = get_the_post_thumbnail( $course_id, 'course-thumb', array( 'loading' => 'lazy', 'class' => 'link-img-course', 'alt' => $course_name ) );
}

?>
<div class="item-course <?php echo 'on-ur-library-' . $course_id;?>">
    <div class="img-course">
        <?php echo $imgEl;?>
    </div>
    <div class="info-course">
        <h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_name;?>">
            <?php echo $course_name;?>
        </h5>
        <div class="course-duration">
            <div class="number-lesson">
                <div class="icon-lesson">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/book.svg'?>" alt="curriculum">
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
                    //     echo ' ' . wp_kses_post(sprintf(_x('%s Lesson ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
                    // }
                    // else{
                    //     echo ' ' . wp_kses_post(sprintf(_x('%s Lessons ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
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
