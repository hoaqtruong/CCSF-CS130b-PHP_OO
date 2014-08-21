<?php
error_reporting(E_ALL);
define('WEB_DIR','/users/dputnam/public_html/');
define('IMAGES_DIR','/users/dputnam/public_html/images/');

define('ROOT',dirname(__FILE__) . '/phplib/'         );
define('CONTROLLERS', ROOT    . 'controllers/');
define('MODELS'   , ROOT       . 'models/'     );  
define('CLASSES'  , ROOT      . 'classes/'    );  
define('VIEWS'    , ROOT       . 'views/'      );  
define('LAYOUTS'  , VIEWS     . 'layouts/'    );  

// Eyecandy
define('SITE_URL'        , 'http://hills.ccsf.edu/~dputnam/');
define('SITE_NAME', basename(dirname(dirname(ROOT))));
define('DB'       , ROOT      . 'db/'         );  
define('LIB'      , ROOT      . 'lib/'        );  
define('CONFIG'   , ROOT      . 'config/'     );  
define('PUB_DIR'  , ROOT      . 'public/'     );  
define('JS'       , PUB_DIR   . 'js/'         );  
define('CSS'      , PUB_DIR   . 'css/'        );  
define('IMAGES'   , PUB_DIR   . 'css/'        );  
define('WEB_IMG'  ,             'images/'     );  
define('WEB_CSS'  ,             'css/'        );  
define('WEB_JS'   ,             'js/'         );  
define('DECORATORS' , CLASSES . 'helpers/'    );  
define('HELPERS'    , CLASSES . 'helpers/'    );  
define('DB_FILE'    , DB      . basename(dirname(dirname(__FILE__))).'.sqlite');

date_default_timezone_set('America/Los_Angeles');

#require_once LIB         . 'std_lib.php';
#require_once CLASSES     . 'site.php' ;
#require_once CONTROLLERS . 'base_controller.php';
require_once CONTROLLERS . 'application_controller.php';
#require_once DECORATORS  . 'decorator.php';

/**
 *  Autoload classes to simplify the very messy PHP.
 */
function __autoload($klass) {
  // Classes
  if((strpos(strtolower($klass),'controller')) !== FALSE) {
     $klass =substr($klass,0,strpos(strtolower($klass),'controller'));
  }

  if(file_exists(CLASSES.strtolower($klass) . '.php')) {
    require_once CLASSES.strtolower($klass) . '.php';
  }
  // Controller classes
  elseif(file_exists(CONTROLLERS . strtolower($klass . '_controller.php'))) {
    require_once CONTROLLERS.strtolower($klass) . '_controller.php';
  }
  // Helpers for controllers
    // Decorator design pattern
  elseif(file_exists(DECORATORS.strtolower($klass.'_decorator.php'))) {
    require_once DECORATORS.strtolower($klass) . '_decorator.php';
  }
  // Models
  elseif(file_exists(MODELS.strtolower($klass).'.php')) {
    require_once MODELS.strtolower($klass).'.php';
  }
}

