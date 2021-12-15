<?php

if (! function_exists('dd')) {
    function dd() {
        foreach(func_get_args() as $data) {
            echo '<pre>'. print_r($data, true) .'</pre>';
        }
    }
}

/* Remove WP Emoji */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

add_action('after_setup_theme', function() {
    register_nav_menus([
        'menu-1' => __( 'Primary', 'hello-elementor' ),
    ]);
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 350,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
});

/* TinyMCE font-size */
add_filter('tiny_mce_before_init', function($settings=[]) {
    $settings['extended_valid_elements'] = '*[*]';
    $settings['fontsize_formats'] = '8px 10px 12px 13px 14px 16px 20px 24px 28px 32px 36px';

    $settings['style_formats'] = json_encode([
        [
            'title' => 'Download Link',
            'selector' => 'a',
            'classes' => 'download'
        ],
        [
            'title' => 'My Test',
            'selector' => 'p',
            'classes' => 'mytest',
        ],
        [
            'title' => 'AlertBox',
            'block' => 'div',
            'classes' => 'alert_box',
            'wrapper' => true
        ],
        [
            'title' => 'Red Uppercase Text',
            'inline' => 'span',
            'styles' => [
                'color'         => 'red', // or hex value #ff0000
                'fontWeight'    => 'bold',
                'textTransform' => 'uppercase'
            ],
        ],
    ]);

    return $settings;
});


// Gutenberg wide images
add_theme_support( 'align-wide' );

foreach(['wp_enqueue_scripts', 'admin_enqueue_scripts'] as $hook) {
    add_action($hook, function() {
        $styles['style'] = get_template_directory_uri().'/style.css';
        $styles['bootstrap'] = '//unpkg.com/bootstrap@5.1.3/dist/css/bootstrap.min.css';
        $styles['animate'] = '//unpkg.com/animate.css@4.1.1/animate.min.css';
        $styles['font-awesome-all'] = '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css';
        $styles['font-awesome-brands'] = '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/brands.min.css';
        $styles['font-awesome'] = '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/fontawesome.min.css';
        $styles['font-awesome-regular'] = '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/regular.min.css';
        $styles['font-awesome-solid'] = '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/solid.min.css';
    
        $scripts['vue'] = '//unpkg.com/vue';
        // $scripts['vuex'] = '//unpkg.com/vuex';
    
        foreach($styles as $hid=>$url) { wp_enqueue_style($hid, $url); }
        foreach($scripts as $hid=>$url) { wp_enqueue_script($hid, $url); }
    });
}


add_action('get_header', function() {
    remove_action('wp_head', '_admin_bar_bump_cb');
});

// Desabilita checagem de nonce nos endpoints
add_filter('woocommerce_store_api_disable_nonce_check', '__return_true');


// Shortcodes
include __DIR__ . '/shortcodes/social-share.php';

// Admin pages
include __DIR__ . '/admin/settings-header-footer.php';

// Includes
include __DIR__ . '/includes/helpers.php';
include __DIR__ . '/includes/elementor-autoload.php';
