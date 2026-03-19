<aside id="secondary" class="widget-area" role="complementary"
       aria-label="<?php esc_attr_e('Sidebar', 'usm-theme'); ?>">

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>

    <?php else : ?>
        <!-- Default sidebar content when no widgets are added -->

        <div class="widget">
            <h2 class="widget-title"><?php esc_html_e('Search', 'usm-theme'); ?></h2>
            <?php get_search_form(); ?>
        </div>

        <div class="widget">
            <h2 class="widget-title"><?php esc_html_e('Recent Posts', 'usm-theme'); ?></h2>
            <?php
            $recent_posts = new WP_Query([
                'posts_per_page' => 5,
                'post_status'    => 'publish',
            ]);
            if ($recent_posts->have_posts()) :
                echo '<ul>';
                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                    echo '<li><a href="' . esc_url(get_the_permalink()) . '">'
                        . esc_html(get_the_title()) . '</a></li>';
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <div class="widget">
            <h2 class="widget-title"><?php esc_html_e('Categories', 'usm-theme'); ?></h2>
            <ul>
                <?php wp_list_categories(['title_li' => '', 'orderby' => 'count', 'order' => 'DESC']); ?>
            </ul>
        </div>

        <div class="widget">
            <h2 class="widget-title"><?php esc_html_e('Archives', 'usm-theme'); ?></h2>
            <ul>
                <?php wp_get_archives(['type' => 'monthly', 'show_post_count' => true]); ?>
            </ul>
        </div>

        <div class="widget">
            <h2 class="widget-title"><?php esc_html_e('Tags', 'usm-theme'); ?></h2>
            <?php wp_tag_cloud(['smallest' => 10, 'largest' => 18, 'unit' => 'px', 'number' => 20]); ?>
        </div>

    <?php endif; ?>

</aside><!-- #secondary -->
