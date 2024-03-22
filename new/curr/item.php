<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$course_id = $args['course_id'];
$active_class = $args['active_class'];
$post_id = 'course-summary-' . $course_id;

$features_image = get_the_post_thumbnail_url($course_id);
$course_title = get_the_title($course_id);

if ( empty($features_image)){
    $url =  get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
    $imgEl = '<img src="'. $url .'" alt="'. $course_title .'" class="link-img-course">';
  } else {
    $imgEl = get_the_post_thumbnail( $course_id, 'course-thumb', array( 'loading' => 'lazy', 'class' => 'link-img-course', 'alt' => $course_title ) );
}

?>

<div class="item-course <?php echo $course_id?>">
    <div class="custom-form-check">
        <input class="course_checked_id" name="<?php echo $course_id; ?>" type="checkbox" id="<?php echo $course_id; ?>">
        <label for="<?php echo $course_id; ?>" class="plus-checkbox" data-toggle="tooltip" data-bs-placement="top" title="select"></label>
    </div>
    <div class="img-course">
        <?php echo $imgEl?>
    </div>
    <div class="info-course">
        <h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_title;?>">
			<?php echo $course_title;?>
		</h5>          
    </div>
    <div class="show-course">
        <button class="btn-secondary <?php echo $active_class; ?>" id="v-pills-<?php echo $post_id ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $post_id; ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $course_id; ?>" aria-selected="false">View Details</button>
        </div>
</div>
