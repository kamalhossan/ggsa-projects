<div class="mt-5">

</div>

<?php

get_template_part('template-parts/resources/resource', 'Resource');

// $taxonomy = 'ld_course_category';
// $tax_terms = get_terms($taxonomy, array('hide_empty' => false));

$terms = get_terms( array(
    'taxonomy'   => 'ld_course_category',
    'hide_empty' => false,
    'order' => 'ASC',
    'parent' => 0
) );

?>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
<?php
$navCounter = 0;
foreach ($terms as $tax_term) {  
  $navCounter++;
  $termName =  $tax_term->name; 
  $termNameOld = $termName;
  
  if($termName == 'Arts, Materials and Technologies') {
    $termName = 'arts';
  } else if ($termName == 'Humanities and Social Sciences') {
    $termName = 'Humanities';
  }
  
  ?>
  <li class="nav-item" role="presentation">
      <button class="nav-link <?php if($navCounter == 1) {echo 'active';}?>" id="pills-<?php echo strtolower($termName);?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo strtolower($termName);?>" type="button" role="tab" aria-controls="pills-<?php echo strtolower($termName);?>" aria-selected="true"><?php if($termNameOld) { echo $termNameOld; } else {echo $termName;}?></button>
  </li>
    <?php
    // echo '<li>' . '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name.'</a></li>';

    // echo '<pre>';
    // var_dump($tax_term);  
    // echo '</pre>';
} ?>
</ul>

<div class="tab-content" id="pills-tabContent">
  <?php
  $counter = 0;
  foreach ($terms as $tax_term) { 
    $counter++; 

    $termID = $tax_term -> term_id;
    $termName =  $tax_term->name; 
    $termNameOld = $termName;
    
    if($termName == 'Arts, Materials and Technologies') {
      $termName = 'arts';
    } else if ($termName == 'Humanities and Social Sciences') {
      $termName = 'Humanities';
    }
    ?> 
      <div class="tab-pane fade <?php if($counter == 1) { echo 'show active';} ?>" id="pills-<?php echo strtolower($termName);?>" role="tabpanel" aria-labelledby="pills-<?php echo strtolower($termName);?>-tab">
        <?php get_template_part( 'template-parts/courses/getCourseList', null, array('term_id' => $termID, 'term_name' => $termNameOld) );
        ?>
      </div>
  <?php }
  ?>
</div>





