<?php get_header(); ?>

<!-- Archive Hero Header -->
<div class="archive-header">
    <div class="site-wrapper">
        <?php the_archive_title('<h1 class="archive-title">', '</h1>'); ?>
        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
    </div>
</div>

<div class="site-wrapper">
    <div id="main-content" class="content-area">

        <main id="primary" class="main-content" role="main">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                        <div class="post-card-thumbnail">
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <?php the_post_thumbnail('medium_large'); ?>
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
                                <span><?php esc_html_e('By', 'usm-theme'); ?> <?php the_author(); ?></span>
                            </div>

                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e('Read More', 'usm-theme'); ?> &rarr;
                            </a>

                        </div>

                    </article>

                <?php endwhile; ?>

                <!-- Pagination -->
                <nav class="pagination" aria-label="<?php esc_attr_e('Archive pagination', 'usm-theme'); ?>">
                    <?php
                    echo paginate_links([
                        'prev_text' => '&laquo; ' . esc_html__('Newer', 'usm-theme'),
                        'next_text' => esc_html__('Older', 'usm-theme') . ' &raquo;',
                    ]);
                    ?>
                </nav>

            <?php else : ?>

                <div class="no-results">
                    <h2><?php esc_html_e('Nothing Found', 'usm-theme'); ?></h2>
                    <p><?php esc_html_e('No posts matched your criteria.', 'usm-theme'); ?></p>
                </div>

            <?php endif; ?>

        </main><!-- #primary -->

        <?php get_sidebar(); ?>

    </div><!-- .content-area -->
</div><!-- .site-wrapper -->

<?php get_footer(); ?>
