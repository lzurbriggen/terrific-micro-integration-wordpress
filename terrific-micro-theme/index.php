<?php get_header(); ?>
	<?php while (have_posts()) : the_post();
	module('Post');
	endwhile; ?>
<?php get_footer(); ?>