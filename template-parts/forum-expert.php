<?php

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

<div class="expert-forum bg-[#fff] rounded-4 p-3 my-3">
    <div class="row">
        <div class="col-md-9">
            <div class="header d-flex justify-content-between">
                <div class="title flex-1">
                    <h4 class="fw-bold fs-3 text-[#161C24] p-0 m-0">All Expert Forums</h4>
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
                            <option selected disabled>Please select a forum</option>
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

            $paged = ( get_query_var( 'expert' ) ) ? get_query_var( 'expert' ) : 1;
            // Define the query arguments
            $args = array(
                'post_type'      => 'expert-forum',
                'posts_per_page' => 5,
                'paged' => $paged,
                // 'tax_query' => array(
                //     'relation' => 'AND', array(
                //        'taxonomy' => 'forum',
                //        'field' => 'slug',
                //        'terms' => 'expert',
                //     )
                // )
            );

            if($expert_sort == 'top'){
                $args['orderby'] = 'comment_count';
                $args['order'] = 'DESC';
            }

            if(isset(($_POST['question-search']))){
                $args['s'] = sanitize_text_field($_POST['question-search']);
            }


            // Create a new WP_Query instance
            $question_query = new WP_Query( $args );

            if($question_query -> have_posts()){
                // Loop through the topics
                $counter = 0;
                while ( $question_query->have_posts() ) {
                    $question_query->the_post(); 
                    $counter++;
                    expert_forum_questions_template_item(get_the_ID(), $counter);
                }
                wp_reset_postdata();
            }  else { ?>
                <!--no chats founds-->
                <div class="chats-emtpy my-3 items-center text-center d-flex flex-column">
                    <img width="64px" height="64px" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/no-comment.svg';?>" alt="no chats">
                    <p class="text-[#4d4f4e]">
                        <?php if (isset(($_POST['question-search']))){
                            echo 'Sorry, we couldn’t find a match for, “'. $keyword . '”. Please try another search.';  
                        }else {
                            echo 'There are no conversations created or saved here.';
                        }?>    
                    </p>
                </div>
                <!--no chats founds end-->
            <?php
            }
            ?>
            </div>
            <div class="pagination d-flex gap-2 items-center justify-content-center mt-3">
                <?php
                $big = 999999999; // need an unlikely integer
                $total = $question_query->max_num_pages;
                $prev_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-left.svg';
                $next_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-right.svg';

                echo paginate_links( array(
                    // 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'base' => add_query_arg( 'expert', '%#%' ),
                    'format' => '?expert=%#%',
                    'current' => max( 1, get_query_var('expert') ),
                    'total' => $total,
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

<script src="https://cdn.tailwindcss.com"></script>