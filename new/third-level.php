<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$parent_id = $args['term_id'];
$parent_term_slug = $args['term_slug'];
$parent_term_name = $args['parent_term_name'];
$main_parent_name = $args['main_parent_name'];

// getting all the third level category by 2nd level terms
$terms = get_terms( array(
    'taxonomy'   => 'ld_course_category',
    'hide_empty' => true,
    'order' => 'ASC',
    'parent' => $parent_id, 
    'depth' => 1,
  ) );

    $counter = 0;
  // counting total course number
  $course_count = count($terms);

  if($course_count > 0) {
    get_template_part('new/course-quantity', null, array(
      'term_name' => $parent_term_name,
      'course_quantity' => $course_count,
      'category_id' => $parent_id,
      'parent_term_slug' => $parent_term_slug,
      'main_parent_tab' => $main_parent_name
    ));

    // if we found sub cateogry and course associated
    if($terms) {
      echo '<div class="result_course_list">';
      foreach ($terms as $tax_term) {
        $counter++;
        if($counter == 1) {
          $open_accordion = 'block';
        } else {
          $open_accordion = 'hidden';
        }

        $term_name =  $tax_term->name;
        $term_id =  $tax_term->term_id;
        $term_slug = $tax_term -> slug;
        // we are using accordion for 3rd level course
        // 3rd level category also main course category to load them
        echo '<div class="mt-2 curriculum-table-container" id="accordion-for-' . $parent_id . '">';
        ?>

        <div id="heading-<?php echo $term_id;?>" class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-4  w-align-btn">
                <div class="course_terms">
                  <h4 data-toggle="tooltip" data-placement="top" title="<?php echo $term_name;?>" class="mb-0 pb-0" style="color: #4D4F4E; font-weight: 700;text-overflow: ellipsis;white-space: nowrap;font-size: 18px;"><?php  echo $term_name?></h4>
                </div>
                <div style="padding-right: 1rem;" class="text-end">
                    <button class="btn-secondary" style="width: 120px;" data-bs-toggle="modal" data-bs-target="#aboutModal-<?php echo $term_id?>">About</button>
                </div>
            </div>
            <div class="arrow" style="transform: rotate(0deg);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                    <path d="M19.9201 9.45001L13.4001 15.97C12.6301 16.74 11.3701 16.74 10.6001 15.97L4.08008 9.45001" stroke="#7A7B7A" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
        </div>
        <div id="collapse-<?php echo $term_id;?>" class="hidden-content <?php echo $open_accordion . ' ' . $term_slug ;?>" aria-labelledby="heading-<?php echo $term_id;?>">
            <?php 
            // loading fourth level for curriculum
            if ($main_parent_name == 'Curriculum') {
              get_template_part('new/curr/fourth-level', null, array(
                'term_id' => $term_id,
                'term_name' => $term_name));
            } else {
                get_template_part('new/pro-learning/category-course', null, array(
                  'term_id' => $term_id,
                  'term_name' => $term_name,
                  'main_parent_name' => $main_parent_name
                ));
            }
            ?>
            <?php  ?>
        </div>
        <?php 
        echo '</div>';

        get_template_part('new/modal', null, array(
          'category_id' => $term_id,
          'category_name' => $term_name
        ));
      }
     }
     echo '</div>';
  } else {
    if($main_parent_name == 'School Improvement'){
      get_template_part( 'new/si-second-level-course', null, array(
        'id' => $parent_id,
        'parent_term_slug' => $parent_term_slug
      ));
    } else {
      echo 'No "Course Category" found for this category, please create category under this and assign course to it';
    }
  }