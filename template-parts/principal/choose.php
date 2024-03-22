<?php

$user_id = get_current_user_id();
$meta_key = 'invited_staff_email_ids';
$invited_user_emails =  get_user_meta($user_id, $meta_key, true);
?>
<section id="principal-content">
    <div class="ggsa-principal-choose my-5">
        <div class="container">
            <div class="row">
                <h4 class="text-brand-navy font-calibri fw-bold text-brand-primary text-center">
                    You can now sign up all of your staff</h4>
                <div class="ggsa-choose-container mt-5">
                    <div class="row principal-actions">
                        <div class="col">
                            <div class="choose border-1 p-3 border">
                                <div class="content-box d-grid">
                                    <div class="content-title">
                                        <h5 class="text-center fw-bold choose-text-color">Sign up your staff</h5>
                                    </div>
                                    <div class="content-cover-img">
                                     <img class="d-block" src="<?php echo get_stylesheet_directory_uri(). '/assets/img/sign-up-staff.png'?>" alt="Sign up your staff">
                                    </div>
                                    <button data-bs-toggle="modal" data-bs-target="#staff" type="button" class=" mt-2 btn btn-outline-primary btn-block">Start Now</button>
                                </div>
                                <div class="content-modal">                                   
                                    <div class="modal fade" id="staff" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staff">
                                                        Send an email to sign up your staff</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <div class="invitaions-form">
                                                        <form id="invite_staff_form" action="" class="needs-validation">
                                                            <div class="row">
                                                                <label for="" class="form-label">Invite staff by entering their email addresses</label>
                                                                <div class="button-group d-flex">
                                                                    <input type="email" class="form-control" name="new_user_email" id="new_user_email" aria-describedby="emailHelpId" placeholder="mail@organisations.com" required multiple>
                                                                    <button type="submit" class="ms-2 btn btn-outline-primary send-invite send-invite-staff">Send Invite</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                   </div>
                                                   <div class="invited-staff mt-3">
                                                        <p class="form-label">Email list of staff you invited:</p>
                                                        <ul class="invited-emails list-group">
                                                            <?php 
                                                            if($invited_user_emails > 0) {
                                                                foreach($invited_user_emails as $useremail){
                                                                    echo '<li class="list-group-item">' . $useremail . '</li>';
                                                                }
                                                            } else {
                                                                echo '<li class="list-group-item invitee_exits"> Invitee emails will appears here.</li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                   </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link btn-primary text-white" data-bs-dismiss="modal">Complete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="choose border-1 p-3 border">
                                <div class="content-box d-grid">
                                    <div class="content-title">
                                        <h5 class="text-center fw-bold choose-text-color">Delegate this task to your deputy</h5>
                                    </div>
                                    <div class="content-cover-img">
                                        <img class="d-block" src="<?php echo get_stylesheet_directory_uri(). '/assets/img/deputy-principal.png'?>" alt="Sign up your staff">    
                                    </div>
                                    <button data-bs-toggle="modal" data-bs-target="#deputy-principal" type="button" class=" mt-2 btn btn-outline-primary btn-block">Send Email</button>
                                </div>
                                <div class="content-modal">                                   
                                    <div class="modal fade" id="deputy-principal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deputy-principal">
                                                        Enter your deputy's email address</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="deputy_principal_form" action="" class="needs-validation">
                                                    <div class="modal-body">
                                                        <div class="invitaions-form">
                                                            <label for="" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="deputy_email" id="deputy_email" aria-describedby="emailHelpId" placeholder="Enter your deputy's email address" required>     
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link text-primary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Send Email</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="choose border-1 p-3 border">
                                <div class="content-box d-grid">
                                    <div class="content-title">
                                        <h5 class="text-center fw-bold choose-text-color">Delegate this task to your school administrator</h5>
                                    </div>
                                    <div class="content-cover-img">
                                    <img class="d-block" src="<?php echo get_stylesheet_directory_uri(). '/assets/img/school-administration.png'?>" alt="Sign up your staff">
                                    </div>        
                                    <button data-bs-toggle="modal" data-bs-target="#administrations" type="button" class=" mt-2 btn btn-outline-primary btn-block">Send Email</button>
                                </div>
                                <div class="content-modal">                                   
                                    <div class="modal fade" id="administrations" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="administrations">
                                                        Enter your school administrator's email address</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="school_administrator_form" action="" class="needs-validation">
                                                        <div class="modal-body">
                                                            <div class="invitaions-form">
                                                                        <label for="" class="form-label">Email</label>
                                                                        <input type="email" class="form-control" name="administrator_email" id="administrator_email" aria-describedby="emailHelpId" placeholder="Enter your school administrator’s email address" required>     
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-link text-primary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Send Email</button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <!-- Flexbox container for aligning the toasts -->
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center"> 
        <!-- Then put toasts within -->
        <div style="position: absolute; top: 20%; right: 20px; z-index: 99999">
            <div id="success" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true">
                <div class="toast-header">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/alert-check-outline.png' ?>" class="rounded me-2" alt="check-icon">
                    <h6 class="mr-auto" style="flex: 1 0 0">Email has been sent successfully</h6>
                    <button type="button" class="ms-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center"> 
        <!-- Then put toasts within -->
        <div style="position: absolute; top: 20%; right: 20px; z-index: 99999">
            <div id="failed" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true">
                <div class="toast-header">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/error.png' ?>" class="rounded me-2" alt="check-icon">
                    <h6 class="mr-auto" style="flex: 1 0 0">Email Address Not Verified</h6>
                    <button type="button" class="ms-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    silent is gold!
                </div>
            </div>
        </div>
    </div>
 </section>