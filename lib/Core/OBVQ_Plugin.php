<?php

namespace OBVQ_WpPluginAutoload\Core;

use OBVQ_WpPluginAutoload\Admin\OBVQ_Admin;
use OBVQ_WpPluginAutoload\Frontend\OBVQ_Frontend;


/**
 * The core plugin class.
 */
class OBVQ_Plugin
{
    /**
     * The plugin's unique id.
     *
     * @var string
     */
    private $id;

    /**
     * @var OBVQ_Loader
     */
    private $loader;

    public function __construct($id, $version)
    {
        $this->id = $id;

        $this->loader = new OBVQ_Loader();
        $this->loader->add_action('plugins_loaded', $this, 'load_plugin_textdomain');

        $assets = new OBVQ_Assets($id, $version, $this->loader, is_admin());
        $templating = new OBVQ_Templating();

        if (is_admin()) {
            new OBVQ_Admin($this->loader, $assets, $templating);
        } else {
            new OBVQ_Frontend($this->loader, $assets, $templating);

        }
    }

    /**
     * Run the plugin.
     */
    public function run()
    {
        $this->loader->register_hooks();
        #$this->load_plugin_textdomain();
    }

    /**
     * Load internationalization files.
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            $this->id,
            $deprecated = false,
            $this->id.'/languages/'
        );
    }
}
