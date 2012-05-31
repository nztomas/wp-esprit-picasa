<?php
$libraryPath = dirname(__FILE__)."/lib/";
$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $libraryPath);

require_once 'Picasa.php';
?>