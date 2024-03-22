<?php

?>
<!--with comment response layout-->
<div class="single-topic mb-5">
    <div class="forum-topic-single bg-[#fff] rounded-4 p-3">
        <div class="row">
            <div class="col-md-12">
                <div class="forum-topic-single-top p-2 border-0 d-flex gap-2 mb-2 items-center">
                    <button class="go-back btn bg-[#b4b9b9] rounded-2"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/icon-goback.svg';?>" alt="goback" srcset=""></button>
                    <span class="status rounded-2 bg-[#FFE8DB] px-2 text-[#E52E2E]">New</span>
                    <span class="category rounded-2 px-2 bg-[#E1EEFF] text-[#1B61F9]">Curriculum</span>
                    <span class="course rounded-2 px-2 bg-[#EDFDDC] text-[#1A8319]"><?= the_title(); ?></span>
                </div>
                <div class="forum-topic-single-body my-3">
                    <div class="creator d-flex gap-2 items-center mb-3">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="avatar" srcset="">
                        <p class="creator-name fw-bold m-0 text-[#4d4f4e]">Lisa Ramapati</p>
                    </div>
                    <h2 class="fw-bold fs-4 text-[#4D4F4E] mb-2"><?= the_title();?></h2>
                    <div class="desc text-[#4D4F4E]">
                        <?= the_content();?>
                    </div>
                    <div class="forum-topic-single-bottom pb-3 mt-3 d-flex justify-content-between items-center border-bottom">
                        <div class="question-action d-flex gap-2">
                            <button id="question-like" class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center "><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                            <button class="curr-qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">5</span>
                            </button>
                            <button id="forum-save" class="save-ques d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/saved.svg';?>" alt="save discussion" srcset="">Save Question
                            </button> 
                            <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                        </div>
                    </div>
                    <div class="forum-topic-single-comment">
                        <div class="comments mb-3">
                            <div class="add-comments my-3 d-flex gap-3">
                                <div class="user-img">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                </div>
                                <div class="comment-text flex-1">
                                    <input type="text" class="form-control w-100" placeholder="Add your answers">
                                </div>
                            </div>
                            <div class="add-comment text-end">
                                <button id="submit-comment" class="submit-answer btn btn-primary">Comment</button>
                            </div>
                        </div>

                        <?php

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;

                        ?>
                        <!--ZERO COMMENT RESPONSE-->
                        <div class="comment-responses mb-3">
                            <p class="fw-bold mb-3 text-[#4d4f4e]">0 Comments</p>
                            <div class="zero-comment p-3 items-center text-center d-flex flex-column">
                                <img class="" width="64px" height="64px" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/no-comment.svg';?>" alt="">
                                <p class="text-[#4d4f4e]">There are no comments here.</p>
                            </div>
                        </div>
                        <!--ZERO COMMENT RESPONSE-->

                        <!--COMMENT RESPONSE-->
                        <div class="comment-responses mb-3">
                            <p class="fw-bold mb-3 text-[#4d4f4e]">32 Comments</p>
                            <div class="top-resnpons mb-3">
                                <div class="res-info top-res d-flex gap-3">
                                    <div class="user-img">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                    </div>
                                    <div class="view-resnponse-info flex-1">
                                        <div class="responde-by d-flex justify-content-between">
                                            <div class="info gap-2 d-flex items-center">
                                                <span class="fw-bold text-[#161c24]">Jane</span>
                                            </div>
                                            <div class="time">
                                                <span class="text-[#4d4f4e]">15 m ago</span>
                                            </div>
                                        </div>
                                        <p class="response-text">Where do we get our certification? I did my first..do we wait until we are done with the rest of the course? Thank you.</p>
                                        <div class="top-res-action d-flex gap-2 my-2">
                                            <button class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                                            <button class="top-res-com d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">1</span>
                                            </button>
                                            <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                                        </div>
                                        <div class="top-res-reply">
                                            <!--INNER COMMENT LOOP-->
                                            <div class="second-res d-flex gap-3">
                                                <div class="user-img">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                                </div>
                                                <div class="view-top-info flex-1">
                                                    <div class="responde-by d-flex justify-content-between">
                                                        <div class="info gap-2 d-flex items-center">
                                                            <span class="fw-bold text-[#161c24]">Jane</span>
                                                        </div>
                                                        <div class="time">
                                                            <span class="text-[#4d4f4e]">15 m ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="response-text">Where do we get our certification? I did my first..do we wait until we are done with the rest of the course? Thank you.</p>
                                                    <div class="res-action d-flex gap-2 mt-2">
                                                        <button class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                                                        <button class="curr-qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">2</span>
                                                        </button>
                                                        <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--ADD COMMENT FOR SUB COMMENT-->
                                            <div class="top-res-ans mb-3">
                                                <div class="add-answer my-3 d-flex gap-3">
                                                    <div class="user-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                                    </div>
                                                    <div class="answer-text flex-1">
                                                        <input type="text" class="form-control w-100" placeholder="Add your comment">
                                                    </div>
                                                </div>
                                                <div class="add-answer text-end">
                                                    <button id="submit-answer" class="submit-answer btn btn-primary">Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!--Another comment here-->
                            <div class="top-resnpons mb-3">
                                <div class="res-info top-res d-flex gap-3">
                                    <div class="user-img">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                    </div>
                                    <div class="view-resnponse-info flex-1">
                                        <div class="responde-by d-flex justify-content-between">
                                            <div class="info gap-2 d-flex items-center">
                                                <span class="fw-bold text-[#161c24]">Jane</span>
                                            </div>
                                            <div class="time">
                                                <span class="text-[#4d4f4e]">15 m ago</span>
                                            </div>
                                        </div>
                                        <p class="response-text">Where do we get our certification? I did my first..do we wait until we are done with the rest of the course? Thank you.</p>
                                        <div class="top-res-action d-flex gap-2 my-2">
                                            <button class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                                            <button class="top-res-com d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">1</span>
                                            </button>
                                            <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                                        </div>
                                        <div class="top-res-reply d-none">
                                            <!--INNER COMMENT LOOP-->
                                            <div class="second-res d-flex gap-3">
                                                <div class="user-img">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                                </div>
                                                <div class="view-top-info flex-1">
                                                    <div class="responde-by d-flex justify-content-between">
                                                        <div class="info gap-2 d-flex items-center">
                                                            <span class="fw-bold text-[#161c24]">Jane</span>
                                                        </div>
                                                        <div class="time">
                                                            <span class="text-[#4d4f4e]">15 m ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="response-text">Where do we get our certification? I did my first..do we wait until we are done with the rest of the course? Thank you.</p>
                                                    <div class="res-action d-flex gap-2 mt-2">
                                                        <button class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                                                        <button class="curr-qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">2</span>
                                                        </button>
                                                        <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--ADD COMMENT FOR SUB COMMENT-->
                                            <div class="top-res-ans mb-3">
                                                <div class="add-answer my-3 d-flex gap-3">
                                                    <div class="user-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                                    </div>
                                                    <div class="answer-text flex-1">
                                                        <input type="text" class="form-control w-100" placeholder="Add your comment">
                                                    </div>
                                                </div>
                                                <div class="add-answer text-end">
                                                    <button id="submit-answer" class="submit-answer btn btn-primary">Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!--Another comment here-->
                            <div class="top-resnpons mb-3">
                                <div class="res-info top-res d-flex gap-3">
                                    <div class="user-img">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                    </div>
                                    <div class="view-resnponse-info flex-1">
                                        <div class="responde-by d-flex justify-content-between">
                                            <div class="info gap-2 d-flex items-center">
                                                <span class="fw-bold text-[#161c24]">Jane</span>
                                            </div>
                                            <div class="time">
                                                <span class="text-[#4d4f4e]">15 m ago</span>
                                            </div>
                                        </div>
                                        <p class="response-text">Where do we get our certification? I did my first..do we wait until we are done with the rest of the course? Thank you.</p>
                                        <div class="top-res-action d-flex gap-2 my-2">
                                            <button class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                                            <button class="top-res-com d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">2</span>
                                            </button>
                                            <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                                        </div>
                                        <div class="top-res-reply d-none">
                                            <!--INNER COMMENT LOOP-->
                                            <div class="second-res d-flex gap-3">
                                                <div class="user-img">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                                </div>
                                                <div class="view-top-info flex-1">
                                                    <div class="responde-by d-flex justify-content-between">
                                                        <div class="info gap-2 d-flex items-center">
                                                            <span class="fw-bold text-[#161c24]">Jane</span>
                                                        </div>
                                                        <div class="time">
                                                            <span class="text-[#4d4f4e]">15 m ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="response-text">Where do we get our certification? I did my first..do we wait until we are done with the rest of the course? Thank you.</p>
                                                    <div class="res-action d-flex gap-2 mt-2">
                                                        <button class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                                                        <button class="curr-qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">2</span>
                                                        </button>
                                                        <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="second-res d-flex gap-3">
                                                <div class="user-img">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                                </div>
                                                <div class="view-top-info flex-1">
                                                    <div class="responde-by d-flex justify-content-between">
                                                        <div class="info gap-2 d-flex items-center">
                                                            <span class="fw-bold text-[#161c24]">Jane</span>
                                                        </div>
                                                        <div class="time">
                                                            <span class="text-[#4d4f4e]">15 m ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="response-text">Where do we get our certification? I did my first..do we wait until we are done with the rest of the course? Thank you.</p>
                                                    <div class="res-action d-flex gap-2 mt-2">
                                                        <button class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/like.svg';?>">Like <span class="number">12</span></button>    
                                                        <button class="curr-qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">2</span>
                                                        </button>
                                                        <button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--ANOTHER SECOND RESPONSE-->
                                            <!--ADD COMMENT FOR SUB COMMENT-->
                                            <div class="top-res-ans mb-3">
                                                <div class="add-answer my-3 d-flex gap-3">
                                                    <div class="user-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Avatar.png';?>" alt="user name">
                                                    </div>
                                                    <div class="answer-text flex-1">
                                                        <input type="text" class="form-control w-100" placeholder="Add your comment">
                                                    </div>
                                                </div>
                                                <div class="add-answer text-end">
                                                    <button id="submit-answer" class="submit-answer btn btn-primary">Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--ANOTEHR RESPONSE END HERE-->
                        </div>
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