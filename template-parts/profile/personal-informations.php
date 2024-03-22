<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$current_user = wp_get_current_user();
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar( $user_id );
$user_roles = $current_user->roles;
$role_name = $user_roles[0];
$first_name = get_user_meta($current_user->ID, 'first_name', true);
$last_name = get_user_meta($current_user->ID, 'last_name', true);
$user_school = get_user_meta( $user_id, 'school-name', true );
$number_of_student = get_user_meta( $user_id, 'number-of-student',true);
$indigenous_student_meta = get_user_meta( $user_id, 'indigenous-student',true);
$jurisdiction_meta = get_user_meta( $user_id, 'jurisdiction',true);
$town_meta = get_user_meta( $user_id, 'town',true);
$zone_meta = get_user_meta( $user_id, 'zone',true);
$state_meta = get_user_meta( $user_id, 'state',true);
$school_list = $args['school_list'];
$Towns = $args['towns'];
$Jurisdiction = $args['jurisdiction'];
$zone = $args['zone'];
$state_territory = $args['state_territory'];
$indegenous_students = $args['indegenous_students'];
$year_level = $args['year_level'];


?>
<div class="myprofile bg-white rounded-3 p-3">
    <div class="personal-information border-bottom pb-3">
        <div class="info_header d-flex justify-content-between align-items-center">
            <div class="">
                <h4>Personal information</h4> 
                <p>Update your personal details here.</p>
            </div>
            <div class="save-p-info">
                <button type="button" class="btn btn-primary update-profile">Save Changes</button>
            </div>
        </div>
    </div>
    <div class="loading-screen">
            <div class="lds-ring">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    <div class="update-personal-info mt-3 border-bottom pb-3">
        <div class="row d-flex justify-content-between mt-2">
            <div class="col"> 
                <h4 class="fw-bold text-start form-title mb-3">Your Information</h4>
                <div class="mb-3 row">
                    <label for="f_name" class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control rounded" id="f_name" value="<?php echo $first_name?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="l_name" class="col-sm-3 col-form-label">Last Name</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="l_name" value="<?php echo $last_name?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" placeholder="Disabled input" aria-label="Disabled input example" value="<?php echo $current_user -> user_email; ?>" disabled>
                    <!-- <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com"> -->
                    </div>
                </div>
                <?php
                if(! in_array('principal', $user_roles)){ ?>
                    <div class="mb-3 row">
                        <label for="yearLevel" class="col-sm-3 col-form-label">Year Level</label>
                        <div class="col-sm-9">
                            <select id="yearLevel" class="form-select" aria-label="Default select example">                                                                
                                <?php
                                $year = get_user_meta( $user_id, 'year', true );
                                echo '<option value="" disabled selected>Select an option</option>';
                                foreach ($year_level as $level ){    
                                    echo '<option value="'. $level . '"' . ($year == $level ? "selected" : "" ). '>'  .$level . '</option>';                          
                                }
                                ?> 
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="subject" class="col-sm-3 col-form-label">Subject</label>
                        <div class="col-sm-9">
                            <select id="subject" class="form-select" aria-label="Default select example">                                                                
                                <?php
                                $subject_list = [
                                    'Childhood',
                                    'English',
                                    'Maths',
                                    'Science',
                                    'Arts',
                                    'Materials and Technologies Humanities and Social Sciences',
                                    'Languages'
                                ];
                                $subject = get_user_meta( $user_id, 'subject', true );
                                echo '<option value="" disabled selected>Select an option</option>';
                                foreach ($subject_list as $s ){    
                                    echo '<option value="'. $s . '"' . ($subject == $s ? "selected" : "" ). '>'  .$s . '</option>';                          
                                }
                                ?> 
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="stage" data-bs-toggle="tooltip" data-bs-placement="top" title="Development Stage" class="col-sm-3 col-form-label">Development Stage</label>
                        <div class="col-sm-9">
                            <select id="stage" class="form-select" aria-label="Default select example">                                                                
                                <?php
                                $dev_stage = [
                                    'Foundation', 
                                    'Proficient',
                                    'Accomplished',
                                    'Lead',
                                ];
                                $stage = get_user_meta( $user_id, 'development-stage', true );
                                echo '<option value="" disabled selected>Select an option</option>';
                                foreach ($dev_stage as $d ){    
                                    echo '<option value="'. $d . '"' . ($stage == $d ? "selected" : "" ). '>'  .$d . '</option>';                          
                                }
                                ?> 
                            </select>
                        </div>
                    </div>
                <?php }
                ?>
                <div class="mb-3 row">
                    <label for="role" class="col-sm-3 col-form-label">Role</label>
                    <div class="col-sm-9">
                        <div class="user-roles">
                            <?php
        
                            foreach ($user_roles as $role){
                                $role_name = str_replace('_', ' ', $role);
                                echo '<span ' . ($role_name == 'principal' ? 'class="principal"' : '') .'>'. ucwords($role_name) . '</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col"> 
                <h4 class="fw-bold text-start form-title mb-3">School Information</h4>
                <?php
                if($user_school){ ?>
                    <div class="mb-3 row">
                        <?php
                            if(in_array('principal', $user_roles)){ ?>
                                <label for="school_name" class="col-sm-4 col-form-label">School Name</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control rounded" id="schoolName" value="<?php echo $user_school;?>" disabled>
                                </div>
                            <?php } else { ?>
                                <label for="school_name" class="col-sm-4 col-form-label">School Name</label>
                                <div class="col-sm-4">
                                    <input type="text" data-toggle="tooltip" data-placement="top" title="<?php echo $user_school;?>" class="form-control rounded" id="schoolName" value="<?php echo $user_school;?>" disabled>
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" data-toggle="tooltip" data-placement="top" title="Leave School Membership" class="btn leave btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#leave_school">Leave School Membership</button>
                                </div> 
                            <?php }
                        ?>
                    </div>
                <?php } else { ?>
                    <div class="mb-3 row">
                    <label for="schoolName" data-bs-toggle="tooltip" data-bs-placement="top" title="School Name" class="col-sm-4 col-form-label">School Name</label>
                    <div class="col-sm-8">
                        <select id="schoolName" class="form-select" aria-label="Default select example">
                            <?php
                                echo '<option value="" disabled selected>Select an School</option>';
                                foreach ($school_list as $sl){
                                    echo '<option value="'. $sl . '" ' . ($user_school == $sl ? "selected" : "" ). '>'  .$sl . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <?php }
                ?>
                <div class="mb-3 row">
                    <label for="num_of_s" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of School Students" class="col-sm-4 col-form-label">Number of School Students</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="num_of_s" placeholder="Number of Students" value="<?php echo $number_of_student?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="indegenousPercent" data-bs-toggle="tooltip" data-bs-placement="top" title="% indigenous Students" class="col-sm-4 col-form-label">% indigenous Students</label>
                    <div class="col-sm-8">
                        <select id="indegenousPercent" class="form-select" aria-label="Default select example">
                            <?php
                                echo '<option value="" disabled selected>Select an option</option>';
                                foreach ($indegenous_students as $is){
                                    echo '<option value="'. $is . '" ' . ($indigenous_student_meta == $is ? "selected" : "" ). '>'  .$is . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jurisdiction" class="col-sm-4 col-form-label">Jurisdiction</label>
                    <div class="col-sm-8">
                        <select id="jurisdiction" class="form-select" aria-label="Default select example">
                        <?php
                            sort($Jurisdiction);
                            echo '<option value="" disabled selected>Select an option</option>';
                            foreach ($Jurisdiction as $j){
                                echo '<option value="'. $j . '" ' . ($jurisdiction_meta == $j ? "selected" : "" ). '>'  .$j . '</option>';
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="town" class="col-sm-4 col-form-label">Town</label>
                    <div class="col-sm-8">
                        <select id="town" class="form-select" aria-label="Default select example">
                            <?php
                                sort($Towns);
                                echo '<option value="" disabled selected>Select an option</option>';
                                foreach ($Towns as $t){
                                    echo '<option value="'. $t . '" ' . ($town_meta == $t ? "selected" : "" ). '>'  .$t . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="Zone" class="col-sm-4 col-form-label">Zone</label>
                    <div class="col-sm-8">
                        <select id="zone" class="form-select" aria-label="Default select example">
                            <?php
                                echo '<option value="" disabled selected>Select an option</option>';
                                foreach($zone as $z){
                                    echo '<option value="'. $z . '" ' . ($zone_meta == $z ? "selected" : "" ). '>'  .$z . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stateTerritory" class="col-sm-4 col-form-label">State/Territory</label>
                    <div class="col-sm-8">
                        <select id="stateTerritory" class="form-select" aria-label="Default select example">
                            <?php
                                sort($state_territory);
                                echo '<option value="" disabled selected>Select an option</option>';
                                foreach ($state_territory as $s){
                                    echo '<option value="'. $s . '" ' . ($state_meta == $s ? "selected" : "" ). '>'  .$s . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="update-password mt-3">
        <div class="password-information border-bottom pb-3">
            <div class="info_header d-flex justify-content-between align-items-center">
                <div class="">
                    <h4 class="fw-bold text-start form-title">Password</h4>
                    <p>Update your personal details here.</p>
                </div>
                <div class="save-p-info">
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-between mt-3 border-bottom pb-3">
        <div class="col"> 
            <div class="mb-3 row">
                <label for="c_pass" class="col-sm-2 col-form-label">Current Password</label>
                <div class="col-sm-10">
                <input type="text" class="form-control rounded" id="c_pass" placeholder="Enter your current password.">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="n_pass" class="col-sm-2 col-form-label">New Password</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="n_pass" placeholder="Enter your new password.">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="con_pass" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="con_pass" placeholder="Enter your new password again.">
                </div>
            </div>
        </div>
    </div> -->
    <div class="logout mb-5 mt-4">
        <div class="btn-logout text-end">
            <a class="btn btn-site btn-bd-red" href="<?php echo wp_logout_url(); ?>">
                Sign out
            </a>
        </div>
    </div>
</div>

<!-- Leave School Modal -->

<div class="modal fade" id="leave_school" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
        role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-1">
                <h5 class="modal-title fw-bold" id="modalTitleId">
                    Leave This School Membership
                </h5>
                <button
                    type="button"
                    class="btn-close modal-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body py-0">
                <p>You are about to leave the <span class="school fw-bold"><?php echo $user_school;?></span>. You will no longer be a part of this school membership. You will retain your individual resources but through your own individual membership.</p>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    class="btn cancel btn-outline-secondary border-0"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>
                <button type="button" id="leaveButton" class="btn btn-primary px-4">Leave</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="position-fixed top-20 end-0 p-3" style="z-index: 99999">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" autohide="true">
        <div class="toast-header d-flex align-items-start rounded-2">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/alert-check-outline.png' ?>" class="rounded me-2" alt="check-icon">
            <h6 class="mr-auto pb-0" style="flex: 1 0 0">
            You have successfully left <span class="school fw-bold"><?php echo $user_school;?></span>.
            </h6>
            <button type="button" class="toast-close ms-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>