<?php
error_reporting(E_ALL);


define('ROOT',dirname(__FILE__) . '/app/'        );
define('CONTROLLERS', ROOT    . 'controllers/'   );
define('DECORATORS' , CONTROLLERS . 'decorators/');  
define('MODELS'   , ROOT      . 'models/'        );  
define('CONFIG'   , ROOT      . 'config/'      );  
define('CLASSES'  , ROOT      . 'classes/'     );  
define('VIEWS'    , ROOT      . 'views/'       );  
define('LAYOUTS'  , VIEWS     . 'layouts/'     );  
define('SESSIONS' , ROOT      . 'sessions/'    );  
define('LIB'      , ROOT      . 'lib/'         );  
define('DB'       , ROOT      . 'db/'          );  

// Miscellaneous
define('PUB_DIR'  , '/~'.get_current_user().'/');
define('JS'       , PUB_DIR   . 'js/'          );  
define('CSS'      , PUB_DIR   . 'css/'         );  
define('IMAGES'   , PUB_DIR   . 'images/'      );  
define('XML'      , PUB_DIR   . 'xml/'         );
define('HELPERS'  , CLASSES   . 'helpers/'     );  
define('UNITTEST' , LIB       . 'simpletest/'  );
define('_TMP' , '../../images/_tmp'  ); 
//define('DB_FILE'  , DB . basename(dirname(dirname(__FILE__))).'.sqlite');

date_default_timezone_set('America/Los_Angeles');

// Start sessions
session_save_path(SESSIONS);
session_name(substr(md5(get_current_user()),0,8));
session_set_cookie_params('','/~'.get_current_user());
session_start();

require_once LIB         . 'std_lib.php';
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

