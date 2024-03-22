<?php

$current_user = $args['current_user'];
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar($user_id);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];
$query_courses = [];

$school_image1 = get_user_meta($user_id, 'school_image1', true );
$school_image2 = get_user_meta($user_id, 'school_image2', true );
$school_image3 = get_user_meta($user_id, 'school_image3', true );

/* curriculum total post */
$c_slug = 'curriculum';
$curriculum_args = array(
  'post_type' => 'sfwd-courses',
  'tax_query' => array(
    array(
      'taxonomy' => 'ld_course_category',
      'field' => 'slug',
      'terms' => $c_slug
    ),
  ),
);

$curriculum_query = new WP_Query($curriculum_args);
$curriculum_query_posts = $curriculum_query->found_posts;
wp_reset_query();


/* professional total post */

$p_slug = 'professional-learning';
$pro_args = array(
  'post_type' => 'sfwd-courses',
  'tax_query' => array(
    array(
      'taxonomy' => 'ld_course_category',
      'field' => 'slug',
      'terms' => $p_slug
    ),
  ),
);

$pro_query = new WP_Query($pro_args);
$pro_query_posts = $pro_query->found_posts;
wp_reset_query();

/* professional total post */
$s_slug = 'school-improvement';
$school_args = array(
  'post_type' => 'sfwd-courses',
  'tax_query' => array(
    array(
      'taxonomy' => 'ld_course_category',
      'field' => 'slug',
      'terms' => $s_slug,
    ),
  ),
);

$school_query = new WP_Query($school_args);
$school_query_posts = $school_query->found_posts;
wp_reset_query();


$curriculum_course_enrolled = learndash_user_get_enrolled_courses($user_id, $curriculum_args);
$pro_course_enrolled = learndash_user_get_enrolled_courses($user_id, $pro_args);
$school_course_enrolled = learndash_user_get_enrolled_courses($user_id, $school_args);


$user_notifications = user_get_notification($user_id);

$library_per_page = 5;

?>
<main class="px-6 py-8 bg-[#F6F6F6]">
  <header class="flex justify-between items-center">
    <div class="d-flex gap-4 items-center">
      <h1 class="text-[40px] text-[#161C24] font-bold p-0 m-0">My School Box</h1>
      <button id="tour-popup" class="btn btn-primary dashboard">Begin Tour</button>
      <!-- <button id="close-tour" class="btn btn-primary close">Close Tour</button> -->
    </div>
    <div class=" relative flex items-center justify-center w-10 h-10 bg-white rounded-full">
      <div class="icon-notification">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/notification.svg" alt="" />
        <span
          class="absolute top-0 right-0 transform translate-x-2 -translate-y-1.5 flex items-center justify-center w-[19px] h-[18px] text-xs text-white font-bold bg-orange rounded-full">
          <?php echo $user_notifications['total_unread']; ?>
        </span>
      </div>
      <div class="notification  right-0 top-12 absolute bg-white" style="z-index:9999">
        <header class="flex justify-between p-3">
          <h4 class="text-xl font-bold">Notification</h4>
          <span class="cursor-pointer close-button"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M18 6L6 18" stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M6 6L18 18" stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>

        </header>
        <ul class="">
          <?php
          foreach ($user_notifications['data'] as $nt) {
            ?>
            <li class="msg-<?php echo $nt['read'] ?> msg pt-2 pb-2 pl-4 pr-4" data-entry="<?php echo $nt['ID'] ?>">
              <div class="ml-3 mgs-wraper">
                <div class="top-nt flex justify-between ">
                <strong>
                  <?php echo $nt['action'] ?>
                </strong>
                <span>
                  <?php echo $nt['time'] ?>
                </span>
              </div>
                <div class="bot-nt mt-2">
                  <?php echo $nt['msg']; ?>
                </div>
              </div>
            </li>
          <?php

          }

          ?>
          <li><button class="p-3 mark-read ">Mark all as Read</button></li>
        </ul>
      </div>
    </div>
  </header>

  <section class="mt-6">
    <ul class="flex justify-between gap-6 school_logo  items-center">
      <?php 
        if( $school_image1 ){
          // update_user_meta($user_id , 'school_image1' , $attachment_id );
          $image_data = wp_get_attachment_image_src( $school_image1, 'school-logo' );
          $image_url = $image_data[0];
          $hidden_logo = '';
          $hidden_upload = 'hidden';
        }
        else{
          $hidden_logo = 'hidden';
          $hidden_upload = '';
          $image_url = '';
        }
          ?>
          <li class="s-logo <?php echo $hidden_logo ?> " >
            
            <img class=" m-auto rounded-lg" src="<?php echo $image_url; ?>" >
            <a href="#" class="delete-logo" data-id="school_image1" data-attach="<?php echo $school_image1 ?>" title="delete"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/delete.svg"></a>
            
          </li>
       
        <li class="s-logo text-sm  border border-[#86868D] border-dashed rounded-lg cursor-pointer <?php echo $hidden_upload ?>">
          <label for="school_image1"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/gallery-add.svg" target alt="" />
          <span>Insert your school logo here</span>
          <span>File format .jpg, .jpeg, .png, <= 300KB and minimum size 300x300 pixels.</span>
          </label>
          
          <form class="form" role="form" id="attachform" enctype="multipart/form-data">
            <input type="file" name="school_image1" id="school_image1" class=" school_upload hidden" accept=".jpg, .png, .jpeg">
            
          </form>
        </li>
         <?php 
        if( $school_image2 ){
          // update_user_meta($user_id , 'school_image1' , $attachment_id );
          $image_data = wp_get_attachment_image_src( $school_image2, 'school-image' );
          $image_url = $image_data[0];
          $hidden_logo = '';
          $hidden_upload = 'hidden';
        }
        else{
          $hidden_logo = 'hidden';
          $hidden_upload = '';
          $image_url = '';
        }
          ?>
          <li class="w-[397px]  <?php echo $hidden_logo ?>" ><img class=" h-[222px] m-auto rounded-lg" src="<?php echo $image_url; ?>" >
          <a href="#" class="delete-logo" data-attach="<?php echo $school_image2 ?>" data-id="school_image2" title="delete"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/delete.svg"></a>
          </li>
          
        <li class="w-[397px] school-banner-1 flex flex-col items-center justify-center gap-2 w-[222px] h-[222px] text-sm bg-white border border-[#86868D] border-dashed rounded-lg cursor-pointer <?php echo $hidden_upload ?>">
          <label for="school_image2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/gallery-add.svg" target alt="" />
          <span>Insert your school image here</span>
          <span>File format .jpg, .jpeg, .png, <= 300KB and minimum size 395x222 pixels.</span>
          </label>
          <form class="form" role="form" id="attachform" enctype="multipart/form-data">
            <input type="file" name="school_image2" id="school_image2" class=" school_upload hidden" accept=".jpg, .png, .jpeg">
            
          </form>
        </li>
          <?php
       
        if( $school_image3 ){
          // update_user_meta($user_id , 'school_image1' , $attachment_id );
          $image_data = wp_get_attachment_image_src( $school_image3, 'school-image' );
          $image_url = $image_data[0];
          $hidden_logo = '';
          $hidden_upload = 'hidden';
        }
        else{
          $hidden_logo = 'hidden';
          $hidden_upload = '';
          $image_url = '';
        }
          ?>
          <li class="w-[397px]  <?php echo $hidden_logo ?>" ><img class=" h-[222px] m-auto rounded-lg" src="<?php echo $image_url; ?>" >
          <a href="#" class="delete-logo" data-id="school_image3" data-attach="<?php echo $school_image3 ?>" title="delete"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/delete.svg"></a>
        </li>
        
        <li class="w-[397px] school-banner-2 flex flex-col items-center justify-center gap-2 w-[222px] h-[222px] text-sm bg-white border border-[#86868D] border-dashed rounded-lg cursor-pointer <?php echo $hidden_upload ?>">
          <label for="school_image3"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/gallery-add.svg" target alt="" />
          <span>Insert your school image here</span>
          <span>File format .jpg, .jpeg, .png, <= 300KB and minimum size 395x222 pixels.</span>
          </label>
          <form class="form" role="form" id="attachform" enctype="multipart/form-data">
            <input type="file" name="school_image3" id="school_image3" class=" school_upload hidden" accept=".jpg, .png, .jpeg">
            
          </form>
        </li>
          
      <!--
        
        <li class="flex flex-col items-center justify-center gap-2 w-[397px] h-[222px] text-sm bg-white border border-[#86868D] border-dashed rounded-lg cursor-pointer">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/gallery-add.svg" alt="" />
          Insert your school image here
        </li>
        <li class="flex flex-col items-center justify-center gap-2 w-[397px] h-[222px] text-sm bg-white border border-[#86868D] border-dashed rounded-lg cursor-pointer">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/gallery-add.svg" alt="" />
          Insert your school image here
        </li>
     

      <li class="w-[222px] flex">
        <img class="w-[150px] m-auto"  src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/your-school-logo.png"
          alt="" />
      </li>
      <li class="w-[397px]">
        <img class="w-[395px]" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/your-school-image1.png"
          alt="" />
      </li>
      
      <li class="w-[397px]">
        <img class="w-[395px]" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/your-school-image2.png"
          alt="" />
      </li>
       -->
    </ul>
  </section>
  <div class="flex flex-container">
    <div class="flex-2 col-lg-8">
      <!-- my professional record -->
      <section class="mt-6 my-professional-record-section p-3  rounded-lg bg-white ">
        <header class="flex justify-between">
          <h3 class="text-xl font-bold">My Professional Record</h3>
          <a class="text-[#4d4f4e]" href="<?php echo home_url('my-library') ?>"><span class="cursor-pointer view-all">View all</span></a>
        </header>
        <div class="block-content ">
          
          <?php
        
          
          $courses = learndash_user_get_enrolled_courses($user_id , $pro_args);
          $course_complete = 0;
          $complete_course = [];
          if ( $courses) {

            $courses = implode(',', $courses);
            $query_courses = $wpdb->get_results(
              $wpdb->prepare('SELECT * FROM ' . esc_sql(LDLMS_DB::get_table_name('user_activity')) . ' WHERE activity_type=%s AND  activity_completed <> 0 AND user_id = %d  AND course_id IN (' . $courses . ')  ORDER BY activity_id, activity_started ASC LIMIT 4', 'course', $user_id)
            );
           
            if (($query_courses)) {
              ?>
              <header class="flex ">
                <div class="fr-col fr-4">Modules</div>
                <div class="fr-col ">Score</div>
                <div class="fr-col hidden">Score</div>
                <div class="fr-col">Date</div>
              </header>
              <?php
              foreach ($query_courses as $course) {

                if (get_post_thumbnail_id($course->post_id)) {
                  $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($course->post_id), 'thumbnail-cover-landscape')[0];
                } else {
                  $thumbnail_url = get_stylesheet_directory_uri() . '/assets/img/pro-img.jpg';
                }
                ?>
                <div class="flex">
                  <div class="fr-col fr-4 courseid-<?php echo $course->post_id ?>">
                    <div class="course-thumbnail">
                      <a href="<?php echo get_permalink($course->post_id); ?>">


                        <img src="<?php echo $thumbnail_url ?>" class="w-[50px] h-[28px] rounded">
                      </a>
                    </div>
                    <div class="course-title">
                      <a href="<?php echo get_permalink($course->post_id); ?>">
                        <strong>
                          <?php echo get_the_title($course->post_id) ?>
                        </strong>
                      </a>
                    </div>

                  </div>
                  <div class="fr-col ">
                    <?php
                    $time_text = convert_time($course->activity_completed - $course->activity_started);
                    // echo $time_text; 
                    echo "100/100";
                    ?>
                  </div>
                  <div class="fr-col hidden">
                    <?php
                    // var_dump(learndash_get_course_quiz_list ($course->post_id ,$user_id ));
                    
                    // $points = learndash_get_user_course_points($user_id, $course->post_id);
                    // $points = learndash_get_user_quiz_points($user_id, 175);
                    // echo $points;
                    $time_text = convert_time($course->activity_completed - $course->activity_started);
                    //echo $time_text; ?>
                  </div>
                  <div class="fr-col">
                    <?php echo date('d/m/Y', $course->activity_completed); ?>
                  </div>
                </div>
              <?php



              }
               
              $complete_course = wp_list_pluck($query_courses, 'post_id');
             
            } else {
              ?>
              <div class="flex justify-center">
                
                <?php get_template_part('new/library/empty-professional'); ?>
              </div>
              
            <?php
            }

          } else {
            ?>
            <div class="flex justify-center">
            <?php get_template_part('new/library/empty-professional'); ?>
            </div>
          <?php
          }
          ?>

        </div>

      </section>
      <section class="mt-4 p-3 bg-[#FEF4D5] rounded-lg my-library-section">
        <header class="flex justify-between">
        <div class="">  
        <h3 class="text-orange text-xl font-bold">My Library</h3>
        <p>My resources from the GGSA Product Range</p>
        </div>
          <a class="text-[#4d4f4e]" href="<?php echo home_url('my-library') ?>"><span class="cursor-pointer view-all">View all</span></a>
        </header>

        <ul class="flex items-start justify-between gap-2 mt-3" style="display:none!important">
          <li class="flex items-center pr-2 bg-white rounded-lg">
            <div class="inline-flex items-center justify-center overflow-hidden rounded-full">
              <svg class="w-12 h-12 -rotate-90">
                <!--
                  circumference: 24 * 2 * Math.PI // 150.79644737231007
                  stroke-dasharray = 18 * 2 * Math.PI // 113.09733552923255
                  stroke-dashoffset = circumference - percent / 100 * circumference // 
                -->
                <circle class="text-[#EDEDED]" stroke-width="5" stroke="currentColor" fill="transparent" r="18" cx="24"
                  cy="24" />
                <circle class="text-standard" stroke-width="5" stroke-dasharray="113.09733552923255"
                  stroke-dashoffset="37.32212072464674" stroke-linecap="round" stroke="currentColor" fill="transparent"
                  r="18" cx="24" cy="24" />
              </svg>
              <span class="absolute text-xs">67%</span>
            </div>
            Curriculum in progress
          </li>
          <li class="flex items-center pr-2 bg-white rounded-lg">
            <div class="inline-flex items-center justify-center overflow-hidden rounded-full">
              <svg class="w-12 h-12 -rotate-90">
                <!--
                  circumference: 24 * 2 * Math.PI // 150.79644737231007
                  stroke-dasharray = 18 * 2 * Math.PI // 113.09733552923255
                  stroke-dashoffset = circumference - percent / 100 * circumference // 
                -->
                <circle class="text-[#EDEDED]" stroke-width="5" stroke="currentColor" fill="transparent" r="18" cx="24"
                  cy="24" />
                <circle class="text-yellow" stroke-width="5" stroke-dasharray="113.09733552923255"
                  stroke-dashoffset="37.32212072464674" stroke-linecap="round" stroke="currentColor" fill="transparent"
                  r="18" cx="24" cy="24" />
              </svg>
              <span class="absolute text-xs">67%</span>
            </div>
            Professional Learning in progress
          </li>
          <li class="flex items-center pr-2 bg-white rounded-lg">
            <div class="inline-flex items-center justify-center overflow-hidden rounded-full">
              <svg class="w-12 h-12 -rotate-90">
                <!--
                  circumference: 24 * 2 * Math.PI // 150.79644737231007
                  stroke-dasharray = 18 * 2 * Math.PI // 113.09733552923255
                  stroke-dashoffset = circumference - percent / 100 * circumference // 
                -->
                <circle class="text-[#EDEDED]" stroke-width="5" stroke="currentColor" fill="transparent" r="18" cx="24"
                  cy="24" />
                <circle class="text-green" stroke-width="5" stroke-dasharray="113.09733552923255"
                  stroke-dashoffset="37.32212072464674" stroke-linecap="round" stroke="currentColor" fill="transparent"
                  r="18" cx="24" cy="24" />
              </svg>
              <span class="absolute text-xs">67%</span>
            </div>
            School Improvement in progress
          </li>
        </ul>

        <!-- Tab menu items -->
        <ul class="mt-2.5 inline-flex border-b border-navy my-library-tab">
          <li data-tab-key="#curriculum" class="tab-key relative flex items-center justify-center">
            <svg width="218" height="40" viewBox="0 0 227 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g filter="url(#filter0_d_6252_1662)">
                <path
                  d="M226 39H3C8.24493 31.4494 20.1146 14.7507 24.1606 9.47189C28.5012 3.80862 32.0216 3.00002 36.3622 3H189.105C196.918 3 199.956 5.83146 202.127 8.66292L226 39Z"
                  fill="currentColor" />
              </g>
              <defs>
                <filter id="filter0_d_6252_1662" x="0" y="0" width="227" height="40" filterUnits="userSpaceOnUse"
                  color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix" />
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                    result="hardAlpha" />
                  <feOffset dx="-1" dy="-1" />
                  <feGaussianBlur stdDeviation="1" />
                  <feComposite in2="hardAlpha" operator="out" />
                  <feColorMatrix type="matrix"
                    values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0" />
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6252_1662" />
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6252_1662" result="shape" />
                </filter>
              </defs>
            </svg>
            <span class="absolute">Curriculum (<?php echo count($curriculum_course_enrolled); ?>)
            </span>
          </li>
          <li data-tab-key="#professional-learning" class="tab-key relative -ml-4 flex items-center justify-center">
            <svg width="218" height="40" viewBox="0 0 228 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g filter="url(#filter0_d_6252_1806)">
                <path
                  d="M226.666 39H3.66602C8.91095 31.4494 20.7806 14.7507 24.8266 9.47189C29.1672 3.80862 32.6876 3.00002 37.0282 3H189.771C197.584 3 200.622 5.83146 202.793 8.66292L226.666 39Z"
                  fill="currentColor" />
              </g>
              <defs>
                <filter id="filter0_d_6252_1806" x="0.666016" y="0" width="227" height="40" filterUnits="userSpaceOnUse"
                  color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix" />
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                    result="hardAlpha" />
                  <feOffset dx="-1" dy="-1" />
                  <feGaussianBlur stdDeviation="1" />
                  <feComposite in2="hardAlpha" operator="out" />
                  <feColorMatrix type="matrix"
                    values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0" />
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6252_1806" />
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6252_1806" result="shape" />
                </filter>
              </defs>
            </svg>
            <span class="absolute">Professional Learning (<?php echo (count($pro_course_enrolled) - count($query_courses)) ; ?>)
            </span>
          </li>
          <li data-tab-key="#school-improvement"
            class="tab-key relative -ml-4 flex items-center justify-center text-[#7A7B7A]">
            <svg width="218" height="40" viewBox="0 0 228 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g filter="url(#filter0_d_6252_1806)">
                <path
                  d="M226.666 39H3.66602C8.91095 31.4494 20.7806 14.7507 24.8266 9.47189C29.1672 3.80862 32.6876 3.00002 37.0282 3H189.771C197.584 3 200.622 5.83146 202.793 8.66292L226.666 39Z"
                  fill="currentColor" />
              </g>
              <defs>
                <filter id="filter0_d_6252_1806" x="0.666016" y="0" width="227" height="40" filterUnits="userSpaceOnUse"
                  color-interpolation-filters="sRGB">
                  <feFlood flood-opacity="0" result="BackgroundImageFix" />
                  <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                    result="hardAlpha" />
                  <feOffset dx="-1" dy="-1" />
                  <feGaussianBlur stdDeviation="1" />
                  <feComposite in2="hardAlpha" operator="out" />
                  <feColorMatrix type="matrix"
                    values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0" />
                  <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6252_1806" />
                  <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6252_1806" result="shape" />
                </filter>
              </defs>
            </svg>
            <span class="absolute">School Improvement (<?php echo count($school_course_enrolled); ?>)
            </span>
          </li>
        </ul>

        <!-- Tab menu contents -->
        <!-- Curriculum content -->
        <ul id="curriculum" class="tab-content gap-2 mt-1">

          <?php
          if ( $curriculum_course_enrolled) {
            $o = 0;
            
            foreach ($curriculum_course_enrolled as  $course_id) {
              if( !in_array( $course_id , $complete_course) )   {
                // course_content_process($course_id, $user_id);
                curriculumn_course($course_id , $user_id );

                $o++ ;
                
                if( $o >= $library_per_page ){
                  break;
                }
              }
            }
          } else {
            ?>
            <li class="flex gap-3 p-2 bg-transparent rounded-lg justify-center items-center" style="min-height:382px">
              <?php get_template_part('new/library/empty'); ?>
            </li>
            <?php
          }
          ?>

        </ul>

        <!-- Professional Learning content -->
        <ul id="professional-learning" class="tab-content gap-2 mt-1">
          <?php
          if ($pro_course_enrolled) {
            $o = 0;
            foreach ($pro_course_enrolled as $course_id) {

              if( !in_array( $course_id , $complete_course) )   {
                professional_course($course_id, $user_id);
                $o++ ;
                if( $o >= $library_per_page ){
                  break;
                }
              }
            }
          } else {
            ?>
            <li class="flex gap-3 p-2 bg-transparent rounded-lg justify-center items-center" style="min-height:382px">
              <?php get_template_part('new/library/empty'); ?>
            </li>
            <?php
          }
          ?>
        </ul>

        <!-- School Improvement content -->
        <ul id="school-improvement" class="tab-content gap-2 mt-1">
          <?php
          if( $school_course_enrolled ){
          $o = 0;
            foreach ($school_course_enrolled as $course_id) {

              if( !in_array( $course_id , $complete_course) )   {
                
                schoolimprove_course($course_id, $user_id);
                $o++ ;
                if( $o >= $library_per_page ){
                  break;
                }
              }
            }
          }
          else {
            ?>
            <li class="flex gap-3 p-2 bg-transparent rounded-lg justify-center items-center" style="min-height:382px">
              <?php get_template_part('new/library/empty'); ?>
            </li>
            <?php
          }
          
          ?>
        </ul>
      </section>
    </div>
    <div class="flex-1 col-lg-4">
      <!-- Our school -->
      <section class="mt-6 our-school-section p-3  rounded-lg bg-white ">
        <header class="flex justify-between">
          <h3 class="text-xl font-bold">Our School</h3>
        </header>
        <div class="our-shool scroll-bar">


          <ul class="our-school-list">
            <?php
            $user_team = get_user_in_team($user_id);
            get_team_activity($user_team);
            ?>
          </ul>
        </div>
      </section>
      <section class="mt-6 news-section p-3 rounded-lg bg-white">
        <header class="flex justify-between">
          <h3 class="text-xl font-bold">News</h3>
        </header>
        <div class="">
          <ul class="news-bar">
            <?php
            $args = array(
              'post_type' => 'post',
              'posts_per_page' => 10,
              'order' => 'DESC',
              'orderby' => 'date',
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
              while ($query->have_posts()) {
                $query->the_post();
                // Display the post information here
                news_content(get_the_ID());

              }
              wp_reset_postdata();
            } else {
              echo 'No posts found.';
            }

            ?>
          </ul>
        </div>
      </section>
      
      <section class="ss-share-school mt-6 share-school-section p-3 rounded-lg bg-white">
        <header class="flex justify-between">
          <h3 class="text-xl font-bold">Share School Success</h3>
        </header>
        <div class="">
            <div class="item-share-school">
                <div class="img-share-school">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bg.jpg"
                        class="link-img-sc">
                </div>
                <a href="" class="links-share-school">
                    <button class="btn btn-share-school">Coming soon!</button>
                    <svg class="hidden" xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path d="M14.93 5.92999L21 12L14.93 18.07M4 12H20.83" stroke="#FAA332" stroke-width="1.5"
                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>

    </section>

    </div>
  </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>