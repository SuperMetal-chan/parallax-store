<?php
define("ROOT", dirname(__FILE__));
include '../../../../controllers/GamesController.php';

GamesController::actionList($sortBy,$howTo);

echo $_POST['query'];