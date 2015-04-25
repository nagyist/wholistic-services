<?php
defined( 'ABSPATH' ) or	die( 'Cheatin&#8217; uh?' );

/**
 * Get relative url
 * Clean URL file to get only the equivalent of REQUEST_URI
 * ex: rocket_clean_exclude_file( 'http://www.geekpress.fr/referencement-wordpress/') return /referencement-wordpress/
 *
 * @since 1.3.5 Redo the function
 * @since 1.0
 */
function rocket_clean_exclude_file( $file )
{
	if ( ! $file ) {
		return false;
	}

	$path = parse_url( $file, PHP_URL_PATH );
    return $path;
}

/**
 * Get an url without HTTP protocol
 *
 * @since 1.3.0
 *
 * @param string $url The URL to parse
 * @param bool 	 $no_dots (default: false)
 * @return string $url The URL without protocol
 */
function rocket_remove_url_protocol( $url, $no_dots=false )
{
	$url = str_replace( array( 'http://', 'https://' ) , '', $url );

	/** This filter is documented in inc/front/htaccess.php */
	if ( apply_filters( 'rocket_url_no_dots', $no_dots ) ) {
		$url = str_replace( '.', '_', $url );
	}
	return $url;
}

/**
 * Add HTTP protocol to an url that does not have
 *
 * @since 2.2.1
 *
 * @param string $url The URL to parse
 * @return string $url The URL with protocol
 */
function rocket_add_url_protocol( $url ) {
	if ( strpos( $url, 'http://' ) === false && strpos( $url, 'https://' ) === false ) {
		$url = 'http://' . ltrim( $url, '//' );
	}
	return $url;
}

/**
 * Extract and return host, path, query and scheme of an URL
 *
 * @since 2.1 Add $query variable
 * @since 2.0
 *
 * @param string $url The URL to parse
 * @return array Components of an URL
 */
function get_rocket_parse_url( $url )
{
	if ( ! is_string( $url ) ) {
		return;
	}

	$url    = parse_url( $url );
	$host   = isset( $url['host'] ) ? $url['host'] : '';
	$path   = isset( $url['path'] ) ? $url['path'] : '';
	$scheme = isset( $url['scheme'] ) ? $url['scheme'] : '';
	$query  = isset( $url['query'] ) ? $url['query'] : '';

	/**
	 * Filter components of an URL
	 *
	 * @since 2.2
	 *
	 * @param array Components of an URL
	*/
	return apply_filters( 'rocket_parse_url', array( $host, $path, $scheme, $query ) );
}

/**
 * Get CNAMES hosts
 *
 * @since 2.3
 *
 * @param string $zones CNAMES zones
 * @return array $hosts CNAMES hosts
 */
function get_rocket_cnames_host( $zones = array( 'all' ) ) {
	$hosts = array();

	if ( $cnames = get_rocket_cdn_cnames( $zones ) ) {
		foreach ( $cnames as $cname ) {
			$cname = rocket_add_url_protocol( $cname );
			$hosts[] = parse_url( $cname, PHP_URL_HOST );
		}
	}

	return $hosts;
}

/*
 * Get an URL with one of CNAMES added in options
 *
 * @since 2.1
 *
 * @param string $url The URL to parse
 * @param array  $zone (default: array( 'all' ))
 * @return string $url The URL with one of CNAMES
 */
function get_rocket_cdn_url( $url, $zone = array( 'all' ) )
{
	$cnames = get_rocket_cdn_cnames( $zone );

	if ( ( defined( 'DONOTCDN' ) && DONOTCDN ) || (int) get_rocket_option('cdn') == 0 || empty( $cnames ) || ! is_rocket_cdn_on_ssl() || is_rocket_post_excluded_option( 'cdn' ) ) {
		return $url;
	}

	list( $host, $path, $scheme, $query ) = get_rocket_parse_url( $url );
	$query = ! empty( $query ) ? '?' . $query : '';

	// Exclude rejected files from CDN
	$rejected_files = get_rocket_cdn_reject_files();
	if( ! empty( $rejected_files ) && preg_match( '#(' . $rejected_files . ')#', $path ) ) {
		return $url;
	}

	if ( empty( $scheme ) ) {
		$home = rocket_remove_url_protocol( home_url() );

		// Check if URL is external
		if ( strpos( $path, $home ) === false ) {
			return $url;
		} else {
			$path = str_replace( $home, '', ltrim( $path, '//' ) );
		}
	}
	$url = rtrim( $cnames[(abs(crc32($path))%count($cnames))], '/' ) . '/' . ltrim( $path, '/' ) . $query;
	$url = rocket_add_url_protocol( $url );
	return $url;
}

/*
 * Wrapper of get_rocket_cdn_url() and print result
 *
 * @since 2.1
 */
function rocket_cdn_url( $url, $zone = array( 'all' ) )
{
	echo get_rocket_cdn_url( $url, $zone );
}

/*
 * Wrapper of get_rocket_minify_files() and echoes the result
 *
 * @since 2.5.5
 *
 * @param 	string $html Original Output
 * @return 	string $html Output that will be printed
 */
function rocket_add_cdn_on_custom_attr( $html ) {
	if( preg_match( '/(data-lazy-src|data-lazyload|data-src|data-retina)=[\'"]?([^\'"\s>]+)[\'"]/i', $html, $matches ) ) {
		$html = str_replace( $matches[2], get_rocket_cdn_url( $matches[2], array( 'all', 'images' ) ), $html );
	}
	
	return $html;
}

/**
 * Get tag of a group of files or JS minified CSS
 *
 * @since 2.1
 *
 * @param array  $files List of files to minify (CSS or JS)
 * @param bool   $force_pretty_url (default: true)
 * @param string $pretty_filename (default: null) The new filename if $force_pretty_url set to true
 * @return string $tags
 */
function get_rocket_minify_files( $files, $force_pretty_url = true, $pretty_filename = null )
{
	// Get the internal CSS Files
	// To avoid conflicts with file URLs are too long for browsers,
	// cut into several parts concatenated files
	$tags 		= '';
	$data_attr  = 'data-minify="1"';
	$urls 		= array( 0 => '' );
	$bubble     = is_child_theme() ? 'bubbleCssImports=1&' : '';
	$base_url 	= WP_ROCKET_URL . 'min/?' . $bubble . 'f=';
	$files  	= is_array( $files ) ? $files : (array) $files;

	if ( count( $files ) ) {

		$i=0;
		foreach ( $files as $file ) {

			$file = parse_url( $file, PHP_URL_PATH );

			// Replace "//" by "/" because it cause an issue with Google Code Minify!
			$file = str_replace( '//' , '/', $file );

			/**
			 * Filter the total number of files generated by the minification
			 *
			 * @since 2.1
			 *
			 * @param string The maximum number of characters in a URL
			 * @param string The file's extension
			*/
			$filename_length = apply_filters( 'rocket_minify_filename_length', 255, pathinfo( $file, PATHINFO_EXTENSION ) );

			// +1 : we count the extra comma
			if ( strlen( $urls[$i] . $base_url . $file )+1>=$filename_length ) {
				$i++;
			}

			/**
			 * Filter file to add in minification process
			 *
			 * @since 2.4
			 *
			 * @param string $file The file path
			*/
			$file = apply_filters( 'rocket_pre_minify_path', $file );

			$urls[$i] .= $file . ',';

		}

		foreach ( $urls as $url ) {

			$url = $base_url . rtrim( $url, ',' );
			$ext = pathinfo( $url, PATHINFO_EXTENSION );

			if ( $force_pretty_url && ( defined( 'SCRIPT_DEBUG' ) && !SCRIPT_DEBUG ) ) {

				/**
				 * Filter the minify URL
				 *
				 * If true returns,
				 * the minify URL like example.com/wp-content/plugins/wp-rocket/min/?f=...
				 *
				 * @since 2.1
				 *
				 * @param bool
				*/
				if ( ! apply_filters( 'rocket_minify_debug', false ) ) {

					$blog_id = get_current_blog_id();
					$pretty_url = !$pretty_filename ? WP_ROCKET_MINIFY_CACHE_URL . $blog_id . '/' . md5( $url . get_rocket_option( 'minify_' . $ext . '_key', create_rocket_uniqid() ) ) . '.' . $ext : WP_ROCKET_MINIFY_CACHE_URL . $blog_id . '/' . $pretty_filename . '.' . $ext;

					/**
					 * Filter the pretty minify URL
					 *
					 * @since 2.1
					 *
					 * @param string $pretty_url
					 * @param string $pretty_filename
					*/
					$pretty_url = apply_filters( 'rocket_minify_pretty_url', $pretty_url, $pretty_filename );

					$url = rocket_fetch_and_cache_minify( $url, $pretty_url ) ? $pretty_url : $url;

				}

			}

			// If CSS & JS use a CDN
			$url = get_rocket_cdn_url( $url, array( 'all', 'css_and_js', $ext ) );

			if ( $ext == 'css' ) {
				/**
				 * Filter CSS file URL with CDN hostname
				 *
				 * @since 2.1
				 *
				 * @param string $url
				*/
				$url = apply_filters( 'rocket_css_url', $url );

				$tags .= sprintf( '<link rel="stylesheet" href="%s" %s/>', esc_attr( $url ), $data_attr );

			} elseif ( $ext == 'js' ) {
				/**
				 * Filter JavaScript file URL with CDN hostname
				 *
				 * @since 2.1
				 *
				 * @param string $url
				*/
				$url = apply_filters( 'rocket_js_url', $url );

				$tags .= sprintf( '<script src="%s" %s></script>', esc_attr( $url ), $data_attr );
			}

		}

	}

	return $tags;
}

/*
 * Wrapper of get_rocket_minify_files() and echoes the result
 *
 * @since 2.1
 */
function rocket_minify_files( $files, $force_pretty_url = true, $pretty_filename = null )
{
	echo get_rocket_minify_files( $files, $force_pretty_url, $pretty_filename );
}