<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<section <?php post_class( 'pad group' ); ?> >

		<h1 class="page-title"><?php the_title(); ?></h1>

		<div class="entry-content group">
			<?php the_content(); ?>
		</div>

	</section>

	<?php endwhile; endif; ?>


<?php get_footer(); ?>
