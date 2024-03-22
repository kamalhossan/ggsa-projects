<?php

$course_id = $args['course_id'];
$course_name = get_the_title($course_id);
$permalink = get_the_permalink($course_id);

$features_image = get_the_post_thumbnail_url($course_id);

if ( empty($features_image)){
    $url =  get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
    $imgEl = '<img src="'. $url .'" alt="'. $course_name .'" class="link-img-course">';
  } else {
    $imgEl = get_the_post_thumbnail( $course_id, 'pro-course-thumb', array( 'loading' => 'lazy', 'class' => 'link-img-course', 'alt' => $course_name ) );
}
?>
<div class="item-course <?php echo 'on-ur-library-' . $course_id;?>">
    <div class="img-course pro-lrn-img">
        <?php echo $imgEl;?>
    </div>
    <div class="info-course">
        <h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_name;?>">
            <?php echo $course_name;?>
        </h5>
        <div class="course-duration">
            <div class="number-lesson">
                <div class="icon-lesson">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/book.svg'?>" alt="professional improvement">
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
            <div class="hours-lesson">
                <div class="icon-hours">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <g clip-path="url(#clip0_6407_8254)">
                            <path d="M16.5 9C16.5 13.14 13.14 16.5 9 16.5C4.86 16.5 1.5 13.14 1.5 9C1.5 4.86 4.86 1.5 9 1.5C13.14 1.5 16.5 4.86 16.5 9Z" stroke="#9D9D9D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.7827 11.3851L9.45766 9.99757C9.05266 9.75757 8.72266 9.18007 8.72266 8.70757V5.63257" stroke="#9D9D9D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_6407_8254">
                            <rect width="18" height="18" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <span class="text-hours-lesson">
                <?php
                    $c_time = get_post_meta( $course_id , 'course_time' , true );
                    if( $c_time ){
                        if ($c_time == 1 || $c_time == 0){
                            echo $c_time." hour";
                        }
                        else{
                            echo $c_time." hours";
                        }
                    }
                    else{
                        echo "8 hours";
                    }
                ?>
                </span>
            </div>
        </div>
    </div>
</div>
