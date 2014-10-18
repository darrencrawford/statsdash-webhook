<form method="POST" action="" name="formManageWebhook" id="formManageWebhook" style="display:none;">
<h3>Add New WebHook Catcher</h3>
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td width="22%">Series ID</td>
    <td width="78%"><input type="text" name="series_id" id="series_id" required /></td>
  </tr>
  <tr>
    <td>Category</td>
    <td><input type="text" name="category" id="category" required /></td>
  </tr>
  <tr>
    <td>Post Title</td>
    <td><input type="text" name="post_title" id="post_title" required /></td>
  </tr>
  <tr>
    <td>Duplicate</td>
    <td><select name="is_duplicate" id="is_duplicate" required>
      <option value="Yes">Allowed</option>
      <option value="No">Not Allowed</option>
    </select></td>
  </tr>
  <tr>
    <td>Post URL</td>
    <td><input type="text" name="post_url" id="post_url" required /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="addWebhookItem" id="addWebhookItem" value="Add Item" /><input type="button" onclick="jQuery('#formManageWebhook').hide();jQuery('#showForm').show();" value="Close" /></td>
  </tr>
</table>
</form>
<br />
<input type="button" onclick="jQuery('#formManageWebhook').show(); jQuery('#showForm').hide();" id="showForm" class="add-new-h2" value="Add New Item" />

<style>
	.pagination_div{
		margin-top: 15px;
		text-align: center;
	}
</style>

<h3>WebHook Catcher Listings</h3>
<?php if(isset($_POST['addWebhookItem'])) { ?>
    <div class="updated fade">
       <p><strong style="color:green;"><?php _e(' Record Added Successfully', 'crowdfunding_settings'); ?></strong></p>
    </div>
<?php } else if(isset($_POST['editWebhookItem'])) { ?>
	<div class="updated fade">
       <p><strong style="color:green;"><?php _e(' Record Updated Successfully', 'crowdfunding_settings'); ?></strong></p>
    </div>
<?php } ?>
<br style="clear:both;"/>
<div>
<table border="0" cellpadding="3" class="wp-list-table widefat fixed pages" style="width:98%;">
  <thead>
      <tr>
        <th align="left">Series ID</th>
        <th align="left">Category</th>
        <th align="left">Post Title</th>
        <th align="left">Is Duplicate</th>
        <th align="left">Post URL</th>
      </tr>
  </thead>
  <tfoot>
      <tr>
        <th align="left">Series ID</th>
        <th align="left">Category</th>
        <th align="left">Post Title</th>
        <th align="left">Is Duplicate</th>
        <th align="left">Post URL</th>
      </tr>
  </tfoot>
  <?php if(!empty($rs)) { 
  		$numberOfRows = count($rs);
		$page_pagi = $_GET['pageno'];
		if ($page_pagi < 1) $page_pagi = 1;
		$resultsPerPage = 30;
		$startResults = ($page_pagi - 1) * $resultsPerPage;
		$cnt = $startResults;
		$totalPages = ceil($numberOfRows / $resultsPerPage);
		
		// get by limit
		$dbObj = new WEBHOOK_CATCHER_DB;
		$rsPerPage = $dbObj->getWebHookByLimit($startResults, $resultsPerPage);			
  ?>
    <?php
		if(!empty($rsPerPage)){ 
			foreach($rsPerPage as $key => $val) {
				if($key % 2 == 0){
					$class = 'alternate';
				}else{
					$class = '';
				} 
			 $delUrl = get_admin_url()."admin.php?page=webhook_catcher&action=del&recId=".$val->wc_id;
			 $editUrl = get_admin_url()."admin.php?page=webhook_catcher&action=edit&recId=".$val->wc_id;
		?>
		  <tr class="<?php echo $class; ?>">
			<td class="manage-column column-role">&nbsp;<?php echo $val->series_id; ?>
				 <br>
				 <div class="row-actions">
					 <span class="edit"><a href="<?php echo $editUrl; ?>">Edit</a></span> | 
					 <span class="delete"><a onClick="if(confirm('Are you sure you want to delete this item')){window.location='<?php echo $delUrl; ?>'}" href="javascript:;">Delete</a></span>
				</div>
			</td>
			<td class="manage-column column-role">&nbsp;<?php echo $val->category; ?></td>
			<td class="manage-column column-role">&nbsp;<?php echo $val->post_title; ?></td>
			<td class="manage-column column-role">&nbsp;<?php echo $val->is_duplicate; ?></td>
			<td class="manage-column column-role">&nbsp;<?php echo $val->post_url; ?></td>
		  </tr>
      <?php
		}
	  } ?>
  <?php }else{ ?>
  	  <tr>
      	<td colspan="5">No Record Found</td>
      </tr>
  <?php } ?>
</table>
	
    <?php
		 /************Pagination Links Display************/
  
	
		echo '<div class="pagination_div">';
		if($totalPages > 1){
			if($page_pagi > 1)
				echo '<a class="prev_page" href="?page=webhook_catcher&pageno='.($page_pagi - 1).'">&lt; Prev</a>&nbsp';
			for($i = 1; $i <= $totalPages; $i++){
				if($i == $page_pagi)
					echo '<strong class="selected_page">'.$i.'</strong>&nbsp';
				else
					echo '<a class="off_pages" href="?page=webhook_catcher&pageno='.$i.'">'.$i.'</a>&nbsp';
			}
			if ($page_pagi < $totalPages)
				echo '<a class="nxt_page" href="?page=webhook_catcher&pageno='.($page_pagi + 1).'">Next &gt;</a>&nbsp;';
		}
		echo '</div>';  
		
		
 		?>	  


</div>