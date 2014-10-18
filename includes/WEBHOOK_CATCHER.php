<?php

/**

  * This is the WebHook Catcher main class. Here different methods are defined

  * such as API call, card process, customer registration etc.

  */



class WEBHOOK_CATCHER 
{

	/**

    * Proceed only if Curl is installed

    */

    public function __construct ($debug = false) { 

        if (!function_exists('curl_version')) {

            wp_die('Curl not installed. WebHook Catcher can not function.');

        }

    }    
	
	public static function init(){

        ob_start(); 

        add_action('action', array(__CLASS__, 'add_actions'));

        do_action('action');
	
	  if(!session_id()) {
	
	   session_start();
	
	  }
	
    }
 
  //
  public static function add_actions(){
	  
      add_action('admin_menu', array(__CLASS__, 'add_interface_items'));
	  add_action('wp_head', array(__CLASS__, 'detectUrlBySeriesId'));

  }
 
 // detect url

    public static function detectUrlBySeriesId(){

       	  //$wehookCatcherObject = new WEBHOOK_CATCHER;
		  
		  //$currentUrl   = $wehookCatcherObject->currentPageURL();
		 
		  $dbObj = new WEBHOOK_CATCHER_DB;	
		  
		  $query = $_SERVER['QUERY_STRING']; // get the entire query string
		  $queryString = parse_str($query); // parse the string to its parts
		  $contact = $_REQUEST['contact'];
		  $contactId = $contact['id'];
		  
		  if(isset($_REQUEST['seriesid']) and !empty($_REQUEST['seriesid']) and is_numeric($_REQUEST['seriesid']) and !empty($contactId)){
			  
			  $rs = $dbObj->getWebHookItemBySeriesId($_REQUEST['seriesid']);
			  
			  $category = $rs[0]->category;
			  $postTitle = $rs[0]->post_title;
			  $duplicate = $rs[0]->is_duplicate;
			  $postUrl = $rs[0]->post_url;
			  
			  if($duplicate == 'Yes'){
				$postargs = "duplicate=true&category=".$category."&post_title=".$postTitle."&Id=".$contactId;
				} else {
					$postargs = "category=".$category."&post_title=".$postTitle."&Id=".$contactId;
				}
			   $url = $postUrl."/?".$postargs;
			  
			  $session = curl_init($url);
			  header("Accept: application/json");
			  //curl_setopt($session, CURLOPT_HEADER, $header);
			  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			  $response = curl_exec($session);
			  echo $response;	
			  exit;
		  }else if(isset($_REQUEST['seriesid']) and !empty($_REQUEST['seriesid']) and empty($contactId)){
			  echo "Invalid url";
			  exit;
		  }
	      	
    }
	
	
	 // adding menu to admin

    public static function add_interface_items(){

        add_menu_page(__('WEBHOOK CATCHER'), __('Manage Webhook'), 'manage_options','webhook_catcher', array(__CLASS__, 'webhookSettings'));

    }
	
	public function webhookSettings()
	{
		$dbObj = new WEBHOOK_CATCHER_DB;	
		
		if(isset($_POST['addWebhookItem'])) {
			$dbObj->addNewWebHookItem($_POST);
		}
		
		if(isset($_POST['editWebhookItem'])) {
			$dbObj->editWebHookItem($_POST);
			header("location:".get_admin_url()."admin.php?page=webhook_catcher");
			exit;
		}
		
		
		if(isset($_GET['action']) and !empty($_GET['recId'])){
			if($_GET['action']=="del"){
				$delRecord = $dbObj->delWebHookItem($_GET['recId']);
				header("location:".get_admin_url()."admin.php?page=webhook_catcher");
				exit;
			}else if($_GET['action']=="edit"){
				$getRs = $dbObj->getWebHookItemById($_GET['recId']);
				include WEBHOOK_CATCHER_DIR_PATH.'view/admin/edit_webhook_item.php';
				exit;
			}
		}
		
		
		$rs = $dbObj->getAllWebhookListings();
		include WEBHOOK_CATCHER_DIR_PATH.'view/admin/manage_webhook.php';
	}
	
	public function activatePlugin() {

        global $wpdb;

        // Call DB class object

        $webHookDbObject    = new WEBHOOK_CATCHER_DB;

        $webhookCatcher         = $wpdb->prefix . "webhook_catcher";
      
        if (!empty($wpdb->charset))
		
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

        

        $sql = "CREATE TABLE IF NOT EXISTS ".$webhookCatcher." (

                wc_id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			
				series_id bigint NOT NULL,
			
				category text NOT NULL,
			
				post_title text NOT NULL,
			
				is_duplicate text NOT NULL, 
				
				post_url text NOT NULL
			
			  ) {$charset_collate};";
			
        dbDelta($sql);

    }
	
	  public function currentPageURL() {
	
		$pageURL = 'http';
		
		if ($_SERVER["HTTPS"] == "on") {
		
		 $pageURL .= "s";
		
		}
		
		 $pageURL .= "://";
		
		if ($_SERVER["SERVER_PORT"] != "80") {
		
		 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		
		} else {
		
		 $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		}
		
	  return $pageURL; 
	
	 }
	 
	 public function deactivateCreate() {
		 
	  global $wpdb;
	
	  $webhook_catcher         = $wpdb->prefix . "webhook_catcher";
	
	  $wpdb->query("DROP TABLE IF EXISTS $webhook_catcher");
	
    }
}