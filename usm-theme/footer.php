<!-- ===================== FOOTER ===================== -->
<footer id="colophon" class="site-footer" role="contentinfo">

    <!-- Footer Widget Area -->
    <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
    <div class="footer-widgets">

        <?php if (is_active_sidebar('footer-1')) : ?>
        <div class="footer-widget">
            <?php dynamic_sidebar('footer-1'); ?>
        </div>
        <?php endif; ?>

        <?php if (is_active_sidebar('footer-2')) : ?>
        <div class="footer-widget">
            <?php dynamic_sidebar('footer-2'); ?>
        </div>
        <?php endif; ?>

        <?php if (is_active_sidebar('footer-3')) : ?>
        <div class="footer-widget">
            <?php dynamic_sidebar('footer-3'); ?>
        </div>
        <?php endif; ?>

    </div><!-- .footer-widgets -->
    <?php else : ?>
    <div class="footer-widgets">
        <div class="footer-widget">
            <h3 class="footer-widget-title"><?php bloginfo('name'); ?></h3>
            <p style="font-size:.875rem;"><?php bloginfo('description'); ?></p>
        </div>
        <div class="footer-widget">
            <h3 class="footer-widget-title"><?php esc_html_e('Navigation', 'usm-theme'); ?></h3>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'usm-theme'); ?></a></li>
                <?php wp_list_pages(['title_li' => '', 'depth' => 1, 'echo' => true]); ?>
            </ul>
        </div>
        <div class="footer-widget">
            <h3 class="footer-widget-title"><?php esc_html_e('Recent Posts', 'usm-theme'); ?></h3>
            <?php
            $recent = new WP_Query(['posts_per_page' => 4, 'post_status' => 'publish']);
            if ($recent->have_posts()) :
                echo '<ul>';
                while ($recent->have_posts()) : $recent->the_post();
                    echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Footer Bottom Bar -->
    <div class="footer-bottom">
        <span>
            &copy; <?php echo esc_html(date('Y')); ?>
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>.
            <?php esc_html_e('All rights reserved.', 'usm-theme'); ?>
        </span>
        <span>
            <?php
            /* translators: %s: WordPress link */
            printf(
                esc_html__('Powered by %s', 'usm-theme'),
                '<a href="https://wordpress.org" target="_blank" rel="noopener">WordPress</a>'
            );
            ?>
            &mdash;
            <?php esc_html_e('USM Theme', 'usm-theme'); ?>
        </span>
    </div><!-- .footer-bottom -->

</footer><!-- #colophon -->
<!-- ==================== /FOOTER ==================== -->

<?php wp_footer(); ?>
</body>
</html>
