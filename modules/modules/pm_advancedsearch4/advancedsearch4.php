<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/pm_advancedsearch4.php');
include(dirname(__FILE__).'/controllers/front/advancedsearch4.php');
ControllerFactory::getController('pm_advancedsearch4advancedsearch4ModuleFrontController')->run();
