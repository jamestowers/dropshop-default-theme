<?php get_header(); ?>

	<div id="main" class="twelvecolcol box clearfix" role="main">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

			<header>
				<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
			</header>

			<section class="entry-content clearfix" itemprop="articleBody">
				<?php the_content(); ?>
			</section>

			<footer class="article-footer"></footer>


		</article>

		<?php endwhile; endif; ?>

	</div>


<?php get_footer(); ?>
