<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$category_id = $args['category_id'];
$category_description = term_description( $category_id);

$category_name = $args['category_name'];

$add_category_description_url = get_site_url() . '/wp-admin/term.php?taxonomy=ld_course_category&tag_ID=' . $category_id;

?>
<div class="modal fade" id="aboutModal-<?php echo $category_id?>" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModal-<?php echo $category_id;?>"><?php echo $category_name;?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                if($category_description) {
                    echo $category_description;
                } else {
                    echo 'Please add descriptions for this category from 
                    <a target="_blank" href="' . $add_category_description_url . '">Here</a>';
                }
                 ;?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary w-100" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>