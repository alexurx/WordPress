<?php
/**
 * Plugin Name: USM Notes
 * Plugin URI:  https://github.com/
 * Description: Плагин добавляет раздел «Заметки» с приоритетами и датой напоминания.
 * Version:     1.0.0
 * Author:      Alex / USM
 * License:     GPL-2.0+
 * Text Domain: usm-notes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'USM_NOTES_VERSION', '1.0.0' );
define( 'USM_NOTES_DIR', plugin_dir_path( __FILE__ ) );
define( 'USM_NOTES_URL', plugin_dir_url( __FILE__ ) );

require_once USM_NOTES_DIR . 'includes/cpt.php';
require_once USM_NOTES_DIR . 'includes/taxonomy.php';
require_once USM_NOTES_DIR . 'includes/metabox.php';
require_once USM_NOTES_DIR . 'includes/columns.php';
require_once USM_NOTES_DIR . 'includes/shortcode.php';
