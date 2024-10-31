<?php
namespace OBVQ_WpPluginAutoload\Core;

class OBVQ_Config{

    public $config = array();

    public function __construct()
    {
        $this->config = parse_ini_file(OBVQ_PLUGIN_URL."config.ini", true);
    }
    public function saveWPoption ($option_name, $option_value){

    }
    public function getWPoption ($option_name){

    }
    public function get(){
        #echo '<pre>';
        #print_r($this->config);
        #echo '</pre>';
        $return = $this->config;

        $oSettings = new OBVQ_Settings();

        $get_vals = $oSettings->getByCode('obla_post_type_slug');
        $return['onionbuzz_posttypes']['OB_POST_TYPE_SLUG'] = $get_vals['value'];

        $get_vals = $oSettings->getByCode('obla_post_type_text');
        $return['onionbuzz_posttypes']['OB_POST_TYPE_BREADCRUMB'] = $get_vals['value'];

        return $return;
    }

}