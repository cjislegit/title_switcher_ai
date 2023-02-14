<?php

/**
* Plugin Name: Title Tag Switcher AI
* Description: Plugin that uses AI to update your pages tiltle tags.
* Author: CJR
* Author URL: cjramirez.tech
* Version: 1.0.0
* Text Domain: title_switcher_ai
*/

//Exists if accessed directly
defined('ABSPATH') or die('Get out of here!');

//Constatns should have a unique name so they don't interfere with other plugins
//Sets the plugin path constant to the path of of the plugin
define('TITLE_SWITCHER_AI_PATH', plugin_dir_path(__FILE__));

//Sets the plugin url contsant to the url of the plugin
define('TITLE_SWITCHER_AI_URL', plugin_dir_url(__FILE__));

//Sets the pligin const to the name of the plugin
define('TITLE_SWITCHER_AI_SUBS', plugin_basename(__FILE__));

//Load Classes
require_once(TITLE_SWITCHER_AI_PATH . 'inc/class/TitleSwitcherAiEnqueue.php');
require_once(TITLE_SWITCHER_AI_PATH . 'inc/class/TitleSwitcherAi.php');

//Create new instance of class
$newEnqueue = new TitleSwitcherEnqueueAi();
$newTitleSwitcher = new TitleSwitcherAi();

//Call register method
$newEnqueue->register();
$newTitleSwitcher->register();

//Calls create_db method
$newTitleSwitcher->create_db();

//Set plublished_pages to array of active page ids
define('PUBLISHED_PAGES_AI', $newTitleSwitcher->get_all_pages());

//Ajax function
function update_table_ai()
{
    global $wpdb;
    $table = $wpdb->prefix . "title_switcher_ai";
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

add_action('wp_ajax_update_table', 'update_table_ai'); // for logged in users only
add_action('wp_ajax_nopriv_update_table', 'update_table_ai'); // for ALL users

require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

function generate_tag()
{
    $industry = $_POST['industry'];
    $city = $_POST['city'];
    $state = $_POST['state'];

    $open_ai_key = '';
    $open_ai = new OpenAi($open_ai_key);

    $complete = $open_ai->completion([
        'model' => 'davinci',
        'prompt' => 'Hello',
        'temperature' => 0.9,
        'max_tokens' => 150,
        'frequency_penalty' => 0,
        'presence_penalty' => 0.6,
    ]);

    echo $complete;
}

add_action('wp_ajax_generate_tag', 'generate_tag'); // for logged in users only
add_action('wp_ajax_nopriv_generate_tag', 'generate_tag'); // for ALL users