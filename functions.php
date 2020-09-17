<?php
add_action( 'wp_enqueue_scripts', 'extra_child_enqueue_styles' );
function extra_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
}

function extra_child_display_single_post_meta() {
	$post_meta_options = et_get_option( 'extra_postinfo2', array(
		'author',
		'date',
		'categories',
		'comments',
		'rating_stars',
	) );

	$meta_args = array(
		'author_link'    => in_array( 'author', $post_meta_options ),
		'author_link_by' => et_get_safe_localization( __( 'Posted by %s', 'extra' ) ),
		'post_date'      => in_array( 'date', $post_meta_options ),
		'categories'     => in_array( 'categories', $post_meta_options ),
		'comment_count'  => in_array( 'comments', $post_meta_options ),
		'rating_stars'   => in_array( 'rating_stars', $post_meta_options ),
	);

	return et_extra_child_display_post_meta( $meta_args );
}

function et_extra_child_display_post_meta( $args = array() ) {
	$default_args = array(
		'post_id'        => get_the_ID(),
		'author_link'    => true,
		'author_link_by' => et_get_safe_localization( __( 'by %s', 'extra' ) ),
		'post_date'      => true,
		'date_format'    => et_get_option( 'extra_date_format', '' ),
		'categories'     => true,
		'comment_count'  => true,
		'rating_stars'   => true,
	);

	$args = wp_parse_args( $args, $default_args );

	$meta_pieces = array();

	if ( $args['author_link'] ) {
		$meta_pieces[] = sprintf( $args['author_link_by'], extra_child_get_post_author_link( $args['post_id'] ) );
	}

	if ( $args['post_date'] ) {
		$meta_pieces[] = extra_get_the_post_date( $args['post_id'], $args['date_format'] );
	}

	if ( $args['categories'] ) {
		$meta_piece_categories = extra_get_the_post_categories( $args['post_id'] );
		if ( !empty( $meta_piece_categories ) ) {
			$meta_pieces[] = $meta_piece_categories;
		}
	}

	if ( $args['comment_count'] ) {
		$meta_piece_comments = extra_get_the_post_comments_link( $args['post_id'] );
		if ( !empty( $meta_piece_comments ) ) {
			$meta_pieces[] = $meta_piece_comments;
		}
	}

	if ( $args['rating_stars'] && extra_is_post_rating_enabled( $args['post_id'] ) ) {
		$meta_piece_rating_stars = extra_get_post_rating_stars( $args['post_id'] );
		if ( !empty( $meta_piece_rating_stars ) ) {
			$meta_pieces[] = $meta_piece_rating_stars;
		}
	}

	$output = implode( ' | ', $meta_pieces );

	return $output;
}

function extra_child_get_post_author_link( $post_id = 0 ) {
    
    if (!function_exists('get_multiple_authors')) {
        return extra_get_post_author_link($post_id);
    }

    
    $post_id = empty( $post_id ) ? get_the_ID() : $post_id;
    
    ob_start();
    do_action('pp_multiple_authors_show_author_box', false, 'inline', false, true, $post_id);
    $output = ob_get_clean();
        
	return $output;
}

function extra_child_display_archive_post_meta() {
	$post_meta_options = et_get_option( 'extra_postinfo1', array(
		'author',
		'date',
		'categories',
		'comments',
		'rating_stars',
	) );

	$meta_args = array(
		'author_link'    => in_array( 'author', $post_meta_options ),
		'author_link_by' => et_get_safe_localization( __( 'Posted by %s', 'extra' ) ),
		'post_date'      => in_array( 'date', $post_meta_options ),
		'categories'     => in_array( 'categories', $post_meta_options ),
		'comment_count'  => in_array( 'comments', $post_meta_options ),
		'rating_stars'   => in_array( 'rating_stars', $post_meta_options ),
	);

	return et_extra_child_display_post_meta( $meta_args );
}