<?php
/* Template Name: Onboarding Principal */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( ! is_user_logged_in(  ) ){
  $redirect_to = esc_url( home_url($_SERVER['REQUEST_URI']) );
  wp_redirect( home_url( '/wp-login.php?redirect_to='.$redirect_to ) );
  exit;
}

session_start();

get_header();

$user_id = get_current_user_id();
$current_user = get_userdata($user_id);
$roles = $current_user -> roles;
$array_principal_role = array( 'principal', 'assistant_principal', 'deputy_principal', 'executive_principal', 'head_of_curriculum', 'head_of_department');
$result = array_intersect($array_principal_role, $roles);
if( !empty( $result ) ){
// if(in_array('principal', $roles)){
  $users  = get_user_in_team($user_id);

  if(!empty($users)) {
    get_template_part('template-parts/principal/layout');
  } else {
    get_template_part('template-parts/principal/header');
    get_template_part('template-parts/principal/choose');
  }

  wp_register_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', false );
  wp_register_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', false );
  wp_register_script( 'principal-js', get_stylesheet_directory_uri() . '/assets/js/principal.js', array( 'jquery' ) );

  wp_localize_script('principal-js', 'principal_object', array(
    'ajax_url' => admin_url( 'admin-ajax.php' ),
    'nonce' => wp_create_nonce('like-nonce'),
    'delegate_to_deputy_principal' => get_user_meta(get_current_user_id(), 'delegate_to_deputy_principal', true),
    'delegate_to_school_administrator' => get_user_meta(get_current_user_id(), 'delegate_to_school_administrator', true),
  ));

  wp_enqueue_style('bootstrap');
  wp_enqueue_style( 'principal', get_stylesheet_directory_uri() . '/assets/css/principal.css', [], null, false );
  wp_enqueue_script( 'bootstrap-js' );
  wp_enqueue_script( 'principal-js' );

} else {
  echo '<div class="container my-5">';
  echo 'You\'re not a principal, please ask your principal to give you permission to view this page';
  echo '</div>';
}

get_footer();