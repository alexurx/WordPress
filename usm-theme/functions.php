<?php
/**
 * USM Theme functions and definitions.
 *
 * @package usm-theme
 */

// Prevent direct access.
defined('ABSPATH') || exit;

// ============================================================
// 1. THEME SETUP
// ============================================================
if (!function_exists('usm_theme_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function usm_theme_setup() {

        // Make theme available for translation.
        load_theme_textdomain('usm-theme', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title.
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 600, true);
        add_image_size('card-thumbnail', 800, 400, true);

        // Register navigation menus.
        register_nav_menus([
            'primary' => esc_html__('Primary Menu', 'usm-theme'),
            'footer'  => esc_html__('Footer Menu', 'usm-theme'),
        ]);

        // Switch default core markup to output valid HTML5.
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]);

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('usm_custom_background_args', [
            'default-color' => 'f8f7f4',
            'default-image' => '',
        ]));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Support for custom logo.
        add_theme_support('custom-logo', [
            'height'      => 60,
            'width'       => 200,
            'flex-width'  => true,
            'flex-height' => true,
        ]);

        // Support for editor styles.
        add_theme_support('editor-styles');
        add_editor_style('style.css');

        // Support wide alignment in block editor.
        add_theme_support('align-wide');

        // Support responsive embeds.
        add_theme_support('responsive-embeds');

    }
endif;
add_action('after_setup_theme', 'usm_theme_setup');


// ============================================================
// 2. CONTENT WIDTH
// ============================================================
if (!isset($content_width)) {
    $content_width = 800; // pixels
}


// ============================================================
// 3. ENQUEUE SCRIPTS & STYLES
// ============================================================
if (!function_exists('usm_scripts')) :
    /**
     * Enqueue scripts and styles.
     */
    function usm_scripts() {

        // Theme stylesheet.
        wp_enqueue_style(
            'usm-style',
            get_stylesheet_uri(),
            [],
            wp_get_theme()->get('Version')
        );

        // Google Fonts – Elegant pairing for the theme.
        wp_enqueue_style(
            'usm-google-fonts',
            'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;1,8..60,300&display=swap',
            [],
            null
        );

        // Comment reply script (only on posts with comments open).
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
endif;
add_action('wp_enqueue_scripts', 'usm_scripts');


// ============================================================
// 4. REGISTER SIDEBARS / WIDGET AREAS
// ============================================================
if (!function_exists('usm_widgets_init')) :
    /**
     * Register widget areas.
     */
    function usm_widgets_init() {

        // Main sidebar.
        register_sidebar([
            'name'          => esc_html__('Main Sidebar', 'usm-theme'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Widgets in this area will be shown in the main sidebar.', 'usm-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]);

        // Footer widget areas.
        for ($i = 1; $i <= 3; $i++) {
            register_sidebar([
                'name'          => sprintf(esc_html__('Footer Widget Area %d', 'usm-theme'), $i),
                'id'            => "footer-{$i}",
                'description'   => sprintf(esc_html__('Footer column %d widget area.', 'usm-theme'), $i),
                'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="footer-widget-title">',
                'after_title'   => '</h3>',
            ]);
        }
    }
endif;
add_action('widgets_init', 'usm_widgets_init');


// ============================================================
// 5. CUSTOM EXCERPT LENGTH & MORE TEXT
// ============================================================
function usm_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'usm_excerpt_length', 999);

function usm_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'usm_excerpt_more');


// ============================================================
// 6. CUSTOM COMMENT TEMPLATE CALLBACK
// ============================================================
if (!function_exists('usm_comment_template')) :
    /**
     * Outputs a single comment using the theme's markup.
     *
     * @param WP_Comment $comment Comment object.
     * @param array      $args    Display arguments.
     * @param int        $depth   Nesting depth.
     */
    function usm_comment_template($comment, $args, $depth) {
        $tag = ($args['style'] === 'div') ? 'div' : 'li';
        ?>
        <<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>"
            <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>

            <div class="comment">
                <div class="comment-meta">
                    <?php echo get_avatar($comment, $args['avatar_size'], '', '', ['class' => 'avatar']); ?>
                    <div>
                        <span class="comment-author-name">
                            <?php comment_author_link($comment); ?>
                        </span>
                        <time class="comment-date" datetime="<?php comment_time('c'); ?>">
                            <?php comment_date(); ?> <?php esc_html_e('at', 'usm-theme'); ?> <?php comment_time(); ?>
                        </time>
                    </div>
                </div>

                <?php if ('0' === $comment->comment_approved) : ?>
                    <p class="comment-awaiting-moderation">
                        <?php esc_html_e('Your comment is awaiting moderation.', 'usm-theme'); ?>
                    </p>
                <?php endif; ?>

                <div class="comment-body">
                    <?php comment_text(); ?>
                </div>

                <div class="comment-footer">
                    <?php
                    comment_reply_link(array_merge($args, [
                        'add_below' => 'comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<span>',
                        'after'     => '</span>',
                    ]));
                    ?>
                    <?php edit_comment_link(esc_html__('Edit', 'usm-theme'), '<span class="edit-link">', '</span>'); ?>
                </div>
            </div>

        <?php // Closing tag is added by WordPress automatically.
    }
endif;


// ============================================================
// 7. BODY CLASSES HELPER
// ============================================================
function usm_body_classes($classes) {
    // Adds a class if there is a sidebar.
    if (!is_page_template('page-fullwidth.php')) {
        $classes[] = 'has-sidebar';
    }
    return $classes;
}
add_filter('body_class', 'usm_body_classes');


// ============================================================
// 8. DISABLE EMOJIS (performance)
// ============================================================
function usm_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'usm_disable_emojis');
