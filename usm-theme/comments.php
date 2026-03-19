<?php
/*
 * The template for displaying comments.
 * This is called via comments_template() in single.php and page.php.
 */

// Password-protected posts should not display comments.
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>

        <h2 class="comments-title">
            <?php
            $count = get_comments_number();
            if ('1' === $count) {
                printf(
                    /* translators: 1: title */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'usm-theme'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count, 2: title */
                    esc_html(_n(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $count,
                        'usm-theme'
                    )),
                    number_format_i18n($count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments([
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 40,
                'callback'    => 'usm_comment_template',
            ]);
            ?>
        </ol><!-- .comment-list -->

        <?php the_comments_navigation(); ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments">
                <?php esc_html_e('Comments are closed.', 'usm-theme'); ?>
            </p>
        <?php endif; ?>

    <?php endif; // have_comments() ?>

    <?php
    $commenter = wp_get_current_commenter();
    comment_form([
        'title_reply'          => esc_html__('Leave a Comment', 'usm-theme'),
        'title_reply_to'       => esc_html__('Leave a Reply to %s', 'usm-theme'),
        'cancel_reply_link'    => esc_html__('Cancel reply', 'usm-theme'),
        'label_submit'         => esc_html__('Post Comment', 'usm-theme'),
        'class_submit'         => 'submit',
        'comment_notes_before' => '',
        'fields'               => [
            'author' => '<div class="comment-form-author"><label for="author">'
                . esc_html__('Name', 'usm-theme')
                . ' <span class="required" aria-hidden="true">*</span></label>'
                . '<input id="author" name="author" type="text" value="'
                . esc_attr($commenter['comment_author'])
                . '" size="30" maxlength="245" autocomplete="name" required /></div>',

            'email'  => '<div class="comment-form-email"><label for="email">'
                . esc_html__('Email', 'usm-theme')
                . ' <span class="required" aria-hidden="true">*</span></label>'
                . '<input id="email" name="email" type="email" value="'
                . esc_attr($commenter['comment_author_email'])
                . '" size="30" maxlength="100" autocomplete="email" required /></div>',

            'url'    => '<div class="comment-form-url"><label for="url">'
                . esc_html__('Website', 'usm-theme')
                . '</label>'
                . '<input id="url" name="url" type="url" value="'
                . esc_attr($commenter['comment_author_url'])
                . '" size="30" maxlength="200" autocomplete="url" /></div>',
        ],
        'comment_field' => '<div class="comment-form-comment"><label for="comment">'
            . esc_html__('Comment', 'usm-theme')
            . ' <span class="required" aria-hidden="true">*</span></label>'
            . '<textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required></textarea></div>',
    ]);
    ?>

</div><!-- #comments -->
