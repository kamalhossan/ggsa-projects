<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$current_user = $args['current_user'];
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar($user_id);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];
$user_notifications = user_get_notification($user_id);

?>

<main class="px-0 py-2 bg-[#F6F6F6]">
  <header class="grid resource-header items-center">
      <div class="d-flex gap-4 items-center">
          <h1 class="text-[40px] text-[#161C24] font-bold p-0 m-0"><?php echo get_the_title(); ?></h1>
          <button id="tour-popup" class="btn btn-primary resources">Begin Tour</button>
      </div>
      <div id="res-ss" class="ss-search mr-3 position-relative">
            <input type="text" id="resourcesearch" name="resourcesearch" placeholder="Search Resources" class="item-search">
            <a class="search-clear text-[14px] text-[#161c24] lh-base underline hidden mr-[35px]">Clear</a>
            <div class="ss-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M11 20C15.9706 20 20 15.9706 20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20Z"
                        stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M22 22L18 18" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div id="search-resource" style="display: none" class="search-resource shadow-lg p-3 mb-5 bg-body rounded w-100">
            </div>
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
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>