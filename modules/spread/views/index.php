<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vincent
 * Date: 03/04/13
 * Time: 10:49
 * To change this template use File | Settings | File Templates.
 */


header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header("Location: ../");
exit;