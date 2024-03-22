<?php

$rating_and_reviews = get_post_meta(get_the_ID(), 'rating_and_reviews', true);

if (isset($_SESSION['sort']) && !empty($_SESSION['sort'])) {
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST['review-filter']) && !empty($_POST['review-filter'])){
            $_SESSION['sort'] = $_POST['review-filter'];
        }
    }
} else {
    $_SESSION['sort'] = 'newest';
}

if(!empty($rating_and_reviews) && $_SESSION['sort'] == 'newest'){ 
    // sorting the array to get the last comment at the top
    usort($rating_and_reviews, function($a, $b) {
        return $b["time"] <=> $a["time"];
    });
}

$five_star = [];
$four_star = [];
$three_star = [];
$two_star = [];
$one_star = [];
$rating_number = [];
$max_rating = 0;
$average_rating = 0;

if(!empty($rating_and_reviews)){
   
    foreach($rating_and_reviews as $rr){
        $user_rating = $rr['user_rating'];
        $rating_number[] = $user_rating;
        if($user_rating == 1){
            $one_star[] = $user_rating;
        } elseif ($user_rating == 2){
            $two_star[] = $user_rating;
        } elseif ($user_rating == 3){
            $three_star[] = $user_rating;
        } elseif ($user_rating == 4){
            $four_star[] = $user_rating;
        } elseif ($user_rating == 5){
            $five_star[] = $user_rating;
        }
    }

    $max_rating = max(count($five_star),count($four_star), count($three_star), count($two_star), count($one_star));
    $average_rating = array_sum($rating_number) / count($rating_and_reviews);
    $average_rating = round($average_rating);
}

?>

<!--rating and feedback-->
<div class="row  my-3">
    <div class="col-md-12 d-flex align-self-end justify-content-end">
        <div class="filter d-flex align-items-center gap-2 overflow-hidden me-3">
            <label for="review-filter">Sort</label>
            <form id="filter_form" method="post">
                <select name="review-filter" id="review-filter" class="form-select mr-2" <?php echo (empty($rating_and_reviews) ? 'disabled': '');?>>
                    <option value="newest"<?php echo ($_SESSION['sort'] == 'newest') ? 'selected': '';?>>Newest</option>
                    <option value="oldest" <?php echo ($_SESSION['sort'] == 'oldest') ? 'selected': '';?>>Oldest</option>
                </select>
            </form>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#feedback">Leave a Rating</button>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <div class="d-flex h-100 rounded-2 border border-1 p-3 align-items-center">
            <div class="text-left">
                <h2 class="fw-bold fs-1 total-review text-[#00859C] p-0 m-0"><?php echo (!empty($rating_and_reviews) ? count($rating_and_reviews) : 0) ;?></h2>
                <p class="fs-6">Total Reviews</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class=" d-flex h-100 rounded-2 border border-1 p-3 align-items-center">
            <div class="text-left">
                <div class="avg-star d-flex">
                    <h2 class="fw-bold fs-1 total-review text-[#5BC04E] p-0 m-0"><?php echo $average_rating;?></h2>
                    <div class="d-flex ms-2">
                        <?php
                            for ($x = 1; $x < 6; $x++) {
                                if($x < $average_rating + 1){
                                    echo '<img src="' .get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg' .'" alt="">';
                                } else {
                                    echo '<img src="' .get_stylesheet_directory_uri() . '/assets/svg/star.svg' .'" alt="">';
                                }
                                }
                        ?>
                    </div>
                </div>
                <p class="fs-6">Average rating</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-left h-100 rounded-2 border border-1 p-3">
            <ul class="p-0">
                <li class="justify-content-start align-items-center d-flex gap-2">
                    <div class="rating d-flex align-items-center justify-content-start">
                        <img class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>" alt="" srcset="">5
                    </div>
                    <div class="progress flex-1 align-items-center ">
                        <div class="progress-bar five-star bg-[#FAA332] mr-2 rounded-3" role="progressbar" style="width: 100%" aria-valuenow="<?php echo count($five_star);?>" aria-valuemin="0" aria-valuemax="<?php echo $max_rating;?>"></div>
                        <div class="value"><?php echo count($five_star);?></div>
                    </div>  
                </li>
                <li class="justify-content-start align-items-center d-flex gap-2">
                    <div class="rating d-flex align-items-center justify-content-start">
                        <img class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>" alt="" srcset="">4
                    </div>
                    <div class="progress flex-1 align-items-center">
                        <div class="progress-bar four-star bg-[#00859C] mr-2 rounded-3" role="progressbar" style="width: 20%" aria-valuenow="<?php echo count($four_star);?>" aria-valuemin="0" aria-valuemax="<?php echo $max_rating;?>"></div>
                        <div class="value"><?php echo count($four_star);?></div>
                    </div>  
                </li>
                <li class="justify-content-start align-items-center d-flex gap-2">
                    <div class="rating d-flex align-items-center justify-content-start">
                        <img class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>" alt="" srcset="">3
                    </div>
                    <div class="progress flex-1 align-items-center">
                        <div class="progress-bar three-star bg-[#FBBC16] mr-2 rounded-3" role="progressbar" style="width: 10%" aria-valuenow="<?php echo count($three_star);?>" aria-valuemin="0" aria-valuemax="<?php echo $max_rating;?>"></div>
                        <div class="value"><?php echo count($three_star);?></div>
                    </div>  
                </li>
                <li class="justify-content-start align-items-center d-flex gap-2">
                    <div class="rating d-flex align-items-center justify-content-start">
                        <img class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>" alt="" srcset="">2
                    </div>
                    <div class="progress flex-1 align-items-center">
                        <div class="progress-bar two-star BG-[#5BC04E] mr-2 rounded-3" role="progressbar" style="width: 5%" aria-valuenow="<?php echo count($two_star);?>" aria-valuemin="0" aria-valuemax="<?php echo $max_rating;?>"></div>
                        <div class="value"><?php echo count($two_star);?></div>
                    </div>  
                </li>
                <li class="justify-content-start align-items-center d-flex gap-2">
                    <div class="rating d-flex align-items-center justify-content-start">
                        <img class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>" alt="" srcset="">1
                    </div>
                    <div class="progress flex-1 align-items-center">
                        <div class="progress-bar one-star bg-[#E52E2E] mr-2 rounded-3" role="progressbar" style="width: 5%" aria-valuenow="<?php echo count($one_star);?>" aria-valuemin="0" aria-valuemax="<?php echo $max_rating;?>"></div>
                        <div class="value"><?php echo count($one_star);?></div>
                    </div>  
                </li>
            </ul>
        </div>
    </div>
</div>
<?php

if(!empty($rating_and_reviews)){
    foreach($rating_and_reviews as $rr){ 
        $rating_id = $rr['rating_id'];
        $user_id = $rr['user_id'];
        $user_rating = $rr['user_rating'];
        $user_feedback = $rr['user_feedback'];
        $user_data = get_userdata($user_id);
        $user_dp =  $user_data -> display_name;
        $roles = $user_data -> roles;
        $user_role = $roles[0];
        $review_time = $rr['time'];
    
        // Get the current date and time
        $currentDateTime = new DateTime();
    
        $interval = $currentDateTime->diff($review_time);
        $sec = $interval->s + $interval->i * 60 + $interval->h * 3600 + $interval->days * 86400;
    
        if ($sec < 3600) {
            $time = floor(($sec) / 60);
            $review_time = $time . ' m ago';
            // under 60 min show min
        } elseif (($sec) < (86400)) {
            // under 24h show hour
            $time = floor(($sec) / (60 * 60));
            $review_time = $time . ' h ago';
        } else {
            $time = floor(($sec) / (60 * 60 * 24));
            $review_time = $time . ' day ago';
        }
        
    ?>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="border-1 rounded-4 p-3 border">
                <div class="d-flex justify-content-between">
                    <div class="user">
                        <div class="d-flex">
                            <div class="profile-picture me-3">
                            <?php
                                $user_avatar = get_user_meta($user_id, 'user_avatar_url', true);
                                if(!empty($user_avatar)){
                                    echo '<img alt="" src="' . $user_avatar . '" class="avatar" decoding="async">';
                                } else {
                                    echo '<img alt="" src="' . esc_url( get_avatar_url( $user_id ) ) . '" class="avatar" decoding="async">';
                                }
                                ?>
                            </div>
                            <div class="info ">
                                <h4 class="fw-bold mb-0 p-0 fs-5"><?php echo $user_dp . ', '. ucfirst($user_role);?></h4>
                                <div class="user-rated d-flex">
                                    <div class="user-rating d-flex">
                                        <?php
                                            for ($x = 1; $x < 6; $x++) {
                                                if($x < $user_rating + 1){
                                                    echo '<img src="' .get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg' .'" alt="">';
                                                } else {
                                                    echo '<img src="' .get_stylesheet_directory_uri() . '/assets/svg/star.svg' .'" alt="">';
                                                }
                                              }
                                        ?>
                                    </div>
                                    <span class="time position-relative ms-3"><?php echo $review_time;?></span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="nav-vertical position-relative">
                        <div class="infos">
                            <img class="dot-nav" id="<?php echo $rating_id;?>" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/dot-nav.svg';?>" alt="dot-nav">
                            <div class="position-absolute more-menu right-10 top-0">
                                <div class="d-flex justify-content-center align-items-center shadow rounded-2 ">
                                    <!-- Then put toasts within -->
                                    <div id="<?php echo 'toast-' .  $rating_id;?>" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="toast-header align-items-center">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/spam.svg';?>" class="rounded me-2" alt="report-spam" />
                                            <strong class="me-auto">Report Spam</strong>
                                            <button class="btn-close text-[10px]" data-bs-dismiss="toast" aria-label="Close">&times;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="review-desc my-3">
                    <p class="fs-5"><?php echo $user_feedback;?></p>
                </div>
                <div class="review-feedback">
                    <div class="d-flex align-items-center ">
                        <h6 class="me-2 p-0 m-0">Did you find it helpful?</h6>
                        <div class="thumbs d-flex gap-2">
                            <img class="thumbs-up" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/thumbs-up.svg';?>" alt="">
                            <img class="thumbs-down" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/thumbs-down.svg';?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
}
?>

<!--Modal -->
<div class="modal fade" id="feedback" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold fs-4 text-black pb-0" id="modalTitleId">Ratings and Reviews</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rating-submit" action="" class="needs-validation">
                <div class="modal-body pt-1">
                    <div class="provide-rating mb-2">
                        <div class="d-flex mx-auto my-0" style="width: fit-content;">
                            <div class="d-flex justify-content-between w-100">
                                <div class="form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="user-rating" id="user-rating-1" value="1"/>
                                    <label class="form-check-label" for="user-rating-1"><img class="mr-1 rating-star rating-1" data-rating="1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>"></label>
                                </div>
                                <div class="form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="user-rating" id="user-rating-2" value="2" />
                                    <label class="form-check-label" for="user-rating-2"><img class="mr-1 rating-star rating-2" data-rating="2" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>"></label>
                                </div>
                                <div class="form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="user-rating" id="user-rating-3" value="3"
                                    />
                                    <label class="form-check-label" for="user-rating-3"><img class="mr-1 rating-star rating-3" data-rating="3" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>"></label>
                                </div>
                                <div class="form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="user-rating" id="user-rating-4" value="4"/>
                                    <label class="form-check-label" for="user-rating-4"><img class="mr-1 rating-star rating-4" data-rating="4" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>"></label>
                                </div>
                                <div class="form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="user-rating" id="user-rating-5" value="5" checked/>
                                    <label class="form-check-label" for="user-rating-5"><img class="mr-1 rating-star rating-5" data-rating="5" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/star-filled.svg';?>"></label>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="mb-2">
                        <label for="review" class="form-label">Your reviews</label>
                        <textarea maxlength="500" class="form-control needs-validation" name="review" id="review" rows="4" placeholder="Please provide your reviews." required></textarea>
                        <div id="char-limit">0/500</div>
                        <div class="invalid-feedback">
                            Please provide your reviews in 500 character.
                        </div>
                        <input type="hidden" id="rating-number" name="rating-number" value="">
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