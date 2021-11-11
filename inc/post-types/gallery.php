<?php

add_action( 'wp_santri_register_post_types', function () {
	register_post_type( 'gallery', array(
		'label'     => __( 'Galeri', 'wp-santri' ),
		'public'    => true,
		'supports'  => array( 'title', 'editor' ),
		'menu_icon' => 'dashicons-format-gallery',
	) );
} );
