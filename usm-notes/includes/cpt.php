<?php
/**
 * Custom Post Type: usm_note
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'usm_notes_register_cpt' );

function usm_notes_register_cpt() {
    $labels = [
        'name'               => 'Заметки',
        'singular_name'      => 'Заметка',
        'menu_name'          => 'Заметки',
        'add_new'            => 'Добавить заметку',
        'add_new_item'       => 'Добавить новую заметку',
        'edit_item'          => 'Редактировать заметку',
        'new_item'           => 'Новая заметка',
        'view_item'          => 'Просмотреть заметку',
        'search_items'       => 'Поиск заметок',
        'not_found'          => 'Заметок не найдено',
        'not_found_in_trash' => 'В корзине заметок нет',
        'all_items'          => 'Все заметки',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'notes' ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-edit-page',
        'supports'           => [ 'title', 'editor', 'author', 'thumbnail' ],
        'show_in_rest'       => true,
    ];

    register_post_type( 'usm_note', $args );
}
