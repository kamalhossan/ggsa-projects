<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

$theme_url = get_stylesheet_directory_uri();
// $active_class = $args['active_class'];
// $tabs_nav_id = $args['tabs_nav_id'];

?>

<div class="empty-library">
<img src="<?php echo $theme_url . '/assets/img/note-2.svg';?>" alt="Emtry Cart" srcset="">
<h4 class="empty-title">There is no professional record here</h4>
</div>
