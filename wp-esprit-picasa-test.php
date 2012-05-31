<?php
// load picasa lightweight library
require_once('wp-esprit-picasa-library-include.php');

$picasa = new Picasa();
Picasa::setPicasaUrl($_REQUEST['server']);

$status = True;
try {
  $account = $picasa->getAlbumsByUsername($_REQUEST['username'], 0);
} catch (Exception $e) {
  $status = False;
}

if($_REQUEST['type'] == 'rpc')
{
  $xml  = "<picasa>";
  $xml .= "<status>";
  if ($status) {
    $xml .= "OK";
  } else {
    $xml .= "ERROR";
  }
  $xml .= "</status>\n";
  $xml .= "</picasa>";

  header('Content-type: text/xml');
  echo $xml;
}
?>
