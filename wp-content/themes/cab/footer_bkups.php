<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage cab
 * @since cab
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				/**
				 * Fires before the cab footer text for footer customization.
				 *
				 * @since cab
				 */
				do_action( 'cab_credits' );
			?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'cab' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'cab' ), 'WordPress' ); ?></a>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
