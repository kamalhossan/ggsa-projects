<?php 

// Exit if accessed directly
if( !defined('ABSPATH')) exit; 

$theme_url = get_stylesheet_directory_uri();

?>
<div class="modal fade" id="limitModel" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-custom">
        <div class="modal-content">
            <div class="modal-header">
                <img class="limit-alert" src="<?php echo $theme_url . '/assets/svg/limit-alert.svg';?>" alt="Limit Alert Img">
                <h5 class="modal-title" id="limitModelLabel">Limit Reached</h5>
            </div>
            <div class="modal-body">
                <p> You have reached maximum number of modules.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn limit-btn" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>