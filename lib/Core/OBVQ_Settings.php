<?php
namespace OBVQ_WpPluginAutoload\Core;

class OBVQ_Settings{

    private $wpdb;

    public $settings_codes = array(
        'all' => array(
            0 => 'ui_elements_color',
            1 => 'label_color',
            2 => 'progress_bar_color',
            3 => 'custom_css',
            4 => 'facebook_app_id',
            5 => 'share_results_buttons',
            6 => 'mailchimp_api_key',
            7 => 'mailchimp_list_id',
            8 => 'display_optin_form',
            9 => 'lock_results_form',
            10 => 'form_heading',
            11 => 'submit_button_text',
            12 => 'optin_warning',
            13 => 'form_subtitle',
            14 => 'sharing_heading',
            15 => 'lock_button_facebook',
            16 => 'lock_button_twitter',
            17 => 'lock_button_google',
            18 => 'settings_resultlock',
            19 => 'lock_ignore_quizids',
            20 => 'obla_post_type_slug',
            21 => 'obla_post_type_text'
        ),
        'general' => array(
            /*0 => 'quizzes_per_page',
            1 => 'display_feed_filters',
            2 => 'post_date',
            3 => 'post_author',
            4 => 'post_feed',
            5 => 'post_players_number',
            6 => 'post_views',*/
        ),
        'appearance' => array(
            0 => 'ui_elements_color',
            1 => 'label_color',
            2 => 'progress_bar_color',
            3 => 'custom_css',
            4 => 'obla_post_type_slug',
            5 => 'obla_post_type_text'
        ),
        'social' => array(
            0 => 'facebook_app_id',
            1 => 'share_quiz_buttons',
            2 => 'share_results_buttons',
            /*3 => 'share_button_facebook',
            4 => 'share_button_twitter',
            5 => 'share_button_google'*/
        ),
        'optin' => array(
            0 => 'mailchimp_api_key',
            1 => 'mailchimp_list_id',
            2 => 'display_optin_form',
            3 => 'lock_results_form',
            4 => 'form_heading',
            5 => 'submit_button_text',
            6 => 'optin_warning',
            7 => 'form_subtitle',
            8 => 'sharing_heading',
            9 => 'lock_button_facebook',
            10 => 'lock_button_twitter',
            11 => 'lock_button_google',
            12 => 'settings_resultlock',
            13 => 'lock_ignore_quizids'
        )
    );

    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;

        #print_r($this->wpdb);
        return 1;
    }

    public function getById($item_id)
    {
        $item_id = intval($item_id);
        $results = $this->wpdb->get_row( "SELECT * FROM `{$this->wpdb->prefix}ob_settings` WHERE id = {$item_id}", ARRAY_A );
        return $results;
    }

    public function getByType($type){
        $type = sanitize_text_field($type);
        $results = $this->wpdb->get_results( "SELECT * FROM `{$this->wpdb->prefix}ob_settings` WHERE `type` = '{$type}'", OBJECT );
        $i = 0;
        while ($i < count($results)) {
            $settings_list[$results[$i]->code] = $results[$i]->value;
            $i++;
        }

        #echo $results[0]->code;
        return $settings_list;
    }

    public function getByCode($code){
        $code = sanitize_text_field($code);
        $results = $this->wpdb->get_row( "SELECT * FROM `{$this->wpdb->prefix}ob_settings` WHERE code = '{$code}'", ARRAY_A );
        return $results;
    }

    public function getByQuizID($quiz_id){
        $quiz_id = intval($quiz_id);
        $results = $this->wpdb->get_results( "SELECT * FROM `{$this->wpdb->prefix}ob_settings` WHERE quiz_id = {$quiz_id}", OBJECT );
        $i = 0;
        while ($i < count($results)) {
            $settings_list[$results[$i]->code] = $results[$i]->value;
            $i++;
        }
        return @$settings_list;
    }

    public function getAll($query){
        $query = sanitize_text_field($query);
        $results = $this->wpdb->get_results( "SELECT * FROM `{$this->wpdb->prefix}ob_settings` WHERE 1 {$query}", ARRAY_A );
        /*$i = 0;
        while ($i < count($results)) {
            $settings_list[$results[$i]->code] = $results[$i]->value;
            $i++;
        }*/
        return $results;
    }

    public function updateSettings($type){

        $oConfig = new OBVQ_Config();
        $configs = $oConfig->get();

        $settings_type = $type;

        $standart_array = array(
            'post',
            'page',
            'attachment',
            'revision',
            'nav_menu_item',
            'custom_css',
            'poscustomize_changesett'
        );
        if(in_array($_POST['obla_post_type_slug'], $standart_array) || $_POST['obla_post_type_slug'] == '' || $_POST['obla_post_type_slug'] == ' ' || post_type_exists( $_POST['obla_post_type_slug'] )) {
            $_POST['obla_post_type_slug'] = 'quiz';
        }

        foreach($this->settings_codes[$settings_type] as $k=>$v){

            $this->wpdb->update(
                $this->wpdb->prefix.'ob_settings',
                array(
                    'value' => sanitize_text_field($_POST[$this->settings_codes[$settings_type][$k]])
                ),
                array(
                    'code' => $this->settings_codes[$settings_type][$k]
                ),
                array(
                    '%s',
                ),
                array( '%s' )
            );

        }

        // if updating custom post type slug
        $standart_array = array(
            'post',
            'page',
            'attachment',
            'revision',
            'nav_menu_item',
            'custom_css',
            'poscustomize_changesett'
        );
        if(!in_array($_POST['obla_post_type_slug'], $standart_array) && $_POST['obla_post_type_slug'] != '' && $_POST['obla_post_type_slug'] != ' ' && !post_type_exists( $_POST['obla_post_type_slug'] ))
        {
            if($_POST['obla_post_type_slug'] != $configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG']){
                global $wpdb, $wp_rewrite;
                $old_post_types = array($configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'] => sanitize_title($_POST['obla_post_type_slug']));

                #register_post_type( $configs['onionbuzz_posttypes']['OB_POST_TYPE_NAME'], $args );
                #unregister_taxonomy( $configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME']);
                #register_taxonomy( $configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'], array( $_POST['obla_post_type_slug'] ), $args );

                foreach ($old_post_types as $old_type=>$type) {
                    $q = 'numberposts=-1&post_status=any&post_type='.$old_type;
                    $items = get_posts($q);
                    foreach ($items as $item) {
                        $update['ID'] = $item->ID;
                        $update['post_type'] = $type;
                        wp_update_post( $update );
                    }
                }
                $wp_rewrite->flush_rules();
                flush_rewrite_rules();

            }
        }
        $return = 1;

        return $return;
    }

    public function updateSetting($item_id){

    }

    public function delete($item_id){
        // not for settings
    }
}