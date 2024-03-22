<?php

$taxonomy = 'topics';
$term = get_queried_object();
$term_name = $term->name;
$term_id = $term->term_id;
$course_id = get_term_meta($term_id, 'course_id', true);

// Set default value for peer-sort
if (!isset($_SESSION['peer-sort'])) {
    $peer_sort = isset($_POST['peer-sort']) ? $_POST['peer-sort'] : 'recent';
    $_SESSION['peer-sort'] = $peer_sort;
} else {
    // If the session variable is already set, use its value
    $peer_sort = $_SESSION['peer-sort'];
}

// If the request method is POST and 'peer-sort' is set, update the session variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['peer-sort'])) {
    // Update the session variable with the value from the POST request
    $_SESSION['peer-sort'] = $_POST['peer-sort'];
    $peer_sort = $_SESSION['peer-sort'];

    if(isset(($_POST['topic-search']))){
        $keyword = sanitize_text_field($_POST['topic-search']);
    }
}

?>
<div class="peer-forum-topic-list bg-[#fff] rounded-4 p-3 my-3">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="title flex-1 d-flex gap-2 items-center">
                        <button class="go-back btn bg-[#b4b9b9] rounded-2"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/icon-goback.svg';?>" alt="" srcset=""></button>
                        <h4 class="fw-bold fs-4 text-[#161C24] text-truncate" data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="<?= $term_name;?>"><?= $term_name?></h4>                                    
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="action d-flex items-center justify-content-around ">
                        <div class="turn-on-notification form-check form-switch d-flex p-0 position-relative">
                            <label class="form-check-label" for="notification">Notification</label>
                            <input class="form-check-input" type="checkbox" id="notification"/>
                        </div>
                        <form id="peer-search" action="" method="post">
                            <div class="action d-flex">
                                <div class="form-group row align-items-center">
                                    <label for="topic-search" class="col-sm-3 col-form-label">Search</label>
                                    <div class="col-sm-9 ps-0">
                                    <input type="text" name="topic-search" class="form-control px-2" id="topic-search" placeholder="Topics" value="<?php echo (isset($_POST['topic-search'])) ? $keyword : '';?>">
                                    </div>
                                </div>
                                <div class="form-group d-flex ms-2">
                                    <label for="peer-sort" class="col-sm-2 col-form-label">Sort</label>
                                    <select name="peer-sort" class="form-select  mr-sm-5 ms-3 form-control" id="peer-sort">
                                        <option value="recent"<?php echo ($peer_sort == 'recent') ? 'selected' : '';?>>Recent</option>
                                        <option value="top" <?php echo ($peer_sort == 'top') ? 'selected' : '';?>>Top</option>
                                    </select>
                                    <input type="hidden" name="tabs-name" id="tabs-name" value="peer">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="forums-contributors my-3">
                <?php
                    if($course_id){
                        get_enrolled_course_user_avater_for_current_forum($course_id);
                    }
                ?>
            </div>
            <div class="start-discussion p-3 rounded-3 mt-3 bg-[#FEF4D5]">
                <div class="d-flex justify-content-between align-items-center">
                <div class="descriptions">
                        <h4 class="fw-bold fs-5 text-[#161C24]">Start a discussion with your peer.</h4>
                        <p class="mt-1 text-[#4D4F4E]">Let's raise the topic so everyone can discuss together!</p>
                </div>
                <div class="action">
                    <button id="start-a-discussion" class="btn btn-primary">Start a Discussion</button>
                </div>
                </div>
            </div>
            <!-- SUBMIT DISCUSSION -->
            <div class="create-form p-3 border-1 border rounded-3 mt-3 d-none">
                <h4 class="fw-bold fs-4">Start a Discussion</h4>
                <form id="new-discussion" class="mt-3" action="">
                    <div class="mb-3">
                        <label for="courseid" class="form-label">Forum</label>
                        <select class="form-select" name="courseid" id="courseid">
                            <option value="<?= $course_id;?>" selected><?= $term_name; ?></option>
                             <?php
                            // foreach($user_course_names as $course){
                            //     echo '<option value="'. $course["id"] .'">'. $course["course_title"] . '</option>';
                            // }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="topicid" class="form-label">Topic</label>
                        <select class="form-select" name="topicid" id="topicid">
                            <option selected disabled>Please select a topic</option>
                            <?php
                            // foreach($user_topics_name as $topic){
                            //     echo '<option value="'. $topic["id"] .'">'. $topic["topic_name"] . '</option>';
                            // }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="forum-title" class="form-label">Title</label>
                        <input name="forum-title" id="forum-title" type="text" id="forum-title" class="form-control p-2" placeholder="Write a descriptive title">
                        <span id="title-limit">0/80</span>
                    </div>
                    <div class="mb-3">
                        <label for="forum-desc" class="form-label">Your post</label>
                        <textarea class="form-control" name="forum-desc" id="forum-desc" rows="3"></textarea>
                        <span id="char-limit">0/500</span>
                    </div>
                    <div class="text-end">
                        <span class="btn btn-outline-primary create-cancel">Cancel</span>
                        <button type="submit" id="diss-create" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
            <!-- SUBMIT DISCUSSION END -->
            <div class="forums">
                <?php
                if(have_posts()){
                    // Loop through the topics
                    while (have_posts() ) {
                        the_post();
                        peer_forum_topics_template_item(get_the_ID());
                    } 
                    wp_reset_postdata();
                }
                ?>
            </div>
            <div class="pagination d-flex gap-2 items-center justify-content-center mt-3">
                <?php
                $big = 999999999; // need an unlikely integer
                // $total = $topic_query->max_num_pages;
                $prev_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-left.svg';
                $next_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-right.svg';

                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    // 'total' => $total,
                    'prev_text' => '<img src="'. $prev_img .'">',
                    'next_text' => '<img src="'. $next_img .'">',
                ) );
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <?php get_template_part('template-parts/forum', 'peer-sidebar'); ?>
        </div>
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