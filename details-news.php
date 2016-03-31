<?php

include(dirname(__FILE__). '/../../config/config.inc.php');
include(dirname(__FILE__). '/../../init.php');

require(dirname(__FILE__).'/controllers/front/DetailsNewsSingleController.php');



$controller = new DetailsNewsSingleController();

$controller->run();