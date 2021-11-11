<?php

add_action( 'wp_santri_register_post_types', function () {
	register_post_type( 'quote', array(
		'label'     => __( 'Kutipan', 'wp-santri' ),
		'public'    => true,
		'supports'  => array( 'title', 'editor' ),
		'menu_icon' => 'dashicons-editor-quote',
	) );
} );
