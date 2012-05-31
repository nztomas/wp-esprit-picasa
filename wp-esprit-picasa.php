<?php
/*
 Plugin Name: 	WP Esprit Picasa
 Plugin URI: 	http://trac.espr.it/wiki/Wordpress/Picasa
 Description:	This plugin allows you to easily add your Picasa photos to your posts and pages.
 Author: ESPR!T
 Version: 0.0.6
 Author URI: http://espr.it/
 */

Class WpEspritPicasa {

  private static $PICASA_URL_REGEX = '/(.*)\/((s|c)[0-9]{3})\/((.*)\.(gif|jpg|png))/i';
   
  public static $REQUEST_PARAMETER_SERVER = "server";

  public static $REQUEST_PARAMETER_ALBUM_NAME = "album_name";

  public static $REQUEST_PARAMETER_ALBUM_ID = 'album_id';

  public static $REQUEST_PARAMETER_POST_ID = "post_id";

  public static $REQUEST_PARAMETER_TYPE = "type";

  public static $REQUEST_PARAMETER_TAB = "tab";

  public static $REQUEST_PARAMETER_THUMBNAIL_SIZE = "thumbnail_size";

  public static $REQUEST_PARAMETER_FULL_SIZE = "fullsize";

  public static $REQUEST_PARAMETER_PEREX_STATUS = "perex_status";

  public static $REQUEST_PARAMETER_PEREX_SIZE = "perex_size";

  public static $REQUEST_PARAMETER_PEREX_POSITION = "perex_position";

  public static $REQUEST_PARAMETER_USERNAME = "username";

  public static $META_PARAMETER_PEREX_URL = "perex_url";

  public static $META_PARAMETER_PEREX_TITLE = "perex_title";

  public static $META_PARAMETER_PEREX_DESCRIPTION = "perex_description";

  public static $WP_OPTION_SERVER = "WP_ESPRIT_PICASA_OPTION_SERVER";

  public static $WP_OPTION_USERNAME = "WP_ESPRIT_PICASA_OPTION_USER";

  public static $WP_OPTION_THUMBNAIL_SIZE = "WP_ESPRIT_PICASA_OPTION_THUMBNAIL_SIZE";

  public static $WP_OPTION_FULL_SIZE = "WP_ESPRIT_PICASA_OPTION_FULL_SIZE";

  public static $WP_OPTION_PEREX_STATUS = "WP_ESPRIT_PICASA_OPTION_PEREX_STATUS";

  public static $WP_OPTION_PEREX_SIZE = "WP_ESPRIT_PICASA_OPTION_PEREX_SIZE";

  public static $WP_OPTION_PEREX_POSITION = "WP_ESPRIT_PICASA_OPTION_PEREX_POSITION";

  public static $WP_META_PEREX_URL = "wp-esprit-picasa-meta-url";

  public static $WP_META_PEREX_TITLE = "wp-esprit-picasa-meta-title";

  public static $WP_META_PEREX_DESCRIPTION = "wp-esprit-picasa-meta-description";

  public static $WP_PLUGIN_NAME = "WpEspritPicasa";

  public static $WP_DISPLAY_NAME = "ESPR!T Picasa";

  public static $ThumbnailSizes = array(
                     "94" => "94px",
                     "110" => "110px",
                     "128" => "128px",
                     "200" => "200px",
                     "288" => "288px",
                     "320" => "320px",
                     "400" => "400px",
                     "512" => "512px",
                     "576" => "576px",
                     "640" => "640px",
                     "720" => "720px",
                     "800" => "800px",
  );

  public static $PerexPositions = array(
                     "none" => "None",
  					 "left" => "Left",
                     "center" => "Center",
                     "right" => "Right",
  );

  public static $PerexSizes = array(
                     "104" => "104px ",
                     "104c" => "104px cropped",
                     "110" => "110px ",
                     "128" => "128px ",
          					 "144" => "144px ",
                     "144c" => "144px cropped",
                     "150" => "150px ",
                     "150c" => "154px cropped",
                     "160" => "160px ",
                     "160c" => "160px cropped",
                     "200" => "200px ",
                     "220" => "220px ",
                     "288" => "288px ",
                     "320" => "320px ",
  );
  
  public static function gDate($format, $timestamp = null) {
    //echo $timestamp;
    if (is_null($timestamp)) {
      $timestamp=microtime(true);
    }

    return date($format, (int)substr($timestamp, 0, 10));
  }

  public function __construct() {

  }

  public static function getPicasaImageUrl($url) {
    $size = get_option(WpEspritPicasa::$WP_OPTION_FULL_SIZE);
    $replacement = '${1}/s' . $size . '/${4}';
    return preg_replace(self::$PICASA_URL_REGEX, $replacement, $url);
  }
}

define('ESPRIT_PICASA_FILE', basename(__FILE__));
define('ESPRIT_PICASA_DIR', dirname(__FILE__));
define('ESPRIT_PICASA_PATH', ESPRIT_PICASA_DIR.'/'.ESPRIT_PICASA_FILE);
define('ESPRIT_PICASA_ADMIN_URL', $_SERVER['PHP_SELF']."?page=".basename(ESPRIT_PICASA_DIR).'/'.ESPRIT_PICASA_FILE);


function wpEspritPicasaAdminActions() {
  add_options_page("ePicasa", "ESPR!T Picasa", 'administrator', "wp-esprit-picasa/wp-esprit-picasa-admin", "picasaAdminMenu");
  if (get_option(WpEspritPicasa::$WP_OPTION_PEREX_STATUS)=='on') {
    add_meta_box(
			'wpPicasaPerex', // id of the <div> we'll add
			'Picasa Perex', //title
			'picasaPerexBox', // callback function that will echo the box content
			'post', // where to add the box: on "post", "page", or "link" page
			'normal',
			'high' 
			);
  }
}

function wpEspritPicasaAddMediaButton() {
  global $post_ID, $temp_ID;
  $uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
  $media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";

  $media_picasa_iframe_src = apply_filters('media_picasa_iframe_src', "$media_upload_iframe_src&amp;type=wp_picasa_photo&amp;tab=photo");
  $media_picasa_title = __('WP ESPR!T Picasa', 'wp-esprit-picasa');

  echo "<a href=\"{$media_picasa_iframe_src}&amp;TB_iframe=true&amp;height=500&amp;width=800\" class=\"thickbox\" title=\"$media_picasa_title\"><img src=\"".get_option('siteurl').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__))."/images/media-icon.gif\" alt=\"$media_picasa_title\" /></a>";
}

function wpEspritPicasaModifyMediaTab($tabs) {
  $mediaTabs = array();
  $mediaTabs['photo'] =  __('Picasa Photos', 'wp-esprit-picasa');

  if (get_option(WpEspritPicasa::$WP_OPTION_PEREX_STATUS)=='on') {
    $mediaTabs['thumbnail'] =  __('Picasa Thumbnails', 'wp-esprit-picasa');
  }

  return $mediaTabs;
}

function picasaAdminMenu() {
  global $wpdb;
  include 'wp-esprit-picasa-admin.php';
}

function wpEspritPicasaMediaUpload() {
  wp_iframe('media_upload_picasa_iframe');
}

function media_upload_picasa_iframe() {
  global $wpdb, $wp_query, $wp_locale, $type, $tab, $post_mime_types;
  add_filter('media_upload_tabs', 'wpEspritPicasaModifyMediaTab');
  media_upload_header();
  include 'wp-esprit-picasa-gallery.php';
}

function picasaPerexBox()
{
  global $post_ID, $temp_ID;
  include 'wp-esprit-picasa-perex.php';
}

function wpEspritPicasaSaveMetadata()
{
  global $post_ID;

  if(isset($_POST[WpEspritPicasa::$META_PARAMETER_PEREX_DESCRIPTION])) {
    update_post_meta($post_ID, WpEspritPicasa::$WP_META_PEREX_DESCRIPTION, $_POST[WpEspritPicasa::$META_PARAMETER_PEREX_DESCRIPTION]);
  }

  if(isset($_POST[WpEspritPicasa::$META_PARAMETER_PEREX_TITLE])) {
    update_post_meta($post_ID, WpEspritPicasa::$WP_META_PEREX_TITLE, $_POST[WpEspritPicasa::$META_PARAMETER_PEREX_TITLE]);
  }

  if(isset($_POST[WpEspritPicasa::$META_PARAMETER_PEREX_URL])) {
    update_post_meta($post_ID, WpEspritPicasa::$WP_META_PEREX_URL, $_POST[WpEspritPicasa::$META_PARAMETER_PEREX_URL]);
  }

}

function wpPicasaTheExcerpt($content) {
  global $post;
  $newContent = "";
  $style = "";
  $beginning = "";
  $end = "";
  
  $customFields = get_post_custom($post->ID);
  if ($customFields[WpEspritPicasa::$WP_META_PEREX_URL][0]!="") {

    switch(get_option(WpEspritPicasa::$WP_OPTION_PEREX_POSITION)) {
      case 'left':
        $style = " class=\"alignleft\"";
        break;
      case 'right':
        $style = " class=\"alignright\"";
        break;
      case 'center':
        $beginning = "<p style=\"text-align: center;\">\n";
        $end = "</p>\n";
    }
    
    $newContent .= $beginning;
    $newContent .= "<a href=\"" . WpEspritPicasa::getPicasaImageUrl($customFields[WpEspritPicasa::$WP_META_PEREX_URL][0]) . "\"";
    $newContent .= $customFields[WpEspritPicasa::$WP_META_PEREX_DESCRIPTION][0]!=""?" title=\"" . $customFields[WpEspritPicasa::$WP_META_PEREX_DESCRIPTION][0] . "\"":"";
    $newContent .= " rel=\"lightbox\">\n";

    $newContent .= "<img" . $style . " src=\"" . $customFields[WpEspritPicasa::$WP_META_PEREX_URL][0] . "\"";
    $newContent .= $customFields[WpEspritPicasa::$WP_META_PEREX_DESCRIPTION][0]!=""?" alt=\"" . $customFields[WpEspritPicasa::$WP_META_PEREX_DESCRIPTION][0] . "\"":"";
    $newContent .= $customFields[WpEspritPicasa::$WP_META_PEREX_TITLE][0]!=""?" title=\"" . $customFields[WpEspritPicasa::$WP_META_PEREX_TITLE][0] . "\"":"";
    $newContent .= " class=\"wpPicasaPerex\">\n";

    $newContent .= "</a>\n";
    $newContent .= $end;
  }

  $newContent .= $content;
  return $newContent;
}

add_action('admin_menu', 'wpEspritPicasaAdminActions');
add_action('media_buttons', 'wpEspritPicasaAddMediaButton', 20);
add_action('media_upload_wp_picasa_photo', 'wpEspritPicasaMediaUpload');
add_action('save_post','wpEspritPicasaSaveMetadata');

if (get_option(WpEspritPicasa::$WP_OPTION_PEREX_STATUS)=='on') {
  add_action('media_upload_wp_picasa_thumbnail', 'wpEspritPicasaMediaUpload');
  add_filter('the_content', 'wpPicasaTheExcerpt');
  add_filter('the_excerpt', 'wpPicasaTheExcerpt');
}


?>
