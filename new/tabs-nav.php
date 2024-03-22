<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


$term_name = $args['term_name'];
$term_slug = $args['term_slug'];
$active_class = $args['active_class'];
if(isset($args['order'])){
    $order = $args['order'];
    $order = 'order:' . $order;
}
?>

<div style="color:#f6f6f6; <?php echo $order;?>" class="position-relative tab-image nav-link w-100 <?php echo $active_class;?> " id="<?php echo $term_slug;?>-tab" data-bs-toggle="tab" href="#<?php echo $term_slug?>" aria-controls="<?php echo $term_slug?>" aria-selected="false" role="tab" tabindex="-1">
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
        width: 59%;
            max-width: 59%;
        white-space: nowrap;
        overflow: hidden;
        " class="tab-text" data-toggle="tooltip" data-placement="top" title="<?php echo $term_name;?>"><?php echo $term_name;?></p>
    </div>
</div>