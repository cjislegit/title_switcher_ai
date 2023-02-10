<?php

class TitleSwitcher
{

    public function register()
    {
        add_filter('document_title_parts', array($this, 'my_custom_title'));
    }

    public function create_db() 
    {
        global $wpdb;

        $titleTagTableName = $wpdb->prefix . "title_switcher";

        $titleTagTable = $wpdb->get_results("SELECT * FROM $titleTagTableName");

        if (!$titleTagTable) {
            $charset_collate = $wpdb->get_charset_collate();
            
            $sql = "CREATE TABLE $titleTagTableName (
                page_id int NOT NULL,
                title_tag text,
                PRIMARY KEY (page_id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            $wpdb->insert($titleTagTableName, array("title_tag" => "Posts", "page_id" => 0));
        }
    }
    
    public function my_custom_title( $title ) {
        // $title is an array of title parts, including one called `title`
        global $post;
        global $wpdb;
        $pageId = $post->ID;
        $postId =  get_posts("post_type=post&numberposts=1&fields=ids");
        $table = $wpdb->prefix . "title_switcher";

        $pageId = $pageId == $postId[0] ? 0 : $pageId;

        $newTitleTag = $wpdb->get_var("SELECT title_tag FROM $table WHERE page_id = $pageId");

        if($newTitleTag) {
            $title['title'] = $newTitleTag;
            unset( $title['site'] );
        }
        

        return $title;
    }

    public function get_all_pages() {
        $pageIds = get_all_page_ids();
        $publishedIds = [];

        foreach ($pageIds as $pageId) {
            if (get_post_status($pageId) === 'publish') {
                $publishedIds[] = $pageId;
            }
        }
        return $publishedIds;
    }
}
