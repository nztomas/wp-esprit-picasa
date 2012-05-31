<?php
$pluginDirectoryPath = WP_PLUGIN_URL."/".str_replace(basename( __FILE__),'',plugin_basename(__FILE__));

echo "<link rel='stylesheet' href='".$pluginDirectoryPath."css/style.css"."' type='text/css' media='all' />\n";
echo "<script type='text/javascript'>\n";
echo "  pluginDirectoryPath = '".$pluginDirectoryPath."'";
echo "</script>\n";
echo "<script type='text/javascript' src='".$pluginDirectoryPath."js/wp-esprit-picasa-admin.js"."'></script>\n";
?>

<?php

$submitted = false;

if (isset($_REQUEST['submit'])) {
  $submitted = true;
}

if ($submitted && ($_REQUEST['submit'] == 'Save Changes' || $_REQUEST['submit'] == 'Test Settings')) {
  update_option(WpEspritPicasa::$WP_OPTION_SERVER, $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_SERVER]==""?"picasaweb.google.com":$_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_SERVER]);
  update_option(WpEspritPicasa::$WP_OPTION_USERNAME, $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_USERNAME]);
  update_option(WpEspritPicasa::$WP_OPTION_THUMBNAIL_SIZE, $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_THUMBNAIL_SIZE]);
  update_option(WpEspritPicasa::$WP_OPTION_FULL_SIZE, $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_FULL_SIZE]);
  update_option(WpEspritPicasa::$WP_OPTION_PEREX_STATUS, $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_PEREX_STATUS]);
  update_option(WpEspritPicasa::$WP_OPTION_PEREX_SIZE, $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_PEREX_SIZE]);
  update_option(WpEspritPicasa::$WP_OPTION_PEREX_POSITION, $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_PEREX_POSITION]);

  if ($_REQUEST['submit'] == 'Save Changes')
  {
    $message = "Settings saved.";
  }
  else if ($_REQUEST['submit'] == 'Test Settings')
  {
    require_once ESPRIT_PICASA_DIR.'/wp-esprit-picasa-test.php';
    $message = $status?"Connection was successful":"There was an error when connecting";
  }
}

?>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br />
</div>
<h2><?php echo WpEspritPicasa::$WP_DISPLAY_NAME; ?> Settings</h2>

<?php

$PicasaServer = get_option(WpEspritPicasa::$WP_OPTION_SERVER);
$PicasaUser = get_option(WpEspritPicasa::$WP_OPTION_USERNAME);
$ThumbnailSize = get_option(WpEspritPicasa::$WP_OPTION_THUMBNAIL_SIZE);
$FullSize = get_option(WpEspritPicasa::$WP_OPTION_FULL_SIZE);
$PerexStatus = get_option(WpEspritPicasa::$WP_OPTION_PEREX_STATUS);
$PerexSize = get_option(WpEspritPicasa::$WP_OPTION_PEREX_SIZE);
$PerexPosition = get_option(WpEspritPicasa::$WP_OPTION_PEREX_POSITION);

if (isset($message) and strlen($message)) {
  echo '<div id="message" class="updated fade"><p><strong>'.$message.'</strong></p></div>';
  unset($message);
}
?>

<form id="PicasaSettings" method="post"
	action="<?php echo $_SERVER['PHP_SELF'].'?page='.basename(ESPRIT_PICASA_DIR)."/".basename(__FILE__); ?>&update=true">

<input type='hidden' name='option_page' value='discussion' /><input
	type="hidden" name="action" value="update" /><input type="hidden"
	id="_wpnonce" name="_wpnonce" value="2d9f27a5f5" /><input type="hidden"
	name="_wp_http_referer" value="/wp-admin/options-discussion.php" />

<table class="form-table">

	<tr valign="top">
		<th scope="row">Picasa Server:</th>
		<td>
		<fieldset><legend class="hidden">Picasa Server:</legend> <label
			for="PicasaServer"> <input size=40 name="<?php echo WpEspritPicasa::$REQUEST_PARAMETER_SERVER; ?>" type="text"
			id="PicasaServer"
			value="<?php echo get_option(WpEspritPicasa::$WP_OPTION_SERVER); ?>" />
		</label> <br />
		</fieldset>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row">Picasa Album Name:</th>
		<td>
		<fieldset><legend class="hidden">Picasa User Name:</legend> <label
			for="PicasaUsername"> <input size=40 name="username" type="text"
			id="PicasaUsername"
			value="<?php echo get_option(WpEspritPicasa::$WP_OPTION_USERNAME); ?>" />
		</label> <br />
		</fieldset>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row">Default photo thumbnail size:</th>
		<td>
		<fieldset><legend class="hidden">Default photo thumbnail size:</legend>
		<label for="ThumbnailSize">
		<?php 
		  echo "<select id=\"ThumbnailSize\" name=\"" . WpEspritPicasa::$REQUEST_PARAMETER_THUMBNAIL_SIZE . "\">";
		  foreach (WpEspritPicasa::$ThumbnailSizes as $key => $value) {
		    echo "<option value=\"" . $key . "\"" . ($ThumbnailSize==$key?" selected":"") . ">";
		    echo $value;
		    echo "</option>\n";
		  }
          echo "</select>";		
		?>
		</label>
		</fieldset>
		</td>
	</tr>


	<tr valign="top">
		<th scope="row">Default photo full size:</th>
		<td>
		<fieldset><legend class="hidden">Default photo full size:</legend>
		<label for="FullSize">
		<?php 
		  echo "<select id=\"FullSize\" name=\"" . WpEspritPicasa::$REQUEST_PARAMETER_FULL_SIZE . "\">";
		  foreach (WpEspritPicasa::$ThumbnailSizes as $key => $value) {
		    echo "<option value=\"" . $key . "\"" . ($FullSize==$key?" selected":"") . ">";
		    echo $value;
		    echo "</option>\n";
		  }
          echo "</select>";		
		?>
		</label>
		</fieldset>
		</td>
	</tr>
	
</table>

<h3>Picasa Perex Image</h3>

<table class="form-table">
	
	<tr valign="top">
		<th scope="row">Perex status:</th>
		<td>
		<fieldset><legend class="hidden">Photo perex status:</legend>
		<label for="PerexSize">
		<?php 
		  echo "<input type=\"checkbox\" id=\"PerexStatus\" name=\"" . WpEspritPicasa::$REQUEST_PARAMETER_PEREX_STATUS . "\"" . ($PerexStatus?" checked":"") .">";
		?>
		Enable perex image for post and pages.
		</label>
		</fieldset>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row">Default photo perex size:</th>
		<td>
		<fieldset><legend class="hidden">Default photo perex size:</legend>
		<label for="PerexSize">
		<?php 
		  echo "<select id=\"PerexSize\" name=\"" . WpEspritPicasa::$REQUEST_PARAMETER_PEREX_SIZE . "\">";
		  foreach (WpEspritPicasa::$PerexSizes as $key => $value) {
		    echo "<option value=\"" . $key . "\"" . ($PerexSize==$key?" selected":"") . ">";
		    echo $value;
		    echo "</option>\n";
		  }
          echo "</select>";		
        ?>
		</label>
		</fieldset>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row">Perex photo position:</th>
		<td>
		<fieldset><legend class="hidden">Perex photo position:</legend>
		<label for="PerexPosition">
		<?php 
		  echo "<select id=\"PerexPosition\" name=\"" . WpEspritPicasa::$REQUEST_PARAMETER_PEREX_POSITION . "\">";
		  foreach (WpEspritPicasa::$PerexPositions as $key => $value) {
		    echo "<option value=\"" . $key . "\"" . ($PerexPosition==$key?" selected":"") . ">";
		    echo $value;
		    echo "</option>\n";
		  }
          echo "</select>";		
		?>
		</label>
		</fieldset>
		</td>
	</tr>
	
</table>


<p class="submit"><input type="submit" name="submit"
	class="button-primary" value="Save Changes" /> <input type="submit"
	id="TestButton" name="submit" class="button-primary"
	value="Test Settings" /> <img class="AjaxLoader"
	src="<? echo WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__))."images/ajax-loader.gif"; ?>">
<span id="TestResult"><?php echo isset($testMessage)?$testMessage:""; ?> </span></p>

</form>

<div id="PicasaDonate">
<h3>Support. Donate.</h3>
<p>This plugin is freeware and will always remain so.</p>
<p>If you like it and would like to contribute to its development, consider making a donation.</p>
<p>Any amount would be very appreciated.</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</div>

<div class="clear"><br>
</div>

</div>
