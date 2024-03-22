<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


$tema_ids  = get_user_in_team(get_current_user_id());

// excluding remove staff from team
$removed_staff_ids = get_user_meta(get_current_user_id(), 'staff_removed_from_school', true);
if(!empty($removed_staff_ids)){
    $tema_ids = array_diff($tema_ids, $removed_staff_ids);
}

//getting the list of roles of the organizations so that they can use to filter
$team_user_ids_role = [];
foreach ($tema_ids as $user_id){
    $data = get_userdata($user_id);
    $team_user_ids_role[] = $data -> roles;
}

$flatArray = array_map(function ($item) {
    return (!empty($item) && isset($item[0])) ? $item[0] : null;
}, $team_user_ids_role);

// team uniques roles
$team_unique_roles = array_unique($flatArray);

// managing rows per page
if (isset($_SESSION['prows_per_page']) && !empty($_SESSION['prows_per_page'])) {
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST['user_per_page']) && !empty($_POST['user_per_page'])){
            $_SESSION['prows_per_page'] = $_POST['user_per_page'];
        }
    }
} else {
    $_SESSION['prows_per_page'] = 20;
}


// Define how many items to display per page
$user_per_page = $_SESSION['prows_per_page'];
// $user_per_page = $_POST["user_per_page"];

// Get the current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


// Calculate the offset to start displaying items from
$offset = ($paged - 1) * $user_per_page;

// getting user ids with query
$user_args = array(
    'include' => $tema_ids,
    'paged' => $paged,
    'number' => $user_per_page,
    'offset' => $offset,
);


if(isset($_POST['staffRoles'])){
    if($_POST['staffRoles'] !== 'all'){
        $user_args['role'] = $_POST['staffRoles'];
    }
}
if(isset($_POST['staffDisplayName'])){
    // $user_args['search'] = $_POST['staffDisplayName'];
    $searn_name = $_POST['staffDisplayName'];
    $user_args['search'] = '*'.esc_attr( $searn_name ).'*' ;
    $user_args['meta_query'] = array(
        'relation' => 'OR',
        array(
            'key'     => 'first_name',
            'value'   => $searn_name,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'last_name',
            'value'   => $searn_name,
            'compare' => 'LIKE'
        )
    );
}

// The Query
$user_query = new WP_User_Query( $user_args );
$team_found_on_query = $user_query -> get_results();
$total_users = $user_query->total_users;

// Get only the items you need for the current page
// $user_for_current_page = array_slice($team_found_on_query, $offset, $user_per_page);

// Use WP_Query to get the total number of pages for pagination
$total_pages = ceil($total_users/ $user_per_page);

$school_list = $args['school_list'];
$Towns = $args['towns'];
$Jurisdiction = $args['jurisdiction'];
$zone = $args['zone'];
$state_territory = $args['state_territory'];
$indegenous_students = $args['indegenous_students'];
$year_level = $args['year_level'];

?>
<div class="myschool rounded-3 p-3 mb-3">
    <div class="ggsa-members-container bg-brand-secondary p-3 rounded-3 mb-3">
        <div class="table-header overflow-hidden">
            <div class="row m-0">
                <div class="col-sm-6">
                    <div class="list-title d-flex mb-3">
                        <p class="fw-bold mb-0">Staff List</p>
                        <span class="badge existing-tema_ids bg-accent ml-2"><?php echo $total_users;?></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <form id="princiapl_user_search" action="" method="post">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <label for="l_name" class="col-sm-4 col-form-label">Search</label>
                                    <div class="col-sm-8">
                                    <?php
                                    if(isset($_POST['staffDisplayName'])){ ?>
                                        <input type="text" class="form-control" name="staffDisplayName" id="staffDisplayName" placeholder="Name" value="<?php echo $_POST['staffDisplayName']; ?>">
                                    <?php } else { ?>
                                        <input type="text" class="form-control" name="staffDisplayName" id="staffDisplayName" placeholder="Name">
                                    <?php }  
                                    ?>
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 p-0">
                                <div class="row">
                                    <label for="staffRoles" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-4 p-0">
                                        <select name="staffRoles" id="staffRoles" class="form-select" aria-label="Default select example">
                                            <?php
                                            echo '<option value="all">All Staff</option>';
                                            foreach($team_unique_roles as $roles){
                                                $role_name = str_replace('_', ' ', $roles);
                                                echo '<option value="'. $roles . '"' . ( isset($_POST['staffRoles']) && $roles == $_POST['staffRoles'] ? 'selected' : '') . '>'  . ucfirst($role_name) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-primary w-100 d-flex justify-content-center" data-bs-toggle="modal" data-bs-target="#add_more_staff">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/plus-sign.svg';?>" alt="" srcset="">Add More Staff</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive ggsa-members-table mt-2">
            <table class="table">
                <?php if (!empty( $user_query->get_results() ) ) {?>
                    <thead>
                    <tr class="table-header align-middle">
                        <th scope="col">Name</th>
                        <th scope="col" class="text-center">Role</th>
                        <th class="text-center" scope="col">Subject</th>
                        <th class="text-center" scope="col">Year Level</th>
                        <th scope="col">Development Stage</th>
                        <th class="text-center" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                }
                if ( ! empty( $user_query->get_results() ) ) {
                    foreach ($user_query->get_results() as $data){
                        $user_id = $data -> ID;
                        $data = get_userdata($user_id);
                        $user_roles = $data -> roles;
                        $first_name = get_user_meta($user_id, 'first_name', true);
                        $last_name = get_user_meta($user_id, 'last_name', true); 
                        $full_name = $first_name . ' ' . $last_name;
                        $year = get_user_meta($user_id, 'year', true);
                        $subject = get_user_meta( $user_id, 'subject', true );
                        $stage = get_user_meta( $user_id, 'development-stage', true );
                        $user_school = get_user_meta( $user_id, 'school-name', true );
                        $number_of_student = get_user_meta( $user_id, 'number-of-student',true);
                        $indigenous_student_meta = get_user_meta( $user_id, 'indigenous-student',true);
                        $jurisdiction_meta = get_user_meta( $user_id, 'jurisdiction',true);
                        $town_meta = get_user_meta( $user_id, 'town',true);
                        $zone_meta = get_user_meta( $user_id, 'zone',true);
                        $state_meta = get_user_meta( $user_id, 'state',true);
                        $avatar = get_avatar($user_id);
                        $roles = $data->roles[0];
                        $roles = str_replace('_', ' ', $roles);
                        if($data){
                                ?>
                                
                                <tr class="user-information-row">
                                        <td class="name" scope="row">
                                            <div class="user">
                                                <div class="user-picture">
                                                    <?php echo $avatar;?>
                                                </div> 
                                                <p class="user-name"><?php echo $data-> display_name;?></p>
                                            </div>
                                        </td>
                                        <td class="role align-middle">
                                            <div class="staff_role">
                                                <?php echo ucwords($roles);?>
                                            </div>
                                        </td>
                                        <td class="subject align-middle text-center">
                                        <?php
                                            if($subject){ ?>
                                                <p data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $subject;?>"><?php echo $subject;?></p>
                                            <?php } else {
                                                    echo '<p>NA</p>';
                                            }
                                        ?>
                                        </td>
                                        <td class="year-level text-center align-middle">
                                            <p><?php echo ($year ? $year : 'NA');?></p>
                                        </td>
                                        <td class="dev-stage align-middle">
                                            <div class="stage-item">
                                            <?php
                                            if($stage){ ?>
                                                <div class="item-icon">
                                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/stage-'. strtolower($stage)  .'.svg'?>" alt="<?php echo $stage;?>">
                                                </div>
                                                <?php echo $stage;?>
                                            <?php } else {
                                                echo 'NA';
                                                }
                                            ?>
                                            </div>
                                        </td>
                                        <td class="edit_staff">
                                            <div class="action  d-flex justify-content-center gap-3">
                                                <button data-bs-toggle="modal" data-bs-target="<?php echo '#staff-modal-'. $user_id ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User" id="<?php echo 'edit-'. $user_id;?>"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/edit-staff.svg'?>" alt="cup"></button>
                                                <button data-bs-toggle="modal" data-bs-target="<?php echo '#remove-staff-' . $user_id?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove User"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/minus.svg'?>" alt="cup"></button>
                                            </div>
                                        </td>
                                </tr>                                
                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div class="modal fade" id="<?php echo 'remove-staff-' . $user_id;?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title rounded-2 fw-bold" id="modalTitleId">
                                                    Remove Staff 
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><span class="fw-bold"><?php echo $full_name;?></span> is about to leave the <span class="fw-bold"><?php echo $user_school . '.';?></span> This account will no longer be a part of this school membership. This account will retain its individual resources but through its own individual membership.</p>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn cancel btn-outline-secondary border-0" data-bs-dismiss="modal">Cancel</button>
                                                <button id="<?php echo $user_id;?>" type="button" class="btn btn-primary removeStaff">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- staff edit modal-->
                                <div class="modal fade" id="<?php echo 'staff-modal-' . $user_id?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header pb-1">
                                                <h5 class="modal-title fw-bold" id="modalTitleId">
                                                    Edit Staff
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close modal-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="modal-body mt-3 py-0">
                                                <div class="update-personal-info mt-3 border-bottom pb-3">
                                                    <div class="row d-flex justify-content-between mt-2">
                                                        <div class="col"> 
                                                            <h4 class="fw-bold text-start form-title mb-3">Personal Information</h4>
                                                            <div class="mb-3 row">
                                                                <label for="f_name" class="col-sm-3 col-form-label">First Name</label>
                                                                <div class="col-sm-9">
                                                                <input type="text" class="form-control rounded" id="f_name" value="<?php echo $first_name?>" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="l_name" class="col-sm-3 col-form-label">Last Name</label>
                                                                <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="l_name" value="<?php echo $last_name?>" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" type="text" placeholder="Disabled input" aria-label="Disabled input example" value="<?php echo $data -> user_email; ?>" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="<?php echo 'yearLevel-' . $user_id;?>" class="col-sm-3 col-form-label">Year Level</label>
                                                                <div class="col-sm-9">
                                                                    <select id="<?php echo 'yearLevel-' . $user_id;?>" class="form-select" aria-label="Default select example">                            
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
                                                                <label for="s_subject" class="col-sm-3 col-form-label">Subject</label>
                                                                <div class="col-sm-9">
                                                                    <select id="<?php echo 'subject-' . $user_id;?>" class="form-select" aria-label="Default select example">                                                                
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
                                                                        echo '<option value="" disabled selected>Select an option</option>';
                                                                        foreach ($subject_list as $s ){    
                                                                            echo '<option value="'. $s . '"' . ($subject == $s ? "selected" : "" ). '>'  .$s . '</option>';      
                                                                        }
                                                                        ?> 
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="<?php echo 'stage-' . $user_id;?>" class="col-sm-3 col-form-label">Development Stage</label>
                                                                <div class="col-sm-9">
                                                                    <select id="<?php echo 'stage-' . $user_id;?>" class="form-select" aria-label="Default select example">                                                                
                                                                        <?php
                                                                        $dev_stage = [
                                                                            'Foundation',
                                                                            'Proficient',
                                                                            'Accomplished',
                                                                            'Lead',
                                                                        ];
                                                                        echo '<option value="" disabled selected>Select an option</option>';
                                                                        foreach ($dev_stage as $d ){    
                                                                            echo '<option value="'. $d . '"' . ($stage == $d ? "selected" : "" ). '>'  .$d . '</option>';                          
                                                                        }
                                                                        ?> 
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="mb-3 row">
                                                                <label for="staticEmail" class="col-sm-3 col-form-label">Year Level</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-select" aria-label="Default select example">                                                                
                                                                        <?php
                                                                        //  foreach ($year_level as $level ){      
                                                                        //     echo '<option value="'. $level . '">'  .$level . '</option>';               
                                                                        //     }
                                                                        ?> 
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                                            <div class="mb-3 row">
                                                                <label for="staticEmail" class="col-sm-3 col-form-label">Role</label>
                                                                <div class="col-sm-9">
                                                                    <select id="<?php echo 'roles-' . $user_id;?>" class="form-select" aria-label="Default select example">
                                                                        <?php
                                                                            $select_roles = [
                                                                                'teacher' => 'Teacher',
                                                                                'teaching_assistant' => 'Teaching Assistant',
                                                                                'instruction_coach' => 'Instruction Coach',
                                                                            ];
                                                                            foreach ($select_roles as $slug => $name){
                                                                                echo '<option value="'. $slug . '" ' . ($user_roles[0] == $slug ? "selected" : "" ). '>'  . $name . '</option>';
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col"> 
                                                            <h4 class="fw-bold text-start form-title mb-3">School Information</h4>
                                                            <div class="mb-3 row">
                                                                <label for="school_name" class="col-sm-4 col-form-label">School Name</label>
                                                                <div class="col-sm-8">
                                                                <input type="text" class="form-control rounded" id="school_name" value="<?php echo $user_school;?>" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="num_of_s" class="col-sm-4 col-form-label">Number of School Students</label>
                                                                <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="<?php echo 'num-of-s-' . $user_id;?>" placeholder="Number of Students" value="<?php echo $number_of_student?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="indegenousPercent" class="col-sm-4 col-form-label">% Indegenous Students</label>
                                                                <div class="col-sm-8">
                                                                    <select id="<?php echo 'indegenousPercent-' . $user_id;?>" class="form-select" aria-label="Default select example">
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
                                                                    <select id="<?php echo 'jurisdiction-' . $user_id;?>" class="form-select" aria-label="Default select example">
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
                                                                <label for="twon" class="col-sm-4 col-form-label">Town</label>
                                                                <div class="col-sm-8">
                                                                    <select id="<?php echo 'town-' . $user_id;?>" class="form-select" aria-label="Default select example">
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
                                                                    <select id="<?php echo 'zone-' . $user_id;?>" class="form-select" aria-label="Default select example">
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
                                                                    <select id="<?php echo 'stateTerritory-' . $user_id;?>" class="form-select" aria-label="Default select example">
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
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-secondary border-0"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Cancel
                                                </button>
                                                <button type="button" id="<?php echo $user_id;?>" class="save-staff btn btn-primary px-4">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                        }                               
                    }
                } else {
                    echo 'No Staff found.';
                }
                ?>
                </tbody>
            </table>
            <div class="table-navigation">
                <div class="d-flex justify-content-end gap-4">
                    <div class="nav-select d-flex justify-content-end">
                        <form id="user_form" action="" method="post">
                            <label for="" class="form-label"> Rows per page:</label>
                            <select class="p-0 form-select w-50 bg-transparent border-0" name="user_per_page" id="user_per_page">
                                <option <?php if($_SESSION['prows_per_page'] == 10) { echo 'selected'; }?> value="10">10</option>
                                <option <?php if($_SESSION['prows_per_page'] == 20) { echo 'selected'; }?> value="20">20</option>
                                <option <?php if($_SESSION['prows_per_page'] == 30) { echo 'selected'; }?> value="30">30</option>
                                <option <?php if($_SESSION['prows_per_page'] == 50) { echo 'selected'; }?> value="50">50</option>
                            </select>
                        </form>
                    </div>
                    <?php 
                    $prev_icon = '<div class="prev-arrow"><img src="' . get_stylesheet_directory_uri() . '/assets/svg/left-arrow.svg' . '" alt="prev-arrow"></div>';
                    $next_icon = '<div class="next-arrow"><img src="' . get_stylesheet_directory_uri() . '/assets/svg/right-arrow.svg' . '" alt="right-arrow"></div>';
                    
                    echo '<div class="page-quantity">';

                    echo paginate_links(array(
                        // 'total'     => $user_query->max_num_pages,
                        'total'     => $total_pages,
                        'prev_text' => $prev_icon,
                        'next_text' => $next_icon,
                        'current'   => $paged,
                    ));
                    echo '<div>';
                    ?>
                </div>
            </div>
        </div>
    </div>                
</div>

<!-- Invite Staff -->
<div class="modal fade" id="add_more_staff" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="staff">
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
                    <p class="form-label">Email list of staff invited:</p>
                    <ul class="invited-emails list-group">
                        <?php 
                        $invited_user_emails =  get_user_meta(get_current_user_id(), 'invited_staff_email_ids', true);

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

<!-- Flexbox container for aligning the toasts -->
<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center"> 
    <!-- Then put toasts within -->
    <div class="position-fixed top-20 end-0 p-3" style="z-index: 99999">
        <div id="success" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true">
            <div class="toast-header">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/alert-check-outline.png' ?>" class="rounded me-2" alt="check-icon">
                <h6 class="mr-auto fw-bold" style="flex: 1 0 0">Email has been sent successfully</h6>
                <button type="button" class="ms-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center"> 
    <!-- Then put toasts within -->
    <div class="position-fixed top-20 end-0 p-3" style="z-index: 99999">
        <div id="failed" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true">
            <div class="toast-header">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/error.png' ?>" class="rounded me-2" alt="check-icon">
                <h6 class="mr-auto fw-bold" style="flex: 1 0 0">Email Address Not Verified</h6>
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