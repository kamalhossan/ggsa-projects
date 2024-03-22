<?php

$taxonomy = 'topics';
$post_id = get_the_ID();
$author_id = get_post_field('post_author', get_the_id());
$user_avatar = get_user_meta($author_id, 'user_avatar_url', true);
$post_time = get_the_date('Y-m-d H:i:s',get_the_ID());
$topic_title = get_post_meta($post_id, 'topic_title', true);
$parent_category_name = get_post_meta($post_id, 'course_parent_category', true);
$post_terms = get_the_terms($post_id, $taxonomy );

if($post_terms && ! is_wp_error($post_terms)){
    $term_name = $post_terms[0] -> name;
    $term_slug = get_term_link($post_terms[0]);
}

?>
<!--with comment response layout-->
<div class="single-topic mb-5">
    <div class="forum-topic-single bg-[#fff] rounded-4 p-3">
        <div class="row">
            <div class="col-md-12">
                <div class="forum-topic-single-top p-2 border-0 d-flex gap-2 mb-2 items-center">
                    <button class="go-back btn bg-[#b4b9b9] rounded-2"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/icon-goback.svg';?>" alt="goback" srcset=""></button>
                    <span class="status rounded-2 bg-[#FFE8DB] px-2 text-[#E52E2E]">New</span>
                    <?php
                    if($parent_category_name){
                        echo '<span class="category rounded-2 px-2 bg-[#E1EEFF] text-[#1B61F9]">'. $parent_category_name .'</span>';
                    }
                    if($term_name){
                        echo '<span class="course rounded-2 px-2 bg-[#EDFDDC] text-[#1A8319]"><a href="'. $term_slug .'">' . $term_name .'</a></span>';
                    }
                    if($topic_title){
                        echo '<span class="type rounded-2 px-2 bg-[#FFFAD8] text-[#FBBC16]">' . $topic_title . '</span>';
                    }
                    ?>
                </div>
                <div class="forum-topic-single-body my-3">
                    <div class="creator d-flex gap-2 items-center mb-3">
                        <?php
                        if ($user_avatar == "") {
                            echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
                        } else {
                            echo '<img alt="" src="' . $user_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
                        }
                        ?>
                        <p class="creator-name fw-bold m-0 text-[#4d4f4e]"><?php the_author();?></p>
                    </div>
                    <h2 class="fw-bold fs-4 text-[#4D4F4E] mb-2"><?= the_title();?></h2>
                    <div class="desc text-[#4D4F4E]">
                        <?= the_content();?>
                    </div>
                    <div class="forum-topic-single-bottom pb-3 mt-3 d-flex justify-content-between items-center border-bottom">
                        <div class="question-action d-flex gap-2">
                            <button id="<?php echo 'post-likes-' . $post_id;?>" class="d-flex post-like gap-1 border-1 rounded-3 px-2 py-1 border align-items-center ">
                            <?php
                                $like_count = get_post_meta($post_id, 'post_likes', true);
                                if($like_count == 0){
                                    $like_count = '';
                                }
                                $user_post_like_meta = 'user-liked-' . $post_id;
                                if(get_user_meta(get_current_user_id(), $user_post_like_meta, true) == true){
                                    $img_url = '/assets/svg/unlike.svg';
                                } else {
                                    $img_url = '/assets/svg/like.svg';
                                }
                            ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . $img_url;?>">	
                            Like <span class="number"><?= $like_count;?></span></button>   

                            <button class="curr-qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count"><?= get_comments_number();?></span>
                            </button>
                            
                           <?php if($author_id != get_current_user_id()){ ?>
                            <button id="<?php echo 'forum-save-' . $post_id;?>" class="save-diss d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center">
                            <?php
                                $post_saved_meta = 'user-saved-'. $post_id;
                                $check_meta = get_user_meta( get_current_user_id(), $post_saved_meta, true);
                                if($check_meta == true){
                                    $img_url = '/assets/svg/saved.svg';
                                } else {
                                    $img_url = '/assets/svg/unsaved.svg';
                                }
                                ?>
                            <img src="<?php echo get_stylesheet_directory_uri() . $img_url;?>" alt="save Discussion" srcset="">Save Discussion
                            </button> 

                            <?php }?>

                            <button id="<?php echo 'spam-' . $post_id;?>" class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                        </div>
                    </div>

                    <div class="forum-topic-single-comment">
                        <?php
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
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