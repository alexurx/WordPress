<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <!-- Hero header for single post -->
    <div class="single-post-header">
        <div class="site-wrapper">
            <div class="post-meta">
                <?php
                $categories = get_the_category();
                if ($categories) :
                    echo '<a class="cat-label" href="' . esc_url(get_category_link($categories[0]->term_id)) . '">'
                        . esc_html($categories[0]->name) . '</a>';
                endif;
                ?>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date()); ?>
                </time>
                <span>
                    <?php esc_html_e('By', 'usm-theme'); ?>
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php the_author(); ?>
                    </a>
                </span>
                <?php if (comments_open() || get_comments_number()) : ?>
                    <a href="#comments">
                        <?php comments_number(
                            esc_html__('No comments', 'usm-theme'),
                            esc_html__('1 comment', 'usm-theme'),
                            esc_html__('% comments', 'usm-theme')
                        ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <h1 class="entry-title"><?php the_title(); ?></h1>
        </div>
    </div>

    <!-- Content area -->
    <div class="site-wrapper">
        <div id="main-content" class="content-area single-post">
            <main id="primary" class="main-content" role="main">

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content(sprintf(
                            wp_kses(
                                __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'usm-theme'),
                                ['span' => ['class' => []]]
                            ),
                            wp_kses_post(get_the_title())
                        ));
                        wp_link_pages([
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'usm-theme'),
                            'after'  => '</div>',
                        ]);
                        ?>
                    </div><!-- .entry-content -->

                    <!-- Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ($tags) : ?>
                        <div class="post-tags">
                            <span><?php esc_html_e('Tags:', 'usm-theme'); ?></span>
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                    #<?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </article><!-- #post -->

                <!-- Post Navigation -->
                <nav class="post-navigation" aria-label="<?php esc_attr_e('Post navigation', 'usm-theme'); ?>">
                    <div class="nav-previous">
                        <?php if (get_previous_post()) : ?>
                            <span class="nav-label">&larr; <?php esc_html_e('Previous Post', 'usm-theme'); ?></span>
                            <a href="<?php echo esc_url(get_permalink(get_previous_post())); ?>">
                                <?php echo esc_html(get_the_title(get_previous_post())); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="nav-next">
                        <?php if (get_next_post()) : ?>
                            <span class="nav-label"><?php esc_html_e('Next Post', 'usm-theme'); ?> &rarr;</span>
                            <a href="<?php echo esc_url(get_permalink(get_next_post())); ?>">
                                <?php echo esc_html(get_the_title(get_next_post())); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- Comments -->
                <?php comments_template(); ?>

            </main><!-- #primary -->

            <?php get_sidebar(); ?>

        </div><!-- .content-area -->
    </div><!-- .site-wrapper -->

<?php endwhile; ?>

<?php get_footer(); ?>
