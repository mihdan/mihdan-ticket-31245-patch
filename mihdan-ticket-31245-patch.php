<?php
/**
 * Plugin Name: Mihdan: Patch for ticket 31245
 * Description: WordPress-плагин, который убирает состояние гонки при обновлении кеша alloptions
 * Github Plugin URI: https://github.com/mihdan/mihdan-ticket-31245-patch/
 * Version: 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fix a race condition in alloptions caching
 *
 * @see https://core.trac.wordpress.org/ticket/31245
 */
function mihdan_ticket_31245_patch( $option ) {
    if ( ! wp_installing() ) {
        $alloptions = wp_load_alloptions(); //alloptions should be cached at this point
        if ( isset( $alloptions[ $option ] ) ) { //only if option is among alloptions
            wp_cache_delete( 'alloptions', 'options' );
        }
    }
}
add_action( 'added_option',   'mihdan_ticket_31245_patch' );
add_action( 'updated_option', 'mihdan_ticket_31245_patch' );
add_action( 'deleted_option', 'mihdan_ticket_31245_patch' );

// eof;
