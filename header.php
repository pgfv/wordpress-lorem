<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta name="description" content="<?php bloginfo( 'description' ); ?>"/>

	<?php wp_head(); ?>
    <style type="text/css">
        <?php $p_size = explode( '|', get_theme_mod('font_size_setting')); ?>
        p {
            color: <?php echo get_theme_mod('font_color_setting'); ?>;
            font-size: <?php echo $p_size[0]; ?>;
            line-height: <?php echo $p_size[1]; ?>;
        }

        <?php $h1_size = explode( '|', get_theme_mod('h1_size_setting')); ?>
        h1 {
            color: <?php echo get_theme_mod('h1_color_setting'); ?> !important;
            font-size: <?php echo $h1_size[0]; ?> !important;
        }

        <?php $h2_size = explode( '|', get_theme_mod('h2_size_setting')); ?>
        h2 {
            color: <?php echo get_theme_mod('h2_color_setting'); ?> !important;
            font-size: <?php echo $h2_size[0]; ?> !important;
        }

        <?php $h3_size = explode( '|', get_theme_mod('h3_size_setting')); ?>
        h3 {
            color: <?php echo get_theme_mod('h3_color_setting'); ?> !important;
            font-size: <?php echo $h3_size[0]; ?> !important;
        }

        .widget-primary h2 {
            color: <?php echo get_theme_mod('header_widget_text_color_setting'); ?> !important;
            background-color: <?php echo get_theme_mod('header_widget_color_setting'); ?> !important;
        }
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

                    <label id="show-button" for="nav-toggle" class="block sm:hidden" onclick="menuToggle()">
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
                <nav class="flex flex-row justify-evenly md:space-x-5">
					<?php echo $register_menu[0] ?>
                </nav>
            </section>
        </section>


        <section id="nav-menu" class="hidden md:block"
                 style="background-color:<?php echo get_theme_mod( 'header_menu_color_setting' ) ?>;">
            <nav class="main-container"><?php echo header_menu(); ?></nav>
        </section>
    </header>
    <main role="main" class="flex-1 main-container">
