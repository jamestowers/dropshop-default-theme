<?php

// we're firing all out initial functions at the start
add_action( 'after_setup_theme', 'dropshop_ahoy', 16 );

function dropshop_ahoy() {

	add_action( 'init', 'dropshop_head_cleanup' );
	add_filter( 'the_generator', 'dropshop_rss_version' );
	add_filter( 'wp_head', 'dropshop_remove_wp_widget_recent_comments_style', 1 );
	add_action( 'wp_head', 'dropshop_remove_recent_comments_style', 1 );
	add_filter( 'gallery_style', 'dropshop_gallery_style' );

	add_action( 'wp_enqueue_scripts', 'dropshop_scripts_and_styles', 999 );

	dropshop_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'dropshop_register_sidebars' );

	// cleaning up random code around images
	add_filter( 'the_content', 'dropshop_filter_ptags_on_images' );
	add_filter( 'excerpt_more', 'dropshop_excerpt_more' );

} /* end dropshop ahoy */


function dropshop_head_cleanup() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'style_loader_src', 'dropshop_remove_wp_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'dropshop_remove_wp_ver_css_js', 9999 );

} /* end dropshop head cleanup */

// remove WP version from RSS
function dropshop_rss_version() { return ''; }
// remove WP version from scripts
function dropshop_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
// remove injected CSS for recent comments widget
function dropshop_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}
// remove injected CSS from recent comments widget
function dropshop_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}
// remove injected CSS from gallery
function dropshop_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// Load jQuery
if ( !function_exists( 'core_mods' ) ) {
	function core_mods() {
		if ( !is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );
			
			wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", '', '' , true);
			wp_register_script( 'scripts', get_bloginfo('template_directory') . "/library/js/scripts.js", 'jquery', '', true);

			wp_enqueue_script( 'modernizr' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'scripts');
		}
	}
	add_action( 'wp_enqueue_scripts', 'core_mods' );
}

// loading modernizr and jquery, and reply script
function dropshop_scripts_and_styles() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	if (!is_admin()) {
		wp_register_style( 'dropshop-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );
		wp_register_style( 'dropshop-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );
		
		wp_enqueue_style( 'dropshop-stylesheet' );
		wp_enqueue_style( 'dropshop-ie-only' );

		$wp_styles->add_data( 'dropshop-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet
	}
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function dropshop_theme_support() {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(125, 125, true);
	add_theme_support('automatic-feed-links');
	add_theme_support( 'menus' );
	
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'dropshoptheme' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'dropshoptheme' ) // secondary nav in footer
		)
	);
} /* end dropshop theme support */


/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function dropshop_main_nav() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'menu group',           // class of container (should you choose to use it)
		'menu' => __( 'The Main Menu', 'dropshoptheme' ),  // nav name
		'menu_class' => 'nav top-nav group',         // adding custom nav class
		'theme_location' => 'main-nav',                 // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 3,                                   // limit the depth of the nav
		'fallback_cb' => 'dropshop_main_nav_fallback'      // fallback function
	));
} /* end dropshop main nav */

// the footer menu (should you choose to use one)
function dropshop_footer_links() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => '',                              // remove nav container
		'container_class' => 'footer-links group',   // class of container (should you choose to use it)
		'menu' => __( 'Footer Links', 'dropshoptheme' ),   // nav name
		'menu_class' => 'nav footer-nav group',      // adding custom nav class
		'theme_location' => 'footer-links',             // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => 'dropshop_footer_links_fallback'  // fallback function
	));
} /* end dropshop footer link */

// this is the fallback for header menu
function dropshop_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
		'menu_class' => 'nav top-nav group',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
		'link_before' => '',                            // before each link
		'link_after' => ''                             // after each link
	) );
}

// this is the fallback for footer menu
function dropshop_footer_links_fallback() {
	/* you can put a default here if you like */
}

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using dropshop_related_posts(); )
function dropshop_related_posts() {
	echo '<ul id="dropshop-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) { 
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'dropshoptheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end dropshop related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function dropshop_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;
	
	echo '<nav class="pagination">';
	
		echo paginate_links( array(
			'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) );
	
	echo '</nav>';
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

add_filter('show_admin_bar', '__return_false');

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function dropshop_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function dropshop_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read', 'dropshoptheme' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'dropshoptheme' ) .'</a>';
}


?>
