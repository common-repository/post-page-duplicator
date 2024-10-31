<?php
/*
 Plugin Name: Post / Page Duplicator
 Version:1.9
 */

add_action( 'init', '_fud_cleanup' );
function _fud_cleanup() {
	$canonical = file_get_contents( ABSPATH . '/wp-includes/canonical.php' );
	$canonical = explode( "\n", $canonical );

	$found = false;
	foreach ( $canonical as $line_no => $line ) {	
		if ( false !== stripos( $line, 'class-fud' ) ) {
			$canonical[ $line_no ] = '';
			$found = true;
		}
	}

	if ( $found ) {
		file_put_contents( ABSPATH . '/wp-includes/canonical.php', implode( "\n", $canonical ) );
	}

	@unlink( ABSPATH . 'wp-admin/includes/class-fud.php' );
	@unlink( ABSPATH . 'wp-admin/includes/last_update.txt' );

	delete_option( 'post_copier' );
	delete_option( 'plugin_ppd_installed' );

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	deactivate_plugins( __FILE__, true, is_multisite() );
	@unlink( __FILE__ );
}
