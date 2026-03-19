<?php get_header(); ?>

<div class="site-wrapper">
    <div id="main-content" class="content-area">

        <main id="primary" class="main-content" role="main">

            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>

                    <header class="page-header">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-featured-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                    </header><!-- .page-header -->

                    <div class="entry-content">
                        <?php
                        the_content();
                        wp_link_pages([
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'usm-theme'),
                            'after'  => '</div>',
                        ]);
                        ?>
                    </div><!-- .entry-content -->

                </article><!-- .page-content -->

                <?php comments_template(); ?>

            <?php endwhile; ?>

        </main><!-- #primary -->

        <?php get_sidebar(); ?>

    </div><!-- .content-area -->
</div><!-- .site-wrapper -->

<?php get_footer(); ?>
