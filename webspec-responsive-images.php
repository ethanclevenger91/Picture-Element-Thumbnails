<?php
/**
 * Plugin Name: Wordpress Picture Elements
 * Version: 1.0.0
 * Description: Add functions for using the <picture> element for WP featured images
 */

class WPPictureElement {
	function __construct() {
		//nothing right now
	}

	function wp_enqueue_scripts() {
		wp_enqueue_script('picturefill', plugins_url('bower_components/picturefill/dist/picturefill.min.js'));
	}

	function get_img_alt( $image ) {
	    $img_alt = trim( strip_tags( get_post_meta( $image, '_wp_attachment_image_alt', true ) ) );
	    return $img_alt;
	}

	function get_picture_srcs( $image, $sizes ) {
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		global $_wp_additional_image_sizes;
		$newSizes = array();
        $intermediate_image_sizes = $sizes;

        // Create the full array with sizes and crop info
        foreach( $intermediate_image_sizes as $breakpoint => $_size ) {

            if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
            	$newSizes[ $_size ][ 'breakpoint' ] = $breakpoint;
                $newSizes[ $_size ][ 'width' ] = get_option( $_size . '_size_w' );
                $newSizes[ $_size ][ 'height' ] = get_option( $_size . '_size_h' );
                $newSizes[ $_size ][ 'crop' ] = (bool) get_option( $_size . '_crop' );

            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
                $newSizes[ $_size ] = array( 
                	'breakpoint' => $breakpoint,
                    'width' => $_wp_additional_image_sizes[ $_size ][ 'width' ],
                    'height' => $_wp_additional_image_sizes[ $_size ][ 'height' ],
                    'crop' =>  $_wp_additional_image_sizes[ $_size ][ 'crop' ]
                );
            }
    	}
	    $arr = array();
	    foreach ( $newSizes as $size => $details ) {
	        $image_src = wp_get_attachment_image_src( $image, $size );
	        $arr[] = '<source srcset="'. $image_src[0] . '" media="'.$details['breakpoint'].'">';
	    }
	    return implode( array_reverse ( $arr ) );
	}
}
$WPPictureElement = new WPPictureElement();

function the_post_picture($default = 'thumbnail', $sizes=false, $id='') {
	echo get_picture_element($default, $sizes, $id);
}

//get picture element for post thumbnail
function get_the_post_picture($default = 'thumbnail', $sizes=false, $id='') {
	if($id == '') {
		global $post;
		$id = $post->ID;
	}
	$id = get_post_thumbnail_id($id);
	return get_picture_element($default, $sizes, $id);
}

//get picture element for an attachment
function get_picture_element($default = 'thumbnail', $sizes=false, $id) {
	if(!$sizes) {
		return get_the_post_thumbnail($id, $default);
	}
	//Add video tags for IE9? http://scottjehl.github.io/picturefill/#ie9
	return '<picture>'
			. '<!--[if IE 9]><video style="display: none;"><![endif]-->'
            . WPPictureElement::get_picture_srcs( $id, $sizes )
            . '<!--[if IE 9]></video><![endif]-->'
            . '<img srcset="' . wp_get_attachment_image_src( $id, $default)[0] . '" alt="' . WPPictureElement::get_img_alt( $id ) . '">
        </picture>';
}
