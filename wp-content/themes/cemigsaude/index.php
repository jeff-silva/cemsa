<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<!-- Preload -->
<div class="preloader">
    <div class="loader">
        <div class="wrapper">
            <div class="circle circle-1"></div>
            <div class="circle circle-1a"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
        </div>
    </div>
</div>

<?php while(have_posts()):
    the_post();

    // Elementor
    if (\Elementor\Plugin::instance()->db->is_built_with_elementor($post->ID)):
        the_content();
        break;
    endif;

    // Post
    if ($post->post_type=='post'):
    ?><br>
    <div class="delapis-single-post" style="max-width:600px; margin:0 auto;">
        <h2 class="mb-4"><?php echo get_the_title(); ?></h2>
        
        <?php if ($thumbnail_url = get_the_post_thumbnail_url($post->ID)): ?>
        <img src="<?php echo $thumbnail_url; ?>" alt="image" style="width:100%; max-height:400px; object-fit:cover;" class="mb-4">
        <?php endif; ?>

        <?php the_content(); ?>
        
        <div class="mt-4 text-center text-muted">
            Por <?php echo get_the_author(); ?> em <?php the_date(); ?>
        </div>

        <div class="mt-4 text-center">
            <?php echo do_shortcode('[social-share]'); ?>
        </div>
    </div>
    <br><?php
    break; endif;

    // Outros
    ?><br>
    <div class="container">
        <?php the_content(); ?>
    </div>
    <br><?php


endwhile; ?>

<style>
.delapis-single-post p {display:inline!important;}
</style>

<?php get_footer(); ?>
