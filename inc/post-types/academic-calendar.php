<?php

add_action( 'wp_santri_register_post_types', function () {
	register_post_type( 'academic-calendar', array(
		'label'               => __( 'Kalender Akademik', 'wp-santri' ),
		'public'              => true,
		'exclude_from_search' => true,
		'supports'            => array( 'title', 'editor' ),
		'has_archive'         => false,
		'menu_icon'           => 'dashicons-calendar-alt',
	) );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'academic-calendar' === $post->post_type ) {
            wp_enqueue_script(  'alpinejs', 'https://unpkg.com/alpinejs@3.5.0/dist/cdn.min.js', array(), '3.5.0', true );
        }
    }
}, 10, 1 );


add_action( 'edit_form_after_editor', function ( $post ) {
	if ( 'academic-calendar' === $post->post_type ) {
		wp_santri_view( 'post-types/academic-calendar/form' );
	}
} );

add_action( 'save_post_academic-calendar', function ( $post_id, $post, $update ) {
	if ( 'auto-draft' === $post->post_status ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	update_post_meta( $post_id, 'events', $_REQUEST['events'] );
}, 10, 3 );
