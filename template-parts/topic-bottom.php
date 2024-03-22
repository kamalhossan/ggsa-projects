<?php

$user_id = get_current_user_id();
$post_id = get_the_ID();
$course_id = learndash_get_course_id($post_id);
$active_tab = 'peer';

// Set default value for topic-peer-sort
if (!isset($_SESSION['topic-peer-sort'])) {
    $peer_sort = isset($_POST['topic-peer-sort']) ? $_POST['topic-peer-sort'] : 'newest';
    $_SESSION['topic-peer-sort'] = $peer_sort;
} else {
    // If the session variable is already set, use its value
    $peer_sort = $_SESSION['topic-peer-sort'];
}

// If the request method is POST and 'topic-peer-sort' is set, update the session variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-peer-sort'])) {
    // Update the session variable with the value from the POST request
    $_SESSION['topic-peer-sort'] = $_POST['topic-peer-sort'];
    $peer_sort = $_SESSION['topic-peer-sort'];

}

// Set default value for topic-peer-sort
if (!isset($_SESSION['question-expert-sort'])) {
    $expert_sort = isset($_POST['question-expert-sort']) ? $_POST['question-expert-sort'] : 'newest';
    $_SESSION['question-expert-sort'] = $expert_sort;
} else {
    // If the session variable is already set, use its value
    $expert_sort = $_SESSION['question-expert-sort'];
}

// If the request method is POST and 'topic-peer-sort' is set, update the session variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question-expert-sort'])) {
    // Update the session variable with the value from the POST request
    $_SESSION['question-expert-sort'] = $_POST['question-expert-sort'];
    $expert_sort = $_SESSION['question-expert-sort'];
}
// If the request method is POST and 'topic-peer-sort' is set, update the session variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['active-tab'])) {
    // Update the session variable with the value from the POST request
    $active_tab = $_POST['active-tab'];
}

?>

<!--TOPIC LIKE ACTION-->

<div class="lesson-bottom border-top border-bottom border-1 py-3 d-flex gap-2 mb-3">
    <?php
    $liked = '';
    if(get_user_meta($user_id, get_the_ID(), true) == true){
        $liked = 'liked';
    }
    $likes_count = get_post_meta(get_the_ID(), 'topic_likes', true);
    $like_svg = get_stylesheet_directory_uri() . '/assets/svg/like.svg';
    echo '<button id="topic-like" class=" d-flex gap-1 border-1 rounded-2 px-2 border align-items-center ' . $liked . '"><img src="' . $like_svg .'">Like <span class="number">' . ($likes_count > 0 ? $likes_count : '') . '</span></button>';
    ?>
    
    <button
        class="d-flex gap-1 border-1 rounded-2 px-2 border align-items-center"
        data-bs-toggle="modal"
        data-bs-target="<?php echo '#report-' . get_the_ID();?>"
    >
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="" srcset="">
        Report Mistakes
    </button>
</div>

<!--POPUP-->
<div class="modal fade" id="<?php echo 'report-' . get_the_ID();?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold fs-4 text-black pb-0" id="modalTitleId"> Report Mistakes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="mistake-submit" action="" class="needs-validation">
                <div class="modal-body pt-1">
                    <div class="desc mb-2">
                        <p>Select the type of mistake you'd like to report! This report will be sent to the GGSA Curriculum Developer of this lesson and will be reviewed promptly!*</p>
                    </div>
                    <div class="radio-group mb-3 ">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mistaketype" id="mistaketype1" value="Missing part of assessment, typos,..." checked>
                            <label class="form-check-label" for="mistaketype1">
                                Missing part of assessment, typos,...
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mistaketype" id="mistaketype2" value="Something not understood by students">
                            <label class="form-check-label" for="mistaketype2">
                                Something not understood by students
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mistaketype" id="mistaketype3" value="Others (please specify)">
                            <label class="form-check-label" for="mistaketype3">
                                Others (please specify)
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">Describe the mistake.</label>
                        <textarea class="form-control needs-validation" name="details" id="details" rows="2" placeholder="Example: Please specify chapters in the references." required></textarea>
                        <div class="invalid-feedback">
                            Please specify chapters in the references.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Forum and Rating Part-->

<div class="d-flex flex-row align-items-center" id="topic-bottom" role="tablist">
    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 <?php echo ($active_tab == 'peer') ? 'active' : '';?>" id="peer-forum-tab" data-bs-toggle="tab" href="#peer-forum" aria-controls="peer-forum" aria-selected="false" role="tab" tabindex="-1">
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
    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 <?php echo ($active_tab == 'expert') ? 'active' : '';?>" id="expert-forum-tab" data-bs-toggle="tab" href="#expert-forum" aria-controls="expert-forum" aria-selected="false" role="tab" tabindex="-1">
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
    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100" id="rating-review-tab" data-bs-toggle="tab" href="#rating-review" aria-controls="rating-review" aria-selected="false" role="tab" tabindex="-1">
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
            " class="tab-text">Rating & Reviews</p>
        </div>
    </div>
</div>

<div class="tab-content" id="topic-bottom-content">
    <div class="tab-pane fade <?php echo ($active_tab == 'peer') ? 'active show' : '';?>" id="peer-forum" role="tabpanel" aria-labelledby="peer-forum-tab">
        <div class="row my-3">
            <div class="col-md-12">
                <div class="rounded-4 p-3 text-center">
                       <!-- peer forum start -->
                        <div class="forums-contributors my-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php get_enrolled_course_user_avater_for_current_forum($course_id);?>
                                </div>
                                <div class="col-md-6">
                                    <div class="action d-flex items-center justify-content-end ">
                                        <div class="turn-on-notification form-check form-switch d-flex p-0 position-relative">
                                            <label class="form-check-label" for="notification">Notification</label>
                                            <input class="form-check-input" type="checkbox" id="notification"/>
                                        </div>
                                        <form id="sort-peer-forums" action="" method="POST">
                                            <div class="form-group d-flex ms-2 items-center">
                                                <input type="hidden" name="active-tab" value="peer">
                                                <label for="topic-peer-sort" class="form-label mb-0">Sort</label>
                                                <select name="topic-peer-sort" id="topic-peer-sort" class="form-select  mr-sm-5 ms-3 form-control">
                                                    <option value="newest" <?php echo ($peer_sort == 'newest')? 'selected' : '';?>>Newest</option>
                                                    <option value="old" <?php echo ($peer_sort == 'old')? 'selected' : '';?>>Old</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="action ms-3">
                                            <button id="start-a-discussion" class="btn btn-primary">Start a Discussion</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SUBMIT DISCUSSION -->
                        <div class="create-form d-none">
                            <form id="new-discussion" class="mt-3 text-start" action="">
                                <div class="mb-3">
                                    <label for="forum-title" class="form-label">Title</label>
                                    <input name="forum-title" id="forum-title" type="text" id="forum-title" class="form-control p-2" placeholder="Write a descriptive title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="forum-desc" class="form-label">Your post</label>
                                    <textarea class="form-control" name="forum-desc" id="forum-desc" rows="3" required></textarea>
                                    <span id="char-limit">0/500</span>
                                    <input type="hidden" id="topic-id" name="topic-id" value="<?= get_the_ID();?>">
                                    <input type="hidden" id="topic-course-id" name="topic-course-id" value="<?=  $course_id; ?>">
                                </div>
                                <div class="text-end">
                                    <button type="submit" id="create-submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                        <?php
                        $term_id = get_post_meta($course_id, 'has_peer_conversations', true);
                        if($term_id){

                            $peer_forum_args = array(
                                'post_type'      => 'peer-forum',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    'relation' => 'AND',
                                        array(
                                        'taxonomy' => 'topics',
                                        'field' => 'id',
                                        'terms' => $term_id,
                                    ),
                                )
                            );

                            if($peer_sort == 'old'){
                                $peer_forum_args['order'] = 'ASC';
                                $peer_forum_args['orderby'] = 'date';
                            }

                            $peer_forum_query = new WP_Query($peer_forum_args);
                            if($peer_forum_query->have_posts()){
                                while($peer_forum_query->have_posts()){
                                    $peer_forum_query->the_post();
                                    $post_id = get_the_ID();
                                    peer_forum_topics_template_item($post_id);
                                }   
                            }

                            
                        } else { ?>
                            <div class="chats-emtpy my-3 items-center text-center d-flex flex-column">
                                <img width="64px" height="64px" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/no-comment.svg';?>" alt="no chats">
                                <p class="text-[#4d4f4e]">                        
                                        There are no conversations created or saved here.;
                                </p>
                            </div>
                        <?php  
                        }
                        ?>
                       <!-- peer forum end -->
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade <?php echo ($active_tab == 'expert') ? 'active show' : '';?>" id="expert-forum" role="tabpanel" aria-labelledby="expert-forum-tab">
        <div class="row my-3">
            <div class="col-md-12">
            <div class="rounded-4 p-3 text-center">
                    <!-- Expert forum start -->
                    <!-- CREATE QUESTIONS -->
                    <div class="create-question">
                        <form id="new-question" class="needs-validation" action="">
                            <div class="mb-3 text-start">
                                <input type="hidden" id="ques-course-id" name="ques-course-id" value="<?=  $course_id ?>">
                                <label for="forum-qus-desc" class="form-label text-start w-100">Your Question</label>
                                <textarea class="form-control" name="forum-qus-desc" id="forum-qus-desc" rows="3" placeholder="Describe your question." required></textarea>
                                <span id="char-limit-qus" class="text-start w-100">0/500</span>
                            </div>
                            <div class="mb-3 text-end">
                                <button type="submit" id="ques-create" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                    <!--  CREATE QUESTIONS -->
                    <div class="forums-contributors my-3">
                        <div class="row">
                            <div class="col-md-6">
                                <?php get_enrolled_course_user_avater_for_current_forum($course_id);?>
                            </div>
                            <div class="col-md-6">
                                <div class="action d-flex items-center justify-content-end ">
                                    <div class="turn-on-notification form-check form-switch d-flex p-0 position-relative">
                                        <label class="form-check-label" for="notification">Notification</label>
                                        <input class="form-check-input" type="checkbox" id="notification"/>
                                    </div>
                                    <form id="sort-expert-forums" action="" method="POST">
                                        <div class="form-group d-flex ms-2 items-center">
                                            <input type="hidden" name="active-tab" value="expert">
                                            <label for="question-expert-sort" class="form-label mb-0">Sort</label>
                                            <select name="question-expert-sort" id="question-expert-sort" name="question-expert-sort" class="form-select  mr-sm-5 ms-3 form-control">
                                                <option value="newest" <?php echo ($expert_sort == 'newest') ? 'selected' : '';?> >Newest</option>
                                                <option value="old" <?php echo ($expert_sort == 'old') ? 'selected' : '';?> >Old</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $term_id = get_post_meta($course_id, 'has_expert_conversation', true);
                        if($term_id){

                            $peer_forum_args = array(
                                'post_type'      => 'expert-forum',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    'relation' => 'AND',
                                        array(
                                        'taxonomy' => 'question',
                                        'field' => 'id',
                                        'terms' => $term_id,
                                    ),
                                )
                            );

                            if($expert_sort == 'old'){
                                $peer_forum_args['order'] = 'ASC';
                                $peer_forum_args['orderby'] = 'date';
                            }

                            $peer_forum_query = new WP_Query($peer_forum_args);
                            if($peer_forum_query->have_posts()){
                                while($peer_forum_query->have_posts()){
                                    $peer_forum_query->the_post();
                                    $post_id = get_the_ID();
                                    expert_forum_questions_template_item($post_id);
                                }   
                            }

                            
                        } else { ?>
                            <div class="chats-emtpy my-3 items-center text-center d-flex flex-column">
                                <img width="64px" height="64px" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/no-comment.svg';?>" alt="no chats">
                                <p class="text-[#4d4f4e]">                        
                                        There are no conversations created or saved here.;
                                </p>
                            </div>
                        <?php  
                        }
                    ?>
                    <!-- Expert forum end -->
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade " id="rating-review" role="tabpanel" aria-labelledby="rating-review-tab">
        <?php get_template_part('template-parts/topic', 'rating');?>
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