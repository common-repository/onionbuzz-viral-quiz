<?php

namespace OBVQ_WpPluginAutoload\Admin;

use OBVQ_WpPluginAutoload\Core\OBVQ_Config;
use OBVQ_WpPluginAutoload\Core\OBVQ_Feeds;
use OBVQ_WpPluginAutoload\Core\OBVQ_Quizzes;
use OBVQ_WpPluginAutoload\Core\OBVQ_Settings;
use OBVQ_WpPluginAutoload\Core\OBVQ_User;
use OBVQ_WpPluginAutoload\Core\OBVQ_Results;
use OBVQ_WpPluginAutoload\Core\OBVQ_Answers;
use OBVQ_WpPluginAutoload\Core\OBVQ_Questions;
use OBVQ_WpPluginAutoload\Core\OBVQ_Posttype;
use OBVQ_WpPluginAutoload\Core\OBVQ_MailChimp;
use OBVQ_WpPluginAutoload\Core\OBVQ_Mobile_Detect;

/**
 * Admin-specific functionality.
 */
class OBVQ_Admin
{
    private $wpdb;
    private $templating;
    private $menu_top;
    private $current_page;
    private $plugin_version;
    private $configs;

    public function __construct($loader, $assets, $templating)
    {
        global $wpdb; // this is how you get access to the database
        $this->wpdb = $wpdb;

        $oConfig = new OBVQ_Config();
        $this->configs = $oConfig->get();

        $this->plugin_version = $assets->plugin_version();

        $this->templating = $templating;

        $current_page = isset($_GET['page']) ? $_GET['page'] : '';
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : '';
        $available_pages = array('la_onionbuzz_dashboard','la_onionbuzz_feeds','la_onionbuzz_settings','la_onionbuzz_help');

        if( in_array($current_page, $available_pages)){
            $assets->add_script('vendors/jquery-ui/jquery-ui.min.js');

            $assets->add_script('vendors/jquery-confirm-master/jquery-confirm.min.js');
            $assets->add_script('vendors/jquery-ui-slider-pips/jquery-ui-slider-pips.js');
            $assets->add_script('vendors/sliders/native/nativemultiple.jquery.js');

            $assets->add_script('vendors/bootstrap/js/bootstrap.min.js');
            //$assets->add_script('vendors/bootstrap/js/bootstrap-confirmation.js');
            $assets->add_script('vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js');
            //$assets->add_script('vendors/bootstrap-switch/js/bootstrap-switch.js');

            $assets->add_script('vendors/pnotify/pnotify.min.js');
            $assets->add_script('vendors/paginators/jqPaginator.js');
            $assets->add_script('vendors/ays/jquery.are-you-sure.js');

            //backbone routes
            if($current_page == 'la_onionbuzz_settings'){
                $assets->add_script('admin/js/routes/settings.js');
            }
            else if($current_page == 'la_onionbuzz_dashboard'){
                if($current_tab == '') {
                    $assets->add_script('admin/js/models/singleQuiz.js');
                    $assets->add_script('admin/js/views/singleQuiz.js');
                    $assets->add_script('admin/js/views/allQuizzes.js');
                    $assets->add_script('admin/js/collections/allQuizzes.js');
                }
                else if($current_tab == 'quiz_results'){
                    $assets->add_script('admin/js/models/singleQuizResult.js');
                    $assets->add_script('admin/js/views/singleQuizResult.js');
                    $assets->add_script('admin/js/views/allQuizResults.js');
                    $assets->add_script('admin/js/collections/allQuizResults.js');
                }
                else if($current_tab == 'quiz_questions'){
                    $assets->add_script('admin/js/models/singleQuizQuestion.js');
                    $assets->add_script('admin/js/views/singleQuizQuestion.js');
                    $assets->add_script('admin/js/views/allQuizQuestions.js');
                    $assets->add_script('admin/js/collections/allQuizQuestions.js');
                }
                else if($current_tab == 'quiz_question_answers'){
                    $assets->add_script('admin/js/models/singleQuizQuestionAnswer.js');
                    $assets->add_script('admin/js/views/singleQuizQuestionAnswer.js');
                    $assets->add_script('admin/js/views/allQuizQuestionAnswers.js');
                    $assets->add_script('admin/js/collections/allQuizQuestionAnswers.js');
                }
                else if($current_tab == 'quiz_stats_players') {
                    $assets->add_script('admin/js/models/singleQuizStatsPlayer.js');
                    $assets->add_script('admin/js/views/singleQuizStatsPlayer.js');
                    $assets->add_script('admin/js/views/allQuizStatsPlayers.js');
                    $assets->add_script('admin/js/collections/allQuizStatsPlayers.js');
                }
                $assets->add_script('admin/js/routes/quizzes.js');
            }
            else if($current_page == 'la_onionbuzz_feeds'){
                $assets->add_script('admin/js/models/singleFeedModel.js');
                $assets->add_script('admin/js/models/singleFeedQuiz.js');
                $assets->add_script('admin/js/views/singleFeedView.js');
                $assets->add_script('admin/js/views/singleFeedQuiz.js');
                $assets->add_script('admin/js/views/allFeedsView.js');
                $assets->add_script('admin/js/views/allFeedQuizzes.js');
                //$assets->add_script('admin/js/views/paginationView.js');
                $assets->add_script('admin/js/collections/allFeeds.js');
                $assets->add_script('admin/js/collections/allFeedQuizzes.js');
                $assets->add_script('admin/js/routes/feeds.js');
            }

            else{
                $assets->add_script('admin/js/routes/route.js');
            }
            //app core
            $assets->add_script('admin/js/admin.js');

            $assets->add_style('vendors/jquery-ui/jquery-ui.css');
            $assets->add_style('vendors/jquery-ui/jquery-ui.structure.css');
            $assets->add_style('vendors/jquery-ui/jquery-ui.theme.css');

            $assets->add_style('admin/css/animate.css');
            $assets->add_style('vendors/pnotify/pnotify.css');
            $assets->add_style('vendors/bootstrap/css/bootstrap.css');
            $assets->add_style('vendors/bootstrap/css/bootstrap-theme.css');
            $assets->add_style('vendors/bootstrap/css/icheck-bootstrap.css');
            $assets->add_style('vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.css');
            //$assets->add_style('vendors/bootstrap-switch/css/bootstrap-switch.css');
            $assets->add_style('vendors/jquery-confirm-master/jquery-confirm.min.css');
            $assets->add_style('vendors/jquery-ui-slider-pips/jquery-ui-slider-pips.css');
            $assets->add_style('vendors/sliders/native/nativemultiple.jquery.css');
            $assets->add_style('admin/css/css-loader.css');
            $assets->add_style('admin/css/admin.css');

        }

        $loader->add_action('admin_menu', $this, 'admin_menu');

        $loader->add_action( 'wp_ajax_ob_get_results',$this, 'ob_get_results_callback' );
        $loader->add_action( 'wp_ajax_nopriv_ob_get_results',$this, 'ob_get_results_callback' );

        $loader->add_action( 'wp_ajax_ob_question_votes',$this, 'ob_question_votes_callback' );
        $loader->add_action( 'wp_ajax_nopriv_ob_question_votes',$this, 'ob_question_votes_callback' );

        $loader->add_action( 'wp_ajax_ob_save_email',$this, 'ob_save_email_callback' );
        $loader->add_action( 'wp_ajax_nopriv_ob_save_email',$this, 'ob_save_email_callback' );

        $loader->add_action( 'wp_ajax_ob_lock_share_clicked',$this, 'ob_lock_share_clicked_callback' );
        $loader->add_action( 'wp_ajax_nopriv_ob_lock_share_clicked',$this, 'ob_lock_share_clicked_callback' );

        $loader->add_action( 'wp_ajax_ob_settings',$this, 'ob_settings_callback' );

        $loader->add_action( 'wp_ajax_ob_feeds',$this, 'ob_feeds_callback' );
        $loader->add_action( 'wp_ajax_ob_feed',$this, 'ob_feed_callback' );
        $loader->add_action( 'wp_ajax_ob_feed_quizzes',$this, 'ob_feed_quizzes_callback' );

        $loader->add_action( 'wp_ajax_ob_quizzes',$this, 'ob_quizzes_callback' );
        $loader->add_action( 'wp_ajax_ob_quiz',$this, 'ob_quiz_callback' );

        $loader->add_action( 'wp_ajax_ob_quiz_results',$this, 'ob_quiz_results_callback' );
        $loader->add_action( 'wp_ajax_ob_quiz_result',$this, 'ob_quiz_result_callback' );
        $loader->add_action( 'wp_ajax_ob_quiz_results_conditions',$this, 'ob_quiz_results_conditions_callback' );

        $loader->add_action( 'wp_ajax_ob_quiz_questions',$this, 'ob_quiz_questions_callback' );
        $loader->add_action( 'wp_ajax_ob_quiz_question',$this, 'ob_quiz_question_callback' );
        $loader->add_action( 'wp_ajax_ob_questions_resort',$this, 'ob_questions_resort_callback' );

        $loader->add_action( 'wp_ajax_ob_quiz_question_answers',$this, 'ob_quiz_question_answers_callback' );
        $loader->add_action( 'wp_ajax_ob_quiz_question_answer',$this, 'ob_quiz_question_answer_callback' );

        $loader->add_action( 'wp_ajax_ob_quiz_settings',$this, 'ob_quiz_settings_callback' );

        $loader->add_action( 'wp_ajax_ob_quiz_stats',$this, 'ob_quiz_stats_callback' );

        $loader->add_action( 'wp_ajax_ob_stats_erase',$this, 'ob_stats_erase_callback' );

        $loader->add_action( 'init', $this, 'taxonomies_init', 0 );
        $loader->add_action( 'init', $this, 'posttypes_init' );

        $loader->add_action( 'widgets_init', $this, 'register_widgets' );

        $loader->add_action( 'plugins_loaded', $this, 'my_plugin_load_plugin_textdomain' );
    }
    function my_plugin_load_plugin_textdomain() {
        #load_plugin_textdomain( "onionbuzz", FALSE, '/onionbuzz/languages/' );
    }
    public function register_widgets(){
        register_widget( '\OBVQ_WpPluginAutoload\Widgets\WP_Onionbuzz_Categories' );
        register_widget( '\OBVQ_WpPluginAutoload\Widgets\WP_Onionbuzz_Recent_Posts' );
    }

    public function posttypes_init(){
        $oPosttype = new OBVQ_Posttype();
        $oPosttype->posttypes_init();
    }
    public function taxonomies_init(){
        $oPosttaxonomy = new OBVQ_Posttype();
        $oPosttaxonomy->taxonomies_init();
    }


    public function admin_menu()
    {
        add_menu_page('OnionBuzz', 'OnionBuzz', 'edit_posts', 'la_onionbuzz_dashboard', array($this, 'init_dashboard_page') , 'data:image/svg+xml;base64,'.base64_encode('<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve">
<style type="text/css">
	.st0{fill:#9EA3A8;}
</style>
<path id="Oval" class="st0" d="M10,19.6c-5.3,0-9.6-4.3-9.6-9.6S4.7,0.4,10,0.4s9.6,4.3,9.6,9.6S15.3,19.6,10,19.6z M10,18.4
	c4.6,0,8.4-3.8,8.4-8.4S14.6,1.6,10,1.6S1.6,5.4,1.6,10S5.4,18.4,10,18.4z"/>
<path id="Oval-Copy-2" class="st0" d="M10.5,17.6c-3.9,0-7.1-3.2-7.1-7.1s3.2-7.1,7.1-7.1s7.1,3.2,7.1,7.1S14.4,17.6,10.5,17.6z
	 M10.5,16.4c3.3,0,5.9-2.6,5.9-5.9s-2.6-5.9-5.9-5.9s-5.9,2.6-5.9,5.9S7.2,16.4,10.5,16.4z"/>
<path id="Oval-Copy-3" class="st0" d="M10,14.6c-2.5,0-4.6-2.1-4.6-4.6S7.5,5.4,10,5.4s4.6,2.1,4.6,4.6S12.5,14.6,10,14.6z M10,13.4
	c1.9,0,3.4-1.5,3.4-3.4S11.9,6.6,10,6.6S6.6,8.1,6.6,10S8.1,13.4,10,13.4z"/>
<path id="Oval-Copy-4" class="st0" d="M10,12.6c-1.4,0-2.6-1.2-2.6-2.6S8.6,7.4,10,7.4s2.6,1.2,2.6,2.6S11.4,12.6,10,12.6z M10,11.4
	c0.8,0,1.4-0.6,1.4-1.4c0-0.8-0.6-1.4-1.4-1.4S8.6,9.2,8.6,10C8.6,10.8,9.2,11.4,10,11.4z"/>
<path id="middle-dot" class="st0" d="M10,11.2c-0.4,0-0.7-0.3-0.7-0.7c0-0.4,0.3-0.7,0.7-0.7s0.7,0.3,0.7,0.7
	C10.7,10.9,10.4,11.2,10,11.2z"/>
</svg>'));
        add_submenu_page( 'la_onionbuzz_dashboard', 'OnionBuzz - Stories', 'Stories', 'edit_posts', 'la_onionbuzz_dashboard', array($this, 'init_dashboard_page') );
        add_submenu_page( 'la_onionbuzz_dashboard', 'OnionBuzz - Feeds', 'Feeds', 'edit_posts', 'la_onionbuzz_feeds', array($this, 'init_feeds_page') );
        add_submenu_page( 'la_onionbuzz_dashboard', 'OnionBuzz - Settings', 'Settings', 'edit_posts', 'la_onionbuzz_settings', array($this, 'init_settings_page') );
    }

    public function init_dashboard_page()
    {
        $oQuizzes = new OBVQ_Quizzes(1);
        $oFeeds = new OBVQ_Feeds();
        $oResults = new OBVQ_Results();
        $oQuestions = new OBVQ_Questions();
        $oAnswers = new OBVQ_Answers();
        $oSettings = new OBVQ_Settings();

        $data = array(
            'templating' => $this->templating,
            'base' => plugin_dir_path(__FILE__),
            'current_menu_top' => 'quizzes',
            'current_tab' => 'quizzes_all',
            'plugin_version' => $this->plugin_version
        );

        if(!isset($_GET['tab']) || $_GET['tab'] == 'quizzes_all') {
            $data['total_quizzes'] = $oQuizzes->totalQuizzes();
            $data['total_quizzes'] = $data['total_quizzes']['total'];
            $data['feeds'] = $oFeeds->getFeeds();
            $this->templating->render('admin/quizzes', $data);
        }
        else if($_GET['tab'] == 'quiz_edit'){
            $data['current_tab'] = 'quiz_edit';
            $data['edit_quiz']['id'] = intval(@$_REQUEST['quiz_id']);

            if($data['edit_quiz']['id'] == 0){
                $data['edit_quiz']['title'] = "";

                $data['edit_quiz']['type'] = intval($_REQUEST['type']);
                if($data['edit_quiz']['type'] == 1){
                    $data['edit_quiz']['page_title'] = "Create Trivia Quiz";
                }
                if($data['edit_quiz']['type'] == 2){
                    $data['edit_quiz']['page_title'] = "Create Personality Quiz";
                }
                if($data['edit_quiz']['type'] == 3){
                    $data['edit_quiz']['page_title'] = "Create List\Ranked List";
                }
                if($data['edit_quiz']['type'] == 4){
                    $data['edit_quiz']['page_title'] = "Create Flip Cards";
                }
            }
            else{
                $data['edit_quiz'] = $oQuizzes->getById($data['edit_quiz']['id']);
                $data['edit_quiz']['page_title'] = $data['edit_quiz']['title'];
                $data['edit_quiz']['results_count'] = intval($oQuizzes->totalQuizResults($data['edit_quiz']['id']));
                $data['edit_quiz']['questions_count'] = intval($oQuizzes->totalQuizQuestions($data['edit_quiz']['id']));
                $data['edit_quiz']['feeds'] = $oQuizzes->getQuizFeeds($data['edit_quiz']['id']);
                $data['edit_quiz']['preview_link'] = get_permalink($data['edit_quiz']['post_id']);

                $data['quiz_settings'] = $oSettings->getByQuizID($data['edit_quiz']['id']);

            }
            $data['feeds'] = $oFeeds->getFeeds();


            $this->templating->render('admin/quiz-edit', $data);
        }
        else if($_GET['tab'] == 'quiz_settings'){
            $data['current_tab'] = 'quiz_settings';

            $data['edit_quiz']['id'] = intval($_REQUEST['quiz_id']);
            $data['edit_quiz'] = $oQuizzes->getById($data['edit_quiz']['id']);
            $data['edit_quiz']['results_count'] = intval($oQuizzes->totalQuizResults($data['edit_quiz']['id']));
            $data['edit_quiz']['questions_count'] = intval($oQuizzes->totalQuizQuestions($data['edit_quiz']['id']));
            $data['edit_quiz']['preview_link'] = get_permalink($data['edit_quiz']['post_id']);
            $data['quiz_settings'] = $oSettings->getByQuizID($data['edit_quiz']['id']);

            $this->templating->render('admin/quiz-settings', $data);
        }
        else if($_GET['tab'] == 'quiz_results'){
            $data['current_tab'] = 'quiz_results';
            $data['edit_quiz']['id'] = intval($_REQUEST['quiz_id']);
            $data['edit_quiz'] = $oQuizzes->getById($data['edit_quiz']['id']);
            $data['edit_quiz']['results_count'] = intval($oQuizzes->totalQuizResults($data['edit_quiz']['id']));
            $data['edit_quiz']['questions_count'] = intval($oQuizzes->totalQuizQuestions($data['edit_quiz']['id']));
            $data['edit_quiz']['preview_link'] = get_permalink($data['edit_quiz']['post_id']);
            $this->templating->render('admin/quiz-results', $data);
        }
        else if($_GET['tab'] == 'quiz_result_edit'){
            $data['current_tab'] = 'quiz_result_edit';

            $data['edit_result']['id'] = intval($_REQUEST['result_id']);
            $data['edit_result']['quiz_id'] = intval($_REQUEST['quiz_id']);
            $data['quiz_info'] = $oQuizzes->getById($data['edit_result']['quiz_id']);

            if($data['edit_result']['id'] == 0){
                $data['edit_result']['page_title'] = "Add another awesome result";
            }
            else{
                $data['edit_result'] = $oResults->getById($data['edit_result']['id']);
                $data['prev_item'] = $oResults->prevFromId($data['edit_result']['id'], array('quiz_id'=>$data['quiz_info']['id']));
                $data['next_item'] = $oResults->nextFromId($data['edit_result']['id'], array('quiz_id'=>$data['quiz_info']['id']));
                $data['edit_result']['page_title'] = $data['edit_result']['title'];
            }
            $data['edit_result']['results_count'] = intval($oQuizzes->totalQuizResults($data['edit_result']['quiz_id']));
            $this->templating->render('admin/quiz-result-edit', $data);
        }
        else if($_GET['tab'] == 'quiz_questions'){
            $data['current_tab'] = 'quiz_questions';
            $data['edit_quiz']['id'] = intval($_REQUEST['quiz_id']);
            $data['edit_quiz'] = $oQuizzes->getById($data['edit_quiz']['id']);
            $data['edit_quiz']['results_count'] = intval($oQuizzes->totalQuizResults($data['edit_quiz']['id']));
            $data['edit_quiz']['questions_count'] = intval($oQuizzes->totalQuizQuestions($data['edit_quiz']['id']));
            $data['edit_quiz']['preview_link'] = get_permalink($data['edit_quiz']['post_id']);
            $this->templating->render('admin/quiz-questions', $data);
        }
        else if($_GET['tab'] == 'quiz_question_edit'){
            $data['current_tab'] = 'quiz_question_edit';

            $data['edit_question']['id'] = intval($_REQUEST['question_id']);
            $data['edit_question']['quiz_id'] = intval($_REQUEST['quiz_id']);
            $data['quiz_info'] = $oQuizzes->getById($data['edit_question']['quiz_id']);

            if($data['edit_question']['id'] == 0){
                $data['edit_question']['page_title'] = "Add another awesome question";
            }
            else{
                $data['edit_question'] = $oQuestions->getById($data['edit_question']['id']);
                $data['edit_question']['page_title'] = $data['edit_question']['title'];
                $data['prev_item'] = $oQuestions->prevFromId($data['edit_question']['id'], array('quiz_id'=>$data['quiz_info']['id']));
                $data['next_item'] = $oQuestions->nextFromId($data['edit_question']['id'], array('quiz_id'=>$data['quiz_info']['id']));
                $data['edit_question']['answers_count'] = intval($oQuestions->totalQuestionAnswers($data['edit_question']['id']));

                //if type `match` get answers and form string
                if($data['edit_question']['answers_type'] == 'match') {
                    $data['edit_question']['answers'] = $oAnswers->getAllByQuestionID($data['edit_question']['id']);
                    foreach ($data['edit_question']['answers']['items'] as $k => $v) {
                        $data['edit_question']['answers_array'][$k] = $data['edit_question']['answers']['items'][$k]['title'];
                    }
                    if(count($data['edit_question']['answers_array']) > 0){
                        $data['edit_question']['answers_string'] = implode(", ", $data['edit_question']['answers_array']);
                    }

                }

            }

            $this->templating->render('admin/quiz-question-edit', $data);
        }
        else if($_GET['tab'] == 'quiz_question_answers'){
            $data['current_tab']                    = 'quiz_question_answers';
            $data['answers_list']['quiz_id']        = intval($_REQUEST['quiz_id']);
            $data['answers_list']['question_id']    = intval($_REQUEST['question_id']);
            $data['quiz_info']                      = $oQuizzes->getById($data['answers_list']['quiz_id']);
            $data['question_info']                  = $oQuestions->getById($data['answers_list']['question_id']);
            $data['answers_list']['answers_count']  = intval($oQuestions->totalQuestionAnswers($data['answers_list']['question_id']));
            $data['prev_item']                      = $oQuestions->prevFromId($data['question_info']['id'], array('quiz_id'=>$data['quiz_info']['id']));
            $data['next_item']                      = $oQuestions->nextFromId($data['question_info']['id'], array('quiz_id'=>$data['quiz_info']['id']));
            $this->templating->render('admin/quiz-question-answers', $data);
        }
        else if($_GET['tab'] == 'quiz_question_answer_edit'){
            $data['current_tab'] = 'quiz_question_answer_edit';

            $data['edit_answer']['id']              = intval($_REQUEST['answer_id']);
            $data['edit_answer']['quiz_id']         = intval($_REQUEST['quiz_id']);
            $data['edit_answer']['question_id']     = intval($_REQUEST['question_id']);
            $data['quiz_info']                      = $oQuizzes->getById($data['edit_answer']['quiz_id']);
            $data['question_info']                  = $oQuestions->getById($data['edit_answer']['question_id']);
            $data['prev_item']                      = $oAnswers->prevFromId($data['edit_answer']['id'], array('quiz_id'=>$data['quiz_info']['id'],'question_id'=>$data['question_info']['id']));
            $data['next_item']                      = $oAnswers->nextFromId($data['edit_answer']['id'], array('quiz_id'=>$data['quiz_info']['id'],'question_id'=>$data['question_info']['id']));
            if($data['quiz_info']['type'] == 2){
                $data['quiz_results'] = $oResults->getResultsByQuizID($data['quiz_info']['id']);
                foreach($data['quiz_results'] as $k=>$v){
                    $data['quiz_results'][$k]['points'] = $oResults->getResultPointsByResultIDAnswerID($data['quiz_results'][$k]['id'],$data['edit_answer']['id']);
                }
            }

            if($data['edit_answer']['id'] == 0){
                $data['edit_answer']['page_title'] = "Add another awesome answer";
            }
            else{
                $data['edit_answer'] = $oAnswers->getById($data['edit_answer']['id']);
                $data['edit_answer']['page_title'] = $data['edit_answer']['title'];
            }
            $data['edit_answer']['answers_count'] = intval($oQuestions->totalQuestionAnswers($data['edit_answer']['question_id']));
            $this->templating->render('admin/quiz-question-answer-edit', $data);
        }
        else if($_GET['tab'] == 'quiz_stats'){
            $data['current_tab'] = 'quiz_stats';

            $data['quiz_info'] = $oQuizzes->getById(intval($_REQUEST['quiz_id']));
            $data['quiz_info']['players'] = $oQuizzes->getPlayersCountByID(intval($_REQUEST['quiz_id']));
            $data['quiz_info']['avg'] = $oQuizzes->getAvgScoreByID(intval($_REQUEST['quiz_id']));

            $this->templating->render('admin/quiz-stats', $data);
        }
        else if($_GET['tab'] == 'quiz_stats_players'){
            $data['current_tab'] = 'quiz_stats_players';

            $data['quiz_info'] = $oQuizzes->getById(intval($_REQUEST['quiz_id']));

            $this->templating->render('admin/quiz-stats-players', $data);
        }
        else if($_GET['tab'] == 'quiz_stats_results'){
            $data['current_tab'] = 'quiz_stats_results';

            $data['quiz_info'] = $oQuizzes->getById(intval($_REQUEST['quiz_id']));

            $results_array = $oQuizzes->getStatsResults($data['quiz_info']['id']);
            $results_info_total_players = $this->wpdb->get_row( "SELECT count(0) as total FROM `{$this->wpdb->prefix}ob_score` WHERE 1 AND quiz_id = '{$data['quiz_info']['id']}'", ARRAY_A );
            $i=0;
            foreach ($results_array as $k=>$v){
                $data['results_list'][$i] = $results_array[$k];
                $data['results_list'][$i]['total_players'] = $this->wpdb->get_row( "SELECT count(0) as total FROM `{$this->wpdb->prefix}ob_score` WHERE 1 AND quiz_id = '{$data['quiz_info']['id']}' AND result_id = '{$results_array[$k]['id']}'", ARRAY_A );

                if($results_info_total_players['total']>0) {
                    $data['results_list'][$i]['avg_players'] = $data['results_list'][$i]['total_players']['total'] * 100 / $results_info_total_players['total'];
                }
                else{
                    $data['results_list'][$i]['avg_players'] = 0;
                }
                $i++;
            }
            $this->templating->render('admin/quiz-stats-results', $data);
        }

    }
    public function init_feeds_page()
    {
        $oFeeds = new OBVQ_Feeds();

        $data = array(
            'templating' => $this->templating,
            'base' => plugin_dir_path(__FILE__),
            'current_menu_top' => 'feeds',
            'plugin_version' => $this->plugin_version
        );
        if(!isset($_GET['tab']) || $_GET['tab'] == 'feeds_all') {
            $data['main_feed'] = $oFeeds->getMain();

            $data['total_feeds'] = $oFeeds->totalFeeds();
            $data['total_feeds'] = $data['total_feeds']['total'];

            $this->templating->render('admin/feeds', $data);
        }
        else if($_GET['tab'] == 'feed_edit'){
            $data['edit_feed']['id'] = intval(@$_REQUEST['feed_id']);
            $data['prev_item'] = $oFeeds->prevFromId($data['edit_feed']['id']);
            $data['next_item'] = $oFeeds->nextFromId($data['edit_feed']['id']);

            if($data['edit_feed']['id'] == 0){
                $data['edit_feed']['page_title'] = "Add new feed";
            }
            else{
                $data['edit_feed'] = $oFeeds->getById($data['edit_feed']['id']);
                $data['edit_feed']['page_title'] = $data['edit_feed']['title'];
                $data['edit_feed']['preview_link'] = get_term_link($data['edit_feed']['slug'], $this->configs['onionbuzz_posttypes']['OB_TAXONOMY_NAME']);
            }

            $this->templating->render('admin/feed-edit', $data);
        }
        else if($_GET['tab'] == 'feed_quizzes'){
            $data['edit_feed']['id'] = intval($_REQUEST['feed_id']);
            $data['prev_item'] = $oFeeds->prevFromId($data['edit_feed']['id']);
            $data['next_item'] = $oFeeds->nextFromId($data['edit_feed']['id']);
            $data['edit_feed'] = $oFeeds->getById($data['edit_feed']['id']);
            $this->templating->render('admin/feed-quizzes', $data);
        }

    }
    public function init_settings_page()
    {
        $oQuizzes = new OBVQ_Quizzes();
        $oSettings = new OBVQ_Settings();

        $data = array(
            'templating' => $this->templating,
            'base' => plugin_dir_path(__FILE__),
            'current_menu_top' => 'settings',
            'current_tab' => 'general',
            'plugin_version' => $this->plugin_version
        );
        if(!isset($_GET['tab']) || $_GET['tab'] == 'general') {
            $data['items']['general'] = $oSettings->getByType('general');
            $data['items']['appearance'] = $oSettings->getByType('appearance');
            $data['items']['social'] = $oSettings->getByType('social');
            $data['items']['optin'] = $oSettings->getByType('optin');
            if (!empty($data['items']['optin']['mailchimp_api_key'])) {
                $data['mailchimp_lists'] = $this->ob_get_MC_lists($data['items']['optin']['mailchimp_api_key']);
            }
            $placeholder_ids = $oQuizzes->getIdsList($limit = "0, 5", $random = 1);
            foreach ($placeholder_ids as $k=>$v){
                $placeholder_ids_array[] = $placeholder_ids[$k]['id'];
            }
            if(count($placeholder_ids_array) > 0) {
                $data['placeholder_ids'] = implode(", ", $placeholder_ids_array);
            }
            else{
                $data['placeholder_ids'] = '';
            }
            $this->templating->render('admin/settings', $data);
        }
        else if($_GET['tab'] == 'appearance'){
            // moved to general
            $data['current_tab'] = 'appearance';
            $data['items'] = $oSettings->getByType('appearance');
            //$this->templating->render('admin/settings-appearance', $data);
        }
        else if($_GET['tab'] == 'social'){
            // moved to general
            $data['current_tab'] = 'social';
            $data['items'] = $oSettings->getByType('social');
            //$this->templating->render('admin/settings-social', $data);
        }
        else if($_GET['tab'] == 'optin'){
            // moved to general
            $data['current_tab'] = 'optin';
            $data['items'] = $oSettings->getByType('optin');
            $data['admin'] = $this;
            //$this->templating->render('admin/settings-optin', $data);
        }
        else if($_GET['tab'] == 'export'){
            // future feature
            $data['current_tab'] = 'export';

            $this->templating->render('admin/settings-export', $data);
        }
    }

    public function init_help_page()
    {
        $data = array(
            'templating' => $this->templating,
            'base' => plugin_dir_path(__FILE__),
            'current_menu_top' => 'help',
            'plugin_version' => $this->plugin_version
        );
        $this->templating->render('admin/help', $data);
    }
    public function ob_question_votes_callback() {

        $data = $_REQUEST;
        $oQuestions = new OBVQ_Questions();

        if($data['type'] == 'set_count'){
            $return = $oQuestions->saveQuestionVote($data['id']);
        }

        echo json_encode($return);

        wp_die();
    }
    public function ob_get_results_callback() {

        $data = $_REQUEST;
        $oQuizzes = new OBVQ_Quizzes();

        if($data['type'] == 'get_result'){
            $return = $oQuizzes->getResult($data);
        }

        $return['success'] = 1;

        echo json_encode($return);

        wp_die();
    }
    public function ob_lock_share_clicked_callback(){
        $data = $_REQUEST;

        $ip = $_SERVER['HTTP_CLIENT_IP']?$_SERVER['HTTP_CLIENT_IP']:($_SERVER['HTTP_X_FORWARDE‌​D_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR']);
        $quiz_id = intval($data['id']);
        $current_user = wp_get_current_user(); //
        $user_id = intval($current_user->ID);

        $check_row = $this->wpdb->get_row( "SELECT count(0) as total FROM `{$this->wpdb->prefix}ob_result_unlocks` WHERE 1 AND quiz_id = '{$quiz_id}' AND user_id = '{$user_id}' AND ip = '{$ip}'", ARRAY_A );
        if($check_row['total'] == 0){
            // insert row to db
            $this->wpdb->insert(
                $this->wpdb->prefix.'ob_result_unlocks',
                array(
                    'quiz_id' => intval($quiz_id),
                    'user_id' => intval($user_id),
                    'ip' => $ip,
                    'date_added' => current_time('mysql', 1)
                )
            );
            if($this->wpdb->insert_id > 0){
                $return['success'] = 1;
            }
        }

        echo json_encode($return);

        wp_die();
    }
    public function ob_save_email_callback() {

        $data = $_REQUEST;

        if($data['type'] == 'save_email'){

            $oSettings = new OBVQ_Settings();
            $MC_key  = $oSettings->getByCode('mailchimp_api_key');
            $MC_list = $oSettings->getByCode('mailchimp_list_id');

            // брать токен из настроек
            $MC_token = $MC_key['value'];
            // оттуда же лист, в который добавлять подписчика
            $MC_list_id = $MC_list['value'];
            // имейл из сабмита формы
            $email = $data['email'];
            // оттуда же имя
            $sender = $data['name'];
            $subscribed = false;

            if ($MC_token) {
                $exploded = explode(' ', $sender);

                if (isset($exploded[0]) && isset($exploded[1])) {
                    $lastname = str_replace($exploded[0] + ' ', '', $sender);
                }
                $subscribed = $this->ob_add_subscriber($email, $MC_token, $MC_list_id, isset($exploded[0]) ? $exploded[0] : $sender, isset($lastname) ? $lastname : '');
            } else {
                // нужно просто слать письмо на админ имейл. В этом письме будет то, что заполнили в форме
                $subscribed = true;
            }
        }
        $return['success'] = 1;
        $return['subscribed'] = $subscribed;

        echo json_encode($return);

        wp_die();
    }
    public function ob_feeds_callback() {

        $oFeeds = new OBVQ_Feeds();

        $query = $_REQUEST['query'];
        $page = $_REQUEST['page'];
        $orderby = $_REQUEST['orderby'];
        $ordertype = $_REQUEST['ordertype'];

        $return = $oFeeds->getAll($query, $page, $orderby, $ordertype);
        echo $return;

        wp_die();
    }
    public function ob_feed_callback() {

        $oFeeds = new OBVQ_Feeds();

        $item_id = intval($_REQUEST['id']);
        $data = $_REQUEST;
        if($data['type'] == 'save'){
            $return = $oFeeds->save($item_id, $data);
        }
        else if($data['type'] == 'delete'){
            $return = $oFeeds->delete($item_id);
        }

        echo $return;

        wp_die();
    }
    public function ob_feed_quizzes_callback() {

        $oFeeds = new OBVQ_Feeds();

        $query = $_REQUEST['query'];
        $page = $_REQUEST['page'];
        $orderby = $_REQUEST['orderby'];
        $ordertype = $_REQUEST['ordertype'];

        $return = $oFeeds->getQuizzes($query, $page, $orderby, $ordertype);
        echo $return;

        wp_die();
    }
    public function ob_quizzes_callback() {

        $oQuizzes = new OBVQ_Quizzes();

        $query = $_REQUEST['query'];
        $page = $_REQUEST['page'];
        $orderby = $_REQUEST['orderby'];
        $ordertype = $_REQUEST['ordertype'];
        $feed = $_REQUEST['feed'];

        $return = $oQuizzes->getAll($query, $page, $orderby, $ordertype, $feed);
        echo $return;

        wp_die();
    }
    public function ob_quiz_callback() {

        $oQuizzes = new OBVQ_Quizzes();

        $item_id = intval($_REQUEST['id']);
        $data = $_REQUEST;

        if($data['type'] == 'save'){
            $return = $oQuizzes->save($item_id, $data);
        }
        else if($data['type'] == 'clone'){
            $return = $oQuizzes->cloneQuiz($item_id);
        }
        else if($data['type'] == 'delete'){
            $return = $oQuizzes->delete($item_id);
        }

        echo $return;

        wp_die();
    }
    public function ob_quiz_results_callback() {

        $oResults = new OBVQ_Results();

        $query = $_REQUEST['query'];
        $page = $_REQUEST['page'];
        $orderby = $_REQUEST['orderby'];
        $ordertype = $_REQUEST['ordertype'];
        $quiz_id = $_REQUEST['quiz_id'];

        $orderby = "CAST(conditions as UNSIGNED)";
        $ordertype = "ASC";

        $return = $oResults->getAll($query, $page, $orderby, $ordertype, $quiz_id);
        echo $return;

        wp_die();
    }
    public function ob_quiz_result_callback() {

        $oResults = new OBVQ_Results();

        $item_id = intval($_REQUEST['id']);
        $data = $_REQUEST;

        if($data['type'] == 'save'){
            $return = $oResults->save($item_id, $data);
        }
        else if($data['type'] == 'delete'){
            $return = $oResults->delete($item_id);
        }

        echo $return;

        wp_die();
    }
    public function ob_quiz_results_conditions_callback (){

        $data = $_REQUEST;
        $return['success'] = 1;
        $oResults = new OBVQ_Results();
        $oResults->saveResultsConditions($data);

        echo json_encode($return);

        wp_die();
    }
    public function ob_quiz_questions_callback() {

        $oQuestions = new OBVQ_Questions();

        $query = $_REQUEST['query'];
        $page = $_REQUEST['page'];
        $orderby = $_REQUEST['orderby'];
        $ordertype = $_REQUEST['ordertype'];
        $quiz_id = $_REQUEST['quiz_id'];

        $return = $oQuestions->getAll($query, $page, $orderby, $ordertype, $quiz_id);
        echo $return;

        wp_die();
    }
    public function ob_quiz_question_callback() {

        $oQuestions = new OBVQ_Questions();

        $item_id = intval($_REQUEST['id']);
        $data = $_REQUEST;

        if($data['type'] == 'save'){
            $return = $oQuestions->save($item_id, $data);
        }
        else if($data['type'] == 'delete'){
            $return = $oQuestions->delete($item_id);
        }

        echo $return;

        wp_die();
    }
    public function ob_questions_resort_callback() {

        $oQuestions = new OBVQ_Questions();

        $data = $_REQUEST;

        $oQuestions->reorderQuestions($data);

        echo 1;

        wp_die();
    }
    public function ob_quiz_question_answers_callback() {

        $oAnswers = new OBVQ_Answers();

        $query = $_REQUEST['query'];
        $page = $_REQUEST['page'];
        $orderby = $_REQUEST['orderby'];
        $ordertype = $_REQUEST['ordertype'];
        $quiz_id = $_REQUEST['quiz_id'];
        $question_id = $_REQUEST['question_id'];

        $return = $oAnswers->getAll($query, $page, $orderby, $ordertype, $quiz_id, $question_id);
        echo $return;

        wp_die();
    }
    public function ob_quiz_question_answer_callback() {

        $oAnswers = new OBVQ_Answers();

        $item_id = intval($_REQUEST['id']);
        $data = $_REQUEST;

        if($data['type'] == 'save'){
            $return = $oAnswers->save($item_id, $data);
        }
        else if($data['type'] == 'delete'){
            $return = $oAnswers->delete($item_id);
        }

        echo $return;

        wp_die();
    }
    public function ob_quiz_settings_callback() {

        $oQuizzes = new OBVQ_Quizzes();

        $item_id = intval($_REQUEST['id']);
        $data = $_REQUEST;

        if($data['type'] == 'save'){
            $return = $oQuizzes->save_settings($item_id, $data);
        }

        echo $return;

        wp_die();
    }


    public function ob_quiz_stats_callback() {

        $oQuizzes = new OBVQ_Quizzes();

        $query = $_REQUEST['query'];
        $page = $_REQUEST['page'];
        $orderby = $_REQUEST['orderby'];
        $ordertype = $_REQUEST['ordertype'];
        $quiz_id = $_REQUEST['quiz_id'];

        if($_REQUEST['section'] == 'players'){
            $return = $oQuizzes->getStatsPlayers($quiz_id, $page, $query, $orderby, $ordertype);
        }

        echo $return;

        wp_die();
    }
    public function ob_settings_callback() {

        $oSettings = new OBVQ_Settings();
        $return = $oSettings->updateSettings($_GET['type']);
        echo $return;

        wp_die();
    }
    public function ob_stats_erase_callback() {

        $this->wpdb->query("TRUNCATE {$this->wpdb->prefix}ob_score");

        $return['success'] = 1;

        echo json_encode($return);

        wp_die();
    }
    public function ob_add_subscriber($email, $token, $list,  $first_name = '', $last_name = '', $phone = NULL, $city = NULL)
    {
        $response = array();

        if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $mc = new OBVQ_MailChimp($token);

                try {
                    $response = $mc->post("lists/" . $list . "/members", array(
                        'email_address' => sanitize_email($email),
                        'status'        => 'pending',
                        'merge_fields' => array('FNAME'=>$first_name, 'LNAME'=>$last_name)
                    ));
                } catch (Exception $e) {
                    $response['error'] = 'Error in subscription.';
                }

            }catch(Exception $e){
                $response['error'] = 'Exception during the call.';
                print_r("<!-- QUIZ ERROR \n\n\n".var_export($e, true)."\n\n\n-->");
            }
        } else {
            $response['error'] = 'Invalid email address.';
        }

        $response['fname'] = $first_name;
        $response['lname'] = $last_name;

        return $response;
    }
    public function ob_get_MC_lists($token)
    {
        $mc = new OBVQ_MailChimp($token);
        $mailLists = array();

        $response = $mc->get('lists');
        if($mc->success()) {
            foreach ($response['lists'] as $listItem) {
                array_push($mailLists, array($listItem['id'], str_replace("'", '`', str_replace('"', '`', $listItem['name']))));
            }
            return $mailLists;
        }
        else{
            array_push($mailLists, array('0', str_replace("'", '`', str_replace('"', '`', '!!Mailchimp API key is wrong!!'))));
            return $mailLists;
        }
    }
    function ob_debug_to_console($data) {
        if(is_array($data) || is_object($data))
        {
            echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
        } else {
            echo("<script>console.log('PHP: ".$data."');</script>");
        }
    }
}
