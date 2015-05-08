<?php get_header(); ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'pad group' ); ?> role="article">

				<div class="thumbnail col3">
					<?php the_post_thumbnail( 'thumbnail' ); ?> 
				</div>

				<div class="post-content col9 last">

					<h1 class="page-title">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
							<?php the_title(); ?>
						</a>
					</h1>

					<div class="entry-content group">
						<?php the_excerpt(); ?>
					</div>

					<footer class="article-footer">
						<p class="tags"><?php the_tags( '<span class="tags-title">' . __( 'Tags:', 'dropshoptheme' ) . '</span> ', ', ', '' ); ?></p>
					</footer>

				</div>

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

				<?php not_found_message();?>

		<?php endif; ?>

	<?php //get_sidebar();?>

<?php get_footer(); ?>
