<?php

$current_user = $args['current_user'];
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar($user_id);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];


$course_enrolled_args = array(
    'post_type' => 'sfwd-courses',
    'post_status' => 'publish',
);
$course_enrolled = learndash_user_get_enrolled_courses($user_id, $course_enrolled_args, true);

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
            <a class="entry-about-pl-report-form-button-sumbit mr-1 px-2 py-[6px] rounded-lg border-solid border-1 border-[#FAA332] text-[#FAA332] text-[14px] font-bold" href="<?php echo home_url('/about-the-mastery-teaching-pathway') ?>">About the Mastery Teaching Pathway</a>
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
            <!-- my library -->
            
            <?php //fn_get_stage_left_bar('Proficient' , 0); ?>
            <?php //fn_get_stage_left_bar('Accompilshed' , 0); ?>
            <?php //fn_get_stage_left_bar('Lead' , 0); ?>
            <section class="my-pathway-section main-block">
                <div>
                    <?php fn_get_stage_progress_html('foundation' , $user_id ); ?>
                    <?php fn_get_stage_progress_html('proficient' ,  $user_id); ?>
                    <?php fn_get_stage_progress_html('accomplished' , $user_id); ?>
                    <?php fn_get_stage_progress_html('lead' , $user_id); ?>
                   
                   
                   

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
