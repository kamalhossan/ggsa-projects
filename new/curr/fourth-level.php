<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$parent_id = $args['term_id'];
$main_parent_name = $args['term_name'];

$terms = get_terms( array(
    'taxonomy'   => 'ld_course_category',
    'hide_empty' => true,
    'order' => 'ASC',
    'parent' => $parent_id,
    'depth' => 1,
  ) );

  $counter = 0;
  // counting total course number
  $cat_count = count($terms);

  if($cat_count > 0) {

    if($terms) { ?>


      <div class="d-flex flex-row align-items-center curr-course-year" id="nav-tab-<?php echo $parent_id ;?>" role="tablist">

      <?php foreach ($terms as $tax_term) {

        $term_id =  $tax_term->term_id; 
        
        $counter++;
    
        if (1 == $counter){
          $active_class = 'active';
       }
       else {
           $active_class = '';
       }

        $term_name =  $tax_term->name;
        $term_id =  $tax_term->term_id;

        get_template_part('new/tabs-nav', null, array(
          'term_name' => $term_name, 
          'term_slug' => 'course-' . $term_id,
          'active_class' => $active_class,
      ));


      } ?>
      </div>
      <div class="tab-content course-list" id="pills-course-list-tabContent">
      
      <?php

      $counter = 0;
      foreach ($terms as $tax_term) {
        
        $counter++;

        if (1 == $counter){
          $active_class = 'show active';
       }
       else {
           $active_class = '';
       }

        $term_id =  $tax_term->term_id; 

        $args = array(
          'post_type'			=>	'sfwd-courses',
          'post_status'		=>	'publish',
          'fields'			=>	'ids',
          'orderby'			=>	'title',
          'order'				=>	'ASC',
          'nopaging'			=>	true, 	// Turns OFF paging logic to get ALL courses
          'tax_query'         => array(
              array(
              'taxonomy' => 'ld_course_category',
              'field' => 'term_id',
              'terms' => $term_id,
              )
          )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $course_coutner = 0; ?>

          <div class="tab-pane <?php echo $active_class; ?>" id="course-<?php echo $term_id?>" role="tabpanel" aria-labelledby="pills-<?php echo $term_id?>-tab">
            <div class="d-flex align-items-start curr_cour_desc">
                <div class="nav flex-column nav-pills me-3" id="v-<?php echo get_the_ID();?>-tab" role="tablist" aria-orientation="vertical">
                <?php  while($query->have_posts()) {
                    $query->the_post(); $course_coutner++; ?>
                        
                            <?php
                                if ($course_coutner == 1) {       
                                    $active_class = 'active show';
                                }
                                else {
                                    $active_class = '';
                                }
                                $course_id = get_the_ID();
                            ?>
                            <div class="lesson_list curriculum">
                                <?php get_template_part('new/curr/item', null, array(
                                    'active_class' => $active_class,
                                    'course_id' => $course_id)
                                    );?>
                            </div>
                        
                    <?php }?>
                </div>
                <div class="tab-content lessons" id="v-pills-tabContent">
                  <?php
                      $content_counter = 0;
                      while($query->have_posts()) {
                      $query->the_post(); 
                      $content_counter++;
                      if(1 == $content_counter) {
                        $active_class = 'show active';
                      } else {
                        $active_class = '';
                      }

                      $course_id = get_the_ID();
                      ?>
                          <div class="tab-pane fade<?php echo $active_class;?>" id="v-pills-course-summary-<?php echo $course_id; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $course_id; ?>-tab">
                            <div class="course_summary course-<?php echo $course_id; ?>">
                                <div class="course_highlight">
                                <?php get_template_part('new/curr/summary-top', null, array(
                                    'active_class' => $active_class,
                                    'course_id' => $course_id,
                                    'term_id' =>  $parent_id
                                    ));?>
                                </div>
                                <?php get_template_part('new/details-tab', null, array(
                                  'course_id' => $course_id,
                                  'parent_id' =>  $parent_id
                                )) ?>
                            </div>
                        </div>
                  <?php } ?>      
                </div>
            </div>
          </div>
        <?php }
      }
      ?>
      </div>
      <?php
    }
  } else {
    echo 'No "Year Level" found for this category, please assign the course to the correct Year Level';
  }