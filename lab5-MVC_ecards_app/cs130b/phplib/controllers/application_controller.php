<?php
class ApplicationController {
    
    public $layout = '';
    protected $out = '';
    
    function __construct($request) {
        $this->r = $request;
    }
    
    function render() {
        $this->controller = $this->r->controller;
        $this->action = $this->r->action;
        $this->id = $this->r->id;
        
        if (file_exists(VIEWS.$this->controller.'/'.$this->action.'.html')) {
            if (method_exists($this->controller.'Controller', $this->action)) {
                $action = $this->action;
                $this->$action();
            }
            ob_start();
            include (VIEWS.$this->controller.'/'.$this->action.'.html');
            $this->out = ob_get_clean();
        } else {
            // handle error
        }
        if (file_exists(LAYOUTS.$this->r->controller.'.html')) {
            include LAYOUTS.$this->r->controller.'.html';
        } elseif (file_exists(LAYOUTS.'default.html')) {
            include LAYOUTS.'default.html';
        } else {
            print $this->out;
        }
    
    }
    function yield() {
        print $this->out;
    }
}

