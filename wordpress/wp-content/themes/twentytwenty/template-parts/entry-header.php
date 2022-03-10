<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$entry_header_classes = '';

if ( is_singular() ) {
	$entry_header_classes .= ' header-footer-group';
}

?>

<header class="entry-header has-text-align-center<?php echo esc_attr( $entry_header_classes ); ?>">

	<div class="entry-header-inner section-inner medium">

		<?php
		/**
		 * Allow child themes and plugins to filter the display of the categories in the entry header.
		 *
		 * @since Twenty Twenty 1.0
		 *
		 * @param bool Whether to show the categories in header. Default true.
		 */
		$show_categories = apply_filters( 'twentytwenty_show_categories_in_entry_header', true );

		if ( true === $show_categories && has_category() ) {
			?>

			<div class="entry-categories">
				<span class="screen-reader-text"><?php _e( 'Categories', 'twentytwenty' ); ?></span>
				<div class="entry-categories-inner">
					<?php the_category( ' ' ); ?>
				</div><!-- .entry-categories-inner -->
			</div><!-- .entry-categories -->

			<?php
		}

		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
		}
		
		
 		// Display start and end date of activity.
		if(is_single()) {
			global $db2;
			$post_id 	= get_the_ID();
			$startDate  = get_field("start_tijd", $post_id);
			$endDate    = get_field("eind_tijd", $post_id);
			$maxUsers 	= get_field("maximaal_aantal_deelnemers", $post_id);
			$availableUsers = "";
			$deelnemers = $db2->get_var("SELECT COUNT(*) FROM `$post_id`");
			// Calculate ammount of available slots. (max ammount of users - current ammount of users)
			$availableUsers = ($maxUsers - $deelnemers);
			echo '<p class="datee">Begint op: '.$startDate.'</p>';
			echo '<p class="datee">Eindigt op: '.$endDate.'</p><br>';
			echo '<p class="users">Beschikbare Plekken: '.$availableUsers.'</p>';
		}
		?>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
