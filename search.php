<?php get_header(); ?>

	<div class="inner group">

		<div id="main" class="pad col8 group" role="main">
			
			<h1 class="archive-title"><span><?php _e( 'Search Results for:', 'dropshoptheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?> role="article">

					<header class="article-header">

						<h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<p class="small"><?php
							printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> <span class="amp">&</span> filed under %3$s.', 'dropshoptheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'dropshoptheme' ) ), get_the_category_list(', ') );
						?></p>

					</header>

					<section class="entry-content">
							<?php the_excerpt( '<span class="read-more">' . __( 'Read more &raquo;', 'dropshoptheme' ) . '</span>' ); ?>

					</section>

					<footer class="article-footer">

					</footer>

				</article>

			<?php endwhile; ?>

					<?php if (function_exists('dropshop_page_navi')) { ?>
							<?php dropshop_page_navi(); ?>
					<?php } else { ?>
							<nav class="wp-prev-next">
									<ul class="group">
										<li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'dropshoptheme' )) ?></li>
										<li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'dropshoptheme' )) ?></li>
									</ul>
							</nav>
					<?php } ?>

				<?php else :  not_found_message(); endif; ?>

			</div>

				<?php get_sidebar(); ?>

		</div>

<?php get_footer(); ?>
