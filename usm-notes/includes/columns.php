<?php
/**
 * Кастомные колонки в списке заметок
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Добавление колонки
add_filter( 'manage_usm_note_posts_columns', 'usm_notes_add_columns' );

function usm_notes_add_columns( $columns ) {
    $new = [];
    foreach ( $columns as $key => $value ) {
        $new[ $key ] = $value;
        if ( $key === 'title' ) {
            $new['due_date'] = 'Дата напоминания';
        }
    }
    return $new;
}

// Заполнение колонки
add_action( 'manage_usm_note_posts_custom_column', 'usm_notes_fill_columns', 10, 2 );

function usm_notes_fill_columns( $column, $post_id ) {
    if ( $column === 'due_date' ) {
        $due_date = get_post_meta( $post_id, '_usm_note_due_date', true );
        if ( $due_date ) {
            $ts      = strtotime( $due_date );
            $today   = strtotime( date( 'Y-m-d' ) );
            $diff    = $ts - $today;
            $days    = intval( $diff / DAY_IN_SECONDS );

            $color = 'inherit';
            if ( $days < 0 ) {
                $color = '#cc0000'; // просрочено
            } elseif ( $days <= 3 ) {
                $color = '#e67e00'; // скоро
            }

            echo '<span style="color:' . $color . ';font-weight:600;">'
                . esc_html( date_i18n( 'd.m.Y', $ts ) )
                . '</span>';

            if ( $days < 0 ) {
                echo ' <em style="color:#cc0000;">(просрочено)</em>';
            } elseif ( $days === 0 ) {
                echo ' <em style="color:#e67e00;">(сегодня)</em>';
            } elseif ( $days <= 3 ) {
                echo ' <em style="color:#e67e00;">(' . $days . ' д.)</em>';
            }
        } else {
            echo '<span style="color:#999;">—</span>';
        }
    }
}

// Сортировка по дате
add_filter( 'manage_edit-usm_note_sortable_columns', 'usm_notes_sortable_columns' );

function usm_notes_sortable_columns( $columns ) {
    $columns['due_date'] = 'due_date';
    return $columns;
}

add_action( 'pre_get_posts', 'usm_notes_orderby_due_date' );

function usm_notes_orderby_due_date( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) return;
    if ( $query->get( 'orderby' ) === 'due_date' ) {
        $query->set( 'meta_key', '_usm_note_due_date' );
        $query->set( 'orderby', 'meta_value' );
    }
}
