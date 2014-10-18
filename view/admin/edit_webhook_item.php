<?php
$category = $getRs[0]->category;
$postTitle = $getRs[0]->post_title;
if(strpos($category, "+") !== false)
{
   $category = str_replace("+", " ", $category);
}
if(strpos($postTitle, "+") !== false)
{
   $postTitle = str_replace("+", " ", $postTitle);
}
?>
<form method="POST" action="" name="formManageWebhook" id="formManageWebhook">
<h3>Edit WebHook Catcher</h3>
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td width="22%">Series ID</td>
    <td width="78%"><input type="text" name="series_id" id="series_id" required value="<?php echo $getRs[0]->series_id; ?>" /></td>
  </tr>
  <tr>
    <td>Category</td>
    <td><input type="text" name="category" id="category" required value="<?php echo $category; ?>" /></td>
  </tr>
  <tr>
    <td>Post Title</td>
    <td><input type="text" name="post_title" id="post_title" required value="<?php echo $postTitle; ?>" /></td>
  </tr>
  <tr>
    <td>Duplicate</td>
    <td><select name="is_duplicate" id="is_duplicate" required>
      <option <?php if($getRs[0]->is_duplicate=="Yes"){ ?> selected="selected" <?php } ?> value="Yes">Allowed</option>
      <option <?php if($getRs[0]->is_duplicate=="No"){ ?> selected="selected" <?php } ?> value="No">Not Allowed</option>
    </select></td>
  </tr>
  <tr>
    <td>Post URL</td>
    <td><input type="text" name="post_url" id="post_url" required value="<?php echo $getRs[0]->post_url; ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <input type="hidden" name="wc_id" id="wc_id" value="<?php echo $getRs[0]->wc_id; ?>" />
    <input type="submit" name="editWebhookItem" id="editWebhookItem" value="Edit Item" /><input type="button" onclick="window.location='<?php echo get_admin_url()."admin.php?page=webhook_catcher"; ?>'" value="Cancel" /></td>
  </tr>
</table>
</form>
