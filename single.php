<?php get_header(); ?>

	<?php dropshop_hero_image();?>
	
	<div class="inner">

		<div id="main" class="col8 group pad" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

					<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
					<p class="small"><?php
						printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> <span class="amp">&amp;</span> filed under %3$s.', 'dropshoptheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), get_the_category_list(', ') );
					?></p>


					<section class="entry-content group" itemprop="articleBody">
						<?php the_content(); ?>
					</section>

					<footer class="article-footer small">
						<?php dropshop_share_buttons();?>
						<?php the_tags( '<p class="tags pull-right"><span class="tags-title">' . __( 'Tags:', 'dropshoptheme' ) . '</span> ', ', ', '</p>' ); ?>
					</footer>

					<?php //comments_template(); ?>
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
								<p><?php _e( 'This is the error message in the single.php template.', 'dropshoptheme' ); ?></p>
						</footer>
				</article>

			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div> <!-- close inner -->

<?php get_footer(); ?>
