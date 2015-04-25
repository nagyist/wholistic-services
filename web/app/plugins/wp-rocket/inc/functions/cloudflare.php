<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

/**
 * Get a WP_Rocket_CloudFlareAPI instance
 *
 * @since 2.5
 *
 * @return obj WP_Rocket_CloudFlareAPI instance
 */
function get_rocket_cloudflare_instance() {
	$cloudflare_email   = get_rocket_option( 'cloudflare_email' );
	$cloudflare_api_key = get_rocket_option( 'cloudflare_api_key' );

	if( isset( $cloudflare_email, $cloudflare_api_key ) ) {
		return WP_Rocket_CloudFlareAPI::instance( $cloudflare_email, $cloudflare_api_key );
	}
	return false;
}

/**
 * Returns the main instance of WP_Rocket_CloudFlareAPI to prevent the need to use globals.
 */
$GLOBALS['rocket_cloudflare'] = get_rocket_cloudflare_instance();

/**
 * Get all the current CloudFlare settings for a given domain.
 *
 * @since 2.5
 *
 * @return void
 */
function get_rocket_cloudflare_settings() {
	$domain 	 = get_rocket_option( 'cloudflare_domain' );
	$cf_settings = (array) $GLOBALS['rocket_cloudflare']->zone_settings( $domain )->response->result->objs;
	return reset(( $cf_settings ));
}

/**
 * Set the CloudFlare Development Mode.
 *
 * @since 2.5
 *
 * @return void
 */
function set_rocket_cloudflare_cache_lvl( $mode ) {
	$domain = get_rocket_option( 'cloudflare_domain' );
	$GLOBALS['rocket_cloudflare']->cache_lvl( $domain, $mode );
}


/**
 * Set the CloudFlare Caching Level.
 *
 * @since 2.5
 *
 * @return void
 */
function set_rocket_cloudflare_devmode( $mode ) {
	$domain = get_rocket_option( 'cloudflare_domain' );
	$GLOBALS['rocket_cloudflare']->devmode( $domain, $mode );
}

/**
 * Set the CloudFlare Rocket Loader.
 *
 * @since 2.5
 *
 * @return void
 */
function set_rocket_cloudflare_async( $mode ) {
	$domain = get_rocket_option( 'cloudflare_domain' );
	$GLOBALS['rocket_cloudflare']->async( $domain, $mode );
}

/**
 * Set the CloudFlare Minification.
 *
 * @since 2.5
 *
 * @return void
 */
function set_rocket_cloudflare_minify( $mode ) {
	$domain = get_rocket_option( 'cloudflare_domain' );
	$GLOBALS['rocket_cloudflare']->minify( $domain, $mode );
}

/**
 * Purge CloudFlare cache.
 *
 * @since 2.5
 *
 * @return void
 */
function rocket_purge_cloudflare() {
	$domain = get_rocket_option( 'cloudflare_domain' );
	$GLOBALS['rocket_cloudflare']->fpurge_ts( $domain );
}