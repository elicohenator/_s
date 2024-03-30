<?php

/**
 * Template Name: About
 */

get_header();
?>

	<main id="content">

		<?php while ( have_posts() ) : the_post(); ?>

		<?php endwhile; ?>

	</main>

<?php
get_footer();
