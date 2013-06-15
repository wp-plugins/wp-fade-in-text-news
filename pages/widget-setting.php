<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo WP_FadeIn_TITLE; ?></h2>
	<h3>Widget setting</h3>
    <?php
	$FadeIn_Title = get_option('FadeIn_Title');
	$FadeIn_FadeOut = get_option('FadeIn_FadeOut');
	$FadeIn_FadeIn = get_option('FadeIn_FadeIn');
	$FadeIn_Fade = get_option('FadeIn_Fade');
	
	$FadeIn_FadeStep = get_option('FadeIn_FadeStep');
	$FadeIn_FadeWait = get_option('FadeIn_FadeWait');
	//$FadeIn_bFadeOutt = get_option('FadeIn_bFadeOutt');
	$FadeIn_group = get_option('FadeIn_group');
	
	if (@$_POST['FadeIn_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('FadeIn_form_setting');
			
		$FadeIn_Title = stripslashes($_POST['FadeIn_Title']);
		$FadeIn_FadeOut = stripslashes($_POST['FadeIn_FadeOut']);
		$FadeIn_FadeIn = stripslashes($_POST['FadeIn_FadeIn']);
		$FadeIn_Fade = stripslashes($_POST['FadeIn_Fade']);
		
		$FadeIn_FadeStep = stripslashes($_POST['FadeIn_FadeStep']);
		$FadeIn_FadeWait = stripslashes($_POST['FadeIn_FadeWait']);
		//$FadeIn_bFadeOutt = stripslashes($_POST['FadeIn_bFadeOutt']);
		$FadeIn_group = stripslashes($_POST['FadeIn_group']);
		
		update_option('FadeIn_Title', $FadeIn_Title );
		update_option('FadeIn_FadeOut', $FadeIn_FadeOut );
		update_option('FadeIn_FadeIn', $FadeIn_FadeIn );
		update_option('FadeIn_Fade', $FadeIn_Fade );
		
		update_option('FadeIn_FadeStep', $FadeIn_FadeStep );
		update_option('FadeIn_FadeWait', $FadeIn_FadeWait );
		//update_option('FadeIn_bFadeOutt', $FadeIn_bFadeOutt );
		update_option('FadeIn_group', $FadeIn_group );
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-fade-in-text-news/pages/setting.js"></script>
    <form name="FadeIn_form" method="post" action="">
      
	  <label for="tag-title">Enter widget title.</label>
      <input name="FadeIn_Title" id="FadeIn_Title" type="text" value="<?php echo $FadeIn_Title; ?>" size="50" maxlength="150" />
      <p></p>
      
	  <label for="tag-width">Fade Out:</label>
      <input name="FadeIn_FadeOut" id="FadeIn_FadeOut" type="text" value="<?php echo $FadeIn_FadeOut; ?>" />
      <p>Please enter only number</p>
      
	  <label for="tag-height">Fade In:</label>
      <input name="FadeIn_FadeIn" id="FadeIn_FadeIn" type="text" value="<?php echo $FadeIn_FadeIn; ?>" />
      <p>Please enter only number</p>
	  
	  <label for="tag-height">Fade:</label>
      <input name="FadeIn_Fade" id="FadeIn_Fade" type="text" value="<?php echo $FadeIn_Fade; ?>" />
      <p>Please enter only number</p>
	  
	  <label for="tag-height">Fade Step:</label>
      <input name="FadeIn_FadeStep" id="FadeIn_FadeStep" type="text" value="<?php echo $FadeIn_FadeStep; ?>" />
      <p>Please enter only number</p>
	  
	  <label for="tag-height">Fade Wait:</label>
      <input name="FadeIn_FadeWait" id="FadeIn_FadeWait" type="text" value="<?php echo $FadeIn_FadeWait; ?>" />
      <p>Please enter only number</p>
	  
	  <label for="tag-height">Select your news group</label>
	  <select name="FadeIn_group" id="FadeIn_group">
	 	<?php
		$sSql = "SELECT distinct(FadeIn_group) as FadeIn_group FROM `".WP_FadeIn_TABLE."` order by FadeIn_group";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		if(count($myDistinctData) > 0)
		{
			foreach ($myDistinctData as $DistinctData)
			{
				$arrDistinctData[$i]["FadeIn_group"] = strtoupper($DistinctData['FadeIn_group']);
				$i = $i+1;
			}
			foreach ($arrDistinctData as $arrDistinct)
			{
				if(strtoupper($FadeIn_group) == strtoupper($arrDistinct["FadeIn_group"]) ) 
				{ 
					$selected = "selected='selected'"; 
				}
				?>
				<option value='<?php echo $arrDistinct["FadeIn_group"]; ?>' <?php echo $selected; ?>><?php echo strtoupper($arrDistinct["FadeIn_group"]); ?></option>
				<?php
				$selected = "";
			}
		}
		else
		{
			?><option value='widget'>Widget</option><?php
		}
		?>
      </select>
      <p>Select your group name to display the news for widget.</p>
	  
	  <div style="height:10px;"></div>
	  <input name="FadeIn_submit" id="FadeIn_submit" class="button-primary" value="Submit" type="submit" />
	  <input name="publish" lang="publish" class="button-primary" onclick="_FadeIn_redirect()" value="Cancel" type="button" />
      <input name="Help" lang="publish" class="button-primary" onclick="_FadeIn_help()" value="Help" type="button" />
	  <?php wp_nonce_field('FadeIn_form_setting'); ?>
    </form>
  </div>
  <br /><p class="description"><?php echo WP_FadeIn_LINK; ?></p>
</div>
