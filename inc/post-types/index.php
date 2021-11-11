<?php

require_once __DIR__ . '/academic-calendar.php';
require_once __DIR__ . '/quote.php';
require_once __DIR__ . '/gallery.php';

function wp_santri_register_post_types() {
	do_action( 'wp_santri_register_post_types' );
}
add_action( 'init', 'wp_santri_register_post_types' );
