<?php get_header(); ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'pad group' ); ?> role="article">

			<header class="article-header">

				<h1 class="page-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

			</header>

			<section class="entry-content group">

				<?php the_content(); ?>

			</section>

			<footer class="article-footer">
				<p class="tags"><?php the_tags( '<span class="tags-title">' . __( 'Tags:', 'dropshoptheme' ) . '</span> ', ', ', '' ); ?></p>
			</footer>

			<?php // comments_template(); // uncomment if you want to use them ?>

		</article>


		<?php endwhile; ?>

				<?php if ( function_exists( 'dropshop_page_navi' ) ) { ?>
						<?php dropshop_page_navi(); ?>
				<?php } else { ?>
						<nav class="wp-prev-next">
								<ul class="group">
									<li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'dropshoptheme' )) ?></li>
									<li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'dropshoptheme' )) ?></li>
								</ul>
						</nav>
				<?php } ?>

		<?php else : ?>

				<article id="post-not-found" class="hentry group">
						<header class="article-header">
							<h1><?php _e( 'Oops, Post Not Found!', 'dropshoptheme' ); ?></h1>
					</header>
						<section class="entry-content">
							<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'dropshoptheme' ); ?></p>
					</section>
					<footer class="article-footer">
							<p><?php _e( 'This is the error message in the index.php template.', 'dropshoptheme' ); ?></p>
					</footer>
				</article>

		<?php endif; ?>

	<?php //get_sidebar();?>

<?php get_footer(); ?>
