<?php

if ( !defined( 'ABSPATH' ) ) exit;

/* Template Name: Peer Forum Topics */

// if( ! is_user_logged_in(  ) ){
//     $redirect_to = esc_url( home_url($_SERVER['REQUEST_URI']) );
//     wp_redirect( home_url( '/wp-login.php?redirect_to='.$redirect_to ) );
//     exit;
// }

get_header();

$current_user = wp_get_current_user();
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar( $user_id );
$user_roles = $current_user->roles;
$role_name = '';
if ( ! empty( $user_roles ) ) {
    $role = get_role( $user_roles[0] );
    $role_name = $role->name;
}
$data = [
    'user_id' => $user_id, 
    'current_user' => $current_user, 
    'role_name'  => $role_name,

];
?>
<div class="page-wrap">
    <div class="container">
        <div class="row">
            <div class="col col-lg-2 left-siderbar">
                <?php get_template_part('template-parts/user' , 'nav',$data); ?>
            </div>
            <div class="col col-lg-10 center-siderbar bg-[#f6f6f6]">
            <div class="forum-page mt-2">
                <?php get_template_part( 'template-parts/forum', 'peer-list', $data); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

// $tour_meta = get_user_meta( $user_id, 'ggsa_product_range_tour', true );
// if(!$tour_meta){
//     $class = 'start-tour';
// }
// get_template_part('template-parts/user-tour', null, array('class' => $class));

wp_register_style( 'school-forum', get_stylesheet_directory_uri() . '/assets/css/school-forum.css', false );
wp_register_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', false );
wp_register_style( 'user-dashboard', get_stylesheet_directory_uri() . '/assets/css/dashboard.css', [] );
wp_register_script( 'school-forum-js', get_stylesheet_directory_uri() . '/assets/js/school-forum.js', false );
wp_register_script( 'user-dashboard-js', get_stylesheet_directory_uri() . '/assets/js/dashboard.js', false );

wp_enqueue_style( 'bootstrap' );
wp_enqueue_style( 'user-dashboard' );
wp_enqueue_style( 'school-forum' );
wp_enqueue_script( 'school-forum-js' );
wp_enqueue_script( 'user-dashboard-js' );
wp_localize_script( 'user-dashboard-js', 'aj_object',
    array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'user_id' => $user_id
    )
);
get_footer();
?>