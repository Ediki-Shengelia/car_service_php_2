<?php



defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
defined("SITE_ROOT") ? null : define("SITE_ROOT", 'C:' . DS . 'xampp' . DS . 'htdocs' . DS . 'php_refresher' . DS  . '002');


require_once "functions.php";
require_once __DIR__ . '/../class/database.php';
require_once __DIR__ . '/../class/db_object.php';
require_once __DIR__ . '/../class/user.php';
require_once __DIR__ . '/../class/session.php';
require_once __DIR__ . '/../class/staff.php';
require_once __DIR__ . '/../class/service.php';
require_once __DIR__ . '/../class/working_hours.php';
require_once __DIR__ . '/../class/day_off.php';
