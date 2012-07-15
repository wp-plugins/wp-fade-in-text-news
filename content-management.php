<!--
/**
 *     WP fade in text news
 *     Copyright (C) 2012  www.gopipulse.com
 *     http://www.gopipulse.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
-->

<div class="wrap">
  <?php
  	global $wpdb;
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=wp-fade-in-text-news/content-management.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['FadeIn_text']) <>"")
    {
			if($_POST['FadeIn_id'] == "" )
			{
					$sql = "insert into ".WP_FadeIn_TABLE.""
					. " set `FadeIn_text` = '" . mysql_real_escape_string(trim($_POST['FadeIn_text']))
					. "', `FadeIn_link` = '" . $_POST['FadeIn_link']
					. "', `FadeIn_order` = '" . $_POST['FadeIn_order']
					. "', `FadeIn_status` = '" . $_POST['FadeIn_status']
					. "', `FadeIn_group` = '" . $_POST['FadeIn_group']
					. "'";	
			}
			else
			{
					$sql = "update ".WP_FadeIn_TABLE.""
					. " set `FadeIn_text` = '" . mysql_real_escape_string(trim($_POST['FadeIn_text']))
					. "', `FadeIn_link` = '" . $_POST['FadeIn_link']
					. "', `FadeIn_order` = '" . $_POST['FadeIn_order']
					. "', `FadeIn_status` = '" . $_POST['FadeIn_status']
					. "', `FadeIn_group` = '" . $_POST['FadeIn_group']
					. "' where `FadeIn_id` = '" . $_POST['FadeIn_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_FadeIn_TABLE." where FadeIn_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_FadeIn_TABLE." where FadeIn_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $FadeIn_id_x = htmlspecialchars(stripslashes($data->FadeIn_id)); 
        if ( !empty($data) ) $FadeIn_text_x = htmlspecialchars(stripslashes($data->FadeIn_text));
		if ( !empty($data) ) $FadeIn_link_x = htmlspecialchars(stripslashes($data->FadeIn_link));
        if ( !empty($data) ) $FadeIn_status_x = htmlspecialchars(stripslashes($data->FadeIn_status));
		if ( !empty($data) ) $FadeIn_group_x = htmlspecialchars(stripslashes($data->FadeIn_group));
		if ( !empty($data) ) $FadeIn_order_x = htmlspecialchars(stripslashes($data->FadeIn_order));
        $submittext = "Update Message";
    }
    ?>
  <h2>Fade in text news</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-fade-in-text-news/setting.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-fade-in-text-news/noenter.js"></script>
  <form name="FadeIn_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return FadeIn_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="3" align="left" valign="middle">Enter the message:</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle">
        <textarea name="FadeIn_text" id="FadeIn_text" cols="120" rows="5"><?php echo @$FadeIn_text_x; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle">Enter Link:</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="middle"><input name="FadeIn_link" type="text" id="FadeIn_link" value="<?php echo @$FadeIn_link_x; ?>" size="150" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Group Name:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="12%" align="left" valign="middle"><select name="FadeIn_status" id="FadeIn_status">
            <option value="">Select</option>
            <option value='YES' <?php if(@$FadeIn_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if(@$FadeIn_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>
        </td>
        <td width="15%" align="left" valign="middle"><input name="FadeIn_group" type="text" id="FadeIn_group" value="<?php echo @$FadeIn_group_x; ?>" size="20" maxlength="75" /></td>
        <td width="73%" align="left" valign="middle"><input name="FadeIn_order" type="text" id="FadeIn_order" size="10" value="<?php echo @$FadeIn_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="3" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="_FadeIn_redirect()" value="Cancel" type="button" />
              </td>
              <td width="50%" align="right">
			  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=wp-fade-in-text-news/content-management.php'" value="Go to - Text Management" type="button" />
        	  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=wp-fade-in-text-news/wp-fade-in-text-news.php'" value="Go to - Fadein Setting" type="button" />
			  <input name="Help1" lang="publish" class="button-primary" onclick="_FadeIn_help()" value="Help" type="button" />
			  </td>
            </tr>
          </table></td>
      </tr>
      <input name="FadeIn_id" id="FadeIn_id" type="hidden" value="<?php echo @$FadeIn_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_FadeIn_TABLE." order by FadeIn_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="FadeIn_Display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="3%" align="left" scope="col">ID
              </td>
            <th width="65%" align="left" scope="col">Message
              </td>
            <th width="11%" align="left" scope="col">Group            
            <th width="6%" align="left" scope="col"> Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="8%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->FadeIn_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->FadeIn_id)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->FadeIn_text)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->FadeIn_group)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->FadeIn_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->FadeIn_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=wp-fade-in-text-news/content-management.php&DID=<?php echo($data->FadeIn_id); ?>">Edit</a> &nbsp; <a onClick="javascript:_FadeIn_delete('<?php echo($data->FadeIn_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table width="100%">
    <tr>
      <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=wp-fade-in-text-news/content-management.php'" value="Go to - Text Management" type="button" />
        <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=wp-fade-in-text-news/wp-fade-in-text-news.php'" value="Go to - Fadein Setting" type="button" />
		<input name="Help" lang="publish" class="button-primary" onclick="_FadeIn_help()" value="Help" type="button" />
      </td>
    </tr>
  </table>
  <?php include_once("help.php"); ?>
</div>
