<?php
/**
 * Custom Taxonomy: note_priority
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'usm_notes_register_taxonomy' );

function usm_notes_register_taxonomy() {
    $labels = [
        'name'              => 'Приоритеты',
        'singular_name'     => 'Приоритет',
        'menu_name'         => 'Приоритеты',
        'search_items'      => 'Найти приоритет',
        'all_items'         => 'Все приоритеты',
        'parent_item'       => 'Родительский приоритет',
        'parent_item_colon' => 'Родительский приоритет:',
        'edit_item'         => 'Редактировать приоритет',
        'update_item'       => 'Обновить приоритет',
        'add_new_item'      => 'Добавить приоритет',
        'new_item_name'     => 'Новый приоритет',
    ];

    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'note-priority' ],
        'show_in_rest'      => true,
    ];

    register_taxonomy( 'note_priority', [ 'usm_note' ], $args );
}
