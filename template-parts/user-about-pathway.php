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

$search = ($_GET['search-keyword']) ?: '';
$search_input_placeholder = 'Search Resources';
$search_sentence = true;
$search_exact = (count(explode(' ', $search)) == 1) ? true : false;

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
            'taxonomy' => $pl_term,
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
            'taxonomy' => $pl_term,
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
            'taxonomy' => $pl_term,
            'field' => 'slug',
            'terms' => $s_slug,
        ),
    ),
);


$curriculum_course_enrolled = learndash_user_get_enrolled_courses($user_id, $curriculum_args);
$pro_course_enrolled = learndash_user_get_enrolled_courses($user_id, $pro_args);
$school_course_enrolled = learndash_user_get_enrolled_courses($user_id, $school_args);


$user_subject = get_user_meta($user_id, 'subject', true);
$user_year = get_user_meta($user_id, 'year', true);
$user_stage = get_user_meta($user_id, 'stage', true);
if (!$user_stage) {
    $user_stage = 'Foundation';
}
$user_notifications = user_get_notification($user_id);
$pl_term = 'ld_course_category';

?>
<main class="px-6 py-8 bg-[#F6F6F6]">
    <header class="flex justify-between items-center">
        <section class="heading-section">
            <h1 class="text-[32px] text-[#161C24] lh-sm font-bold mb-0 pb-0">
                <?php echo get_the_title(); ?>
            </h1>
            <span class="text-[20px] text-[#4d4f4e] lh-md font-normal mb-0 pb-0">
                <?php echo get_the_excerpt(); ?>
            </span>
        </section>
        <section class="flex justify-between items-center">
            <?php // echo search_form_html(); ?>
            
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
                        <span class="cursor-pointer close-button"><svg width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18" stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6 6L18 18" stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>

                    </header>
                    <ul class="">
                        <?php
                        foreach ($user_notifications['data'] as $nt) {
                            ?>
                            <li class="msg-<?php echo $nt['read'] ?> msg pt-2 pb-2 pl-4 pr-4"
                                data-entry="<?php echo $nt['ID'] ?>">
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
    <?php
    
    ?>
    <div class="flex flex-container mt-6">
        <div class="flex-2 col-lg-12">
           
            <section class="about-pathway-section main-block p-4 rounded-[20px] bg-white">
                <div class="list-course-recommendations rs-slider-one flex " >
                    <div class="ss-slidera">
                        <div><img src="<?php echo get_stylesheet_directory_uri().'/assets/img/about-pathway-slider.jpg' ?>" alt=""></div>
                        
                    </div>
                </div>
                <header class="pt-4 pb-4">
                        <h3 class="text-[24px] text-[#161C24] lh-md font-bold pb-0 mb-0">
                        Our Mastery Teaching Pathway is a professional learning accreditation platform for principals, instruction coaches, teachers and teaching assistants.</h3>
                    </header>
                <div class="about-pathway-inner p-3  bg-[#FEF4D5]">
                        <ul >
                        <li class="gap-4"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke="#FAA332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6 10V8C6 4.69 7 2 12 2C16.5 2 18 4 18 7" stroke="#FAA332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 18.5C13.3807 18.5 14.5 17.3807 14.5 16C14.5 14.6193 13.3807 13.5 12 13.5C10.6193 13.5 9.5 14.6193 9.5 16C9.5 17.3807 10.6193 18.5 12 18.5Z" stroke="#FAA332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg> All GGSA members have free access to the Mastery Teaching Pathway.</li>
                        <li class="gap-4"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M21.9103 22.001L18.8803 18.971M17.2903 4.14096L17.2203 7.93096C17.2103 8.45096 17.5403 9.14096 17.9603 9.45096L20.4403 11.331C22.0303 12.531 21.7703 14.001 19.8703 14.601L16.6403 15.611C16.1003 15.781 15.5303 16.371 15.3903 16.921L14.6203 19.861C14.0103 22.181 12.4903 22.411 11.2303 20.371L9.47027 17.521C9.15027 17.001 8.39027 16.611 7.79027 16.641L4.45027 16.811C2.06027 16.931 1.38027 15.551 2.94027 13.731L4.92027 11.431C5.29027 11.001 5.46027 10.201 5.29027 9.66096L4.28027 6.43096C3.69027 4.53096 4.75027 3.48096 6.64027 4.10096L9.59027 5.07096C10.0903 5.23096 10.8403 5.12096 11.2603 4.81096L14.3403 2.59096C16.0003 1.39096 17.3303 2.09096 17.2903 4.14096Z" stroke="#FAA332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg> All modules you undertake align to the Australian Institute for Teaching and School Leadership (AITSL) national standards. These standards are listed in each module overview.</li>
                        <li class="gap-4"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10 1H19.696C20.4172 1 21.0018 1.58466 21.0018 2.30588V12.7346C21.0018 13.4558 20.4172 14.0405 19.696 14.0405H11.7698" stroke="#FAA332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.07398 6.38626C6.56137 6.38626 7.76712 5.18051 7.76712 3.69312C7.76712 2.20575 6.56137 1 5.07398 1C3.58661 1 2.38086 2.20575 2.38086 3.69312C2.38086 5.18051 3.58661 6.38626 5.07398 6.38626Z" stroke="#FAA332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M14.0769 8.73502C14.0769 7.862 13.3692 7.1543 12.4962 7.1543H5.07527C2.82457 7.1543 1 8.97885 1 11.2296V14.8466H2.74654L3.32872 21.0004H6.82181L8.16346 10.3157H12.4962C13.3692 10.3157 14.0769 9.60802 14.0769 8.73502Z" stroke="#FAA332" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg> The Mastery Teaching Pathway includes a recommended learning plan for you that is based on your role and preferences and is informed by expert advice.</li>
                    </ul>
                </div>
                <hr class="bg-[#EDEDED] border border-[#EDEDED] mt-4 mb-4">
                <div class="about-pathway-bottom">
                    <div class="row">
                        <div class="col">
                            <h3 class="text-[20px] text-[#00859C] lh-md font-bold pb-0 mb-3"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.666 2.66602V6.66602" stroke="#00859C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21.334 2.66602V6.66602" stroke="#00859C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M28 11.3327V18.1727C26.8133 17.226 25.3067 16.666 23.6667 16.666C22.0267 16.666 20.4933 17.2393 19.2933 18.2126C17.68 19.4793 16.6667 21.466 16.6667 23.666C16.6667 24.9727 17.04 26.226 17.68 27.266C18.1733 28.0794 18.8133 28.786 19.5733 29.3327H10.6667C6 29.3327 4 26.666 4 22.666V11.3327C4 7.33268 6 4.66602 10.6667 4.66602H21.3333C26 4.66602 28 7.33268 28 11.3327Z" stroke="#00859C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.33398 14.666H17.334" stroke="#00859C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.33398 21.334H12.8273" stroke="#00859C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M30.666 23.666C30.666 24.9727 30.2927 26.226 29.6527 27.266C29.2793 27.906 28.8127 28.466 28.266 28.9194C27.0394 30.0127 25.4393 30.666 23.666 30.666C22.1327 30.666 20.7193 30.1727 19.5727 29.3327C18.8127 28.786 18.1727 28.0794 17.6794 27.266C17.0394 26.226 16.666 24.9727 16.666 23.666C16.666 21.466 17.6794 19.4793 19.2927 18.2126C20.4927 17.2393 22.026 16.666 23.666 16.666C25.306 16.666 26.8127 17.226 27.9993 18.1727C29.626 19.4527 30.666 21.4393 30.666 23.666Z" stroke="#00859C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M23.6673 27.0007C23.6673 25.1607 25.1607 23.6673 27.0007 23.6673C25.1607 23.6673 23.6673 22.174 23.6673 20.334C23.6673 22.174 22.174 23.6673 20.334 23.6673C22.174 23.6673 23.6673 25.1607 23.6673 27.0007Z" stroke="#00859C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg> Prerequisites </h3>
                            <div class="">
                            There are four modules that should be completed before undertaking <a href="">Program Modules.</a>
    They must be completed for you to receive accreditation on the <span class="text-[#FAA332]">Mastery Teaching Pathway.</span>
                            </div>
                            <div class="container">
                            <div class="row prerequisite-box mt-3">
                                <div class="col">
                                    <h4><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 5.4897V20.4897M7.75 8.4897H5.5M8.5 11.4897H5.5M22 16.7397V4.6697C22 3.4697 21.02 2.5797 19.83 2.6797H19.77C17.67 2.8597 14.48 3.9297 12.7 5.0497L12.53 5.1597C12.24 5.3397 11.76 5.3397 11.47 5.1597L11.22 5.0097C9.44 3.8997 6.26 2.8397 4.16 2.6697C2.97 2.5697 2 3.4697 2 4.6597V16.7397C2 17.6997 2.78 18.5997 3.74 18.7197L4.03 18.7597C6.2 19.0497 9.55 20.1497 11.47 21.1997L11.51 21.2197C11.78 21.3697 12.21 21.3697 12.47 21.2197C14.39 20.1597 17.75 19.0497 19.93 18.7597L20.26 18.7197C21.22 18.5997 22 17.6997 22 16.7397Z" stroke="#1B61F9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>   Learn Effective Teaching Essentials</h4>
                                    <p>All Program Modules
    Mastery Teaching Pathway (all roles)</p>
                                </div>
                                <div class="col">
                                <h4><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 5.4897V20.4897M7.75 8.4897H5.5M8.5 11.4897H5.5M22 16.7397V4.6697C22 3.4697 21.02 2.5797 19.83 2.6797H19.77C17.67 2.8597 14.48 3.9297 12.7 5.0497L12.53 5.1597C12.24 5.3397 11.76 5.3397 11.47 5.1597L11.22 5.0097C9.44 3.8997 6.26 2.8397 4.16 2.6697C2.97 2.5697 2 3.4697 2 4.6597V16.7397C2 17.6997 2.78 18.5997 3.74 18.7197L4.03 18.7597C6.2 19.0497 9.55 20.1497 11.47 21.1997L11.51 21.2197C11.78 21.3697 12.21 21.3697 12.47 21.2197C14.39 20.1597 17.75 19.0497 19.93 18.7597L20.26 18.7197C21.22 18.5997 22 17.6997 22 16.7397Z" stroke="#1B61F9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>  Support Families in Positive High-Expectations Schools</h4>
                                    <p>All Program Modules in the Community domain</p>

                                </div>
                                <div class="col">
                                <h4><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 5.4897V20.4897M7.75 8.4897H5.5M8.5 11.4897H5.5M22 16.7397V4.6697C22 3.4697 21.02 2.5797 19.83 2.6797H19.77C17.67 2.8597 14.48 3.9297 12.7 5.0497L12.53 5.1597C12.24 5.3397 11.76 5.3397 11.47 5.1597L11.22 5.0097C9.44 3.8997 6.26 2.8397 4.16 2.6697C2.97 2.5697 2 3.4697 2 4.6597V16.7397C2 17.6997 2.78 18.5997 3.74 18.7197L4.03 18.7597C6.2 19.0497 9.55 20.1497 11.47 21.1997L11.51 21.2197C11.78 21.3697 12.21 21.3697 12.47 21.2197C14.39 20.1597 17.75 19.0497 19.93 18.7597L20.26 18.7197C21.22 18.5997 22 17.6997 22 16.7397Z" stroke="#1B61F9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>  Cycles of School Practice</h4>
                                    <p>Mastery Teaching Pathway (all roles)</p>
                                </div>
                                <div class="col"><h4><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 5.4897V20.4897M7.75 8.4897H5.5M8.5 11.4897H5.5M22 16.7397V4.6697C22 3.4697 21.02 2.5797 19.83 2.6797H19.77C17.67 2.8597 14.48 3.9297 12.7 5.0497L12.53 5.1597C12.24 5.3397 11.76 5.3397 11.47 5.1597L11.22 5.0097C9.44 3.8997 6.26 2.8397 4.16 2.6697C2.97 2.5697 2 3.4697 2 4.6597V16.7397C2 17.6997 2.78 18.5997 3.74 18.7197L4.03 18.7597C6.2 19.0497 9.55 20.1497 11.47 21.1997L11.51 21.2197C11.78 21.3697 12.21 21.3697 12.47 21.2197C14.39 20.1597 17.75 19.0497 19.93 18.7597L20.26 18.7197C21.22 18.5997 22 17.6997 22 16.7397Z" stroke="#1B61F9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>  Build Positive High-Expectations School Communities</h4>
                                    <p>Mastery Teaching Pathway (all roles)</p></div>
                        </div>
                    </div>
                        </div>
                        <div class="col divider">
                        
                        </div>
                        <div class="col">
                        <h3 class="text-[20px] text-[#00859C] lh-md font-bold pb-0 mb-3"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.97266 24.4673L14.106 27.6673C14.6393 28.2006 15.8393 28.4673 16.6393 28.4673H21.706C23.306 28.4673 25.0393 27.2673 25.4393 25.6673L28.6393 15.9339C29.306 14.0673 28.106 12.4673 26.106 12.4673H20.7727C19.9727 12.4673 19.306 11.8006 19.4393 10.8673L20.106 6.60061C20.3727 5.40061 19.5727 4.06728 18.3727 3.66728C17.306 3.26728 15.9727 3.80061 15.4393 4.60061L9.97266 12.7339" stroke="#00859C" stroke-width="1.5" stroke-miterlimit="10"/>
<path d="M3.17383 24.4672V11.4005C3.17383 9.53385 3.97383 8.86719 5.84049 8.86719H7.17383C9.04049 8.86719 9.84049 9.53385 9.84049 11.4005V24.4672C9.84049 26.3339 9.04049 27.0005 7.17383 27.0005H5.84049C3.97383 27.0005 3.17383 26.3339 3.17383 24.4672Z" stroke="#00859C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg> Recognition of Prior Learning</h3>
                        <p>You can apply for recognition of prior learning if you have evidence of undertaking effective teaching modules or have mastered a range of effective teaching practices and can accurately demonstrate them. Please use <a href="">this link</a> to enquire or apply.</p>
                        <hr class="bg-[#EDEDED] border border-[#EDEDED]">
                        <h3 class="text-[20px] text-[#00859C] lh-md font-bold pb-0 mb-3"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M28.8796 13.9207L27.5729 19.494C26.4529 24.3073 24.2396 26.254 20.0796 25.854C19.4129 25.8007 18.6929 25.6807 17.9196 25.494L15.6796 24.9607C10.1196 23.6407 8.39959 20.894 9.70626 15.3207L11.0129 9.734C11.2796 8.60066 11.5996 7.61399 11.9996 6.80066C13.5596 3.57399 16.2129 2.70733 20.6663 3.76066L22.8929 4.28066C28.4796 5.58733 30.1863 8.34733 28.8796 13.9207Z" stroke="#00859C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M20.0805 25.8541C19.2538 26.4141 18.2138 26.8808 16.9471 27.2941L14.8405 27.9874C9.54712 29.6941 6.76045 28.2674 5.04045 22.9741L3.33379 17.7074C1.62712 12.4141 3.04045 9.61411 8.33379 7.90745L10.4405 7.21411C10.9871 7.04078 11.5071 6.89411 12.0005 6.80078C11.6005 7.61411 11.2805 8.60078 11.0138 9.73412L9.70712 15.3208C8.40046 20.8941 10.1205 23.6408 15.6805 24.9608L17.9205 25.4941C18.6938 25.6808 19.4138 25.8008 20.0805 25.8541Z" stroke="#00859C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16.8535 11.373L23.3202 13.013" stroke="#00859C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.5469 16.5332L19.4135 17.5199" stroke="#00859C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg> Program Module Electives</h3>
                        <p>Program Modules are designed to provide training in how to deliver a particular education program. They can be completed at any pathway level of the <a href="">Mastery Teaching Pathway.</a></p>

                        <p>Teachers and teaching assistants usually complete at least one Program Module per year.</p>

                        <p>Program Modules are 'electives', not core course modules. Every teacher needs to complete at least three electives from the Mastery Teaching Pathway to achieve certification. Program Modules are chosen by the teacher depending on what programs they are implementing at their school.</p>
                        </div>
                    </div>
                    </div>
            </section>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    
</style>
