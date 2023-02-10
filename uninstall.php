<?php

//Makes sure the code is only triggered by WP
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;
$titleTagTableName = $wpdb->prefix . "title_switcher_ai";

$wpdb->query("DROP TABLE $titleTagTableName");