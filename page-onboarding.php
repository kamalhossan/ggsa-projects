<?php
/* Template Name: Onboarding */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( ! is_user_logged_in(  ) ){
  $redirect_to = esc_url( home_url($_SERVER['REQUEST_URI']) );
  wp_redirect( home_url( '/wp-login.php?redirect_to='.$redirect_to ) );
  exit;
}

$user_id = get_current_user_id();
$current_user = get_userdata($user_id);
$current_user_role = $current_user -> roles;

// user role to consider
// if they have below roles they will be able to goto onboarding page
// without these role none of the user can goto onboarding page
$onbaording_users = array(
  'teacher',
  'teaching_assistant',
  'instruction_coach',
  'principal', 
  'administrator',
  'editor',
);

// checking user roles has access or not
if(array_intersect($current_user_role, $onbaording_users )){

  // checking onboarding complete or not
  if (get_user_meta($user_id, 'ggsa_onboarding_courses_added', true) == true) {
    wp_redirect(home_url('dashboard'));
    exit; 
  } else {

    get_header();

    get_template_part('new/welcome/message'); 
    
    $active_tab = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $active_tab = true;
    }
    ?>
    <div class="tab-content" id="welcome-screen-tabContent">
      <div class="tab-pane fade <?php if(! $active_tab){ echo 'show active';} ?>" id="pills-welcome" role="tabpanel" aria-labelledby="pills-home-tab">
        <?php get_template_part('new/welcome/content'); ?>
      </div>
      <div class="tab-pane fade <?php if($active_tab){ echo 'show active';} ?>" id="pills-onboarding" role="tabpanel" aria-labelledby="pills-onboarding-content">
          <section id="course_content" class="mt-5 mb-5">
          <div class="onboarding-body bg-white px-150">
            <div class="row">
              <?php get_template_part( 'new/onboarding-tabs');?>
              <?php get_template_part( 'new/library/onboarding-your-library');?>
              <?php get_template_part( 'new/limit-modal');?>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php
    wp_register_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', false );
    wp_register_style( 'onboarding', get_stylesheet_directory_uri() . '/assets/css/onboarding.css', false );	
    wp_register_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', false );
    wp_register_script( 'onboarding-js', get_stylesheet_directory_uri() . '/assets/js/onboarding.js', array( 'jquery' ) );
      
    wp_localize_script( 'onboarding-js', 'onboarding_object', 
      array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce('like-nonce')
      ));	
      
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'onboarding' );
    wp_enqueue_script( 'bootstrap-js' );
    wp_enqueue_script( 'onboarding-js' );
    
    get_footer();
  }
} else {
  update_user_meta($user_id, 'ggsa_onboarding_courses_added', true);
  wp_redirect(home_url('dashboard'));
  exit; 
}