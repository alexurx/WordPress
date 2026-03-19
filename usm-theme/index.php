<?php get_header(); ?>

<div class="site-wrapper">
    <div id="main-content" class="content-area">

        <!-- ========== MAIN CONTENT ========== -->
        <main id="primary" class="main-content" role="main">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                        <div class="post-card-thumbnail">
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <div class="post-card-body">

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
                                <span><?php esc_html_e('By', 'usm-theme'); ?>
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php the_author(); ?>
                                    </a>
                                </span>
                                <?php if (comments_open()) : ?>
                                    <span>
                                        <a href="<?php comments_link(); ?>">
                                            <?php comments_number(
                                                esc_html__('0 comments', 'usm-theme'),
                                                esc_html__('1 comment', 'usm-theme'),
                                                esc_html__('% comments', 'usm-theme')
                                            ); ?>
                                        </a>
                                    </span>
                                <?php endif; ?>
                            </div><!-- .post-meta -->

                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="read-more"
                               aria-label="<?php printf(esc_attr__('Read more about %s', 'usm-theme'), get_the_title()); ?>">
                                <?php esc_html_e('Read More', 'usm-theme'); ?> &rarr;
                            </a>

                        </div><!-- .post-card-body -->

                    </article><!-- .post-card -->

                <?php endwhile; ?>

                <!-- Pagination -->
                <nav class="pagination" aria-label="<?php esc_attr_e('Posts pagination', 'usm-theme'); ?>">
                    <?php
                    echo paginate_links([
                        'prev_text' => '&laquo; ' . esc_html__('Previous', 'usm-theme'),
                        'next_text' => esc_html__('Next', 'usm-theme') . ' &raquo;',
                        'type'      => 'list',
                    ]);
                    ?>
                </nav>

            <?php else : ?>

                <div class="no-results">
                    <h2><?php esc_html_e('Nothing Found', 'usm-theme'); ?></h2>
                    <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Try a search?', 'usm-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>

            <?php endif; ?>

        </main><!-- #primary -->

        <!-- ========== SIDEBAR ========== -->
        <?php get_sidebar(); ?>

    </div><!-- .content-area -->
</div><!-- .site-wrapper -->

<?php get_footer(); ?>
