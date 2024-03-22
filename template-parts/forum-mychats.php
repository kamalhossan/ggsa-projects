<?php

// Set default value for chats-sort
if (!isset($_SESSION['chats-sort'])) {
    $chats_sort = isset($_POST['chats-sort']) ? $_POST['chats-sort'] : 'recent';
    $_SESSION['chats-sort'] = $chats_sort;
} else {
    // If the session variable is already set, use its value
    $chats_sort = $_SESSION['chats-sort'];
}

// If the request method is POST and 'chats-sort' is set, update the session variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chats-sort'])) {
    // Update the session variable with the value from the POST request
    $_SESSION['chats-sort'] = $_POST['chats-sort'];
    $chats_sort = $_SESSION['chats-sort'];

    if(isset(($_POST['chats-search']))){
        $keyword = sanitize_text_field($_POST['chats-search']);
    }
}


?>
<div class="peer-forum bg-[#fff] rounded-4 p-3 my-3">
    <div class="row">
        <div class="col-md-9">
            <div class="header d-flex justify-content-between">
                <div class="title flex-1">
                    <h4 class="fw-bold fs-3 text-[#161C24] p-0 m-0">My Chats</h4>
                </div>
                <form id="chats-search" action="" method="post">
                    <div class="action d-flex">
                        <div class="form-group row align-items-center">
                            <label for="chats-search" class="col-sm-3 col-form-label">Search</label>
                            <div class="col-sm-9 ps-0">
                            <input type="text" name="chats-search" class="form-control px-2" id="chats-search" placeholder="Questions, discussions" value="<?php echo (isset($_POST['chats-search'])) ? $keyword : '';?>">
                            </div>
                        </div>
                        <div class="form-group d-flex ms-2">
                            <label for="chats-sort" class="col-sm-2 col-form-label">Sort</label>
                            <select name="chats-sort" id="chats-sort" class="form-select  mr-sm-5 ms-3 form-control">
                                <option value="recent" <?php echo ($chats_sort == 'recent') ? 'selected' : '';?> >Recent</option>
                                <option value="top" <?php echo ($chats_sort == 'top') ? 'selected' : '';?>>Top</option>
                            </select>
                            <input type="hidden" name="tabs-name" id="tabs-name" value="mychats">
                        </div>
                    </div>
                </form>
            </div>
            <!--Tab Navigation-->
            <div class="d-flex mt-3 flex-row align-items-center" id="my-chats" role="tablist">
                <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 active" id="chats-peer-forum-tab" data-bs-toggle="tab" href="#chats-peer-forum" aria-controls="chats-peer-forum" aria-selected="false" role="tab" tabindex="-1">
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
                <div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100" id="chats-expert-forum-tab" data-bs-toggle="tab" href="#chats-expert-forum" aria-controls="chats-expert-forum" aria-selected="false" role="tab" tabindex="-1">
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
            </div>
            <!-- Tab Navigation Content tab -->
            <div class="tab-content" id="my-chats-content">
                <div class="tab-pane fade active show" id="chats-peer-forum" role="tabpanel" aria-labelledby="peer-forum-tab">
                    <div class="forums">
                        <?php
                        // Define the query arguments
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                        $saved_course_ids = get_user_meta(get_current_user_id(), 'saved_topic_and_question', true);

                        $topic_args = array(
                            'post_type'      => 'peer-forum',
                            'posts_per_page' => 5,
                            'paged'          => $paged,
                            'post__in'       => $saved_course_ids,
                        );

                        if($chats_sort == 'top'){
                            $topic_args['orderby'] = 'comment_count';
                            $topic_args['order'] = 'DESC';
                        }

                        if(isset(($_POST['chats-search']))){
                            $topic_args['s'] = sanitize_text_field($_POST['chats-search']);
                        }
                        // Create a new WP_Query instance for the merged posts
                        $topic_query = new WP_Query($topic_args);

                        

                        if($topic_query -> have_posts()){
                            while($topic_query -> have_posts()){
                                $topic_query -> the_post(); 
                                peer_forum_topics_template_item(get_the_ID());
                            }
                            wp_reset_postdata();

                            ?>
                            <div class="pagination d-flex gap-2 items-center justify-content-center mt-3">
                                <?php
                                $big = 999999999; // need an unlikely integer
                                $total = $topic_query->max_num_pages;
                                $prev_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-left.svg';
                                $next_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-right.svg';
        
                                echo paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?paged=%#%',
                                    'current' => max( 1, get_query_var('paged') ),
                                    'total' => $total,
                                    'prev_text' => '<img src="'. $prev_img .'">',
                                    'next_text' => '<img src="'. $next_img .'">',
                                    
                                ) );
                                ?>
                            </div>
                        <?php
                        } else { ?>                          
                            <!--no chats founds-->
                            <div class="chats-emtpy my-3 items-center text-center d-flex flex-column">
                                <img width="64px" height="64px" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/no-comment.svg';?>" alt="no chats">
                                <p class="text-[#4d4f4e]">
                                <?php if (isset(($_POST['chats-search']))){
                                echo 'There are no conversations created with this keywords "' . $keyword . '"';  
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

                </div>
                <!-- PEER FORUM END-->

                <div class="tab-pane fade" id="chats-expert-forum" role="tabpanel" aria-labelledby="expert-forum-tab">
                    <div class="questions">
                    <?php

                        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

                        $saved_course_ids = get_user_meta(get_current_user_id(), 'saved_topic_and_question', true);

                        $ques_args = array(
                            'post_type'      => 'expert-forum',
                            'posts_per_page' => 5,
                            'paged'          => $paged,
                            'post__in'       => $saved_course_ids,
                        );

                        if($chats_sort == 'top'){
                            $ques_args['orderby'] = 'comment_count';
                            $ques_args['order'] = 'DESC';
                        }
                        
                        if(isset(($_POST['chats-search']))){
                            $ques_args['s'] = sanitize_text_field($_POST['chats-search']);
                        }
                        
                        $question_query = new WP_Query($ques_args);

                        if ($question_query->have_posts()) {

                            while ( $question_query->have_posts() ) {
                                $question_query->the_post(); 
                                expert_forum_questions_template_item(get_the_ID());
                            }
                            wp_reset_postdata();
                            ?>
                            <div class="pagination d-flex gap-2 items-center justify-content-center mt-3">
                                <?php
                                $big = 999999999; // need an unlikely integer
                                $total = $question_query->max_num_pages;
                                $prev_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-left.svg';
                                $next_img = get_stylesheet_directory_uri() . '/assets/svg/chevron-right.svg';

                                echo paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?paged=%#%',
                                    'current' => max( 1, get_query_var('paged') ),
                                    'total' => $total,
                                    'prev_text' => '<img src="'. $prev_img .'">',
                                    'next_text' => '<img src="'. $next_img .'">',
                                ) );
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <!--no chats founds-->
                            <div class="chats-emtpy my-3 items-center text-center d-flex flex-column">
                                <img width="64px" height="64px" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/no-comment.svg';?>" alt="no chats">
                                <p class="text-[#4d4f4e]">
                                <?php if (isset(($_POST['chats-search']))){
                                echo 'There are no conversations created with this keywords "' . $keyword . '"';  
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
                </div>
                <!-- EXPERT FORUM END-->
            </div>
        </div>
        <div class="col-md-3">
            <?php get_template_part('template-parts/forum', 'chats-sidebar'); ?>
        </div>
    </div>
</div>