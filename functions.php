<?php

require ('functions-cleanup.php');
require ('functions-options-page.php');

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'hero-image-tablet-retina', 2200, 720, true );
add_image_size( 'hero-image-desktop', 1440, 380, true );
add_image_size( 'hero-image-tablet', 1100, 340, true );
add_image_size( 'hero-image-mobile-retina', 750, 1000, true );
add_image_size( 'hero-image-mobile', 350, 500, true );
add_image_size( 'hero-image-thumbnail', 400, 400, true );


set_post_thumbnail_size( '400', '400', true ); 
/*
<?php the_post_thumbnail( 'dropshop-thumb-300' ); ?>
*/


/*
The function below adds the ability to use the dropdown menu to select 
the new images sizes you have just created from within the media manager 
when you add media to your content blocks. If you add more image sizes, 
duplicate one of the lines in the array and name it according to your 
new image size.
*/
add_filter( 'image_size_names_choose', 'dropshop_custom_image_sizes' );

function dropshop_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
      //'hero-image-tablet-retina' => __('2200px by 720px'),
      'hero-image-desktop' => __('1440px by 380px'),
      'hero-image-tablet-landscape' => __('1100px by 340px'),
      'hero-image-mobile-retina' => __('750px by 1000px'),
      'hero-image-mobile' => __('350px by 500px'),
      'hero-image-thumbnail' => __('400px by 400px')
    ) );
}









/*********************
HERO IMAGE
*********************/
function dropshop_get_img_alt( $image ) {
    $img_alt = trim( strip_tags( get_post_meta( $image, '_wp_attachment_image_alt', true ) ) );
    return $img_alt;
}

function dropshop_get_picture_srcs( $image, $mappings ) {
    $arr = array();
    foreach ( $mappings as $size => $type ) {
        $image_src = wp_get_attachment_image_src( $image, $type );
        $arr[] = '<source srcset="'. $image_src[0] . '" media="(min-width: '. $size .'px)">';
    }
    return implode( array_reverse ( $arr ) );
}

function dropshop_responsive_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'imageid'    => 1,
        // You can add more sizes for your shortcodes here
        'size1' => 0,
        'size2' => 400,
        'size3' => 800,
        'size4' => 1200,
    ), $atts ) );

    $mappings = array(
        $size1 => 'hero-image-mobile',
        $size2 => 'hero-image-tablet-portrait',
        $size3 => 'hero-image-tablet-landscape',
        $size4 => 'hero-image-desktop',
    );

   return
        '<picture>
            <!--[if IE 9]><video style="display: none;"><![endif]-->'
            . dropshop_get_picture_srcs( $imageid, $mappings ) .
            '<!--[if IE 9]></video><![endif]-->
            <img srcset="' . wp_get_attachment_image_src( $imageid[0] ) . '" alt="' . dropshop_get_img_alt( $imageid ) . '">
            <noscript>' . wp_get_attachment_image( $imageid, $mappings[0] ) . ' </noscript>
        </picture>';
}

add_shortcode( 'responsive', 'dropshop_responsive_shortcode' );
/* in post use:
  $image_id = get_post_thumbnail_id( $post->ID );
  echo do_shortcode('[responsive imageid="'.$image_id.'"]');
*/

function dropshop_hero_image(){
  global $post;
  if ( has_post_thumbnail() || function_exists('get') && get('hero_video') != '') { ?>
    
    <div class="hero-container">

    <?php 
      if(function_exists('get') && get('hero_video') != '' ){
        $vid_url = get('hero_video');
        if($vid_url != ''){

          echo '<div class="video-wrapper">';
            echo '<iframe id="vimeo-player" data-video-id="' . dropshop_get_vimeoid_from_url($vid_url) . '" src="" width="1000" height="562" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
          echo '</div>';

          echo '<ul class="vimeo-controls">';
            echo '<li><a href="" class="icon-unmute no-ajaxy" title="Unmute"></a></li>';
            echo '<li><a href="' . $vid_url . '" class="icon-vimeo no-ajaxy" title="View on Vimeo" target="_blank"></a></li>';
          echo '</ul>';
        }
      }
      if ( has_post_thumbnail() ) {
        $image_id = get_post_thumbnail_id( $post->ID );
        echo do_shortcode('[responsive imageid="'.$image_id.'"]');
      }
    ?>

    </div>

  <?php }
}

function dropshop_get_vimeoid_from_url( $url ) {
  $regex = '~
    # Match Vimeo link and embed code
    (?:<iframe [^>]*src=")?         # If iframe match up to first quote of src
    (?:                             # Group vimeo url
        https?:\/\/             # Either http or https
        (?:[\w]+\.)*            # Optional subdomains
        vimeo\.com              # Match vimeo.com
        (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
        \/                      # Slash before Id
        ([0-9]+)                # $1: VIDEO_ID is numeric
        [^\s]*                  # Not a space
    )                               # End group
    "?                              # Match end quote if part of src
    (?:[^>]*></iframe>)?            # Match the end of the iframe
    (?:<p>.*</p>)?                  # Match any title information stuff
    ~ix';
  
  preg_match( $regex, $url, $matches );
  
  return $matches[1];
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
if ( !function_exists( 'dropshop_load_scripts' ) ) {
  function dropshop_load_scripts() {
    if ( !is_admin() ) {
      wp_deregister_script( 'jquery' );
      wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/library/js/vendor/modernizr.custom.min.js', array(), '2.5.3', false );
      
      wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", '', '' , true);
      wp_register_script( 'picturefill', get_bloginfo('template_directory') . "/library/js/vendor/picturefill.min.js", 'jquery', '', true);
      wp_register_script( 'fastclick', get_bloginfo('template_directory') . "/library/js/vendor/fastclick.js", 'jquery', '', true);
      wp_register_script( 'history', get_bloginfo('template_directory') . "/library/js/vendor/jquery.history.js", array('jquery'), '', true);
      wp_register_script( 'ajaxify', get_bloginfo('template_directory') . "/library/js/vendor/ajaxify-html5.js", array('jquery', 'picturefill', 'history'), '', true);
      wp_register_script( 'dropshop', get_bloginfo('template_directory') . "/library/js/dropshop.js", array('jquery', 'picturefill', 'ajaxify'), '', true);
      wp_register_script( 'scripts', get_bloginfo('template_directory') . "/library/js/scripts.js", array('dropshop', 'fastclick'), '', true);

      wp_enqueue_script( 'modernizr' );
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'fastclick' );
      wp_enqueue_script( 'picturefill' );
      wp_enqueue_script( 'dropshop' );
      wp_enqueue_script( 'scripts');
    }
  }
  add_action( 'wp_enqueue_scripts', 'dropshop_load_scripts' );
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









function not_found_message(){ ?>

  <article id="post-not-found" class="hentry group">
    <h1><?php _e( 'Oops, Post Not Found!', 'dropshoptheme' ); ?></h1>
      <section class="entry-content">
        <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'dropshoptheme' ); ?></p>
    </section>
    <footer class="article-footer">
        <p><?php _e( 'This is the error message in the index.php template.', 'dropshoptheme' ); ?></p>
    </footer>
  </article>

<?php }











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
