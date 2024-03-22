<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


$enroll_course_array =  $args['course_array'];
$keyword =  $args['keyword'];


$library_tabs = array('Curriculum', 'Professional learning', 'School Improvement');
$tabs_counter = 0;

$curr_course = array(
    'post_type' => 'sfwd-courses',
    'posts_per_page' => -1,
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
    'posts_per_page' => -1,
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
    'posts_per_page' => -1,
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


<div class="suggestion-container">
    <div class="d-flex" id="suggestion-header">
        <h6 class="suggestion-quantity" style="font-weight: 700"><?php echo count($enroll_course_array)?> resources found for "<?php echo $keyword?>"</h6>
    </div>

    <div class="d-flex flex-row align-items-center" id="pills-resource-library" role="tablist">
        <?php
            foreach($library_tabs as $tabs) {
            
                $tabs_counter++;
                $tabs_nav_id = 'library-' . $tabs_counter;

                if ($tabs_counter === 1) {
                    $active_class = 'active';
                } else {
                    $active_class = '';
                } 
                if($tabs == 'Curriculum'){
                    $tabs .= ' (' . $curriculum_query_posts . ')';
                } else if($tabs == 'Professional learning'){
                    $tabs .= ' (' . $professional_query_posts . ')';
                } else {
                    $tabs .= ' (' . $si_query_posts . ')';
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
                    if($curriculum_query->have_posts()){
                        while($curriculum_query->have_posts()){
                            $curriculum_query-> the_post();
                            $course_id = get_the_ID();
                            get_template_part('new/library/curr-item', null, array('course_id' => $course_id));
                        }
                    } else {
                        // get_template_part('new/library/empty');
                        echo '<div class="empty-library">';
                        echo '<h4 class="empty-title">There are no results found in Curriculum</h4>';
                        echo '</div>';
                    }  
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="library-2" role="tabpanel" aria-labelledby="library-2-tab">
            <div class="list-course">
                <?php
                    if($professional_query->have_posts()){
                        while($professional_query->have_posts()){
                            $professional_query-> the_post();
                            $course_id = get_the_ID();
                            get_template_part('new/library/pro-item', null, array('course_id' => $course_id));
                        }
                    } else {
                        // get_template_part('new/library/empty');
                        echo '<div class="empty-library">';
                        echo '<h4 class="empty-title">There are no results found in Professional Learning</h4>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="library-3" role="tabpanel" aria-labelledby="library-3-tab">
            <div class="list-course">
                <?php
                    if($si_query->have_posts()){
                        while($si_query->have_posts()){
                            $si_query-> the_post();
                            $course_id = get_the_ID();
                            get_template_part('new/library/si-item', null, array('course_id' => $course_id));
                        }
                    } else {
                        // get_template_part('new/library/empty');
                        echo '<div class="empty-library">';
                        echo '<h4 class="empty-title">There are no results found in School Improvement</h4>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>  
</div>  
