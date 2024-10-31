<?php
namespace OBVQ_WpPluginAutoload\Core;

class OBVQ_Feeds{

    private $item_id;
    private $wpdb;
    private $configs;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $oConfig = new OBVQ_Config();
        $this->configs = $oConfig->get();

        return 1;
    }

    public function getMain()
    {
        $results = $this->wpdb->get_row( "SELECT * FROM `{$this->wpdb->prefix}ob_feeds` WHERE flag_main = 1", ARRAY_A );
        $results = stripslashes_deep($results);
        return $results;
    }
    public function getFeedTermId($feed_id){
        $feed_id = intval($feed_id);
        $results = $this->wpdb->get_row( "SELECT term_id FROM `{$this->wpdb->prefix}ob_feeds` WHERE id = $feed_id", ARRAY_A );
        return $results;
    }
    public function getFeeds(){
        $results['items'] = $this->wpdb->get_results( "SELECT * FROM `{$this->wpdb->prefix}ob_feeds` ORDER BY flag_main DESC, title ASC", ARRAY_A );
        $results = stripslashes_deep($results);
        return $results;
    }
    public function getFeedsIDS(){
        $results['items'] = $this->wpdb->get_results( "SELECT * FROM `{$this->wpdb->prefix}ob_feeds` ORDER BY flag_main DESC, title ASC", ARRAY_A );
        $results = stripslashes_deep($results);
        return $results;
    }
    public function getAll($query = '', $page = 1, $orderby = '', $ordertype = ''){

        if($orderby != ''){
            $orderby = sanitize_title($orderby);
            $order = "ORDER BY {$orderby}";
        }
        if($ordertype != ''){
            $ordertype = sanitize_title($ordertype);
            $order = $order . " {$ordertype}";
        }
        if($query == 'all'){
            $query = "";
        }
        else if($query != ''){
            $query = sanitize_title_for_query($query);
            $query = "AND title COLLATE UTF8_GENERAL_CI LIKE '%{$query}%'";
        }

        $exclude_main_feed = "AND flag_main = 0";

        $items_count = $this->wpdb->get_row( "SELECT count(0) as total FROM `{$this->wpdb->prefix}ob_feeds` WHERE 1 {$query} {$exclude_main_feed}", ARRAY_A );

        // prepares for pagination
        $start = 0;
        $per_page = 10; // may be move to the global settings, but its only for admin panel
        $results['page'] = intval($page);
        $results['total_items'] = intval($items_count['total']);
        $results['total_pages'] = ceil($results['total_items'] / $per_page);

        if($results['page'] > 1){
            $start = ($results['page']-1)*($per_page);
        }

        $results['items'] = $this->wpdb->get_results( "SELECT *, DATE_FORMAT(date_added,'%m/%d/%Y') as date_added,(SELECT COUNT(0) FROM `{$this->wpdb->prefix}ob_feed2quiz` WHERE feed_id = `{$this->wpdb->prefix}ob_feeds`.`id`) as quizzes_count FROM `{$this->wpdb->prefix}ob_feeds` WHERE 1 {$query} {$exclude_main_feed} {$order} LIMIT {$start}, {$per_page}", ARRAY_A );

        foreach ($results['items'] as $k=>$v){
            $user_info = get_user_by('ID', $results['items'][$k]['user_id']);
            $results['items'][$k]['user_name'] = $user_info->user_login;
            $results['items'][$k]['players_count'] = 0;
            $results['items'][$k]['preview_link'] = get_term_link(intval($results['items'][$k]['term_id']), $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME']);
        }

        $results = stripslashes_deep($results);
        return json_encode($results);
    }
    public function getById($id)
    {
        $id = intval($id);
        $results = $this->wpdb->get_row( "SELECT * FROM `{$this->wpdb->prefix}ob_feeds` WHERE id = {$id}", ARRAY_A );
        $results = stripslashes_deep($results);

        if($results['slug'] == ''){
            $results['slug'] = sanitize_title($results['title']);
        }

        return $results;
    }
    public function getQuizzes($query = '', $page = 1, $orderby = '', $ordertype = ''){

        if($orderby != ''){
            $orderby = sanitize_title($orderby);
            $order = "ORDER BY {$orderby}";
        }
        if($ordertype != ''){
            $ordertype = sanitize_title($ordertype);
            $order = $order . " {$ordertype}";
        }
        if($query == 'all'){
            $query = "";
        }
        else if($query != ''){
            $query = sanitize_title_for_query($query);
            $query = "AND title COLLATE UTF8_GENERAL_CI LIKE '%{$query}%'";
        }

        #echo "SELECT * FROM `{$this->wpdb->prefix}ob_feeds` WHERE 1 {$query} {$order}";

        $results['page'] = 1;
        $results['total_items'] = 2;
        $results['items'] = $this->wpdb->get_results( "SELECT quiz_id as id, (SELECT title FROM `{$this->wpdb->prefix}ob_quizzes` WHERE id = quiz_id) as title FROM `{$this->wpdb->prefix}ob_feed2quiz`", OBJECT );

        return json_encode($results);
    }
    public function totalQuizzes ($feed_id){
        $feed_id = intval($feed_id);
        return $this->wpdb->get_row( "SELECT count(0) as total FROM `{$this->wpdb->prefix}ob_quizzes` WHERE feed_id = '{$feed_id}'", ARRAY_A );
    }
    public function prevFromId($id){
        $id = intval($id);
        return $results = $this->wpdb->get_row( "SELECT id FROM `{$this->wpdb->prefix}ob_feeds` WHERE id < {$id} ORDER BY id DESC LIMIT 1", ARRAY_A );
    }
    public function nextFromId($id){
        $id = intval($id);
        return $results = $this->wpdb->get_row( "SELECT id FROM `{$this->wpdb->prefix}ob_feeds` WHERE id > {$id} ORDER BY id ASC LIMIT 1", ARRAY_A );
    }
    public function totalFeeds (){
        return $this->wpdb->get_row( "SELECT count(0) as total FROM `{$this->wpdb->prefix}ob_feeds` WHERE 1", ARRAY_A );
    }
    public function save($item_id = 0, $data){

        $item_id = intval($item_id);
        $current_user = wp_get_current_user();
        #echo 'Username: ' . $current_user->user_login . '<br />';
        #echo 'User email: ' . $current_user->user_email . '<br />';
        #echo 'User first name: ' . $current_user->user_firstname . '<br />';
        #echo 'User last name: ' . $current_user->user_lastname . '<br />';
        #echo 'User display name: ' . $current_user->display_name . '<br />';
        #echo 'User ID: ' . $current_user->ID . '<br />';

        if($item_id > 0){

            $item_info = $this->wpdb->get_row( "SELECT term_id FROM `{$this->wpdb->prefix}ob_feeds` WHERE id = {$item_id} ORDER BY id ASC LIMIT 1", ARRAY_A );

            $parent_term = term_exists( $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'], $this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'], 0 ); // array is returned if taxonomy is given
            if(!$parent_term){

            }
            $return['success'] = 1;
            $return['action'] = 'UPDATE '.$item_info['term_id'];

            if(!isset($data['slug']) || $data['slug'] = ''){
                $data['slug'] = sanitize_title($data['title']);
            }

            $this->wpdb->update(
                $this->wpdb->prefix.'ob_feeds',
                array(
                    'user_id' => intval($current_user->ID),
                    'slug' => $data['slug'],
                    'title' => sanitize_text_field($data['title']),
                    'description' => $data['description'],
                    'featured_image' => sanitize_text_field($data['featured_image']),
                    'date_updated' => current_time('mysql', 1),
                    'flag_published' => intval($data['flag_published'])
                    //'flag_main' => 0
                ),
                array(
                    'id' => intval($data['id'])
                )
            );
            wp_update_term($item_info['term_id'], $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'], array(
                'name' => sanitize_text_field($data['title']),
                'slug' => $data['slug'],
                'description' => $data['description']
            ));

            $return['id'] = $item_id;
        } else{
            $return['action'] = 'INSERT INTO';

            if(!isset($data['slug']) || $data['slug'] == ''){
                $data['slug'] = sanitize_title($data['title']);
            }

            if(isset($data['flag_main'] )){
                $data['flag_main'] = intval($data['flag_main']);
            }

            // line below wrong function params!
            $parent_term = term_exists( $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'], $this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'], 0 ); // array is returned if taxonomy is given
            $parent_term_id = $parent_term['term_id']; // get numeric term id
            if(!$parent_term){
                $inserted_term = wp_insert_term(
                    sanitize_text_field($data['title']), // the term
                    $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'], // the taxonomy
                    array(
                        'description'=> $data['description'],
                        'slug' => $data['slug'],
                        'parent'=> $parent_term_id
                    )
                );

                $this->wpdb->insert(
                    $this->wpdb->prefix.'ob_feeds',
                    array(
                        'term_id' => $inserted_term['term_id'],
                        'user_id' => $current_user->ID,
                        'slug' => $data['slug'],
                        'title' => sanitize_text_field($data['title']),
                        'description' => $data['description'],
                        //'featured_image' => $data['featured_image'],
                        'submits_count' => 0,
                        'views_count' => 0,
                        'date_updated' => current_time('mysql', 1),
                        'date_added' => current_time('mysql', 1),
                        'flag_published' => intval($data['flag_published'])
                        //'flag_main' => 0
                    )
                );
                if($this->wpdb->insert_id > 0){
                    $return['success'] = 1;
                    $return['id'] = $this->wpdb->insert_id;
                }
            }
            else{
                $return['success'] = 0;
                $return['message'] = 'Term exists';
            }

        }

        return json_encode($return);

    }
    public function delete($item_id){
        $item_id = intval($item_id);
        if($item_id > 0){

            $item_info = $this->wpdb->get_row( "SELECT term_id FROM `{$this->wpdb->prefix}ob_feeds` WHERE id = {$item_id} ORDER BY id ASC LIMIT 1", ARRAY_A );
            $this->wpdb->delete( $this->wpdb->prefix.'ob_feeds', array( 'id' => $item_id ), array( '%d' ) );
            wp_delete_term( $item_info['term_id'], $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'] );

            $return['action'] = 'DELETE';
            $return['success'] = 1;
        }
        else{
            $return['success'] = 0;
        }
        return json_encode($return);

    }
    public function update($item_id){}


}