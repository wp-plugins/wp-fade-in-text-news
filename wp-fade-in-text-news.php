<?php

/*
Plugin Name: WP fade in text news
Plugin URI: http://www.gopiplus.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/
Description: Everybody loves fading in and out; this plugin will create the fade-in and out effect in the text. It is an excellent way to transition between announcements.
Author: Gopi.R
Version: 9.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/
Tags: Wordpress, plugin, widget, fadein, fade-in, fade in, announcement, text
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_FadeIn_TABLE", $wpdb->prefix . "FadeInText_plugin");

function FadeIn() 
{
	global $wpdb;
	$FadeIn_Arr = "";
	$FadeIn_FadeOut = get_option('FadeIn_FadeOut');
	$FadeIn_FadeIn = get_option('FadeIn_FadeIn');
	$FadeIn_Fade = get_option('FadeIn_Fade');
	$FadeIn_FadeStep = get_option('FadeIn_FadeStep');
	$FadeIn_FadeWait = get_option('FadeIn_FadeWait');
	$FadeIn_bFadeOutt = get_option('FadeIn_bFadeOutt');
	
	if(!is_numeric($FadeIn_FadeOut)){ $FadeIn_FadeOut = 255; } 
	if(!is_numeric($FadeIn_FadeIn)){ $FadeIn_FadeIn = 0; } 
	if(!is_numeric($FadeIn_Fade)){ $FadeIn_Fade = 0; } 
	if(!is_numeric($FadeIn_FadeStep)){ $FadeIn_FadeStep = 3; } 
	if(!is_numeric($FadeIn_FadeWait)){ $FadeIn_FadeWait = 3000; } 
	
	$sSql = "select FadeIn_text,FadeIn_link from ".WP_FadeIn_TABLE." where FadeIn_status='YES' and FadeIn_group='widget'";
	$sSql = $sSql . "ORDER BY FadeIn_order";
	
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($sSql) ) 
	{
		$FadeIn_Count = 0;
		foreach ( $data as $data ) 
		{
			$FadeIn_text =  $data->FadeIn_text;
			//$FadeIn_text = mysql_real_escape_string(trim($FadeIn_text));
			$FadeIn_link = $data->FadeIn_link;
			$FadeIn_Arr = $FadeIn_Arr . "FadeIn_Links[$FadeIn_Count] = '$FadeIn_link';FadeIn_Titles[$FadeIn_Count] = '$FadeIn_text';";
			if($FadeIn_Count == 0)
			{
				$FadeIn_First = $FadeIn_text;
			}
			$FadeIn_Count = $FadeIn_Count + 1;
		}
	}
	
	?>
    <script type="text/javascript" language="javascript">
	function FadeIn_SetFadeLinks() 
	{
		<?php echo $FadeIn_Arr ?>
	}

	var FadeIn_FadeOut = <?php echo $FadeIn_FadeOut; ?>;
	var FadeIn_FadeIn = <?php echo $FadeIn_FadeIn; ?>;
	var FadeIn_Fade = <?php echo $FadeIn_Fade; ?>;
	var FadeIn_FadeStep = <?php echo $FadeIn_FadeStep; ?>;
	var FadeIn_FadeWait = <?php echo $FadeIn_FadeWait; ?>;
	var FadeIn_bFadeOutt = <?php echo $FadeIn_bFadeOutt; ?>;

	</script>
    <div id="FadeIn_CSS" style="padding:5px;">
	<a href="#" id="FadeIn_Link"><?php echo $FadeIn_text; ?></a>
	</div>
    <?php	
}

function FadeIn_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'wp-fade-in-text-news', get_option('siteurl').'/wp-content/plugins/wp-fade-in-text-news/wp-fade-in-text-news.js');
	}	
}

function FadeIn_install() 
{
	
	global $wpdb;
	
	if($wpdb->get_var("show tables like '". WP_FadeIn_TABLE . "'") != WP_FadeIn_TABLE) 
	{
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". WP_FadeIn_TABLE . "` (
			  `FadeIn_id` int(11) NOT NULL auto_increment,
			  `FadeIn_text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `FadeIn_link` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
			  `FadeIn_order` int(11) NOT NULL default '0',
			  `FadeIn_status` char(3) NOT NULL default 'No',
			  `FadeIn_group` VARCHAR( 100 ) NOT NULL,
			  `FadeIn_date` datetime NOT NULL default '0000-00-00 00:00:00',
			  PRIMARY KEY  (`FadeIn_id`) )
			");
		$iIns = "INSERT INTO `". WP_FadeIn_TABLE . "` (`FadeIn_text`,`FadeIn_link`, `FadeIn_order`, `FadeIn_status`, `FadeIn_group`, `FadeIn_date`)"; 
		$sSql = $iIns . "VALUES ('Everybody loves fading in and out; this wp fade in text news plugin will create the fade-in and out effect in the text.','#', '1', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . "VALUES ('It is an superb excellent way to transition between announcements. Admin can add more announcement using plugin text management.','#', '2', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . "VALUES ('Only website admin and the user have the administrator privilege can see and change the setting in the website administration area.','#', '3', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . "VALUES ('Everybody loves fading in and out; this wp fade in text news plugin will create the fade-in and out effect in the text.','#', '4', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $iIns . "VALUES ('Only website admin and the user have the administrator privilege can see and change the setting in the website administration area.','#', '5', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}
	
	add_option('FadeIn_Title', "Text Fadein plugin");
	add_option('FadeIn_FadeOut', "255");
	add_option('FadeIn_FadeIn', "0");
	add_option('FadeIn_Fade', "0");
	
	add_option('FadeIn_FadeStep', "3");
	add_option('FadeIn_FadeWait', "3000");
	add_option('FadeIn_bFadeOutt', "true");
}

function FadeIn_control() 
{
	echo '<p>To change the setting ';
	echo ' <a href="options-general.php?page=wp-fade-in-text-news/wp-fade-in-text-news.php">';
	echo 'click here</a></p>';
}

function FadeIn_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('FadeIn_Title');
	echo $after_title;
	FadeIn();
	echo $after_widget;
}

function FadeIn_admin_options() 
{
	global $wpdb;
	?>
<div class="wrap">
  <h2>Fade in text news</h2>
</div>
<?php
	$FadeIn_Title = get_option('FadeIn_Title');
	$FadeIn_FadeOut = get_option('FadeIn_FadeOut');
	$FadeIn_FadeIn = get_option('FadeIn_FadeIn');
	$FadeIn_Fade = get_option('FadeIn_Fade');
	
	$FadeIn_FadeStep = get_option('FadeIn_FadeStep');
	$FadeIn_FadeWait = get_option('FadeIn_FadeWait');
	//$FadeIn_bFadeOutt = get_option('FadeIn_bFadeOutt');
	
	if (@$_POST['FadeIn_submit']) 
	{
		$FadeIn_Title = stripslashes($_POST['FadeIn_Title']);
		$FadeIn_FadeOut = stripslashes($_POST['FadeIn_FadeOut']);
		$FadeIn_FadeIn = stripslashes($_POST['FadeIn_FadeIn']);
		$FadeIn_Fade = stripslashes($_POST['FadeIn_Fade']);
		
		$FadeIn_FadeStep = stripslashes($_POST['FadeIn_FadeStep']);
		$FadeIn_FadeWait = stripslashes($_POST['FadeIn_FadeWait']);
		//$FadeIn_bFadeOutt = stripslashes($_POST['FadeIn_bFadeOutt']);
		
		update_option('FadeIn_Title', $FadeIn_Title );
		update_option('FadeIn_FadeOut', $FadeIn_FadeOut );
		update_option('FadeIn_FadeIn', $FadeIn_FadeIn );
		update_option('FadeIn_Fade', $FadeIn_Fade );
		
		update_option('FadeIn_FadeStep', $FadeIn_FadeStep );
		update_option('FadeIn_FadeWait', $FadeIn_FadeWait );
		//update_option('FadeIn_bFadeOutt', $FadeIn_bFadeOutt );
	}
	
	?>
<form name="FadeIn_form" method="post" action="">
  <?php
	echo '<p>Title:<br><input  style="width: 200px;" type="text" value="';
	echo $FadeIn_Title . '" name="FadeIn_Title" id="FadeIn_Title" /></p>';
	
	echo '<p>Fade Out:<br><input  style="width: 100px;" type="text" value="';
	echo $FadeIn_FadeOut . '" name="FadeIn_FadeOut" id="FadeIn_FadeOut" /></p>';

	echo '<p>Fade In:<br><input  style="width: 100px;" type="text" value="';
	echo $FadeIn_FadeIn . '" name="FadeIn_FadeIn" id="FadeIn_FadeIn" /></p>';

	echo '<p>Fade:<br><input  style="width: 100px;" type="text" value="';
	echo $FadeIn_Fade . '" name="FadeIn_Fade" id="FadeIn_Fade" /> ';
	
	echo '<p>Fade Step:<br><input  style="width: 100px;" type="text" value="';
	echo $FadeIn_FadeStep . '" name="FadeIn_FadeStep" id="FadeIn_FadeStep" /></p>';
	
	echo '<p>Fade Wait:<br><input  style="width: 100px;" type="text" value="';
	echo $FadeIn_FadeWait . '" name="FadeIn_FadeWait" id="FadeIn_FadeWait" /></p>';
	
	echo '<input name="FadeIn_submit" id="FadeIn_submit" lang="publish" class="button-primary" value="Update Setting" type="Submit" />';
	
	?>
</form>
<table width="100%">
  <tr>
    <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=wp-fade-in-text-news/content-management.php'" value="Go to - Text Management" type="button" />
      <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=wp-fade-in-text-news/wp-fade-in-text-news.php'" value="Go to - Fadein Setting" type="button" /></td>
  </tr>
</table>
<?php include_once("help.php"); ?>
<?php
}

add_shortcode( 'fadein-text', 'FadeIn_Show_shortcode' );

function FadeIn_Show_shortcode( $atts ) 
{
	global $wpdb;
	$JaFade = "";
	$FadeIn_Arr = "";
	$group = "";
	
	$FadeIn_FadeOut = get_option('FadeIn_FadeOut');
	$FadeIn_FadeIn = get_option('FadeIn_FadeIn');
	$FadeIn_Fade = get_option('FadeIn_Fade');
	$FadeIn_FadeStep = get_option('FadeIn_FadeStep');
	$FadeIn_FadeWait = get_option('FadeIn_FadeWait');
	$FadeIn_bFadeOutt = get_option('FadeIn_bFadeOutt');
	
	if(!is_numeric($FadeIn_FadeOut)){ $FadeIn_FadeOut = 255; } 
	if(!is_numeric($FadeIn_FadeIn)){ $FadeIn_FadeIn = 0; } 
	if(!is_numeric($FadeIn_Fade)){ $FadeIn_Fade = 0; } 
	if(!is_numeric($FadeIn_FadeStep)){ $FadeIn_FadeStep = 3; } 
	if(!is_numeric($FadeIn_FadeWait)){ $FadeIn_FadeWait = 3000; } 

	// Old short code
	//[FADEIN_TEXT_NEWS GROUP="widget"]
	//$var = $matches[1];
	//extract( shortcode_atts( array('group' => $group,), $var ) );
	//list($group,$value) = split('=', $var);
	//$tblgroup = str_replace('"', '', $value);
	
	// New short code
	// [fadein-text group="widget"]
	$tblgroup = "";
	if ( is_array( $atts ) )
	{
		$tblgroup = $atts['group'];
	}
	
	
	$sSql = "select FadeIn_text,FadeIn_link from ".WP_FadeIn_TABLE." where FadeIn_status='YES'";
	
	if($tblgroup <> "")
	{
		$sSql = $sSql . " and FadeIn_group='".$tblgroup."'";
	}
	
	$sSql = $sSql . "ORDER BY FadeIn_order";
	
	$data = $wpdb->get_results($sSql);

	$FadeIn_Count = 0;
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data )  
		{
			$FadeIn_text =  $data->FadeIn_text;
			//$FadeIn_text = mysql_real_escape_string(trim($FadeIn_text));
			$FadeIn_link = $data->FadeIn_link;
			$FadeIn_Arr = $FadeIn_Arr . "FadeIn_Links[$FadeIn_Count] = '".$FadeIn_link."';FadeIn_Titles[$FadeIn_Count] = '".$FadeIn_text."';";
			if($FadeIn_Count == 0)
			{
				$FadeIn_First = $FadeIn_text;
			}
			$FadeIn_Count = $FadeIn_Count + 1;
		}
		
		$JaFade = $JaFade . "<script type='text/javascript' language='javascript'>function FadeIn_SetFadeLinks() { $FadeIn_Arr;}";
		
		$JaFade = $JaFade . 'var FadeIn_FadeOut = '.$FadeIn_FadeOut.';';
		$JaFade = $JaFade . 'var FadeIn_FadeIn = '.$FadeIn_FadeIn.';';
		$JaFade = $JaFade . 'var FadeIn_Fade = '.$FadeIn_Fade.';';
		$JaFade = $JaFade . 'var FadeIn_FadeStep = '.$FadeIn_FadeStep.';';
		$JaFade = $JaFade . 'var FadeIn_FadeWait = '.$FadeIn_FadeWait.';';
		$JaFade = $JaFade . 'var FadeIn_bFadeOutt = '.$FadeIn_bFadeOutt.';';
		
		$JaFade = $JaFade . '</script>';
		$JaFade = $JaFade . '<div id="FadeIn_CSS">';
		$JaFade = $JaFade . '<a href="#" id="FadeIn_Link">'.$FadeIn_First.'</a>';
		$JaFade = $JaFade . '</div>';
	}
	else
	{
		$JaFade = "No record found for this short code";
	}
	return $JaFade;
}

function FadeIn_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Fade in text news', 'Fade in text news', 'manage_options', __FILE__, 'FadeIn_admin_options' );
		add_options_page('Fade in text news', '', 'manage_options', "wp-fade-in-text-news/content-management.php",'' );
	}
}

function FadeIn_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('fade-in-text-news', 'Fade in text news', 'FadeIn_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('fade-in-text-news', array('Fade in text news', 'widgets'), 'FadeIn_control');
	} 
}

function FadeIn_deactivation() 
{
	delete_option('FadeIn_FadeOut');
	delete_option('FadeIn_FadeIn');
	delete_option('FadeIn_Fade');
	delete_option('FadeIn_FadeStep');
	delete_option('FadeIn_FadeWait');
	delete_option('FadeIn_bFadeOutt');
}

add_action('admin_menu', 'FadeIn_add_to_menu');
add_action('wp_enqueue_scripts', 'FadeIn_add_javascript_files');
add_action("plugins_loaded", "FadeIn_init");
register_activation_hook(__FILE__, 'FadeIn_install');
register_deactivation_hook(__FILE__, 'FadeIn_deactivation');
add_action('admin_menu', 'FadeIn_add_to_menu');
?>