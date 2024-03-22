<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$term_name = $args['term_name'];
$parent_term_slug = $args['parent_term_slug'];
$course_quantity = $args['course_quantity'];
$category_id = $args['category_id'];
$main_parent_tab = $args['main_parent_tab'];

$main_parent_tab_slug = str_replace(' ', '-', strtolower($main_parent_tab));

get_template_part('new/modal', null, array(
    'category_id' => $category_id,
    'category_name' => $term_name
));

$keyword_value = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['category_id'];

    if($category_id == $id){
        $keyword_value = $_POST['s_program'];
    }
}


if($main_parent_tab_slug == 'curriculum'){
    $placeholder = 'Search Program';
} else {
    $placeholder = 'Search Modules';
}

?>

<div class="mt-3 overflow-hidden">
    <div class="row align-items-center m-0">
        <div class="col term_name_qty">
          <h4 class="fw-bold text-nowrap" style="font-size: 20px; overflow: hidden; text-overflow: ellipsis;"><?php echo $term_name . ' (' . $course_quantity . ')';?></h4>
        </div>
        <div class="col ab-btn">
            <button class="btn-secondary" data-bs-toggle="modal"
                data-bs-target="#aboutModal-<?php echo $category_id?>">About</button>
        </div>
        <div class="col s-box d-flex p-0">
            <form method="post" class="search-program d-flex align-items-center w-100">
                <span class="mr-2">Search</span>
                <input type="hidden" id="category_id" name="category_id" value="<?php echo $category_id;?>">
                <input type="hidden" id="current_tab" name="current_tab" value="<?php echo $parent_term_slug;?>">
                <input type="hidden" id="main_parent_tab_slug" name="main_parent_tab_slug" value="<?php echo $main_parent_tab_slug;?>">
                <input type="text" class="form-control" placeholder="<?php echo $placeholder;?>" id="s_program" name="s_program" value="<?php echo $keyword_value;?>"
                    aria-label="Sizing example input"
                    aria-describedby="inputGroup-sizing-default">
                <button class="search-icon" type="submit">
                    <img src="<?echo get_stylesheet_directory_uri() . '/assets/svg/search.svg';?>" alt="Search Program">
                </button>
            </form>
        </div>
    </div>
</div>
