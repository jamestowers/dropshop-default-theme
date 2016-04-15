<article id="post-<?php the_ID(); ?>" <?php post_class( 'group' ); ?> role="article">

  <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="thumbnail col3">
    <?php the_post_thumbnail(  ); ?> 
  </a>

  <div class="post-content col9 pull-right last">

    <h2 class="page-title">
      <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>

    <div class="entry-content group">
      <?php the_excerpt(); ?>
    </div>

    <?php get_template_part('partials/news-footer');?>

  </div>

  <?php // comments_template(); // uncomment if you want to use them ?>

</article>