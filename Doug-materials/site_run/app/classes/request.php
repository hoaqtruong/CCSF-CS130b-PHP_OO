<?php

   class Request {

      // Set up default controller, action and id
      static $defaultController = 'default';
      static $defaultAction     = 'index';
      static $defaultId         = null;

      private function __construct() {}

      static function run() {
         // Start parsing the Request.
         $R = new Request();
         $R->parse();

         // The requested controller or the default.
         $kontroller = $R->determineController();
         $kontroller->render();
      }

      function  determineController() 
      {
         $controller = $this->controller.'Controller';

         if(file_exists(CONTROLLERS . $this->controller . '_controller.php')) {
             // Create the controller that matches the request
			 require_once CONTROLLERS. $this->controller . '_controller.php';
             return(new $controller($this));
         }
         else {
             return(new DefaultController($this));
         }
      }

      function parse() {
         // Collect the request data and place it into
         // a Request object. This object will be passed
         // to the require controller as the sole parameter.

         // Users cannot explicitly set the controller, action, or id.
         // These are all set with the _r key: ?_r=controller/action/id


         $forbidden = array('controller','action','id');

         // GET or POST but REQUEST
         $this->controller = $this->defaultController = 'default';
         $this->action     = $this->defaultAction     = 'index';
         $this->id         = $this->defaultId         = '';

         if(isset($_REQUEST['_r'])) {
             $parts = explode('/',trim($_REQUEST['_r']));

             if(count($parts) == 3) { 
                $this->controller = $parts[0];
                $this->action     = $parts[1];
                $this->id         = $parts[2];
             }

             if(count($parts) == 2) {
                $this->controller = $parts[0];
                $this->action = $parts[1];
             }

             if(count($parts) == 1) $this->controller = $parts[0];
         }


         // Collect any other request values from $_REQUEST
         foreach($_REQUEST as $k => $v) {
             if(in_array($k,$forbidden)) { continue; }
             $this->$k = $v;
         }
      }
   }
