<?php

namespace OBVQ_WpPluginAutoload;
use OBVQ_WpPluginAutoload\Core\OBVQ_Feeds;
use OBVQ_WpPluginAutoload\Core\OBVQ_Quizzes;

/**
 * Code to run during the plugin's activation, deactivation or uninstallation.
 */
class OBVQ_Lifecycle
{
    /**
     * This method is automatically called on plugin activation.
     */

    var $db_version = '1.0';

    public function __construct()
    {
    }

    public function activate()
    {
        self::posttypes_init();
        self::taxonomies_init();

        flush_rewrite_rules();

        global $wpdb;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_feeds (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            term_id BIGINT(20) NOT NULL DEFAULT '0' ,
            user_id BIGINT(20) NOT NULL DEFAULT '0' ,
            slug TEXT NOT NULL ,
            title TEXT NOT NULL ,
            description LONGTEXT NOT NULL ,
            featured_image VARCHAR(255) NOT NULL ,
            submits_count INT(10) NOT NULL ,
            views_count INT(10) NOT NULL ,
            date_updated DATETIME NOT NULL ,
            date_added DATETIME NOT NULL ,
            flag_published TINYINT(1) NOT NULL DEFAULT '0' ,
            flag_main TINYINT(1) NOT NULL DEFAULT '0' ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_feeds CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        if($wpdb->get_var("show tables like '" . $wpdb->prefix . "ob_feeds'") == $wpdb->prefix . "ob_feeds") {
            $is_added_main_feed = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->prefix" . "ob_feeds WHERE flag_main = 1");
        }
        if($is_added_main_feed == 0){
            $term = term_exists('All stories', 'feeds');
            if ($term !== 0 && $term !== null) {
                wp_delete_term( $term, 'feeds' );
            }
            /*$parent_term = term_exists( 'feeds', 'quiz' ); // array is returned if taxonomy is given
            $parent_term_id = $parent_term['term_id']; // get numeric term id*/

            if($term['term_id'] > 0){
                $inserted_term['term_id'] = $term['term_id'];
            }
            else{
                $inserted_term = wp_insert_term(
                    'All stories', // the term
                    'feeds', // the taxonomy
                    array(
                        'description'=> 'This is main feed. Stories adding here by default.',
                        'slug' => 'all-stories'
                    )
                );
            }


            $current_user = wp_get_current_user();
            $wpdb->query("INSERT INTO " . $wpdb->prefix . "ob_feeds
                (id, term_id, user_id, slug, title, description, featured_image, submits_count, views_count, date_updated, date_added, flag_published, flag_main)
                VALUES
                (NULL, '".$inserted_term['term_id']."', $current_user->ID, 'all-stories', 'All stories', 'Stories adding here by default.', '', 0, 0, NOW(), NOW(), '1', '1');"
            );
        }

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_quizzes (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            post_id BIGINT(20) UNSIGNED NOT NULL ,
            user_id BIGINT(20) NOT NULL DEFAULT '0' ,
            `type` TINYINT(1) NOT NULL DEFAULT '0' ,
            layout VARCHAR(255) NOT NULL ,
            slug TEXT NOT NULL ,
            title TEXT NOT NULL ,
            description LONGTEXT NOT NULL ,
            featured_image VARCHAR(255) NOT NULL ,
            image_caption VARCHAR(255) NOT NULL ,
            views_count BIGINT(20) NOT NULL DEFAULT '0' , 
            date_added DATETIME NOT NULL ,
            date_updated DATETIME NOT NULL ,
            flag_list_ranked TINYINT(1) NOT NULL DEFAULT '0' ,
            flag_published TINYINT(1) NOT NULL DEFAULT '0' ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_quizzes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_score (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            quiz_id BIGINT(20) NOT NULL DEFAULT '0' ,
            user_id BIGINT(20) NOT NULL DEFAULT '0' ,
            result_id BIGINT(20) NOT NULL DEFAULT '0' ,
            email VARCHAR(255) NULL , 
            score INT(10) NOT NULL DEFAULT '0' , 
            op INT(10) NOT NULL DEFAULT '0' , 
            ip VARCHAR(255) NULL DEFAULT NULL ,
            date_added DATETIME NOT NULL ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_score CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_questions (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            quiz_id BIGINT(20) NOT NULL ,
            position INT(10) NOT NULL DEFAULT '0', 
            upvotes INT(10) NOT NULL DEFAULT '0', 
            title TEXT NOT NULL ,
            description LONGTEXT NOT NULL ,
            featured_image VARCHAR(255) NOT NULL ,
            image_caption VARCHAR(255) NOT NULL ,
            secondary_image VARCHAR(255) ,
            secondary_image_caption VARCHAR(255) ,
            explanation_title TEXT NOT NULL ,
            explanation LONGTEXT NOT NULL ,
            explanation_image VARCHAR(255) ,
            answers_type VARCHAR(255) NOT NULL,
            mediagrid_type VARCHAR(255) NOT NULL DEFAULT 'flex2',
            date_added DATETIME NOT NULL ,
            date_updated DATETIME NOT NULL ,
            flag_publish TINYINT(1) NOT NULL DEFAULT '0' ,
            flag_explanation TINYINT(1) NOT NULL DEFAULT '0' ,
            flag_pagebreak TINYINT(1) NOT NULL DEFAULT '0' ,
            flag_casesensitive TINYINT(1) NOT NULL DEFAULT '0' ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_questions CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_vote2question (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            question_id BIGINT(20) UNSIGNED NOT NULL ,
            ip VARCHAR(255) ,
            date_added DATETIME NOT NULL ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_vote2question CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_result_unlocks (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            quiz_id BIGINT(20) UNSIGNED NOT NULL ,
            user_id BIGINT(20) NOT NULL DEFAULT '0' ,
            ip VARCHAR(255) ,
            date_added DATETIME NOT NULL ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_result_unlocks CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_answers (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            quiz_id BIGINT(20) NOT NULL ,
            question_id BIGINT(20) NOT NULL ,
            title TEXT ,
            description LONGTEXT NOT NULL ,
            featured_image VARCHAR(255) ,
            flag_correct TINYINT(1) NOT NULL DEFAULT '0' ,
            flag_points INT(10) NOT NULL DEFAULT '0' ,
            flag_published TINYINT(1) NOT NULL DEFAULT '0' ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_answers CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_feed2quiz (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            feed_id BIGINT(20) UNSIGNED NOT NULL ,
            quiz_id BIGINT(20) UNSIGNED NOT NULL ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_feed2quiz CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_results (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            quiz_id BIGINT(20) NOT NULL ,
            title TEXT NOT NULL ,
            description LONGTEXT NOT NULL ,
            conditions VARCHAR(255) NOT NULL ,
            featured_image VARCHAR(255) NOT NULL ,
            image_caption VARCHAR(255) NOT NULL ,
            flag_published TINYINT(1) NOT NULL DEFAULT '0' ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_results CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_answer2result (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            answer_id BIGINT(20) UNSIGNED NOT NULL ,
            result_id BIGINT(20) UNSIGNED NOT NULL ,
            points INT(5) NOT NULL DEFAULT '0' ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_answer2result CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);


        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_advertisings (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            user_id BIGINT(20) NULL DEFAULT '0' ,
            type VARCHAR(255) NULL DEFAULT NULL ,
            title TEXT NULL DEFAULT NULL ,
            code LONGTEXT NULL ,
            image VARCHAR(255) NULL DEFAULT NULL ,
            link VARCHAR(255) NULL DEFAULT NULL ,
            flag_newwindow TINYINT(1) NULL DEFAULT '0' ,
            date_added DATETIME NOT NULL ,
            date_updated DATETIME NOT NULL ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_advertisings CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_adv_settings (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            advertising_id BIGINT(20) NULL DEFAULT NULL ,
            code VARCHAR(255) NULL DEFAULT NULL ,
            `value` VARCHAR(255) NULL DEFAULT NULL ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_adv_settings CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        if($wpdb->get_var("show tables like '" . $wpdb->prefix . "ob_adv_settings'") == $wpdb->prefix . "ob_adv_settings") {
            $is_added_adv_settings = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->prefix" . "ob_adv_settings WHERE code = 'before_story'");
        }
        if($is_added_adv_settings == 0) {
            $wpdb->query("INSERT INTO " . $wpdb->prefix . "ob_adv_settings
                (id, advertising_id, code, value)
                VALUES
                (NULL, NULL, 'before_story', NULL ),
                (NULL, NULL, 'after_story', NULL ),
                (NULL, NULL, 'under_result', NULL ),
                (NULL, NULL, 'between_items', NULL ),
                (NULL, NULL, 'between_count', 5 ),
                (NULL, NULL, 'no_ads_stories', NULL ),
                (NULL, NULL, 'show_on_mobiles', 1 ),
                (NULL, NULL, 'show_for_loggedin', 1 );"
            );
        }
        /*
         *
         *

        INSERT INTO `wp_ob_adv_settings` (`id`, `advertising_id`, `code`, `value`) VALUES
        (1, NULL, 'before_story', NULL),
        (2, NULL, 'after_story', NULL),
        (3, NULL, 'under_result', NULL),
        (4, NULL, 'between_items', NULL),
        (5, NULL, 'between_count', '5'),
        (6, NULL, 'no_ads_stories', NULL),
        (7, NULL, 'show_on_mobiles', '1'),
        (9, NULL, 'show_for_loggedin', '1');
        */


        $sql = "CREATE TABLE " . $wpdb->prefix . "ob_settings (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
            quiz_id BIGINT(20) NOT NULL ,
            type VARCHAR(255) NOT NULL ,
            code VARCHAR(255) NOT NULL ,
            title VARCHAR(255) NOT NULL ,
            value TEXT NOT NULL ,
            UNIQUE KEY id (id)
        );";
        dbDelta($sql);
        $sql = "ALTER TABLE " . $wpdb->prefix . "ob_settings CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
        $wpdb->query($sql);

        if($wpdb->get_var("show tables like '" . $wpdb->prefix . "ob_settings'") == $wpdb->prefix . "ob_settings") {
            $any_data_here = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->prefix" . "ob_settings WHERE quiz_id = 0 AND `type` <> 'advanced' ");
        }
        if($any_data_here == 0){
            $wpdb->query("INSERT INTO " . $wpdb->prefix . "ob_settings
                (id, type, code, title, value)
                VALUES
                (NULL, 'optin', 'mailchimp_api_key', '', ''),
                (NULL, 'optin', 'mailchimp_list_id', '', ''),
                (NULL, 'optin', 'display_optin_form', '', '0'),
                (NULL, 'optin', 'lock_results_form', '', '0'),
                (NULL, 'optin', 'form_heading', '', 'Want more stuff like this?'),
                (NULL, 'optin', 'form_subtitle', '', 'Get the best viral stories straight into your inbox!'),
                (NULL, 'optin', 'submit_button_text', '', 'Sign Up'),
                (NULL, 'optin', 'optin_warning', '', 'Don`t worry, we don`t spam'),
                (NULL, 'social', 'facebook_app_id', '', ''),
                (NULL, 'social', 'share_quiz_buttons', '', '1'),
                (NULL, 'social', 'share_results_buttons', '', '1'),
                (NULL, 'social', 'share_button_facebook', '', '1'),
                (NULL, 'social', 'share_button_twitter', '', '1'),
                (NULL, 'social', 'share_button_google', '', '1'),
                (NULL, 'general', 'quizzes_per_page', '', '10'),
                (NULL, 'general', 'display_feed_filters', '', '1'),
                (NULL, 'general', 'post_date', '', '1'),
                (NULL, 'general', 'post_author', '', '1'),
                (NULL, 'general', 'post_feed', '', '1'),
                (NULL, 'general', 'post_players_number', '', '1'),
                (NULL, 'general', 'post_views', '', '0'),
                (NULL, 'appearance', 'ui_elements_color', '', '#FF0136'),
                (NULL, 'appearance', 'label_color', '', '#ffffff'),
                (NULL, 'appearance', 'progress_bar_color', '', '#BDEF65'),
                (NULL, 'appearance', 'custom_css', '', ''),
                (NULL, 'appearance', 'obla_post_type_slug', '', 'quiz'),
                (NULL, 'appearance', 'obla_post_type_text', '', 'OnionBuzz Stories');"
            );
        }
        $is_settings_for_lock = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->prefix" . "ob_settings WHERE `type` = 'optin' AND `code` = 'settings_resultlock'");
        if($is_settings_for_lock == 0){
            $wpdb->query("INSERT INTO " . $wpdb->prefix . "ob_settings
                (id, type, code, title, value)
                VALUES
                (NULL, 'optin', 'settings_resultlock', '', '0'),
                (NULL, 'optin', 'sharing_heading', '', 'Share story to unlock your results'),
                (NULL, 'optin', 'lock_button_facebook', '', '1'),
                (NULL, 'optin', 'lock_button_twitter', '', '1'),
                (NULL, 'optin', 'lock_button_google', '', '1'),
                (NULL, 'optin', 'lock_ignore_quizids', '', '');"
            );
        }
        $is_settings_for_post_type = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->prefix" . "ob_settings WHERE `type` = 'appearance' AND `code` = 'obla_post_type_slug'");
        if($is_settings_for_post_type == 0){
            $wpdb->query("INSERT INTO " . $wpdb->prefix . "ob_settings
                (id, type, code, title, value)
                VALUES
                (NULL, 'appearance', 'obla_post_type_slug', '', 'quiz'),
                (NULL, 'appearance', 'obla_post_type_text', '', 'OnionBuzz Stories');"
            );
        }

    }

    /**
     * This method is automatically called on plugin deactivation.
     */
    public function deactivate()
    {
        global $wpdb;

        flush_rewrite_rules();

    }

    /**
     * This method is automatically called on plugin uninstallation.
     */
    public function uninstall()
    {
        global $wpdb;

        /*$oFeeds = new Feeds();
        $feeds = $oFeeds->getFeedsIDS();
        foreach($feeds['items'] as $k=>$v){
            wp_delete_term( $feeds['items'][$k]['term_id'], 'feeds' );
        }
        $oQuizzes = new Quizzes();
        $quizzes = $oQuizzes->getQuizzesIDS();
        foreach($quizzes['items'] as $k=>$v){
            wp_delete_post( $quizzes['items'][$k]['post_id'], true );
        }

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_feeds");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_answers");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_feed2quiz");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_questions");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_quizzes");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_results");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_settings");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ob_answer2result");*/

        //$wpdb->delete( $table, $where, $where_format = null );
        //$wpdb->delete( 'table', array( 'ID' => 1 ) );
        // Using where formatting.
        //$wpdb->delete( 'table', array( 'ID' => 1 ), array( '%d' ) );

        /*$wpdb->query(
            $wpdb->prepare(
                "
                DELETE FROM $wpdb->postmeta
		 WHERE post_id = %d
		 AND meta_key = %s
		",
                13, 'gargle'
            )
        );*/

        /*$wpdb->query( $wpdb->prepare(
        "
	    UPDATE $wpdb->posts
	    SET post_parent = 7
	    WHERE ID = 15
		AND post_status = 'static'
	    "
        ) );*/

    }

    public function posttypes_init() {
        $labels = array(
            'name'               => _x( 'Quizzes', 'post type general name', 'your-plugin-textdomain' ),
            'singular_name'      => _x( 'Quiz', 'post type singular name', 'your-plugin-textdomain' ),
            'menu_name'          => _x( 'Quiz', 'admin menu', 'your-plugin-textdomain' ),
            'name_admin_bar'     => _x( 'Quiz', 'add new on admin bar', 'your-plugin-textdomain' ),
            'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
            'add_new_item'       => __( 'Add New Quiz', 'your-plugin-textdomain' ),
            'new_item'           => __( 'New Quiz', 'your-plugin-textdomain' ),
            'edit_item'          => __( 'Edit Quiz', 'your-plugin-textdomain' ),
            'view_item'          => __( 'View Quiz', 'your-plugin-textdomain' ),
            'all_items'          => __( 'All Quizzes', 'your-plugin-textdomain' ),
            'search_items'       => __( 'Search Quizzes', 'your-plugin-textdomain' ),
            'parent_item_colon'  => __( 'Parent Quizzes:', 'your-plugin-textdomain' ),
            'not_found'          => __( 'No Quizzes found.', 'your-plugin-textdomain' ),
            'not_found_in_trash' => __( 'No Quizzes found in Trash.', 'your-plugin-textdomain' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Description.', 'your-plugin-textdomain' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'quiz' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
            //'taxonomies'            => array( 'feeds', 'category' ),
        );
        // https://codex.wordpress.org/Function_Reference/register_post_type
        register_post_type( 'quiz', $args );
    }

    public function taxonomies_init() {
        // Add new taxonomy, make it hierarchical (like categories)

        $labels = array(
            'name'              => _x( 'Feeds', 'taxonomy general name', 'textdomain' ),
            'singular_name'     => _x( 'Feed', 'taxonomy singular name', 'textdomain' ),
            'search_items'      => __( 'Search Feeds', 'textdomain' ),
            'all_items'         => __( 'All Feeds', 'textdomain' ),
            'parent_item'       => __( 'Parent Feed', 'textdomain' ),
            'parent_item_colon' => __( 'Parent Feed:', 'textdomain' ),
            'edit_item'         => __( 'Edit Feed', 'textdomain' ),
            'update_item'       => __( 'Update Feed', 'textdomain' ),
            'add_new_item'      => __( 'Add New Feed', 'textdomain' ),
            'new_item_name'     => __( 'New Feed Name', 'textdomain' ),
            'menu_name'         => __( 'Feeds', 'textdomain' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'feeds' ),
        );
        // https://codex.wordpress.org/Function_Reference/register_taxonomy
        register_taxonomy( 'feeds', array( 'quiz' ), $args );

        // Add new taxonomy, NOT hierarchical (like tags)
        /*$labels = array(
            'name'                       => _x( 'Tags', 'taxonomy general name', 'textdomain' ),
            'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'textdomain' ),
            'search_items'               => __( 'Search tags', 'textdomain' ),
            'popular_items'              => __( 'Popular Writers', 'textdomain' ),
            'all_items'                  => __( 'All Writers', 'textdomain' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Writer', 'textdomain' ),
            'update_item'                => __( 'Update Writer', 'textdomain' ),
            'add_new_item'               => __( 'Add New Writer', 'textdomain' ),
            'new_item_name'              => __( 'New Writer Name', 'textdomain' ),
            'separate_items_with_commas' => __( 'Separate writers with commas', 'textdomain' ),
            'add_or_remove_items'        => __( 'Add or remove writers', 'textdomain' ),
            'choose_from_most_used'      => __( 'Choose from the most used writers', 'textdomain' ),
            'not_found'                  => __( 'No writers found.', 'textdomain' ),
            'menu_name'                  => __( 'Writers', 'textdomain' ),
        );

        $args = array(
            'hierarchical'          => false,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'writer' ),
        );

        register_taxonomy( 'writer', 'quiz', $args );*/
        flush_rewrite_rules();
    }
}
