#!/opt/php/bin/php
<?php

/*
 * $Id: $
 * Created on Oct 14, 2006 by Douglas Putnam ** 
*/


// This script require /opt/php/bin/php on hills.
// On other systems, you can use php-cli, if it exists

// Make sure to turn on argc and argv
ini_set('register_argc_argv', 1);

// Define some bottom-line directories for our structions
// relative to the script itself.
$app_dir = dirname(dirname(__FILE__)) . '/app/';

// Supporint directories. You can add other directories
// here if you need them.
$controller_dir = $app_dir  . 'controllers/';
$model_dir      = $app_dir  . 'models/';
$view_dir       = $app_dir  . 'views/';
$layouts_dir    = $view_dir . 'layouts/';
$config_dir     = $app_dir  . 'config/';
$classes_dir    = $app_dir  . 'classes/';
$lib_dir        = $app_dir  . 'lib/';
$sessions_dir   = $app_dir  . 'sessions/';
$directories = array('controllers','models','views','views/layouts','config','classes','lib','sessions');

if(!file_exists(strtolower($app_dir))) {
   print 'Creating initial directory structure.'."\n";
    mkdir($app_dir,0700,true);
    mkdir($model_dir,0700,true);
    mkdir($controller_dir,0700,true);
    mkdir($view_dir,0700,true);
    mkdir($view_dir.'default',0700,true);
    mkdir($layouts_dir,0700,true);
    mkdir($lib_dir,0700,true);
    mkdir($config_dir,0700,true);
    mkdir($classes_dir,0700,true);
    mkdir($sessions_dir,0700,true);
   print "\n";
    $files = file(dirname(__FILE__).'/files/required_files.txt');
    print "Copying files: \n";
    foreach($files as $file) {
       $file = trim($file);
       if(!file_exists(strtolower(dirname(__FILE__).'/../'.$file))) {
          if(!file_exists(strtolower(dirname(__FILE__).'/../'.dirname($file)))) {
              mkdir(dirname(__FILE__).'/../'.dirname($file),0700,true);
          }
          if(is_dir(dirname(__FILE__).'/'.$file)) { continue; }
          print '.';
          copy(dirname(__FILE__).'/'.$file, dirname(__FILE__).'/../'.$file);
       }
    }
    copy(dirname(__FILE__)  . '/files/index.php', dirname(__FILE__).'/../index.php');
    copy(dirname(__FILE__)  . '/files/setup.inc', dirname(__FILE__).'/../setup.inc');
    copy(dirname(__FILE__)  . '/files/LICENSE.txt', dirname(__FILE__).'/../LICENSE.txt');
    copy(dirname(__FILE__)  . '/files/README', dirname(__FILE__).'/../README');
}
// We will need some templates to create functions and classes
$method = array();

// We'll always need some default methods and views, index for example.
$methods = 'function index() {}'; 

// We can use eval() to use these templates to create dummy methods
$templates  = array(
        'controller' => '$out = "<?php
    class {$controller}Controller extends ApplicationController {
        $methods
    }
";',

        'model' =>' $out = "<?php
/**
 * File: $model.php
 * \$Id: \$
 */
    class ".ucwords($model)." extends ActiveRecord {
    }
";
',

        'view' => '$out = "<h1>{$view}.html</h1>
This is the {$view}.html file.<br />
Edit me at phplib/views/{$controller}/{$view}.html.
<p>";',

);

if(count($argv) < 3) {
    print <<<END

---

Usage: php script/generate.php [controller [model [ view]]]  [name [view2 [view n...]]]

---

END;
    exit;
}
elseif($argv[1] == 'controller') {

    $view = '';

    if($argv[2]) {
        $controller = $argv[2];
    }
    else {
        die('Missing controller name');
    }
    $controller_file = $app_dir .'controllers/'."{$controller}_controller.php";

    if(count($argv)> 3) {
        $view = $argv[3];
        $views = array_slice($argv,3);
        foreach($views as $method) {
            if($method == 'index') continue;
            $methods .= "\n\n        function $method() {}";
        }
        $view_file = $app_dir ."views/{$controller}/{$view}.html";
        $view_dir = $app_dir ."views/{$controller}/";
        if(!is_dir($view_dir)) {
            mkdir($view_dir, 0755,TRUE);
        }
    }

    if(file_exists(strtolower($controller_file))) {
        print "Controller File exists!" . basename($controller_file);
        $res = readline(' Overwrite(Y,n)?');
        ;

        if('n' == trim(strtolower($res))) {
            print ("... Ignoring\n");
        }
        else {
            $fh = fopen(strtolower($controller_file), 'w')
                    or die('Could not open ' . $controller_file);

            eval( $templates['controller']);

            fwrite($fh, $out) && print "Creating {$controller_file}\n";
            fclose($fh);
        }
    }
    else {
        $fh = fopen(strtolower($controller_file), 'w')
                or die('Could not open ' . $controller_file);
        eval( $templates['controller']);
        fwrite($fh, $out) && print "created {$controller_file}\n";
        fclose($fh);
    }

    //if(isset($view_file)) 
    if(count($argc > 2)) {
        $views = array_slice($argv, 3);
        $views[] = 'index';
        $views = array_unique($views);
        foreach($views as $view) {
            if(!file_exists(strtolower($app_dir."views/$controller"))) {
                mkdir($app_dir."views/$controller");
            }
            $view_file = $app_dir ."views/{$controller}/{$view}.html";
            if(file_exists(strtolower($view_file))) {
                print "View file exists! ". basename( $view_file);
                $res = readline(' Overwrite(Y,n)?');
                ;
                if('n' == trim(strtolower($res))) {
                    print("... ignoring\n");
                }
                else {
                    $fh = fopen(strtolower($view_file), 'w')
                            or die('Could not open ' . "$view_file\n");

                    eval( $templates['view']);
                    fwrite($fh, $out) && print "created {$view_file}\n";
                    fclose($fh);
                }
            }
            else {
                $fh = fopen(strtolower($view_file), 'w')
                    or die('Could not open ' . "$view_file\n");

                eval( $templates['view']);
                fwrite($fh, $out) && print "created {$view_file}\n";
                fclose($fh);
            }
        }
    }
}
elseif(strtolower($argv[1]) == 'view') {

    if($argv[2]) {
        $controller = $argv[2];
    }
    else {
        die('Missing controller name');
    }
    if($argv[3]) {
        $view = $argv[3];
    }
    else {
        die('Missing view name');
    }
    $view_file = $app_dir .'views/'."{$controller}/{$view}.html";

    if(file_exists(strtolower($view_file))) {
        print "View file exists! ". basename( $view_file);
        $res = readline(' Overwrite(Y,n)?');
        ;
        if('n' == trim(strtolower($res))) {
            print("... ignoring\n");
        }
        else {
            $fh = fopen(strtolower($view_file), 'w')
                    or die('Could not open ' . "$view_file\n");

            eval( $templates['view']);
            fwrite($fh, $out) && print "Create {$view_file}\n";
            fclose($fh);
        }
    }
    else {
        $fh = fopen(strtolower($view_file), 'w')
                or die('Could not open ' . "$view_file\n");

        eval( $templates['view']);
        fwrite($fh, $out) && print "Create {$view_file}\n";
        fclose($fh);
    }
}
elseif($argv[1] == 'model') {

    if($argv[2]) {
        $model = $argv[2];
    }
    else {
        die('Missing model name');
    }
    $model_file = $app_dir .'models/'."{$model}.php";

    if(file_exists(strtolower($model_file))) {
        print "Model file exists! ". basename( $model_file);
        $res = readline(' Overwrite(Y,n)?');
        ;
        if('n' == trim(strtolower($res))) {
            print("... ignoring\n");
        }
        else {
            $fh = fopen(strtolower($model_file), 'w')
                    or die('Could not open ' . "$model_file\n");

            eval( $templates['model']);
            fwrite($fh, $out) && print "Create {$model_file}\n";
            fclose($fh);
        }
    }
    else {
        $fh = fopen(strtolower($model_file), 'w')
                or die('Could not open ' . "$model_file\n");

        eval( $templates['model']);
        fwrite($fh, $out) && print "Create {$model_file}\n";
        fclose($fh);
    }
}
