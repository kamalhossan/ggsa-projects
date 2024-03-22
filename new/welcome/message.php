<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$theme_url = get_stylesheet_directory_uri();

$child_theme = get_stylesheet_directory_uri();

// Getting all the informatinos about the current user
$user = wp_get_current_user();

$user_resource_limit = get_field('course_limit', 'Options');
$user_id = get_current_user_id();
$current_user = get_userdata($user_id);
$user_roles = $current_user -> roles;
$current_user_role = array_values($user_roles)[0];

$resource_limit = 0;

foreach($user_resource_limit as $user_limit){
    $role_limit = $user_limit['role_limit'];
    if($role_limit == $current_user_role){
        $resource_limit = $user_limit['resource_limit'];
        $meta_key = 'onboarding_course_limit';
        $check_meta = get_user_meta( $user_id, $meta_key, true );
        if(!$check_meta){
            add_user_meta($user_id, $meta_key, $resource_limit);
          }
    }
}

$userDisplayName =  $user -> display_name . ', ';

// cehcking if user doing a search query or not
$active_tab = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $active_tab = true;
}

?>        
<div class="main-background h-auto pt-3">
    <div class="d-flex flex-row align-items-center p-3">
        <div class="w-25 text-center">
            <img src="<?php echo $theme_url . '/assets/img/logo.svg';?>" alt="Main Logo">
        </div>
        <div class="flex-fill">
            <h2 id="onboarding-header" class="text-brand-navy font-calibri h2-custom fw-bold">Resources</h2>
            <p class="onboarding-header-body step-one">
                Choose up to <span class="total-resouce"><?php echo $resource_limit;?> </span> resources from <span class="fw-bold" style="color: #FAA332">5000+</span> quality resources at any time.
            </p>
            <p class="onboarding-header-body step-two">
                Choose up to <span class="total-resouce"><?php echo $resource_limit;?> </span> resources at any time.
            </p>
            <div class="nav nav-pills welcome-circle-nav">
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php if(! $active_tab){ echo 'active';} ?> circle-nav" id="pills-welcome-content" data-bs-toggle="pill" data-bs-target="#pills-welcome" type="button" role="tab" aria-controls="pills-welcome" aria-selected="true"></a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php if($active_tab){ echo 'active';} ?>  circle-nav" id="pills-onboarding-content" data-bs-toggle="pill" data-bs-target="#pills-onboarding" type="button" role="tab" aria-controls="pills-onboarding" aria-selected="true"></a>
            </li>
                <!-- <img id="step1Circle" src="<?php // echo $theme_url . '/assets/img/circle-inactive.svg';?>" alt="circle 1">
                <img id="step2Circle" src="<?php // echo $theme_url . '/assets/img/circle-active.svg';?>" alt="circle 2"> -->
            </div>
        </div>
        <div style="width: 10%;" class="text-center">
            <!-- <button id="completeButton" data-bs-toggle="pill" data-bs-target="#pills-onboarding" class="btn-primary">Next</button> -->
                <?php if(! $active_tab){ ?>
                    <button id="nextButton" class="btn btn-brand-primary">Next</button>
                    <button id="completeButton" class="btn btn-brand-primary">Complete</button>
                <?php } else { ?>
                    <button id="nextButton" class="btn btn-brand-primary d-non">Next</button>
                    <button id="completeButton" class="btn btn-brand-primary d-blk">Complete</button>
                <?php }
                ?>
        </div>
    </div>
</div>