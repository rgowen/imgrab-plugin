<?php

/**
 * @package imgrabPlugin
 */

/*
Plugin Name: imgrab
Plugin URI: none
Description: A WordPress plugin to add media files to library from the web.
Version: 2018.1
Author: Ryan Gowen
Author URI: http://github.com/rgowen/
License: GPLv2
*/
 
defined('ABSPATH') or die('Get out');

class ImgrabPlugin
{
    public $plugin;
    function __construct()
    {
        $plugin = plugin_basename(__FILE__);
    }
    function register()
    {
        add_action('admin_menu', array( $this, 'add_admin_pages'));
        add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
    }
    public function settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=imgrab_plugin">Settings</a>';
        array_push($links, $settings_link);
    }
    public function add_admin_pages() 
    {
        add_menu_page( 'imgrabPlugin', 'imgrab', 'manage_options', 'imgrab_plugin', array($this, 'admin_index'), 'dashicons-images-alt', 110 );
    }
    public function admin_index()
    {
        require_once plugin_dir_path(__FILE__).'templates/admin.php';
    }
}

if( class_exists('imgrabPlugin'))
{
    $imgrabPlugin = new imgrabPlugin('initialized');
    $imgrabPlugin->register();
}

//activate
register_activation_hook( __FILE__, array($imgrabPlugin, 'activate'));
//deactive
register_deactivation_hook(__FILE__, array($imgrabPlugin, 'deactivate'));
