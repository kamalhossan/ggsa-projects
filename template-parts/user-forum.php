<?php

$current_user = $args['current_user'];
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar($user_id);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];
$user_notifications = user_get_notification($user_id);
$tabs_name = isset($_POST['tabs-name']) ? $_POST['tabs-name'] : 'peer';

?>

<header class="grid forum-header items-center">
    <div class="d-flex gap-4 items-center">
        <h1 class="text-[40px] text-[#161C24] font-bold p-0 m-0"><?php echo get_the_title(); ?></h1>
        <button id="tour-popup" class="btn btn-primary resources">Begin Tour</button>
    </div>
    <div id="forum-ss" class="ss-search mr-3 position-relative">
        <input type="text" id="forum-search" name="forum-search" placeholder="Search Forum" class="item-search">
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
        <div id="search-forum" class="search-resource shadow-lg p-3 mb-5 bg-body rounded w-100 d-none">
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

<div class="d-flex flex-row align-items-center mt-3" id="school-forum" role="tablist">
    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 <?php echo ($tabs_name == 'peer') ? 'active' : ''; ?>" id="peer-forum-tab" data-bs-toggle="tab" href="#peer-forum" aria-controls="peer-forum" aria-selected="false" role="tab" tabindex="-1">
        <svg style="height: 36px" class="w-100" viewBox="0 0 193 40" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_6543_11707)">
                <path d="M192 39H3C7.44526 31.4494 17.5052 14.7507 20.9343 9.47189C24.6131 3.80862 27.5968 3.00002 31.2756 3H160.73C167.352 3 169.927 5.83146 171.766 8.66292L192 39Z" fill="currentColor"></path>
            </g>
            <defs>
                <filter id="filter0_d_6543_11707" x="0" y="0" width="193" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                    <feOffset dx="-1" dy="-1"></feOffset>
                    <feGaussianBlur stdDeviation="1"></feGaussianBlur>
                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0"></feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6543_11707"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6543_11707" result="shape"></feBlend>
                </filter>
            </defs>
        </svg>
        <div style="top: 8px; left: 0; right: 0%;" class="position-absolute">
            <p style="text-overflow: ellipsis;
            font-size: 16px;
            position: absolute;
            text-align: center;
            width: 100%;
            max-width: 93%;
            white-space: nowrap;
            overflow: hidden;
            color: #7A7B7A;
            " class="tab-text">Peer Forum</p>
        </div>
    </div>
    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 <?php echo ($tabs_name == 'expert') ? 'active' : ''; ?>" id="expert-forum-tab" data-bs-toggle="tab" href="#expert-forum" aria-controls="expert-forum" aria-selected="false" role="tab" tabindex="-1">
        <svg style="height: 36px" class="w-100" viewBox="0 0 193 40" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_6543_11707)">
                <path d="M192 39H3C7.44526 31.4494 17.5052 14.7507 20.9343 9.47189C24.6131 3.80862 27.5968 3.00002 31.2756 3H160.73C167.352 3 169.927 5.83146 171.766 8.66292L192 39Z" fill="currentColor"></path>
            </g>
            <defs>
                <filter id="filter0_d_6543_11707" x="0" y="0" width="193" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                    <feOffset dx="-1" dy="-1"></feOffset>
                    <feGaussianBlur stdDeviation="1"></feGaussianBlur>
                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0"></feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6543_11707"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6543_11707" result="shape"></feBlend>
                </filter>
            </defs>
        </svg>
        <div style="top: 8px; left: 0; right: 0%;" class="position-absolute">
            <p style="text-overflow: ellipsis;
            font-size: 16px;
            position: absolute;
            text-align: center;
            width: 100%;
            max-width: 93%;
            white-space: nowrap;
            overflow: hidden;
            color: #7A7B7A;
            " class="tab-text">Expert Forum</p>
        </div>
    </div>
    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 <?php echo ($tabs_name == 'mychats') ? 'active' : ''; ?>" id="rating-review-tab" data-bs-toggle="tab" href="#rating-review" aria-controls="rating-review" aria-selected="false" role="tab" tabindex="-1">
        <svg style="height: 36px" class="w-100" viewBox="0 0 193 40" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_6543_11707)">
                <path d="M192 39H3C7.44526 31.4494 17.5052 14.7507 20.9343 9.47189C24.6131 3.80862 27.5968 3.00002 31.2756 3H160.73C167.352 3 169.927 5.83146 171.766 8.66292L192 39Z" fill="currentColor"></path>
            </g>
            <defs>
                <filter id="filter0_d_6543_11707" x="0" y="0" width="193" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                    <feOffset dx="-1" dy="-1"></feOffset>
                    <feGaussianBlur stdDeviation="1"></feGaussianBlur>
                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                    <feColorMatrix type="matrix" values="0 0 0 0 0.121667 0 0 0 0 0.121363 0 0 0 0 0.121363 0 0 0 0.1 0"></feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6543_11707"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6543_11707" result="shape"></feBlend>
                </filter>
            </defs>
        </svg>
        <div style="top: 8px; left: 0; right: 0%;" class="position-absolute">
            <p style="text-overflow: ellipsis;
            font-size: 16px;
            position: absolute;
            text-align: center;
            width: 100%;
            max-width: 93%;
            white-space: nowrap;
            overflow: hidden;
            color: #7A7B7A;
            " class="tab-text">My Chats</p>
        </div>
    </div>
</div>

<div class="tab-content" id="school-forum-content">
    <div class="tab-pane fade <?php echo ($tabs_name == 'peer') ? 'active show' : '';?>" id="peer-forum" role="tabpanel" aria-labelledby="peer-forum-tab">
        <?php get_template_part('template-parts/forum', 'peer'); ?>
    </div>
    <div class="tab-pane fade <?php echo ($tabs_name == 'expert') ? 'active show' : '';?>" id="expert-forum" role="tabpanel" aria-labelledby="expert-forum-tab">
        <?php get_template_part('template-parts/forum', 'expert'); ?>
    </div>
    <div class="tab-pane fade <?php echo ($tabs_name == 'mychats') ? 'active show' : '';?>" id="rating-review" role="tabpanel" aria-labelledby="rating-review-tab">
        <?php get_template_part('template-parts/forum', 'mychats'); ?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="reportSpam" tabindex="-1" role="dialog" aria-labelledby="reportSpam" aria-hidden="true">
    <div class="modal-dialog rounded-4 modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="spam-report" class="needs-validation" action="">
                <div class="modal-header border-0">
                    <h4 class="fs-4 modal-title fw-bold" id="reportSpam">Report as Inappropriate</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <h5 class="text-[#161c24] mb-2">Select the issue you want to report</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reportSpamField" id="spam" value="spam" checked>
                        <label class="form-check-label text-[#161c24]" for="spam">Spam</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="reportSpamField" id="language" value="language">
                        <label class="form-check-label text-[#161c24]" for="language">Sensitive language</label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="reportSpamField" id="other" value="other">
                        <label class="form-check-label text-[#161c24]" for="other">Others (please specify)</label>
                        </div>
                        <textarea name="issue-details" id="issueDetails" rows="2" placeholder="Please specify the issue you want to report" class="form-control mt-2" required></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3">Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" -->
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>