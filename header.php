<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rafbig
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri() . '/images/icon_cross_sm.png'; ?>" alt="branding-icon"">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'rafbig' ); ?></a>

        <nav id="site-navigation" class="nav-primary <?php if ( is_front_page() ) echo 'nav-primary--front-page' ?>">
            <button class="nav-primary__toggle-btn" >
                <div class="nav-primary__toggle-btn-line"></div>
                <div class="nav-primary__toggle-btn-line"></div>
                <div class="nav-primary__toggle-btn-line"></div>
            </button>
            <?php
            // $logo_url declared in functions.php
            global $logo_url;
            $cross_icon_src = get_template_directory_uri() . '/images/icon_cross_sm.png';
            ?>
            <div class="nav-primary__logo">
                <a href="<?php echo get_site_url(); ?>"><img src="<?php echo esc_url( $logo_url[0] ) ?>" alt="<?php echo get_bloginfo( 'name' ) ?>"></a>
            </div>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'menu-1',
                'menu_class'     => 'nav-primary__menu-list',
                'container'      => false,
                'after'         => '<div class="menu-list__hover-icon"><img src="' . $cross_icon_src . '" alt="branding-icon"></div>'
            ) );
            ?>
        </nav><!--.nav-primary -->

    <div id="content" class="site-content">
