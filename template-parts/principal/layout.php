<!-- Nav tabs
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="principal-tab" data-bs-toggle="tab" data-bs-target="#principal" type="button" role="tab" aria-controls="principal" aria-selected="true">principal</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="choose-tab" data-bs-toggle="tab" data-bs-target="#choose" type="button" role="tab" aria-controls="choose" aria-selected="false">choose</button>
  </li>
</ul> -->

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
        <div style="width: 15%;" class="text-center">
            <ul class="nav nav-tabs" id="principal-flow-tabs" role="tablist">
                <button class="btn btn-primary active d-none" id="principal-tab" data-bs-toggle="tab" data-bs-target="#principal" type="button" role="tab" aria-controls="principal" aria-selected="true"></button>
                <button class="btn btn-primary" id="choose-tab" data-bs-toggle="tab" data-bs-target="#choose" type="button" role="tab" aria-controls="choose" aria-selected="false">Click next to Continue</button>
            </ul>
        </div>
    </div>
</div>


<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="principal" role="tabpanel" aria-labelledby="principal-tab">
    <?php get_template_part('template-parts/principal/content'); ?>
    </div>
  <div class="tab-pane" id="choose" role="tabpanel" aria-labelledby="choose-tab">
     <?php get_template_part('template-parts/principal/choose');?>
    </div>
</div>
