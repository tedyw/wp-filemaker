<?php
/*
Plugin Name: FileMaker
Description: Connects to a FileMaker Server and utilizes the REST API.
Author: Tedy Warsitha
Version: 0.1
Text Domain: filemaker
Text Path: languages
 */

defined( 'ABSPATH' ) OR exit;
include 'autoload.php';

call_user_func(
    function () {

        $plugin_url = plugin_dir_url(__FILE__);
        $plugin_directory_name = pathinfo(plugin_basename(__FILE__), PATHINFO_DIRNAME);

        $integration = \FileMaker\Integration::get_instance($plugin_url, $plugin_directory_name, __FILE__);

        $integration->after_init(function () use ($integration) {
            global $filemaker;
            $filemaker = $integration->get_filemaker();
        });

        $integration->init();
    }
);
