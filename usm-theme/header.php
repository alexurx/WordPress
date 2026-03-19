<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#main-content"><?php esc_html_e('Skip to content', 'usm-theme'); ?></a>

<!-- ===================== HEADER ===================== -->
<header id="masthead" class="site-header" role="banner">
    <div class="header-inner">

        <!-- Branding -->
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <div class="custom-logo-wrap"><?php the_custom_logo(); ?></div>
            <?php else : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
                <?php if (get_bloginfo('description')) : ?>
                    <p class="site-description"><?php bloginfo('description'); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div><!-- .site-branding -->

        <!-- Navigation -->
        <nav id="site-navigation" class="main-navigation" role="navigation"
             aria-label="<?php esc_attr_e('Primary Menu', 'usm-theme'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'fallback_cb'    => function () {
                    echo '<ul id="primary-menu">';
                    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'usm-theme') . '</a></li>';
                    wp_list_pages(['title_li' => '', 'depth' => 1, 'echo' => true]);
                    echo '</ul>';
                },
            ]);
            ?>
        </nav><!-- .main-navigation -->

    </div><!-- .header-inner -->
</header><!-- #masthead -->
<!-- ==================== /HEADER ==================== -->
