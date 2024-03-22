<?php

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) )
        exit;

	/**
	 * Template Name: Single SFWD Topic
	 */

    if( ! is_user_logged_in(  ) ){
        auth_redirect();
        exit;
    }

    $current_user = wp_get_current_user();
    $username = $current_user->user_login;
    $user_id = $current_user->ID;
    $avatar = get_avatar( $user_id );
    $user_roles = $current_user->roles;
    $role_name = '';

    // if(  !(get_user_meta( $user_id, 'ggsa_onboarding_courses_added' ) == true) ) {
    //     wp_redirect( home_url( 'onboarding' ) );
    //     exit;
    // }

    session_start();

    get_header();


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
        <div class="container m-0 p-0 w-100 mw-100 overflow-hidden">
            <div class="row justify-content-center">
                <div class="col col-lg-2 left-siderbar bg-[#ebf9fd] no-padding">
                    <?php get_template_part('template-parts/user' , 'nav',$data); ?>
                </div>
                <div class="col col-lg-10 center-siderbar bg-[#F6F6F6] no-padding">
                    <!--                    -->
                    <?php get_template_part('template-parts/topic', 'detail' , $data);?>
                    <?php //get_template_part('template-parts/user-middle'); ?>
                </div>


            </div>
        </div>
    </div>
    <?php
    
    $post_id = get_the_ID();
    $course_id = learndash_get_course_id( $post_id );
    $parent_term = get_course_parent_term_name_by_course_id($course_id );

    if($parent_term == 'Professional Learning'){
        $tour_meta = get_user_meta( $user_id, 'ggsa_pl_topic_tour_meta', true );
        if($tour_meta){
            $class = 'tour-complete';
        } else {
            $class = 'start-tour';
        }
        get_template_part('template-parts/user-tour', null, array('class' => $class, 'type' => 'pl'));
    } else {
        $tour_meta = get_user_meta( $user_id, 'ggsa_topic_tour_meta', true );
        if($tour_meta){
            $class = 'tour-complete';
        } else {
            $class = 'start-tour';
        }
        get_template_part('template-parts/user-tour', null, array('class' => $class));
    }

   	wp_enqueue_style( 'jquery-ui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', false );
	wp_enqueue_style( 'multiselect-style', get_stylesheet_directory_uri() . '/assets/css/jquery.multiselect.css', false );

	wp_register_style( 'bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', false );

	wp_register_style( 'topic-detail', get_stylesheet_directory_uri() . '/assets/css/topic-detail.css', [] );
	wp_register_style( 'user-myaccount', get_stylesheet_directory_uri() . '/assets/css/myaccount.css', false );
	wp_register_style( 'user-slick', get_stylesheet_directory_uri() . '/assets/css/slick.css', false );


	wp_register_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', false );
	wp_register_script( 'topic-detail-js', get_stylesheet_directory_uri() . '/assets/js/topic-detail.js', false );
	wp_register_script( 'user-slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', false ); 



   wp_enqueue_style( 'bootstrap' );
   wp_enqueue_style( 'topic-detail' );
   wp_enqueue_style( 'user-slick' );
   wp_enqueue_style('simple-bar' , get_stylesheet_directory_uri() . '/assets/css/simplebar.css', [] );

  

   wp_enqueue_script( 'bootstrap-js' );
   
   wp_enqueue_script( 'user-slick-js' );
   wp_enqueue_script( 'simple-bar-js', get_stylesheet_directory_uri() . '/assets/js/simplebar.min.js',[] ,'' ,false);
   wp_enqueue_script( 'topic-detail-js' );
   wp_localize_script( 'topic-detail-js', 'ld_object',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce('like-nonce'),
            'topic_id' => get_the_ID()
        )
    );
   wp_localize_script( 'user-dashboard-js', 'aj_object',
		array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'user_id' => $user_id,
			'security' => wp_create_nonce( 'school_upload' ),
		)
	);
    get_footer();
?>