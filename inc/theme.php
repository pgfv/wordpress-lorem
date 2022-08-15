<?php

class LoremTheme {
    private $version;
    private $theme_name;
    private $font_sizes;
	private $font_size_default;

    function init() {
        $this->theme_support();

        add_action( 'init', [ $this, 'register_navigation_menus' ] );
        add_action( 'init', [ $this, 'init_widgets' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'register_custom_style' ] ); 
        add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_plugin_style' ], 999 );
        add_action( 'wp_head', [ $this, 'customize_css' ] );
        add_action( 'customize_register', [ $this, 'theme_customizer' ] );

        add_filter( 'image_size_names_choose', [ $this, 'image_sizes_name' ] );
        add_filter( 'image_send_to_editor', [ $this, 'make_image_relative_path' ] );
        add_filter( 'nav_menu_css_class', [ $this, 'header_menu_li_classes' ], 1, 3 );
        add_filter( 'nav_menu_link_attributes', [ $this, 'header_menu_archer_classes' ], 10, 3 );

        add_shortcode( 'ufaloginform', [ $this, 'ufa_login_form' ] );
    }

    function __construct() {
        $this->version = wp_get_theme()->version;
        $this->theme_name = 'lorem';
        $this->font_size_default = '1rem|1.5rem';
        $this->font_sizes = array(
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
    }

    function theme_support() {
        if ( function_exists( 'add_theme_support' ) ) {
            add_theme_support( 'title-tag' );
            add_theme_support( 'menus' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'custom-logo', array( 'width' => 350, 'height' => 200 ) );
        }

        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'logo-350w', 350 );
            add_image_size( 'menu-36x36', 36, 36 );
        }        
    }

    function image_sizes_name( $sizes ) {
        $sizes['menu-36x36'] = __( 'Menu 36x36', $this->theme_name );

        return $sizes;
    }

    function register_custom_style() {
        wp_register_style( 'tailwind', get_template_directory_uri() . '/assets/css/style.css', array(), $this->version, 'all' );
	    wp_enqueue_style( 'tailwind' );
    }

    function dequeue_plugin_style() {
        wp_dequeue_style( 'dashicons' );
        wp_dequeue_style( 'font-awesome' );
        wp_dequeue_style( 'menu-icons-extra' );
    }

    function register_navigation_menus() {
        register_nav_menus( array(
            'header-menu'     => __( 'Header Menu', $this->theme_name ),
            'top-header-menu' => __( 'Top Header Menu', $this->theme_name ),
            'register-menu'   => __( 'Register Menu', $this->theme_name ),
            'mobile-menu'     => __( 'Mobile Menu', $this->theme_name ),
        ) );
    }

    function make_image_relative_path( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
        $image_url    = wp_get_attachment_image_src( $id, $size );
        $relative_url = wp_make_link_relative( $image_url[0] );
        $html         = str_replace( $image_url[0], $relative_url, $html );
    
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

    function init_widgets() {
        // primary sidebar
        register_sidebar( array(
            'id'            => 'primary',
            'name'          => __( 'Primary Sidebar', $this->theme_name ),
            'before_widget' => '<section id="%1$s" class="widget widget-primary prose max-w-none mb-10 %2$s">',
            'after_widget'  => '</section>',
        ) );

        // top header 
        register_sidebar( array(
            'id'            => 'top_header',
            'name'          => __( 'Top Header', $this->theme_name ),
            'before_widget' => '<section id="%1$s" class="top-header %s$s">',
            'after_widget'  => '</section>',
        ) );

        // header banner
        register_sidebar( array(
            'id'            => 'header_banner',
            'name'          => __( 'Header Banner', $this->theme_name ),
            'before_widget' => '<section id="%1$s" class="header-banner %s$s">',
            'after_widget'  => '</section>',
        ) );

        // footer
        for ( $i = 1; $i <= 4; $i++ ) {
            register_sidebar( array( 
                'id'            => "footer_{$i}",
                'name'          => __( "Footer Sidebar {$i}", $this->theme_name ),
                'before_widget' => '<section id="%1$s" class="widget widget-footer prose max-w-none mb-10 %2$s">',
                'after_widget'  => '</section>',
            ) );
        }

        // sticky 
        for ( $i = 1; $i <= 4; $i++ ) {
            register_sidebar( array(
                'id'            => "sticky_widget_{$i}",
                'name'          => __( "Sticky Widget {$i}", 'lorem' ),
                'before_widget' => '<section id="%1$s" class="sticky-widget %2$s">',
                'after_widget'  => '</section>',
            ) );
        }
    }

    function ufa_login_form() {
        $response  = wp_remote_get( 'https://ufacurlapi.theautob.com/ufa_login' );
        $body      = wp_remote_retrieve_body( $response );
        $obj       = json_decode( $body );
        $viewstate = $obj->{'data'}->{'viewstate'};
        $generator = $obj->{'data'}->{'viewstategenerator'};
    
        ob_start();
        ?>
        <form id="form2" name="form2" method="post" action="https://www.usa2468.com/Default8.aspx?lang=EN-GB" rel="nofollow">
            <div class="aspNetHidden">
            <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="btnLogin">
            <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="">
            <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="<?php echo $viewstate; ?>">
            <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="<?php echo $generator; ?>">
            </div>
    
            <div class="col-md-12">
                <div class="form-group">
                <center>
                    <input id="txtUserName" name="txtUserName" type="text" style="width:90%;margin:auto;padding:12px 0px 13px 18px;border-radius:20px;border:solid 1px #d5ccb7;background-color:#ffffff;font-size:1rem;" placeholder="ชื่อผู้ใช้">
                    <br><br>
                    <input id="password" name="password" type="password" placeholder="รหัสผ่าน" style="width:90%;margin:auto;padding:12px 0px 13px 18px;border-radius:20px;border:solid 1px #d5ccb7;background-color:#ffffff;font-size:1rem;">
                    <br><br>
                    <input type="submit" style="font-size:1rem;padding: 0.75em;background: linear-gradient(to bottom, #e7d39d, #b19560);margin: 6px 0px;color: black;border-radius: 5em;width: 90%;text-transform: uppercase;font-weight: bold;display: inline-block;text-align: center;" value="เข้าสู่ระบบ">
                </center>
                </div>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }

    // theme customizer
    function theme_customizer( $wp_customizer ) {
        $this->customizer_general( $wp_customizer );
        $this->customizer_header( $wp_customizer );
        $this->customizer_footer( $wp_customizer );
        $this->customizer_breadcrumb( $wp_customizer );
        $this->customizer_widgets( $wp_customizer );
        $this->customizer_google_analytics( $wp_customizer );
    }

    function customizer_general( $wp_customizer ) {
        // General Settings: layout, font, base color
        $wp_customizer->add_panel( 'general_panel', array( 
            'title'    => __( 'General', $this->theme_name ),
            'priority' => 99,
        ) );

        // General -> layout
        $wp_customizer->add_section( 'general_layout_section', array(
            'title'    => __( 'Layout', $this->theme_name ),
            'priority' => 1,
            'panel'    => 'general_panel',
        ) );

        // General -> style
        $wp_customizer->add_section( 'general_style_section', array( 
            'title'    => __( 'Style', $this->theme_name ),
            'priority' => 2,
            'panel'    => 'general_panel',
        ) );

        // General -> style -> background color
        $wp_customizer->add_setting( 'background_color_setting', array( 'default' => '#FFFFFF' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'background_color_control', array(
            'label'    => __( 'Background Color', $this->theme_name ),
            'section'  => 'general_style_section',
            'settings' => 'background_color_setting',
        ) ) );

        // General -> style -> background gradient color
        $wp_customizer->add_setting( 'background_gradient_to_setting', array( 'default' => '#FFFFFF' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'background_gradient_to_control', array(
            'label'    => __( 'Background Gradient', $this->theme_name ),
            'section'  => 'general_style_section',
            'settings' => 'background_gradient_to_setting',
        ) ) );

        // General -> style -> font color
        $wp_customizer->add_setting( 'font_color_setting', array( 'default' => '#374151' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'font_color_setting', array(
            'label'    => __( 'Color', $this->theme_name ),
            'section'  => 'general_style_section',
            'settings' => 'font_color_setting',
        ) ) );

        // General -> style -> strong color
        $wp_customizer->add_setting( 'strong_color_setting', array( 'default' => '#374151' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'strong_color_setting', array(
            'label'    => __( 'Strong Color', $this->theme_name ),
            'section'  => 'general_style_section',
            'settings' => 'strong_color_setting',
        ) ) );

        // General -> style -> link color
        $wp_customizer->add_setting( 'archer_color_setting', array( 'default' => '#374151' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'archer_color_control', array(
            'label'    => __( 'Link Color', $this->theme_name ),
            'section'  => 'general_style_section',
            'settings' => 'archer_color_setting',
        ) ) );

        // General -> style -> link hover
        $wp_customizer->add_setting( 'archer_hover_color_setting', array( 'default' => '#374151' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'archer_hover_color_control', array(
            'label'    => __( 'Link Hover Color', $this->theme_name ),
            'section'  => 'general_style_section',
            'settings' => 'archer_hover_color_setting',
        ) ) );

        // General -> header
        $wp_customizer->add_section( 'general_header_section', array(
            'title'    => __( 'Header', $this->theme_name ),
            'priority' => 3,
            'panel'    => 'general_panel',
        ) );

        for ( $i = 1; $i <= 5; $i++ ) {
            // General -> header -> size
            $wp_customizer->add_setting( "h{$i}_size_setting", array( 'default' => $this->font_size_default ) );
            $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, "h{$i}_size_control", array(
                'label'    => "H{$i} Size",
                'section'  => 'general_header_section',
                'settings' => "h{$i}_size_setting",
                'type'     => 'select',
                'choices'  => $this->font_sizes,
            ) ) );    

            // General -> header -> color
            $wp_customizer->add_setting( "h{$i}_color_setting", array( 'default' => '#111827' ) );
            $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, "h{$i}_color_control", array(
                'label'    => "H{$i} Color",
                'section'  => 'general_header_section',
                'settings' => "h{$i}_color_setting",                
            ) ) );
        }

        // General -> text
        $wp_customizer->add_section( 'general_text_section', array(
            'title'    => __( 'Text', $this->theme_name ),
            'priority' => 4,
            'panel'    => 'general_panel',
        ) );

        // General -> text -> thai font
        $wp_customizer->add_setting( 'font_thai_setting', array( 'default' => 'Sarabun:wght@400;700' ) );
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'font_thai_control', array(
            'label'    => __( 'Thai Font Family', $this->theme_name ),
            'section'  => 'general_text_section',
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

        // General -> text -> english font
        $wp_customizer->add_setting( 'font_english_setting', array( 'default' => 'Montserrat:wght@400;700' ) );
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'font_english_control', array(
            'label'    => __( 'English Font Family', $this->theme_name ),
            'section'  => 'general_text_section',
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

        
    }

    function customizer_header( $wp_customizer ) {
        // Header Settings
        $wp_customizer->add_panel( 'header_panel', array( 
            'title'    => __( 'Header', $this->theme_name ),
            'priority' => 100,
        ) );

        // Header -> top header 
        $wp_customizer->add_section( 'top_header_section', array(
            'title'    => __( 'Top Header', $this->theme_name ),
            'priority' => 1,
            'panel'    => 'header_panel',
        ) );

        // Header -> top header -> display
        $wp_customizer->add_setting( 'top_header_display_setting', array( 'default' => 'none' ) );
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'top_header_display_control', array(
            'label'    => 'Top Header',
            'section'  => 'top_header_section',
            'settings' => 'top_header_display_setting',
            'type'     => 'select',
            'choices'  => array(
                'none'   => 'None',
                'menu'   => 'Top Header Menu',
                'widget' => 'Top Header Widget',
            ),
        ) ) );

        // Header -> top header style
        $wp_customizer->add_section( 'top_header_style_section', array(
            'title'    => __( 'Top Header Style', $this->theme_name ),
            'priority' => 2,
            'panel'    => 'header_panel',
        ) );

        // Header -> top header style -> background color
        $wp_customizer->add_setting( 'top_header_background_color_setting' );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'top_header_background_color_control', array(
            'label'    => 'Background Color',
            'section'  => 'top_header_style_section',
            'settings' => 'top_header_background_color_setting',
        ) ) );

        // Header -> top header style -> background color gradient to
        $wp_customizer->add_setting( 'top_header_background_gradient_to_setting' );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'top_header_background_gradient_to_control',
            array(
                'label'    => 'Background Gradient',
                'section'  => 'top_header_style_section',
                'settings' => 'top_header_background_gradient_to_setting',
            ) ) );

        // Header -> style 
        $wp_customizer->add_section( 'header_color_section', array(
            'title'    => __( 'Header Style', $this->theme_name ),
            'priority' => 3,
            'panel'    => 'header_panel',
        ) );

        // Header -> style -> background color
        $wp_customizer->add_setting( 'header_color_setting', array( 'default' => '#9CA3AF' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_color_control', array(
            'label'    => __( 'Background Color', $this->theme_name ),
            'section'  => 'header_color_section',
            'settings' => 'header_color_setting',
        ) ) );

        // Header -> style -> background color gradient to
        $wp_customizer->add_setting( 'header_color_gradient_to_setting', array( 'default' => '#9CA3AF' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_color_gradient_to_control',
            array(
                'label'    => __( 'Background Gradient', $this->theme_name ),
                'section'  => 'header_color_section',
                'settings' => 'header_color_gradient_to_setting',
            ) ) );

        // Header -> style -> font color
        $wp_customizer->add_setting( 'header_menu_color_setting', array( 'default' => '#E5E7EB' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_menu_color_control', array(
            'label'    => __( 'Text Color', $this->theme_name ),
            'section'  => 'header_color_section',
            'settings' => 'header_menu_color_setting',
        ) ) );

        // Header -> style -> hamburger color
        $wp_customizer->add_setting( 'header_hamburger_color_setting', array( 'default' => '#000000' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'header_hamburger_color_control',
            array(
                'label'    => __( 'Hamburger Color', $this->theme_name ),
                'section'  => 'header_color_section',
                'settings' => 'header_hamburger_color_setting',
            ) ) );

        // Header -> banner
        $wp_customizer->add_section( 'header_banner_section', array(
            'title'    => __( 'Banner', $this->theme_name ),
            'priority' => 5,
            'panel'    => 'header_panel',
        ) );

        // Header -> banner -> display
        $wp_customizer->add_setting( 'header_banner_display_setting', array( 'default' => 'none' ) );
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_banner_display_control', array(
            'label'    => __( 'Banner', $this->theme_name ),
            'section'  => 'header_banner_section',
            'settings' => 'header_banner_display_setting',
            'type'     => 'select',
            'choices'  => array(
                'none'   => 'None',
                'widget' => 'Header Banner Widget',
            ),
        ) ) );

        // Header -> main menu
        $wp_customizer->add_section( 'header_main_menu_section', array( 
            'title'    => __( 'Main Menu', $this->theme_name ),
            'priority' => 6,
            'panel'    => 'header_panel',
        ) );

        // Header -> main menu -> background color
        $wp_customizer->add_setting( 'header_menu_background_color_setting', array( 'default' => '#FFFFFF' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_background_color_control',
            array(
                'label'    => __( 'Background Color', $this->theme_name ),
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_background_color_setting',
            ) ) );

        // Header -> main menu -> background color gradient
        $wp_customizer->add_setting( 'header_menu_background_gradient_to_setting', array( 'default' => '#FFFFFF' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_background_gradient_to_control',
            array(
                'label'    => __( 'Background Gradient', $this->theme_name ),
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_background_gradient_to_setting',
            ) ) );

        // Header -> main menu -> link color
        $wp_customizer->add_setting( 'header_menu_archer_text_color_setting', array( 'default' => '#000000' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_archer_text_color_control',
            array(
                'label'    => __( 'Link Color', $this->theme_name ),
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_archer_text_color_setting',
            ) ) );

        // Header -> main menu -> link hover color
        $wp_customizer->add_setting( 'header_menu_archer_text_color_hover_setting', array( 'default' => '#000000' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_archer_text_color_hover_control',
            array(
                'label'    => __( 'Link Hover Color', $this->theme_name ),
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_archer_text_color_hover_setting',
            ) ) );

        // Header -> main menu -> transparent background color
        $wp_customizer->add_setting( 'header_menu_archer_background_transparent_setting', array( 'default' => true ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_archer_background_transparent_control',
            array(
                'label'    => __( 'Transaparent Background Color', $this->theme_name ),
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_archer_background_transparent_setting',
                'type'     => 'checkbox',
            ) ) );

        // Header -> main menu -> link background color
        $wp_customizer->add_setting( 'header_menu_archer_background_setting', array( 'default' => '#E5E7EB' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_archer_background_control',
            array(
                'label'    => __( 'Link Background Color', $this->theme_name ),
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_archer_background_setting',
            ) ) );

        // Header -> main menu -> enable link background hover color
        $wp_customizer->add_setting( 'header_menu_archer_background_transparent_hover_setting', array( 'default' => true ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_archer_background_transparent_hover_control',
            array(
                'label'    => __( 'Transaparent Background Color Hover', $this->theme_name ),
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_archer_background_transparent_hover_setting',
                'type'     => 'checkbox',
            ) ) );

        // Header -> main menu -> link background hover color
        $wp_customizer->add_setting( 'header_menu_archer_background_hover_setting', array( 'default' => '#E5E7EB' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'header_menu_archer_background_hover_control',
            array(
                'label'    => 'Link Background Hover Color',
                'section'  => 'header_main_menu_section',
                'settings' => 'header_menu_archer_background_hover_setting',
            ) ) );
        
        // Header -> content
        $wp_customizer->add_section( 'header_content_section', array(
            'title'    => __( 'Content', $this->theme_name ),
            'priority' => 7,
            'panel'    => 'header_panel'
        ) );

        // Header -> content -> content
        $wp_customizer->add_setting( 'header_foot_content_setting' );
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_foot_content_control', array(
            'label'    => __( 'Content', $this->theme_name ),
            'section'  => 'header_content_section',
            'settings' => 'header_foot_content_setting',
            'type'     => 'textarea',
        ) ) );

        // Header -> register menu
        $wp_customizer->add_section( 'header_register_section', array(
            'title'    => __( 'Register Menu', $this->theme_name ),
            'priority' => 7,
            'panel'    => 'header_panel',
        ) );

        // Header -> register menu -> sticky menu
        $wp_customizer->add_setting( 'header_sticky_register_setting', array( 'default' => true ) );    
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'header_register_control', array(
            'label'    => __( 'Sticky Register Menu', $this->theme_name ),
            'section'  => 'header_register_section',
            'settings' => 'header_sticky_register_setting',
            'type'     => 'checkbox',
        ) ) );
    }

    function customizer_footer( $wp_customizer ) {
        // Footer Settings
        $wp_customizer->add_panel( 'footer_panel', array(
            'title'       => __( 'Footer', $this->theme_name ),
            'priority'    => 102,
        ) );

        // Footer -> columns
        $wp_customizer->add_section( 'footer_columns_section', array(
            'title'       => __( 'Columns', $this->theme_name ),
            'description' => __( 'Change how many columns you want to display', $this->theme_name ),
            'priority'    => 1,
            'panel'       => 'footer_panel',
        ) );
    
        // Footer -> columns -> number
        $wp_customizer->add_setting( 'footer_column_setting', array( 'default' => 3 ) );    
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
    
        // Footer -> columns -> 2 columns layout
        $wp_customizer->add_setting( 'footer_2_columns_layout_setting', array( 'default' => '1|1' ) );    
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
    
        // Footer -> columns -> 3 columns layout
        $wp_customizer->add_setting( 'footer_3_columns_layout_setting', array( 'default' => '1|1|1' ) );    
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

        // Footer -> style
        $wp_customizer->add_section( 'footer_color_section', array(
            'title'    => __( 'Footer Style', $this->theme_name ),
            'priority' => 2,
            'panel'    => 'footer_panel',
        ) );

        // Footer -> style -> background color
        $wp_customizer->add_setting( 'footer_color_setting', array( 'default' => '#9CA3AF' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_color_control', array(
            'label'    => __( 'Background Color', $this->theme_name ),
            'section'  => 'footer_color_section',
            'settings' => 'footer_color_setting',
        ) ) );

        // Footer -> style -> background color gradient to
        $wp_customizer->add_setting( 'footer_color_gradient_to_setting', array( 'default' => '#9CA3AF' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_color_gradient_to_control',
            array(
                'label'    => __( 'Background Gradient', $this->theme_name ),
                'section'  => 'footer_color_section',
                'settings' => 'footer_color_gradient_to_setting',
            ) ) );

        // Footer -> style -> font color
        $wp_customizer->add_setting( 'footer_p_color_setting', array( 'default' => '#D1D5DB' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_p_color_control', array(
            'label'    => __( 'Font Color', $this->theme_name ),
            'section'  => 'footer_color_section',
            'settings' => 'footer_p_color_setting',
        ) ) );    

        // Footer -> style -> link color
        $wp_customizer->add_setting( 'footer_a_color_setting', array( 'default' => '#D1D5DB' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_a_color_control', array(
            'label'    => __( 'Link Color', $this->theme_name ),
            'section'  => 'footer_color_section',
            'settings' => 'footer_a_color_setting',
        ) ) );

        // Footer -> style -> link hover color
        $wp_customizer->add_setting( 'footer_a_hover_color_setting', array( 'default' => '#D1D5DB' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_a_hover_color_control', array(
            'label'    => __( 'Link Hover Color', $this->theme_name ),
            'section'  => 'footer_color_section',
            'settings' => 'footer_a_hover_color_setting',
        ) ) );

        // Footer -> style -> bullet color
        $wp_customizer->add_setting( 'footer_bullet_setting', array( 'default' => '#D1D5DB' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_bullet_control', array(
            'label'    => __( 'Bullet Color', $this->theme_name ),
            'section'  => 'footer_color_section',
            'settings' => 'footer_bullet_setting',
        ) ) );

        // Footer -> style -> copyright font color
        $wp_customizer->add_setting( 'copyright_text_color_setting', array( 'default' => '#D1D5DB' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'copyright_text_color_control', array(
            'label'    => __( 'Copyright Color', $this->theme_name ),
            'section'  => 'footer_color_section',
            'settings' => 'copyright_text_color_setting',
        ) ) );

        // Footer -> content
        $wp_customizer->add_section( 'footer_content_section', array(
            'title'    => __( 'Content', $this->theme_name ),
            'priority' => 3,
            'panel'    => 'footer_panel',
        ) );

        // Footer -> content -> copyright
        $wp_customizer->add_setting( 'copyright_text_setting' );
        $wp_customizer->add_control( 'copyright_text_control', array(
            'label'    => __( 'Copyright', $this->theme_name ),
            'section'  => 'footer_content_section',
            'settings' => 'copyright_text_setting',
            'type'     => 'textarea',
        ) );

        // Footer -> mobile menu
        $wp_customizer->add_section( 'footer_mobile_menu_section', array(
            'title' => __( 'Mobile Menu', $this->theme_name ),
            'panel' => 'footer_panel',
        ) );
        
        // Footer -> mobile menu display
        $wp_customizer->add_setting( 'footer_mobile_menu_display_setting', array( 'default' => true ) );
        $wp_customizer->add_control( 'footer_mobile_menu_display_control', array(
            'label'    => __( 'Display', $this->theme_name ),
            'section'  => 'footer_mobile_menu_section',
            'settings' => 'footer_mobile_menu_display_setting',
            'type'     => 'select',
            'choices'  => array( true => 'Enable', false => 'Disable' ),
        ) );

        // Footer -> mobile menu style
        $wp_customizer->add_section( 'footer_mobile_menu_style_section', array(
            'title' => __( 'Mobile Menu Style', $this->theme_name ),
            'panel' => 'footer_panel',
        ) );

        // Footer -> mobile menu style -> mobile menu background color
        $wp_customizer->add_setting( 'footer_mobile_color_setting', array( 'default' => '#9CA3AF' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_color_control', array(
            'label'    => __( 'Background Color', $this->theme_name ),
            'section'  => 'footer_mobile_menu_style_section',
            'settings' => 'footer_mobile_color_setting',
        ) ) );

        // Footer -> mobile menu style -> link color
        $wp_customizer->add_setting( 'footer_mobile_a_color_setting', array( 'default' => '#d1d5db' ) );    
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer, 'footer_mobile_a_color_control', array(
            'label'    => __( 'Link Color', $this->theme_name ),
            'section'  => 'footer_mobile_menu_style_section',
            'settings' => 'footer_mobile_a_color_setting',
        ) ) );
    }    

    function customizer_breadcrumb( $wp_customizer ) {
        // Breadcrumb Settings
        $wp_customizer->add_section( 'breadcrumbs_section', array(
            'title'       => __( 'Breadcrumbs', $this->theme_name ),
            'description' => __( 'All In One Breadcrumbs', $this->theme_name ),
            'priority'    => 119,
        ) );
    
        // Breadcrumb -> font size
        $wp_customizer->add_setting( 'breadcrumbs_font_size_setting', array( 'default' => $this->font_size_default ) );
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'breadcrumbs_font_size_control', array(
            'label'    => 'Font Size',
            'section'  => 'breadcrumbs_section',
            'settings' => 'breadcrumbs_font_size_setting',
            'type'     => 'select',
            'choices'  => $this->font_sizes,
        ) ) );
    
        // Breadcrumb -> font color
        $wp_customizer->add_setting( 'breadcrumbs_text_color_setting', array( 'default' => '#000000' ) );
        $wp_customizer->add_control( new WP_Customize_Color_Control( $wp_customizer,
            'breadcrumbs_text_color_control',
            array(
                'label'    => 'Text Color',
                'section'  => 'breadcrumbs_section',
                'settings' => 'breadcrumbs_text_color_setting',
            ) ) );
    }

    function customizer_widgets( $wp_customizer ) {
        // Widget Settings
        $wp_customizer->add_panel( 'sticky_widget_panel', array(
            'title'    => __( 'Sticky Widgets', $this->theme_name ),
            'priority' => 115,
        ) );

        // Widget -> sticky 
        for ( $i = 1; $i <= 4; $i++ ) {
            $wp_customizer->add_section( "sticky_widget_{$i}_section", array(
                'title'    => __( "Sticky Widget {$i}", $this->theme_name ),
                'priority' => $i,
                'panel'  => 'sticky_widget_panel',
            ) );
    
            // sticky widget position horizontal
            $wp_customizer->add_setting( "sticky_widget_{$i}_position_horizontal_setting", array(
                'default' => 'right',
            ) );
    
            $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer,
                "sticky_widget_{$i}_position_horizontal_control", array(
                    'label'    => __( 'Horizontal Alignment', $this->theme_name ),
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
                    'label'    => __( 'Vertical Alignment', $this->theme_name ),
                    'section'  => "sticky_widget_{$i}_section",
                    'settings' => "sticky_widget_{$i}_position_vertical_setting",
                    'type'     => 'radio',
                    'choices'  => array(
                        'top'    => 'Top',
                        'bottom' => 'Bottom',
                    ),
                ) ) );
    
            // hide on pc
            $wp_customizer->add_setting( "sticky_widget_{$i}_hide_pc_setting", array( 'default' => false ) );    
            $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, "sticky_widget_{$i}_hide_pc_control",
                array(
                    'label'    => __( 'Hide On PC', $this->theme_name ),
                    'section'  => "sticky_widget_{$i}_section",
                    'settings' => "sticky_widget_{$i}_hide_pc_setting",
                    'type'     => 'checkbox',
                ) ) );
    
            // hide on mobile
            $wp_customizer->add_setting( "sticky_widget_{$i}_hide_mobile_setting", array( 'default' => false ) );    
            $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, "sticky_widget_{$i}_hide_mobile_control",
                array(
                    'label'    => __( 'Hide On Mobile', $this->theme_name ),
                    'section'  => "sticky_widget_{$i}_section",
                    'settings' => "sticky_widget_{$i}_hide_mobile_setting",
                    'type'     => 'checkbox',
                ) ) );
        }
    }

    function customizer_google_analytics( $wp_customizer ) {
        // Google Analytics Settings
        $wp_customizer->add_section( 'google_analytics_section', array(
            'title'       => __( 'Google Analytics', $this->theme_name ),
            'description' => __( 'Google analytics', $this->theme_name ),
            'priority'    => 120,
        ) );

        $wp_customizer->add_setting( 'google_analytics_setting' );
        $wp_customizer->add_control( new WP_Customize_Control( $wp_customizer, 'google_analytics_control', array(
            'label'    => 'Measurement ID',
            'section'  => 'google_analytics_section',
            'settings' => 'google_analytics_setting',
            'type'     => 'text',
        ) ) );
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

		if ( $css == '' ) {
			return '';
		}

		return "{$class}{{$css}}";
	}

    function css_theme_mod_gradient( $class, $settings, $gradient, $degree = '' ) {
		$b = get_theme_mod( $settings );
		$g = get_theme_mod( $gradient );

		if ( empty ( $b ) ) {
			return '';
		}

		if ( ! empty( $g ) && $b != $g ) {
			$output = '';
			if ( $degree != '' ) {
				$d = get_theme_mod( $degree );
				if ( ! empty( $d ) ) {
					$output .= "{$d}deg,";
				}
			}
			$output .= "{$b},{$g}";

			return "{$class}{background-image:linear-gradient({$output});}";
		}

		return "{$class}{background-color:{$b};}";
	}

    function custom_css_output() {
        $css = '';

        // global
        $css .= 'body{';
        $english_font = explode( ":", get_theme_mod( 'font_english_setting', 'Montserrat:wght@400;700' ) )[0];
        if ( strpos( $english_font, '+' ) ) {
            $english_font = str_replace( '+', ' ', $english_font );
            $english_font = '"' . $english_font . '"';
        }
        $thai_font = explode( ":", get_theme_mod( 'font_thai_setting', 'Sarabun:wght@400;700' ) )[0];

        $css .= "font-family:{$english_font},{$thai_font},sans-serif;";
        $css .= '}';

        // wrapper
        $css .= $this->css_theme_mod_gradient( '.wrapper-section', 'background_color_setting', 'background_gradient_to_setting' );

        // header
        $css .= $this->css_theme_mod_gradient( '.main-header', 'header_color_setting', 'header_color_gradient_to_setting' );

        // top header
        $css .= $this->css_theme_mod_gradient( '.top-header', 'top_header_background_color_setting', 'top_header_background_gradient_to_setting' );

        // header main menu
        $css .= $this->css_theme_mod_gradient( '.header-menu', 'header_menu_background_color_setting', 'header_menu_background_gradient_to_setting' );
        $css .= $this->css_theme_mod_generator( '.header-menu a', array( 'color' => 'header_menu_archer_text_color_setting' ) );
        $css .= $this->css_theme_mod_generator( '.header-menu a:hover', array( 'color' => 'header_menu_archer_text_color_hover_setting' ) );
        $css .= $this->css_theme_mod_generator( '.header-menu .menu-item-has-children .sub-menu', array( 'background-color' => 'header_menu_color_setting' ) );
        
        if ( ! get_theme_mod( 'header_menu_archer_background_transparent_setting' ) ) {
            $css .= $this->css_theme_mod_generator( '.header-menu .menu-item', array( 'background-color' => 'header_menu_archer_background_setting' ) );
        }
        if ( ! get_theme_mod( 'header_menu_archer_background_transparent_hover_setting' ) ) {
            $css .= $this->css_theme_mod_generator( '.header-menu .menu-item:hover', array( 'background-color' => 'header_menu_archer_background_hover_setting' ) );
        }
        
        // mobile menu
        $css .= $this->css_theme_mod_generator( '.mobile-menu a', array( 'color' => 'footer_mobile_a_color_setting' ) );
        
        // breadcrumbs
        $css .= $this->css_theme_mod_generator( '.aioseo-breadcrumbs', array(
            'font-size|0' => 'breadcrumbs_font_size_setting',
            'color'       => 'breadcrumbs_text_color_setting',
        ) );

        // main content
        $css .= $this->css_theme_mod_generator( '.main-content p,.main-content li,.main-content address,.main-content table', array(
            'color'         => 'font_color_setting',
            'font-size|0'   => 'font_size_setting',
            'line-height|1' => 'font_size_setting',
        ) );
        $css .= $this->css_theme_mod_generator( '.main-content strong', array( 'color' => 'strong_color_setting' ) );

        for ( $i = 1; $i <= 5; $i++ ) {
            //$css .= $this->css_theme_mod_generator( ".main-content h{$i},.main-content h{$i} strong,.prose h{$i}", array(
            $css .= $this->css_theme_mod_generator( ".prose h{$i}", array(
                'color'       => "h{$i}_color_setting",
                'font-size|0!' => "h{$i}_size_setting",
            ) );
        }

        // footer
        $css .= $this->css_theme_mod_gradient( '.main-footer', 'footer_color_setting', 'footer_color_gradient_to_setting' );
        $css .= $this->css_theme_mod_generator( '.footer-content h1,.footer-content h2,.footer-content h3,.footer-content h4,.footer-content h5', array(
            'font-size' => 'footer_header_size_setting',
            'color'     => 'footer_header_color_setting',
        ), array( 'margin-top' => '0 !important' ) );
        $css .= $this->css_theme_mod_generator( '.footer-content p', array(
            'font-size|0'   => 'footer_p_size_setting',
            'line-height|1' => 'footer_p_size_setting',
            'color'         => 'footer_p_color_setting',
        ) );
        $css .= $this->css_theme_mod_generator( '.footer-content a', array(
            'font-size|0'   => 'footer_p_size_setting',
            'line-height|1' => 'footer_p_size_setting',
            'color'         => 'footer_a_color_setting',            
        ) );
        $css .= $this->css_theme_mod_generator( '.footer-content a:hover', array( 'color' => 'footer_a_hover_color_setting' ) );
        $css .= $this->css_theme_mod_generator( '.copyright', array( 'color' => 'copyright_text_color_setting' ) );
        $css .= $this->css_theme_mod_generator( '.copyright a', array( 'color' => 'footer_a_color_setting' ) );

        // widget footer
        $css .= $this->css_theme_mod_generator( '.widget-footer.prose ul>li:before', array( 'background-color!' => 'footer_bullet_setting' ) );

        // widget sidebar
        // $css .= $this->css_theme_mod_generator( '.widget-primary h2', array(
        //     'color!'           => 'header_widget_text_color_setting',
        //     'background-color' => 'header_widget_color_setting'
        // ) );
        $css .= $this->css_theme_mod_generator( '.widget-primary.prose ul>li:before', array( 'background-color!' => 'bullet_widget_color_setting' ) );
        $css .= $this->css_theme_mod_generator( '.widget-primary.prose', array( 'color' => 'font_primary_widget_color_control' ) );
        $css .= $this->css_theme_mod_generator( '.widget-primary .wp-block-tag-cloud a', array(
            'background-color' => 'tag_cloud_widget_background_color_setting',
            'color'            => 'tag_cloud_widget_text_color_setting'
        ) );

        // reset tag cloud font size
	    $css .= '.wp-block-tag-cloud{display:flex;flex-wrap:wrap;}.wp-block-tag-cloud a{font-size:100% !important;margin:0 5px 5px 0;}';

        return $css;
    }

    function customize_css() {
        ?>
            <style type="text/css"><? echo $this->custom_css_output(); ?></style>
        <?php
    }
    
    public static function menu_with_count( $location ) {
        $html = wp_nav_menu( array(
            'theme_location' => $location,
            'items_wrap'     => '%3$s',
            'echo'           => false,
        ) );
    
        $html  = strip_tags( $html, '<a><img><span>' );
        $count = substr_count( $html, '<a' );
    
        return array( $html, $count );
    }

    public static function top_header() {
        $display = get_theme_mod( 'top_header_display_setting', 'none' );
        if ( $display == 'none' ) {
            return;
        }

        if ( $display == 'menu' ) {
            $menu = self::menu_with_count( 'top_header' );
            ?>
            <nav class="flex flex-row justify-evenly w-full md:space-x-5 top-header py-3">
                <?php echo $menu[0]; ?>
            </nav>
            <?php
        } else if ( $display == 'widget' ) {
            dynamic_sidebar( 'top_header' );            
        }
    }

    public static function header_banner() {
        $display = get_theme_mod( 'header_banner_display_setting', 'none' );
        if ( $display == 'none' ) {
            return;
        }

        if ( $display == 'widget' ) {
            dynamic_sidebar( 'header_banner' ); 
        }
    }

    public static function header_menu() {
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

    public static function footer_widget_style() {
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
}