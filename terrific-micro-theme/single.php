<?php get_header(); ?>
<?php get_sidebar(); ?>
<section class="content">
	<?php while (have_posts()) : the_post();
		module('Post');
		comments_template();
	endwhile; ?>
</section>
<?php get_footer(); ?>