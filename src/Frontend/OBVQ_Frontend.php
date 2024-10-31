<?php

namespace OBVQ_WpPluginAutoload\Frontend;

use OBVQ_WpPluginAutoload\Core\OBVQ_Config;
use OBVQ_WpPluginAutoload\Core\OBVQ_Feeds;
use OBVQ_WpPluginAutoload\Core\OBVQ_Quizzes;
use OBVQ_WpPluginAutoload\Core\OBVQ_Settings;
use OBVQ_WpPluginAutoload\Core\OBVQ_Shortcodes;
use OBVQ_WpPluginAutoload\Core\OBVQ_User;
use OBVQ_WpPluginAutoload\Core\OBVQ_Results;
use OBVQ_WpPluginAutoload\Core\OBVQ_Answers;
use OBVQ_WpPluginAutoload\Core\OBVQ_Questions;
use OBVQ_WpPluginAutoload\Core\OBVQ_Posttype;

/**
 * Frontend functionality.
 */
class OBVQ_Frontend
{
    public $loader;
    public $is_onion = 0;
    private $wpdb;
    private $post;
    private $templating;
    private $configs;

    public function __construct($loader, $assets, $templating)
    {
        global $wpdb;
        global $post;
        global $posts;
        $this->wpdb = $wpdb;
        $this->post = $post;

        $oConfig = new OBVQ_Config();
        $this->configs = $oConfig->get();

        $this->templating = $templating;

        $assets->add_script('vendors/pnotify/pnotify.min.js');
        $assets->add_script('vendors/sharer/sharer.js');
        $assets->add_script('frontend/js/frontend.js');
        $assets->add_style('frontend/css/frontend.css');
        $assets->add_style('vendors/animations/animations.css');

        $this->loader = $loader;
        #$loader->add_action( 'init', $this, 'check_url' );
        //$loader->add_filter( 'the_posts', $this, 'confirm_page' );
        if($this->check_confirm_url() == 1){
            //$loader->add_filter( 'the_posts', $this, 'confirm_page' );
        }

        $loader->add_action( 'init', $this, 'taxonomies_init', 0 );
        $loader->add_action( 'init', $this, 'posttypes_init' );

        $loader->add_action( 'init', $this, 'shortcodes_init' );

        $loader->add_action( 'wp_head', $this, 'add_custom_css_file' );
        $loader->add_action( 'wp_head', $this, 'add_custom_js_vars' );

        #$loader->add_action( 'init', $this, 'check_tax');

        #$loader->add_filter('the_content', $this, 'init_custom_single_quiz', $priority = 10, $accepted_args = 1);
        #$loader->add_filter('single_template', $this, 'init_custom_single_quiz', $priority = 10, $accepted_args = 1);
        $loader->add_filter('archive_template', $this, 'get_custom_post_type_template', $priority = 10, $accepted_args = 1);
        $loader->add_filter('the_content', $this, 'quiz_post_init_game', $priority = 1, $accepted_args = 1);
        #$loader->add_filter('widget_posts_args', $this, 'filter_recent_posts_widget_parameters', $priority = 1, $accepted_args = 1);

        $loader->add_action( 'pre_get_posts',$this, 'ob_fix_custom_post_type_in_home' );
        $loader->add_action( 'pre_get_posts',$this, 'ob_fix_custom_post_type_in_archive_authorpage' );

        $loader->add_action( 'wp_ajax_nopriv_ob_get_results',$this, 'ob_get_results_callback' );
        $loader->add_action( 'wp_ajax_nopriv_ob_save_email',$this, 'ob_save_email_callback' );
        $loader->add_action( 'wp_ajax_nopriv_ob_question_votes',$this, 'ob_question_votes_callback' );
        $loader->add_action( 'wp_ajax_nopriv_ob_lock_share_clicked',$this, 'ob_lock_share_clicked_callback' );

        $loader->add_action( 'widgets_init', $this, 'register_widgets' );
        $loader->add_action( 'wp_enqueue_scripts', $this, 'localize_js', 10 );
    }
    function localize_js() {
        wp_localize_script($this->configs['onionbuzz_info']['OB_TEXTDOMAIN'].'-'.str_replace(DIRECTORY_SEPARATOR, '-', 'frontend/js/frontend.js'), 'onionbuzz_lng', array(
                'Correct' => __('Correct!', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'Wrong' => __('Wrong!', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'Question' => __('Question', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'Slide' => __('Slide', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'email_form_thank_you' => __('Thank you, your sign-up request was successful! Please check your e-mail inbox.', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'email_form_valid_email' => __('Enter valid email.', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_noresult_i_got' => __('I got', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_noresult_of' => __('of', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_noresult_right' => __('right', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_noresult_you_checked' => __('You checked', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_noresult_i_checked' => __('I checked', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_noresult_out_of' => __('out of', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_noresult_on_this_list' => __('on this list!', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
                'quiz_score' => __('Score:', $this->configs['onionbuzz_info']['OB_TEXTDOMAIN']),
            )
        );

    }
    function add_custom_css_file (){
        $oSettings = new OBVQ_Settings();
        $get_custom_css = $oSettings->getByCode("custom_css");
        $css_from_settings = $get_custom_css['value'];
        echo "\n<!-- Onionbuzz Custom CSS -->\n<style type=\"text/css\">\n".$css_from_settings."\n</style>\n<!-- Onionbuzz Custom CSS END -->\n";
    }
    function add_custom_js_vars(){
        $onionbuzz_variables = array (
            'ajax_url' => admin_url('admin-ajax.php'),
            'is_mobile' => wp_is_mobile()
        );
        echo'<script type="text/javascript">window.onionbuzz_params = '.json_encode($onionbuzz_variables).';</script>';
    }
    function filter_recent_posts_widget_parameters($params) {
        #$params['orderby'] = 'date';
        #$params['post_type'] = $this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'];
        #print_r($params);
        return $params;
    }
    public function register_widgets(){
        register_widget( '\OBVQ_WpPluginAutoload\Widgets\WP_Onionbuzz_Categories' );
        register_widget( '\OBVQ_WpPluginAutoload\Widgets\WP_Onionbuzz_Recent_Posts' );
    }
    public function ob_fix_custom_post_type_in_home($query)
    {
        if (is_home() && $query->get('post_type') != 'nav_menu_item') {

            $host = $_SERVER['HTTP_HOST'];
            if(in_array($host, $this->configs['onionbuzz_info']['OB_SHOW_ON_HOME_DOMAIN']) ) {
                $query->set('post_type', array($this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG']));
            }

        }
        return $query;
    }
    public function ob_fix_custom_post_type_in_archive_authorpage($query)
    {
        if (is_archive() && get_queried_object()->taxonomy == $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME'] && $query->get('post_type') != 'nav_menu_item') {
            $query->set('post_type', array($this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG']));
        }
        elseif(is_author() && $query->is_main_query()){
            $query->set('post_type', array('post', $this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG']));
        }
        return $query;
    }

    public function posttypes_init(){
        $oPosttype = new OBVQ_Posttype();
        $oPosttype->posttypes_init();
    }
    public function taxonomies_init(){
        $oPosttaxonomy = new OBVQ_Posttype();
        $oPosttaxonomy->taxonomies_init();
    }
    public function shortcodes_init(){
        $oShortcodes = new OBVQ_Shortcodes($this->loader,$this->templating);
    }
    public function check_tax(){
    }
    public function quiz_post_init_game( $content ) {
        if ( is_single() && $this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'] == get_post_type() ) {
            $custom_content = '[onionbuzz postid='.get_post()->ID.' title=0 image=0 description=1 embed=0][/onionbuzz]';
            $content = $custom_content;
            return $content;
        } else {
            return $content;
        }
    }

    public function init_custom_single_quiz($single) {
        global $wp_query, $post;

        /* Checks for single template by post type */
        if ($post->post_type == $this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG']){
            if(file_exists(__DIR__ . '/../../templates/frontend/quiz-single.php')){
                $data['post'] = $post;
                $this->templating->render('frontend/quiz-single', $data);
            }

        }
        #return $single;
    }

    public function get_custom_post_type_template( $archive_template ) {
        global $post;

        if ( is_post_type_archive ( $this->configs['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'] ) ) {
            $data['test'] = 1;
            #$this->templating->render('frontend/quiz-single', $data);
        }
    }


    public function check_confirm_url() {
        if (false !== strpos($_SERVER['REQUEST_URI'], '/quiz')) {
            $this->is_onion = 1;
            return 1;
        }
        return false !== strpos( $_SERVER[ 'REQUEST_URI' ], '/onionbuzz' );
    }
    public function check_url() {

        if( $this->check_confirm_url() == 1 ) {
            $this->loader->add_filter( 'the_posts', $this, 'confirm_page' );
        }
    }
    public function confirm_page( $posts ) {

    }
}
/*
 * add_action( 'the_post', 'replace_newline' );

function replace_newline( $post ) {
    $post->content = str_replace( "\n", "<br>", $post->post_content );
}
 */
?>