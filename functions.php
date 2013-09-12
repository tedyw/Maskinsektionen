<?php
/**
 * This makes the child theme work. If you need any
 * additional features or let's say menus, do it here.
 *
 * @return void
 */
function required_starter_themesetup() {

	load_child_theme_textdomain( 'requiredstarter', get_stylesheet_directory() . '/languages' );
	load_child_theme_textdomain( 'requiredfoundation', get_stylesheet_directory() . '/languages' );

	// Register an additional Menu Location
	register_nav_menus( array(
		'meta' => __( 'Meta Menu', 'requiredstarter' )
	) );

	// Add support for custom backgrounds and overwrite the parent backgorund color
	add_theme_support( 'custom-background', array( 'default-color' => 'f7f7f7' ) );

}
add_action( 'after_setup_theme', 'required_starter_themesetup' );


/**
 * With the following function you can disable theme features
 * used by the parent theme without breaking anything. Read the
 * comments on each and follow the link, if you happen to not
 * know what the function is for. Remove the // in front of the
 * remove_theme_support('...'); calls to make them execute.
 *
 * @return void
 */
function required_starter_after_parent_theme_setup() {

	/**
	 * Hack added: 2012-10-04, Silvan Hagen
	 *
	 * This is a hack, to calm down PHP Notice, since
	 * I'm not sure if it's a bug in WordPress or my
	 * bad I'll leave it here: http://wordpress.org/support/topic/undefined-index-custom_image_header-in-after_setup_theme-of-child-theme
	 */
	if ( ! isset( $GLOBALS['custom_image_header'] ) )
		$GLOBALS['custom_image_header'] = array();

	if ( ! isset( $GLOBALS['custom_background'] ) )
		$GLOBALS['custom_background'] = array();

	// Remove custom header support: http://codex.wordpress.org/Custom_Headers
	remove_theme_support( 'custom-header' );

	// Remove support for post formats: http://codex.wordpress.org/Post_Formats
	//remove_theme_support( 'post-formats' );

	// Remove featured images support: http://codex.wordpress.org/Post_Thumbnails
	//remove_theme_support( 'post-thumbnails' );

	// Remove custom background support: http://codex.wordpress.org/Custom_Backgrounds
	//remove_theme_support( 'custom-background' );

	// Remove automatic feed links support: http://codex.wordpress.org/Automatic_Feed_Links
	//remove_theme_support( 'automatic-feed-links' );

	// Remove editor styles: http://codex.wordpress.org/Editor_Style
	//remove_editor_styles();

	// Remove a menu from the theme: http://codex.wordpress.org/Navigation_Menus
	//unregister_nav_menu( 'secondary' );

	update_option('thumbnail_size_w', 480);
	update_option('thumbnail_size_h', 480);
	update_option('thumbnail_crop', 1);
	add_image_size( 'square', 640, 640, true );
	add_image_size( 'wide', 640, 320, true );

	require_once("marketpress-functions.php");

}
add_action( 'after_setup_theme', 'required_starter_after_parent_theme_setup', 11 );

/**
 * Add our theme specific js file and some Google Fonts
 * @return void
 */
function required_starter_scripts() {

	/**
	 * Registers the child-theme.js
	 *
	 * Remove if you don't need this file,
	 * it's empty by default.
	 */
	wp_register_script(
		'machine-js',
		get_stylesheet_directory_uri() . '/javascripts/machine.min.js',
		array( 'theme-js' ),
		required_get_theme_version( false ),
		true
	);

	if ( is_front_page() || is_page_template('timer.php') || is_page_template('maintenance.php') ) {
    	wp_enqueue_script('machine-js');
  	}

	/**
	 * Registers the app.css
	 *
	 * If you don't need it, remove it.
	 * The file is empty by default.
	 */
	wp_register_style(
        'app-css', //handle
        get_stylesheet_directory_uri() . '/stylesheets/app.css',
        array( 'foundation-css' ),	// needs foundation
        required_get_theme_version( false ) //version
  	);
  	wp_enqueue_style( 'app-css' );

	/**
	 * Adding google fonts
	 *
	 * This is the proper code to add google fonts
	 * as seen in TwentyTwelve
	 */
	$protocol = is_ssl() ? 'https' : 'http';
	$query_args = array( 'family' => 'Open+Sans:300italic,800,300' );
	wp_enqueue_style(
		'open-sans',
		add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ),
		array(),
		null
	);
}
add_action('wp_enqueue_scripts', 'required_starter_scripts');

/**
 * Overwrite the default continue reading link
 *
 * This function is an example on how to overwrite
 * the parent theme function to create continue reading
 * links.
 *
 * @return string HTML link with text and permalink to the post/page/cpt
 */
function required_continue_reading_link() {
	return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( ' Read on! &rarr;', 'requiredstarter' ) . '</a>';
}

/**
 * Overwrite the defaults of the Orbit shortcode script
 *
 * Accepts all the parameters from http://foundation.zurb.com/docs/orbit.php#optCode
 * to customize the options for the orbit shortcode plugin.
 *
 * @param  array $args default args
 * @return array       your args
 */
function required_orbit_script_args( $defaults ) {
	$args = array(
		'animation' 	=> 'fade',
		'advanceSpeed' 	=> 8000,
	);
	return wp_parse_args( $args, $defaults );
}
add_filter( 'req_orbit_script_args', 'required_orbit_script_args' );

/**
 * class required_walker
 *
 * Custom output to enable the the ZURB Navigation style.
 * Courtesy of Kriesi.at. http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
 *
 * @since  required+ Foundation 0.1.0
 *
 * @return string the code of the full navigation menu
 */
class REQ_Moment_Walker extends Walker_Nav_Menu {

	/**
	 * Specify the item type to allow different walkers
	 * @var array
	 */
	var $nav_bar = '';

	function __construct( $nav_args = '' ) {

		$defaults = array(
			'item_type' => 'li',
			'in_top_bar' => false,
		);
		$this->nav_bar = apply_filters( 'req_nav_args', wp_parse_args( $nav_args, $defaults ) );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$title = sanitize_title($item->title);

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID . ' menu-item-' . $title;

		// Check for flyout
		$flyout_toggle = '';
		if ( $args->has_children && $this->nav_bar['item_type'] == 'li' ) {

			if ( $depth == 0 && $this->nav_bar['in_top_bar'] == false ) {

				$classes[] = 'has-flyout';
				$flyout_toggle = '<a href="#" class="flyout-toggle"><span></span></a>';

			} else if ( $this->nav_bar['in_top_bar'] == true ) {

				$classes[] = 'has-dropdown';
				$flyout_toggle = '';
			}

		}
        /**
         * Add class names to the li.divider from parent menu item
         * @var string
         *
         * @since  required+ Foundation 1.0.7
         */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( $depth > 0 ) {
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		} else {
			$output .= $indent . '<' . $this->nav_bar['item_type'] . ' id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		}

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output  = $args->before;
		$item_output .= '<a '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $flyout_toggle; // Add possible flyout toggle
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( $depth > 0 ) {
			$output .= "</li>\n";
		} else {
			$output .= "</" . $this->nav_bar['item_type'] . ">\n";
		}
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		if ( $depth == 0 && $this->nav_bar['item_type'] == 'li' ) {
			$indent = str_repeat("\t", 1);
    		$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"flyout\">\n";
    	} else {
			$indent = str_repeat("\t", $depth);
    		$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"level-$depth\">\n";
		}
  	}
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own required_posted_on to override in a child theme
 *
 * @since required+ Foundation 0.3.0
 */
function required_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'maskinsektionen' ),
		esc_url( get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'requiredfoundation' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}

function custom_post_organisation() {
	register_post_type( 'organisation',
		array(
			'labels' => array(
				'name' => __( 'Organisations' ),
				'singular_name' => __( 'Organisation' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'organisations'),
			'taxonomies' => array('organisation_type'),
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' )
		)
	);
}
add_action( 'init', 'custom_post_organisation' );

function custom_post_document() {
	register_post_type( 'document',
		array(
			'labels' => array(
				'name' => __( 'Documents' ),
				'singular_name' => __( 'Document' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'documents'),
			'taxonomies' => array('document_type'),
			'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'page-attributes' )
		)
	);
}
add_action( 'init', 'custom_post_document' );

function custom_post_superior() {
	register_post_type( 'superior',
		array(
			'labels' => array(
				'name' => __( 'Superiors' ),
				'singular_name' => __( 'Superior' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'superiors'),
			'supports' => array( 'title', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes' )
		)
	);
}
add_action( 'init', 'custom_post_superior' );

function create_custom_taxonomies() {

	$document_labels = array(
		'name'              => _x( 'Document Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Document Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Document Categories' ),
		'all_items'         => __( 'All Document Categories' ),
		'parent_item'       => __( 'Parent Document Category' ),
		'parent_item_colon' => __( 'Parent Document Category:' ),
		'edit_item'         => __( 'Edit Document Category' ), 
		'update_item'       => __( 'Update Document Category' ),
		'add_new_item'      => __( 'Add New Document Category' ),
		'new_item_name'     => __( 'New Document Category' ),
		'menu_name'         => __( 'Document Categories' ),
	);

	$document_args = array(
		'hierarchical'      => true,
		'labels'            => $document_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'document' ),
	);

	register_taxonomy( 'document_category', array( 'document' ), $document_args );
}
add_action( 'init', 'create_custom_taxonomies', 0 );

/**
 * Initialize the sponsor type
 * 
 * @action init
 */
function roots_sponsor_init(){
	$labels = array(
		'name' => _x('Sponsors', 'post type general name', 'roots'),
		'singular_name' => _x('Sponsor', 'post type singular name', 'roots'),
		'add_new' => _x('Add New', 'book', 'roots'),
		'add_new_item' => __('Add New Sponsor', 'roots'),
		'edit_item' => __('Edit Sponsor', 'roots'),
		'new_item' => __('New Sponsor', 'roots'),
		'all_items' => __('All Sponsors', 'roots'),
		'view_item' => __('View Sponsor', 'roots'),
		'search_items' => __('Search Sponsors', 'roots'),
		'not_found' =>  __('No sponsors found', 'roots'),
		'not_found_in_trash' => __('No sponsors found in Trash', 'roots'),
		'parent_item_colon' => '',
		'menu_name' => __('Sponsors', 'roots')
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')
	);

	register_post_type('sponsor', $args);
	
	// Now register the skills taxonomy
}
add_action('init', 'roots_sponsor_init');

/**
 * Initialize the steward type
 * 
 * @action init
 */
function roots_steward_init(){
	$labels = array(
		'name' => _x('Stewards', 'post type general name', 'roots'),
		'singular_name' => _x('Steward', 'post type singular name', 'roots'),
		'add_new' => _x('Add New', 'book', 'roots'),
		'add_new_item' => __('Add New Steward', 'roots'),
		'edit_item' => __('Edit Steward', 'roots'),
		'new_item' => __('New Steward', 'roots'),
		'all_items' => __('All Stewards', 'roots'),
		'view_item' => __('View Steward', 'roots'),
		'search_items' => __('Search Stewards', 'roots'),
		'not_found' =>  __('No stewards found', 'roots'),
		'not_found_in_trash' => __('No stewards found in Trash', 'roots'),
		'parent_item_colon' => '',
		'menu_name' => __('Stewards', 'roots')
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'author', 'excerpt' )
	);

	register_post_type('steward', $args);
	
	// Now register the skills taxonomy
}
add_action('init', 'roots_steward_init');

/**
 * Initialize the board member type
 * 
 * @action init
 */
function roots_board_member_init(){
	$labels = array(
		'name' => _x('Board members', 'post type general name', 'roots'),
		'singular_name' => _x('Board member', 'post type singular name', 'roots'),
		'add_new' => _x('Add New', 'book', 'roots'),
		'add_new_item' => __('Add New Board member', 'roots'),
		'edit_item' => __('Edit Board member', 'roots'),
		'new_item' => __('New Board member', 'roots'),
		'all_items' => __('All Board members', 'roots'),
		'view_item' => __('View Board member', 'roots'),
		'search_items' => __('Search Board members', 'roots'),
		'not_found' =>  __('No board members found', 'roots'),
		'not_found_in_trash' => __('No board members found in Trash', 'roots'),
		'parent_item_colon' => '',
		'menu_name' => __('Board members', 'roots')
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
	);

	register_post_type('board_member', $args);
	
	// Now register the skills taxonomy
}
add_action('init', 'roots_board_member_init');
