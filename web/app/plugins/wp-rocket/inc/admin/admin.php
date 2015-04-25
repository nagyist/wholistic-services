<?php
defined( 'ABSPATH' ) or	die( 'Cheatin&#8217; uh?' );

/**
 * Link to the configuration page of the plugin
 *
 * @since 1.0
 */
add_filter( 'plugin_action_links_' . plugin_basename( WP_ROCKET_FILE ), '__rocket_settings_action_links' );
function __rocket_settings_action_links( $actions )
{
	if ( ! rocket_is_white_label() ) {
		array_unshift( $actions, sprintf( '<a href="%s">%s</a>', 'http://wp-rocket.me/support/', __( 'Support', 'rocket' ) ) );

		array_unshift( $actions, sprintf( '<a href="%s">%s</a>', 'http://docs.wp-rocket.me', __( 'Docs', 'rocket' ) ) );
	}

	array_unshift( $actions, sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=' . WP_ROCKET_PLUGIN_SLUG ), __( 'Settings' ) ) );

    return $actions;
}


/**
 * Add a link "Renew your licence" when ou can't do it automatically (expired licence but new version available)
 *
 * @since 2.2
 *
 */
add_action( 'plugin_row_meta', '__rocket_plugin_row_meta', 10, 3 );
function __rocket_plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data ) {
	if ( 'wp-rocket/wp-rocket.php' == $plugin_file ) {

		$update_plugins = get_site_transient( 'update_plugins' );

		if ( $update_plugins != false && isset( $update_plugins->response[ $plugin_file ] ) && empty( $update_plugins->response[ $plugin_file ]->package ) ) {

			$link =	'<span class="dashicons dashicons-update rocket-dashicons"></span> ' .
					'<span class="rocket-renew">Renew your licence of WP Rocket to receive access to automatic upgrades and support.</span> ' .
					'<a href="http://wp-rocket.me" target="_blank" class="rocket-purchase">Purchase now</a>.';

			$plugin_meta = array_merge( (array) $link, $plugin_meta );
		}
	}

	return $plugin_meta;
}
/**
 * Add a link "Purge this cache" in the post edit area
 *
 * @since 1.0
 * @todo manage all CPTs
 */
add_filter( 'page_row_actions', '__rocket_row_actions', 10, 2 );
add_filter( 'post_row_actions', '__rocket_row_actions', 10, 2 );
function __rocket_row_actions( $actions, $post )
{
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=purge_cache&type=post-' . $post->ID ), 'purge_cache_post-' . $post->ID );
		$actions['rocket_purge'] = sprintf( '<a href="%s">%s</a>', $url, __( 'Clear this cache', 'rocket' ) );
	}
    return $actions;
}

/**
 * Add a link "Purge cache" in the post submit area
 *
 * @since 1.0
 * @todo manage all CPTs
 *
 */
add_action( 'post_submitbox_start', '__rocket_post_submitbox_start' );
function __rocket_post_submitbox_start()
{
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		global $post;
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=purge_cache&type=post-' . $post->ID ), 'purge_cache_post-' . $post->ID );
		printf( '<div id="purge-action"><a class="button-secondary" href="%s">%s</a></div>', $url, __( 'Clear cache', 'rocket' ) );
	}
}

/**
 * Add the CSS and JS files for WP Rocket options page
 *
 * @since 1.0.0
 */
add_action( 'admin_print_styles-settings_page_' . WP_ROCKET_PLUGIN_SLUG, '__rocket_add_admin_css_js' );
function __rocket_add_admin_css_js()
{
	wp_enqueue_script( 'jquery-ui-sortable', null, array( 'jquery', 'jquery-ui-core' ), null, true );
	wp_enqueue_script( 'jquery-ui-draggable', null, array( 'jquery', 'jquery-ui-core' ), null, true );
	wp_enqueue_script( 'jquery-ui-droppable', null, array( 'jquery', 'jquery-ui-core' ), null, true );
	wp_enqueue_script( 'options-wp-rocket', WP_ROCKET_ADMIN_JS_URL . 'options.js', array( 'jquery', 'jquery-ui-core' ), WP_ROCKET_VERSION, true );
	wp_enqueue_script( 'fancybox-wp-rocket', WP_ROCKET_ADMIN_JS_URL . 'vendors/jquery.fancybox.pack.js', array( 'options-wp-rocket' ), WP_ROCKET_VERSION, true );
	wp_enqueue_script( 'sweet-alert-wp-rocket', WP_ROCKET_ADMIN_JS_URL . 'vendors/sweet-alert.min.js', array( 'options-wp-rocket' ), WP_ROCKET_VERSION, true );

	wp_enqueue_style( 'options-wp-rocket', WP_ROCKET_ADMIN_CSS_URL . 'options.css', array(), WP_ROCKET_VERSION );
	wp_enqueue_style( 'fancybox-wp-rocket', WP_ROCKET_ADMIN_CSS_URL . 'fancybox/jquery.fancybox.css', array( 'options-wp-rocket' ), WP_ROCKET_VERSION );

	// Sweet Alert
	$translation_array = array(
		'warning_title'  	 => __( 'Are you sure?', 'rocket' ),
		'cloudflare_title'   => __( 'CloudFlare Settings', 'rocket' ),
		'minify_text'  		 => __( 'In case of any display errors we recommend following our documentation: ', 'rocket' ) . ' <a href="http://docs.wp-rocket.me/article/19-resolving-issues-with-minification/?utm_source=wp-rocket&utm_medium=wp-admin&utm_term=doc-minification&utm_campaign=plugin">Resolving Issues with Minification</a>.<br/><br/>' . sprintf(  __( 'You can also <a href="%s">contact our support</a> if you need help implementing that.', 'rocket' ), 'http://wp-rocket.me/support/?utm_source=wp-rocket&utm_medium=wp-admin&utm_term=support-minification&utm_campaign=plugin' ),
		'cloudflare_text'    => __( 'Click "Save Changes" to activate the Cloudflare tab.', 'rocket' ),
		'confirmButtonText'  => __( 'Yes, I\'m sure!', 'rocket' ),
		'cancelButtonText' 	 => __( 'Cancel', 'rocket' )
	);
	wp_localize_script( 'options-wp-rocket', 'sawpr', $translation_array );
	wp_enqueue_style( 'sweet-alert-wp-rocket', WP_ROCKET_ADMIN_CSS_URL . 'sweet-alert.css', array( 'options-wp-rocket' ), WP_ROCKET_VERSION );
}

/**
 * Add the CSS and JS files needed by WP Rocket everywhere on admin pages
 *
 * @since 2.1
 */
add_action( 'admin_print_styles', '__rocket_add_admin_css_js_everywhere', 11 );
function __rocket_add_admin_css_js_everywhere()
{
	wp_enqueue_script( 'all-wp-rocket', WP_ROCKET_ADMIN_JS_URL . 'all.js', array( 'jquery' ), WP_ROCKET_VERSION, true );
}

/**
 * Add some CSS to display the dismiss cross
 *
 * @since 1.1.10
 *
 */
add_action( 'admin_print_styles', '__rocket_admin_print_styles' );
function __rocket_admin_print_styles()
{
	wp_enqueue_style( 'admin-wp-rocket', WP_ROCKET_ADMIN_CSS_URL . 'admin.css', array(), WP_ROCKET_VERSION );
}

/**
 * Manage the dismissed boxes
 *
 * @since 2.4 Add a delete_transient on function name (box name)
 * @since 1.3.0 $args can replace $_GET when called internaly
 * @since 1.1.10
 */
add_action( 'wp_ajax_rocket_ignore', 'rocket_dismiss_boxes' );
add_action( 'admin_post_rocket_ignore', 'rocket_dismiss_boxes' );
function rocket_dismiss_boxes( $args )
{
	$args = empty( $args ) ? $_GET : $args;

	if ( isset( $args['box'], $args['_wpnonce'] ) ) {

		if ( ! wp_verify_nonce( $args['_wpnonce'], $args['action'] . '_' . $args['box'] ) ) {
			if ( defined( 'DOING_AJAX' ) ) {
				wp_send_json( array( 'error' => 1 ) );
			} else {
				wp_nonce_ays( '' );
			}
		}

		global $current_user;
		$actual = get_user_meta( $current_user->ID, 'rocket_boxes', true );
		$actual = array_merge( (array) $actual, array( $args['box'] ) );
		$actual = array_filter( $actual );
		$actual = array_unique( $actual );
		update_user_meta( $current_user->ID, 'rocket_boxes', $actual );
		delete_transient( $args['box'] );

		if ( 'admin-post.php' == $GLOBALS['pagenow'] ){
			if ( defined( 'DOING_AJAX' ) ) {
				wp_send_json( array( 'error' => 0 ) );
			} else {
				if ( ! defined( 'WP_ROCKET_NO_REDIRECT' ) ) {
					wp_safe_redirect( wp_get_referer() );
					die();
				}
			}
		}
	}
}

/**
 * Renew the plugin modification warning on plugin de/activation
 *
 * @since 1.3.0
 */
add_action( 'activated_plugin', 'rocket_dismiss_plugin_box' );
add_action( 'deactivated_plugin', 'rocket_dismiss_plugin_box' );
function rocket_dismiss_plugin_box( $plugin )
{
	if ( $plugin != plugin_basename( WP_ROCKET_FILE ) ) {
		rocket_renew_box( 'rocket_warning_plugin_modification' );
	}
}

/**
 * Display a prevention message when enabling or disabling a plugin can be in conflict with WP Rocket
 *
 * @since 1.3.0
 */
add_action( 'admin_post_deactivate_plugin', '__rocket_deactivate_plugin' );
function __rocket_deactivate_plugin()
{
	if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'deactivate_plugin' ) ) {
		wp_nonce_ays( '' );
	}

	deactivate_plugins( $_GET['plugin'] );

	wp_safe_redirect( wp_get_referer() );
	die();
}

/**
 * Reset White Label values to WP Rocket default values
 *
 * @since 2.1
 */
add_action( 'admin_post_rocket_resetwl', '__rocket_reset_white_label_values_action' );
function __rocket_reset_white_label_values_action()
{
	if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'rocket_resetwl' ) ) {
		rocket_reset_white_label_values( true );
	}
	wp_safe_redirect( add_query_arg( 'page', 'wprocket', remove_query_arg( 'page', wp_get_referer() ) ) );
	die();
}

/**
 * White Label the plugin, if you need to
 *
 * @since 2.1
 *
 */
add_filter( 'all_plugins', '__rocket_white_label' );
function __rocket_white_label( $plugins )
{
	// We change the plugin's header
	$plugins['wp-rocket/wp-rocket.php'] = array(
			'Name'			=> get_rocket_option( 'wl_plugin_name' ),
			'PluginURI'		=> get_rocket_option( 'wl_plugin_URI' ),
			'Version'		=> isset( $plugins['wp-rocket/wp-rocket.php']['Version'] ) ? $plugins['wp-rocket/wp-rocket.php']['Version'] : '',
			'Description'	=> reset( ( get_rocket_option( 'wl_description' ) ) ),
			'Author'		=> get_rocket_option( 'wl_author' ),
			'AuthorURI'		=> get_rocket_option( 'wl_author_URI' ),
			'TextDomain'	=> isset( $plugins['wp-rocket/wp-rocket.php']['TextDomain'] ) ? $plugins['wp-rocket/wp-rocket.php']['TextDomain'] : '',
			'DomainPath'	=> isset( $plugins['wp-rocket/wp-rocket.php']['DomainPath'] ) ? $plugins['wp-rocket/wp-rocket.php']['DomainPath'] : '',
		);

	// if white label, remove our names from contributors
	if ( rocket_is_white_label() ) {
		remove_filter( 'plugin_row_meta', 'rocket_plugin_row_meta', 10, 2 );
	}

	return $plugins;
}

/**
 * When you're doing an update, the constant does not contain yet your option or any value, reset and redirect!
 *
 * @since 2.1
 */
add_action( 'admin_init', '__rocket_check_no_empty_name', 11 );
function __rocket_check_no_empty_name()
{
	$wl_plugin_name = trim( get_rocket_option( 'wl_plugin_name' ) );
	if ( empty( $wl_plugin_name ) ) {
		rocket_reset_white_label_values( false );
		wp_safe_redirect( $_SERVER['REQUEST_URI'] );
		die();
	}
}

/**
 * This function will force the direct download of the plugin's options, compressed.
 *
 * @since 2.2
 */
add_action( 'admin_post_rocket_export', '__rocket_do_options_export' );
function __rocket_do_options_export()
{
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'rocket_export' ) ) {
		wp_nonce_ays( '' );
	}

	$filename = sprintf( 'wp-rocket-settings-%s-%s.txt', date( 'Y-m-d' ), uniqid() );
	$gz = 'gz' . strrev( 'etalfed' );
	$options = $gz//;
	( serialize( get_option( WP_ROCKET_SLUG ) ), 1 ); // do not use get_rocket_option() here
	nocache_headers();
	@header( 'Content-Type: text/plain' );
	@header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	@header( 'Content-Transfer-Encoding: binary' );
	@header( 'Content-Length: ' . strlen( $options ) );
	@header( 'Connection: close' );
	echo $options;
	exit();
}

/**
 * Do the rollback
 *
 * @since 2.4
 */
add_action( 'admin_post_rocket_rollback', '__rocket_rollback' );
function __rocket_rollback()
{
	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'rocket_rollback' ) ) {
		wp_nonce_ays( '' );
	}

	$plugin_transient 	= get_site_transient( 'update_plugins' );
	$plugin_folder    	= plugin_basename( dirname( WP_ROCKET_FILE ) );
	$plugin_file      	= basename( WP_ROCKET_FILE );
	$version          	= WP_ROCKET_LASTVERSION;
	$c_key 				= get_rocket_option( 'consumer_key' );
	$url 				= sprintf( 'http://support.wp-rocket.me/%s/wp-rocket_%s.zip', $c_key, $version );
	$temp_array 		= array(
		'slug'        => $plugin_folder,
		'new_version' => $version,
		'url'         => 'http://wp-rocket.me',
		'package'     => $url
	);

	$temp_object = (object) $temp_array;
	$plugin_transient->response[ $plugin_folder . '/' . $plugin_file ] = $temp_object;
	set_site_transient( 'update_plugins', $plugin_transient );

	$c_key = get_rocket_option( 'consumer_key' );
	$transient = get_transient( 'rocket_warning_rollback' );

	if ( false == $transient )	{

		require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		$title = sprintf( __( '%s Update Rollback', 'rocket' ), WP_ROCKET_PLUGIN_NAME );
		$plugin = 'wp-rocket/wp-rocket.php';
		$nonce = 'upgrade-plugin_' . $plugin;
		$url = 'update.php?action=upgrade-plugin&plugin=' . urlencode( $plugin );
		$upgrader_skin = new Plugin_Upgrader_Skin( compact( 'title', 'nonce', 'url', 'plugin' ) );
		$upgrader = new Plugin_Upgrader( $upgrader_skin );
		$upgrader->upgrade( $plugin );

		// Uncheck the autoupdate option to avoid an infinite update loop
		$options = get_option( WP_ROCKET_SLUG );
		if ( isset( $options['autoupdate'] ) ) {
			unset( $options['autoupdate'] );
		}
		define( 'WP_ROCKET_NO_REDIRECT', true );
		update_option( WP_ROCKET_SLUG, $options );

		wp_die( '', sprintf( __( '%s Update Rollback', 'rocket' ), WP_ROCKET_PLUGIN_NAME ), array( 'response' => 200 ) );

	}
}

/**
 * Add "Cache options" metabox
 *
 * @since 2.5
 *
 */
add_action( 'add_meta_boxes', '__rocket_cache_options_meta_boxes' );
function __rocket_cache_options_meta_boxes() {
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		$cpts = get_post_types( array( 'public' => true ), 'objects' );
		unset( $cpts['attachment'] );
		
		foreach( $cpts as $cpt => $cpt_object ) {
			$label = $cpt_object->labels->singular_name;
			add_meta_box( 'rocket_post_exclude', sprintf( __( 'Cache Options', 'rocket' ), $label ), '__rocket_display_cache_options_meta_boxes', $cpt, 'side', 'core' );
		}
	}
}

/*
 * Displays some checkbox to de/activate some cache options
 *
 * @since 2.5
 */
function __rocket_display_cache_options_meta_boxes() {
	/** This filter is documented in inc/admin-bar.php */
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) ) {
		global $post;
		wp_nonce_field( 'rocket_box_option', '_rocketnonce', false, true );
		?>

		<div class="misc-pub-section">
			<p><?php _e( 'Activate these options on this post:', 'rocket' ) ;?></p>
			<?php
			$fields = array(
				'lazyload' 		=> 'LazyLoad',
				'minify_html'	=> __( 'HTML Minification', 'rocket' ),
				'minify_css'	=> __( 'CSS Minification', 'rocket' ),
				'minify_js' 	=> __( 'JS Minification', 'rocket' ),
				'cdn'			=> __( 'CDN', 'rocket' ),
			);

			foreach ( $fields as $field => $label ) {
				$disabled = disabled( ! get_rocket_option( $field ), true, false );
				$title    = $disabled ? ' title="' . sprintf( __( 'Activate first the %s option.', 'rocket' ), esc_attr( $label ) ) . '"' : '';
				$class    = $disabled ? ' class="rkt-disabled"' : '';
				$checked   = ! $disabled ? checked( ! get_post_meta( $post->ID, '_rocket_exclude_' . $field, true ), true, false ) : '';
 				?>

				<input name="rocket_post_exclude_hidden[<?php echo $field; ?>]" type="hidden" value="on">
				<input name="rocket_post_exclude[<?php echo $field; ?>]" id="rocket_post_exclude_<?php echo $field; ?>" type="checkbox"<?php echo $title; ?><?php echo $checked; ?><?php echo $disabled; ?>>
				<label for="rocket_post_exclude_<?php echo $field; ?>"<?php echo $title; ?><?php echo $class; ?>><?php echo $label; ?></label><br>

				<?php
			}
			?>

			<p class="rkt-note"><?php _e( '<strong>Note:</strong> These options aren\'t applied if you added this post in the "Never cache the following pages" option.', 'rocket' ); ?></p>
		</div>

	<?php
	}
}

/*
 * Manage the cache options from the metabox.
 *
 * @since 2.5
 */
add_action( 'save_post', '__rocket_save_metabox_options' );
function __rocket_save_metabox_options() {
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) &&
		isset( $_POST['post_ID'], $_POST['rocket_post_exclude_hidden'], $_POST['_rocketnonce'] ) ) {

		check_admin_referer( 'rocket_box_option', '_rocketnonce' );

		$fields = array( 'lazyload', 'minify_html', 'minify_css', 'minify_js', 'cdn' );

		foreach ( $fields as $field ) {
			if ( isset( $_POST['rocket_post_exclude_hidden'][ $field ] ) && $_POST['rocket_post_exclude_hidden'][ $field ] ) {
				if ( isset( $_POST['rocket_post_exclude'][ $field ] ) ) {
					delete_post_meta( $_POST['post_ID'], '_rocket_exclude_' . $field );
				} else {
					if ( get_rocket_option( $field ) ) {
						update_post_meta( $_POST['post_ID'], '_rocket_exclude_' . $field, true );
					}
				}
			}
		}
	}
}

/*
 * Create cache folders if not exists.
 *
 * @since 2.5.5
 */
add_action( 'admin_init', '__rocket_maybe_create_cache_folders' );
function __rocket_maybe_create_cache_folders() {
	if ( defined( 'DOING_AJAX' ) || defined( 'DOING_AUTOSAVE' ) ) {
		return;
	}
	
	// Create cache folder if not exist
    if ( ! is_dir( WP_ROCKET_CACHE_PATH ) ) {
	   rocket_mkdir_p( WP_ROCKET_CACHE_PATH );
    }

	// Create minify cache folder if not exist
    if ( ! is_dir( WP_ROCKET_MINIFY_CACHE_PATH ) ) {
		rocket_mkdir_p( WP_ROCKET_MINIFY_CACHE_PATH );
    }
}