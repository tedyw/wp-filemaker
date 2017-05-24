<?php

namespace FileMaker;

class Integration
{

    private $filemaker, $after_init_callback, $plugin_url, $plugin_directory_name, $plugin_file_path;

    /**
     * Integration constructor.
     * @param $plugin_url
     * @param $plugin_directory_name
     * @param $plugin_file_path
     */
    function __construct($plugin_url, $plugin_directory_name, $plugin_file_path)
    {
        $this->plugin_url = $plugin_url;
        $this->plugin_directory_name = $plugin_directory_name;
        $this->$plugin_file_path = $plugin_file_path;
    }

    /**
     * Returns the singleton instance of this class.
     * @param $plugin_url
     * @param $plugin_directory_name
     * @param $plugin_file_path
     * @return null|static
     */
    public static function get_instance($plugin_url, $plugin_directory_name, $plugin_file_path)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static($plugin_url, $plugin_directory_name, $plugin_file_path);
        }

        return $instance;
    }

    /**
     * Init action hook callback
     */
    public function init_hook()
    {

        $this->filemaker = new FileMaker();

        if (is_callable($this->after_init_callback)) {
            call_user_func($this->after_init_callback);
        }
    }

    /**
     * Registers hooks essential to the plugin.
     */
    public function init()
    {
        add_action("init", array(&$this, 'init_hook'));
    }

    /**
     * Stores callback function to be performed after init.
     * @param $callback
     */
    public function after_init($callback)
    {
        $this->after_init_callback = $callback;
    }
}