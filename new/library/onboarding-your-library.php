<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$library_tabs = array('Curriculum', 'Professional learning', 'School Improvement');
$tabs_counter = 0;

$user_id = get_current_user_id();

$enroll_course_array = get_user_meta( $user_id, 'onboarding_enroll_course_array', true );

// $enroll_course_quantity = count(learndash_user_get_enrolled_courses($user_id, array()));
$enrolled_meta = get_user_meta( $user_id, 'onboarding_enroll_course_array', true );

if($enrolled_meta){
    $enroll_course_quantity = count($enrolled_meta);
} else {
    $enroll_course_quantity = 0;
}

$curr_course = array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => 'curriculum',
        ),
    ),
    'post__in' => $enroll_course_array
);

$curriculum_query = new WP_Query( $curr_course );
$curriculum_query_posts = $curriculum_query->found_posts;
wp_reset_query();

$pro_course = array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => 'professional-learning',
        ),
    ),
    'post__in' => $enroll_course_array
);

$professional_query = new WP_Query( $pro_course );
$professional_query_posts = $professional_query->found_posts;
wp_reset_query();

$si_course = array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => 'school-improvement',
        ),
    ),
    'post__in' => $enroll_course_array
);

$si_query = new WP_Query( $si_course );
$si_query_posts = $si_query->found_posts;
wp_reset_query();

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
            <?php
                foreach($library_tabs as $tabs) {
                    
                    $tabs_counter++;

                    $tabs_nav_id = 'library-' . $tabs_counter;

                    if ($tabs_counter === 1) {
                        $active_class = 'active';
                    } else {
                        $active_class = '';
                    } 
                    get_template_part('new/tabs-nav', null, array('term_name' => $tabs, 'term_slug' => $tabs_nav_id, 'active_class' => $active_class));
                }
            ?>
        </div>
        <div class="tab-content" id="pills-tabContent">
        <?php
            ?>
            <div class="tab-pane fade show active" id="library-1" role="tabpanel" aria-labelledby="library-1-tab">
                <div class="list-course">
                    <?php
                        if($enroll_course_array){
                            if($curriculum_query->have_posts()){
                                while($curriculum_query->have_posts()){
                                    $curriculum_query-> the_post();
                                    $course_id = get_the_ID();
                                    get_template_part('new/library/curr-item', null, array('course_id' => $course_id));
                                }
                            } else {
                                get_template_part('new/library/empty');
                            }
                        } else {
                            get_template_part('new/library/empty');
                        }
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="library-2" role="tabpanel" aria-labelledby="library-2-tab">
                <div class="list-course">
                    <?php
                        if($enroll_course_array){
                            if($professional_query->have_posts()){
                                while($professional_query->have_posts()){
                                    $professional_query-> the_post();
                                    $course_id = get_the_ID();
                                    get_template_part('new/library/pro-item', null, array('course_id' => $course_id));
                                }
                            } else {
                                get_template_part('new/library/empty');
                            }
                        }else {
                            get_template_part('new/library/empty');
                        }
                        
                    ?>
                </div>
            </div>
            <div class="tab-pane fade" id="library-3" role="tabpanel" aria-labelledby="library-3-tab">
                <div class="list-course">
                    <?php
                        if($enroll_course_array){
                            if($si_query->have_posts()){
                                while($si_query->have_posts()){
                                    $si_query-> the_post();
                                    $course_id = get_the_ID();
                                    get_template_part('new/library/si-item', null, array('course_id' => $course_id));
                                }
                            } else {
                                get_template_part('new/library/empty');
                            }
                        } else {
                            get_template_part('new/library/empty');
                        }
                    ?>
                </div>
            </div>
        </div>  
    </div>  
</div>