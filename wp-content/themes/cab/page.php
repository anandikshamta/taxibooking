<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage cab
 * @since cab
 */
if($_POST['ajaxcall']!="1"):get_header();endif; ?>


		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
                
				echo '<div class="'.get_the_title().'">';the_title();echo '</div>';
                the_content();

			
		// End the loop.
		endwhile;
		?>

<?php if($_POST['ajaxcall']!="1"): get_footer(); endif; ?>
