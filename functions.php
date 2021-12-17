<?php

/**
 * WP Santri Theme setup.
 */
function wp_santri_setup() {
	add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => __( 'Menu Utama', 'wp-santri' ),
			'footer' => __( 'Menu Footer', 'wp-santri' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

    add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	// add_theme_support( 'editor-styles' );
	// add_editor_style( 'assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'wp_santri_setup' );

function wp_santri_view( $view ) {
	include get_template_directory() . '/inc/views/' . $view . '.php';
}


require_once get_template_directory() . '/inc/post-types/index.php';
