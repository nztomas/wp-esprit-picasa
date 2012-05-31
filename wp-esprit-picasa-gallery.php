<?php
// load picasa lightweight library
require_once('wp-esprit-picasa-library-include.php');
?>

<?php 
// load javascript and css files
echo "<script type='text/javascript' src='".WP_PLUGIN_URL."/".str_replace(basename( __FILE__),'',plugin_basename(__FILE__))."js/wp-esprit-picasa-gallery.js"."'></script>\n";
echo "<link rel='stylesheet' href='".WP_PLUGIN_URL."/".str_replace(basename( __FILE__),'',plugin_basename(__FILE__))."css/style.css"."' type='text/css' media='all' />\n";
?>

<?php
// construct uri parameters which have to be passed with each request  
$uriParams  = WpEspritPicasa::$REQUEST_PARAMETER_POST_ID."=".$_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_POST_ID];
$uriParams .= "&".WpEspritPicasa::$REQUEST_PARAMETER_TAB."=".$_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_TAB];
$uriParams .= "&".WpEspritPicasa::$REQUEST_PARAMETER_TYPE."=".$_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_TYPE];

// how many photos we will display on each line
$albumsPerRow = 4;
// the size of the photo displayed in admin area
$albumThumbnailSize = "144";

$picasa = new Picasa();
Picasa::setPicasaUrl(get_option(WpEspritPicasa::$WP_OPTION_SERVER));

// get the album name from the request
$albumId = null;
if (isset($_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_ALBUM_ID])) {
  $albumId = $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_ALBUM_ID];
}

$tab = $_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_TAB];

$html = "<div id=\"PicasaWrapper\">";

$i = 0;

if (is_null($albumId))
// if there is no album name supplied in request parameter, display album list
{
  $account = $picasa->getAlbumsByUsername(get_option(WpEspritPicasa::$WP_OPTION_USERNAME), null, null, null, $albumThumbnailSize."c");
  
  foreach ($account->getAlbums() as $album) {

    $html .= $i % $albumsPerRow == 0?"<div class=\"row\">\n":"";

    $html .= "  <div class=\"PicasaAlbums\">\n";
    $html .= "    <a href=\"".$_SERVER["PHP_SELF"]."?".$uriParams."&".WpEspritPicasa::$REQUEST_PARAMETER_ALBUM_ID."=".$album->getIdnum()."\">\n";
    $html .= "      <img src=\"".$album->getIcon()."\" width=\"".$albumThumbnailSize."px\" height=\"".$albumThumbnailSize."px\">\n";
    $html .= "    </a>\n";
    $html .= "    <h5>".$album->getTitle()."</h5>\n";
    $html .= "    <p>".WpEspritPicasa::gDate('D jS F Y', $album->getTimestamp())." (photos: ".$album->getNumphotos().")</p>\n";
    $html .= "  </div>\n";

    if (($i + 1) % $albumsPerRow == 0 ) {
      $html .= "</div>\n";
      $html .= "<div class='clear'><br></div>";
    }

    $i++;
  }
}
else
// else display photos from album specified by name in request parameter
{
  $javascript = "<script type='text/javascript'>\n";
  
  $html .= "<div id=\"PicasaNavigation\">\n";
  $html .= "  <a href=\"".$_SERVER["PHP_SELF"]."?".$uriParams."\">Back to Albums</a>\n";
  $html .= "  <div class='clear'><br></div>\n";
  $html .= "</div>";

  $images = $picasa->getAlbumById(get_option(WpEspritPicasa::$WP_OPTION_USERNAME), $albumId, null, null, null, null, $albumThumbnailSize."c,".get_option(WpEspritPicasa::$WP_OPTION_THUMBNAIL_SIZE).",".get_option(WpEspritPicasa::$WP_OPTION_FULL_SIZE).",".get_option(WpEspritPicasa::$WP_OPTION_PEREX_SIZE))->getImages();
  $javascript .= "var picasaImagesArray = new Array();\n";
  
  foreach ($images as $image) {
    
    $thumbnails = $image->getThumbnails();

    $javascript .= "picasaImageObject = new Object();\n";
    $javascript .= "picasaImageObject.linkPerex = '" . $thumbnails[3]->getUrl() . "';\n";
    $javascript .= "picasaImageObject.description = '" . $image->getDescription() . "';\n";
    $javascript .= "picasaImagesArray['" . $image->getTitle() . "'] = picasaImageObject;\n"; 
    
    $html .= $i % $albumsPerRow == 0?"<div class=\"row\">\n":"";

    $html .= "  <div class=\"PicasaPhotos\">\n";
    
    if ($tab && $tab == "thumbnail") {
      $html .= "    <a href=\"#\" onclick=\"return false\">\n";
      $html .= "      <img class=\"Thumbnail\" name=\"" . $image->getTitle() . "\" src=\"".$thumbnails[0]->getUrl()."\" width=\"".$albumThumbnailSize."px\" height=\"".$albumThumbnailSize."px\">\n";
      $html .= "    </a>\n";
    } else {
      $html .= "    <a href=\"#\" onclick=\"return picasaAddPhoto('".$thumbnails[2]->getUrl()."','".$thumbnails[1]->getUrl()."','".$image->getTitle()."','".$image->getDescription()."','".$_REQUEST[WpEspritPicasa::$REQUEST_PARAMETER_POST_ID]."')\">\n";
      $html .= "      <img src=\"".$thumbnails[0]->getUrl()."\" width=\"".$albumThumbnailSize."px\" height=\"".$albumThumbnailSize."px\">\n";
      $html .= "    </a>\n";
    }

    $html .= "    <h5>".$image->getTitle()."</h5>\n";
    $html .= "    <p></p>\n";
    $html .= "  </div>\n";
    
    //$html .= $image->getWeblink();
    
    if (($i + 1) % $albumsPerRow == 0 ) {
      $html .= "</div>\n";
      $html .= "<div class='clear'><br></div>";
    }

    $i++;
  }
  $javascript .= "</script>\n";
  echo $javascript;
}

$html .= "<div class='clear'><br></div>\n";
$html .= "</div>\n";


echo $html;
?>
