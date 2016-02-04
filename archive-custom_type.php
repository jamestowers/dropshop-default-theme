<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="group">

						<div id="main" class="col8 group" role="main">

						<h1 class="page-title"><?php post_type_archive_title(); ?></h1>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'group' ); ?> role="article">

								<header class="article-header">

									<h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.', 'dropshoptheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'dropshoptheme' ) ), dropshop_get_the_author_posts_link());
									?></p>

								</header>

								<section class="entry-content group">

									<?php the_excerpt(); ?>

								</section>

								<footer class="article-footer">

								</footer>

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

								<?php else :

										// If no content, include the "No posts found" template: content-none.php
						        get_template_part( 'content', 'none' );

								endif; ?>

						</div>

						<?php get_sidebar(); ?>

								</div>

			</div>

<?php get_footer(); ?>
