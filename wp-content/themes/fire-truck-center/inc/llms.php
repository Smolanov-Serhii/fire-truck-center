<?php
/**
 * Automatic llms.txt generation and delivery.
 *
 * @package Fire_Truck_Center
 */

/**
 * Generator version. Increment when the output structure changes.
 */
function ftc_llms_generator_version() {
	return '2';
}

/**
 * Convert content to a safe, single-line Markdown value.
 *
 * @param mixed $value      Raw value.
 * @param int   $max_length Optional maximum length.
 * @return string
 */
function ftc_llms_plain_text( $value, $max_length = 0 ) {
	if ( is_array( $value ) || is_object( $value ) ) {
		return '';
	}

	$text = html_entity_decode( wp_strip_all_tags( (string) $value, true ), ENT_QUOTES, get_bloginfo( 'charset' ) );
	$text = trim( preg_replace( '/\s+/u', ' ', $text ) );

	if ( $max_length > 0 && function_exists( 'mb_strlen' ) && mb_strlen( $text ) > $max_length ) {
		$text = rtrim( mb_substr( $text, 0, $max_length - 1 ) ) . '…';
	} elseif ( $max_length > 0 && strlen( $text ) > $max_length ) {
		$text = rtrim( substr( $text, 0, $max_length - 3 ) ) . '...';
	}

	return $text;
}

/**
 * Escape the characters that can break a Markdown link label.
 *
 * @param string $label Link label.
 * @return string
 */
function ftc_llms_markdown_label( $label ) {
	return str_replace( array( '\\', '[', ']' ), array( '\\\\', '\\[', '\\]' ), ftc_llms_plain_text( $label ) );
}

/**
 * Build one llms.txt file-list entry.
 *
 * @param string $label Link label.
 * @param string $url   Absolute URL.
 * @param string $note  Optional link note.
 * @return string
 */
function ftc_llms_link( $label, $url, $note = '' ) {
	$url = esc_url_raw( $url );
	if ( '' === $url ) {
		return '';
	}

	$line = '- [' . ftc_llms_markdown_label( $label ) . '](' . $url . ')';
	$note = ftc_llms_plain_text( $note );

	return $note ? $line . ': ' . $note : $line;
}

/**
 * Return a published page by path, or null.
 *
 * @param string $path Page path.
 * @return WP_Post|null
 */
function ftc_llms_get_page( $path ) {
	$page = get_page_by_path( $path, OBJECT, 'page' );

	return $page instanceof WP_Post && 'publish' === $page->post_status ? $page : null;
}

/**
 * Read a truck field through ACF with a post-meta fallback.
 *
 * @param int      $post_id Truck ID.
 * @param string[] $keys    Candidate field names.
 * @return string
 */
function ftc_llms_get_truck_field( $post_id, $keys ) {
	foreach ( $keys as $key ) {
		$value = function_exists( 'get_field' ) ? get_field( $key, $post_id ) : get_post_meta( $post_id, $key, true );
		$value = ftc_llms_plain_text( $value );
		if ( '' !== $value ) {
			return $value;
		}
	}

	return '';
}

/**
 * Normalize the inventory status stored by ACF.
 *
 * @param int $post_id Truck ID.
 * @return string
 */
function ftc_llms_get_truck_status( $post_id ) {
	$status = ftc_llms_get_truck_field( $post_id, array( 'status_sibgle', 'status' ) );

	return sanitize_key( str_replace( array( ' ', '_' ), '-', strtolower( $status ) ) );
}

/**
 * Collect current inventory and active taxonomy counts in one pass.
 *
 * @return array
 */
function ftc_llms_get_inventory_data() {
	$query = new WP_Query(
		array(
			'post_type'              => 'truck',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => true,
		)
	);

	$data = array(
		'inventory' => array(),
		'counts'    => array(
			'equipment_type' => array(),
			'truck_brands'   => array(),
		),
	);

	foreach ( $query->posts as $post_id ) {
		$status = ftc_llms_get_truck_status( $post_id );
		if ( in_array( $status, array( 'sold', 'sold-out', 'out-of-stock' ), true ) ) {
			continue;
		}

		$year    = ftc_llms_get_truck_field( $post_id, array( '_year', 'year' ) );
		$sku     = ftc_llms_get_truck_field( $post_id, array( 'sku' ) );
		$price   = ftc_llms_get_truck_field( $post_id, array( '_price', 'price' ) );
		$mileage = ftc_llms_get_truck_field( $post_id, array( 'mileage' ) );
		$types   = wp_get_object_terms( $post_id, 'equipment_type' );
		$brands  = wp_get_object_terms( $post_id, 'truck_brands' );

		if ( is_wp_error( $types ) ) {
			$types = array();
		}
		if ( is_wp_error( $brands ) ) {
			$brands = array();
		}

		foreach ( array( 'equipment_type' => $types, 'truck_brands' => $brands ) as $taxonomy => $terms ) {
			foreach ( $terms as $term ) {
				if ( ! isset( $data['counts'][ $taxonomy ][ $term->term_id ] ) ) {
					$data['counts'][ $taxonomy ][ $term->term_id ] = 0;
				}
				++$data['counts'][ $taxonomy ][ $term->term_id ];
			}
		}

		$details = array();
		if ( $types ) {
			$details[] = 'Type: ' . implode( ', ', wp_list_pluck( $types, 'name' ) );
		}
		if ( $brands ) {
			$details[] = 'Make: ' . implode( ', ', wp_list_pluck( $brands, 'name' ) );
		}
		if ( $year ) {
			$details[] = 'Year: ' . $year;
		}
		if ( $mileage ) {
			$details[] = 'Mileage: ' . $mileage . ' miles';
		}
		if ( $sku ) {
			$details[] = 'SKU: ' . $sku;
		}
		if ( $price ) {
			$details[] = 'Price: ' . $price;
		}
		$details[] = in_array( $status, array( 'pending', 'sale-pending' ), true ) ? 'Availability: sale pending' : 'Availability: in stock';

		$data['inventory'][] = array(
			'id'      => (int) $post_id,
			'title'   => get_the_title( $post_id ),
			'url'     => get_permalink( $post_id ),
			'year'    => is_numeric( $year ) ? (int) $year : 0,
			'details' => implode( '; ', $details ),
		);
	}

	usort(
		$data['inventory'],
		function ( $left, $right ) {
			if ( $left['year'] !== $right['year'] ) {
				return $right['year'] <=> $left['year'];
			}

			return strcasecmp( $left['title'], $right['title'] );
		}
	);

	return $data;
}

/**
 * Add an automatically generated taxonomy section.
 *
 * @param array  $lines     Output lines, passed by reference.
 * @param string $heading   Section heading.
 * @param string $taxonomy  Taxonomy name.
 * @param array  $counts    Current inventory counts by term ID.
 * @return void
 */
function ftc_llms_add_taxonomy_section( &$lines, $heading, $taxonomy, $counts ) {
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return;
	}

	$entries = array();
	foreach ( $terms as $term ) {
		$count = isset( $counts[ $term->term_id ] ) ? (int) $counts[ $term->term_id ] : 0;
		if ( $count < 1 ) {
			continue;
		}

		$url = get_term_link( $term );
		if ( is_wp_error( $url ) ) {
			continue;
		}

		$note = sprintf( _n( '%d current listing', '%d current listings', $count, 'fire-truck-center' ), $count );
		if ( $term->description ) {
			$note .= '. ' . ftc_llms_plain_text( $term->description, 180 );
		}

		$entries[] = ftc_llms_link( $term->name, $url, $note );
	}

	if ( ! $entries ) {
		return;
	}

	$lines[] = '## ' . $heading;
	$lines[] = '';
	foreach ( $entries as $entry ) {
		$lines[] = $entry;
	}
	$lines[] = '';
}

/**
 * Build a standards-aligned llms.txt document from current WordPress data.
 *
 * @return string
 */
function ftc_build_llms_txt() {
	$site_name = ftc_llms_plain_text( apply_filters( 'ftc_llms_site_name', 'Fire Truck Center' ) );
	$summary   = ftc_llms_plain_text( get_bloginfo( 'description' ) );

	if ( '' === $summary ) {
		$summary = 'Fire Truck Center sells inspected used fire trucks and custom-built fire apparatus to fire departments and emergency services. Inventory includes pumpers, aerials, rescue trucks, tankers, wildland and brush trucks, and CAFS, dry chemical, and ARFF apparatus. Worldwide delivery, financing, inspections, pump tests, and aerial certifications are available.';
	}

	$summary = apply_filters( 'ftc_llms_summary', $summary );
	$data    = ftc_llms_get_inventory_data();
	$lines   = array(
		'# ' . ( $site_name ? $site_name : 'Fire Truck Center' ),
		'',
		'> ' . ftc_llms_plain_text( $summary ),
		'',
		'Fire Truck Center is located at 1991 Hartel Ave, Levittown, PA 19057, United States. Phone: +1 215-559-9119. Email: help@firetruck.center.',
		'',
		'Inventory links and availability below are generated automatically from published website content. The individual vehicle page is the authoritative source for current specifications, price, and availability.',
		'',
		'## Primary pages',
		'',
	);

	$primary_pages = array(
		array( 'Home', home_url( '/' ), 'Company overview and featured fire trucks.' ),
		array( 'Used Fire Trucks for Sale', 'search-fire-truck-for-sale', 'Complete current inventory with filters.' ),
		array( 'Fire Truck Brands', 'fire-truck-brands', 'Browse current inventory by manufacturer.' ),
		array( 'Sell or Appraise Your Fire Truck', 'sell-your-fire-truck', 'Submit a vehicle for appraisal or sale.' ),
		array( 'About Fire Truck Center', 'about-us', 'Company information.' ),
		array( 'Contact Fire Truck Center', 'contact-us', 'Sales and support contacts.' ),
		array( 'Frequently Asked Questions', 'faq', 'Common questions about buying and selling fire apparatus.' ),
	);

	foreach ( $primary_pages as $index => $page_data ) {
		if ( 0 === $index ) {
			$lines[] = ftc_llms_link( $page_data[0], $page_data[1], $page_data[2] );
			continue;
		}

		$page = ftc_llms_get_page( $page_data[1] );
		if ( $page ) {
			$lines[] = ftc_llms_link( $page_data[0], get_permalink( $page ), $page_data[2] );
		}
	}
	$lines[] = '';

	ftc_llms_add_taxonomy_section( $lines, 'Current inventory by truck type', 'equipment_type', $data['counts']['equipment_type'] );
	ftc_llms_add_taxonomy_section( $lines, 'Current inventory by manufacturer', 'truck_brands', $data['counts']['truck_brands'] );

	if ( $data['inventory'] ) {
		$lines[] = '## Current available inventory';
		$lines[] = '';

		$maximum = (int) apply_filters( 'ftc_llms_max_inventory_items', 100 );
		foreach ( array_slice( $data['inventory'], 0, max( 1, $maximum ) ) as $truck ) {
			$lines[] = ftc_llms_link( $truck['title'], $truck['url'], $truck['details'] );
		}
		$lines[] = '';
	}

	$lines[] = '## Optional';
	$lines[] = '';

	$blog_page = ftc_llms_get_page( 'blog' );
	if ( $blog_page ) {
		$lines[] = ftc_llms_link( 'Fire Truck Center Blog', get_permalink( $blog_page ), 'Guides and news about used fire apparatus.' );
	}

	$privacy_page = ftc_llms_get_page( 'privacy-policy-2' );
	if ( $privacy_page ) {
		$privacy_title = get_the_title( $privacy_page );
		$lines[]       = ftc_llms_link( $privacy_title ? $privacy_title : 'Privacy Policy', get_permalink( $privacy_page ) );
	}

	$posts = get_posts(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => 12,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $posts as $post ) {
		$excerpt = has_excerpt( $post ) ? $post->post_excerpt : $post->post_content;
		$lines[] = ftc_llms_link( get_the_title( $post ), get_permalink( $post ), ftc_llms_plain_text( $excerpt, 180 ) );
	}

	$lines[] = ftc_llms_link( 'XML Sitemap', home_url( '/sitemap_index.xml' ), 'Index of crawlable website content.' );

	$lines = array_values( array_filter( $lines, 'is_string' ) );

	return implode( "\n", $lines ) . "\n";
}

/**
 * Return cached output, rebuilding it when needed.
 *
 * @param bool $force Force regeneration.
 * @return string
 */
function ftc_get_llms_txt( $force = false ) {
	$cache_key = 'ftc_llms_txt_' . ftc_llms_generator_version();
	$content   = $force ? false : get_transient( $cache_key );

	if ( false === $content ) {
		$content = ftc_build_llms_txt();
		set_transient( $cache_key, $content, 12 * HOUR_IN_SECONDS );
	}

	return $content;
}

/**
 * Write the generated document to the public web root.
 *
 * @param bool $force Force content regeneration.
 * @return bool
 */
function ftc_write_llms_txt( $force = false ) {
	$content = ftc_get_llms_txt( $force );
	$path    = wp_normalize_path( ABSPATH . 'llms.txt' );
	$current = is_readable( $path ) ? file_get_contents( $path ) : false; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

	if ( $current === $content ) {
		update_option( 'ftc_llms_generator_version', ftc_llms_generator_version(), false );
		return true;
	}

	$bytes = @file_put_contents( $path, $content, LOCK_EX ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
	if ( false === $bytes ) {
		update_option( 'ftc_llms_write_error', sprintf( 'Could not write %s. Check file ownership and permissions.', $path ), false );
		return false;
	}

	delete_option( 'ftc_llms_write_error' );
	update_option( 'ftc_llms_generator_version', ftc_llms_generator_version(), false );
	update_option( 'ftc_llms_generated_at', time(), false );
	do_action( 'ftc_llms_txt_generated', $path, $content );

	return true;
}

/**
 * Coalesce multiple content-change hooks into one end-of-request refresh.
 *
 * @return void
 */
function ftc_schedule_llms_refresh() {
	static $scheduled = false;

	if ( $scheduled ) {
		return;
	}

	$scheduled = true;
	delete_transient( 'ftc_llms_txt_' . ftc_llms_generator_version() );
	add_action( 'shutdown', 'ftc_refresh_llms_txt_on_shutdown', 20 );
}

/**
 * Refresh callback used at shutdown.
 *
 * @return void
 */
function ftc_refresh_llms_txt_on_shutdown() {
	ftc_write_llms_txt( true );
}

/**
 * Refresh after relevant post content changes.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether the post already existed.
 * @return void
 */
function ftc_llms_post_changed( $post_id, $post, $update ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}

	if ( $post instanceof WP_Post && in_array( $post->post_type, array( 'truck', 'page', 'post' ), true ) ) {
		ftc_schedule_llms_refresh();
	}
}
add_action( 'save_post', 'ftc_llms_post_changed', 100, 3 );

/**
 * Refresh before a relevant post is deleted.
 *
 * @param int $post_id Post ID.
 * @return void
 */
function ftc_llms_post_deleted( $post_id ) {
	if ( in_array( get_post_type( $post_id ), array( 'truck', 'page', 'post' ), true ) ) {
		ftc_schedule_llms_refresh();
	}
}
add_action( 'before_delete_post', 'ftc_llms_post_deleted' );
add_action( 'trashed_post', 'ftc_llms_post_deleted' );
add_action( 'untrashed_post', 'ftc_llms_post_deleted' );

/**
 * Refresh after a catalog term changes.
 *
 * @param int    $term_id  Term ID.
 * @param int    $tt_id    Term-taxonomy ID.
 * @param string $taxonomy Taxonomy.
 * @return void
 */
function ftc_llms_term_changed( $term_id, $tt_id, $taxonomy ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
	if ( in_array( $taxonomy, array( 'equipment_type', 'truck_brands' ), true ) ) {
		ftc_schedule_llms_refresh();
	}
}
add_action( 'created_term', 'ftc_llms_term_changed', 20, 3 );
add_action( 'edited_term', 'ftc_llms_term_changed', 20, 3 );
add_action( 'delete_term', 'ftc_llms_term_changed', 20, 3 );

/**
 * Refresh after truck taxonomy assignments change.
 *
 * @param int    $object_id Object ID.
 * @param array  $terms     Assigned terms.
 * @param array  $tt_ids    Term-taxonomy IDs.
 * @param string $taxonomy  Taxonomy.
 * @return void
 */
function ftc_llms_object_terms_changed( $object_id, $terms, $tt_ids, $taxonomy ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
	if ( 'truck' === get_post_type( $object_id ) && in_array( $taxonomy, array( 'equipment_type', 'truck_brands' ), true ) ) {
		ftc_schedule_llms_refresh();
	}
}
add_action( 'set_object_terms', 'ftc_llms_object_terms_changed', 20, 4 );

/**
 * Refresh when ACF saves a truck or catalog term.
 *
 * @param mixed $post_id ACF object identifier.
 * @return void
 */
function ftc_llms_acf_changed( $post_id ) {
	if ( is_numeric( $post_id ) && in_array( get_post_type( (int) $post_id ), array( 'truck', 'page', 'post' ), true ) ) {
		ftc_schedule_llms_refresh();
		return;
	}

	if ( is_string( $post_id ) && preg_match( '/^(?:term|equipment_type|truck_brands)_\d+$/', $post_id ) ) {
		ftc_schedule_llms_refresh();
	}
}
add_action( 'acf/save_post', 'ftc_llms_acf_changed', 30 );

// Keep the document current when global site identity or URLs change.
add_action( 'update_option_blogname', 'ftc_schedule_llms_refresh', 20, 0 );
add_action( 'update_option_blogdescription', 'ftc_schedule_llms_refresh', 20, 0 );
add_action( 'update_option_home', 'ftc_schedule_llms_refresh', 20, 0 );
add_action( 'update_option_siteurl', 'ftc_schedule_llms_refresh', 20, 0 );

/**
 * Register the dynamic fallback endpoint.
 *
 * @return void
 */
function ftc_llms_rewrite_rule() {
	add_rewrite_rule( '^llms\.txt$', 'index.php?ftc_llms=1', 'top' );
}
add_action( 'init', 'ftc_llms_rewrite_rule', 20 );

/**
 * Register the endpoint query variable.
 *
 * @param array $vars Public query variables.
 * @return array
 */
function ftc_llms_query_var( $vars ) {
	$vars[] = 'ftc_llms';
	return $vars;
}
add_filter( 'query_vars', 'ftc_llms_query_var' );

/**
 * Generate the file after deployment and maintain a daily safety refresh.
 *
 * @return void
 */
function ftc_llms_bootstrap() {
	if ( ftc_llms_generator_version() !== get_option( 'ftc_llms_rewrite_version' ) ) {
		flush_rewrite_rules( false );
		update_option( 'ftc_llms_rewrite_version', ftc_llms_generator_version(), false );
	}

	$path = wp_normalize_path( ABSPATH . 'llms.txt' );
	if ( ftc_llms_generator_version() !== get_option( 'ftc_llms_generator_version' ) || ! is_readable( $path ) ) {
		ftc_write_llms_txt( true );
	}

	if ( ! wp_next_scheduled( 'ftc_llms_daily_refresh' ) ) {
		wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', 'ftc_llms_daily_refresh' );
	}
}
add_action( 'wp_loaded', 'ftc_llms_bootstrap', 99 );
add_action( 'ftc_llms_daily_refresh', 'ftc_refresh_llms_txt_on_shutdown' );

/**
 * Serve llms.txt through WordPress when no physical file is available.
 *
 * @return void
 */
function ftc_llms_serve_dynamic_endpoint() {
	if ( '1' !== (string) get_query_var( 'ftc_llms' ) ) {
		return;
	}

	$content = ftc_get_llms_txt();
	$etag    = '"' . md5( $content ) . '"';

	if ( isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) && trim( wp_unslash( $_SERVER['HTTP_IF_NONE_MATCH'] ) ) === $etag ) {
		status_header( 304 );
		exit;
	}

	status_header( 200 );
	header( 'Content-Type: text/plain; charset=UTF-8' );
	header( 'Cache-Control: public, max-age=3600, stale-while-revalidate=86400' );
	header( 'ETag: ' . $etag );
	header( 'X-Robots-Tag: index, follow' );
	echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit;
}
add_action( 'template_redirect', 'ftc_llms_serve_dynamic_endpoint', 0 );

/**
 * Add a small status and manual refresh screen under Tools.
 *
 * @return void
 */
function ftc_llms_admin_menu() {
	add_management_page( 'LLMs.txt', 'LLMs.txt', 'manage_options', 'ftc-llms', 'ftc_llms_admin_page' );
}
add_action( 'admin_menu', 'ftc_llms_admin_menu' );

/**
 * Render the Tools > LLMs.txt screen.
 *
 * @return void
 */
function ftc_llms_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$generated_at = (int) get_option( 'ftc_llms_generated_at' );
	$error        = get_option( 'ftc_llms_write_error' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'LLMs.txt', 'fire-truck-center' ); ?></h1>
		<p><?php esc_html_e( 'The file is generated automatically from published pages, truck types, manufacturers, current inventory, and recent blog posts.', 'fire-truck-center' ); ?></p>
		<p><strong><?php esc_html_e( 'Public URL:', 'fire-truck-center' ); ?></strong> <a href="<?php echo esc_url( home_url( '/llms.txt' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( home_url( '/llms.txt' ) ); ?></a></p>
		<p><strong><?php esc_html_e( 'Last generated:', 'fire-truck-center' ); ?></strong> <?php echo $generated_at ? esc_html( wp_date( 'Y-m-d H:i:s T', $generated_at ) ) : esc_html__( 'Not generated yet', 'fire-truck-center' ); ?></p>
		<?php if ( $error ) : ?>
			<div class="notice notice-error inline"><p><?php echo esc_html( $error ); ?></p></div>
		<?php endif; ?>
		<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
			<input type="hidden" name="action" value="ftc_refresh_llms">
			<?php wp_nonce_field( 'ftc_refresh_llms' ); ?>
			<?php submit_button( __( 'Regenerate now', 'fire-truck-center' ), 'primary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}

/**
 * Process manual regeneration from Tools > LLMs.txt.
 *
 * @return void
 */
function ftc_llms_manual_refresh() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to perform this action.', 'fire-truck-center' ) );
	}

	check_admin_referer( 'ftc_refresh_llms' );
	$success = ftc_write_llms_txt( true );
	$url     = add_query_arg( 'ftc_llms_refreshed', $success ? '1' : '0', admin_url( 'tools.php?page=ftc-llms' ) );
	wp_safe_redirect( $url );
	exit;
}
add_action( 'admin_post_ftc_refresh_llms', 'ftc_llms_manual_refresh' );

/**
 * Show the result of a manual regeneration.
 *
 * @return void
 */
function ftc_llms_admin_notice() {
	if ( ! isset( $_GET['page'], $_GET['ftc_llms_refreshed'] ) || 'ftc-llms' !== $_GET['page'] ) {
		return;
	}

	$success = '1' === sanitize_text_field( wp_unslash( $_GET['ftc_llms_refreshed'] ) );
	$class   = $success ? 'notice notice-success is-dismissible' : 'notice notice-error is-dismissible';
	$message = $success ? __( 'LLMs.txt was regenerated successfully.', 'fire-truck-center' ) : __( 'LLMs.txt could not be written. Check the file permissions shown below.', 'fire-truck-center' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
add_action( 'admin_notices', 'ftc_llms_admin_notice' );
