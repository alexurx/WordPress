<?php
/**
 * Шорткод [usm_notes priority="X" before_date="YYYY-MM-DD"]
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'usm_notes_enqueue_styles' );

function usm_notes_enqueue_styles() {
    wp_enqueue_style(
        'usm-notes-style',
        USM_NOTES_URL . 'assets/style.css',
        [],
        USM_NOTES_VERSION
    );
}

add_shortcode( 'usm_notes', 'usm_notes_shortcode_handler' );

function usm_notes_shortcode_handler( $atts ) {
    $atts = shortcode_atts(
        [
            'priority'    => '',
            'before_date' => '',
        ],
        $atts,
        'usm_notes'
    );

    $args = [
        'post_type'      => 'usm_note',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => '_usm_note_due_date',
        'order'          => 'ASC',
    ];

    // Фильтр по таксономии (приоритет)
    if ( ! empty( $atts['priority'] ) ) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'note_priority',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $atts['priority'] ),
            ],
        ];
    }

    // Фильтр по дате (before_date)
    if ( ! empty( $atts['before_date'] ) ) {
        $before = sanitize_text_field( $atts['before_date'] );
        $args['meta_query'] = [
            [
                'key'     => '_usm_note_due_date',
                'value'   => $before,
                'compare' => '<=',
                'type'    => 'DATE',
            ],
        ];
    }

    $query = new WP_Query( $args );

    ob_start();

    echo '<div class="usm-notes-wrapper">';

    if ( ! $query->have_posts() ) {
        echo '<p class="usm-notes-empty">Нет заметок с заданными параметрами.</p>';
    } else {
        echo '<ul class="usm-notes-list">';

        while ( $query->have_posts() ) {
            $query->the_post();

            $post_id  = get_the_ID();
            $due_date = get_post_meta( $post_id, '_usm_note_due_date', true );
            $terms    = get_the_terms( $post_id, 'note_priority' );
            $priority = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
            $slug     = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : '';

            $today_ts = strtotime( date( 'Y-m-d' ) );
            $due_ts   = $due_date ? strtotime( $due_date ) : null;

            $urgency_class = '';
            if ( $due_ts ) {
                $days = intval( ( $due_ts - $today_ts ) / DAY_IN_SECONDS );
                if ( $days < 0 )      $urgency_class = 'usm-note--overdue';
                elseif ( $days <= 3 ) $urgency_class = 'usm-note--soon';
            }

            $priority_class = $slug ? 'usm-note--priority-' . esc_attr( $slug ) : '';

            echo '<li class="usm-note-item ' . $priority_class . ' ' . $urgency_class . '">';
            echo '<div class="usm-note-header">';
            echo '<a class="usm-note-title" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
            if ( $priority ) {
                echo '<span class="usm-note-badge usm-note-badge--' . esc_attr( $slug ) . '">' . esc_html( $priority ) . '</span>';
            }
            echo '</div>';

            $content = get_the_excerpt();
            if ( $content ) {
                echo '<p class="usm-note-excerpt">' . esc_html( $content ) . '</p>';
            }

            echo '<div class="usm-note-footer">';
            if ( $due_date ) {
                echo '<span class="usm-note-date">📅 ' . esc_html( date_i18n( 'd.m.Y', $due_ts ) ) . '</span>';
            }
            echo '</div>';

            echo '</li>';
        }

        echo '</ul>';
    }

    echo '</div>';

    wp_reset_postdata();

    return ob_get_clean();
}
