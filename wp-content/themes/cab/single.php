<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage cab
 * @since cab
 */

get_header(); ?>

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
                
                    //the_title();
                    the_content();
			

		// End the loop.
		endwhile;
		?>

		

<?php get_footer(); ?>
