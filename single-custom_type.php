<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>

			<div id="content" class="page group">

				<div id="main" class="col8 pad group" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?> role="article">

						<header class="article-header">

							<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
							<p class="byline vcard"><?php
								printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'dropshoptheme' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'dropshoptheme' ) ), dropshop_get_the_author_posts_link(), get_the_term_list( $post->ID, 'custom_cat', ' ', ', ', '' ) );
							?></p>

						</header>

						<section class="entry-content group">

							<?php the_content(); ?>

						</section>

						<footer class="article-footer">
							<p class="tags"><?php echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">' . __( 'Custom Tags:', 'dropshoptheme' ) . '</span> ', ', ' ) ?></p>

						</footer>

						<?php comments_template(); ?>

					</article>

					<?php endwhile; ?>

					<?php else : ?>

							<article id="post-not-found" class="hentry group">
								<header class="article-header">
									<h1><?php _e( 'Oops, Post Not Found!', 'dropshoptheme' ); ?></h1>
								</header>
								<section class="entry-content">
									<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'dropshoptheme' ); ?></p>
								</section>
								<footer class="article-footer">
										<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'dropshoptheme' ); ?></p>
								</footer>
							</article>

					<?php endif; ?>

				</div>

				<?php get_sidebar(); ?>

		</div>

<?php get_footer(); ?>
