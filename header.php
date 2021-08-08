<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta name="description" content="<?php bloginfo( 'description' ); ?>"/>

	<?php $english_font = get_theme_mod( 'font_english_setting', 'Montserrat:wght@400;700' ); ?>
	<?php $thai_font = get_theme_mod( 'font_thai_setting', 'Sarabun:wght@400;700' ) ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?php echo $english_font; ?>&family=<?php echo $thai_font; ?>&display=swap"
          rel="stylesheet">

	<?php wp_head(); ?>
    <style type="text/css">
        <?php echo lorem_css_customizer(); ?>
    </style>
</head>
<body <?php body_class(); ?>>
<!-- wrapper -->
<section class="flex flex-col min-h-screen"
         style="background-color: <?php echo get_theme_mod( 'background_color_setting' ); ?>;">
    <header class="flex flex-col mb-10"
            style="background-color:<?php echo get_theme_mod( 'header_color_setting' ); ?>;">

        <section class="flex flex-col md:flex-row justify-between main-container">
            <section class="py-3 flex flex-row justify-between items-center">
                <div class="w-1/6 md:w-full">
					<?php the_custom_logo(); ?>
                </div>
                <div class="p-2 block sm:hidden">
                    <script type="text/javascript">
                        function menuToggle() {
                            let menu = document.getElementById('nav-menu');
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

            <section class="pb-3 md:py-5 flex items-center">
				<?php $register_menu = register_menu(); ?>
                <nav class="flex flex-row justify-evenly w-full md:space-x-5">
					<?php echo $register_menu[0] ?>
                </nav>
            </section>
        </section>


        <section id="nav-menu" class="header-menu hidden md:block"
                 style="background-color:<?php echo get_theme_mod( 'header_menu_color_setting' ) ?>;">
            <nav class="main-container py-5"><?php echo header_menu_list(); ?></nav>
        </section>
    </header>
    <main role="main" class="flex-1 main-container">
