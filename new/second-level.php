<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$parent_id = $args['term_id'];
$main_parent_name = $args['term_name'];

// getting all the 2nd level category by the parent terms
$terms = get_terms( array(
    'taxonomy'   => 'ld_course_category',
    'hide_empty' => true,
    'order' => 'ASC',
    'parent' => $parent_id,
    'depth' => 1,
  ) ); 

  $data = array(
    'parent_name' => $main_parent_name
  );

  $parent_slug = str_replace(' ', '-', strtolower($main_parent_name));

  // checking if user doing a search query or not
  $query_current_tab = '';
  $query_parent_tab = '';
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $query_current_tab = $_POST['current_tab'];
    $query_parent_tab = $_POST['main_parent_tab_slug'];
  }
  ?>
  
  <?php

  // if we found category then we will move to the third category
  if ($terms) { ?>
        <div class="d-flex flex-row second-level align-items-center" id="pills-<?php echo $parent_id;?>" role="tablist">
        <?php
        $nav_counter = 0;

        foreach ($terms as $tax_term) {

          $nav_counter++;

          if ($nav_counter == 1) {
            $active_class = 'active';
          } else {
            $active_class ='';
          }

          $term_name =  $tax_term->name;
          $term_slug =  $tax_term->slug;
          $term_id =  $tax_term->term_id;

           // checking if user doing a search query or not
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($parent_slug == $query_parent_tab){
              if($query_current_tab == $term_slug){
                $active_class = 'active';
              } else {
                $active_class ='';
              }
            } else {
              if($parent_slug == 'curriculum') {
                if ($term_slug == 'childhood') {
                  $active_class = 'active';
                } else {
                  $active_class ='';
                }
              } else {
                if ($nav_counter == 1) {
                  $active_class = 'active';
                } else {
                  $active_class ='';
                }
              }
            }
          } else {
            if($parent_slug == 'curriculum') {
              if ($term_slug == 'childhood') {
                $active_class = 'active';
              } else {
                $active_class ='';
              }
            } else {
              if ($nav_counter == 1) {
                $active_class = 'active';
              } else {
                $active_class ='';
              }
            }
          }
          
          $order = 8;

          // we are customizing the navs and content order as requirement
          // if matching the terms we are changing the order for curriculum only
          if($term_slug == 'childhood'){
            $order = 1;
          } else if ($term_slug == 'english'){
            $order = 2;
          } else if ($term_slug == 'mathematics'){
            $order = 3;
          }  else if ($term_slug == 'science'){
            $order = 4;
          } else if ($term_slug == 'arts-materials-and-technologies'){
            $order = 5;
          } else if ($term_slug == 'the-arts-dance-drama-and-media-arts'){
            $order = 6;
          } else if ($term_slug == 'humanities-and-social-sciences'){
            $order = 7;
          } else {
            $order++;
          }

          get_template_part('new/tabs-nav', null, array(
            'term_name' => $term_name,
            'term_slug' => $term_slug,
            'active_class' => $active_class,
            'order' => $order
          ));
        }

        echo '</div>'; ?>

        <div class="tab-content" id="<?php echo $parent_id; ?>">

        <?php

        $div_counter = 0;
          foreach ($terms as $tax_term) {
            $div_counter++;

            $term_name = $tax_term -> name;
            $term_slug =  $tax_term->slug;
            $term_id =  $tax_term->term_id;

             // checking if user doing a search query or not
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
              if($parent_slug == $query_parent_tab){
                if($query_current_tab == $term_slug){
                  $active_class = 'show active';
                } else {
                  $active_class ='';
                }
              } else {
                if($parent_slug == 'curriculum') {
                  if ($term_slug == 'childhood') {
                    $active_class = 'show active';
                  } else {
                    $active_class ='';
                  }
                } else {
                  if ($div_counter == 1) {
                    $active_class = 'show active';
                  } else {
                    $active_class ='';
                  }
                }
              }
            } else {
              if($parent_slug == 'curriculum') {
                if ($term_slug == 'childhood') {
                  $active_class = 'show active';
                } else {
                  $active_class ='';
                }
              } else {
                if ($div_counter == 1) {
                  $active_class = 'show active';
                } else {
                  $active_class ='';
                }
              }
            }
             // checking if user doing a search query or not
             // if user performing search query then we are loading search result template
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
              if($query_current_tab == $term_slug){ ?>
                <div class="tab-pane fade <?php echo $active_class;?>" id="<?php echo $term_slug;?>" role="tabpanel" aria-labelledby="pills-<?php echo $term_slug?>-tab">
                    <?php get_template_part( 'new/search-result'); ?>
                </div>
              <?php } else {
              ?>
              <div class="tab-pane fade <?php echo $active_class;?>" id="<?php echo $term_slug;?>" role="tabpanel" aria-labelledby="pills-<?php echo $term_slug?>-tab">
                  <?php
                  get_template_part( 'new/third-level', null, array(
                    'term_id' => $term_id,
                    'main_parent_name' =>  $main_parent_name,
                    'parent_term_name' => $term_name,
                    'term_slug' => $term_slug
                    ));
                    ?>
              </div>
              <?php }
            } else {
              ?>
              <div class="tab-pane fade <?php echo $active_class;?>" id="<?php echo $term_slug;?>" role="tabpanel" aria-labelledby="pills-<?php echo $term_slug?>-tab">
                  <?php
                  get_template_part( 'new/third-level', null, array(
                    'term_id' => $term_id,
                    'main_parent_name' =>  $main_parent_name,
                    'parent_term_name' => $term_name,
                    'term_slug' => $term_slug
                    ));
                    ?>
              </div>
              <?php
            }
          }
        ?>
        </div>
  <?php } else {
      echo 'No Category associated to ' . $main_parent_name . '<br>';
      echo 'Or category dont have any course and lesson please add them following the design structure';
  }