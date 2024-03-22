
 <?php

// Exit if accessed directly
if( !defined('ABSPATH')) exit;
 
$course_id = $args['course_id'];
$parent_id = $args['parent_id'];

 if (function_exists('get_field')) {
    if(get_field("Summary" , $course_id)) {
        $summary = get_field("Summary" , $course_id);
    } else {
        $summary = 'Please add summary for this course';
    }
    } else {
        $summary = 'Please activate ACF, and add summary for this course';
    }
 ?>
 
 <!-- Nav tabs -->
<div class="course_short_summary">
    <div class="d-flex flex-row navs" id="summary-for-<?php echo $course_id;?>" role="tablist">
        <div style="color:#F8F9FC;" class="position-relative tab-image nav-link w-100 active" id="summary-tab-<?php echo $course_id;?>" data-bs-toggle="tab" href="#summary-<?php echo $course_id;?>" aria-controls="summary-<?php echo $course_id;?>" aria-selected="false" role="tab" tabindex="-1">
            <svg style="height: 36px" class="w-100" viewBox="0 0 193 40" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d_6543_11707)">
                    <path d="M192 39H3C7.44526 31.4494 17.5052 14.7507 20.9343 9.47189C24.6131 3.80862 27.5968 3.00002 31.2756 3H160.73C167.352 3 169.927 5.83146 171.766 8.66292L192 39Z" fill="currentColor"></path>
                </g>
                <defs>
                    <filter id="filter0_d_6543_11707" x="0" y="0" width="193" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                        <feOffset dx="-1" dy="-1"></feOffset>
                        <feGaussianBlur stdDeviation="1"></feGaussianBlur>
                        <feComposite in2="hardAlpha" operator="out"></feComposite>
                        <feColorMatrix type="matrix" values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0"></feColorMatrix>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6543_11707"></feBlend>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6543_11707" result="shape"></feBlend>
                    </filter>
                </defs>
            </svg>
            <div style="top: 8px; left: 0; right: 0%;" class="position-absolute">
                <p style="text-overflow: ellipsis;
                font-size: 16px;
                position: absolute;
                text-align: center;
                width: 59%;
                    max-width: 59%;
                white-space: nowrap;
                overflow: hidden;
                " class="tab-text" data-toggle="tooltip" data-placement="top" title="Summary">Summary</p>
            </div>
        </div>
        <div style="color:#F8F9FC;" class="position-relative tab-image nav-link w-100 " id="resources-tab-<?php echo $course_id;?>" data-bs-toggle="tab" href="#resources-<?php echo $course_id;?>" aria-controls="resources-<?php echo $course_id;?>" aria-selected="false" role="tab" tabindex="-1">
            <svg style="height: 36px" class="w-100" viewBox="0 0 193 40" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d_6543_11707)">
                    <path d="M192 39H3C7.44526 31.4494 17.5052 14.7507 20.9343 9.47189C24.6131 3.80862 27.5968 3.00002 31.2756 3H160.73C167.352 3 169.927 5.83146 171.766 8.66292L192 39Z" fill="currentColor"></path>
                </g>
                <defs>
                    <filter id="filter0_d_6543_11707" x="0" y="0" width="193" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                        <feOffset dx="-1" dy="-1"></feOffset>
                        <feGaussianBlur stdDeviation="1"></feGaussianBlur>
                        <feComposite in2="hardAlpha" operator="out"></feComposite>
                        <feColorMatrix type="matrix" values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0"></feColorMatrix>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6543_11707"></feBlend>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6543_11707" result="shape"></feBlend>
                    </filter>
                </defs>
            </svg>
            <div style="top: 8px; left: 0; right: 0%;" class="position-absolute">
                <p style="text-overflow: ellipsis;
                font-size: 16px;
                position: absolute;
                text-align: center;
                width: 59%;
                    max-width: 59%;
                white-space: nowrap;
                overflow: hidden;
                " class="tab-text" data-toggle="tooltip" data-placement="top" title="Resources">Resources</p>
            </div>
        </div>
    </div>
    <!-- Tab panes / nav content-->
    <div class="tab-content">
        <div class="tab-pane active" id="summary-<?php echo $course_id;?>" role="tabpanel" aria-labelledby="summary-tab-<?php echo $course_id;?>">
            <div class="summary"><?php echo $summary; ?></div>
        </div>
        <div class="tab-pane" id="resources-<?php echo $course_id;?>" role="tabpanel" aria-labelledby="resources-tab-<?php echo $course_id;?>">
            <?php

            
            echo get_post_meta( $course_id , 'details-tab' , true );
             
            // $lessons = learndash_get_course_lessons_list($course_id);

            // if(count($lessons) > 0){
            //     echo '<ul class="p-0">';
            //     foreach($lessons as $lesson){
            //         $is_sample = learndash_is_sample($lesson["id"]);
            //         $title = $lesson["post"] -> post_title;
            //         $url = $lesson["permalink"];

            //         if($is_sample){
            //             echo  '<li class="d-flex mb-1">';
            //             echo '<img class="status" src="' . get_stylesheet_directory_uri() . '/assets/svg/resource-book.svg"' . 'alt="icon">';
            //             echo '<a target="_blank" class="lesson-title" href="'. $url . '">' . $title . '</a>';
            //             echo  '</li>';
            //         } else {
            //             echo  '<li class="d-flex mb-1">';
            //             echo '<img class="status" src="' . get_stylesheet_directory_uri() . '/assets/svg/resource-lock.svg"' . 'alt="icon">';
            //             echo '<p class="lesson-title" data-toggle="tooltip" data-placement="top" title="'. $title .'">'.$title. '</p>';
            //             echo  '</li>';
            //         }
            //     }
            //     echo '</ul>';
            // } else {
            //     echo 'No lessons/resource availble at the moment, please check back later';
            // }          
            ?>
        </div>
        
    </div>
</div>