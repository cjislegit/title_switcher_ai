<?php

/**
* Plugin Name: Title Tag Switcher
* Description: Plugin that lets you update your pages tiltle tags.
* Author: CJR
* Author URL: cjramirez.tech
* Version: 1.0.0
* Text Domain: title_switcher
*/

//Exists if accessed directly
defined('ABSPATH') or die('Get out of here!');

//Constatns should have a unique name so they don't interfere with other plugins
//Sets the plugin path constant to the path of of the plugin
define('TITLE_SWITCHER_PATH', plugin_dir_path(__FILE__));

//Sets the plugin url contsant to the url of the plugin
define('TITLE_SWITCHER_URL', plugin_dir_url(__FILE__));

//Sets the pligin const to the name of the plugin
define('TITLE_SWITCHER_SUBS', plugin_basename(__FILE__));

//Load Classes
require_once(TITLE_SWITCHER_PATH . 'inc/class/TitleSwitcherEnqueue.php');
require_once(TITLE_SWITCHER_PATH . 'inc/class/TitleSwitcher.php');

//Create new instance of class
$newEnqueue = new TitleSwitcherEnqueue();
$newTitleSwitcher = new TitleSwitcher();

//Call register method
$newEnqueue->register();
$newTitleSwitcher->register();

//Calls create_db method
$newTitleSwitcher->create_db();

//Set plublished_pages to array of active page ids
define('PUBLISHED_PAGES', $newTitleSwitcher->get_all_pages());

//Ajax function
function update_table()
{
    global $wpdb;
    $table = $wpdb->prefix . "title_switcher";
    $newTitles = $_POST['function'];

    foreach($newTitles as $newTitle) {
        if(count($wpdb->get_results("SELECT * FROM $table WHERE page_id = $newTitle[0]")) > 0) {
            $wpdb->update($table, array("title_tag" => $newTitle[1]), array("page_id" => $newTitle[0]));
        } else {
            $wpdb->insert($table, array("title_tag" => $newTitle[1], "page_id" => $newTitle[0]));
        }
    }
 
    wp_die();// this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_update_table', 'update_table'); // for logged in users only
add_action('wp_ajax_nopriv_update_table', 'update_table'); // for ALL users

