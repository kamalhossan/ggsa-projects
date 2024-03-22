<?php

$taxonomy = 'question';
$term = get_queried_object();
$term_name = $term->name;
$term_id = $term->term_id;
$course_id = get_term_meta($term_id, 'course_id', true);

// Set default value for expert-sort
if (!isset($_SESSION['expert-sort'])) {
    $expert_sort = isset($_POST['expert-sort']) ? $_POST['expert-sort'] : 'recent';
    $_SESSION['expert-sort'] = $expert_sort;
} else {
    // If the session variable is already set, use its value
    $expert_sort = $_SESSION['expert-sort'];
}

// If the request method is POST and 'expert-sort' is set, update the session variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expert-sort'])) {
    // Update the session variable with the value from the POST request
    $_SESSION['expert-sort'] = $_POST['expert-sort'];
    $expert_sort = $_SESSION['expert-sort'];

    if(isset(($_POST['question-search']))){
        $keyword = sanitize_text_field($_POST['question-search']);
    }
}

?>

<div class="expert-forum-topic-list bg-[#fff] rounded-4 p-3 my-3">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="title flex-1 d-flex gap-2 items-center">
                        <button class="go-back btn bg-[#b4b9b9] rounded-2"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/icon-goback.svg';?>" alt="" srcset=""></button>
                        <h4 class="fw-bold fs-4 text-[#161C24] text-truncate" data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="<?= $term_name;?>"><?= $term_name;?></h4>                                    
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="action d-flex items-center justify-content-around">
                        <div class="turn-on-notification form-check form-switch d-flex p-0 position-relative">
                            <label class="form-check-label" for="notification">Notification</label>
                            <input class="form-check-input" type="checkbox" id="notification"/>
                        </div>
                        <form id="expert-search" action="" method="post">
                            <div class="action d-flex">
                                <div class="form-group row align-items-center">
                                    <label for="question-search" class="col-sm-3 col-form-label">Search</label>
                                    <div class="col-sm-9 ps-0">
                                    <input type="text" name="question-search" class="form-control px-2" id="question-search" id="question-search" placeholder="Question" value="<?php echo (isset($_POST['question-search'])) ? $keyword : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group d-flex ms-2">
                                    <label for="expert-sort" class="col-sm-2 col-form-label">Sort</label>
                                    <select name="expert-sort" id="expert-sort" class="form-select  mr-sm-5 ms-3 form-control">
                                        <option value="recent" <?php echo ($expert_sort == 'recent') ? 'selected' : '';?>>Recent</option>
                                        <option value="top" <?php echo ($expert_sort == 'top') ? 'selected' : '';?>>Top</option>
                                    </select>
                                    <input type="hidden" name="tabs-name" id="tabs-name" value="expert">
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
                        <h4 class="fw-bold fs-5 text-[#161C24]">Have a question? You're in the right place.</h4>
                        <p class="mt-1 text-[#4D4F4E]">Our role is to empower our members with professional expert knowledge so they can excel at effective teaching.</p>
                </div>
                <div class="action w-25 text-end">
                    <button id="ask-a-question" class="btn btn-primary">Ask a Question</button>
                </div>
                </div>
            </div>
            <!-- CREATE QUESTIONS -->
            <div class="create-form p-3 border-1 border rounded-3 mt-3 d-none">
                <h4 class="fw-bold fs-4">Ask a Question</h4>
                <form id="new-question" class="mt-3 needs-validation" action="">
                    <div class="mb-3">
                        <label for="forum-qus-name" class="form-label">Forum</label>
                        <select class="form-select" name="forum-qus-name" id="forum-qus-name">
                            <option value="<?= $course_id;?>" selected><?= $term_name; ?></option>
                        </select>
                    </div> 
                    <div class="mb-3">
                        <label for="forum-qus-desc" class="form-label">Your Question</label>
                        <textarea class="form-control" name="forum-qus-desc" id="forum-qus-desc" rows="3" placeholder="Please provide supporting details or context." required></textarea>
                        <span id="char-limit-qus">0/500</span>
                    </div>
                    <div class="mb-3 text-end">
                        <span class="btn btn-outline-primary create-cancel">Cancel</span>
                        <button type="submit" id="ques-create" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
            <!--  CREATE QUESTIONS -->
            <div class="questions">
            <?php
            if(have_posts()){
                $counter = 0;
                while(have_posts()){
                    the_post();
                    $counter++;
                    expert_forum_questions_template_item(get_the_ID(), $counter);
    
                }
            } else {
                // If no posts are found, show a message
                echo "No posts found.";
            }
            ?>
            </div>
            <div class="pagination d-flex gap-2 items-center justify-content-center mt-3">
                <?php
                $big = 999999999; // need an unlikely integer
                // $total = $question_query->max_num_pages;
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
            <?php get_template_part('template-parts/forum', 'expert-sidebar'); ?>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>