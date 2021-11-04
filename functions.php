<?php
$theme = wp_get_theme();
define( 'THEME_VERSION', $theme->version );

$font_sizes        = array(
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
$font_size_default = '1rem|1.5rem';
define( 'THEME_FONT_SIZE', $font_sizes );
define( 'THEME_FONT_SIZE_DEFAULT', $font_size_default );

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
	wp_register_style( 'tailwind', get_template_directory_uri() . '/assets/css/style.css', array(), THEME_VERSION,
		'all' );
	wp_enqueue_style( 'tailwind' );
}

function dequeue_plugin_style() {
	wp_dequeue_style( 'dashicons' );
	wp_dequeue_style( 'font-awesome' );
	wp_dequeue_style( 'menu-icons-extra' );
}

function make_image_relative_path( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
	$image_url    = wp_get_attachment_image_src( $id, $size );
	$relative_url = wp_make_link_relative( $image_url[0] );
	$html         = str_replace( $image_url[0], $relative_url, $html );

	return $html;
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
		'theme_location'  => 'header-menu',
		'container'       => 'nav',
		'container_class' => 'main-container',
		'items_wrap'      => '<ul id="%1$s" class="%2$s grid grid-cols-4 md:flex md:flex-row justify-evenly text-center">%3$s</ul>',
		'echo'            => false,
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
	$class = implode( ' ', $item->classes );
	if ( $args->theme_location == 'header-menu' ) {
		$atts['class'] = "block md:py-3 md:px-5 {$class}";
	}

	if ( $args->theme_location == 'register-menu' ) {
		$atts['class'] = $class;
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

function font_theme_customizer( $wp_customizer ) {
	$wp_customizer->add_section( 'font_customizer', array(
		'title'       => __( 'Font Settings', 'lorem' ),
		'description' => __( 'Font customizer', 'lorem' ),
		'priority'    => 99,
	) );

	// font thai
	$wp_customizer->add_setting( 'font_thai_setting', array(
		'default' => 'Sarabun:wght@400;700',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'font_thai_control', array(
		'label'    => 'Thai Font',
		'section'  => 'font_customizer',
		'settings' => 'font_thai_setting',
		'type'     => 'select',
		'choices'  => array(
			'Sarabun:wght@400;700' => 'Sarabun',
			'Prompt:wght@400;700'  => 'Prompt',
			'Kanit:wght@400;700'   => 'Kanit',
			'Mitr:wght@400;700'    => 'Mitr',
			'K2D:wght@400;700'     => 'K2D',
		),
	) ) );

	// font english
	$wp_customizer->add_setting( 'font_english_setting', array(
		'default' => 'Montserrat:wght@400;700',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'font_english_control', array(
		'label'    => 'English Font',
		'section'  => 'font_customizer',
		'settings' => 'font_english_setting',
		'type'     => 'select',
		'choices'  => array(
			'Roboto:wght@400;700'     => 'Roboto',
			'Open+Sans:wght@400;700'  => 'Open Sans',
			'Lato:wght@400;700'       => 'Lato',
			'Montserrat:wght@400;700' => 'Montserrat',
			'Hahmlet:wght@400;700'    => 'Hahmlet',
		),
	) ) );

	// font size
	$wp_customizer->add_setting( 'font_size_setting', array(
		'default' => THEME_FONT_SIZE_DEFAULT,
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'font_size_control', array(
		'label'    => 'Font Size',
		'section'  => 'theme_colors',
		'settings' => 'font_size_setting',
		'type'     => 'select',
		'choices'  => THEME_FONT_SIZE,
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
		'choices'  => THEME_FONT_SIZE,
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
		'choices'  => THEME_FONT_SIZE,
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
		'choices'  => THEME_FONT_SIZE,
	) ) );

	// theme setting: strong
	$wp_customizer->add_setting( 'strong_color_setting', array(
		'default' => '',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'strong_color_control', array(
		'label'    => 'Strong Color',
		'section'  => 'theme_colors',
		'settings' => 'strong_color_setting',
	) ) );
}

function header_theme_customizer( $wp_customizer ) {
	$wp_customizer->add_panel( 'header_customizer_panel', array(
		'title'       => __( 'Header Settings', 'lorem' ),
		'description' => __( 'Header customizer', 'lorem' ),
		'priority'    => 101,
		'capability'  => 'edit_theme_options',
	) );

	$wp_customizer->add_section( 'header_color_section', array(
		'title'       => __( 'Header Color', 'lorem' ),
		'description' => __( 'Header color customizer', 'lorem' ),
		'priority'    => 1,
		'panel'       => 'header_customizer_panel',
	) );

	// theme color: header
	$wp_customizer->add_setting( 'header_color_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_color_control', array(
		'label'    => 'Header',
		'section'  => 'header_color_section',
		'settings' => 'header_color_setting',
	) ) );

	// header gradient to
	$wp_customizer->add_setting( 'header_color_gradient_to_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_color_gradient_to_control',
		array(
			'label'    => 'Header Gradient To',
			'section'  => 'header_color_section',
			'settings' => 'header_color_gradient_to_setting',
		) ) );

	// theme color: header menu
	$wp_customizer->add_setting( 'header_menu_color_setting', array(
		'default' => '#E5E7EB',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_color_control', array(
		'label'    => 'Header Menu',
		'section'  => 'header_color_section',
		'settings' => 'header_menu_color_setting',
	) ) );

	// hamburger color
	$wp_customizer->add_setting( 'header_hamburger_color_setting', array(
		'default' => '#000000',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_hamburger_color_control',
		array(
			'label'    => 'Hamburger Color',
			'section'  => 'header_color_section',
			'settings' => 'header_hamburger_color_setting',
		) ) );

	$wp_customizer->add_section( 'header_archer_section', array(
		'title'       => 'Header Archer',
		'description' => 'Archer customizer',
		'priority'    => 2,
		'panel'       => 'header_customizer_panel',
	) );

	// archer text color
	$wp_customizer->add_setting( 'header_menu_archer_text_color_setting', array(
		'default' => '#000000',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
		'header_menu_archer_text_color_control',
		array(
			'label'    => 'Text Color',
			'section'  => 'header_archer_section',
			'settings' => 'header_menu_archer_text_color_setting',
		) ) );

	// archer text color when hover
	$wp_customizer->add_setting( 'header_menu_archer_text_color_hover_setting', array(
		'default' => '#000000',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
		'header_menu_archer_text_color_hover_control',
		array(
			'label'    => 'Hover Text Color',
			'section'  => 'header_archer_section',
			'settings' => 'header_menu_archer_text_color_hover_setting',
		) ) );

	// archer background
	$wp_customizer->add_setting( 'header_menu_archer_background_setting', array(
		'default' => '#E5E7EB',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
		'header_menu_archer_background_control',
		array(
			'label'    => 'Background Color',
			'section'  => 'header_archer_section',
			'settings' => 'header_menu_archer_background_setting',
		) ) );

	// archer background transparent
	$wp_customizer->add_setting( 'header_menu_archer_background_transparent_setting', array(
		'default' => true,
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
		'header_menu_archer_background_transparent_control',
		array(
			'label'    => 'Use transparent for archer background color',
			'section'  => 'header_archer_section',
			'settings' => 'header_menu_archer_background_transparent_setting',
			'type'     => 'checkbox',
		) ) );

	$wp_customizer->add_section( 'header_register_section', array(
		'title'       => __( 'Register Menu', 'lorem' ),
		'description' => __( 'Register menu customizer', 'lorem' ),
		'panel'       => 'header_customizer_panel',
	) );

	// sticky register menu
	$wp_customizer->add_setting( 'header_sticky_register_setting', array(
		'default' => true,
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_register_control', array(
		'label'    => 'Sticky Register Menu',
		'section'  => 'header_register_section',
		'settings' => 'header_sticky_register_setting',
		'type'     => 'checkbox',
	) ) );

//	// register button
//	$wp_customizer->add_setting( 'header_register_is_button_setting', array(
//		'default' => false,
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_register_is_button_control', array(
//		'label'    => 'Display as button',
//		'section'  => 'header_register_section',
//		'settings' => 'header_register_is_button_setting',
//		'type'     => 'checkbox',
//	) ) );
//
//	// register button border size
//	$wp_customizer->add_setting( 'header_register_button_border_size_setting', array(
//		'default' => '1px'
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_register_button_border_size_control',
//		array(
//			'label'    => 'Button border size',
//			'section'  => 'header_register_section',
//			'settings' => 'header_register_button_border_size_setting',
//			'type'     => 'text',
//		) ) );
//
//	// register button border color
//	$wp_customizer->add_setting( 'header_register_button_border_color_setting', array(
//		'default' => '#000000',
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
//		'header_register_button_border_color_control',
//		array(
//			'label'    => 'Border Color',
//			'section'  => 'header_register_section',
//			'settings' => 'header_register_button_border_color_setting',
//		) ) );
//
//	// register button background
//	$wp_customizer->add_setting( 'header_register_button_background_setting', array(
//		'default' => '#9CA3AF',
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
//		'header_register_button_background_control',
//		array(
//			'label'    => 'Background Color',
//			'section'  => 'header_register_section',
//			'settings' => 'header_register_button_background_setting',
//		) ) );
//
//	// register button background hover
//	$wp_customizer->add_setting( 'header_register_button_background_hover_setting', array(
//		'default' => '#9CA3AF',
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
//		'header_register_button_background_hover_control',
//		array(
//			'label'    => 'Hover Background Color',
//			'section'  => 'header_register_section',
//			'settings' => 'header_register_button_background_hover_setting',
//		) ) );
//
//	// register button padding x, y
//	$wp_customizer->add_setting( 'header_register_button_padding_x_setting', array(
//		'default' => '10px',
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_register_button_padding_x_control',
//		array(
//			'label'    => 'Button Padding Horizon',
//			'section'  => 'header_register_section',
//			'settings' => 'header_register_button_padding_x_setting',
//			'type'     => 'text',
//		) ) );
//
//	$wp_customizer->add_setting( 'header_register_button_padding_y_setting', array(
//		'default' => '10px',
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_register_button_padding_y_control',
//		array(
//			'label'    => 'Button Padding Vertical',
//			'section'  => 'header_register_section',
//			'settings' => 'header_register_button_padding_y_setting',
//			'type'     => 'text',
//		) ) );
//
//	// register button text size
//	$wp_customizer->add_setting( 'header_register_button_text_size_setting', array(
//		'default' => '1rem|1.5rem',
//	) );
//
//	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_register_button_text_size_control',
//		array(
//			'label'    => 'Button Font Size',
//			'section'  => 'header_register_section',
//			'settings' => 'header_register_button_text_size_setting',
//			'type'     => 'select',
//			'choices'  => THEME_FONT_SIZE,
//		) ) );
}

function footer_theme_customizer( $wp_customizer ) {
	$wp_customizer->add_panel( 'footer_customizer_panel', array(
		'title'       => __( 'Footer Settings', 'lorem' ),
		'description' => __( 'Footer customizer', 'lorem' ),
		'priority'    => 102,
		'capability'  => 'edit_theme_options',
	) );

	$wp_customizer->add_section( 'footer_color_section', array(
		'title'       => __( 'Footer Color', 'lorem' ),
		'description' => __( 'Footer color customizer', 'lorem' ),
		'panel'       => 'footer_customizer_panel',
	) );

	// footer color
	$wp_customizer->add_setting( 'footer_color_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_color_control', array(
		'label'    => 'Background Color',
		'section'  => 'footer_color_section',
		'settings' => 'footer_color_setting',
	) ) );

	// footer gradient to
	$wp_customizer->add_setting( 'footer_color_gradient_to_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_color_gradient_to_control',
		array(
			'label'    => 'Background Gradient To',
			'section'  => 'footer_color_section',
			'settings' => 'footer_color_gradient_to_setting',
		) ) );

	// footer mobile color
	$wp_customizer->add_setting( 'footer_mobile_color_setting', array(
		'default' => '#9CA3AF',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_color_control', array(
		'label'    => 'Mobile Menu Background Color',
		'section'  => 'footer_color_section',
		'settings' => 'footer_mobile_color_setting',
	) ) );

	$wp_customizer->add_section( 'footer_columns_section', array(
		'title'       => __( 'Columns', 'lorem' ),
		'description' => __( 'Change how many columns you want to display', 'lorem' ),
		'panel'       => 'footer_customizer_panel',
	) );

	// footer column
	$wp_customizer->add_setting( 'footer_column_setting', array(
		'default' => 3,
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'footer_column_control', array(
		'label'    => 'Footer Column',
		'section'  => 'footer_columns_section',
		'settings' => 'footer_column_setting',
		'type'     => 'radio',
		'choices'  => array(
			2 => 2,
			3 => 3,
			4 => 4,
		),
	) ) );

	// footer 2 columns layout
	$wp_customizer->add_setting( 'footer_2_columns_layout_setting', array(
		'default' => '1|1',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'footer_2_columns_layout_control', array(
		'label'    => 'Footer 2 Columns Layout',
		'section'  => 'footer_columns_section',
		'settings' => 'footer_2_columns_layout_setting',
		'type'     => 'radio',
		'choices'  => array(
			'1|1' => '1 - 1',
			'1|2' => '1 - 2',
			'2|1' => '2 - 1',
		),
	) ) );

	// footer 3 columns layout
	$wp_customizer->add_setting( 'footer_3_columns_layout_setting', array(
		'default' => '1|1|1',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'footer_3_columns_layout_control', array(
		'label'    => 'Footer 3 Columns Layout',
		'section'  => 'footer_columns_section',
		'settings' => 'footer_3_columns_layout_setting',
		'type'     => 'radio',
		'choices'  => array(
			'1|1|1' => '1 - 1 - 1',
			'1|1|2' => '1 - 1 - 2',
			'1|2|1' => '1 - 2 - 1',
			'2|1|1' => '2 - 1 - 1',
		),
	) ) );

	// footer header color
	$wp_customizer->add_setting( 'footer_header_color_setting', array(
		'default' => '#111827',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_header_color_control', array(
		'label'    => 'Text Header Color',
		'section'  => 'footer_color_section',
		'settings' => 'footer_header_color_setting',
	) ) );

	$wp_customizer->add_section( 'footer_text_section', array(
		'title'       => __( 'Text Size', 'lorem' ),
		'description' => __( 'Text customizer', 'lorem' ),
		'panel'       => 'footer_customizer_panel',
	) );

	// footer header size
	$wp_customizer->add_setting( 'footer_header_size_setting', array(
		'default' => '1.875rem',
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'footer_header_size_control', array(
		'label'    => 'Text Header Size',
		'section'  => 'footer_text_section',
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
		'default' => THEME_FONT_SIZE_DEFAULT,
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'footer_p_size_control', array(
		'label'    => 'Paragraph Size',
		'section'  => 'footer_text_section',
		'settings' => 'footer_p_size_setting',
		'type'     => 'select',
		'choices'  => THEME_FONT_SIZE,
	) ) );

	// footer p color
	$wp_customizer->add_setting( 'footer_p_color_setting', array(
		'default' => '#d1d5db',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_p_color_control', array(
		'label'    => 'Paragraph Color',
		'section'  => 'footer_color_section',
		'settings' => 'footer_p_color_setting',
	) ) );

	// footer archer color
	$wp_customizer->add_setting( 'footer_a_color_setting', array(
		'default' => '#d1d5db',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_a_color_control', array(
		'label'    => 'Archer Color',
		'section'  => 'footer_color_section',
		'settings' => 'footer_a_color_setting',
	) ) );

	// footer bullet color
	$wp_customizer->add_setting( 'footer_bullet_setting', array(
		'default' => '#d1d5db',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_bullet_control', array(
		'label'    => 'Bullet Color',
		'section'  => 'footer_color_section',
		'settings' => 'footer_bullet_setting',
	) ) );

	$wp_customizer->add_section( 'footer_mobile_section', array(
		'title'       => __( 'Mobile Menu', 'lorem' ),
		'description' => __( 'Customize footer mobile menu', 'lorem' ),
		'panel'       => 'footer_customizer_panel',
	) );

	// mobile archer color
	$wp_customizer->add_setting( 'footer_mobile_a_color_setting', array(
		'default' => '#d1d5db',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_a_color_control', array(
		'label'    => 'Anchor Color',
		'section'  => 'footer_color_section',
		'settings' => 'footer_mobile_a_color_setting',
	) ) );

	// copyright text color
	$wp_customizer->add_setting( 'copyright_text_color_setting', array(
		'default' => '#d1d5db',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'copyright_text_color_control', array(
		'label'    => 'Copyright Color',
		'section'  => 'footer_color_section',
		'settings' => 'copyright_text_color_setting',
	) ) );

	$wp_customizer->add_section( 'footer_content_section', array(
		'title'       => __( 'Content', 'lorem' ),
		'description' => __( 'Customize footer text', 'lorem' ),
		'panel'       => 'footer_customizer_panel',
	) );

	// footer head
	$wp_customizer->add_setting( 'footer_head_setting', array(
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options',
	) );

	$wp_customizer->add_control( 'footer_head_control', array(
		'label'    => __( 'Footer Head', 'luckygame78' ),
		'section'  => 'footer_content_section',
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
		'section'  => 'footer_content_section',
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
		'section'  => 'footer_content_section',
		'settings' => 'copyright_text_setting',
		'type'     => 'textarea',
	) );

	// mobile menu
	$wp_customizer->add_section( 'footer_mobile_menu_section', array(
		'title'       => __( 'Mobile Menu', 'lorem' ),
		'description' => __( 'Customize Mobile Menu', 'lorem' ),
		'panel'       => 'footer_customizer_panel',
	) );

	$wp_customizer->add_setting( 'footer_mobile_menu_enable_setting', array(
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default'    => true,
	) );

	$wp_customizer->add_control( 'footer_mobile_menu_enable_control', array(
		'label'    => __( 'Enable Mobile Menu', 'lorem' ),
		'section'  => 'footer_mobile_menu_section',
		'settings' => 'footer_mobile_menu_enable_setting',
		'type'     => 'checkbox',
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

	// theme color: font
	$wp_customizer->add_setting( 'font_color_setting', array(
		'default' => '#374151',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'font_color_control', array(
		'label'    => 'Font',
		'section'  => 'theme_colors',
		'settings' => 'font_color_setting',
	) ) );

	// theme color: archer
	$wp_customizer->add_setting( 'archer_color_setting', array(
		'default' => '#374151',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'archer_color_control', array(
		'label'    => 'Archer',
		'section'  => 'theme_colors',
		'settings' => 'archer_color_setting',
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

	// theme color: h2
	$wp_customizer->add_setting( 'h2_color_setting', array(
		'default' => '#111827',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'h2_color_control', array(
		'label'    => 'H2',
		'section'  => 'theme_colors',
		'settings' => 'h2_color_setting',
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
}

function widget_theme_customizer( $wp_customizer ) {
	// widget
	$wp_customizer->add_section( 'widget_customizer', array(
		'title'       => __( 'Primary Widget Settings', 'lorem' ),
		'description' => __( 'Primary widget customizer', 'lorem' ),
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

	$wp_customizer->add_setting( 'bullet_widget_color_setting', array(
		'default' => '#d1d5db',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'bullet_widget_color_control', array(
		'label'    => 'Bullet Color',
		'section'  => 'widget_customizer',
		'settings' => 'bullet_widget_color_setting',
	) ) );

	// font color
	$wp_customizer->add_setting( 'font_primary_widget_color_setting', array(
		'default' => '#374151',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'font_primary_widget_color_control',
		array(
			'label'    => 'Font Color',
			'section'  => 'widget_customizer',
			'settings' => 'font_widget_color_setting',
		) ) );

	// tag cloud background color
	$wp_customizer->add_setting( 'tag_cloud_widget_background_color_setting', array(
		'default' => '#374151',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
		'tag_cloud_widget_background_color_control',
		array(
			'label'    => 'Tag Cloud Background Color',
			'section'  => 'widget_customizer',
			'settings' => 'tag_cloud_widget_background_color_setting',
		) ) );

	// tag cloud text color
	$wp_customizer->add_setting( 'tag_cloud_widget_text_color_setting', array(
		'default' => '#000000',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
		'tag_cloud_widget_text_color_control',
		array(
			'label'    => 'Tag Cloud Text Color',
			'section'  => 'widget_customizer',
			'settings' => 'tag_cloud_widget_text_color_setting',
		) ) );
}

function sticky_widget_theme_customizer( $wp_customizer ) {
	$wp_customizer->add_panel( 'sticky_widget_panel', array(
		'title'       => __( 'Sticky Widget Settings Panel', 'lorem' ),
		'description' => __( 'Sticky widget customizer', 'lorem' ),
		'priority'    => 105,
	) );

	for ( $i = 1; $i <= 4; $i ++ ) {
		$wp_customizer->add_section( "sticky_widget_{$i}_section", array(
			'title'       => __( "Sticky Widget {$i}", 'lorem' ),
			'description' => __( 'Sticky widget customizer', 'lorem' ),
			'panel'       => 'sticky_widget_panel',
		) );

		// sticky widget position horizontal
		$wp_customizer->add_setting( "sticky_widget_{$i}_position_horizontal_setting", array(
			'default' => 'right',
		) );

		$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer,
			"sticky_widget_{$i}_position_horizontal_control", array(
				'label'    => 'Horizontal Alignment',
				'section'  => "sticky_widget_{$i}_section",
				'settings' => "sticky_widget_{$i}_position_horizontal_setting",
				'type'     => 'radio',
				'choices'  => array(
					'right' => 'Right',
					'left'  => 'Left',
				),
			) ) );

		// sticky widget position vertical
		$wp_customizer->add_setting( "sticky_widget_{$i}_position_vertical_setting", array(
			'default' => 'top',
		) );

		$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer,
			"sticky_widget_{$i}_position_vertical_control", array(
				'label'    => 'Vertical Alignment',
				'section'  => "sticky_widget_{$i}_section",
				'settings' => "sticky_widget_{$i}_position_vertical_setting",
				'type'     => 'radio',
				'choices'  => array(
					'top'    => 'Top',
					'bottom' => 'Bottom',
				),
			) ) );

		// hide on pc
		$wp_customizer->add_setting( "sticky_widget_{$i}_hide_pc_setting", array(
			'default' => false,
		) );

		$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, "sticky_widget_{$i}_hide_pc_control",
			array(
				'label'    => 'Hide On PC',
				'section'  => "sticky_widget_{$i}_section",
				'settings' => "sticky_widget_{$i}_hide_pc_setting",
				'type'     => 'checkbox',
			) ) );

		// hide on mobile
		$wp_customizer->add_setting( "sticky_widget_{$i}_hide_mobile_setting", array(
			'default' => false,
		) );

		$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, "sticky_widget_{$i}_hide_mobile_control",
			array(
				'label'    => 'Hide On Mobile',
				'section'  => "sticky_widget_{$i}_section",
				'settings' => "sticky_widget_{$i}_hide_mobile_setting",
				'type'     => 'checkbox',
			) ) );
	}
}

function google_analytic_customizer( $wp_customizer ) {
	$wp_customizer->add_section( 'google_analytics_section', array(
		'title'       => __( 'Google Analytics Setting', 'lorem' ),
		'description' => __( 'Google analytics', 'lorem' ),
		'priority'    => 120,
	) );

	$wp_customizer->add_setting( 'google_analytics_setting', array() );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'google_analytics_control', array(
		'label'    => 'Measurement ID',
		'section'  => 'google_analytics_section',
		'settings' => 'google_analytics_setting',
		'type'     => 'text',
	) ) );
}

function breadcrumbs_customizer( $wp_customizer ) {
	$wp_customizer->add_section( 'breadcrumbs_section', array(
		'title'       => __( 'Breadcrumbs Setting', 'lorem' ),
		'description' => __( 'All In One Breadcrumbs', 'lorem' ),
		'priority'    => 119,
	) );

	// font size
	$wp_customizer->add_setting( 'breadcrumbs_font_size_setting', array(
		'default' => THEME_FONT_SIZE_DEFAULT,
	) );

	$wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'breadcrumbs_font_size_control', array(
		'label'    => 'Font Size',
		'section'  => 'breadcrumbs_section',
		'settings' => 'breadcrumbs_font_size_setting',
		'type'     => 'select',
		'choices'  => THEME_FONT_SIZE,
	) ) );

	// font color
	$wp_customizer->add_setting( 'breadcrumbs_text_color_setting', array(
		'default' => '#000000',
	) );

	$wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
		'breadcrumbs_text_color_control',
		array(
			'label'    => 'Text Color',
			'section'  => 'breadcrumbs_section',
			'settings' => 'breadcrumbs_text_color_setting',
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
		'name'          => __( 'Footer Sidebar 1', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="widget widget-footer prose max-w-none mb-10 %2$s">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'footer_2',
		'name'          => __( 'Footer Sidebar 2', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="widget widget-footer prose max-w-none mb-10 %2$s">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'footer_3',
		'name'          => __( 'Footer Sidebar 3', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="widget widget-footer prose max-w-none mb-10 %2$s">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'footer_4',
		'name'          => __( 'Footer Sidebar 4', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="widget widget-footer prose max-w-none mb-10 %2$s">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'sticky_widget_1',
		'name'          => __( 'Sticky Widget 1', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="sticky-widget">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'sticky_widget_2',
		'name'          => __( 'Sticky Widget 2', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="sticky-widget">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'sticky_widget_3',
		'name'          => __( 'Sticky Widget 3', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="sticky-widget">',
		'after_widget'  => '</section>',
	) );

	register_sidebar( array(
		'id'            => 'sticky_widget_4',
		'name'          => __( 'Sticky Widget 4', 'lorem' ),
		'before_widget' => '<section id="%1$s" class="sticky-widget">',
		'after_widget'  => '</section>',
	) );
}

function css_theme_mod_generator( $class, $settings = array(), $manuals = array() ) {
	$css = '';
	foreach ( $settings as $attr => $mod ) {
		$value = get_theme_mod( $mod );
		if ( empty( $value ) ) {
			continue;
		}

		// check important flag
		$flag = false;
		if ( strpos( $attr, '!' ) !== false ) {
			$flag = true;

			// remove ! flag from string
			$attr = str_replace( '!', '', $attr );
		}

		// check explode flag
		if ( strpos( $attr, '|' ) !== false ) {
			$exp   = explode( '|', $attr );
			$value = explode( '|', $value )[ $exp[1] ];

			// remove explode flag
			$attr = str_replace( array( '|', $exp[1] ), '', $attr );
		}

		$css .= "{$attr}:{$value}";
		if ( $flag ) {
			$css .= ' !important';
		}
		$css .= ';';
	}

	// manual attributes
	foreach ( $manuals as $attr => $value ) {
		$css .= "{$attr}:{$value};";
	}

	return "{$class}{{$css}}";
}

function lorem_css_customizer() {
	$css = 'html{';

	$english_font = explode( ":", get_theme_mod( 'font_english_setting', 'Montserrat:wght@400;700' ) )[0];
	if ( strpos( $english_font, '+' ) ) {
		$english_font = str_replace( '+', ' ', $english_font );
		$english_font = '"' . $english_font . '"';
	}

	$thai_font = explode( ":", get_theme_mod( 'font_thai_setting', 'Sarabun:wght@400;700' ) )[0];
	$css       .= "font-family:{$english_font},{$thai_font},sans-serif;";

	$css .= '}';

	// global
	$css .= css_theme_mod_generator( 'a', array( 'color' => 'archer_color_setting' ) );
	$css .= css_theme_mod_generator( 'input', array(), array( 'color' => '#000000' ) );
	$css .= css_theme_mod_generator( '.prose', array( 'color' => 'font_color_setting' ) );

	// header menu
	$css .= css_theme_mod_generator( '.header-menu a', array( 'color' => 'header_menu_archer_text_color_setting' ) );
	$css .= css_theme_mod_generator( '.header-menu a:hover', array( 'color' => 'header_menu_archer_text_color_hover_setting' ) );
	$css .= css_theme_mod_generator( '.header-menu .menu-item-has-children .sub-menu', array( 'background-color' => 'header_menu_color_setting' ) );

	$css .= '.header-menu .menu-item:hover{';

	$header_menu_transparent = get_theme_mod( 'header_menu_archer_background_transparent_setting', true );
	if ( ! $header_menu_transparent && ! empty( get_theme_mod( 'header_menu_archer_background_setting' ) ) ) {
		$color = get_theme_mod( 'header_menu_archer_background_setting' );
		$css   .= "background-color:{$color};";
	}
	$css .= '}';

	// register menu
//	$register_menu_button = get_theme_mod( 'header_register_is_button_setting', false );
//	if ( $register_menu_button ) {
//		$css .= '.register-menu a{';
//
//		$border = get_theme_mod( 'header_register_button_border_size_setting' );
//		$color  = get_theme_mod( 'header_register_button_border_color_setting' );
//		$css    .= "border:solid {$border} {$color};";
//
//
//		$css .= '}';
//	}

	// main content
	$css .= css_theme_mod_generator( '.main-content p,.main-content li,.main-content address', array(
		'color'         => 'font_color_setting',
		'font-size|0'   => 'font_size_setting',
		'line-height|1' => 'font_size_setting',
	) );
	$css .= css_theme_mod_generator( '.main-content strong', array( 'color' => 'strong_color_setting' ) );
	$css .= css_theme_mod_generator( '.main-content h1,.main-content h1 strong', array(
		'color!'      => 'h1_color_setting',
		'font-size|0' => 'h1_size_setting',
	) );
	$css .= css_theme_mod_generator( '.main-content h2,.main-content h2 strong', array(
		'color!'      => 'h2_color_setting',
		'font-size|0' => 'h2_size_setting',
	) );
	$css .= css_theme_mod_generator( '.main-content h3,.main-content h3 strong', array(
		'color!'      => 'h3_color_setting',
		'font-size|0' => 'h3_size_setting',
	) );

	// footer content
	$css .= css_theme_mod_generator( '.footer-content h1,.footer-content h2,.footer-content h3', array(
		'font-size' => 'footer_header_size_setting',
		'color'     => 'footer_header_color_setting',
	), array( 'margin-top' => '0 !important' ) );
	$css .= css_theme_mod_generator( '.footer-content p', array(
		'font-size|0'   => 'footer_p_size_setting',
		'line-height|1' => 'footer_p_size_setting',
		'color'         => 'footer_p_color_setting',
	) );
	$css .= css_theme_mod_generator( '.footer-content a', array(
		'font-size|0'   => 'footer_p_size_setting',
		'line-height|1' => 'footer_p_size_setting',
		'color'         => 'footer_a_color_setting',
	) );
	$css .= css_theme_mod_generator( '.copyright', array( 'color' => 'copyright_text_color_setting' ) );
	$css .= css_theme_mod_generator( '.copyright a', array( 'color' => 'footer_a_color_setting' ) );

	// mobile menu
	$css .= css_theme_mod_generator( '.mobile-menu a', array( 'color' => 'footer_mobile_a_color_setting' ) );

	// widget footer
	$css .= css_theme_mod_generator( '.widget-footer.prose ul>li:before', array( 'background-color!' => 'footer_bullet_setting' ) );

	// widget sidebar
	$css .= css_theme_mod_generator( '.widget-primary h2', array(
		'color!'           => 'header_widget_text_color_setting',
		'background-color' => 'header_widget_color_setting'
	) );
	$css .= css_theme_mod_generator( '.widget-primary.prose ul>li:before', array( 'background-color!' => 'bullet_widget_color_setting' ) );
	$css .= css_theme_mod_generator( '.widget-primary.prose', array( 'color' => 'font_primary_widget_color_control' ) );
	$css .= css_theme_mod_generator( '.widget-primary .wp-block-tag-cloud a', array(
		'background-color' => 'tag_cloud_widget_background_color_setting',
		'color'            => 'tag_cloud_widget_text_color_setting'
	) );
	$css .= css_theme_mod_generator( '.aioseo-breadcrumbs', array(
		'font-size|0' => 'breadcrumbs_font_size_setting',
		'color'       => 'breadcrumbs_text_color_setting',
	) );

	// reset tag cloud font size
	$css .= '.wp-block-tag-cloud{display:flex;flex-wrap:wrap;}.wp-block-tag-cloud a{font-size:100% !important;margin:0 5px 5px 0;}';

	return $css;
}

function sticky_widget_style( $horizontal, $vertical, $hide_mobile = false, $hide_pc = false ) {
	$rtn = '';
	switch ( $horizontal ) {
		case 'right':
			$rtn .= 'right-5 ';
			break;
		case 'left':
			$rtn .= 'left-5 ';
			break;
	}

	switch ( $vertical ) {
		case 'top':
			$rtn .= 'top-5 ';
			break;
		case 'bottom':
			$rtn .= 'bottom-5 ';
			break;
	}

	$rtn .= 'flex md:flex ';
	if ( $hide_mobile ) {
		$rtn .= 'hidden ';
	}
	if ( $hide_pc ) {
		$rtn .= 'md:hidden ';
	}

	return $rtn;
}

function footer_widget_style() {
	$column   = get_theme_mod( 'footer_column_setting' );
	$column_1 = 'md:w-1/2';
	$column_2 = 'md:w-1/2';
	$column_3 = 'md:w-1/3';

	if ( $column == 2 ) {
		$layout = get_theme_mod( 'footer_2_columns_layout_setting' );
		switch ( $layout ) {
			case '1|1':
				$column_1 = 'md:w-1/2';
				$column_2 = 'md:w-1/2';
				break;
			case '1|2':
				$column_1 = 'md:w-1/3';
				$column_2 = 'md:w-2/3';
				break;
			case '2|1':
				$column_1 = 'md:w-2/3';
				$column_2 = 'md:w-1/3';
				break;
		}
	} else if ( $column == 3 ) {
		$layout = get_theme_mod( 'footer_3_columns_layout_setting' );
		switch ( $layout ) {
			case '1|1|1':
				$column_1 = 'md:w-1/3';
				$column_2 = 'md:w-1/3';
				$column_3 = 'md:w-1/3';
				break;
			case '1|1|2':
				$column_1 = 'md:w-1/4';
				$column_2 = 'md:w-1/4';
				$column_3 = 'md:w-2/4';
				break;
			case '1|2|1':
				$column_1 = 'md:w-1/4';
				$column_2 = 'md:w-2/4';
				$column_3 = 'md:w-1/4';
				break;
			case '2|1|1':
				$column_1 = 'md:w-2/4';
				$column_2 = 'md:w-1/4';
				$column_3 = 'md:w-1/4';
				break;
		}
	}

	return array( $column, $column_1, $column_2, $column_3 );
}

function header_background() {
	$base     = get_theme_mod( 'header_color_setting' );
	$gradient = get_theme_mod( 'header_color_gradient_to_setting' );

	if ( ! empty( $gradient ) && $base != $gradient ) {
		return "background-image:linear-gradient({$base},{$gradient});";
	}

	return "background-color:{$base};";
}

function footer_background() {
	$base     = get_theme_mod( 'footer_color_setting' );
	$gradient = get_theme_mod( 'footer_color_gradient_to_setting' );

	if ( ! empty( $gradient ) || $base != $gradient ) {
		return "background-image:linear-gradient({$base},{$gradient});";
	}

	return "background-color:{$base};";
}

// add action
add_action( 'init', 'register_menus' );
add_action( 'init', 'lorem_widgets_init' );
add_action( 'after_setup_theme', 'add_image_sizes' );
add_action( 'wp_enqueue_scripts', 'register_custom_style' );
//add_action( 'wp_enqueue_scripts', 'register_google_fonts' );
add_action( 'wp_enqueue_scripts', 'dequeue_plugin_style', 999 );
add_action( 'customize_register', 'font_theme_customizer' );
add_action( 'customize_register', 'header_theme_customizer' );
add_action( 'customize_register', 'footer_theme_customizer' );
add_action( 'customize_register', 'colors_theme_customizer' );
add_action( 'customize_register', 'widget_theme_customizer' );
add_action( 'customize_register', 'sticky_widget_theme_customizer' );
add_action( 'customize_register', 'google_analytic_customizer' );
add_action( 'customize_register', 'breadcrumbs_customizer' );

// add filter
add_filter( 'image_size_names_choose', 'image_sizes_name' );
add_filter( 'nav_menu_css_class', 'header_menu_li_classes', 1, 3 );
add_filter( 'nav_menu_link_attributes', 'header_menu_archer_classes', 10, 3 );
add_filter( 'image_send_to_editor', 'make_image_relative_path' );