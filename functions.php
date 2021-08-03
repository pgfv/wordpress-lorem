<?php

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'title-tag' );
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'width' => 350, 'height' => 200 ) );
}

function add_image_sizes() {
	add_image_size( 'logo-350w', 350 );
	add_image_size( 'menu-36x36', 36, 36 );
}

function image_sizes_name( $sizes ) {
	$sizes['menu-36x36'] = __( 'Menu 36x36', 'lorem' );

	return $sizes;
}

function register_menus() {
	register_nav_menus( array(
		'header-menu'   => __( 'Header Menu', 'lorem' ),
		'register-menu' => __( 'Register Menu', 'lorem' ),
		'mobile-menu'   => __( 'Mobile Menu', 'lorem' ),
	) );
}

function register_custom_style() {
	wp_register_style( 'tailwind', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0', 'all' );
	wp_enqueue_style( 'tailwind' );
}

function register_google_fonts() {
	wp_enqueue_style( 'google-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Sarabun:wght@400;700&display=swap',
		false, null );
}

function dequeue_plugin_style() {
	wp_dequeue_style( 'dashicons' );
	wp_dequeue_style( 'font-awesome' );
	wp_dequeue_style( 'menu-icons-extra' );
}

function header_menu() {
	$html = wp_nav_menu( array(
		'theme_location' => 'header-menu',
		'items_wrap'     => '<ul id="%1$s" class="%2$s header-menu group grid grid-cols-4 md:grid-cols-8 items-center text-center my-5">%3$s</ul>',
		'echo'           => false,
	) );

	// add class for sub-menu
	$html = str_replace( 'sub-menu',
		'sub-menu group-hover:block absolute top-16 w-full divide-y border border-gray-800 bg-gray-100 rounded z-10 text-left',
		$html );

	return $html;
}

function header_menu_list() {
	$html = wp_nav_menu( array(
		'theme_location' => 'header-menu',
		'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'echo'           => false,
	) );

	// add class to sub-menu
	$html = str_replace( 'sub-menu', 'sub-menu group-hover:block hidden', $html );

	return $html;
}

function header_menu_li_classes( $classes, $item, $args ) {
	if ( $args->theme_location == 'header-menu' ) {
		$classes[] = 'group';
	}

	return $classes;
}

function header_menu_archer_classes( $atts, $item, $args ) {
	if ( $args->theme_location == 'header-menu' ) {
//		$atts['class'] = 'flex flex-row items-center';
	}

	return $atts;
}

function register_menu() {
	return menu_with_count( 'register-menu' );
}

function mobile_menu() {
	return menu_with_count( 'mobile-menu' );
}

function menu_with_count( $location ) {
	$html = wp_nav_menu( array(
		'theme_location' => $location,
		'items_wrap'     => '%3$s',
		'echo'           => false,
	) );

	$html  = strip_tags( $html, '<a><img><span>' );
	$count = substr_count( $html, '<a' );

	return array( $html, $count );
}

function header_footer_theme_customizer( $wp_customizer ) {
	// header & footer
	$wp_customizer->add_section( 'header_footer', array(
		'title'       => __( 'Footer Settings', 'lorem' ),
		'description' => __( 'Footer Customizer' ),
		'priority'    => 100,
	) );

	// footer header color
	$wp_customizer->add_setting( 'footer_header_color_setting', array(
		'default' => '#111827',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_header_color_control', array(
		'label'    => 'Header Color',
		'section'  => 'header_footer',
		'settings' => 'footer_header_color_setting',
	) ) );

	// footer header size
	$wp_customizer->add_setting( 'footer_header_size_setting', array(
		'default' => '1.875rem',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'footer_header_size_control', array(
		'label'    => 'Header Size',
		'section'  => 'header_footer',
		'settings' => 'footer_header_size_setting',
		'type'     => 'select',
		'choices'  => array(
			'0.75rem'  => 'xs',
			'0.875rem' => 'sm',
			'1rem'     => 'base',
			'1.125rem' => 'lg',
			'1.25rem'  => 'xl',
			'1.5rem'   => '2xl',
			'1.875rem' => '3xl',
			'2.25rem'  => '4xl',
			'3rem'     => '5xl',
			'3.75rem'  => '6xl',
			'4.5rem'   => '7xl',
			'6rem'     => '8xl',
			'8rem'     => '9xl',
		),
	) ) );

	// footer p size
	$wp_customizer->add_setting( 'footer_p_size_setting', array(
		'default' => '1rem|1.5rem',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'footer_p_size_control', array(
		'label'    => 'Paragraph Size',
		'section'  => 'header_footer',
		'settings' => 'footer_p_size_setting',
		'type'     => 'select',
		'choices'  => array(
			'0.75rem|1rem'     => 'xs',
			'0.875rem|1.25rem' => 'sm',
			'1rem|1.5rem'      => 'base',
			'1.125rem|1.75rem' => 'lg',
			'1.25rem|1.75rem'  => 'xl',
			'1.5rem|2rem'      => '2xl',
			'1.875rem|2.25rem' => '3xl',
			'2.25rem|2.5rem'   => '4xl',
			'3rem|1'           => '5xl',
			'3.75rem|1'        => '6xl',
			'4.5rem|1'         => '7xl',
			'6rem|1'           => '8xl',
			'8rem|1'           => '9xl',
		),
	) ) );


	// footer bullet color
	$wp_customizer->add_setting( 'footer_bullet_setting', array(
		'default' => '#d1d5db',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_bullet_control', array(
		'label'    => 'Bullet Color',
		'section'  => 'header_footer',
		'settings' => 'footer_bullet_setting',
	) ) );

	// footer head
	$wp_customizer->add_setting( 'footer_head_setting', array(
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options',
	) );

	$wp_customizer->add_control( 'footer_head_control', array(
		'label'    => __( 'Footer Head', 'luckygame78' ),
		'section'  => 'header_footer',
		'settings' => 'footer_head_setting',
		'type'     => 'text',
	) );

	// footer content
	$wp_customizer->add_setting( 'footer_content_setting', array(
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options',
	) );

	$wp_customizer->add_control( 'footer_content_control', array(
		'label'    => __( 'Footer Content', 'luckygame78' ),
		'section'  => 'header_footer',
		'settings' => 'footer_content_setting',
		'type'     => 'textarea',
	) );

	// copyright
	$wp_customizer->add_setting( 'copyright_text_setting', array(
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options'
	) );

	$wp_customizer->add_control( 'copyright_text_control', array(
		'label'    => __( 'Copyright', 'lorem' ),
		'section'  => 'header_footer',
		'settings' => 'copyright_text_setting',
		'type'     => 'textarea',
	) );
}

function colors_theme_customizer( $wp_customizer ) {
	// theme color
	$wp_customizer->add_section( 'theme_colors', array(
		'title'    => __( 'Theme Settings', 'lorem' ),
		'priority' => 105,
	) );

	// theme color: background
	$wp_customizer->add_setting( 'background_color_setting', array(
		'default' => '#FFFFFF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'background_color_control', array(
		'label'    => 'Background',
		'section'  => 'theme_colors',
		'settings' => 'background_color_setting',
	) ) );

	// theme color: header
	$wp_customizer->add_setting( 'header_color_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_color_control', array(
		'label'    => 'Header',
		'section'  => 'theme_colors',
		'settings' => 'header_color_setting',
	) ) );

	// theme color: header menu
	$wp_customizer->add_setting( 'header_menu_color_setting', array(
		'default' => '#E5E7EB',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_color_control', array(
		'label'    => 'Header Menu',
		'section'  => 'theme_colors',
		'settings' => 'header_menu_color_setting',
	) ) );

	// theme color: footer
	$wp_customizer->add_setting( 'footer_color_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_color_control', array(
		'label'    => 'Footer',
		'section'  => 'theme_colors',
		'settings' => 'footer_color_setting',
	) ) );

	// theme color: footer mobile
	$wp_customizer->add_setting( 'footer_mobile_color_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_color_control', array(
		'label'    => 'Footer Mobile Menu',
		'section'  => 'theme_colors',
		'settings' => 'footer_mobile_color_setting',
	) ) );

	// theme color: font
	$wp_customizer->add_setting( 'font_color_setting', array(
		'default' => '#374151',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'font_color_control', array(
		'label'    => 'Font',
		'section'  => 'theme_colors',
		'settings' => 'font_color_setting',
	) ) );

	$font_sizes = array(
		'0.75rem|1rem'     => 'xs',
		'0.875rem|1.25rem' => 'sm',
		'1rem|1.5rem'      => 'base',
		'1.125rem|1.75rem' => 'lg',
		'1.25rem|1.75rem'  => 'xl',
		'1.5rem|2rem'      => '2xl',
		'1.875rem|2.25rem' => '3xl',
		'2.25rem|2.5rem'   => '4xl',
		'3rem|1'           => '5xl',
		'3.75rem|1'        => '6xl',
		'4.5rem|1'         => '7xl',
		'6rem|1'           => '8xl',
		'8rem|1'           => '9xl',
	);

	// theme setting: font size
	$wp_customizer->add_setting( 'font_size_setting', array(
		'default' => '1rem|1.5rem',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'font_size_control', array(
		'label'    => 'Font Size',
		'section'  => 'theme_colors',
		'settings' => 'font_size_setting',
		'type'     => 'select',
		'choices'  => $font_sizes,
	) ) );

	// theme color: h1
	$wp_customizer->add_setting( 'h1_color_setting', array(
		'default' => '#111827',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'h1_color_control', array(
		'label'    => 'H1',
		'section'  => 'theme_colors',
		'settings' => 'h1_color_setting',
	) ) );

	// theme setting: h1 size
	$wp_customizer->add_setting( 'h1_size_setting', array(
		'default' => '1.875rem|2.25rem',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'h1_size_control', array(
		'label'    => 'H1 Size',
		'section'  => 'theme_colors',
		'settings' => 'h1_size_setting',
		'type'     => 'select',
		'choices'  => $font_sizes,
	) ) );

	// theme color: h2
	$wp_customizer->add_setting( 'h2_color_setting', array(
		'default' => '#111827',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'h2_color_control', array(
		'label'    => 'H2',
		'section'  => 'theme_colors',
		'settings' => 'h2_color_setting',
	) ) );

	// theme setting: h2 size
	$wp_customizer->add_setting( 'h2_size_setting', array(
		'default' => '1.5rem|2rem',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'h2_size_control', array(
		'label'    => 'H2 Size',
		'section'  => 'theme_colors',
		'settings' => 'h2_size_setting',
		'type'     => 'select',
		'choices'  => $font_sizes,
	) ) );

	// theme color: h3
	$wp_customizer->add_setting( 'h3_color_setting', array(
		'default' => '#111827',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'h3_color_control', array(
		'label'    => 'H3',
		'section'  => 'theme_colors',
		'settings' => 'h3_color_setting',
	) ) );

	// theme setting: h3 size
	$wp_customizer->add_setting( 'h3_size_setting', array(
		'default' => '1.5rem|2rem',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'h3_size_control', array(
		'label'    => 'H3 Size',
		'section'  => 'theme_colors',
		'settings' => 'h3_size_setting',
		'type'     => 'select',
		'choices'  => $font_sizes,
	) ) );
}

function widget_theme_customizer( $wp_customizer ) {
	// widget
	$wp_customizer->add_section( 'widget_customizer', array(
		'title'       => __( 'Widget Settings', 'lorem' ),
		'description' => __( 'Widget customizer', 'lorem' ),
		'priority'    => 100,
	) );

	// theme color: primary widget header color
	$wp_customizer->add_setting( 'header_widget_color_setting', array(
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default'    => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_widget_color_control', array(
		'label'    => 'Primary Widget Header',
		'section'  => 'widget_customizer',
		'settings' => 'header_widget_color_setting',
	) ) );

	// theme color: primary widget header text color
	$wp_customizer->add_setting( 'header_widget_text_color_setting', array(
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default'    => '#F3F4F6',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_widget_text_color_control',
		array(
			'label'    => 'Primary Widget Text Header',
			'section'  => 'widget_customizer',
			'settings' => 'header_widget_text_color_setting',
		) ) );
}

function lorem_widgets_init() {
	register_sidebar( array(
		'id'            => 'primary',
		'name'          => __( 'Primary Sidebar', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="widget widget-primary prose max-w-none mb-10 %2$s">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'footer',
		'name'          => __( 'Footer Sidebar', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="widget widget-footer prose max-w-none %2$s">',
		'after_widget'  => '</section>',
	) );
}

function lorem_css_customizer() {
	$css = '.main-content p{';
	if ( ! empty( get_theme_mod( 'font_color_setting' ) ) ) {
		$color = get_theme_mod( 'font_color_setting' );
		$css   .= "color:{$color};";
	}
	if ( ! empty( get_theme_mod( 'font_size_setting' ) ) ) {
		$size = explode( '|', get_theme_mod( 'font_size_setting' ) );
		$css  .= "font-size:{$size[0]};line-height:{$size[1]};";
	}
	$css .= '}';

	$css .= '.main-content h1{';
	if ( ! empty( get_theme_mod( 'h1_color_setting' ) ) ) {
		$color = get_theme_mod( 'h1_color_setting' );
		$css   .= "color:{$color} !important;";
	}
	if ( ! empty( get_theme_mod( 'h1_size_setting' ) ) ) {
		$size = explode( '|', get_theme_mod( 'h1_size_setting' ) );
		$css  .= "font-size:{$size[0]};";
	}
	$css .= '}';

	$css .= '.main-content h2{';
	if ( ! empty( get_theme_mod( 'h2_color_setting' ) ) ) {
		$color = get_theme_mod( 'h2_color_setting' );
		$css   .= "color:{$color} !important;";
	}
	if ( ! empty( get_theme_mod( 'h2_size_setting' ) ) ) {
		$size = explode( '|', get_theme_mod( 'h2_size_setting' ) );
		$css  .= "font-size:{$size[0]};";
	}
	$css .= '}';

	$css .= '.main-content h3{';
	if ( ! empty( get_theme_mod( 'h3_color_setting' ) ) ) {
		$color = get_theme_mod( 'h3_color_setting' );
		$css   .= "color:{$color};";
	}
	if ( ! empty( get_theme_mod( 'h3_size_setting' ) ) ) {
		$size = explode( '|', get_theme_mod( 'h3_size_setting' ) );
		$css  .= "font-size:{$size[0]};";
	}
	$css .= '}';

	$css .= '.widget-primary h2{';
	if ( ! empty( get_theme_mod( 'header_widget_text_color_setting' ) ) ) {
		$color = get_theme_mod( 'header_widget_text_color_setting' );
		$css   .= "color:{$color} !important;";
	}
	if ( ! empty( get_theme_mod( 'header_widget_color_setting' ) ) ) {
		$color = get_theme_mod( 'header_widget_color_setting' );
		$css   .= "background-color:{$color};";
	}
	$css .= '}';

	$css .= '.footer-content h1,.footer-content h2,.footer-content h3{';
	if ( ! empty ( get_theme_mod( 'footer_header_color_setting' ) ) ) {
		$color = get_theme_mod( 'footer_header_color_setting' );
		$css   .= "color:{$color};";
	}
	if ( ! empty( get_theme_mod( 'footer_header_size_setting' ) ) ) {
		$size = get_theme_mod( 'footer_header_size_setting' );
		$css  .= "font-size:{$size};";
	}
	$css .= '}';

	$css .= '.footer-content p,.footer-content a{';
	if ( ! empty( get_theme_mod( 'footer_p_size_setting' ) ) ) {
		$size = explode( "|", get_theme_mod( 'footer_p_size_setting' ) );
		$css  .= "font-size:{$size[0]};line-height:{$size[1]};";
	}
	$css .= '}';

	$css .= '.widget-footer.prose ul>li:before{';
	if ( ! empty ( get_theme_mod( 'footer_bullet_setting' ) ) ) {
		$color = get_theme_mod( 'footer_bullet_setting' );
		$css   .= "background-color:{$color} !important;";
	}
	$css .= '}';

	return $css;
}

// add action
add_action( 'init', 'register_menus' );
add_action( 'init', 'lorem_widgets_init' );
add_action( 'after_setup_theme', 'add_image_sizes' );
add_action( 'wp_enqueue_scripts', 'register_custom_style' );
add_action( 'wp_enqueue_scripts', 'register_google_fonts' );
add_action( 'wp_enqueue_scripts', 'dequeue_plugin_style', 999 );
add_action( 'customize_register', 'header_footer_theme_customizer' );
add_action( 'customize_register', 'colors_theme_customizer' );
add_action( 'customize_register', 'widget_theme_customizer' );

// add filter
add_filter( 'image_size_names_choose', 'image_sizes_name' );
add_filter( 'nav_menu_css_class', 'header_menu_li_classes', 1, 3 );
add_filter( 'nav_menu_link_attributes', 'header_menu_archer_classes', 10, 3 );
