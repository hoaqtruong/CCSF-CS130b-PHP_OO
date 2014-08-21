<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', dirname(__FILE__).DS);



defined('HELPERS')   ? null : define("HELPERS", SITE_ROOT.'helpers'.DS);

defined('FUNCTIONS')   ? null : define("FUNCTIONS", SITE_ROOT.'functions'.DS);

defined('PHPLIB')   ? null : define("PHPLIB", SITE_ROOT.'phplib'.DS);

defined('CONTROLLERS')   ? null : define("CONTROLLERS", PHPLIB.'controllers'.DS);

defined('MODELS')   ? null : define("MODELS", PHPLIB.'models'.DS);

defined('VIEWS')   ? null : define("VIEWS", PHPLIB.'views'.DS);

defined('LAYOUTS')   ? null : define("LAYOUTS", VIEWS.'layouts'.DS);

defined('IMAGES')   ? null : define("IMAGES", SITE_ROOT.'images'.DS);