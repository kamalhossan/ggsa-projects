<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Getting all the informatinos about the current user
$current_user = wp_get_current_user();
$username = $current_user->user_login;

$first_name = get_user_meta($current_user->ID, 'first_name', true);
$last_name = get_user_meta($current_user->ID, 'last_name', true);

if ($first_name || $last_name) {
    $name = $first_name . ' ' . $last_name;
} else {
    $name = $username;
}

?>        
<div class="main-background h-auto py-3">
    <div class="d-flex flex-row align-items-center p-3">
        <div class="w-25 text-center">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.svg';?>" alt="Main Logo">
        </div>
        <div class="flex-fill">
            <h2 id="onboarding-header" class="text-brand-navy font-calibri h2-custom fw-bold mb-0 pb-0">Welcome <span style="color: #FAA332"><?php echo $name;?></span>, Let's get you onboard!</h2>
        </div>
        <div style="width: 10%;" class="text-center">
            <button id="prinComBtn" class="btn btn-primary">Complete</button>
        </div>
    </div>
</div>
