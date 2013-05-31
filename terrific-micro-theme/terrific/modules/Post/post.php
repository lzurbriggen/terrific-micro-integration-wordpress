<article id="post-<?php the_ID(); ?>">
	<header>
		<h1 class="title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'terrific' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header>
	<div class="content">
		<?php the_content(); ?>
	</div>
</article>