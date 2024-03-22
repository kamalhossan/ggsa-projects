<?php
	// Exit if accessed directly
if( !defined('ABSPATH')) exit; ?>
 
<div class="col-lg-8 col-md-8">

<?php
// getting top level course category 
// top level cateogry should be 1. Curriculum , 2. Professional Learning 3. School Improvement
$terms = get_terms( array(
    'taxonomy'   => 'ld_course_category',
    'hide_empty' => true,
    'order' => 'ASC',
    'parent' => 0,
) ); 

// if user perform search getting the active parent tab 
$query_parent_tab = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $query_parent_tab = $_POST['main_parent_tab_slug'];
}

// we are using bootstrap nav tab for top level tabs
echo '<div class="d-flex first-level flex-row align-items-center" id="nav-tab" role="tablist">';

$nav_counter = 0;
// looping through the parent terms to get the 2nd level /sub cateogories
foreach ($terms as $tax_term) {
  $nav_counter++;
  $term_name =  $tax_term->name;
  $term_slug =  $tax_term->slug;
  $term_id =  $tax_term->term_id; 

  // checking user is doing search query else regular tabs will open
  if($query_parent_tab){
    if($term_slug == $query_parent_tab){
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

  get_template_part('new/tabs-nav', null, array('term_name' => $term_name, 'term_slug' => $term_slug, 'active_class' => $active_class));
  
}

echo '</div>'; 

// current progress of an user
get_template_part('new/status');

// tabs content for each terms
echo '<div class="tab-content" id="pills-main-tab">';
    $div_counter = 0;
    foreach ($terms as $tax_term) {
      $div_counter++;
      $term_slug =  $tax_term->slug;
      $term_name =  $tax_term->name;
      $term_id =  $tax_term->term_id;

      // checking user is doing search query else regular tabs content will open
      if($query_parent_tab){
        if($term_slug == $query_parent_tab){
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
      ?>
      <div class="tab-pane fade <?php echo $active_class;?>" id="<?php echo $term_slug;?>" role="tabpanel" aria-labelledby="pills-<?php echo $term_slug?>-tab">
      <?php
          get_template_part( 'new/second-level', null, array(
            'term_id' => $term_id,
            'term_name' => $term_name
          ));
        ?>
      </div>
      <?php 
    } 
  echo '</div>';  ?>
</div>