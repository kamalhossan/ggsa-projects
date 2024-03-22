<?php
$course_populars = get_popular_course();
$professional_populars = get_popular_unit_course();
$taxonomy = 'ld_course_category';
$c_slug = 'curriculum';

$current_user = $args['current_user'];
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar($user_id);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];

$state = get_user_meta($user_id, 'state', true);
if( !$state ){
    $state = 0;
}

$courses_enrolled = learndash_user_get_enrolled_courses($user_id);
//query all enrolled course curriculum
$slug = 'curriculum';
$args = array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
      array(
        'taxonomy' => 'ld_course_category',
        'field' => 'slug',
        'terms' => $slug
      ),
    ),
  );
$curriculum_enrolled = learndash_user_get_enrolled_courses($user_id , $args);
$curriculum_arr['selected_units'] = [];
$curriculum_arr['next_units'] = [];
foreach( $curriculum_enrolled as $curriculum_id ){
   
    // $recommend = get_post_meta( $curriculum_id, 'recommend', true );
    $recommends = get_field( 'recommend', $curriculum_id );
    if( $recommends ){
        foreach( $recommends as $r) {
               if (            
                ( $r["state"] == "" && $r["role"] == "" ) ||  
                ( $r['state'] == $state && $r["role"] == "" )  ||  
                ( $r['state'] == "" && $r["role"] == $role_name  )  || 
                ( $r['state'] == $state && $r["role"] == $role_name  )
                ){
                // no require for state and role
                if( is_array ($r['selected_units']) ){
                    $curriculum_arr['selected_units'] = array_merge($curriculum_arr['selected_units'] , $r['selected_units']);
                }
                if( is_array ($r['next_units']) ){
                    $curriculum_arr['next_units'] = array_merge($curriculum_arr['next_units'] , $r['next_units']);
                }
               }
        }
    }

}
$curriculum_arr['selected_units'] = array_unique( $curriculum_arr['selected_units']);
$curriculum_arr['next_units'] = array_unique( $curriculum_arr['next_units']);

//query all enrolled course professional
$slug = 'professional-learning';
$args = array(
    'post_type' => 'sfwd-courses',
    'tax_query' => array(
      array(
        'taxonomy' => 'ld_course_category',
        'field' => 'slug',
        'terms' => $slug
      ),
    ),
  );
$professional_enrolled = learndash_user_get_enrolled_courses($user_id , $args);
$professional_arr = [] ;
$professional_arr['recommend_next'] = [];
$professional_arr['recommend_practice'] = [];
$professional_arr['recommend_card'] = [];
foreach( $professional_enrolled as $professional_id ) {
    // $recommend = get_post_meta( $curriculum_id, 'recommend', true );
    $recommends = get_field( 'course_recommend', $professional_id );

    
    if( $recommends ){
        
        foreach( $recommends as $r) {
               if (            
                ( $r["state"] == "" && $r["role"] == "" ) ||  
                ( $r['state'] == $state && $r["role"] == "" )  ||  
                ( $r['state'] == "" && $r["role"] == $role_name  )  || 
                ( $r['state'] == $state && $r["role"] == $role_name  )
                ){
                // no require for state and role
                // $professional_arr[] = $r;
               
                if( is_array( $r['recommend_next']) ){
                    $professional_arr['recommend_next'] = array_merge($professional_arr['recommend_next'] , $r['recommend_next']);
                }
                if( is_array( $r['recommend_practice']) ){
                $professional_arr['recommend_practice'] = array_merge($professional_arr['recommend_practice'] , $r['recommend_practice']);
            }
            
                if( is_array( $r['recommend_card']) ){
                    
                $professional_arr['recommend_card'] = array_merge($professional_arr['recommend_card'] , $r['recommend_card']);
                
            }
               }
        }
    }
}

?>
<div class="ss-sidebar">
    <div class="access-resources">
        <div class="ss-resources">
            <div class="title-resources">
                <div class="text-resources title-main">GGSA Product Range</div>
                <div class="resource-viewall">
                    <a href="#">Access to more GGSA resources
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.43 5.92993L20.5 11.9999L14.43 18.0699M3.5 11.9999H20.33" stroke="#FAA332" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
                <div class="link-views hidden">
                    <a href="<?php echo home_url('/resources') ; ?>">View all</a>
                </div>
            </div>

            <form class="ss-search hidden">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M11 20C15.9706 20 20 15.9706 20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20Z"
                            stroke="#9D9D9D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 22L18 18" stroke="#9D9D9D" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Seach..." class="item-search">
            </form>
        </div>
        <!-- <section class="mt-4 p-4 bg-[#FEF4D5] rounded-lg my-library-section">
            
            <ul class="flex items-start justify-between gap-2 mt-3" >
                <li class="card-item flex">
                    <img src="abc" > <span>Curriculum </span> 
                </li>
                <li><img src="abc" > <span>Curriculum </span> </li>
                <li></li>

            </ul>
        </section> -->
        <div id="tabCourse" class="ss-my-library">
            <ul class="flex courses-banner">
                <li class="mb-2"><a href="<?php echo home_url('/resources/?tab=curriculum'); ?>" target="_blank"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Curriculum.jpg"> <span>Curriculum </span> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/arrow-right.svg" alt=""> </a></li>
                <li class="mb-2"><a href="<?php echo home_url('/resources/?tab=professional-learning'); ?>" target="_blank"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Professional-Learning.jpg"><span>Professional Learning </span><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/arrow-right.svg" alt=""></a></li>
                <li class="mb-2"><a href="<?php echo home_url('/resources/?tab=school-improvement'); ?>" target="_blank"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/School-Improvement.jpg"> <span>School Improvement</span> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/arrow-right.svg" alt=""></a></li>
            </ul>
        </div>
    </div>
    <section class="section-recommend">
    <?php 
        $slider_post_per_page = 12;
        $c_num = 4;
        $class = 'rs-curriculum active ';
        $c_type = 'c';
        $p_type = 'p';
        $s_type = 's';
        $c_slug = 'curriculum';
        $p_slug = 'professional-learning';
        $s_slug = 'school-improvement';
        ?>
            <header class="flex justify-between mt-4">
            <h3 class="text-xl font-bold">Units Recommended for You</h3>
            </header>
            <?php 
           

           

            $block_arr = array(
                'header' => 'Next Units',
                'slider_post_per_page' => 12,
                'slider_number'    => 4,
                'class'         => $class ,
                'type'          => $c_type
            );
            if( ! empty( $curriculum_arr['next_units']  )) {
                block_slider_recommend( $curriculum_arr['next_units']  , $block_arr );
                // block_slider( $curriculum_args , $block_arr );
            }
            $curriculum_args = array(
                'post_type' => 'sfwd-courses',
                'posts_per_page' => 12 ,
                'order' => 'DESC',
                'orderby' => 'date',
                // 'post__not_in' => $courses_enrolled,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'ld_course_category',
                        'field' => 'slug',
                        'terms' => $c_slug
                    ),
                ),
            );
            $block_arr = array(
                'header' => 'Popular Units',
                'slider_post_per_page' => 12,
                'slider_number'    => 4,
                'class'         => $class,
                'type'          => $c_type
            );
            block_slider_popular( $professional_populars , $curriculum_args, $c_slug , $block_arr ); 
        

        
        if( empty( $professional_arr['recommend_practice'] ) && empty(  $professional_arr['recommend_card']  ) ){

        }
        else{
            ?>
            <header class="flex justify-between mt-4">
            <h3 class="text-xl font-bold">Modules Recommended for You</h3>
            </header>
            <?php 
            
            $block_arr = array(
                'header' => 'Professional Learning for Selected Units',
                'slider_post_per_page' => 9,
                'slider_number'    => 3,
                'class'         => $class ,
                'type'          => $p_type
            );
            if( ! empty( $curriculum_arr['selected_units']  )) {
                block_slider_recommend( $curriculum_arr['selected_units']  , $block_arr );
            }

            $block_arr = array(
                'header' => 'Supplementary Practices',
                'slider_post_per_page' => 9,
                'slider_number'    => 3,
                'class'         => $class,
                'type'          => $p_type
            );
            if (  !empty (  $professional_arr['recommend_practice']  )){
                block_slider_recommend( $professional_arr['recommend_practice']  , $block_arr );
            }
            
            // block_slider( $curriculum_args , $block_arr );
            
            
            $block_arr = array(
                'header' => 'Practice Cards and Posters',
                'slider_post_per_page' => 9,
                'slider_number'    => 3,
                'class'         => $class,
                'type'          => $p_type
            );
            if( ! empty ( $professional_arr['recommend_card']  ) ){
                block_slider_recommend( $professional_arr['recommend_card']  , $block_arr );
            }
           
            // block_slider( $curriculum_args , $block_arr );
        }
        ?>
        
        <?php 
        $curriculum_args = array(
            'post_type' => 'sfwd-courses',
            'posts_per_page' => 12,
            'order' => 'DESC',
            'orderby' => 'date',
            // 'post__not_in' => $courses_enrolled,
            'tax_query' => array(
                array(
                    'taxonomy' => 'ld_course_category',
                    'field' => 'slug',
                    'terms' => $p_slug
                ),
            ),
        );
        $block_arr = array(
            'header' => 'Popular Modules',
            'slider_post_per_page' => 9,
            'slider_number'    => 3,
            'class'         => $class,
            'type'          => $p_type
        );
        block_slider_popular( $course_populars , $curriculum_args, $p_slug , $block_arr ); 


        
    ?>

          
    </section>
    

</div>