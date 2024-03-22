<?php

// $user_resource_limit = get_field('course_limit', 'Options');
$user_id = get_current_user_id();
$current_user = get_userdata($user_id);
$user_roles = $current_user -> roles;
$current_user_role = array_values($user_roles)[0];
  
// $resource_limit = 0;

// foreach($user_resource_limit as $user_limit){
//     $role_limit = $user_limit['role_limit'];
//     if($role_limit == $current_user_role){
//         $resource_limit = $user_limit['resource_limit'];
//     }
// }
$resource_limit = get_role_resource($user_id);

$enroll_course_quantity = count(learndash_user_get_enrolled_courses($user_id, array()));

$course_user_can_select =  $resource_limit - $enroll_course_quantity;
// removing negetive number
if($course_user_can_select < 0){
    $course_user_can_select = 0;
}

$enrolled_meta = get_user_meta( $user_id, 'onboarding_enroll_course_array', true );
if($enrolled_meta){
    $enroll_count = count($enrolled_meta);
} else {
    $enroll_count = 0;
}

$onboarding_user_can_select = $resource_limit - $enroll_count;

?>

<div class="mt-3 d-flex flex-row align-items-start mb-3 progress-status py-3">
    <div class="notice">
    <?php
    if(is_page('onboarding')){
        echo sprintf('You have selected <span class="onboarding_current_selection">%s</span>/<span class="res_quantity">%s</span> resources, you have <span class="course_to_go">%s</span> to go.You can choose them at your own convenience from <span style="font-weight: bold">GGSA Product Range</span>.<br>Click <span class="instruct">Add to Library</span> to complete your selection.', $enroll_count, $resource_limit, $onboarding_user_can_select);
     } else {
        if($resource_limit == 0){
            echo sprintf('You have enrolled to <span class="current_selection">%s</span> resources but you have access of <span class="res_quantity">%s</span> resource, you have <span class="course_to_go">%s</span> to go.<br>Please <span class="instruct">Contact Us</span> if you think this is a mistake.', $enroll_course_quantity, $resource_limit, $course_user_can_select);
        } else {
            echo sprintf('You have selected <span class="current_selection">%s</span>/<span class="res_quantity">%s</span> resources, you have <span class="course_to_go">%s</span> to go. You don’t have to choose all of them now.<br>Click <span class="instruct">Add to Library</span> to complete your selection.', $enroll_course_quantity, $resource_limit, $course_user_can_select);
        }
    }  ?>
    </div>
    <div class="action">
        <button id="add_to_library" type="button" class="btn btn-brand-primary" <?php if($resource_limit == 0 || $enroll_course_quantity == $resource_limit){echo 'disabled';}?>>Add to Library</button>
    </div>
</div>