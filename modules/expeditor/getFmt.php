<?php
include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/ExpeditorModule.php');
$cookie = new Cookie('psAdmin', Tools::substr($_SERVER['PHP_SELF'], Tools::strlen(__PS_BASE_URI__), -10));
Tools::setCookieLanguage();

$file = './expeditor_format.fmt';

$handle = fopen($file, "r");
$len = filesize($file);
$filename_download = 'expeditor_format.fmt';
header('Content-Transfer-Encoding: none');
header('Content-Type: text/plain');
header('Content-Length: ' . $len);
header('Content-Disposition: attachment; filename="' . $filename_download . '"');
readfile($file);
fclose($handle);
exit();