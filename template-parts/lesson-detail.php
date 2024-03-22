<?php

$current_user = $args['current_user'];
$username = $current_user->user_login;
$user_id = $current_user->ID;
$avatar = get_avatar($user_id);
$user_roles = $current_user->roles;
$role_name = $args['role_name'];

$course_id = learndash_get_course_id();
$terms = get_the_terms( learndash_get_course_id(), 'ld_course_category' );
if ( !empty( $terms ) ){
    // get the first term
    $term = array_shift( $terms );
    $termSlug = $term->slug;
}

$modifiedHeader = get_field('modified_header', 'option');
$modifiedHeaderTitle = get_field('modified_header_title', 'option');
$modifiedHeaderDescription = get_field('modified_header_description', 'option');

$searchResultActionLink = ( get_field('search_result', 'option') ) ?: '';

$user_notifications = user_get_notification($user_id);

$modifiedBody = get_field('modified_header', 'option');
$modifiedDownloadButtonText = ( get_field('modified_download_button_text', 'option') ) ?: acf_get_field('modified_download_button_text', 'option')['default_value'];

$goBackActionLink = ( get_the_permalink( learndash_get_course_id() ) ) ?: '';

if( $termSlug != 'professional-learning' ) {
    $downloadFormActionLink = '';
}


?>
<main class="px-6 py-8 bg-[#F6F6F6]">
    <header class="flex justify-between items-center">
        <section class="heading-section">
            <?php
                $headerTitle = ( $modifiedHeader == true ) ? get_field('modified_header_title', 'option') : acf_get_field('modified_header_title', 'option')['default_value'];
                $headerDescription = ( $modifiedHeader == true ) ? get_field('modified_header_description', 'option') : acf_get_field('modified_header_description', 'option')['default_value'];
            ?>
            <h2 class="text-[32px] text-[#161C24] lh-sm font-bold mb-0 pb-0"><?= $headerTitle; ?></h2>
            <span class="text-[20px] text-[#4d4f4e] lh-md font-normal mb-0 pb-0"><?= $headerDescription; ?></span>
        </section>
        <section class="flex justify-between items-center">
            <?php
                echo search_form_html( $searchResultActionLink );
            ?>
            <div class=" relative flex items-center justify-center w-10 h-10 bg-white rounded-full">
                <div class="icon-notification">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/notification.svg" alt="" />
                    <span class="absolute top-0 right-0 transform translate-x-2 -translate-y-1.5 flex items-center justify-center w-[19px] h-[18px] text-xs text-white font-bold bg-orange rounded-full">
                        <?php echo $user_notifications['total_unread']; ?>
                    </span>
                </div>
                <div class="notification  right-0 top-12 absolute bg-white" style="z-index:9999">
                    <header class="flex justify-between p-3">
                        <h4 class="text-xl font-bold">Notification</h4>
                        <span class="cursor-pointer close-button"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18" stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 6L18 18" stroke="#4D4F4E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>

                    </header>
                    <ul class="">
                        <?php
                        foreach ($user_notifications['data'] as $nt) {
                        ?>
                            <li class="msg-<?php echo $nt['read'] ?> msg pt-2 pb-2 pl-4 pr-4" data-entry="<?php echo $nt['ID'] ?>">
                                <div class="ml-3 mgs-wraper">
                                    <div class="top-nt flex justify-between ">
                                        <strong>
                                            <?php echo $nt['action'] ?>
                                        </strong>
                                        <span>
                                            <?php echo $nt['time'] ?>
                                        </span>
                                    </div>
                                    <div class="bot-nt mt-2">
                                        <?php echo $nt['msg']; ?>
                                    </div>
                                </div>
                            </li>
                        <?php

                        }

                        ?>
                        <li><button class="p-3 mark-read ">Mark all as Read</button></li>
                    </ul>
                </div>
            </div>
        </section>
    </header>

    <div class="flex flex-container mt-6">
        <div class="flex-2 col-lg-12">
            <!-- my library -->
            <section class="course-detail-section">
                <div class="course-detail-section-inner p-4 rounded-[20px] bg-white">
                    <?php
                        $show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

                        $is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

                        if ( et_builder_is_product_tour_enabled() ):
                            // load fullwidth page in Product Tour mode
                            while ( have_posts() ): the_post(); ?>

                                <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
                                    <div class="entry-content">
                                    <?php
                                        the_content();
                                    ?>
                                    </div>
                                </article>
                        <?php endwhile;
                        else:
                        ?>
                        <div class="main-container">
                            <div class="heading-area flex justify-between items-center">
                                <div class="heading-area-left flex justify-between items-center">
                                    <form class="entry-goback-form" action="<?= $goBackActionLink; ?>">
                                        <button class="entry-goback-form-button-sumbit px-2 py-1 rounded-lg" type="submit"></button>
                                    </form>
                                    <h2 class="entry-title pl-[12px] text-[24px] text-[#161C24] leading-10 font-bold mb-0 pb-0"><?php echo get_the_title( learndash_get_course_id() ); ?></h2>
                                </div>
                                <?php
                                
                                    if( $termSlug != 'professional-learning' ) {
                                        $ggsa_download_all_link = get_post_meta($course_id , 'ggsa-download-link' , true ); 

                                        if( $ggsa_download_all_link  && in_array(  $course_id , learndash_user_get_enrolled_courses( $user_id )   )   ){
                                            echo '<div class="download-all-wrapper" >
                                                <a class=" entry-download-form-button-sumbit text-[16px] leading-1 font-bold text-white bg-[#FAA332] px-[16px] py-[12px] rounded-lg" target="_blank" href="'.$ggsa_download_all_link.'" download >Download Unit</a>
                                                </div>';
                                        }
                                    /*     <form class="entry-download-form" action="<?= $downloadFormActionLink; ?>">
                                    //     <button class="entry-download-form-button-sumbit text-[16px] leading-1 font-bold text-white bg-[#FAA332] px-[16px] py-[12px] rounded-lg" type="submit"><?= $modifiedDownloadButtonText; ?></button>
                                    // </form>
                                    */
                                ?>
                                
                                   
                                <?php
                                    }
                                ?>
                            </div>
                            <hr class="bg-[#EDEDED] border border-[#EDEDED]">
                            <div id="content-area" class="clearfix">
                                <div id="left-area">
                                    <div class="heading-area flex justify-between items-center mb-3">
                                        <h1 class="entry-title pl-[12px] text-[24px] text-[#161C24] leading-10 font-bold mb-0 pb-0"><?php echo get_the_title(); ?></h1>
                                        <?php
                                            if( $termSlug != 'professional-learning' && in_array(  $course_id , learndash_user_get_enrolled_courses( $user_id )   )   ){
        
                                                
                                                    // The post has the specified term in the specified taxonomy
                                                    $post = get_post(get_the_ID()) ;
                                                    $content = $post->post_content;
                                                    $pattern = '/<iframe.*?src=[\'"](.*?)[\'"]/i';
                                                    if (preg_match($pattern, $content, $matches)) {
                                                        $link = $matches[count($matches) - 1 ];
                                                        $link = str_replace("viewer", "viewer/download2", $link);
                                                        $link = str_replace("embed", "download", $link);
                                                        echo '<div class="download-all-wrapper" ><a id="topic-download" class="border-solid entry-download-form-button-sumbit text-[14px] leading-1 font-bold text-[#FAA332] bg-[#transparent] px-[8px] py-[6px] rounded-lg border-[#FAA332] border-1" target="_blank" href="'.$link.'" download >Download</a></div>';
                                                       
                                                    }
                                                    
                                              
                                            }

                                            /*
                                                <form class="entry-download-form-lesson" action="">
                                                <button class="entry-download-form-button-sumbit text-[14px] leading-1 font-bold text-[#FAA332] bg-[#transparent] px-[8px] py-[6px] rounded-lg border-[#FAA332] border-1" type="submit"><?= 'Download Lesson'; ?></button>
                                            </form>
                                            */
                                        ?>
                                    </div>
                                <?php while ( have_posts() ) : the_post(); ?>
                                    <?php
                                    /**
                                     * Fires before the title and post meta on single posts.
                                     *
                                     * @since 3.18.8
                                     */
                                    do_action( 'et_before_post' );
                                    ?>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
                                        <?php if ( ( 'off' !== $show_default_title && $is_page_builder_used ) || ! $is_page_builder_used ) { ?>
                                            <div class="et_post_meta_wrapper">

                                            <?php
                                                if ( ! post_password_required() ) :

                                                    et_divi_post_meta();

                                                    $thumb = '';

                                                    $width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

                                                    $height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
                                                    $classtext = 'et_featured_image';
                                                    $titletext = get_the_title();
                                                    $alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
                                                    $thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
                                                    $thumb = $thumbnail["thumb"];

                                                    $post_format = et_pb_post_format();

                                                    if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) {
                                                        printf(
                                                            '<div class="et_main_video_container">
                                                                %1$s
                                                            </div>',
                                                            et_core_esc_previously( $first_video )
                                                        );
                                                    } else if ( ! in_array( $post_format, array( 'gallery', 'link', 'quote' ) ) && 'on' === et_get_option( 'divi_thumbnails', 'on' ) && '' !== $thumb ) {
                                                        print_thumbnail( $thumb, $thumbnail["use_timthumb"], $alttext, $width, $height );
                                                    } else if ( 'gallery' === $post_format ) {
                                                        et_pb_gallery_images();
                                                    }
                                                ?>

                                                <?php
                                                    $text_color_class = et_divi_get_post_text_color();

                                                    $inline_style = et_divi_get_post_bg_inline_style();

                                                    switch ( $post_format ) {
                                                        case 'audio' :
                                                            $audio_player = et_pb_get_audio_player();

                                                            if ( $audio_player ) {
                                                                printf(
                                                                    '<div class="et_audio_content%1$s"%2$s>
                                                                        %3$s
                                                                    </div>',
                                                                    esc_attr( $text_color_class ),
                                                                    et_core_esc_previously( $inline_style ),
                                                                    et_core_esc_previously( $audio_player )
                                                                );
                                                            }

                                                            break;
                                                        case 'quote' :
                                                            printf(
                                                                '<div class="et_quote_content%2$s"%3$s>
                                                                    %1$s
                                                                </div>',
                                                                et_core_esc_previously( et_get_blockquote_in_content() ),
                                                                esc_attr( $text_color_class ),
                                                                et_core_esc_previously( $inline_style )
                                                            );

                                                            break;
                                                        case 'link' :
                                                            printf(
                                                                '<div class="et_link_content%3$s"%4$s>
                                                                    <a href="%1$s" class="et_link_main_url">%2$s</a>
                                                                </div>',
                                                                esc_url( et_get_link_url() ),
                                                                esc_html( et_get_link_url() ),
                                                                esc_attr( $text_color_class ),
                                                                et_core_esc_previously( $inline_style )
                                                            );

                                                            break;
                                                    }

                                                endif;
                                            ?>
                                        </div>
                                    <?php  } ?>

                                        <div class="entry-content">
                                        <?php
                                            do_action( 'et_before_content' );

                                            the_content();

                                            wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
                                        ?>
                                        </div>
                                        <div class="et_post_meta_wrapper">
                                        <?php
                                        if ( et_get_option('divi_468_enable') === 'on' ){
                                            echo '<div class="et-single-post-ad">';
                                            if ( et_get_option('divi_468_adsense') !== '' ) echo et_core_intentionally_unescaped( et_core_fix_unclosed_html_tags( et_get_option('divi_468_adsense') ), 'html' );
                                            else { ?>
                                                <a href="<?php echo esc_url( strval( et_get_option( 'divi_468_url' ) ) ); ?>"><img src="<?php echo esc_attr( et_get_option( 'divi_468_image' ) ); ?>" alt="468" class="foursixeight" /></a>
                                    <?php 	}
                                            echo '</div>';
                                        }

                                        /**
                                        * Fires after the post content on single posts.
                                        *
                                        * @since 3.18.8
                                        */
                                        do_action( 'et_after_post' );

                                            if ( ( comments_open() || get_comments_number() ) && 'on' === et_get_option( 'divi_show_postcomments', 'on' ) ) {
                                                comments_template( '', true );
                                            }
                                        ?>
                                        </div>
                                    </article>

                                <?php endwhile; ?>
                                </div>

                                <?php get_sidebar(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
            </section>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>