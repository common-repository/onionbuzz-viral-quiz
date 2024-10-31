<?php
/*
 * @wordpress-plugin
 * Plugin Name:       OnionBuzz Lite
 * Plugin URI:        http://onionbuzz.com/
 * Description:       OnionBuzz Viral Quiz Maker is a versatile tool for creating quizzes, ranked lists, flip cards and other viral content. This plugin allows any WordPress fan to make lots of colorful and exciting quizzes to attract new visitors for the site and keep them interested in the project.
 * Version:           1.0.7
 * Author:            Looks Awesome
 * Author URI:        https://looks-awesome.com/
 * License:           GPLv3
 * Text Domain:       onionbuzz-viral-quiz
 * Domain Path:       /languages
 */

if (!defined('WPINC')) {
    die; // Forbid direct execution
}

require_once __DIR__.'/autoload.php';

register_activation_hook(__FILE__, array('OBVQ_WpPluginAutoload\OBVQ_Lifecycle', 'activate'));
register_deactivation_hook(__FILE__, array('OBVQ_WpPluginAutoload\OBVQ_Lifecycle', 'deactivate'));

define( 'OBVQ_PLUGIN_URL', plugin_dir_path(__FILE__ ) );
define( 'OBVQ_PLUGIN_URL_HTTP', plugin_dir_url(__FILE__ ) );
define( 'OBVQ_PLUGIN_BASENAME', plugin_basename(__FILE__));

$OBVQ_oConfig = new OBVQ_WpPluginAutoload\Core\OBVQ_Config();
$OBVQ_configs = $OBVQ_oConfig->get();

$OBVQ_wpPluginId = $OBVQ_configs['onionbuzz_info']['OB_PLUGIN_ID'];
$OBVQ_wpPluginVersion = $OBVQ_configs['onionbuzz_info']['OB_PLUGIN_V'];

define( 'OBVQ_PLUGIN_TEXTDOMAIN', $OBVQ_configs['onionbuzz_info']['OB_TEXTDOMAIN'] );

$OBVQ_WpPlugin = new OBVQ_WpPluginAutoload\Core\OBVQ_Plugin($OBVQ_wpPluginId, $OBVQ_wpPluginVersion);
$OBVQ_WpPlugin->run();
