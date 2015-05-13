<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section <?php post_class( ); ?> >
        
        <?php dropshop_hero_image( $banner_text = "" );?>

        <div class="inner pad group">

    		<h1 class="page-title"><?php the_title(); ?></h1>

    		<div class="entry-content group">
    			<?php the_content(); ?>
    		</div>

        </div> <!-- close inner -->

    </section>

	<?php endwhile; ?>

  <?php else : ?>

    <?php not_found_message();?>

  <?php endif; ?>


<?php get_footer(); ?>
