<?php

require ('functions-cleanup.php');

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'featured-image-desktop', 1440, 380, true );
add_image_size( 'featured-image-tablet-retina', 2200, 720, true );
add_image_size( 'featured-image-tablet', 1100, 340, true );
add_image_size( 'featured-image-mobile-retina', 640, 340, true );
add_image_size( 'featured-image-mobile', 320, 220, true );
add_image_size( 'featured-image-thumbnail', 400, 400, true );

/*
<?php the_post_thumbnail( 'dropshop-thumb-300' ); ?>
*/


/*
The function above adds the ability to use the dropdown menu to select 
the new images sizes you have just created from within the media manager 
when you add media to your content blocks. If you add more image sizes, 
duplicate one of the lines in the array and name it according to your 
new image size.
*/
add_filter( 'image_size_names_choose', 'dropshop_custom_image_sizes' );

function dropshop_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
      'featured-image-desktop' => __('1440px by 380px'),
      'featured-image-tablet-retina' => __('2200px by 720px'),
      'featured-image-tablet' => __('1100px by 340px'),
      'featured-image-mobile-retina' => __('640px by 340px'),
      'featured-image-mobile' => __('320px by 220px'),
      'featured-image-thumbnail' => __('400px by 400px')
    ) );
}












/*********************
CUSTOM TAXONOMY
*********************/
function add_clients_taxonomy() {
  // create a new taxonomy
  register_taxonomy(
    'clients',
    array('post', 'case_study'),
    array(
      'label' => __( 'Clients' ),
      'rewrite' => array( 'slug' => 'client' ),
      'hierarchical' => true
    )
  );
}
add_action( 'init', 'add_clients_taxonomy' );











/*********************
SCRIPTS & ENQUEUEING
*********************/

// Load jQuery
if ( !function_exists( 'core_mods' ) ) {
  function core_mods() {
    if ( !is_admin() ) {
      wp_deregister_script( 'jquery' );
      wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/library/js/vendor/modernizr.custom.min.js', array(), '2.5.3', false );
      
      wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", '', '' , true);
      wp_register_script( 'scripts', get_bloginfo('template_directory') . "/library/js/scripts.js", 'jquery', '', true);

      wp_enqueue_script( 'modernizr' );
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'scripts');
    }
  }
  add_action( 'wp_enqueue_scripts', 'core_mods' );
}


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
MENUS & NAVIGATION
*********************/

function dropshop_theme_support() {
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size(125, 125, true);
  add_theme_support('automatic-feed-links');
  add_theme_support( 'menus' );
  
  register_nav_menus(
    array(
      'nav-header' => __( 'Header Nav', 'dropshoptheme' ),   // main nav in header
      'nav-footer' => __( 'Footer Nav', 'dropshoptheme' ) // secondary nav in footer
    )
  );
}

// the main menu
function dropshop_nav_header() {
  // display the wp3 menu if available
  wp_nav_menu(array(
    'container' => false,                           // remove nav container
    'container_class' => 'menu group',           // class of container (should you choose to use it)
    'menu' => __( 'Header Nav', 'dropshoptheme' ),  // nav name
    'menu_class' => 'nav group',         // adding custom nav class
    'theme_location' => 'nav-header',                 // where it's located in the theme
    'before' => '',                                 // before the menu
    'after' => '',                                  // after the menu
    'link_before' => '',                            // before each link
    'link_after' => '',                             // after each link
    'depth' => 3,                                   // limit the depth of the nav
    'fallback_cb' => 'dropshop_main_nav_fallback'      // fallback function
  ));
} /* end dropshop main nav */

// the footer menu (should you choose to use one)
function dropshop_nav_footer() {
  // display the wp3 menu if available
  wp_nav_menu(array(
    'container' => 'false',                              // remove nav container
    'container_class' => 'footer-nav group',   // class of container (should you choose to use it)
    'menu' => __( 'Footer Nav', 'dropshoptheme' ),   // nav name
    'menu_class' => 'nav group',      // adding custom nav class
    'theme_location' => 'nav-footer',             // where it's located in the theme
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
SIDEBARS / WIDGETS
*********************/

// Sidebars & Widgetizes Areas
function dropshop_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar',
		'name' => __( 'Sidebar', 'dropshoptheme' ),
		'description' => __( 'The first (primary) sidebar.', 'dropshoptheme' ),
		'before_widget' => '<aside id="%1$s" class="widget box %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

	
	register_sidebar(array(
		'id' => 'footer-sidebar',
		'name' => __( 'Footer Widgets', 'dropshoptheme' ),
		'description' => __( 'Room for 3 widgets just above the footer on every page', 'dropshoptheme' ),
		'before_widget' => '<aside id="%1$s" class="widget box %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
} // don't remove this bracket!











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
      'base'      => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
      'format'    => '',
      'current'     => max( 1, get_query_var('paged') ),
      'total'     => $wp_query->max_num_pages,
      'prev_text'   => '&larr;',
      'next_text'   => '&rarr;',
      'type'      => 'list',
      'end_size'    => 3,
      'mid_size'    => 3
    ) );
  
  echo '</nav>';
} /* end page navi */









/*********************
DEBUGGING
*********************/

if(!function_exists('log_it')){
	function log_it( $message ) {
		if( WP_DEBUG === true ){
			if( is_array( $message ) || is_object( $message ) ){
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}

?>
