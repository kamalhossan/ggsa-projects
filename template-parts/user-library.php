<?php

$current_user = $args['current_user'];
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar($user_id);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];


/* pagination settings */
$pagination_prev_text = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
<path d="M13.0871 6.175L11.9121 5L6.91211 10L11.9121 15L13.0871 13.825L9.27044 10L13.0871 6.175Z" fill="black" fill-opacity="0.87"/>
</svg>';
$pagination_prev_var = sprintf(
    '<i></i> %1$s',
    apply_filters(
        'my_pagination_page_numbers_previous_text',
        __($pagination_prev_text, 'dmugi')
    )
);
$pagination_next_text = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
<path d="M8.08711 5L6.91211 6.175L10.7288 10L6.91211 13.825L8.08711 15L13.0871 10L8.08711 5Z" fill="black" fill-opacity="0.87"/>
</svg>';
$pagination_next_var = sprintf(
    '%1$s <i></i>',
    apply_filters(
        'my_pagination_page_numbers_next_text',
        __($pagination_next_text, 'dmugi')
    )
);

$course_enrolled_args = array(
    'post_type' => 'sfwd-courses',
    'post_status' => 'publish',
);
$course_enrolled = learndash_user_get_enrolled_courses($user_id, $course_enrolled_args, true);

$search = ( $_GET[ 'search-keyword' ] ) ?: '';
$search_input_placeholder = 'Search Resources';
$search_sentence = true;
$search_exact = ( count(explode(' ', $search)) == 1 ) ? true : false;

/* curriculum total post */
$c_slug = 'curriculum';
$c_paged = ($_GET['c_paged']) ? $_GET['c_paged'] : 1;
$curriculum_args = array(
    'post_type' => 'sfwd-courses',
    'post_status' => 'publish',
    'paged' => $c_paged,
    'post__in' => $course_enrolled,
	's' => $search,
	'sentence' => $search_sentence,
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => $c_slug
        ),
    ),
);

/* professional total post */

$p_slug = 'professional-learning';
$p_paged = ($_GET['p_paged']) ? $_GET['p_paged'] : 1;
$pro_args = array(
    'post_type' => 'sfwd-courses',
    'post_status' => 'publish',
    'paged' => $p_paged,
    'post__in' => $course_enrolled,
	's' => $search,
	'sentence' => $search_sentence,
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => $p_slug
        ),
    ),
);

/* professional total post */
$s_slug = 'school-improvement';
$s_paged = ($_GET['s_paged']) ? $_GET['s_paged'] : 1;
$school_args = array(
    'post_type' => 'sfwd-courses',
    'post_status' => 'publish',
    'paged' => $s_paged,
    'post__in' => $course_enrolled,
	's' => $search,
	'sentence' => $search_sentence,
    'tax_query' => array(
        array(
            'taxonomy' => 'ld_course_category',
            'field' => 'slug',
            'terms' => $s_slug,
        ),
    ),
);


$curriculum_course_enrolled = learndash_user_get_enrolled_courses($user_id, $curriculum_args);
$pro_course_enrolled = learndash_user_get_enrolled_courses($user_id, $pro_args);
$school_course_enrolled = learndash_user_get_enrolled_courses($user_id, $school_args);


$user_notifications = user_get_notification($user_id);

?>
<main class="px-6 py-8 bg-[#F6F6F6]">
    <header class="flex justify-between items-center">
        <section class="heading-section">
            <div class="d-flex gap-4 items-center">
            <h1 class="text-[32px] text-[#161C24] lh-sm font-bold mb-0 pb-0"><?php echo get_the_title(); ?></h1>
                <button id="tour-popup" class="btn btn-primary myLibrary">Begin Tour</button>
                <!-- <button id="close-tour" class="btn btn-primary close">Close Tour</button> -->
            </div>
            <span class="text-[20px] text-[#4d4f4e] lh-md font-normal mb-0 pb-0"><?php echo get_the_excerpt(); ?></span>
        </section>
        <section class="flex justify-between items-center">
            <?php echo search_form_html(); ?>
            <div class=" relative flex items-center justify-center w-10 h-10 bg-white rounded-full">
                <div class="icon-notification">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/notification.svg" alt="" />
                    <span class="absolute top-0 right-0 transform translate-x-2 -translate-y-1.5 flex items-center justify-center w-[19px] h-[18px] text-xs text-white font-bold bg-orange rounded-full">
                        <?php echo $user_notifications['total_unread']; ?>
                    </span>
                </div>
                <div class="notification  right-0 top-12 absolute bg-white" style="z-index:9999">
                    <header class="flex justify-between p-3">
                        <h4 class="text-xl font-bold">Notification</h4>
                        <span class="cursor-pointer close-button"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        </section>
    </header>

    <div class="flex flex-container mt-6">
        <div class="flex-2 col-lg-12">
            <!-- my library -->
            <section class="my-library-section">

                <ul class="flex items-start justify-between gap-2 mt-3" style="display:none!important">
                    <li class="flex items-center pr-2 bg-white rounded-lg">
                        <div class="inline-flex items-center justify-center overflow-hidden rounded-full">
                            <svg class="w-12 h-12 -rotate-90">
                                <!--
                  circumference: 24 * 2 * Math.PI // 150.79644737231007
                  stroke-dasharray = 18 * 2 * Math.PI // 113.09733552923255
                  stroke-dashoffset = circumference - percent / 100 * circumference // 
                -->
                                <circle class="text-[#EDEDED]" stroke-width="5" stroke="currentColor" fill="transparent" r="18" cx="24" cy="24" />
                                <circle class="text-standard" stroke-width="5" stroke-dasharray="113.09733552923255" stroke-dashoffset="37.32212072464674" stroke-linecap="round" stroke="currentColor" fill="transparent" r="18" cx="24" cy="24" />
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
                                <circle class="text-[#EDEDED]" stroke-width="5" stroke="currentColor" fill="transparent" r="18" cx="24" cy="24" />
                                <circle class="text-yellow" stroke-width="5" stroke-dasharray="113.09733552923255" stroke-dashoffset="37.32212072464674" stroke-linecap="round" stroke="currentColor" fill="transparent" r="18" cx="24" cy="24" />
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
                                <circle class="text-[#EDEDED]" stroke-width="5" stroke="currentColor" fill="transparent" r="18" cx="24" cy="24" />
                                <circle class="text-green" stroke-width="5" stroke-dasharray="113.09733552923255" stroke-dashoffset="37.32212072464674" stroke-linecap="round" stroke="currentColor" fill="transparent" r="18" cx="24" cy="24" />
                            </svg>
                            <span class="absolute text-xs">67%</span>
                        </div>
                        School Improvement in progress
                    </li>
                </ul>

                <!-- Tab menu items -->
                <ul class="inline-flex border-b border-navy my-library-tab">
                    <li data-tab-key="#curriculum" class="tab-key relative flex items-center justify-center">
                        <span class="">Curriculum (<?php echo count($curriculum_course_enrolled); ?>)
                        </span>
                    </li>
                    <li data-tab-key="#professional-learning" class="tab-key relative -ml-4 flex items-center justify-center">
                        <span class="">Professional Learning (<?php echo count($pro_course_enrolled); ?>)
                        </span>
                    </li>
                    <li data-tab-key="#school-improvement" class="tab-key relative -ml-4 flex items-center justify-center text-[#7A7B7A]">
                        <span class="">School Improvement (<?php echo count($school_course_enrolled); ?>)
                        </span>
                    </li>
                </ul>

                <!-- Tab menu contents -->
                <!-- Curriculum content -->
                <?php
                $curriculum_query = new WP_Query($curriculum_args);
                $curriculum_query_posts_count = $curriculum_query->found_posts;
                $curriculum_empty_class =  ($curriculum_query_posts_count == 0) ? ' course-lists-empty' : '';
                ?>
                <div id="curriculum" class="tab-content mt-3 p-4 bg-white">
                    <h5 class="text-[24px] text-[#161C24] lh-base font-bold mb-3 pb-0">Curriculum (<?php echo $curriculum_query_posts_count; ?>)
                    </h5>
                    <div class="tab-content-inner-wrap<?= $curriculum_empty_class; ?>">
                        <ul class="tab-content-inner gap-2 column-gap-3">
                            <?php
                            if ( $curriculum_query->have_posts() ) {
                                while ( $curriculum_query->have_posts() ) {
                                    $curriculum_query->the_post();
                                    $curriculum_course_id = get_the_ID();
                                    course_list_curriculum_content($curriculum_course_id, $user_id, true);
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
                    </div>
                    <?php
                    $curriculum_pag_args = array(
                        'format'  => '?c_paged=%#%',
                        'current' => $c_paged,
                        'total'   => $curriculum_query->max_num_pages,
                        // 'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'show_all'     => false,
                        'type'         => 'plain',
                        'end_size'     => 2,
                        'mid_size'     => 1,
                        'prev_next'    => true,
                        'prev_text'    => $pagination_prev_var,
                        'next_text'    => $pagination_next_var,
                        'add_fragment' => '',
                        // Custom arguments not part of WP core:
                        'show_page_position' => false, // Optionally allows the "Page X of XX" HTML to be displayed.
                        'add_args' => array('p_paged' => $p_paged, 's_paged' => $s_paged)
                    );
                    if ($curriculum_query_posts_count != 0) {
                    ?>

                        <div class="pagination">
                            <?php echo paginate_links($curriculum_pag_args); ?>
                        </div>
                    <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>

                <!-- Professional Learning content -->
                <?php
                $pro_query = new WP_Query($pro_args);
                $pro_query_posts_count = $pro_query->found_posts;
                $pro_empty_class =  ($pro_query_posts_count == 0) ? ' course-lists-empty' : '';
                ?>
                <div id="professional-learning" class="tab-content mt-3 p-4 bg-white">
                    <h5 class="text-[24px] text-[#161C24] lh-base font-bold mb-3 pb-0">Professional Learning (<?php echo $pro_query_posts_count; ?>)
                    </h5>
                    <div class="tab-content-inner-wrap<?= $pro_empty_class; ?>">
                        <ul class="tab-content-inner gap-2 column-gap-3">
                            <?php
                            if ( $pro_query->have_posts() ) {
                                while ( $pro_query->have_posts() ) {
                                    $pro_query->the_post();
                                    $pro_course_id = get_the_ID();
                                    course_list_professional_learning_content($pro_course_id, $user_id, true);
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
                    </div>
                    <?php
                    $pro_pag_args = array(
                        'format'  => '?p_paged=%#%',
                        'current' => $p_paged,
                        'total'   => $pro_query->max_num_pages,
                        // 'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'show_all'     => false,
                        'type'         => 'plain',
                        'end_size'     => 2,
                        'mid_size'     => 1,
                        'prev_next'    => true,
                        'prev_text'    => $pagination_prev_var,
                        'next_text'    => $pagination_next_var,
                        'add_fragment' => '',
                        // Custom arguments not part of WP core:
                        'show_page_position' => false, // Optionally allows the "Page X of XX" HTML to be displayed.
                        'add_args' => array('c_paged' => $c_paged, 's_paged' => $s_paged)
                    );
                    if ($pro_query_posts_count != 0) {
                    ?>
                        <div class="pagination">
                            <?php echo paginate_links($pro_pag_args); ?>
                        </div>
                    <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>

                <!-- School Improvement content -->
                <?php
                $school_query = new WP_Query($school_args);
                $school_query_posts_count = $school_query->found_posts;
                $school_empty_class =  ($school_query_posts_count == 0) ? ' course-lists-empty' : '';
                ?>
                <div id="school-improvement" class="tab-content mt-3 p-4 bg-white">
                    <h5 class="text-[24px] text-[#161C24] lh-base font-bold mb-3 pb-0">School Improvement (<?php echo $school_query_posts_count; ?>)
                    </h5>
                    <div class="tab-content-inner-wrap<?= $school_empty_class; ?>">
                        <ul class="tab-content-inner gap-2 column-gap-3">
                            <?php
                            if ( $school_query->have_posts() ) {
                                while ( $school_query->have_posts() ) {
                                    $school_query->the_post();
                                    $school_course_id = get_the_ID();
                                    course_list_school_improvement_content($school_course_id, $user_id);
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
                    </div>
                    <?php
                    $school_pag_args = array(
                        'format'  => '?s_paged=%#%',
                        'current' => $s_paged,
                        'total'   => $school_query->max_num_pages,
                        // 'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'show_all'     => false,
                        'type'         => 'plain',
                        'end_size'     => 2,
                        'mid_size'     => 1,
                        'prev_next'    => true,
                        'prev_text'    => $pagination_prev_var,
                        'next_text'    => $pagination_next_var,
                        'add_fragment' => '',
                        // Custom arguments not part of WP core:
                        'show_page_position' => false, // Optionally allows the "Page X of XX" HTML to be displayed.
                        'add_args' => array('c_paged' => $c_paged, 'p_paged' => $p_paged),
                    );
                    if ($school_query_posts_count != 0) {
                    ?>
                        <div class="pagination">
                            <?php echo paginate_links($school_pag_args); ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>