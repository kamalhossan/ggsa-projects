<?php

//exit if access directly
if ( !defined( 'ABSPATH' ) ) exit;


function enroll_course_parent_category_name($course){
	
	$taxonomy = 'ld_course_category';

	// getting category object by taxonomy
	$category = get_the_terms($course, $taxonomy);

	$parent_category = '';
	
	// current course category informations	
	if (is_array($category) && !empty($category)) {
		$category_id = $category[0]->term_id;

		//formating the breadcrumb to getting the parent category
		$category_breadcrumb =  get_term_parents_list($category_id, $taxonomy, array(
			'format' => 'name',
			'separator' => '/',
			'link' => false
		));
	
		// Use explode to split the string by "/"
		$explode = explode('/', $category_breadcrumb);
	
		// Get the content before the first "/"
		$parent_category = $explode[0];

	}
	
	return $parent_category;

}

add_action( 'wp_enqueue_scripts', 'onboarding_page_scripts' );
function onboarding_page_scripts() {
	if(is_user_logged_in()){
		?>
		<style>
			.login-user-hide {
			display: none !important;
		}
		</style>
		<?php
	};
}

add_action( 'wp_ajax_add_curr_user_onboarding', 'add_curr_user_onboarding' );
add_action( 'wp_ajax_nopriv_add_curr_user_onboarding', 'add_curr_user_onboarding' ); // Allow non-logged in users to like

function add_curr_user_onboarding() {
    check_ajax_referer( 'like-nonce', 'nonce' );

    $course_id = $_POST['course_id'];
	ob_start();

	$course_name = get_the_title($course_id);
	$permalink = get_the_permalink($course_id);

	$features_image = get_the_post_thumbnail_url($course_id);

	if ( empty($features_image)){
		$features_image = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
	} ?>
	<div class="item-course <?php echo 'on-ur-library-' . $course_id;?>">
		<div class="img-course">
			<img src="<?php echo $features_image;?>" alt="<?php echo $course_name?>" class="link-img-course">
		</div>
		<div class="info-course">
			<h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_name;?>">
				<?php echo $course_name;?>
			</h5>
			<div class="course-duration">
				<div class="number-lesson">
					<div class="icon-lesson">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/book.svg'?>" alt="curriculum">
					</div>
					<span class="text-number-lesson"><?php
				
						$course_progress_summary = learndash_user_get_course_progress(get_current_user_id(), $course_id, 'summary');

						if (isset($course_progress_summary['status'])) {
							$course_status_slug = esc_attr($course_progress_summary['status']);
						}

						if (isset($course_progress_summary['completed'])) {
							$coursep['completed'] = absint($course_progress_summary['completed']);
						}

						if (isset($course_progress_summary['total'])) {
							$coursep['total'] = absint($course_progress_summary['total']);
						}
						if(  $coursep['total'] == 0 ||  $coursep['total'] == 1 ) {
							echo ' ' . wp_kses_post(sprintf(_x('%s Lesson ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
						}
						else{
							echo ' ' . wp_kses_post(sprintf(_x('%s Lessons ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
						}
						?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php 
	echo ob_get_clean();
	die();
}

add_action( 'wp_ajax_remove_curr_user_onboarding', 'remove_curr_user_onboarding' );
add_action( 'wp_ajax_nopriv_remove_curr_user_onboarding', 'remove_curr_user_onboarding' ); 

function remove_curr_user_onboarding() {
    check_ajax_referer( 'like-nonce', 'nonce' );

    $course_id = $_POST['course_id'];
	echo true;

	die();
}

add_action( 'wp_ajax_add_pro_lern_user_onboarding', 'add_pro_lern_user_onboarding' );
add_action( 'wp_ajax_nopriv_add_pro_lern_user_onboarding', 'add_pro_lern_user_onboarding' ); // Allow non-logged in users to like

function add_pro_lern_user_onboarding() {
    check_ajax_referer( 'like-nonce', 'nonce' );

    $course_id = $_POST['course_id'];
	ob_start();
	$course_name = get_the_title($course_id);
	$permalink = get_the_permalink($course_id);

	$features_image = get_the_post_thumbnail_url($course_id);

	if ( empty($features_image)){
		$features_image = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
	}
	?>
	<div class="item-course <?php echo 'on-ur-library-' . $course_id;?>">
		<div class="img-course pro-lrn-img">
			<img src="<?php echo $features_image;?>" alt="<?php echo $course_name?>" class="link-img-course pro-lrn-img">
		</div>
		<div class="info-course">
			<h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_name;?>">
				<?php echo $course_name;?>
			</h5>
			<div class="course-duration">
				<div class="number-lesson">
					<div class="icon-lesson">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/book.svg'?>" alt="professional improvement">
					</div>
					<span class="text-number-lesson"><?php
				
						$course_progress_summary = learndash_user_get_course_progress(get_current_user_id(), $course_id, 'summary');

						if (isset($course_progress_summary['status'])) {
							$course_status_slug = esc_attr($course_progress_summary['status']);
						}

						if (isset($course_progress_summary['completed'])) {
							$coursep['completed'] = absint($course_progress_summary['completed']);
						}

						if (isset($course_progress_summary['total'])) {
							$coursep['total'] = absint($course_progress_summary['total']);
						}
						if(  $coursep['total'] == 0 ||  $coursep['total'] == 1 ) {
							echo ' ' . wp_kses_post(sprintf(_x('%s Lesson ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
						}
						else{
							echo ' ' . wp_kses_post(sprintf(_x('%s Lessons ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
						}
						?>
					
					</span>
				</div>
				<div class="hours-lesson">
					<div class="icon-hours">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
							<g clip-path="url(#clip0_6407_8254)">
								<path d="M16.5 9C16.5 13.14 13.14 16.5 9 16.5C4.86 16.5 1.5 13.14 1.5 9C1.5 4.86 4.86 1.5 9 1.5C13.14 1.5 16.5 4.86 16.5 9Z" stroke="#9D9D9D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M11.7827 11.3851L9.45766 9.99757C9.05266 9.75757 8.72266 9.18007 8.72266 8.70757V5.63257" stroke="#9D9D9D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</g>
							<defs>
								<clipPath id="clip0_6407_8254">
								<rect width="18" height="18" fill="white"/>
								</clipPath>
							</defs>
						</svg>
					</div>
					<span class="text-hours-lesson">
					<?php
						$c_time = get_post_meta( $course_id , 'course_time' , true );
						if( $c_time ){
							if ($c_time == 1 || $c_time == 0){
								echo $c_time." hour";
							}
							else{
								echo $c_time." hours";
							}
						}
						else{
							echo "8 hours";
						}
					?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php 
	echo ob_get_clean();
	die();
}

add_action( 'wp_ajax_remove_pro_lern_user_onboarding', 'remove_pro_lern_user_onboarding' );
add_action( 'wp_ajax_nopriv_remove_pro_lern_user_onboarding', 'remove_pro_lern_user_onboarding' ); 

function remove_pro_lern_user_onboarding() {
    check_ajax_referer( 'like-nonce', 'nonce' );

    $course_id = $_POST['course_id'];
	echo true;
	die();
}

add_action( 'wp_ajax_add_scl_imp_user_onboarding', 'add_scl_imp_user_onboarding' );
add_action( 'wp_ajax_nopriv_add_scl_imp_user_onboarding', 'add_scl_imp_user_onboarding' ); // Allow non-logged in users to like

function add_scl_imp_user_onboarding() {
    check_ajax_referer( 'like-nonce', 'nonce' );


    $course_id = $_POST['course_id'];

	$course_title = get_the_title($course_id);

	ob_start();

	$course_name = get_the_title($course_id);
	$permalink = get_the_permalink($course_id);

	$features_image = get_the_post_thumbnail_url($course_id);

	if ( empty($features_image)){
		$features_image = get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg';
	} ?>
	<div class="item-course <?php echo 'on-ur-library-' . $course_id;?>">
		<div class="img-course">
			<img src="<?php echo $features_image;?>" alt="<?php echo $course_name?>" class="link-img-course">
		</div>
		<div class="info-course">
			<h5 class="title-course" data-toggle="tooltip" data-placement="top" title="<?php echo $course_name;?>">
				<?php echo $course_name;?>
			</h5>
			<div class="course-duration">
				<div class="number-lesson">
					<div class="icon-lesson">
						<img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/document.svg'?>" alt="school improvement">
					</div>
					<span class="text-number-lesson"><?php
				
						$course_progress_summary = learndash_user_get_course_progress(get_current_user_id(), $course_id, 'summary');

						if (isset($course_progress_summary['status'])) {
							$course_status_slug = esc_attr($course_progress_summary['status']);
						}

						if (isset($course_progress_summary['completed'])) {
							$coursep['completed'] = absint($course_progress_summary['completed']);
						}

						if (isset($course_progress_summary['total'])) {
							$coursep['total'] = absint($course_progress_summary['total']);
						}
						if(  $coursep['total'] == 0 ||  $coursep['total'] == 1 ) {
							echo ' ' . wp_kses_post(sprintf(_x('%s document ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
						}
						else{
							echo ' ' . wp_kses_post(sprintf(_x('%s documents ', 'placeholders: Course steps completed, Course steps total', 'learndash'),  $coursep['total']));
						}
						?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php 
	
	echo ob_get_clean();

	die();
}

add_action( 'wp_ajax_remove_scl_imp_user_onboarding', 'remove_scl_imp_user_onboarding' );
add_action( 'wp_ajax_nopriv_remove_scl_imp_user_onboarding', 'remove_scl_imp_user_onboarding' ); 

function remove_scl_imp_user_onboarding() {
    check_ajax_referer( 'like-nonce', 'nonce' );

    $course_id = $_POST['course_id'];

	$course_title = get_the_title($course_id);

	echo true;

	die();
}


add_action( 'wp_ajax_enroll_user_from_onboarding_page', 'enroll_user_from_onboarding_page' );
add_action( 'wp_ajax_nopriv_enroll_user_from_onboarding_page', 'enroll_user_from_onboarding_page' ); 

function enroll_user_from_onboarding_page(){

	$user_id = get_current_user_id();
	$meta_key = 'onboarding_add_to_library_count';

	$post_array = $_POST['course_array'];
    $course_array = array_unique($post_array);

	foreach($course_array as $course_id) {
		ld_update_course_access( $user_id, $course_id, $remove = false );
	}

	$check_meta = get_user_meta( $user_id, $meta_key, true);
	if(!$check_meta){
		add_user_meta($user_id, $meta_key, count($course_array));
	} else {
		$total_enroll = $check_meta + count($course_array);
		update_user_meta($user_id, $meta_key, $total_enroll);
	}

	$enroll_meta_exists = get_user_meta( $user_id, 'onboarding_enroll_course_array', true );

	if($enroll_meta_exists){
		$old_enroll_array = get_user_meta( $user_id, 'onboarding_enroll_course_array', true );
		$new_enroll_array = $course_array;
		$total_enroll_array = array_unique(array_merge($old_enroll_array, $new_enroll_array));
		update_user_meta($user_id, 'onboarding_enroll_course_array' , $total_enroll_array);
	} else {
		$old_enroll_array = $course_array;
		add_user_meta($user_id, 'onboarding_enroll_course_array', $old_enroll_array);
	}

	// add_user_meta($user_id, 'ggsa_onboarding_courses_added', true);
	// update_user_meta($user_id, 'ggsa_onboarding_courses_added', false);

	echo true;
	die();
}


add_action( 'wp_ajax_enroll_user_from_resources_page', 'enroll_user_from_resources_page' );
add_action( 'wp_ajax_nopriv_enroll_user_from_resources_page', 'enroll_user_from_resources_page' ); 

function enroll_user_from_resources_page(){

	$user_id = get_current_user_id();

    $course_array = $_POST['course_array'];

	foreach($course_array as $course_id) {
		ld_update_course_access( $user_id, $course_id, $remove = false );
	}

	echo true;
	die();
}


add_action( 'wp_ajax_add_meta_value_on_complete', 'add_meta_value_on_complete' );
add_action( 'wp_ajax_nopriv_add_meta_value_on_complete', 'add_meta_value_on_complete' ); 

function add_meta_value_on_complete(){

	$user_id = get_current_user_id();

	$course_array = $_POST['course_array'];

	foreach($course_array as $course_id) {
		ld_update_course_access( $user_id, $course_id, $remove = false );
	}

	add_user_meta($user_id, 'ggsa_onboarding_courses_added', true);

	// update_user_meta($user_id, 'ggsa_onboarding_courses_added', false);
	echo true;
	die();
}



add_action( 'wp_ajax_preselected_course_ids', 'preselected_course_ids' );
add_action( 'wp_ajax_nopriv_preselected_course_ids', 'preselected_course_ids' ); 

function preselected_course_ids(){
	$enroll_course_quantity = learndash_user_get_enrolled_courses(get_current_user_id(), array());

	echo $course_ids = json_encode($enroll_course_quantity);

	// echo 'page loads';

	die();
}

add_action( 'wp_ajax_principal_staff_invitaions_by_email', 'principal_staff_invitaions_by_email' );
add_action( 'wp_ajax_nopriv_principal_staff_invitaions_by_email', 'principal_staff_invitaions_by_email' ); 

function principal_staff_invitaions_by_email(){

	$current_user = wp_get_current_user();
	$current_user_email = $current_user -> user_email;
	$organisations = substr($current_user_email, strpos($current_user_email, '@'));

	$user_input_email = sanitize_text_field( wp_unslash( $_POST['userEmail'] ) );

	$validate_email  = substr($user_input_email, strpos($user_input_email, '@'));

	if($organisations == $validate_email){

		$user_id = get_current_user_id();
		$meta_key = 'invited_staff_email_ids';
		$check_meta =  get_user_meta($user_id, $meta_key, true);

		// sending email here
		$staff_inviation_subject = get_field('staff_inviation_subject', 'Options');
		$staff_inviation_content = get_field('staff_inviation_content', 'Options');
		

		if($check_meta){
			$existing_invitee = get_user_meta($user_id, $meta_key, true);
			// check existing user here
			if(in_array($user_input_email, $existing_invitee)){
				echo 'already_exits';
				die();
			}else {
				$existing_invitee[] = $user_input_email;
				update_user_meta($user_id, $meta_key, $existing_invitee);
				wp_mail($user_input_email, $staff_inviation_subject, $staff_inviation_content);
			}
		} else {
			$existing_invitee = [];
			$existing_invitee[] = $user_input_email;
			add_user_meta($user_id, $meta_key, $existing_invitee);
			wp_mail($user_input_email, $staff_inviation_subject, $staff_inviation_content);
		}
		echo 'Verified';
	} else {
		echo 'You can only invite staff from your organisations for example: ' . $organisations; 
	}
	die();
}

add_action( 'wp_ajax_delegate_to_deputy_principal', 'delegate_to_deputy_principal' );
add_action( 'wp_ajax_nopriv_delegate_to_deputy_principal', 'delegate_to_deputy_principal' ); 

function delegate_to_deputy_principal(){

	$current_user = wp_get_current_user();
	$current_user_email = $current_user -> user_email;
	$organisations = substr($current_user_email, strpos($current_user_email, '@'));

	$user_input_email = sanitize_text_field( wp_unslash( $_POST['userEmail'] ) );

	$validate_email  = substr($user_input_email, strpos($user_input_email, '@'));

	if($organisations == $validate_email){

		$user_id = get_current_user_id();
		$meta_key = 'delegate_to_deputy_principal';
		$check_meta =  get_user_meta($user_id, $meta_key, true);

		if($check_meta){
			echo 'exits';
			die();
		} else {
			//if user exists we are assigining the new role principal so that they can access principal flow page
			$invited_user = get_user_by('email', $user_input_email);
			if($invited_user){
				$invited_user_new_role = new WP_User($invited_user -> ID);
				$invited_user_new_role -> add_role('principal', 'Principal', array());
			} else {
				echo 'user_not_found';
				die();
			}

			//adding user meta so that we can show the administrator their existing invited deputy principal
			add_user_meta($user_id, $meta_key, $user_input_email);

			// sending email here
			$principal_delegate_subject = get_field('principal_delegate_subject', 'Options');
			$principal_delegate_content = get_field('principal_delegate_content', 'Options');
			wp_mail($user_input_email, $principal_delegate_subject, $principal_delegate_content);
			echo 'Verified';
			die();
		}
	} else {
		echo 'You can only invite staff from your organisations for example: ' . $organisations; 
	}
	die();
}

add_action( 'wp_ajax_delegate_to_school_administrator', 'delegate_to_school_administrator' );
add_action( 'wp_ajax_nopriv_delegate_to_school_administrator', 'delegate_to_school_administrator' ); 

function delegate_to_school_administrator(){

	$current_user = wp_get_current_user();
	$current_user_email = $current_user -> user_email;
	$organisations = substr($current_user_email, strpos($current_user_email, '@'));

	$user_input_email = sanitize_text_field( wp_unslash( $_POST['userEmail'] ) );

	$validate_email  = substr($user_input_email, strpos($user_input_email, '@'));

	if($organisations == $validate_email){

		$user_id = get_current_user_id();
		$meta_key = 'delegate_to_school_administrator';
		$check_meta =  get_user_meta($user_id, $meta_key, true);

		if($check_meta){
			echo 'exits';
			die();
		} else {
			//if user exists we are assigining the new role principal so that they can access principal flow page
			$invited_user = get_user_by('email', $user_input_email);
			if($invited_user){
				$invited_user_new_role = new WP_User($invited_user -> ID);
				$invited_user_new_role -> add_role('principal', 'Principal', array());
			} else {
				echo 'user_not_found';
				die();
			}
			//adding user meta so that we can show the administrator their existing invited deputy principal
			add_user_meta($user_id, $meta_key, $user_input_email);

			// sending email here
			$school_admin_subject = get_field('school_admin_subject', 'Options');
			$school_admin_content = get_field('school_admin_content', 'Options');
			wp_mail($user_input_email, $school_admin_subject, $school_admin_content);
			echo 'Verified';
			die();
		}
	} else {
		echo 'You can only invite staff from your organisations for example: ' . $organisations; 
	}
	die();
}


add_action('user_register', 'ggsa_pre_selected_course_to_enroll', 10, 1);

function ggsa_pre_selected_course_to_enroll($user_id) {

	if(get_user_meta( $user_id, 'spelling_mastery' ) == true) {
		$args = array(
			'post_type' => 'sfwd-courses',
			'tax_query' => array(
				array(
					'taxonomy' => 'ld_course_tag',
					'field' => 'slug',
					'terms' => 'spelling-mastery',
				),
			),
		);
		
		$spelling_mastery = new WP_Query( $args );
		
		if($spelling_mastery -> have_posts()){
			$course_ids = [];
		
			while ($spelling_mastery -> have_posts()){
				$spelling_mastery -> the_post();
				$course_ids[] = get_the_ID();
			}
		
			wp_reset_postdata();
			foreach($course_ids as $course_id) {
				ld_update_course_access( $user_id, $course_id, $remove = false );
			}
		}
	}

	if(get_user_meta( $user_id, 'cmc_campaign' ) == true) {
		$args = array(
			'post_type' => 'sfwd-courses',
			'tax_query' => array(
				array(
					'taxonomy' => 'ld_course_tag',
					'field' => 'slug',
					'terms' => 'cmc-campaign',
				),
			),
		);
		
		$cmc_campaign = new WP_Query( $args );
		
		if($cmc_campaign -> have_posts()){
			$course_ids = [];
		
			while ($cmc_campaign -> have_posts()){
				$cmc_campaign -> the_post();
				$course_ids[] = get_the_ID();
			}
		
			wp_reset_postdata();
			foreach($course_ids as $course_id) {
				ld_update_course_access( $user_id, $course_id, $remove = false );
			}
		}
	}

	if(get_user_meta( $user_id, 'corrective_reading' ) == true) {
		$args = array(
			'post_type' => 'sfwd-courses',
			'tax_query' => array(
				array(
					'taxonomy' => 'ld_course_tag',
					'field' => 'slug',
					'terms' => 'corrective-reading',
				),
			),
		);
		
		$corrective_reading = new WP_Query( $args );
		
		if($corrective_reading -> have_posts()){
			$course_ids = [];
		
			while ($corrective_reading -> have_posts()){
				$corrective_reading -> the_post();
				$course_ids[] = get_the_ID();
			}
		
			wp_reset_postdata();
			foreach($course_ids as $course_id) {
				ld_update_course_access( $user_id, $course_id, $remove = false );
			}
		}
	}

	if(get_user_meta( $user_id, 'reading_mastery' ) == true) {
		$args = array(
			'post_type' => 'sfwd-courses',
			'tax_query' => array(
				array(
					'taxonomy' => 'ld_course_tag',
					'field' => 'slug',
					'terms' => 'reading-mastery',
				),
			),
		);
		
		$reading_mastery = new WP_Query( $args );
		
		if($reading_mastery -> have_posts()){
			$course_ids = [];
		
			while ($reading_mastery -> have_posts()){
				$reading_mastery -> the_post();
				$course_ids[] = get_the_ID();
			}
		
			wp_reset_postdata();
			foreach($course_ids as $course_id) {
				ld_update_course_access( $user_id, $course_id, $remove = false );
			}
		}
	}
}



add_action( 'wp_ajax_onboarding_search_program', 'onboarding_search_program');
add_action( 'wp_ajax_nopriv_onboarding_search_program', 'onboarding_search_program');

function onboarding_search_program(){

	$id = sanitize_text_field($_POST['category_id']);
    $keyword = sanitize_text_field($_POST['s_program']);
    $parent_term_slug = sanitize_text_field($_POST['current_tab']);
    $main_parent_tab_slug = sanitize_text_field($_POST['main_parent_tab_slug']);

	ob_start();

	get_template_part('new/search-result', null, array(
		'id' => $id,
		'keyword' => $keyword,
		'parent_term_slug' => $parent_term_slug, 
		'main_parent_tab_slug' => $main_parent_tab_slug, 
	));

	//old ajax method
	// $parent_slug = $_POST["parentSlug"];
	// $parent_id = $_POST["parentId"];
	// $keyword = $_POST["keyword"];

	// get_template_part('new/search-result', null, array(
	// 	'parent_id' => $parent_id,
	// 	'parent_slug' => $parent_slug,
	// 	'keyword' => $keyword 
	// ));

	echo ob_get_clean();
	die();
}

add_action('wp_ajax_search_resource_get_hint', 'search_resource_get_hint');
add_action('wp_ajax_nopriv_search_resource_get_hint', 'search_resource_get_hint'); // If you want to handle non-logged in users

function search_resource_get_hint() {

	function learndash_get_all_course_ids() {
		$query_args = array(
			'post_type'         =>   'sfwd-courses',
			'post_status'       =>   'publish',
			'fields'            =>   'ids',
			'orderby'           =>   'title',
			'order'             =>   'ASC',
			'nopaging'          =>   true    // Turns OFF paging logic to get ALL courses
		);
	 
		$query = new WP_Query( $query_args );
		if ( $query instanceof WP_Query) {
			return $query->posts;
		}
	}
	
	$all_course_ids = learndash_get_all_course_ids();

	$all_courses = [];

	foreach($all_course_ids as $course_id){
	    $all_courses[] = array(
			'course_id' => $course_id,
			'title' => get_the_title($course_id)
		  ); 
	}

	$q = sanitize_text_field($_GET['q']);

	$hint = "";

	$found_course = [];

	if ($q !== "") {
		$q = strtolower($q);
		foreach($all_courses as $course) {
			$name = $course['title'];
			$course_id = $course['course_id'];
			if (stristr($name, $q)) {
				$found_course[] = $course['course_id'];
			}
		}
	}

	if(count($found_course) > 0){
		ob_start();
		get_template_part('template-parts/resources/suggestion', null, array(
			'course_array' => $found_course,
			'keyword' => $q
		));
		echo ob_get_clean();
	} else {
		echo 'Sorry, we couldn’t find a match for “' . $q . '” Please try another search!';
	}
	
    die();

}

function wp_login_redirect_to_all_user($redirect_to, $request, $user){

	if ( isset( $user->roles ) && is_array( $user->roles ) ) {

		$onboarding_users= array(
		'teacher',
		'teaching_assistant',
		'instruction_coach',
		);

		//check for access of onboarding page
		if ( array_intersect( $user->roles, $onboarding_users) ) {
			// check if they already complete onboarding process
			if (get_user_meta($user -> ID, 'ggsa_onboarding_courses_added', true) == true) {
			wp_redirect(home_url('dashboard'));
			exit;
			} else {
			wp_redirect(home_url('onboarding'));
			exit;
			}
		} elseif (in_array( 'principal', $user->roles )){
			if(get_user_meta($user -> ID, 'complete_principal_onboarding_flow', true) == true){
				wp_redirect(home_url('dashboard'));
				exit;
			} else {
				wp_redirect(home_url('principal-flow'));
				exit;
			}
		} else {
			wp_redirect(home_url());
			exit;
		}
	} else {
		return $redirect_to;
	}
}

add_filter('login_redirect', 'wp_login_redirect_to_all_user', 10, 3);


function add_srp_role_for_principal($user_id){

	$user_obj = get_userdata($user_id);
	$user_roles = $user_obj -> roles;

	if(in_array('principal', $user_roles)){
		$user_obj -> add_role( 'school_resource_partnership ', 'School Resource Partnership', get_role( 'principal' )->capabilities );
	}
}

add_action('user_register', 'add_srp_role_for_principal');

add_action('wp_ajax_update_profile_data', 'update_profile_data');
add_action('wp_ajax_nopriv_update_profile_data', 'update_profile_data'); // If you want to handle non-logged in users

function update_profile_data(){

	$user_id = get_current_user_id();

	$fName = sanitize_text_field($_POST['fname']);
	$lName = sanitize_text_field($_POST['lName']);
	$sName = sanitize_text_field($_POST['sName']);
	$yLevel = sanitize_text_field($_POST['yLevel']);
	$subject = sanitize_text_field($_POST['subject']);
	$stage = sanitize_text_field($_POST['stage']);
	$number_of_school_students = sanitize_text_field($_POST['numofss']);
	$indegenous_percent = sanitize_text_field($_POST['indegenousPercent']);
	$jurisdiction = sanitize_text_field($_POST['jurisdiction']);
	$town = sanitize_text_field($_POST['town']);
	$zone = sanitize_text_field($_POST['zone']);
	$stateTerritory = sanitize_text_field($_POST['state']);

	update_user_meta($user_id, 'first_name', $fName);
	update_user_meta($user_id, 'last_name', $lName);
	update_user_meta($user_id, 'school-name', $sName);
	update_user_meta($user_id, 'year', $yLevel);
	update_user_meta($user_id, 'subject', $subject);
	update_user_meta($user_id, 'development-stage', $stage);
	update_user_meta( $user_id, 'number-of-student', $number_of_school_students);
	update_user_meta( $user_id, 'indigenous-student', $indegenous_percent);
	update_user_meta( $user_id, 'jurisdiction', $jurisdiction);
	update_user_meta( $user_id, 'town', $town);
	update_user_meta( $user_id, 'zone', $zone);
	update_user_meta( $user_id, 'state', $stateTerritory);

	echo true;
	die();
}

add_action('wp_ajax_teacher_self_removed_from_school', 'teacher_self_removed_from_school');
add_action('wp_ajax_nopriv_teacher_self_removed_from_school', 'teacher_self_removed_from_school'); // If you want to handle non-logged in users

function teacher_self_removed_from_school(){

	$user_id = get_current_user_id();
	delete_user_meta($user_id, 'school-name', $sName);
	echo true;
	die();
}

add_action('wp_ajax_edit_staff_details_by_principal', 'edit_staff_details_by_principal');
add_action('wp_ajax_nopriv_edit_staff_details_by_principal', 'edit_staff_details_by_principal'); // If you want to handle non-logged in users

function edit_staff_details_by_principal(){

	$user_id = sanitize_text_field($_POST['id']);
	$number_of_school_students = sanitize_text_field($_POST['schoolSTudent']);
	$subject = sanitize_text_field($_POST['subject']);
	$role = sanitize_text_field($_POST['role']);
	$stage = sanitize_text_field($_POST['stage']);
	$year = sanitize_text_field($_POST['year']);
	$indegenous_percent = sanitize_text_field($_POST['indegenousPercent']);
	$jurisdiction = sanitize_text_field($_POST['jurisdiction']);
	$town = sanitize_text_field($_POST['town']);
	$zone = sanitize_text_field($_POST['zone']);
	$stateTerritory = sanitize_text_field($_POST['stateTerritory']);

	wp_update_user( array( 'ID' => $user_id, 'role' => $role) );
	update_user_meta($user_id, 'subject', $subject);
	update_user_meta($user_id, 'development-stage', $stage);
	update_user_meta($user_id, 'year', $year);
	update_user_meta( $user_id, 'number-of-student', $number_of_school_students);
	update_user_meta( $user_id, 'indigenous-student', $indegenous_percent);
	update_user_meta( $user_id, 'jurisdiction', $jurisdiction);
	update_user_meta( $user_id, 'town', $town);
	update_user_meta( $user_id, 'zone', $zone);
	update_user_meta( $user_id, 'state', $stateTerritory);
	
	echo true;
	die();
}

add_action('wp_ajax_remove_staff_from_staff_list', 'remove_staff_from_staff_list');
add_action('wp_ajax_nopriv_remove_staff_from_staff_list', 'remove_staff_from_staff_list'); // If you want to handle non-logged in users

function remove_staff_from_staff_list(){

	$user_id = sanitize_text_field($_POST['id']);
	$user = get_user_by('ID', $user_id);
	$display_name = $user->display_name;

	delete_user_meta( $user_id, 'school-name');

	$current_user_id = get_current_user_id();
	$meta_key = 'staff_removed_from_school';

	$check_meta = get_user_meta($current_user_id, 'staff_removed_from_school', true);

	if($check_meta){
		$removed_staff_ids = get_user_meta($current_user_id, $meta_key, true);
		$removed_staff_ids[] = $user_id;
		update_user_meta($current_user_id, $meta_key, $removed_staff_ids);
	}
	else {
		$removed_staff_ids = [];
		$removed_staff_ids[] = $user_id;
		add_user_meta($current_user_id, $meta_key, $removed_staff_ids);
	}
	echo $display_name;
	die();
}

add_action('wp_ajax_complete_principal_onboarding_flow', 'complete_principal_onboarding_flow');
add_action('wp_ajax_nopriv_complete_principal_onboarding_flow', 'complete_principal_onboarding_flow'); // If you want to handle non-logged in users

function complete_principal_onboarding_flow(){
	add_user_meta(get_current_user_id(), 'complete_principal_onboarding_flow', true);
	echo true;
	die();
}

add_action('init', 'add_topic_likes_custom_field');

function add_topic_likes_custom_field() {
    register_post_meta('sfwd-topic', 'topic_likes', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
    ));
}

add_action('wp_ajax_topic_likes_action', 'topic_likes_action');
add_action('wp_ajax_nopriv_topic_likes_action', 'topic_likes_action'); 

function topic_likes_action(){
	$user_id = get_current_user_id();
	$topic_id = sanitize_text_field($_POST['topicId']);
	$likes_count = get_post_meta($topic_id, 'topic_likes', true);

	if(get_user_meta($user_id, $topic_id, true) == true){
		$likes_count--;
		update_post_meta($topic_id, 'topic_likes', $likes_count);
		update_user_meta($user_id, $topic_id, false);
		echo 'unlike';
	} else {
		$likes_count++;
		update_post_meta($topic_id, 'topic_likes', $likes_count);
		update_user_meta($user_id, $topic_id, true);
		echo 'like';
	}
	
	die();
}

add_action('wp_ajax_report_mistakes', 'report_mistakes');
add_action('wp_ajax_nopriv_report_mistakes', 'report_mistakes'); 

function report_mistakes(){
	$user_id = get_current_user_id();
	$topic_id = sanitize_text_field($_POST['topicId']);
	$topic_title = get_the_title($topic_id);

	$course_Id = learndash_get_course_id($topic_id);
	$course_title = get_the_title($course_Id);

	$lesson_id = learndash_get_lesson_id($topic_id);
	$lesson_title = get_the_title($lesson_id);
	
	$type = sanitize_text_field($_POST['type']);
	$details = sanitize_text_field($_POST['details']);

	$topic_edit_url = get_site_url() . '/wp-admin/post.php?post=' . $topic_id .'&action=edit';
	$lesson_edit_url = get_site_url() . '/wp-admin/post.php?post=' . $lesson_id .'&action=edit';
	$course_edit_url = get_site_url() . '/wp-admin/post.php?post=' . $course_Id .'&action=edit';

	$to = 'info@goodtogreatschools.org.au';
	$subject = 'Report for Mistakes';
	$message = 'Course Name: <a target="_blank" href="'. $course_edit_url . '">' . $course_title . '</a><br>';
	$message .= 'Lesson Name: <a target="_blank" href="'. $lesson_edit_url . '">' . $lesson_title . '</a><br>';
	$message .= 'Topics Name: <a target="_blank" href="'. $topic_edit_url . '">' . $topic_title . '</a><br>';
	$message .= 'Report Type: ' . $type . '<br>';
	$message .= 'User Message: ' . $details;

	wp_mail($to, $subject, $message);
	echo true;

	die();
}

function sfwd_topic_rating_and_reviews() {
    register_post_meta('sfwd-topic', 'rating_and_reviews', array(
        'type' => 'object', 
        'single' => false,
        'show_in_rest' => true,
    ));
}
add_action('init', 'sfwd_topic_rating_and_reviews');


add_action('wp_ajax_leave_a_rating_for_topic', 'leave_a_rating_for_topic');
add_action('wp_ajax_nopriv_leave_a_rating_for_topic', 'leave_a_rating_for_topic'); 

function leave_a_rating_for_topic(){
	$user_id = get_current_user_id();
	$topic_id = sanitize_text_field($_POST['topicId']);
	$rating = sanitize_text_field($_POST['rating']);
	$feedback = sanitize_text_field($_POST['feedback']);

	$topic_meta = 'rating_and_reviews';

	$rating_counter = get_post_meta( $topic_id, 'rating_counter', true);

	if(!empty($rating_counter)){
		$rating_counter++;
		update_post_meta( $topic_id, 'rating_counter', $rating_counter);
	} else {
		$rating_counter = 1;
		update_post_meta( $topic_id, 'rating_counter', $rating_counter);
	}

	$rating_counter = get_post_meta( $topic_id, 'rating_counter', true);
	$rating_id = $topic_id . $rating_counter;

	$new_review =  array(
		'rating_id' => $rating_id,
		'user_id' => $user_id,
		'user_rating' => $rating,
		'time' => new DateTime(),
		'user_feedback' => $feedback
	);

	$user_reviews = [];
	$existing_review = get_post_meta($topic_id, $topic_meta, true);

	if(empty($existing_review)){
		$user_reviews[] = $new_review;
		update_post_meta($topic_id, $topic_meta, $user_reviews);
		echo 'review added';
	} else {
		$all_review = get_post_meta($topic_id, $topic_meta, true);
		$all_review[] = $new_review;
		update_post_meta($topic_id, $topic_meta, $all_review);
	}
	echo true;
	die();
}

add_action( 'after_setup_theme', 'add_image_size_for_product_range_items' );

function add_image_size_for_product_range_items() {
	add_image_size( 'pro-course-thumb', 140, 80);
	add_image_size( 'course-thumb', 85, 120);
}


add_action('wp_ajax_ggsa_set_tour_complete', 'ggsa_set_tour_complete');
add_action('wp_ajax_nopriv_ggsa_set_tour_complete', 'ggsa_set_tour_complete'); 

function ggsa_set_tour_complete(){
	$user_id = get_current_user_id();
	$page_name = sanitize_text_field($_POST['page_name']);

	if($page_name == 'resources'){
		update_user_meta( $user_id, 'ggsa_product_range_tour', true );
	}
	if($page_name == 'dashboard'){
		update_user_meta( $user_id, 'my_school_box_tour', true );
	}
	if($page_name == 'myLibrary'){
		update_user_meta( $user_id, 'ggsa_my_library_page', true );
	}
	if($page_name == 'topics'){
		update_user_meta( $user_id, 'ggsa_topic_tour_meta', true );
	}
	if($page_name == 'learning'){
		update_user_meta( $user_id, 'ggsa_pl_topic_tour_meta', true );
	}

	echo $page_name;
	die();
}

// register custom post types for fourms
add_action( 'init', 'register_ggsa_peer_forum_post' );

function register_ggsa_peer_forum_post() {
	register_post_type( 'peer-forum',
		array(
			'labels' => array(
				'name' => __( 'Peer Forum', 'Divi' ),
				'singular_name' => __( 'Peer Forum', 'Divi' )
			),
			'public' => true,
			'publicly_queryable' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'peer-forum'),
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		)
	);

	register_taxonomy(
		'topics', 'peer-forum', array(
			'hierarchical' => true,
			'labels'       => array(
				'name'          => __('Courses', 'Divi'),
				'singular_name' => __('Course', 'Divi'),
			),
			'show_ui'      => true,
			'show_admin_column' => true,
			'query_var'    => true,
			'rewrite'      => array('slug' => 'course-topics'),
			'public'
		)
	);

	register_post_meta('peer-forum', 'post_likes', array(
		'type' => 'integer',
		'single' => true,
		'show_in_rest' => true,
	));

}

// register custom post types for fourms
add_action( 'init', 'register_ggsa_staff_forum_post' );

function register_ggsa_staff_forum_post() {
	register_post_type( 'expert-forum',
		array(
			'labels' => array(
				'name' => __( 'Expert Forum', 'Divi' ),
				'singular_name' => __( 'Forum', 'Divi' )
			),
			'public' => true,
			'publicly_queryable' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'expert-forum'),
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		)
	);

	register_taxonomy(
		'question', 'expert-forum', array(
			'hierarchical' => true,
			'labels'       => array(
				'name'          => __('Courses', 'Divi'),
				'singular_name' => __('Course', 'Divi'),
			),
			'show_ui'      => true,
			'show_admin_column' => true,
			'query_var'    => true,
			'rewrite'      => array('slug' => 'course-question'),
			'public'
		)
	);

	register_post_meta('expert-forum', 'post_likes', array(
		'type' => 'integer',
		'single' => true,
		'show_in_rest' => true,
	));
	
}

add_action('wp_ajax_user_enrolled_data_for_forum', 'user_enrolled_data_for_forum');
add_action('wp_ajax_nopriv_user_enrolled_data_for_forum', 'user_enrolled_data_for_forum'); 

function user_enrolled_data_for_forum(){

	// check_ajax_referer( 'like-nonce', 'nonce' );

	$user_enroll_course_ids = learndash_user_get_enrolled_courses(get_current_user_id(), array());

	$user_course_names = [];
	$user_topics_name = [];

	if(!empty($user_enroll_course_ids)){
		foreach($user_enroll_course_ids as $course_id){
			$user_course_names[] = array(
					'id' => $course_id,
					'course_title' => get_the_title($course_id),
			);

			$lessons = learndash_get_lesson_list($course_id);
		
			if(! empty($lessons)){
				foreach($lessons as $lesson){
					$lesson_id = $lesson -> ID;
					// storing all lesson ids to the user lessons array
					$lesson_ids[] = $lesson_id;  
					$found_topics = learndash_get_topic_list($lesson_id, $course_id);
					if(!empty($found_topics)){
						foreach($found_topics as $ut){
							$topic_id = $ut -> ID;
							$user_topics_name[$course_id][] = array(
                                'lesson_id' => $lesson_id,
                                'topic_id' => $topic_id,
                                'topic_name' => get_the_title($topic_id)
                            );
						}
					}
				}
			}
		}
	}

	header('Content-Type: application/json');
	echo json_encode(array('user_course_names' => $user_course_names, 'user_topics_name' => $user_topics_name));
	die();
}

add_action('wp_ajax_user_course_topic_for_forum_tax', 'user_course_topic_for_forum_tax');
add_action('wp_ajax_nopriv_user_course_topic_for_forum_tax', 'user_course_topic_for_forum_tax'); 

function user_course_topic_for_forum_tax(){

	// check_ajax_referer( 'like-nonce', 'nonce' );

	$term_id = isset( $_GET['termId'] ) ? intval( $_GET['termId'] ) : 0;
	$course_id =  get_term_meta($term_id, 'course_id', true);
	$user_topics_name = [];

	$lessons = learndash_get_lesson_list($course_id);

	if(! empty($lessons)){
		foreach($lessons as $lesson){
			$lesson_id = $lesson -> ID;
			// storing all lesson ids to the user lessons array
			$lesson_ids[] = $lesson_id;  
			$found_topics = learndash_get_topic_list($lesson_id, $course_id);
			if(!empty($found_topics)){
				foreach($found_topics as $ut){
					$topic_id = $ut -> ID;
					$user_topics_name[] = array(
						'lesson_id' => $lesson_id,
						'topic_id' => $topic_id,
						'topic_name' => get_the_title($topic_id)
					);
				}
			}
		}
	}

	header('Content-Type: application/json');
	// echo json_encode(array('user_course_names' => $user_course_names, 'user_topics_name' => $user_topics_name));
	echo json_encode($user_topics_name);
	die();
}


add_action('wp_ajax_start_a_discussion_on_peer_forum', 'start_a_discussion_on_peer_forum');
add_action('wp_ajax_nopriv_start_a_discussion_on_peer_forum', 'start_a_discussion_on_peer_forum'); 

function start_a_discussion_on_peer_forum(){
	
	check_ajax_referer( 'like-nonce', 'nonce' );

	$user_id = get_current_user_id();
	$course_id = sanitize_text_field($_POST['courseId']);
	$topic_id = sanitize_text_field($_POST['topicId']);
	$post_title = sanitize_text_field($_POST['title']);
	$post_content = sanitize_text_field($_POST['content']);
	$forum_title = get_the_title($course_id);
	$topic_title = get_the_title( $topic_id );

	$course_parent_category = get_course_parent_term_name_by_course_id($course_id);

	$peer_args = array(
		'post_author' => $user_id,
		'post_title' => $post_title,
		'post_type' => 'peer-forum',
		'post_content' => $post_content,
		'post_status' => 'publish',
		'meta_input' => array(
			'course_id' => $course_id,
			'course_parent_category' => $course_parent_category,
			'topic_id' => $topic_id,
			'topic_title' => $topic_title,
		),
	);

	$peer_id = wp_insert_post($peer_args);

	if ( ! is_wp_error( $peer_id ) && $peer_id > 0 ) {

		$add_to_term_id = wp_set_object_terms($peer_id, $forum_title, 'topics');

		if (!is_wp_error($add_to_term_id)) {
			$term_id_for_new_peer_post = get_term_by( 'name', $forum_title, 'topics');
			$term_id = $term_id_for_new_peer_post -> term_id;
			update_term_meta( $term_id, 'course_id', $course_id);
			update_post_meta($course_id, 'has_peer_conversations', $term_id );
		}
		
		// update_post_meta($topic_id, 'has_peer_conversations', true);

		saved_peer_and_expert_post_ids_for_my_chats($peer_id);
		
		echo 'Topic created with new forums';

	}

	die();
}

add_action('wp_ajax_start_a_question_on_expert_forum', 'start_a_question_on_expert_forum');
add_action('wp_ajax_nopriv_start_a_question_on_expert_forum', 'start_a_question_on_expert_forum'); 

function start_a_question_on_expert_forum(){
	
	check_ajax_referer( 'like-nonce', 'nonce' );

	$user_id = get_current_user_id();
	$course_id = sanitize_text_field($_POST['courseId']);
	$post_content = sanitize_text_field($_POST['content']);
	$forum_title = get_the_title($course_id);

	$course_parent_category = get_course_parent_term_name_by_course_id($course_id);

	$forum_question = array(
		'post_author' => $user_id,
		'post_title' => $forum_title,
		'post_type' => 'expert-forum',
		'post_content' => $post_content,
		'post_status' => 'publish',
		'meta_input' => array(
			'course_id' => $course_id, 
			'course_parent_category' => $course_parent_category,
		),
	);

	$new_ques_id = wp_insert_post($forum_question);

	if ( ! is_wp_error( $new_ques_id ) && $new_ques_id > 0 ) {

		$new_ques_term_id = wp_set_object_terms($new_ques_id, $forum_title, 'question');

		if (!is_wp_error($new_ques_term_id)) {
			$term_id_for_new_expert_post = get_term_by( 'name', $forum_title, 'question');
			$term_id = $term_id_for_new_expert_post -> term_id;
			update_term_meta($term_id, 'course_id', $course_id);
			update_post_meta($course_id, 'has_expert_conversation', $term_id);
		}

		saved_peer_and_expert_post_ids_for_my_chats($new_ques_id);
		// update_post_meta($forum_id, 'total_questions', 1);
		echo true;

	}

	die();
}

function saved_peer_and_expert_post_ids_for_my_chats($post_id){

	$user_id = get_current_user_id();
	$existing_saved_disscussion = get_user_meta( $user_id,'saved_topic_and_question', true);

	if(empty($existing_saved_disscussion)){
		$new_save_disscussion = [];
		$new_save_disscussion[] = $post_id;
		update_user_meta( $user_id, 'saved_topic_and_question', $new_save_disscussion);
	} else {
		$existing_saved_disscussion[] = $post_id;
		update_user_meta( $user_id, 'saved_topic_and_question', $existing_saved_disscussion);
	}
}


add_action('wp_ajax_self_user_save_disscussion', 'self_user_save_disscussion');
add_action('wp_ajax_nopriv_self_user_save_disscussion', 'self_user_save_disscussion'); 

function self_user_save_disscussion(){
	
	check_ajax_referer( 'like-nonce', 'nonce' );

	$user_id = get_current_user_id();
	$post_number = sanitize_text_field($_POST['postNumber']);
	preg_match('/\d+/', $post_number, $matches);
	$post_id = $matches[0];

	$post_saved_meta = 'user-saved-'. $post_id;

	if(get_user_meta($user_id, $post_saved_meta, true) == true){
		update_user_meta( $user_id, $post_saved_meta, false );

		$existing_saved_disscussion = get_user_meta( $user_id,'saved_topic_and_question', true);
		$search_input = array_search($post_id, $existing_saved_disscussion);
		if($search_input !== false){
			unset($existing_saved_disscussion[$search_input]);
			update_user_meta( $user_id, 'saved_topic_and_question', $existing_saved_disscussion);
		}
		echo 'remove';
	} else {

		update_user_meta( $user_id, $post_saved_meta, true );

		saved_peer_and_expert_post_ids_for_my_chats($post_id);
		
		echo 'saved';
	}

	die();
}

add_action('wp_ajax_report_topics_and_questions', 'report_topics_and_questions');
add_action('wp_ajax_nopriv_report_topics_and_questions', 'report_topics_and_questions'); 

function report_topics_and_questions(){

	check_ajax_referer( 'like-nonce', 'nonce' );

	$user_id = get_current_user_id();
	$post_number = sanitize_text_field($_POST['postNumber']);
	$spam_type = sanitize_text_field($_POST['spamType']);
	$issue_details = sanitize_text_field($_POST['issueDetails']);

	preg_match('/\d+/', $post_number, $matches);
	$post_id = $matches[0];

	$to = 'info@goodtogreatschools.org.au';
	$subject = 'School Forum has Spam Post';
	$content = '<p>Spam Post ID: ' . $post_id . '</p>';
	$content .= '<p>Spam Type: ' . $spam_type . '</p>';
	$content .= '<p>Issue Details: ' . $issue_details . '</p>';
	$content .= '<p>Reported By: ' . $user_id . '</p>';
	$content .= '<p>Reported At: ' . date('Y-m-d H:i:s') . '</p>';

	wp_mail($to, $subject, $content);
	echo true;
	die();
}

add_action('wp_ajax_post_likes_action', 'post_likes_action');
add_action('wp_ajax_nopriv_post_likes_action', 'post_likes_action'); 

function post_likes_action(){

	check_ajax_referer( 'like-nonce', 'nonce' );

	$user_id = get_current_user_id();
	$post_number = sanitize_text_field($_POST['postId']);

	preg_match('/\d+/', $post_number, $matches);
	$post_id = $matches[0];

	$likes_count = get_post_meta($post_id, 'post_likes', true);
	$user_post_like_meta = 'user-liked-' . $post_id;
	
	if(get_user_meta($user_id, $user_post_like_meta, true) == true){
		$likes_count--;
		update_post_meta($post_id, 'post_likes', $likes_count);
		update_user_meta($user_id, $user_post_like_meta, false);
		// echo 'unlike';
		echo $likes_count;
	} else {
		$likes_count++;
		update_post_meta($post_id, 'post_likes', $likes_count);
		update_user_meta($user_id, $user_post_like_meta, true);
		// echo 'like';
		echo $likes_count;
	}
	
	die();
}

function custom_taxonomy_archive_posts_per_page($query) {
    if (is_tax('question') && $query->is_main_query()) {
        $query->set('posts_per_page', 2); // Adjust the number of posts per page as needed
    }
}
add_action('pre_get_posts', 'custom_taxonomy_archive_posts_per_page');

function calculate_date_and_time_for_post($post_time){

	// Get the current date and time
	$currentDateTime = new DateTime();

	$interval = $currentDateTime->diff(new DateTime($post_time));
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

	return $review_time;

}

function expert_forum_questions_template_item($post_id, $counter = 0){

	$taxonomy = 'question';
	$authod_id = get_post_field('post_author', $post_id);
	$user_avatar = get_user_meta($authod_id, 'user_avatar_url', true);
	$post_time = get_the_date('Y-m-d H:i:s',$post_id);

	$parent_category_name = get_post_meta($post_id, 'course_parent_category', true);

	$post_terms = get_the_terms($post_id, $taxonomy );
	if($post_terms && ! is_wp_error($post_terms)){
		$term_name = $post_terms[0] -> name;
		$term_slug = get_term_link($post_terms[0]);
	}

	$current_user_id = get_current_user_id();
	$current_user_data = get_userdata($current_user_id);
	$current_user_roles = $current_user_data -> roles;
	?>
	<div class="question-card rounded-3 border-1 border mt-3">
		<div class="question-top p-2 border-0 d-flex gap-2 mb-2 bg-[#EBF9FD]">
			<span class="status rounded-2 bg-[#FFE8DB] px-2 text-[#E52E2E]">New</span>
			<?php
			if($parent_category_name){
				echo '<span class="category rounded-2 px-2 bg-[#E1EEFF] text-[#1B61F9]">'. $parent_category_name . '</span>';
			}
			?>
			<span class="course rounded-2 px-2 bg-[#EDFDDC] text-[#1A8319]"><a href="<?= $term_slug;?>"><?= $term_name?></a></span>
		</div>
		<div class="question-body px-3">
			<div class="creator d-flex gap-2 items-center">
				<?php
				if ($user_avatar == "") {
					echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
				} else {
					echo '<img alt="" src="' . $user_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
				}
				?>
				<div class="creator-info">
					<p class="creator-name fw-bold m-0 p-0"><?php the_author();?></p>
					<p class="creator-date position-relative m-0"><?=  calculate_date_and_time_for_post($post_time);;?></p>
				</div>
			</div>
			<div class="question-info my-3 pb-3 border-bottom">
				<div class="desc text-[#4D4F4E] text-start">
					<?= the_content();?>
				</div>
			</div>
			<div class="question-bottom pb-3 d-flex justify-content-between items-center">
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
					Like <span class="number"><?= $like_count;?></span>
					</button> 

					<button id="<?php echo 'fourm-answer-' . $post_id;?>" class="qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">
					Answer
					<span class="comment-count"><?php echo get_comments_number($post_id)?></span>
					</button>
					<!-- href="<?php //  the_permalink();?>" -->
					<?php
					if($authod_id != get_current_user_id()){ ?>
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
						<img src="<?php echo get_stylesheet_directory_uri() . $img_url;?>" alt="save questions" srcset="">Save Question						
						</button> 
						<button id="<?php echo 'spam-' . $post_id;?>" class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
					<?php } else { ?>
						<button id="<?php echo 'forum-delete-' . $post_id;?>" class="delete-forum d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center">
						<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/trash.svg';?>" alt="save questions" srcset="">Delete			
						</button> 
						<div class="delete-confirmation d-flex gap-1 border-1 rounded-3 px-2 py-0 border align-items-center d-none">
							<button id="<?= 'yes-' . $post_id;?>" class="yes">Yes</button>
							<button id="<?= 'no-' . $post_id;?>" class="no">No</button>	
						</div>
						<?php
						}
					?>
				</div>
			</div>
			<div class="question-answers <?= ($counter == 1)? '' : 'd-none';?>">
				<div class="heading d-flex position-relative flex-row items-center justify-content-start gap-2">
					<div class="heading-name text-[#0090a1]">Answers</div>
					<div class="borders flex-1 border-top border-1 position-relative">
					</div>
				</div>
				<?php
				$get_comment_number = get_comments_number($post_id);

				if(in_array('ggsa_staff', $current_user_roles)){ 
				?>
				<form id="<?= $post_id?>" class="parent-answer needs-validation">
					<div class="answer mb-3">
						<div class="add-answer my-3">
							<div class="d-flex gap-3">
								<div class="user-img">
									<?php echo get_user_avatar($current_user_id);?>
								</div>
								<div class="answer-text flex-1">
									<input type="text" id="<?= 'answer-text-' . $post_id;?>" class="form-control w-100 px-2" placeholder="Add your answers" required>
								</div>
							</div>
							<div class="add-answer text-end mt-2">
								<button type="submit" class="submit-answer btn btn-primary">Answer</button>
							</div>
						</div>
					</div>
				</form>
				<?php
				} elseif ($get_comment_number == 0){
					echo '<div class="py-2">Only GGSA Staff can answer</div>';
				} 

				global $wpdb;
				$query = $wpdb->prepare("
				SELECT user_id AS comment_author_id, comment_content, comment_date
				FROM {$wpdb->comments}
				WHERE comment_post_ID = %d
				AND comment_approved = 1
				ORDER BY comment_date DESC
				LIMIT 1
				", $post_id);

				$latest_comment = $wpdb->get_row($query);

				if ($latest_comment) {
					$comment_author_id = $latest_comment -> comment_author_id;
					?>
					<div class="question-responses mb-3">
						<div class="view-resnponse my-3 d-flex gap-3">
							<div class="user-img">
								<?php echo get_user_avatar($comment_author_id);?>
							</div>
							<div class="view-resnponse-info flex-1 text-start">
								<div class="responde-by d-flex justify-content-between">
									<div class="info gap-2 d-flex items-center">
										<span class="fw-bold text-[#161c24]"><?= get_user_name($comment_author_id);?></span>
										<span class="level px-3 py-1 bg-[#e1eeff] rounded-3">Expert</span>
									</div>
									<div class="time">
										<span class="text-[#4d4f4e]"><?= calculate_date_and_time_for_post($latest_comment -> comment_date);;?></span>
									</div>
								</div>
								<p class="response-text"><?= $latest_comment -> comment_content ;?></p>
							</div>
						</div>
					</div>
					<?php
				}
				
				if($get_comment_number && $get_comment_number >= 2){
					$comment_count = $get_comment_number - 1;
					 ?>
					<div class="more-response mb-3 pointer-event text-start">
						<a href="<?= get_the_permalink($post_id);?>" class="fw-bold text-[#faa332]"><?= $comment_count;?> more response</a>
					</div>
				<?php
				} 
				?>
			</div>
		</div>
	</div>
	<?php
}

function get_course_parent_term_name_by_course_id($course_id){

	$course_terms = get_the_terms( $course_id, 'ld_course_category' );

	$course_term_id = '0';
	if ( ! empty( $course_terms ) && ! is_wp_error( $course_terms ) ){
		foreach($course_terms as $term){
			$course_term_id = $term -> term_id;
			break;
		}
	}

	$taxonomy_terms = get_term_by( 'id', $course_term_id, 'ld_course_category');
	$ancestor_ids = get_ancestors($taxonomy_terms->term_id, 'ld_course_category');
	// Check if there are ancestors
    if (!empty($ancestor_ids)) {
        $top_ancestor_id = end($ancestor_ids);
        // Get the term object for the top-level ancestor
        $top_ancestor = get_term($top_ancestor_id, 'ld_course_category');

        return $top_ancestor->name;
    }
}

function peer_forum_topics_template_item($post_id, $counter = 0){
	$taxonomy = 'topics';
	$authod_id = get_post_field('post_author', get_the_id());
	$user_avatar = get_user_meta($authod_id, 'user_avatar_url', true);
	$post_time = get_the_date('Y-m-d H:i:s',get_the_ID());
	
	$post_terms = get_the_terms($post_id, $taxonomy );

	$course_id = get_post_meta($post_id, 'course_id', true);
	$topic_title = get_post_meta($post_id, 'topic_title', true);
	$parent_category_name = get_post_meta($post_id, 'course_parent_category', true);

	if($post_terms && ! is_wp_error($post_terms)){
		$term_name = $post_terms[0] -> name;
		$term_slug = get_term_link($post_terms[0]);
	}
?>
	<div class="forum-card p-3 rounded-3 border border-1 mt-3">
		<div class="forem-top d-flex gap-2">
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
		<div class="forem-body my-3 pb-3 mb-3 border-bottom text-start">
			<h2 class="fw-bold fs-4 text-[#4D4F4E] mb-2"><?= the_title();?></h2>
			<div class="desc text-[#4D4F4E]">
				<?= the_content();?>
			</div>
		</div>
		<div class="forum-bottom d-flex justify-content-between items-center">
			<div class="bottom-action d-flex gap-2">
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

				<a href="<?php the_permalink();?>" id="<?php echo 'fourm-comment-' . $post_id;?>" class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count"><?php echo get_comments_number($post_id)?></span>
				</a>

				<?php 
				if($authod_id != get_current_user_id()){ ?>

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

				<?php } ?>

				
				<button id="<?php echo 'spam-' . $post_id;?>" class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
			</div>
			<div class="creator-info d-flex gap-2 items-center">
				<?php
				if ($user_avatar == "") {
					echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
				} else {
					echo '<img alt="" src="' . $user_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
				}
				?>
				<p class="creator-name fw-bold m-0 p-0"><?php the_author();?></p>
				<p class="creator-time ms-2 position-relative m-0"><?=  calculate_date_and_time_for_post($post_time);;?></p>
			</div>
		</div>
	</div>
<?php
}

function comment_question_replies_as_comment($comment, $args, $depth){
	$author_id = $comment -> user_id;
	$author_data = get_userdata($author_id);
	// $author_name = $author_data -> display_name;
	$comment_content = $comment -> comment_content;
	$comment_date = $comment -> comment_date;
	$comment_id =$comment -> comment_ID;
	$children = $comment -> get_children();
	$user_avatar = get_user_meta($author_id, 'user_avatar_url', true);	

	echo '<div class="comment">';
    echo '<p>' . $comment_content . '</p>';
    echo '</div>';
	
}

function single_forum_replies($comment, $args, $depth){ 

	$current_user_data = get_userdata(get_current_user_id());
	$current_user_roles = $current_user_data->roles;
	$author_id = $comment -> user_id;
	$author_data = get_userdata($author_id);
	$author_name = $author_data -> display_name;;
	$comment_content = $comment -> comment_content;
	$comment_date = $comment -> comment_date;
	$comment_id =$comment -> comment_ID;
	$children = $comment -> get_children();
	$user_avatar = get_user_meta($author_id, 'user_avatar_url', true);	
	$author_roles = $author_data -> roles;
		
	$total_reply = count($children);
	if(empty($total_reply)){
		$total_reply = '';
	}	

	$current_user_id = get_current_user_id();
	$user_data = get_userdata($current_user_id);	
	$current_user_display_name = $user_data -> display_name;
	$current_user_avatar = get_user_meta($current_user_id, 'user_avatar_url', true);

	$placeholder = 'Add your comment';
	$btn_text = 'Comment';
	if('expert-forum' == get_post_type(get_the_ID())){
		$placeholder = 'Add your answers';
		$btn_text = 'Answer';
	}
	
	
	?>

	<div class="top-resnpons mb-3">
		<div class="res-info top-res d-flex gap-3">
			<div class="user-img">
				<?php
					if ($user_avatar == "") {
						echo '<img alt="'. $author_name .'" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
					} else {
						echo '<img alt="'. $author_name .'" src="' . $user_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
					}
				?>
			</div>
			<div class="view-resnponse-info flex-1">
				<div class="responde-by d-flex justify-content-between">
					<div class="info gap-2 d-flex items-center">
						<span class="fw-bold text-[#161c24]"><?= $author_name;?></span>
						<?php if(in_array('ggsa_staff',$author_roles)){ ?>
							<span class="level px-3 py-1 bg-[#e1eeff] rounded-3">Expert</span>
						<?php
						}
						?>
					</div>
					<div class="time">
						<span class="text-[#4d4f4e]"><?= calculate_date_and_time_for_post($comment_date);?></span>
					</div>
				</div>
				<p class="response-text">
					<?php echo wpautop( esc_html( $comment_content ) );?>
				</p>
				<div class="top-res-action d-flex gap-2 my-2" id="<?php echo 'action-' . $comment_id; ?>">

					<button id="<?php echo $comment_id;?>" class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like">

					<?php
						$like_count = get_comment_meta($comment_id, 'likes_count', true);
						if($like_count == 0){
							$like_count = '';
						}
						$user_comment_meta = 'comment-' . $comment_id;
						if(get_user_meta(get_current_user_id(), $user_comment_meta, true) == true){
							$img_url = '/assets/svg/unlike.svg';
						} else {
							$img_url = '/assets/svg/like.svg';
						}
					?>
					<img src="<?php echo get_stylesheet_directory_uri() . $img_url;?>">
					Like <span class="number"><?php echo $like_count;?></span>
					</button>    

					<button class="top-res-com d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset=""><?= $btn_text;?><span class="comment-count"><?= $total_reply;?></span>
					</button>
					<button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
				</div>
				<div class="top-res-reply d-none">
					<!--INNER COMMENT LOOP-->
					<?php
					if($comment -> get_children()){ 
						foreach($children as $reply){
							// var_dump($reply);
							$child_author_id = $reply -> user_id;
							$child_user_data = get_userdata($child_author_id);
							$child_author_name = $child_user_data -> display_name;
							$child_comment_content = $reply -> comment_content;
							$child_comment_id = $reply -> comment_ID;
							$child_date = $reply -> comment_date;
							$child_avatar = get_user_meta($child_author_id, 'user_avatar_url', true);
							$child_author_roles = $child_user_data -> roles;
							
							?>
							<div class="second-res d-flex gap-3">
								<div class="user-img">
									<?php
										if ($child_avatar == "") {
											echo '<img alt="'. $child_author_name .'" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
										} else {
											echo '<img alt="'. $child_author_name .'" src="' . $child_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
										}
									?>
								</div>
								<div class="view-top-info flex-1">
									<div class="responde-by d-flex justify-content-between">
										<div class="info gap-2 d-flex items-center">
											<span class="fw-bold text-[#161c24]"><?= $child_author_name;?></span>
											<?php if(in_array('ggsa_staff',$child_author_roles)){ ?>
												<span class="level px-3 py-1 bg-[#e1eeff] rounded-3">Expert</span>
											<?php
											}
											?>
										</div>
										<div class="time">
											<span class="text-[#4d4f4e]"><?= calculate_date_and_time_for_post($child_date);?></span>
										</div>
									</div>
									<p class="response-text"><?= $child_comment_content; ?></p>
									<div class="res-action d-flex gap-2 mt-2" id="<?= $child_comment_id; ?>">
										<button id="<?php echo $child_comment_id?>" class="d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center com-res-like">
										<?php
											$like_count = get_comment_meta($child_comment_id, 'likes_count', true);
											if($like_count == 0){
												$like_count = '';
											}
											$user_comment_meta = 'comment-' . $child_comment_id;
											if(get_user_meta(get_current_user_id(), $user_comment_meta, true) == true){
												$img_url = '/assets/svg/unlike.svg';
											} else {
												$img_url = '/assets/svg/like.svg';
											}
										?>
										<img src="<?php echo get_stylesheet_directory_uri() . $img_url;?>">
										Like <span class="number"><?php echo $like_count;?></span>
										</button>    
										<!-- <button class="curr-qus-ans d-flex gap-1 border-1 rounded-3 px-2 py-1 border align-items-center"> -->
											<!-- <img src="<?php // echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="comment" srcset="">Comment <span class="comment-count">2</span> -->
										<!-- </button> -->
										<button class="reportBtn d-flex gap-1 py-1 border-1 rounded-3 px-2 border align-items-center" data-bs-toggle="modal" data-bs-target="#report-161043"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/report.svg';?>" alt="Report spam" srcset="">Report Spam</button>
									</div>
								</div>
							</div>
						<?php
						}
					}	
					if('expert-forum' == get_post_type()){
						if(in_array('ggsa_staff', $current_user_roles)){ ?>
							<!--ADD COMMENT FOR SUB COMMENT-->
							<form id="<?php echo $comment_id; ?>" class="needs-validation comment-reply">
								<div class="top-res-ans mb-3">
									<div class="add-answer my-3 d-flex gap-3">
										<div class="user-img">
												<?php
													if ($current_user_avatar == "") {
														echo '<img alt="'. $current_user_display_name .'" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
													} else {
														echo '<img alt="'. $current_user_display_name .'" src="' . $current_user_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
													}
												?>
										</div>
										<div class="reply-text flex-1">
											<input type="text" id="<?php echo 'reply-text-' . $comment_id;?>" class="form-control w-100" placeholder="<?= $placeholder;?>" required>
											<input type="hidden" id="<?php echo 'post-'. $comment_id;?>" value="<?php echo get_the_ID();?>">
										</div>
									</div>
									<div class="add-answer text-end">
										<button type="submit" class="btn btn-primary">Reply</button>
									</div>
								</div>	
							</form>
						<?php
						}
					} else { ?>
						<!--ADD COMMENT FOR SUB COMMENT-->
						<form id="<?php echo $comment_id; ?>" class="needs-validation comment-reply">
							<div class="top-res-ans mb-3">
								<div class="add-answer my-3 d-flex gap-3">
									<div class="user-img">
											<?php
												if ($current_user_avatar == "") {
													echo '<img alt="'. $current_user_display_name .'" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
												} else {
													echo '<img alt="'. $current_user_display_name .'" src="' . $current_user_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
												}
											?>
									</div>
									<div class="reply-text flex-1">
										<input type="text" id="<?php echo 'reply-text-' . $comment_id;?>" class="form-control w-100" placeholder="<?= $placeholder;?>" required>
										<input type="hidden" id="<?php echo 'post-'. $comment_id;?>" value="<?php echo get_the_ID();?>">
									</div>
								</div>
								<div class="add-answer text-end">
									<button type="submit" class="btn btn-primary">Reply</button>
								</div>
							</div>	
						</form>
					<?php
					}
				?>
				</div>
			</div>
		</div>	
	</div>
<?php
}


add_action('wp_ajax_add_discussion_comment_reply', 'add_discussion_comment_reply');
add_action('wp_ajax_nopriv_add_discussion_comment_reply', 'add_discussion_comment_reply'); 

function add_discussion_comment_reply(){

	// check_ajax_referer('ajax_nonce', 'nonce');

	$post_id = sanitize_text_field($_POST['post_id']);
	$comment_parent = sanitize_text_field($_POST['parent_id']);
    $comment_content = sanitize_text_field($_POST['reply_text']);

	$commentdata = array(
        'comment_post_ID' => $post_id, // Adjust based on your post ID
        'user_id' => get_current_user_id(),
        'comment_content' => $comment_content,
        'comment_parent' => $comment_parent,
    );
	$comment_id = wp_insert_comment($commentdata);

    if ($comment_id) {
		add_comment_post_id_to_user_meta($post_id);
        echo 'Reply submitted successfully!';
    } else {
        echo 'Error submitting reply.';
    }

	die();
}


add_action('wp_ajax_add_discussion_parent_comment', 'add_discussion_parent_comment');
add_action('wp_ajax_nopriv_add_discussion_parent_comment', 'add_discussion_parent_comment'); 

function add_discussion_parent_comment(){

	// check_ajax_referer('ajax_nonce', 'nonce');
	
	$post_id = sanitize_text_field($_POST['postId']);
    $comment_content = wp_kses_post($_POST['commentText']);

	$commentdata = array(
        'comment_post_ID' => $post_id, // Adjust based on your post ID
        'user_id' => get_current_user_id(),
        'comment_content' => $comment_content,
    );

	$comment_id = wp_insert_comment($commentdata);

    if ($comment_id) {
		add_comment_post_id_to_user_meta($post_id);
        echo 'Reply submitted successfully!';
    } else {
        echo 'Error submitting reply.';
    }

	die();
}

function add_comment_post_id_to_user_meta($post_id){

	$user_id = get_current_user_id();

	$meta_key = 'commented_post_ids';
	$existing_forums = get_user_meta( $user_id, $meta_key, true);

	if($existing_forums){
		if(!in_array($post_id, $existing_forums)){
			$existing_forums[] = $post_id;
			update_user_meta( $user_id, $meta_key, $existing_forums);
		}
	} else {
		$your_forums = [];
		$your_forums[] = $post_id;
		update_user_meta( $user_id, $meta_key, $your_forums);
	}
}


add_action('wp_ajax_comment_reply_like_count', 'comment_reply_like_count');
add_action('wp_ajax_nopriv_comment_reply_like_count', 'comment_reply_like_count'); 

function comment_reply_like_count(){

	// check_ajax_referer( 'like-nonce', 'nonce' );

	$user_id = get_current_user_id();
	$comment_id = sanitize_text_field($_POST['commentId']);

	$likes_count = get_comment_meta($comment_id, 'likes_count', true);
	$user_comment_meta = 'comment-' . $comment_id;
	
	if(get_user_meta($user_id, $user_comment_meta, true) == true){
		$likes_count--;
		update_comment_meta($comment_id, 'likes_count', $likes_count);
		update_user_meta($user_id, $user_comment_meta, false);
		// echo 'unlike';
		echo $likes_count;
	} else {
		$likes_count++;
		update_comment_meta($comment_id, 'likes_count', $likes_count);
		update_user_meta($user_id, $user_comment_meta, true);
		// echo 'like';
		echo $likes_count;
	}

	die();
}


if(! function_exists('get_user_name')){
	function get_user_name($user_id ){
  
		$user_data = get_userdata($user_id);
		$username = $user_data->user_login;
		$first_name = get_user_meta($user_id, 'first_name', true);
		$last_name = get_user_meta($user_id, 'last_name', true);
	  
		if ($first_name || $last_name) {
			$name = $first_name . ' ' . $last_name;
		} else {
			$name = $username;
		}
		return $name ;
	  
	  }
}

function all_school_top_contributors(){

	global $wpdb;

	$table_name = $wpdb->prefix . 'comments';

	$max_count_query = "SELECT COUNT(comment_ID) as max_count, user_id FROM ". $table_name ." WHERE comment_approved = 1 GROUP BY user_id ORDER BY max_count DESC LIMIT 5";
	$max_count_results = $wpdb->get_results($max_count_query);

	if(! empty($max_count_results)){
		$counter = 0;
		foreach($max_count_results as $result){
			$counter++;
			$user_id = $result -> user_id;
			$user_data = get_userdata($user_id);
			$user_avatar = get_user_meta($user_id, 'user_avatar_url', true);
			$name = get_user_name($user_id);

			$max_count = $result -> max_count; ?>

			<!--Top Contributors items Start-->
			<div class="contributors d-flex items-center gap-2 mb-2 overflow-hidden justify-content-between">
				<div class="rank">
					<h2 class="fs-5 fw-bold text-[#00859C] p-0 m-0"><?= $counter;?></h2>
				</div>
				<div class="user d-flex items-center gap-2">
					<div class="user-img">
					<?php
						if ($user_avatar == "") {
							echo '<img alt="'. $name . '" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle" decoding="async">';
						} else {
							echo '<img alt="'. $name . '" src="' . $user_avatar . '" class="rounded-circle" decoding="async">';
						}
					?>
					</div>
					<div class="user-name overflow-hidden">
						<h2 class="fs-5 text-truncate fw-bold text-[#4D4F4E] p-0 m-0"><?= $name;?></h2>
					</div>
				</div>
				<div class="contributes-count d-flex w-100">
					<img width="16px" height="16px" class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="" srcset="">
					<span class="text-[#7A7B7A]"><?= $max_count?></span>
				</div>
			</div>
			<!--Top Contributors items End-->
			<?php
		}
	} else {
		echo 'No Contributors Found';
	}
}

function my_school_top_contributors(){

	$my_school_member = get_user_in_team(get_current_user_id());
	$my_school_member_string = implode(',', $my_school_member);

	global $wpdb;

	$table_name = $wpdb->prefix . 'comments';

	$max_count_query = "SELECT COUNT(comment_ID) as max_count, user_id FROM ". $table_name ." WHERE comment_approved = 1 AND user_id IN (" . $my_school_member_string . ") GROUP BY user_id ORDER BY max_count DESC LIMIT 5";
	$max_count_results = $wpdb->get_results($max_count_query);

	if(!empty($max_count_results)){
		$counter = 0;
		foreach($max_count_results as $result){
			$counter++;
			$user_id = $result -> user_id;
			$user_data = get_userdata($user_id);
			$user_avatar = get_user_meta($user_id, 'user_avatar_url', true);
			$name = get_user_name($user_id);

			$max_count = $result -> max_count; ?>

			<!--Top Contributors items Start-->
			<div class="contributors d-flex items-center gap-2 mb-2 overflow-hidden justify-content-between">
				<div class="rank">
					<h2 class="fs-5 fw-bold text-[#00859C] p-0 m-0"><?= $counter;?></h2>
				</div>
				<div class="user d-flex items-center gap-2">
					<div class="user-img">
					<?php
						if ($user_avatar == "") {
							echo '<img alt="'. $name . '" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle" decoding="async">';
						} else {
							echo '<img alt="'. $name . '" src="' . $user_avatar . '" class="rounded-circle" decoding="async">';
						}
					?>
					</div>
					<div class="user-name overflow-hidden">
						<h2 class="fs-5 text-truncate fw-bold text-[#4D4F4E] p-0 m-0"><?= $name;?></h2>
					</div>
				</div>
				<div class="contributes-count d-flex w-100">
					<img width="16px" height="16px" class="mr-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/comment.svg';?>" alt="" srcset="">
					<span class="text-[#7A7B7A]"><?= $max_count?></span>
				</div>
			</div>
			<!--Top Contributors items End-->
			<?php
		}
	} else {
		echo 'No Contributors Found';
	}
}

add_action('wp_ajax_search_topic_and_question_across_term', 'search_topic_and_question_across_term');
add_action('wp_ajax_nopriv_search_topic_and_question_across_term', 'search_topic_and_question_across_term'); 

function search_topic_and_question_across_term(){

	$keyword = sanitize_text_field($_POST['search_val']);
	
	$peer_term = get_terms(array(
		'taxonomy' => 'topics',
		'hide_empty' => true,
	));
	
	$expert_term = get_terms(array(
		'taxonomy' => 'question',
		'hide_empty' => true,
	));
	
	$all_terms = array_merge($peer_term, $expert_term);

	$q = strtolower($keyword);
	
	$found_peer_terms = [];
	$found_expert_terms = [];
	
	foreach($all_terms as $term){
		$term_name = $term->name;
		$term_id = $term->term_id;
		$term_taxonomy = $term->taxonomy;
	
		if (stristr($term_name, $q)) {
			if($term_taxonomy == 'topics'){
				$found_peer_terms[] = array(
					'term_name' => $term_name,
					'term_id' => $term_id,
				);
			}else{
				$found_expert_terms[] = array(
					'term_name' => $term_name,
					'term_id' => $term_id
				);
			}
		}
	}

	show_availble_forum_for_topics_and_question($found_peer_terms, $found_expert_terms, $keyword);
	die();
}


function show_availble_forum_for_topics_and_question($peer_args, $exper_args, $keyword){
	$count = count($peer_args);
	$count += count($exper_args);
	?>
	<div class="forum-container">
		<div class="d-flex mb-2" id="suggestion-header">
			<h6 class="suggestion-quantity" style="font-weight: 700"><?= $count;?> Forum found for <?= $keyword;?></h6>
		</div>
		<div class="d-flex flex-row align-items-center" id="pills-forum-results" role="tablist">
			<div style="color:#f6f6f6;" class="position-relative tab-image nav-link w-100 active" id="peer-tab" data-bs-toggle="tab" href="#peer" aria-controls="peer" aria-selected="false" role="tab" tabindex="-1">
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
					max-width: 100%;
					white-space: nowrap;
					overflow: hidden;
					" class="tab-text">Peer Forum</p>
				</div>
			</div>
			<div style="color:#f6f6f6; <?php echo $order;?>" class="position-relative tab-image nav-link w-100" id="expert-tab" data-bs-toggle="tab" href="#expert" aria-controls="expert" aria-selected="false" role="tab" tabindex="-1">
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
					max-width: 100%;
					white-space: nowrap;
					overflow: hidden;
					" class="tab-text">Expert Forum</p>
				</div>
			</div>
		</div>
		<div class="tab-content" id="pills-forum-results">
		<?php
			?>
			<div class="tab-pane fade show active" id="peer" role="tabpanel" aria-labelledby="library-1-tab">
				<div class="peer-list">
					<?php
					if(!empty($peer_args)){
						foreach($peer_args as $terms){
							$name = $terms['term_name'];
							$term_id = $terms['term_id'];
							$term_link = get_term_link($term_id, 'topics');
							echo '<a href="'. $term_link .'">' . $name .'</a><br>';
						}
					} else {
						echo 'no peer forums found';
					}
					?>
				</div>
			</div>
			<div class="tab-pane fade" id="expert" role="tabpanel" aria-labelledby="library-2-tab">
				<div class="expert-course">
				<?php
				if(!empty($exper_args)){
					foreach($exper_args as $terms){
						$name = $terms['term_name'];
						$term_id = $terms['term_id'];
						$term_link = get_term_link($term_id, 'question');
						echo '<a href="'. $term_link .'">' . $name .'</a><br>';
					}
				} else {
					echo 'no forum founds';
				}
				?>
				</div>
			</div>
		</div>  
	</div>  
<?php
}

function custom_query_vars( $vars ) {
    $vars[] = 'peer';
    $vars[] = 'expert';
    return $vars;
}
add_filter( 'query_vars', 'custom_query_vars' );

if(! function_exists('get_user_avatar_for_topic')){

function get_user_avatar_for_topic($user_id){
	$user_avatar = get_user_meta($user_id, 'user_avatar_url', true);
	$user_data = get_userdata($user_id);
	if ($user_avatar == "") {
  
		$ava_img = '<img width="24px" height="24px" class="rounded-circle border-1 border-white" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" decoding="async"  alt="'. $user_data-> display_name . '">';
	} else {
  
		$ava_img = '<img width="24px" height="24px" class="rounded-circle border-1 border-white" src="' . $user_avatar . '" decoding="async" alt="'. $user_data-> display_name . '">';
	}
	return $ava_img;
  }
}

if(! function_exists('get_enrolled_course_user_avater_for_current_forum')){
	function get_enrolled_course_user_avater_for_current_forum($course_id = 0){
                                    
		global $wpdb;

		$table_name = $wpdb->prefix . 'learndash_user_activity';
	   
		?>
		<div class="d-flex gap-4 justify-content-start forums-contributors">
			<div class="all-member position-relative  items-center d-flex gap-3">
				<h4 class="text-[#7a7b7a] fs-6 p-0 m-0">All Members</h4>
				<div class="user-img d-flex">
				<?php

					$all_enrolled_users_of_this_course = $wpdb->get_results( 
						$wpdb->prepare( 
							"SELECT DISTINCT user_id FROM {$table_name} WHERE course_id = %d", 
							$course_id 
						) 
					);

					$remaining_count = count($all_enrolled_users_of_this_course) - 5;

					$all_count = 0;
					foreach ( $all_enrolled_users_of_this_course as $result ) {
						$all_count++;
						$user_id = $result->user_id;
						if($all_count < 6){
							echo get_user_avatar_for_topic($user_id);
						} else { ?>
							<span style="margin-left: -6px; width: 24px; height: 24px" class="text-center rounded-circle bg-[#ededed] fs-6 border-2 border-white"><?= $remaining_count . '+';?></span>
						<?php
							if($all_count == 6){
								break;
							}
						}
					}
					?>
				</div>
			</div>
			<?php
			
			$user_in_my_school  = get_user_in_team(get_current_user_id());

			if($user_in_my_school){ ?>
				<div class="your-school position-relative  items-center d-flex gap-3">
					<h4 class="text-[#7a7b7a] fs-6 p-0 m-0">Your School</h4>
					<div class="user-img d-flex">
						<?php
							$user_ids_string = implode(',', $user_in_my_school);
							$all_enrolled_users_of_this_course_my_school = $wpdb->get_results( 
								$wpdb->prepare( 
									"SELECT DISTINCT user_id FROM {$table_name} WHERE course_id = %d AND user_id IN ($user_ids_string)", 
									$course_id 
								) 
							);
							$remaining_count_my_school = count($all_enrolled_users_of_this_course_my_school) - 5;
							$school_count = 0;
							foreach ( $all_enrolled_users_of_this_course_my_school as $result ) {
								$user_id = $result->user_id;
								$school_count++;
								if($school_count < 6){
									echo get_user_avatar_for_topic($user_id);
								} else { ?>
									<span style="margin-left: -6px; width: 24px; height: 24px" class="text-center rounded-circle bg-[#ededed] fs-6 border-2 border-white"><?= $remaining_count_my_school . '+';?></span>
								<?php
									if($all_count == 6){
										break;
									}
								}
							}
						?>
					</div>
				</div>
			<?php

			}
			
			?>
		</div>
		<?php
	}
}

// Modify the main query based on search form input
function custom_modify_taxonomy_query_with_search( $query ) {
    // Check if we are on a taxonomy page and it's the main query
    if ( $query->is_tax() && $query->is_main_query() ) {
        if ( isset( $_POST['topic-search'] ) && ! empty( $_POST['topic-search'] ) ) {
            $search_query = sanitize_text_field( $_POST['topic-search'] );
            // Modify the query arguments to include the search query
            $query->set( 's', $search_query );
        }

		if ( isset( $_POST['peer-sort'] ) && $_POST['peer-sort'] === 'top' ) {
			// Modify the query to sort by comment count
			$query->set( 'orderby', 'comment_count' );
			$query->set( 'order', 'DESC' );
		}

        if ( isset( $_POST['question-search'] ) && ! empty( $_POST['question-search'] ) ) {
            $search_query = sanitize_text_field( $_POST['question-search'] );
            
            // Modify the query arguments to include the search query
            $query->set( 's', $search_query );
        }

		if ( isset( $_POST['expert-sort'] ) && $_POST['expert-sort'] === 'top' ) {
			// Modify the query to sort by comment count
			$query->set( 'orderby', 'comment_count' );
			$query->set( 'order', 'DESC' );
		}
    }
}
add_action( 'pre_get_posts', 'custom_modify_taxonomy_query_with_search' );


function parent_comment_template_for_forum(){
	$user_avatar = get_user_meta(get_current_user_id(), 'user_avatar_url', true);
	$placeholder = 'Add your comment';
	$btn_text = 'Comment';
	if('expert-forum' == get_post_type()){
		$placeholder = 'Add your answers';
		$btn_text = 'Answer';
	}
	?>
	<div class="comments mb-3">
		<form id="parent-comment" class="needs-validation">
			<div class="add-comments my-3 d-flex gap-3">
				<div class="user-img">
					<?php
					if ($user_avatar == "") {
						echo '<img alt="" src="' . get_stylesheet_directory_uri() . '/assets/img/avatar-placeholder.png" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
					} else {
						echo '<img alt="" src="' . $user_avatar . '" class="rounded-circle topic-author" height="32" width="32" decoding="async">';
					}
					?>
				</div>
				<div class="comment-text flex-1">
						<textarea name="comment" id="p-comment-text" placeholder="<?= $placeholder;?>" class="form-control w-100" cols="30" rows="1" required></textarea>
						<input type="hidden" id="post-id" name="post-id" value="<?php echo get_the_id();?>">
				</div>
			</div>
			<div class="add-comment text-end">
				<button type="submit" class="btn btn-primary"><?= $btn_text;?></button>
			</div>
		</form>
	</div>
<?php
}

add_action('wp_ajax_self_delete_expert_forum', 'self_delete_expert_forum');
add_action('wp_ajax_nopriv_self_delete_expert_forum', 'self_delete_expert_forum'); 

function self_delete_expert_forum(){

	// $user_id = get_current_user_id();
	$post_number = sanitize_text_field($_POST['postNumber']);
	preg_match('/\d+/', $post_number, $matches);
	$post_id = $matches[0];

	wp_delete_post($post_id, false);

	echo 'post deleted';

	die();

}