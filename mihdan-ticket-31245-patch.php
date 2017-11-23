<?php
/**
 * Plugin Name: Mihdan: Patch for ticket 31245
 * Description: WordPress-плагин, который убирает состояние гонки при обновлении кеша alloptions Edit
 * Github Plugin URI: https://github.com/mihdan/mihdan-ticket-31245-patch/
 * Version: 1.0
 */
 ?>

<?php
/**
 * Fix a race condition in alloptions caching
 *
 * @see https://core.trac.wordpress.org/ticket/31245
 */
function mihdan-ticket-31245-patch( $option ) {
    if ( ! wp_installing() ) {
        $alloptions = wp_load_alloptions(); //alloptions should be cached at this point
        if ( isset( $alloptions[ $option ] ) ) { //only if option is among alloptions
            wp_cache_delete( 'alloptions', 'options' );
		}
	}
}
add_action( 'added_option',   'mihdan-ticket-31245-patch' );
add_action( 'updated_option', 'mihdan-ticket-31245-patch' );
add_action( 'deleted_option', 'mihdan-ticket-31245-patch' );

// eof;
