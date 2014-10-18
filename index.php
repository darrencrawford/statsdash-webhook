<?php 
/*
Plugin Name: WEBHOOK CATCHER

Version: 0.1

Author: logicalcoders.com

Description: Wordpress plugin for webhook catcher and HTTP POST
*/

//error_reporting(0);

// WebHook Catcher Plugin paths

define('WEBHOOK_CATCHER_DIR_PATH', plugin_dir_path(__FILE__));

define('WEBHOOK_CATCHER_URL_PATH', plugins_url('', __FILE__).'/');

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

// WebHook Catcher Database class file

require WEBHOOK_CATCHER_DIR_PATH.'includes/WEBHOOK_CATCHER_DB.php';

// WebHook Catcher main class file

require WEBHOOK_CATCHER_DIR_PATH.'includes/WEBHOOK_CATCHER.php';

$webHookCatcherObject 		= new WEBHOOK_CATCHER;

$webHookDbObject 	= new WEBHOOK_CATCHER_DB;

$webHookCatcherObject->init();

register_activation_hook( __FILE__, 			array($webHookCatcherObject,  'activatePlugin' ));

register_deactivation_hook( __FILE__, 			array($webHookCatcherObject,  'deactivatePlugin' ));