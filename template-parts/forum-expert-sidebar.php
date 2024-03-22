<?php

// Define the query arguments

$expert_args = array(
    'post_type'      => 'expert-forum',
    'posts_per_page' => -1,
    // 'tax_query' => array(
    //     'relation' => 'AND', array(
    //        'taxonomy' => 'forum',
    //        'field' => 'slug',
    //        'terms' => 'expert',
    //     )
    // )
);

// Create a new WP_Query instance
$expert_query = new WP_Query( $expert_args );
$total_question = $expert_query -> found_posts;

// Get post IDs from the query results
$post_ids = wp_list_pluck($expert_query->posts, 'ID');

$total_discussion = 0;
foreach($post_ids as $id){
    $comment_count = get_comments_number($id);
    $total_discussion += $comment_count;
}

$taxonomy = 'question';
$expert_terms = get_terms( array(
    'taxonomy'   => $taxonomy,
    'hide_empty' => true,
) );

$top_questions = [];
foreach($expert_terms as $term){

    $term_id = $term -> term_id;
    $term_count = $term -> count;
    $top_questions[$term_id] = $term_count;
}

arsort($top_questions);

$top_contributors = [];

?>

<div class="peer-sidebar">
    <div class="topic-counter">
        <div class="d-flex rounded-2 border border-1 py-3 justify-content-center">
            <div class="topic p-3 border-end w-100">
                <h2 class="text-[#1B61F9] mb-1 p-0 fs-6">Questions</h2>
                <h4 class="fs-4 text-[#FAA332] fw-bold p-0 m-0"><?= $total_question; ?></h4>
            </div>
            <div class="discussion p-3 w-100">
                <h2 class="text-[#1B61F9] mb-1 p-0 fs-6">Answers</h2>
                <h4 class="fs-4 fw-bold text-[#00859C] p-0 m-0"><?php echo $total_discussion;?></h4>
            </div>
        </div>
    </div>
    <?php
    
    $user_post_peer_forum_args = array(
        'post_type'      => 'expert-forum',
        'posts_per_page' => -1,
        'author'         => get_current_user_id(),
    );

    $user_post_forum_query = new WP_Query($user_post_peer_forum_args);

    $found_post = $user_post_forum_query -> found_posts;
    if($found_post){

        $user_post_ids =  wp_list_pluck( $user_post_forum_query->posts, 'ID' );

        $your_forums = get_user_meta( get_current_user_id(), 'commented_post_ids', true);

        if($your_forums){
            $all_expert_forum_by_user = array_merge($user_post_ids, $your_forums);
        } else {
            $all_expert_forum_by_user = $user_post_ids; 
        }

    } else {
        $all_expert_forum_by_user = get_user_meta( get_current_user_id(), 'commented_post_ids', true);
        if(! $all_expert_forum_by_user){
            $all_expert_forum_by_user = array(0);
        }
    }

    wp_reset_postdata();
    
    $your_forum_args = array(
        'post_type'      => 'expert-forum',
        'posts_per_page' => -1,
        'post__in'       => $all_expert_forum_by_user,
    );

    $your_forum_query = new WP_Query($your_forum_args);

    if($your_forum_query->have_posts()){ ?>
        <div class="your-forums mt-3">
            <div class="rounded-3 border border-1 p-3">
                <h4 class="fw-bold text-[#161C24]">Your Forums</h4> 
                <div class="forums-activity mt-3 overflow-auto max-h-44">
                    <?php
                        while($your_forum_query->have_posts()){
                            $your_forum_query->the_post();
                            $post_id = get_the_ID();
                            $course_id = get_post_meta($post_id, 'course_id', true);
                            $course_title = get_the_title($course_id);
                            $course_thumbnail = get_the_post_thumbnail_url($course_id, 'course-thumb');
                            if(empty($course_thumbnail)){
                                $course_thumbnail = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
                            }
                            ?>
                            <!--Forum Start-->
                            <a href="<?= the_permalink($post_id);?>">
                                <div class="activity-card mb-2 d-flex gap-2">
                                    <div class="cover-img overflow-hidden">
                                        <img width="100%" height="100%" src="<?= $course_thumbnail?>" alt="<?= $course_title;?>">
                                    </div>
                                    <div class="forums-summary w-75">
                                        <h4 class="text-truncate fw-bold text-[#4C4C4C] p-0 m-0 fs-5"><?php the_title();?></h4>
                                        <div class="forums-discussion d-flex">
                                            <img width="16px" height="16px" class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="" srcset="">
                                            <span class="text-[#7A7B7A]"><?php echo get_comments_number($post_id);?> discussions</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!--Forum End-->
                            <?php
                        } 
                    ?>
                </div>
            </div>
        </div>

    <?php

    }
    ?>
    <div class="top-contributors mt-3">
        <div class="rounded-3 border border-1 p-3">
            <h4 class="fw-bold text-[#161C24]">Top Contributors</h4> 
            <div class="top-contributors-list mt-3">
                <div class="d-flex flex-row align-items-center" id="top-contributors-expert" role="tablist">
                    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 active" id="expert-my-school-tab" data-bs-toggle="tab" href="#expert-my-school" aria-controls="expert-my-school" aria-selected="false" role="tab" tabindex="-1">
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
                            " class="tab-text">My School</p>
                        </div>
                    </div>
                    <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100" id="expert-all-school-tab" data-bs-toggle="tab" href="#expert-all-school" aria-controls="expert-all-school" aria-selected="false" role="tab" tabindex="-1">
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
                            " class="tab-text">All School</p>
                        </div>
                    </div>
                </div>
                <div class="tab-content mt-3" id="top-contributors-expert-content">
                    <div class="tab-pane fade active show" id="expert-my-school" role="tabpanel" aria-labelledby="expert-my-school-tab">
                        <?php my_school_top_contributors();?>
                    </div>
                    <div class="tab-pane fade " id="expert-all-school" role="tabpanel" aria-labelledby="expert-all-school-tab">
                        <?php all_school_top_contributors();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    if(!empty($top_questions)){ ?>
    <div class="hot-topics mt-3">
        <div class="rounded-3 border border-1 p-3">
            <h4 class="fw-bold text-[#161C24]">Top Questions</h4> 
            <div class="hot-topics-list">
                <?php
                    $topic_limit = 0;
                    foreach($top_questions as $term_id => $term_count){
                        $topic_limit++;
                        if($topic_limit >= 6){
                            break;
                        }
                        $term  = get_term_by('id', $term_id, $taxonomy);
                        $term_name = $term -> name;
                        $term_link = get_term_link($term_id, $taxonomy);

                        $discussion_args = array(
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                'relation' => 'AND', array(
                                'taxonomy' => $taxonomy,
                                'field' => 'id',
                                'terms' => $term_id,
                                )
                            )
                        );

                        $diss_query = new WP_Query( $discussion_args );
                        // Get post IDs from the query results
                        $term_post_ids = wp_list_pluck($diss_query->posts, 'ID');

                        $post_discussion = 0;
                        foreach($term_post_ids as $id){
                            $comment_count = get_comments_number($id);
                            $post_discussion += $comment_count;
                        }
                        ?>
                        <!--Topics Item Start-->
                        <a href="<?= $term_link;?>">
                            <div class="topics-card mt-3">
                                <h4 class="fw-bold topic-cat text-[#4D4F4E] p-0 m-0 fs-6"><?= $term_name;?></h4>
                                <span class="text-[#7A7B7A] dis-count"><?= $post_discussion . ' discussions';?></span>
                            </div>
                        </a>
                        <!--Topics Item End-->
                    <?php
                    } ?>
            </div>
        </div>
    </div>
<?php
}
?>

</div>