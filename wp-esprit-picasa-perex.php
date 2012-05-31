<style type="text/css">
<!--
#wpPicasaPerex .info {
	float: left;
	margin: 0px;
	margin-left: 5px;
	font-size: 1.2em;
}

#wpPicasaPerex .info label {
	display: block;
	font-size: 1.2em;
	margin-left: 4px;
	font-weight: bold;
}

#wpPicasaPerex .info input, #wpPicasaPerex .info textarea {
	width: 500px;
}

#wpPicasaPerex .info textarea {
	height: 80px;
}

#wpPicasaPerex p.buttons {
	padding: 8px;
}

#wpPicasaPerex p.buttons a.button {
	margin-right: 15px;
}
-->
</style>
<?php
  $pluginDirectoryPath = WP_PLUGIN_URL."/".str_replace(basename( __FILE__),'',plugin_basename(__FILE__));
  echo "<link rel='stylesheet' href='".$pluginDirectoryPath."css/style.css' type='text/css' media='all' />\n";
  echo "<script type='text/javascript' src='".$pluginDirectoryPath."js/wp-esprit-picasa-perex.js'></script>";
  
  $uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
  $media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";

  $customFields = get_post_custom($uploading_iframe_ID);
  
  $media_picasa_iframe_src = apply_filters('media_picasa_iframe_src', "$media_upload_iframe_src&amp;type=wp_picasa_thumbnail&amp;tab=thumbnail");
  $media_picasa_title = __('WP ESPR!T Picasa', 'wp-esprit-picasa-add-thumbnail');
  
  $html = "<div id=\"wpPicasaPerex\">\n";

  $html = "<p class=\"buttons\">";
  $html .= "<a class=\"button thickbox\" href=\"{$media_picasa_iframe_src}&amp;TB_iframe=true&amp;height=500&amp;width=800\">Browse</a>";
  $html .= "<a class=\"button reset\" href=\"#\" onclick=\"return false;\">Reset</a>\n";
  $html .= "</p>";
  
  $html .= "<a href=\"{$media_picasa_iframe_src}&amp;TB_iframe=true&amp;height=500&amp;width=800\" class=\"thickbox\" title=\"$media_picasa_title\">\n";
  $html .= "<img id=\"wpPicasaPerexImage\"src=\"" . ($customFields[WpEspritPicasa::$WP_META_PEREX_URL][0]!=""?$customFields[WpEspritPicasa::$WP_META_PEREX_URL][0]:"") . "\" style=\"float: left;\">\n";
  $html .= "</a>";
  
  $html .= "<div class=\"info\">\n";
  
  $html .= "<p>\n";
  $html .= "<label for=\"wpEspritPicasaPerexUrl\">Url:";
  $html .= "</label>";
  
  $html .= "<input type=\"text\" name=\"" . WpEspritPicasa::$META_PARAMETER_PEREX_URL . "\" id=\"wpEspritPicasaPerexUrl\" value=\"" . $customFields[WpEspritPicasa::$WP_META_PEREX_URL][0] . "\"></input>";
  $html .= "</p>\n";
  
  $html .= "<p>\n";
  $html .= "<label for=\"wpEspritPicasaPerexTitle\">Title:</label>";
  $html .= "<input type=\"text\" name=\"" . WpEspritPicasa::$META_PARAMETER_PEREX_TITLE . "\" id=\"wpEspritPicasaPerexTitle\" value=\"" . $customFields[WpEspritPicasa::$WP_META_PEREX_TITLE][0] . "\"></input>";
  $html .= "</p>\n";
  
  $html .= "<p>\n";
  $html .= "<label for=\"wpEspritPicasaPerexDescription\">Description:</label>";
  $html .= "<textarea name=\"" . WpEspritPicasa::$META_PARAMETER_PEREX_DESCRIPTION . "\" id=\"wpEspritPicasaPerexDescription\">" . $customFields[WpEspritPicasa::$WP_META_PEREX_DESCRIPTION][0] . "</textarea>";
  $html .= "</p>\n";
  
  $html .= "</div>\n";
  
  $html .= "<div class=\"clear\"><br></div>";
  
  $html .= "</div>\n";
  
  echo $html;
?>
