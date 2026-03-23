<?php
/**
 * Metabox: Дата напоминания
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Добавление метабокса
add_action( 'add_meta_boxes', 'usm_notes_add_metabox' );

function usm_notes_add_metabox() {
    add_meta_box(
        'usm_notes_due_date',
        'Дата напоминания',
        'usm_notes_metabox_callback',
        'usm_note',
        'side',
        'high'
    );
}

// Вывод содержимого метабокса
function usm_notes_metabox_callback( $post ) {
    wp_nonce_field( 'usm_notes_save_due_date', 'usm_notes_nonce' );

    $due_date = get_post_meta( $post->ID, '_usm_note_due_date', true );

    // Показываем ошибку из transient (если была)
    $error = get_transient( 'usm_notes_error_' . $post->ID );
    if ( $error ) {
        echo '<div style="color:red;margin-bottom:8px;">' . esc_html( $error ) . '</div>';
        delete_transient( 'usm_notes_error_' . $post->ID );
    }

    $today = date( 'Y-m-d' );
    ?>
    <p>
        <label for="usm_note_due_date"><strong>Дата напоминания <span style="color:red">*</span></strong></label>
    </p>
    <input
        type="date"
        id="usm_note_due_date"
        name="usm_note_due_date"
        value="<?php echo esc_attr( $due_date ); ?>"
        min="<?php echo esc_attr( $today ); ?>"
        style="width:100%;"
        required
    />
    <p style="font-size:11px;color:#666;margin-top:4px;">
        Дата не может быть в прошлом. Поле обязательно для заполнения.
    </p>
    <?php
}

// Сохранение метабокса
add_action( 'save_post_usm_note', 'usm_notes_save_metabox' );

function usm_notes_save_metabox( $post_id ) {
    // 1. Проверка nonce
    if ( ! isset( $_POST['usm_notes_nonce'] ) ||
         ! wp_verify_nonce( $_POST['usm_notes_nonce'], 'usm_notes_save_due_date' ) ) {
        return;
    }

    // 2. Автосохранение — пропускаем
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // 3. Проверка прав
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // 4. Обработка значения
    $due_date = isset( $_POST['usm_note_due_date'] ) ? sanitize_text_field( $_POST['usm_note_due_date'] ) : '';

    // 5. Валидация: обязательность
    if ( empty( $due_date ) ) {
        set_transient( 'usm_notes_error_' . $post_id, 'Ошибка: поле «Дата напоминания» обязательно для заполнения.', 60 );
        return;
    }

    // 6. Валидация: дата не в прошлом
    $today     = date( 'Y-m-d' );
    $input_ts  = strtotime( $due_date );
    $today_ts  = strtotime( $today );

    if ( $input_ts === false || $input_ts < $today_ts ) {
        set_transient( 'usm_notes_error_' . $post_id, 'Ошибка: дата напоминания не может быть в прошлом.', 60 );
        return;
    }

    // 7. Сохранение
    update_post_meta( $post_id, '_usm_note_due_date', $due_date );
}

// Отображение сообщения об ошибке в admin notices
add_action( 'admin_notices', 'usm_notes_admin_notice' );

function usm_notes_admin_notice() {
    global $post;

    if ( ! $post || $post->post_type !== 'usm_note' ) {
        return;
    }

    $error = get_transient( 'usm_notes_error_' . $post->ID );
    if ( $error ) {
        echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $error ) . '</p></div>';
        delete_transient( 'usm_notes_error_' . $post->ID );
    }
}
