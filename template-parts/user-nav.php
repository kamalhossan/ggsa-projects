<?php
global $wp;


$current_user = wp_get_current_user();
$username = $current_user->user_login;
$user_email = $current_user->user_email;





$first_name = get_user_meta($current_user->ID, 'first_name', true);
$last_name = get_user_meta($current_user->ID, 'last_name', true);

if ($first_name || $last_name) {
    $name = $first_name . ' ' . $last_name;
} else {
    $name = $username;
}

$user_id = $current_user->ID;
// $avatar = get_avatar($user_id);

$user_avatar = get_user_meta($user_id, 'user_avatar_url', true);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];
$school_name = get_user_meta($user_id, 'school-name', true);
if ($school_name) {

} else {
    $school_name = "";
}
$school_image1 = get_user_meta($user_id, 'school_image1', true);
if ($school_image1) {
    $image_data = wp_get_attachment_image_src($school_image1, 'thumbnail');
    $image_url = $image_data[0];
    $img = '<img width="18px" height="18px" src="' . $image_url . '"  />';
} else {
    $img = '<img width="18px" height="18px" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png"  />';
}
?>

<div class="ss-navbar">
    <div class="nav-logo">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-nav.png" alt="logo">
    </div>
    <div class="admin-menu">
        <div class="user-info">

            <div class="user-info-top overflow-hidden">
                <div class="user-left-section mr-2 flex align-items-center w-25">
                    <div class="avatar overflow-hidden ">
                        <?php

                        if ($user_avatar == "") {

                            echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="avatar avatar-96 photo" height="64" width="64" decoding="async">';
                        } else {


                            echo '<img alt="" src="' . $user_avatar . '" class="avatar avatar-96 photo" height="64" width="64" decoding="async">';
                        }
                        ?>
                    </div>
                </div>
                <div class="user-right-section w-75">
                    <div class="name-admin overflow-hidden">
                        <h4 class="text-admin text-nowrap"><?php echo $name; ?></h4>
                        <div class="edit-section">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 13.5C12.5523 13.5 13 13.0523 13 12.5C13 11.9477 12.5523 11.5 12 11.5C11.4477 11.5 11 11.9477 11 12.5C11 13.0523 11.4477 13.5 12 13.5Z"
                                    fill="#7A7B7A" stroke="#7A7B7A" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M12 6.5C12.5523 6.5 13 6.05228 13 5.5C13 4.94772 12.5523 4.5 12 4.5C11.4477 4.5 11 4.94772 11 5.5C11 6.05228 11.4477 6.5 12 6.5Z"
                                    fill="#7A7B7A" stroke="#7A7B7A" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M12 20.5C12.5523 20.5 13 20.0523 13 19.5C13 18.9477 12.5523 18.5 12 18.5C11.4477 18.5 11 18.9477 11 19.5C11 20.0523 11.4477 20.5 12 20.5Z"
                                    fill="#7A7B7A" stroke="#7A7B7A" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <div class="edit-panel p-2 shadow-sm">
                                <ul>
                                    <li> <a href="<?php echo home_url('my-profile'); ?>">Edit profile</a></li>
                                    <li> <a href="<?php echo wp_logout_url(); ?>">Log out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="position-admin d-flex">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.4416 16.5C15.4416 13.5975 12.5541 11.25 8.99914 11.25C5.44414 11.25 2.55664 13.5975 2.55664 16.5M8.99914 9C9.9937 9 10.9475 8.60491 11.6508 7.90165C12.3541 7.19839 12.7491 6.24456 12.7491 5.25C12.7491 4.25544 12.3541 3.30161 11.6508 2.59835C10.9475 1.89509 9.9937 1.5 8.99914 1.5C8.00458 1.5 7.05075 1.89509 6.34749 2.59835C5.64423 3.30161 5.24914 4.25544 5.24914 5.25C5.24914 6.24456 5.64423 7.19839 6.34749 7.90165C7.05075 8.60491 8.00458 9 8.99914 9Z"
                                stroke="#7A7B7A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg><span class="name-position" data-toggle="tooltip" data-placement="right" title="<?php echo $role_name; ?>">
                            <?php echo $role_name ?>
                        </span>
                    </div>

                    <div class="school-admin d-flex mb-1">
                        <div class="scl-img">
                            <?php echo $img; ?>
                        </div>
                        <span class="name-school" data-toggle="tooltip" data-placement="right" title="<?php echo $school_name; ?>">
                            <?php
                            echo $school_name;?>
                        </span>
                    </div>
                    <div class="user-info-bottom flex">

                        <div class="member-ship-info">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.15327 2.33977L10.3266 4.68643C10.4866 5.0131 10.9133 5.32643 11.2733 5.38643L13.3999 5.73977C14.7599 5.96643 15.0799 6.9531 14.0999 7.92643L12.4466 9.57977C12.1666 9.85977 12.0133 10.3998 12.0999 10.7864L12.5733 12.8331C12.9466 14.4531 12.0866 15.0798 10.6533 14.2331L8.65994 13.0531C8.29994 12.8398 7.70661 12.8398 7.33994 13.0531L5.34661 14.2331C3.91994 15.0798 3.05327 14.4464 3.42661 12.8331L3.89994 10.7864C3.98661 10.3998 3.83327 9.85977 3.55327 9.57977L1.89994 7.92643C0.926606 6.9531 1.23994 5.96643 2.59994 5.73977L4.72661 5.38643C5.07994 5.32643 5.50661 5.0131 5.66661 4.68643L6.83994 2.33977C7.47994 1.06643 8.51994 1.06643 9.15327 2.33977Z"
                                    fill="#FBBC16" />
                            </svg>
                            <span>
                                <?php echo "Individual" ?>
                            </span>
                        </div>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.6546 6.55196L16.5957 7.61084C17.7527 8.61858 19.1507 8.90797 20.1312 8.31795L18.251 6.43769C18.1868 6.37409 18.0881 6.35041 17.9763 6.37183C17.8646 6.39324 17.7489 6.45799 17.6546 6.55196Z"
                                fill="#CF8D41" />
                            <path
                                d="M14.7303 3.14665L14.8309 3.01229C15.0364 2.81214 15.4537 2.71227 16.1413 2.94377C16.8136 3.17009 17.6161 3.68104 18.391 4.45593C19.0707 5.13559 19.5496 5.83884 19.8093 6.4579C19.8712 6.60525 19.9189 6.74344 19.9542 6.87217L18.5356 5.45356L18.5346 5.45254C18.2141 5.13391 17.781 4.95356 17.3292 4.95186C16.8772 4.95016 16.4431 5.12748 16.1227 5.4461L16.1226 5.4461L16.1216 5.44714L15.6589 5.90984C15.2386 5.38374 14.9408 4.86486 14.7743 4.40289C14.5606 3.81016 14.5894 3.3947 14.7257 3.15481L14.7303 3.14665Z"
                                fill="#CF8D41" stroke="#CF8D41" />
                            <path
                                d="M3.15156 13.9896C3.13661 13.9998 3.12285 14.0117 3.11053 14.025C2.33287 14.8026 2.96238 16.6055 4.57452 18.2176C6.18666 19.8297 7.98949 20.4592 8.76715 19.6816C8.78041 19.6693 8.79227 19.6555 8.80252 19.6406L11.7657 15.5857L7.50625 11.3262C7.40695 11.2268 7.32088 11.115 7.25031 10.9939L3.30506 13.8757L3.15156 13.9896Z"
                                fill="#CF8D41" />
                            <path
                                d="M13.0608 4.07546L11.3279 6.58523C11.4538 6.66507 11.5716 6.75951 11.6783 6.86607L16.2487 11.4365L18.7151 9.7348C17.6876 9.4574 16.4736 8.68057 15.293 7.50004C14.1095 6.31647 13.3327 5.10247 13.0608 4.07546Z"
                                fill="#CF8D41" />
                            <path
                                d="M9.66704 7.46968L7.96998 9.16674C7.82019 9.3169 7.74032 9.5246 7.74789 9.74427C7.75547 9.96394 7.84987 10.1777 8.01039 10.3385L13.4652 15.7933C13.5168 15.845 13.58 15.8834 13.6486 15.9051C13.7172 15.9267 13.789 15.9308 13.8571 15.917C13.9253 15.9031 13.9876 15.8718 14.0381 15.8259C14.0886 15.7801 14.1256 15.7213 14.1456 15.655L14.6122 14.1119L16.1554 13.6453C16.2216 13.6253 16.2804 13.5883 16.3262 13.5378C16.3721 13.4873 16.4034 13.425 16.4173 13.3568C16.4311 13.2887 16.427 13.2169 16.4054 13.1483C16.3838 13.0797 16.3453 13.0165 16.2936 12.9649L10.8388 7.51008C10.678 7.34957 10.4642 7.25517 10.2446 7.24759C10.0249 7.24002 9.8172 7.31989 9.66704 7.46968Z"
                                fill="#CF8D41" />
                            <path
                                d="M8 14.3323C8 14.3938 7.99725 14.4462 7.99174 14.4892C7.98806 14.5303 7.98072 14.5631 7.9697 14.5877C7.96051 14.6123 7.94949 14.6308 7.93664 14.6431C7.92378 14.6554 7.90909 14.6615 7.89256 14.6615H6.72727V15.7323H7.82094C7.83747 15.7323 7.85216 15.7374 7.86501 15.7477C7.87787 15.7579 7.88889 15.7754 7.89807 15.8C7.90909 15.8246 7.91644 15.8574 7.92011 15.8985C7.92562 15.9395 7.92837 15.9908 7.92837 16.0523C7.92837 16.1138 7.92562 16.1651 7.92011 16.2062C7.91644 16.2472 7.90909 16.281 7.89807 16.3077C7.88889 16.3344 7.87787 16.3538 7.86501 16.3662C7.85216 16.3764 7.83747 16.3815 7.82094 16.3815H6.72727V17.8646C6.72727 17.8872 6.72176 17.9067 6.71074 17.9231C6.69972 17.9395 6.67952 17.9538 6.65014 17.9662C6.62259 17.9764 6.58586 17.9846 6.53994 17.9908C6.49403 17.9969 6.43526 18 6.36364 18C6.29385 18 6.23508 17.9969 6.18733 17.9908C6.14141 17.9846 6.10468 17.9764 6.07713 17.9662C6.04959 17.9538 6.02938 17.9395 6.01653 17.9231C6.00551 17.9067 6 17.8872 6 17.8646V14.2554C6 14.1651 6.0202 14.1005 6.06061 14.0615C6.10285 14.0205 6.15427 14 6.21488 14H7.89256C7.90909 14 7.92378 14.0062 7.93664 14.0185C7.94949 14.0287 7.96051 14.0472 7.9697 14.0738C7.98072 14.0985 7.98806 14.1323 7.99174 14.1754C7.99725 14.2185 8 14.2708 8 14.3323Z"
                                fill="white" />
                        </svg>
                    </div>
                </div>

            </div>

        </div>
        <div class="nav-menu">
            <ul class="list-nav-menu">
                <li class="item-menu my-school-box <?php echo ($wp->request == "dashboard") ? "active" : ""; ?>   ">
                    <a href="<?php echo home_url('/dashboard'); ?>" class="links-menu ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5L7.6 2L2 6L6.4 9L12 5Z" stroke="#FAA332" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 5L16.4 2L22 6L17.6 9L12 5Z" stroke="#FAA332" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14L7.6 17L2 13L6.4 10L12 14Z" stroke="#FAA332" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14L16.4 17L22 13L17.6 10L12 14Z" stroke="#FAA332" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M19 15.5V18.8L12.4 21.8C12.1 21.9 11.8 21.9 11.6 21.8L5 18.8V15.5" stroke="#FAA332"
                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        My School Box
                    </a>
                </li>
                <li class="item-menu ggsa-product-range <?php echo ($wp->request == "resources") ? "active" : ""; ?>">
                    <a href="<?php echo home_url('/resources'); ?>" class="links-menu">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/note-2.png" class="w-[24px]"
                            ?>
                        GGSA Product Range

                    </a>
                </li>
                <li
                    class="item-menu has-sub-menu our-school <?php echo ($wp->request == "school-forum" || $wp->request == "team-learning-plan" || $wp->request == "team-learning-report") ? "active-sub sub-menu-active " : ""; ?>">
                    <a href="#" class="links-menu ">

                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 22H5C3 22 2 21 2 19V11C2 9 3 8 5 8H10V19C10 21 11 22 13 22Z" stroke="#4D4F4E"
                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M10.11 4C10.03 4.3 10 4.63 10 5V8H5V6C5 4.9 5.9 4 7 4H10.11Z" stroke="#4D4F4E"
                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M14 8V13" stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18 8V13" stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 17H15C14.45 17 14 17.45 14 18V22H18V18C18 17.45 17.55 17 17 17Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M6 13V17" stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M10 19V5C10 3 11 2 13 2H19C21 2 22 3 22 5V19C22 21 21 22 19 22H13C11 22 10 21 10 19Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Our School <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.9201 8.9502L13.4001 15.4702C12.6301 16.2402 11.3701 16.2402 10.6001 15.4702L4.08008 8.9502"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    <ul class="sub-link">
                        <li class="item-menu">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/svg/line.svg" alt="line">
                            <a class="links-menu <?php echo ($wp->request == "school-forum") ? "active" : ""; ?>"
                                href="<?php echo home_url('/school-forum'); ?>">
                    
                                School Forum</a>
                        </li>
                        <li class="item-menu ">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/svg/line.svg" alt="line">
                            <a class="links-menu <?php echo ($wp->request == "team-learning-plan") ? "active" : ""; ?>"
                                href="<?php echo home_url('/team-learning-plan'); ?>">
                    
                                Team Learning Plan</a>
                        </li>
                        <li class="item-menu">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/svg/lastline.svg" alt="line">
                            <a class="links-menu <?php echo ($wp->request == "team-learning-report") ? "active" : ""; ?>"
                                href="<?php echo home_url('/team-learning-report'); ?>">
                    
                                School Professional Learning Report</a>
                        </li>
                    </ul>
                </li>
                <li class="item-menu my-library <?php echo ($wp->request == "my-library") ? "active" : ""; ?>">
                    <a class="links-menu" href="<?php echo home_url('my-library'); ?>" class="links-menu">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 20.1139V4.31387C7 2.81387 6.62353 2.21387 5.68824 2.21387H3.31176C2.37647 2.21387 2 2.81387 2 4.31387V20.1139C2 21.6139 2.37647 22.2139 3.31176 22.2139H5.68824C6.62353 22.2139 7 21.6139 7 20.1139Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M14 20.1139V4.31387C14 2.81387 13.6235 2.21387 12.6882 2.21387H10.3118C9.37647 2.21387 9 2.81387 9 4.31387V20.1139C9 21.6139 9.37647 22.2139 10.3118 22.2139H12.6882C13.6235 22.2139 14 21.6139 14 20.1139Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M22.9349 19.7917L21.2003 4.08721C21.0356 2.59628 20.5956 2.04124 19.6659 2.14392L17.3038 2.40482C16.3742 2.5075 16.0659 3.1452 16.2305 4.63613L17.9651 20.3406C18.1298 21.8316 18.5699 22.3866 19.4995 22.2839L21.8616 22.023C22.7913 21.9203 23.0996 21.2826 22.9349 19.7917Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        My Library</a>
                </li>
                <li
                    class="item-menu my-learning has-sub-menu <?php echo ( $wp->request == "my-pathway" ||  $wp->request == "my-professional-learning-plan" ||  $wp->request == "my-professional-learning-report") ? "active-sub sub-menu-active " : ""; ?>">
                    <a href="#" class="links-menu ">

                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8 3H7C3.5 3 2 4.9 2 7.75V17.25C2 20.1 3.5 22 7 22H15C18.5 22 20 20.1 20 17.25V12.025"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M7 14H11M7 18H15" stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10 9.42453V4.69092" stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M12.8184 5.91846L12.8245 8.84642C12.8245 8.84642 13.8499 10.2033 16.2109 10.2033C18.5717 10.2033 19.6026 8.84642 19.6026 8.84642L19.602 5.91846"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16.2108 2L22.4215 4.69098L16.2108 7.38198L10 4.69098L16.2108 2Z" stroke="#4D4F4E"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        My Learning <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.9201 8.9502L13.4001 15.4702C12.6301 16.2402 11.3701 16.2402 10.6001 15.4702L4.08008 8.9502"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    <ul class="sub-link">
                        <li class="item-menu">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/svg/line.svg" alt="line">
                            <a class="links-menu <?php echo ($wp->request == "my-pathway") ? "active" : ""; ?>"
                                href="<?php echo home_url('/my-pathway'); ?>">

                                My Learning Pathway</a>
                        </li>
                        <li class="item-menu">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/svg/line.svg" alt="line">
                            
                            <a class="links-menu <?php echo ($wp->request == "my-professional-learning-plan") ? "active" : ""; ?>"
                                href="<?php echo home_url('/my-professional-learning-plan'); ?>">
                                My Learning Plan</a>
                        </li>
                        <li class="item-menu">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/svg/lastline.svg" alt="line">
                            <a class="links-menu <?php echo ($wp->request == "my-professional-learning-report") ? "active" : ""; ?>"
                                href="<?php echo home_url('/my-professional-learning-report'); ?>">
                                My Professional Learning Report</a>
                        </li>
                    </ul>
                </li>
                <li class="item-menu our-forum <?php echo ($wp->request == "our-forums") ? "active" : ""; ?>">
                    <a href="#" class="links-menu">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.4698 16.83L18.8598 19.99C18.9598 20.82 18.0698 21.4 17.3598 20.97L13.1698 18.48C12.7098 18.48 12.2598 18.45 11.8198 18.39C12.5778 17.5113 12.9964 16.3904 12.9998 15.23C12.9998 12.39 10.5398 10.09 7.49984 10.09C6.33984 10.09 5.26984 10.42 4.37984 11C4.34984 10.75 4.33984 10.5 4.33984 10.24C4.33984 5.69 8.28984 2 13.1698 2C18.0498 2 21.9998 5.69 21.9998 10.24C21.9998 12.94 20.6098 15.33 18.4698 16.83Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M13 15.2298C13 16.4198 12.56 17.5198 11.82 18.3898C10.83 19.5898 9.26 20.3598 7.5 20.3598L4.89 21.9098C4.45 22.1798 3.89 21.8098 3.95 21.2998L4.2 19.3298C2.86 18.3998 2 16.9098 2 15.2298C2 13.4698 2.94 11.9198 4.38 10.9998C5.27 10.4198 6.34 10.0898 7.5 10.0898C10.54 10.0898 13 12.3898 13 15.2298Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Our Forum</a>
                </li>
                <li class="item-menu my-profile <?php echo ($wp->request == "my-profile") ? "active" : ""; ?>">
                    <a href="<?php echo home_url('/my-profile'); ?>" class="links-menu">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.5902 22C20.5902 18.13 16.7402 15 12.0002 15C7.26016 15 3.41016 18.13 3.41016 22M12.0002 12C13.3262 12 14.598 11.4732 15.5357 10.5355C16.4734 9.59785 17.0002 8.32608 17.0002 7C17.0002 5.67392 16.4734 4.40215 15.5357 3.46447C14.598 2.52678 13.3262 2 12.0002 2C10.6741 2 9.4023 2.52678 8.46462 3.46447C7.52694 4.40215 7.00016 5.67392 7.00016 7C7.00016 8.32608 7.52694 9.59785 8.46462 10.5355C9.4023 11.4732 10.6741 12 12.0002 12Z"
                                stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        My Profile</a>
                </li>
                <?php if (in_array('ggsa_staff', $user_roles)): ?>
                    <li>
                        <a href="#" class="links-menu ">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.25 22H8C5.79 22 4 21 4 18V8.25C4 5 5.79 4.25 8 4.25C8 4.87 8.25 5.43 8.66 5.84C9.07 6.25 9.63 6.5 10.25 6.5H13.75C14.99 6.5 16 5.49 16 4.25C18.21 4.25 20 5 20 8.25V10.5"
                                    stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M8 13H11M8 17H9M16 4.25C16 5.49 14.99 6.5 13.75 6.5H10.25C9.63 6.5 9.07 6.25 8.66 5.84C8.25 5.43 8 4.87 8 4.25C8 3.01 9.01 2 10.25 2H13.75C14.37 2 14.93 2.25 15.34 2.66C15.75 3.07 16 3.63 16 4.25Z"
                                    stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M16.3009 18.5921C17.1791 18.5921 17.8909 17.8802 17.8909 17.0021C17.8909 16.124 17.1791 15.4121 16.3009 15.4121C15.4228 15.4121 14.7109 16.124 14.7109 17.0021C14.7109 17.8802 15.4228 18.5921 16.3009 18.5921Z"
                                    stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M11 17.4615V16.5315C11 15.9815 11.45 15.5315 12 15.5315C12.96 15.5315 13.35 14.8515 12.87 14.0215C12.59 13.5415 12.76 12.9215 13.24 12.6515L14.15 12.1215C14.57 11.8715 15.11 12.0215 15.36 12.4415L15.42 12.5415C15.9 13.3715 16.68 13.3715 17.16 12.5415L17.22 12.4415C17.47 12.0215 18.01 11.8815 18.43 12.1215L19.34 12.6515C19.82 12.9315 19.99 13.5415 19.71 14.0215C19.23 14.8515 19.62 15.5315 20.58 15.5315C21.13 15.5315 21.58 15.9815 21.58 16.5315V17.4615C21.58 18.0115 21.13 18.4615 20.58 18.4615C19.62 18.4615 19.23 19.1415 19.71 19.9715C19.99 20.4515 19.82 21.0715 19.34 21.3415L18.43 21.8715C18.01 22.1215 17.47 21.9715 17.22 21.5515L17.16 21.4515C16.68 20.6215 15.9 20.6215 15.42 21.4515L15.36 21.5515C15.11 21.9715 14.57 22.1115 14.15 21.8715L13.24 21.3415C12.76 21.0615 12.59 20.4515 12.87 19.9715C13.35 19.1415 12.96 18.4615 12 18.4615C11.45 18.4715 11 18.0215 11 17.4615Z"
                                    stroke="#FAA332" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                            Administration <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.9201 8.9502L13.4001 15.4702C12.6301 16.2402 11.3701 16.2402 10.6001 15.4702L4.08008 8.9502"
                                    stroke="#4D4F4E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                        <ul class="sub-link">
                            <li class="item-menu">
                                <a class="links-menu" href="<?php echo home_url('/report'); ?>">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/svg/lastline.svg"
                                        alt="line">
                                    Reports
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="blog-menu grow-school-network">
        <div class="img-blog">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blogMenu1.png" alt="">
        </div>
        <div class="">
            <h3 class="title-blog-menu">
                Grow our school network
            </h3>
            <p class="paragraph-blog-menu">
                Let your colleagues know what programs you are using so that they can get access as well for their
                students.
            </p>
        </div>
        <a class="btn btn-warning btn-blog"
            href="<?php echo '/referral/?fname=' . $first_name . '&lname=' . $last_name . '&uemail=' . $user_email; ?>"
            target="_blank" rel="noopener noreferrer">
            Share with my colleagues
        </a>

    </div>
    <div class="blog-menu bg-blog-menu imp-school-results">
        <div class="img-blog">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/blogMenu2.png" alt="">
        </div>
        <h3 class="title-blog-menu">
            Improve our school results
        </h3>
        <p class="paragraph-blog-menu">
            Let your principal that you are enjoying the programs so that they can sign up the whole school for free.
        </p>

        <a class="btn btn-warning btn-blog"
            href="<?php echo '/referral/?fname=' . $first_name . '&lname=' . $last_name . '&uemail=' . $user_email; ?>"
            target="_blank" rel="noopener noreferrer">
            Share with my principal
        </a>

    </div>
    <div class="block-suport support-call">
        <a href="mailto:info@goodtogreatschools.org.au" target="_blank"> <svg width="24" height="24" viewBox="0 0 24 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5.46005 18.49V15.57C5.46005 14.6 6.22005 13.73 7.30005 13.73C8.27005 13.73 9.14005 14.49 9.14005 15.57V18.38C9.14005 20.33 7.52005 21.9501 5.57005 21.9501C3.62005 21.9501 2.00005 20.32 2.00005 18.38V12.22C1.89005 6.60005 6.33005 2.05005 11.95 2.05005C17.57 2.05005 22 6.60005 22 12.11V18.2701C22 20.2201 20.38 21.84 18.43 21.84C16.48 21.84 14.86 20.2201 14.86 18.2701V15.46C14.86 14.49 15.62 13.62 16.7 13.62C17.67 13.62 18.54 14.38 18.54 15.46V18.49"
                    stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg> Support</a>
    </div>
</div>