<?php
// static

class Request {
    private static $password = 'topsecret';
    public $controller = 'user';
    public $action = 'index';
    public $id = null;
    
    private function __construct() {
        #$_REQUEST['_r'] = 'sports/nfl';
        #$_REQUEST['_r'] = 'fashion';
        #$_REQUEST = array();
    }
    
    static function run() {
        $r = new Request();
        $r->parse();
        $controller = $r->controller.'Controller';
        $action = $r->action;
        
        if (class_exists($controller)) {
            $obj = new $controller($r);
            $obj->render();
        } else {
            // do default stuff;
            $obj = new UserController( new Request);
            $obj->render();
        }
    }
    
    // figure out what the request is?
    private function parse() {
        if (! empty($_REQUEST) && isset($_REQUEST['_r'])) {
            $parts = explode('/', $_REQUEST['_r']);
            if (count($parts) == 3)
                list($this->controller, $this->action, $this->id) = $parts;
            if (count($parts) == 2)
                list($this->controller, $this->action) = $parts;
            if (count($parts) == 1)
                list($this->controller) = $parts;
        }
        if(!empty($_GET)) {
           foreach($_GET as $k => $v) {
              if($k == 'controller') continue;
              if($k == 'action') continue;
              if($k == 'id') continue;
              if($k == '_r') continue;
              $this->$k = htmlentities(stripslashes($v),ENT_QUOTES, 'utf-8');
           }
        }
    }
}
