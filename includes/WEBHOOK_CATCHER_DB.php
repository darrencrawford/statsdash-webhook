<?php

/**

 * This is the DB class that is used to handle the DB quries

 */

class WEBHOOK_CATCHER_DB 
{
	
	public function getAllWebhookListings()
	{
		global $wpdb;
		$webhook_catcher = $wpdb->prefix."webhook_catcher";
		
		$rs = $wpdb->get_results( "SELECT * FROM ". $webhook_catcher );
		return $rs;
	}
	
	//get webhooks by limit
	public function getWebHookByLimit($startResults, $resultsPerPage)
	{
		global $wpdb;
		$webhook_catcher = $wpdb->prefix."webhook_catcher";			
		
		$rsPerPage = $wpdb->get_results( "SELECT * FROM ". $webhook_catcher." WHERE `wc_id` > 0 LIMIT $startResults, $resultsPerPage " );
		
		return $rsPerPage;
	}
	
	public function addNewWebHookItem($arr) {
		global $wpdb;
		$webhook_catcher = $wpdb->prefix."webhook_catcher";
		
		if(!empty($arr)) {
			foreach($arr as $key => $val) {
				$$key=$val;	
			}
		}
		if(strpos($category, " ") !== false)
		{
		   $category = str_replace(" ", "+", $category);
		}
		if(strpos($post_title, " ") !== false)
		{
		   $post_title = str_replace(" ", "+", $post_title);
		}
		$insertWebhook = $wpdb->insert( 
								$webhook_catcher, 
								array( 
									'series_id' => $series_id, 
									'category' => $category, 
									'post_title' => $post_title, 
									'is_duplicate' => $is_duplicate, 
									'post_url' => $post_url 
								)
							);
	}
	
	
	public function editWebHookItem($arr) {
		global $wpdb;
		$webhook_catcher = $wpdb->prefix."webhook_catcher";
		
		if(!empty($arr)) {
			foreach($arr as $key => $val) {
				$$key=$val;	
			}
		}
		if(strpos($category, " ") !== false)
		{
		   $category = str_replace(" ", "+", $category);
		}
		if(strpos($post_title, " ") !== false)
		{
		   $post_title = str_replace(" ", "+", $post_title);
		}
		if(!empty($wc_id)){
			$wpdb->update( 
					$webhook_catcher, 
					array( 
						'series_id' => $series_id, 
						'category' => $category, 
						'post_title' => $post_title, 
						'is_duplicate' => $is_duplicate, 
						'post_url' => $post_url 
					), 
					array( 'wc_id' => $wc_id )
				);
		}
	}
	
	public function delWebHookItem($itemId)
	{
		global $wpdb;
		$webhook_catcher = $wpdb->prefix."webhook_catcher";
		
		if(!empty($itemId)){
			$wpdb->delete( $webhook_catcher, array( 'wc_id' => $itemId ) );
		}
	}
	
	public function getWebHookItemById($itemId)
	{
		global $wpdb;
		$webhook_catcher = $wpdb->prefix."webhook_catcher";
		
		if(!empty($itemId)){
			$rs = $wpdb->get_results( "SELECT * FROM ". $webhook_catcher. " WHERE `wc_id` = '".$itemId."'" );
		}
		return $rs;
	}
	
	public function getWebHookItemBySeriesId($seriesId)
	{
		global $wpdb;
		$webhook_catcher = $wpdb->prefix."webhook_catcher";
		
		if(!empty($seriesId)){
			$rs = $wpdb->get_results( "SELECT * FROM ". $webhook_catcher. " WHERE `series_id` = '".$seriesId."'" );
		}
		return $rs;
	}
	
}
