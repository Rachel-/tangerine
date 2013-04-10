<?php

/*==================================================*/
/* Defines, includes, startup
/*==================================================*/

	define( 'TANGERINE_TEXTDOMAIN', 'tangerine' );

	include( 'settings/settings.php' );
	include( 'includes/cleanup.php' );
	include( 'includes/widgets/postslide-widget.php' );
	include( 'includes/walkers/menu_walker.php' );
	include( 'includes/walkers/comment_walker.php' );

	load_theme_textdomain( TANGERINE_TEXTDOMAIN, get_template_directory() . '/languages' );


/*==================================================*/
/* Theme Support
/*==================================================*/

	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'post-formats', array(
		'video',
		'gallery',
		'image'
	) );


/*==================================================*/
/* Image sizes
/*==================================================*/

	//set_post_thumbnail_size( 'width', 'height', 'crop' );

	//add_image_size( 'name', width, height, true );
	//add_image_size( 'name', width, height, true );
	//add_image_size( 'name', width, height, true );

	add_image_size( 'slider-large-thumbnail', get_theme_mod('tangerine_slider_width', '1000'), get_theme_mod('tangerine_slider_height', '400'), true );
	add_image_size( 'slider-medium-thumbnail', get_theme_mod('tangerine_slider_width', '1000') * 0.5 - 40, get_theme_mod('tangerine_slider_height', '400') - 40, true );


/*==================================================*/
/* Actions
/*==================================================*/

	if( ! is_admin() )
	{
		// Headers, footers, body
		add_filter( 'the_generator', 'remove_wp_version' );
		add_filter( 'body_class','browser_body_class' );
		add_filter( 'body_class','post_categories_body_class' );

		// Styles
		add_action( 'wp_enqueue_scripts', 'deregister_styles' );
		add_action( 'wp_enqueue_scripts', 'register_styles' );
		add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
		add_action( 'wp_head', 'webfont_styles' );

		// Scripts
		add_action( 'wp_enqueue_scripts', 'deregister_scripts' );
		add_action( 'wp_enqueue_scripts', 'register_scripts' );
		add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

		// Login styles
		add_action( 'login_head', 'register_login_styles' );

		// Excerpt
		add_filter( 'excerpt_length', 'excerpt_length' );
		add_filter( 'excerpt_more', 'excerpt_more' );

		// Menu
		add_filter( 'wp_nav_menu_objects', 'add_extra_menu_classes' );
	}
	else
	{
		// Styles
		add_action( 'admin_init', 'register_admin_styles' );
		add_action( 'admin_print_styles', 'enqueue_admin_styles' );

		// Scripts
		add_action( 'admin_init', 'register_admin_scripts' );
		add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );

		// Admin menu
		add_action( 'admin_menu', 'remove_menu_pages' );

		// Dashboard widgets
		add_action( 'wp_dashboard_setup', 'add_dashboard_widgets' );
		add_action( 'admin_menu', 'remove_dashboard_widgets' );

		// User
		add_filter( 'user_contactmethods', 'edit_contactmethods' );
	}

	// Widgets / Sidebars
	add_action( 'widgets_init', 'register_extra_sidebars' );
	add_action( 'widgets_init', 'register_widgets' );

	// Menus
	add_action( 'init', 'register_menus' );


/*==================================================*/
/* Headers, footers, body
/*==================================================*/

	function remove_wp_version()
	{
		return '';
	}

	// Browser name in body class
	function browser_body_class( $classes )
	{
	    global $is_gecko, $is_IE, $is_opera, $is_safari, $is_chrome;

	    if( $is_gecko )      	$classes[] = 'gecko';
	    elseif( $is_opera )  	$classes[] = 'opera';
	    elseif( $is_safari )	$classes[] = 'safari';
	    elseif( $is_chrome )	$classes[] = 'chrome';
	    elseif( $is_IE )		$classes[] = 'ie';
	    else               		$classes[] = 'unknown';

	    return $classes;
	}

	// Post category name in body class
	function post_categories_body_class( $classes )
	{
	    if( is_single() )
		{
	        global $post;
	        foreach( ( get_the_category( $post->ID ) ) as $category )
			{
	            $classes[] = 'term-' . $category->category_nicename;
	        }
	    }

	    return $classes;
	}



/*==================================================*/
/* Styles
/*==================================================*/

	// Register styles
	function register_styles()
	{
		wp_register_style( 'normalize', get_template_directory_uri() . '/stylesheets/normalize.css', '', '', 'screen' );
		wp_register_style( 'main', get_template_directory_uri() . '/stylesheets/main.css', '', '', 'screen' );
		wp_register_style( 'style', get_template_directory_uri() . '/style.css', '', '', 'screen' );
	}

	// Deregister styles
	function deregister_styles()
	{
		//wp_deregister_style();
	}

	// Enqueue styles
	function enqueue_styles()
	{
		wp_enqueue_style( 'normalize' );
		wp_enqueue_style( 'main' );
		wp_enqueue_style( 'style' );
	}

	// Login screen styles
	function register_login_styles()
	{
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'template_url' ) . '/stylesheets/login.css">';
	}

	// Register admin styles
	function register_admin_styles()
	{
		wp_register_style( 'admin-style', get_template_directory_uri() . '/stylesheets/admin.css', '', '', 'screen' );
	}

	// Enqueue / Print admin styles
	function enqueue_admin_styles()
	{
		wp_enqueue_style( 'admin-style' );
	}

	// Add specific styles
	function webfont_styles()
	{
		// Body & heading fonts
		if ( get_theme_mod('tangerine_body_font') == 'Ubuntu' || get_theme_mod('tangerine_heading_font') == 'Ubuntu' || get_theme_mod('tangerine_title_font') == 'Ubuntu' ) { echo '<link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css">'; }
		if ( get_theme_mod('tangerine_body_font') == 'Open Sans' || get_theme_mod('tangerine_heading_font') == 'Open Sans' || get_theme_mod('tangerine_title_font') == 'Ubuntu' ) { echo '<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">'; }
		if ( get_theme_mod('tangerine_body_font') == 'Autour One' || get_theme_mod('tangerine_heading_font') == 'Autour One' || get_theme_mod('tangerine_title_font') == 'Ubuntu' ) { echo '<link href="http://fonts.googleapis.com/css?family=Autour+One" rel="stylesheet" type="text/css">'; }
		if ( get_theme_mod('tangerine_body_font') == 'Dosis' || get_theme_mod('tangerine_heading_font') == 'Dosis' || get_theme_mod('tangerine_title_font') == 'Ubuntu' ) { echo '<link href="http://fonts.googleapis.com/css?family=Dosis" rel="stylesheet" type="text/css">'; }

		// Heading & title fonts
		if ( get_theme_mod('tangerine_title_font') == 'Caesar Dressing' || get_theme_mod('tangerine_heading_font') == 'Caesar Dressing' ) { echo '<link href="http://fonts.googleapis.com/css?family=Caesar+Dressing" rel="stylesheet" type="text/css">'; }
		if ( get_theme_mod('tangerine_title_font') == 'Oleo Script' || get_theme_mod('tangerine_heading_font') == 'Oleo Script' ) { echo '<link href="http://fonts.googleapis.com/css?family=Oleo+Script" rel="stylesheet" type="text/css">'; }
		if ( get_theme_mod('tangerine_title_font') == 'Codystar' || get_theme_mod('tangerine_heading_font') == 'Codystar' ) { echo '<link href="http://fonts.googleapis.com/css?family=Codystar" rel="stylesheet" type="text/css">'; }
		if ( get_theme_mod('tangerine_title_font') == 'Dosis' || get_theme_mod('tangerine_heading_font') == 'Dosis' ) { echo '<link href="http://fonts.googleapis.com/css?family=Dosis" rel="stylesheet" type="text/css">'; }
		if ( get_theme_mod('tangerine_title_font') == 'Autour One' || get_theme_mod('tangerine_heading_font') == 'Autour One' ) { echo '<link href="http://fonts.googleapis.com/css?family=Autour+One" rel="stylesheet" type="text/css">'; }
	}


/*==================================================*/
/* Scripts
/*==================================================*/

	// Deregister scripts
	function deregister_scripts()
	{
		//wp_deregister_script( 'jquery' );
		//wp_deregister_script( 'jquery-ui-core' );
	}

	// Register scripts
	function register_scripts()
	{
		wp_register_script( 'modernizr', get_template_directory_uri() . '/javascripts/extras/custom.modernizr.js', array( 'jquery' ), '', false );
		wp_register_script( 'foundation', get_template_directory_uri() . '/javascripts/foundation/foundation.js', array( 'jquery' ), '', true );
		wp_register_script( 'clearing', get_template_directory_uri() . '/javascripts/foundation/foundation.clearing.js', array( 'jquery' ), '', true );
		wp_register_script( 'orbit', get_template_directory_uri() . '/javascripts/foundation/foundation.orbit.js', array( 'jquery' ), '', true );
		wp_register_script( 'placeholder', get_template_directory_uri() . '/javascripts/foundation/foundation.placeholder.js', array( 'jquery' ), '', true );
		wp_register_script( 'topbar', get_template_directory_uri() . '/javascripts/foundation/foundation.topbar.js', array( 'jquery' ), '', true );
		wp_register_script( 'dropdown', get_template_directory_uri() . '/javascripts/foundation/foundation.dropdown.js', array( 'jquery' ), '', true );
		wp_register_script( 'forms', get_template_directory_uri() . '/javascripts/foundation/foundation.forms.js', array( 'jquery' ), '', true );
		wp_register_script( 'magellan', get_template_directory_uri() . '/javascripts/foundation/foundation.magellan.js', array( 'jquery' ), '', true );
		wp_register_script( 'reveal', get_template_directory_uri() . '/javascripts/foundation/foundation.reveal.js', array( 'jquery' ), '', true );
		wp_register_script( 'alerts', get_template_directory_uri() . '/javascripts/foundation/foundation.alerts.js', array( 'jquery' ), '', true );
		wp_register_script( 'section', get_template_directory_uri() . '/javascripts/foundation/foundation.section.js', array( 'jquery' ), '', true );
		wp_register_script( 'joyride', get_template_directory_uri() . '/javascripts/foundation/foundation.joyride.js', array( 'jquery' ), '', true );
		wp_register_script( 'tooltips', get_template_directory_uri() . '/javascripts/foundation/foundation.tooltips.js', array( 'jquery' ), '', true );
		wp_register_script( 'functions', get_template_directory_uri() . '/javascripts/functions.js', array( 'jquery', 'jquery-ui-core' ), '', true);
	}

	// Enqueue scripts
	function enqueue_scripts()
	{
		wp_enqueue_script( 'modernizr' );
		wp_enqueue_script( 'foundation' );
		wp_enqueue_script( 'clearing' );
		wp_enqueue_script( 'orbit' );
		wp_enqueue_script( 'placeholder' );
		wp_enqueue_script( 'topbar' );
		wp_enqueue_script( 'dropdown' );
		wp_enqueue_script( 'forms' );
		wp_enqueue_script( 'magellan' );
		wp_enqueue_script( 'reveal' );
		wp_enqueue_script( 'alerts' );
		wp_enqueue_script( 'section' );
		wp_enqueue_script( 'joyride' );
		wp_enqueue_script( 'tooltips' );
		wp_enqueue_script( 'functions' );
	}

	function register_admin_scripts()
	{
		wp_register_script( 'snippet', get_template_directory_uri() . '/javascripts/extras/jquery.snippet.min.js' );
		wp_register_script( 'admin', get_template_directory_uri() . '/javascripts/admin.js' );
	}

	function enqueue_admin_scripts()
	{
		wp_enqueue_script( 'snippet' );
		wp_enqueue_script( 'admin-functions' );
	}


/*==================================================*/
/* Admin Menu
/*==================================================*/

	// Remove unnecessary pages
	function remove_menu_pages()
	{
		remove_menu_page('link-manager.php');
	}


/*==================================================*/
/*  Menu
/*==================================================*/

	function register_menus()
	{
		register_nav_menus(
			array(
				'top_menu'		=> __( 'Top Menu', TANGERINE_TEXTDOMAIN ),
				'main_menu'		=> __( 'Main Menu', TANGERINE_TEXTDOMAIN ),
				'footer_menu'	=> __( 'Footer Menu', TANGERINE_TEXTDOMAIN )
			)
		);
	}

	function add_extra_menu_classes( $objects )
	{
	    $objects[1]->classes[] = 'first';
	    $objects[count( $objects )]->classes[] = 'last';

	    return $objects;
	}

	function tangerine_top_menu_bar() {
		wp_nav_menu(array(
		    'container' => false,
		    'container_class' => '',
		    'menu' => 'top-menu',
		    'menu_class' => 'right',
		    'theme_location' => 'top_menu',
		    'before' => '',
		    'after' => '',
		    'link_before' => '',
		    'link_after' => '',
		    'depth' => 3,
		    'fallback_cb' => 'tangerine_top_bar_fallback',
		    'walker' => new tangerine_top_menu()
		));
	}

	function tangerine_main_menu_bar() {
		wp_nav_menu(array(
		    'container' => false,
		    'container_class' => '',
		    'menu' => 'main-menu',
		    'menu_class' => 'left',
		    'theme_location' => 'main_menu',
		    'before' => '',
		    'after' => '',
		    'link_before' => '',
		    'link_after' => '',
		    'depth' => 3,
		    'fallback_cb' => 'tangerine_main_bar_fallback',
		    'walker' => new tangerine_general_menu()
		));
	}

	function tangerine_footer_menu_bar() {
		wp_nav_menu(array(
		    'container' => false,
		    'container_class' => '',
		    'menu' => 'footer-menu',
		    'menu_class' => 'left',
		    'theme_location' => 'footer_menu',
		    'before' => '',
		    'after' => '',
		    'link_before' => '',
		    'link_after' => '',
		    'depth' => 1,
		    'fallback_cb' => 'tangerine_footer_bar_fallback',
		    'walker' => new tangerine_general_menu()
		));
	}

	function tangerine_top_bar_fallback() {
		echo '<ul class="right">';
		wp_list_pages(array(
			'depth'        => 3,
			'child_of'     => 0,
			'exclude'      => '',
			'include'      => '',
			'title_li'     => '',
			'echo'         => 1,
			'authors'      => '',
			'sort_column'  => 'menu_order, post_title',
			'link_before'  => '',
			'link_after'   => '',
			'walker'       => new tangerine_fallback_menu(),
			'post_type'    => 'page',
			'post_status'  => 'publish'
		));
		echo '</ul>';
	}

	function tangerine_main_bar_fallback() {
		echo '<ul class="left">';
		wp_list_pages(array(
			'depth'        => 3,
			'child_of'     => 0,
			'exclude'      => '',
			'include'      => '',
			'title_li'     => '',
			'echo'         => 1,
			'authors'      => '',
			'sort_column'  => 'menu_order, post_title',
			'link_before'  => '',
			'link_after'   => '',
			'walker'       => new tangerine_fallback_menu(),
			'post_type'    => 'page',
			'post_status'  => 'publish'
		));
		echo '</ul>';
	}

	function tangerine_footer_bar_fallback() {
		echo '<ul class="left">';
		wp_list_pages(array(
			'depth'        => 1,
			'child_of'     => 0,
			'exclude'      => '',
			'include'      => '',
			'title_li'     => '',
			'echo'         => 1,
			'authors'      => '',
			'sort_column'  => 'menu_order, post_title',
			'link_before'  => '',
			'link_after'   => '',
			'walker'       => new tangerine_fallback_menu(),
			'post_type'    => 'page',
			'post_status'  => 'publish'
		));
		echo '</ul>';
	}


/*==================================================*/
/*  Slider
/*==================================================*/

	function tangerine_orbit_register_cpt() {

		$labels = array(
			'name'                 => __( 'Slides', 'tangerine-orbit' ),
			'singular_name'        => __( 'Slide', 'tangerine-orbit' ),
			'all_items'            => __( 'All Slides', 'tangerine-orbit' ),
			'add_new'              => __( 'Add New', 'tangerine-orbit' ),
			'add_new_item'         => __( 'Add New', 'tangerine-orbit' ),
			'edit_item'            => __( 'Edit Slide', 'tangerine-orbit' ),
			'new_item'             => __( 'New Slide', 'tangerine-orbit' ),
			'view_item'            => __( 'View Slide', 'tangerine-orbit' ),
			'search_items'         => __( 'Search Slides', 'tangerine-orbit' ),
			'not_found'            => __( 'No Slide found', 'tangerine-orbit' ),
			'not_found_in_trash'   => __( 'No Slide found in Trash', 'tangerine-orbit' ),
			'parent_item_colon'    => ''
		);

		$args = array(
			'labels'               => $labels,
			'public'               => true,
			'publicly_queryable'   => true,
			'_builtin'             => false,
			'show_ui'              => true,
			'query_var'            => true,
			'rewrite'              => array( "slug" => "slides" ),
			'capability_type'      => 'post',
			'hierarchical'         => false,
			'menu_position'        => 20,
			'supports'             => array( 'title','thumbnail', 'page-attributes' ),
			'taxonomies'           => array(),
			'has_archive'          => true,
			'show_in_nav_menus'    => false
		);

		register_post_type( 'slides', $args );
	}
	add_action( 'init', 'tangerine_orbit_register_cpt' );


/*==================================================*/
/* Excerpt
/*==================================================*/

	function excerpt_length( $length )
	{
		return 55;
	}

	function excerpt_more( $more )
	{
		return '<div class="small-12 columns read-more"><a class="button tiny secondary right" href="'. get_permalink() .'">'. __( 'Read More...', TANGERINE_TEXTDOMAIN ) .'</a></div>';
	}


/*==================================================*/
/* Sidebars, widgets
/*==================================================*/

	function register_extra_sidebars()
	{
		register_sidebar( array(
			'name' 			=> 'Home Sidebar',
			'id'			=> 'home-sidebar',
			'description'	=> __( 'Sidebar used on home page', TANGERINE_TEXTDOMAIN ),
			'before_widget' =>  '<li id="%1$s2" class="widget %2$s">',
			'after_widget'  =>  '</li>',
			'before_title'  =>  '<h3 class="widgettitle">',
			'after_title'   =>  '</h3>'
		) );

		register_sidebar( array(
			'name' 			=> 'Main Sidebar',
			'id'			=> 'sidebar',
			'description'	=> __( 'Sidebar used on all pages', TANGERINE_TEXTDOMAIN ),
			'before_widget' =>  '<li id="%1$s2" class="widget %2$s">',
			'after_widget'  =>  '</li>',
			'before_title'  =>  '<h3 class="widgettitle">',
			'after_title'   =>  '</h3>'
		) );

		register_sidebar( array(
			'name' 			=> 'Footer Area',
			'id'			=> 'footer-area',
			'description'	=> __( 'Footer widget area', TANGERINE_TEXTDOMAIN ),
			'before_widget' =>  '<li id="%1$s2" class="widget %2$s">',
			'after_widget'  =>  '</li>',
			'before_title'  =>  '<h3 class="widgettitle">',
			'after_title'   =>  '</h3>'
		) );
	}

	// Register widgets
	function register_widgets()
	{
		// register_widget( 'Widget' );
	}


/*==================================================*/
/* Dashboard widgets
/*==================================================*/

	function add_dashboard_widgets()
	{
		//wp_add_dashboard_widget( 'dashboard_widget', 'Dashboard Widget', 'dashboard_widget' );
	}

	function dashboard_widget()
	{
		// echo '';
	}

	function remove_dashboard_widgets()
	{
		// Core
		//remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
		//remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );

		// Yoast
		remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
	}


/*==================================================*/
/* User
/*==================================================*/

	function edit_contactmethods( $methods )
	{
		unset( $methods['aim'] );
		unset( $methods['jabber'] );
		unset( $methods['yim'] );

		return $methods;
	}


/*==================================================*/
/* Title
/*==================================================*/

	function tangerine_title()
	{
		global $page, $paged;

		wp_title( '|', true, 'right' );
		bloginfo( 'name' );

		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) echo ' | ' . $site_description;
		if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', TANGERINE_TEXTDOMAIN ), max( $paged, $page ) );
	}


/*==================================================*/
/* Breadcrumbs
/*==================================================*/

	function breadcrumbs()
	{
		if ( ! is_front_page() )
		{
			echo '<ul class="breadcrumbs hide-for-small"><li><a href="';
			echo get_option('home');
			echo '">';
			echo 'Home';
			echo "</a></li>";
		}

		if ( is_single() ) {
			$category = get_the_category();
			echo '<li>'. get_category_parents( $category[0]->cat_ID, true, '', false ) .'</li>';
		}

		if ( is_category() ) {
			$category = get_the_category();
			echo '<li class="current"><a href="#">'. get_category_parents( $category[0]->cat_ID, false, '', false ) .'</a></li>';
		}

		if( is_single() || is_page() ) echo '<li class="current"><a href="#">' . get_the_title() . '</a></li>';
		if( is_tag() ) echo "Tag: ".single_tag_title( '',false );
		if( is_404() ) echo "404 - Page not Found";
		if( is_search() ) echo "Search";
		if( is_year() ) echo get_the_time('Y');

		echo "</ul>";
	}


/*==================================================*/
/* Pagination
/*==================================================*/

	function pagination( $pages = '', $range = 2 )
	{
	     $showitems = ( $range * 2 ) + 1;

	     global $paged;
	     if( empty( $paged ) ) $paged = 1;

	     if( $pages == '' )
	     {
	         global $wp_query;
	         $pages = $wp_query->max_num_pages;
	         if( ! $pages )
	         {
	             $pages = 1;
	         }
	     }

	     if( 1 != $pages )
	     {
	         echo '<ul class="pagination">';
	         echo '<li><a href="' . get_pagenum_link( 1 ) . '">&laquo;</a></li>';

	         for ( $i = 1; $i <= $pages; $i++ )
	         {
	             if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ))
	             {
	                 echo ( $paged == $i ) ? '<li class="current unavailable"><a href="#" onclick="event.preventDefault();">' . $i . '</a></li>'
						: '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
	             }
	         }

			 echo '<li><a href="' . get_pagenum_link($pages) . '">&raquo;</a></li>';
	         echo '</ul>';
	     }
	}

?>
