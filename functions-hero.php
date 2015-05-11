<?php

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'hero-image-tablet-retina', 2200, 720, true );
add_image_size( 'hero-image-desktop', 1440, 380, true );
add_image_size( 'hero-image-tablet', 1100, 340, true );
add_image_size( 'hero-image-mobile-retina', 750, 1000, true );
add_image_size( 'hero-image-mobile', 350, 500, true );
add_image_size( 'hero-image-thumbnail', 400, 400, true );


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

function dropshop_using_custom_featured_image_metabox_plugin() {
  return method_exists('Custom_Featured_Image_Metabox', 'get_instance');
}

function dropshop_hero_image(){
  global $post;
  // If we are using the custom-featured-image-metabox plugin we can check to see if the hero image has been enabled on this post/page
  if( dropshop_using_custom_featured_image_metabox_plugin() && get_post_meta($post->ID, 'enable_cover_image', true) !== '1'){
    return;
  }
  
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
?>