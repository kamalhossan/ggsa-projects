<?php

/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
$user_roles = $user_data->roles;

if('expert-forum' == get_post_type()){
	if(in_array('ggsa_staff', $user_roles)){
		parent_comment_template_for_forum();
	} else {
		// echo 'Sorry You\'re not allowed to answer on this forum. Only GGSA Staff can answer';
	}
} else {
	parent_comment_template_for_forum();
}




// var_dump($user_roles);
echo '<br>';
// var_dump($user_data);



if ( have_comments() ){ ?>
<div class="comment-responses mb-3">
	<div class="comment-list">
		<p class="fw-bold mb-3 text-[#4d4f4e]"><?= get_comments_number();?> Answer</p>
		<?php
		wp_list_comments( array(
			// 'style'       => 'ol',
			// 'short_ping'  => true,
			// 'avatar_size' => 32,
			'callback' 	  => 'single_forum_replies',
			'max_depth'	=> 2,
			'format' => 'html5',
			'reverse_top_level' => true,
		) );
		?>
	</div>
</div>
<?php

} else { ?>
<div class="comment-responses mb-3">
	<!--ZERO COMMENT RESPONSE-->
	<p class="fw-bold mb-3 text-[#4d4f4e]">0 Comments</p>
	<div class="zero-comment p-3 items-center text-center d-flex flex-column">
		<img class="" width="64px" height="64px" src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/no-comment.svg';?>" alt="">
		<p class="text-[#4d4f4e]">There are no comments here.</p>
	</div>
</div>
	<!--ZERO COMMENT RESPONSE-->
<?php
}
?>
