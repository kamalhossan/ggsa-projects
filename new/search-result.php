<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// if you want to load through ajax
// $id = $args['id'];
// $keyword = $args['keyword'];
// $parent_term_slug = $args['parent_term_slug'];
// $main_parent_tab_slug = $args['main_parent_tab_slug'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = sanitize_text_field($_POST['category_id']);
    $keyword = sanitize_text_field($_POST['s_program']);
    $parent_term_slug = sanitize_text_field($_POST['current_tab']);
    $main_parent_tab_slug = sanitize_text_field($_POST['main_parent_tab_slug']);
}

$main_parent_tab_name = str_replace('-', ' ', strtolower($main_parent_tab_slug));
$category_id = $id;
$terms = get_term_by('term_id', $category_id, 'ld_course_category');
$term_id = $terms -> term_id;
$term_name = $terms -> name;
$taxonomy = 'ld_course_category';

get_template_part('new/modal', null, array(
    'category_id' => $category_id,
    'category_name' => $term_name
));

$args = array(
    'post_type'			=>	'sfwd-courses',
    'post_status'		=>	'publish',
    'fields'			=>	'ids',
    'orderby'			=>	'title',
    'order'				=>	'ASC',
    'nopaging'			=>	true, 	// Turns OFF paging logic to get ALL courses
    'tax_query'         => array(
        array(
        'taxonomy' => $taxonomy,
        'field' => 'term_id',
        'terms' => $term_id,
        )
    ),
    's'                 => $keyword
  );
  $query = new WP_Query($args);
  $course_quantity = $query -> found_posts;

?>

<div class="mt-3 overflow-hidden">
    <div class="row align-items-center m-0">
        <div class="col term_name_qty">
          <h4 class="fw-bold text-nowrap" style="font-size: 20px; overflow: hidden; text-overflow: ellipsis;">
          <?php echo $term_name;?>
        </h4>
        </div>
        <div class="col ab-btn">
            <button class="btn-secondary" data-bs-toggle="modal"
                data-bs-target="#aboutModal-<?php echo $category_id?>">About</button>
        </div>
        <div class="col s-box d-flex p-0">
            <form method="post" class="search-program d-flex align-items-center w-100">
                <span>Search</span>
                <input type="hidden" id="category_id" name="category_id" value="<?php echo $category_id;?>">
                <input type="hidden" id="current_tab" name="current_tab" value="<?php echo $parent_term_slug;?>">
                <input type="hidden" id="main_parent_tab_slug" name="main_parent_tab_slug" value="<?php echo $main_parent_tab_slug;?>">
                <input type="text" class="form-control" placeholder="Search Program" id="s_program" name="s_program" value="<?php echo $keyword;?>"
                    aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default">
                    <button class="search-icon" type="submit">
                    <img src="<?echo get_stylesheet_directory_uri() . '/assets/svg/search.svg';?>" alt="Search Program">
                </button>
            </form>
        </div>
    </div>
</div>

<?php

echo '<div class="search-result mt-2 curriculum-table-container" id="accordion-for-' . $category_id . '">';
    $title = 'Search results for "' . $keyword . '" (' . $course_quantity . ')';
    ?>
    <div id="heading-<?php echo $term_id;?>" class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-4  w-align-btn">
            <div class="course_terms">
                <h4 data-toggle="tooltip" data-placement="top" title="<?php echo $title;?>" class="mb-0 pb-0" style="color: #4D4F4E; font-weight: 700;text-overflow: ellipsis;white-space: nowrap;font-size: 18px;"><?php  echo $title?></h4>
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
    <div id="collapse-<?php echo $term_id;?>" class="hidden-content block?>" aria-labelledby="heading-<?php echo $term_id;?>">
    <?php

    $counter = 0;
    if ($query->have_posts()) {


    echo '<div class="d-flex align-items-start curr_cour_desc">';
    echo '<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">';
    while($query-> have_posts()){
        $query->the_post();
        $category = get_the_terms(get_the_ID(), $taxonomy);
        $term_id = $category[0] -> term_id;
        $term_name = $category[0] -> name;
        $counter++;

        if ($counter == 1) {
            $active_class = 'active show';
        } else {
            $active_class = '';
        }
        $course_id = get_the_ID();
        $course_title = get_the_title($course_id);
        $features_image = get_the_post_thumbnail_url($course_id);

        if ( ! $features_image) {
            $features_image = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
        }
        ?>  
        <div class="lesson_list pro-learning">
            <div class="item-course">
                <div class="custom-form-check">
                    <input class="course_checked_id" name="<?php echo $course_id; ?>" type="checkbox" id="<?php echo $course_id; ?>">
                    <label for="<?php echo $course_id; ?>" class="plus-checkbox" data-toggle="tooltip" data-bs-placement="top" title="select"></label>
                </div>
                <div class="img-course">
                    <img src="<?php echo $features_image;?>" alt="<?php echo $course_id?>" class="link-img-course">
                </div>
                <div class="info-course">
                    <h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_title;?>">
                        <?php echo $course_title;?>
                    </h5>          
                </div>
                <div class="show-course">
                    <button class="btn-secondary <?php echo $active_class; ?> >" id="v-pills-<?php echo $course_id ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $course_id; ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $course_id; ?>" aria-selected="false">View Details</button>
                </div>
            </div>
        </div>
        <?php
    }
    echo '</div>';
    echo ' <div class="tab-content lessons" id="v-pills-tabContent">';
    wp_reset_postdata();

    $counterTwo = 0;
    while ($query->have_posts()) {
        $query->the_post();

        $counterTwo++;

        if ($counterTwo == 1) {
            $active_class = 'active show';
        } else {
            $active_class = '';
        }

        $course_id = get_the_ID();

        ?>

        <div class="tab-pane fade <?php echo $active_class ?>" id="v-pills-<?php echo $course_id; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $course_id; ?>-tab">
            <div class="course_summary lesson-<?php echo $course_id; ?>">
                <div class="course_highlight">
                <?php 
            
                if($main_parent_tab_name == "school improvement"){
                    get_template_part('new/pro-learning/si-summary-top', null, array(
                        'course_id' => $course_id
                    )); 
                } else {
                    get_template_part('new/pro-learning/summary-top', null, array(
                        'course_id' => $course_id
                    )); 
                }
                ?> 
                </div>
                <?php
                get_template_part('new/details-tab', null, array('course_id' => $course_id,'parent_id' =>  $term_id )) ?>
            </div>
        </div>
        <?php  
        }
    echo '</div>';
    echo '</div>';
    wp_reset_postdata();
    
} else {
    echo '<div class="align-items-start curr_cour_desc">';
    echo '<div class="py-3 hidden-content block">';
    echo 'Sorry, we couldn’t find a match for “' . $keyword . '”. Please try another search!';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
echo '</div>';