<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$FadeIn_errors = array();
$FadeIn_success = '';
$FadeIn_error_found = FALSE;

// Preset the form fields
$form = array(
	'FadeIn_text' => '',
	'FadeIn_status' => '',
	'FadeIn_group' => '',
	'FadeIn_link' => '',
	'FadeIn_order' => '',
	'FadeIn_date' => ''
);

// Form submitted, check the data
if (isset($_POST['FadeIn_form_submit']) && $_POST['FadeIn_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('FadeIn_form_add');
	
	$form['FadeIn_text'] = isset($_POST['FadeIn_text']) ? $_POST['FadeIn_text'] : '';
	if ($form['FadeIn_text'] == '')
	{
		$FadeIn_errors[] = __('Please enter the popup message.', 'FadeIn');
		$FadeIn_error_found = TRUE;
	}

	$form['FadeIn_link'] = isset($_POST['FadeIn_link']) ? $_POST['FadeIn_link'] : '';
	$form['FadeIn_order'] = isset($_POST['FadeIn_order']) ? $_POST['FadeIn_order'] : '';
	$form['FadeIn_status'] = isset($_POST['FadeIn_status']) ? $_POST['FadeIn_status'] : '';
	$form['FadeIn_group'] = isset($_POST['FadeIn_group']) ? $_POST['FadeIn_group'] : '';
	$form['FadeIn_date'] = isset($_POST['FadeIn_date']) ? $_POST['FadeIn_date'] : '';

	//	No errors found, we can add this Group to the table
	if ($FadeIn_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_FadeIn_TABLE."`
			(`FadeIn_text`,`FadeIn_link`, `FadeIn_order`, `FadeIn_status`, `FadeIn_group`, `FadeIn_date`)
			VALUES(%s, %s, %d, %s, %s, %s)",
			array($form['FadeIn_text'], $form['FadeIn_link'], $form['FadeIn_order'], $form['FadeIn_status'], $form['FadeIn_group'], $form['FadeIn_date'])
		);
		$wpdb->query($sql);
		
		$FadeIn_success = __('Details was successfully added.', 'FadeIn');
		
		// Reset the form fields
		$form = array(
			'FadeIn_text' => '',
			'FadeIn_status' => '',
			'FadeIn_group' => '',
			'FadeIn_link' => '',
			'FadeIn_order' => '',
			'FadeIn_date' => ''
		);
	}
}

if ($FadeIn_error_found == TRUE && isset($FadeIn_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $FadeIn_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($FadeIn_error_found == FALSE && strlen($FadeIn_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $FadeIn_success; ?> <a href="<?php echo FADEIN_ADMIN_URL; ?>">Click here</a> to view the details</strong></p>
	  </div>
	  <?php
	}
?>
<script language="javascript" src="<?php echo FADEIN_PLUGIN_URL; ?>/pages/setting.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo FADEIN_PLUGIN_URL; ?>/pages/noenter.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Fade in text news', 'FadeIn'); ?></h2>
	<form name="FadeIn_form" method="post" action="#" onsubmit="return FadeIn_submit()"  >
      <h3><?php _e('Add news', 'FadeIn'); ?></h3>
      <label for="tag-image"><?php _e('Enter the news/message', 'FadeIn'); ?></label>
      <textarea name="FadeIn_text" id="FadeIn_text" cols="100" rows="5"></textarea>
      <p><?php _e('We can enter HTML content in this textarea', 'FadeIn'); ?></p>
	  <label for="tag-link"><?php _e('Enter target link', 'FadeIn'); ?></label>
      <input name="FadeIn_link" type="text" id="FadeIn_link" value="" size="102" maxlength="1024" />
      <p><?php _e('When someone clicks on the content, where do you want to send them', 'FadeIn'); ?></p>
      <label for="tag-select-gallery-group"><?php _e('Select fadein group', 'FadeIn'); ?></label>
      <select name="FadeIn_group" id="FadeIn_group">
	  <option value=''>Select</option>
	  <?php
		$sSql = "SELECT distinct(FadeIn_group) as FadeIn_group FROM `".WP_FadeIn_TABLE."` order by FadeIn_group";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["FadeIn_group"] = strtoupper($DistinctData['FadeIn_group']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["FadeIn_group"] = "GROUP" . $j;
		}
		$arrDistinctData[$j+1]["FadeIn_group"] = "WIDGET";
		$arrDistinctData[$j+2]["FadeIn_group"] = "SAMPLE";
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo $arrDistinct["FadeIn_group"]; ?>'><?php echo $arrDistinct["FadeIn_group"]; ?></option><?php
		}
		?>
      </select>
      <p><?php _e('This is to group the message. Select your group from the list', 'FadeIn'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'FadeIn'); ?></label>
      <select name="FadeIn_status" id="FadeIn_status">
        <option value=''>Select</option>
		<option value='YES' selected="selected">Yes</option>
        <option value='NO'>No</option>
      </select>
	  <p><?php _e('Do you want to show this message?', 'FadeIn'); ?></p>
	  <label for="tag-link"><?php _e('Display order', 'FadeIn'); ?></label>
      <input name="FadeIn_order" type="text" id="FadeIn_order" value="" maxlength="2" />
      <p><?php _e('Please enter news display order in this box. Only number', 'FadeIn'); ?></p>
	  
	  <label for="tag-date"><?php _e('Expiration date', 'FadeIn'); ?></label>
      <input name="FadeIn_date" type="text" id="FadeIn_date" value="9999-12-30" maxlength="10" />
      <p><?php _e('Please enter the expiration date in this format YYYY-MM-DD <br /> 9999-12-30 : Is equal to no expire.', 'FadeIn'); ?></p>
	  
      <input name="FadeIn_id" id="FadeIn_id" type="hidden" value="">
      <input type="hidden" name="FadeIn_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="<?php _e('Submit', 'FadeIn'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="_FadeIn_redirect()" value="<?php _e('Cancel', 'FadeIn'); ?>" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="_FadeIn_help()" value="<?php _e('Help', 'FadeIn'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('FadeIn_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'FadeIn'); ?>
	<a target="_blank" href="<?php echo FADEIN_FAV; ?>"><?php _e('click here', 'FadeIn'); ?></a>
</p>
</div>