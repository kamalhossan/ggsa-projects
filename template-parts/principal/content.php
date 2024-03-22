<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$users  = get_user_in_team(get_current_user_id());
// excluding remove staff from team
$removed_staff_ids = get_user_meta(get_current_user_id(), 'staff_removed_from_school', true);
if(!empty($removed_staff_ids)){
    $users = array_diff($users, $removed_staff_ids);
}

// default selection for the options
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $_SESSION['rows_per_page'] = $_POST["user_per_page"];
}

if(! isset($_SESSION['rows_per_page'])){
    $_SESSION['rows_per_page'] = 10;
}

// Define how many items to display per page
$user_per_page = $_SESSION['rows_per_page'];

// Get the current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Calculate the offset to start displaying items from
$offset = ($paged - 1) * $user_per_page;

// Get only the items you need for the current page
$user_for_current_page = array_slice($users, $offset, $user_per_page);

// Use WP_Query to get the total number of pages for pagination
$total_pages = ceil(count($users) / $user_per_page);

 ?>
 
 <section id="principal-content" class="mb-4">
    <div class="ggsa-member-list mt-5">
        <div class="container">
            <div class="row">
                <h4 class="text-brand-navy font-calibri fw-bold text-brand-primary text-center">Below is a list of all your staff who are already GGSA members</h4>
                <div class="ggsa-members-container bg-brand-secondary p-3 rounded-3 mb-5">
                    <div class="list-title mb-3">
                        <p class="fw-bold">Total</p>
                        <span class="badge existing-users bg-accent"><?php echo count($users);?></span>
                    </div>
                    <div class="table-responsive ggsa-members-table">
                        <table class="table">
                            <thead>
                                <tr class="table-header align-middle">
                                    <th scope="col">Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Subject</th>
                                    <th class="text-center" scope="col">Year Level</th>
                                    <th scope="col">Development Stage</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($user_for_current_page as $user_id){
                                $data = get_userdata($user_id);
                                $subject = get_user_meta( $user_id, 'subject', true );
                                $stage = get_user_meta( $user_id, 'development-stage', true );
                                $year = get_user_meta($user_id, 'year', true);
                                $avatar = get_avatar($user_id);
                                $roles = $data->roles[0];
                                $roles = str_replace('_', ' ', $roles);
                                if($data){
                                        ?>
                                        <tr class="user-information-row">
                                                <td class="user" scope="row">
                                                    <div class="user">
                                                        <div class="user-picture">
                                                            <?php echo $avatar;?>
                                                        </div> 
                                                        <p class="user-name"><?php echo $data-> display_name;?></p>
                                                    </div>
                                                </td>
                                                <td class="role align-middle">
                                                    <p data-toggle="tooltip" data-placement="top" title="<?php echo ucwords($roles);?>"><?php echo ucwords($roles);?></p>
                                                </td>
                                                <td class="subject align-middle">
                                                <?php
                                                    if($subject){ ?>
                                                        <p data-toggle="tooltip" data-placement="top" title="<?php echo $subject;?>"><?php echo $subject;?></p>
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
                                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/stage-'. strtolower($stage) .'.svg'?>" alt="cup">
                                                        </div>
                                                        <?php echo $stage;?>
                                                    <?php } else {
                                                        echo 'NA';
                                                        }
                                                    ?>
                                                    </div>
                                                </td>
                                        </tr>
                                    <?php 
                                }                               
                                ?>
                             <?php
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
                                            <option <?php if($_SESSION['rows_per_page'] == 10) { echo 'selected'; }?> value="10">10</option>
                                            <option <?php if($_SESSION['rows_per_page'] == 20) { echo 'selected'; }?> value="20">20</option>
                                            <option <?php if($_SESSION['rows_per_page'] == 30) { echo 'selected'; }?> value="30">30</option>
                                            <option <?php if($_SESSION['rows_per_page'] == 50) { echo 'selected'; }?> value="50">50</option>
                                        </select>
                                    </form>
                                </div>
                                <?php 
                                $prev_icon = '<div class="prev-arrow"><img src="' . get_stylesheet_directory_uri() . '/assets/svg/left-arrow.svg' . '" alt="prev-arrow"></div>';
                                $next_icon = '<div class="next-arrow"><img src="' . get_stylesheet_directory_uri() . '/assets/svg/right-arrow.svg' . '" alt="right-arrow"></div>';
                                
                                echo '<div class="page-quantity">';

                                echo paginate_links(array(
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
        </div>
    </div>
 </section>