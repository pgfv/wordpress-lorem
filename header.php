<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>

	<?php $english_font = get_theme_mod( 'font_english_setting', 'Montserrat:wght@400;700' ); ?>
	<?php $thai_font = get_theme_mod( 'font_thai_setting', 'Sarabun:wght@400;700' ) ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?php echo $english_font; ?>&family=<?php echo $thai_font; ?>&display=swap" rel="stylesheet">

	<?php wp_head(); ?>

	<?php
	if ( ! empty( get_theme_mod( 'google_analytics_setting' ) ) ) :
		$id = get_theme_mod( 'google_analytics_setting' ); ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $id; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push( arguments );
            }

            gtag( 'js', new Date() );
            gtag( 'config', '<?php echo $id; ?>' );
        </script>
	<?php endif; ?>
</head>
<body <?php body_class(); ?>>

<section>
	<?php for ( $i = 1; $i <= 4; $i ++ ) :
		if ( is_active_sidebar( "sticky_widget_{$i}" ) ):
			$hw = get_theme_mod( "sticky_widget_{$i}_position_horizontal_setting", 'right' );
			$vw = get_theme_mod( "sticky_widget_{$i}_position_vertical_setting", 'top' );
			$hide_mobile = get_theme_mod( "sticky_widget_{$i}_hide_mobile_setting", false );
			$hide_pc = get_theme_mod( "sticky_widget_{$i}_hide_pc_setting", false );
			?>
            <div id="sticky-widget-<?php echo $i; ?>"
                 class="fixed z-10 flex-col <?php echo sticky_widget_style( $hw, $vw, $hide_mobile, $hide_pc ); ?>">
                <button class="text-sm text-right text-red-700"
                        onclick="document.getElementById('sticky-widget-<?php echo $i; ?>').style.display = 'none';">
                    close
                </button>
				<?php dynamic_sidebar( "sticky_widget_{$i}" ); ?>
            </div>
		<?php endif; ?>
	<?php endfor; ?>
</section>

<!-- wrapper -->
<section class="flex flex-col min-h-screen wrapper-section">
    
    <header class="flex flex-col main-header">
        <?php LoremTheme::top_header(); ?>
        
        <section class="flex flex-col md:flex-row justify-between main-container">
            <section class="py-3 flex flex-row justify-between items-center">
                <div class="w-1/6 md:w-full">
					<?php the_custom_logo(); ?>
                </div>
                <div class="p-2 block sm:hidden">
                    <script type="text/javascript">
                        function menuToggle() {
                            let menu = document.getElementById( 'nav-menu' );
                            if (menu.style.display === 'grid') {
                                menu.style.display = 'none';
                            } else {
                                menu.style.display = 'grid';
                            }
                        }
                    </script>

                    <label id="show-button" for="nav-toggle" class="block sm:hidden"
                           style="color:<?php echo get_theme_mod( 'header_hamburger_color_setting' ) ?>;"
                           onclick="menuToggle()">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu Open</title>
                            <path d="M0 3h20v2H0V3z m0 6h20v2H0V9z m0 6h20v2H0V0z"/>
                        </svg>
                    </label>
                    <label id="hide-button" for="nav-toggle" class="hidden" onclick="menuToggle()">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu Close</title>
                            <polygon points="11 9 22 9 22 11 11 11 11 22 9 22 9 11 -2 11 -2 9 9 9 9 -2 11 -2"
                                     transform="rotate(45 10 10)"/>
                        </svg>
                    </label>
                </div>
            </section>

			<?php $sticky_register = get_theme_mod( 'header_sticky_register_setting' ); ?>
            <section class="register-menu pb-3 md:py-5 md:flex items-center<?php if ( $sticky_register ): ?> hidden<?php endif; ?>">
				<?php $register_menu = LoremTheme::menu_with_count( 'register_menu' ); ?>
                <nav class="flex flex-row justify-evenly w-full md:space-x-5">
					<?php echo $register_menu[0]; ?>
                </nav>
            </section>
        </section>

        <?php LoremTheme::header_banner(); ?>

        <section id="nav-menu" class="header-menu hidden md:block py-5 md:py-0">
            <?php echo LoremTheme::header_menu(); ?>
            <?php if ( ! empty( get_theme_mod( 'header_foot_content_setting' ) ) ) : ?>
            <div class="nav-content text-center"><?php echo get_theme_mod( 'header_foot_content_setting' ); ?></div>
            <?php endif; ?>
        </section>
    </header>


	<?php if ( $sticky_register ): ?>
        <section class="block md:hidden sticky top-0 mb-5 z-10" style="min-height:56px;">
			<?php $register_menu = LoremTheme::menu_with_count( 'register_menu' ); ?>
            <nav class="flex flex-row justify-evenly w-full md:space-x-5">
				<?php echo $register_menu[0] ?>
            </nav>
        </section>
	<?php endif; ?>

    <main role="main" class="flex-1 main-container mt-5">
