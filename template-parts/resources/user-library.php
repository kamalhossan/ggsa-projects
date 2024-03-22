<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$library_tabs = array('Curriculum', 'Professional learning', 'School Improvement');

$currentUserID = get_current_user_id();

$enroll_course_quantity = count(learndash_user_get_enrolled_courses($currentUserID, array()));

$curr_course = learndash_user_get_enrolled_courses($currentUserID, array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => 'curriculum',
        ),
    ),
));

$pro_course = learndash_user_get_enrolled_courses($currentUserID, array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => 'professional-learning',
        ),
    ),
));

$school_course = learndash_user_get_enrolled_courses($currentUserID, array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => 'school-improvement',
        ),
    ),
));
?>

<div class="col-lg-4 col-md-4">
    <div class="library-container">
        <div class="d-flex justify-content-between align-items-center" id="library-header">
            <div style="font-weight: 700" class="">
                My Library
            </div>
            <div class="library-notifications">
                <div class="enroll-counter">
                    <span class="enroll-qty">
                        <?php echo $enroll_course_quantity;?>
                    </span>
                </div>
                <img style="width: 24px; height: 24px;" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/folder-favorite.png'?>" alt="folder-favorite">
            </div>
        </div>
    
        <div class="d-flex flex-row align-items-center" id="pills-your-library" role="tablist">
                <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 active" id="library-1-tab" data-bs-toggle="tab" href="#library-1" aria-controls="library-1" aria-selected="false" role="tab" tabindex="-1">
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
                        " class="tab-text">Curriculum (<?php echo count($curr_course);?>)</p>
                    </div>
                </div>
                <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100" id="library-2-tab" data-bs-toggle="tab" href="#library-2" aria-controls="library-2" aria-selected="false" role="tab" tabindex="-1">
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
                        " class="tab-text">Professional Learning (<?php echo count($pro_course);?>)</p>
                    </div>
                </div>
                <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100" id="library-3-tab" data-bs-toggle="tab" href="#library-3" aria-controls="library-3" aria-selected="false" role="tab" tabindex="-1">
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
                        " class="tab-text">School Improvement (<?php echo count($curr_course);?>)</p>
                    </div>
                </div>   
        </div>
        <div class="tab-content" id="pills-tabContent">
        <?php
            ?>
            <div class="tab-pane fade show active" id="library-1" role="tabpanel" aria-labelledby="library-1-tab">
                <div class="list-course">
                    <?php
                        get_template_part('new/library/empty');
                        foreach($curr_course as $course_id) {
                            get_template_part('new/library/curr-item', null, array('course_id' => $course_id));
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="library-2" role="tabpanel" aria-labelledby="library-2-tab">
                <div class="list-course">
                    <?php
                        get_template_part('new/library/empty');
                        foreach($pro_course as $course_id) {
                            get_template_part('new/library/pro-item', null, array('course_id' => $course_id));
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="library-3" role="tabpanel" aria-labelledby="library-3-tab">
                <div class="list-course">
                    <?php
                        get_template_part('new/library/empty');
                        foreach($school_course as $course_id) {
                            get_template_part('new/library/si-item', null, array('course_id' => $course_id));     
                        }
                    ?>
                </div>
            </div>
        </div>  
    </div>  
</div>