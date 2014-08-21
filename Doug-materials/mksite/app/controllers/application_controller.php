<?php
   class ApplicationController {

      function __construct(Request $request) {
         $this->r = $request;

      }

      function render() {

         // Our convention is to execute the action before including the action HTML file.
         // For convenience
          
         $action_file = VIEWS.strtolower($this->r->controller) . '/' . $this->r->action . '.html';
         $action_method  = $this->r->action;
         $layout = LAYOUTS.strtolower($this->r->controller).'.html';
         
         // check for action  page
         if(file_exists($action_file)) {

             // Run the action if possible
             if(method_exists($this,$action_method)) {
                 $this->$action_method();
             }

             // Capture the View in a variable.
             ob_start();
             include VIEWS .strtolower($this->r->controller) . '/' . $this->r->action .'.html';
             $this->content = ob_get_clean();
             
             // Check for a controller specific layout.
             if(file_exists(LAYOUTS.strtolower($this->r->controller).'.html')) {
                include LAYOUTS .strtolower($this->r->controller) . '.html';
             }
             // Or use the default layout.
             elseif(file_exists(LAYOUTS.'default.html')) {
                include LAYOUTS .'default.html';
             }
             // If no default layout exists, print the content
             else {
                print $this->content;
             }
         }
         else {
             ob_start();
             include VIEWS . 'default/error404.html';
             $this->content = ob_get_clean();
             include LAYOUTS . 'default.html';
         }
      }
      
      /**
       * yield() prints the content in the VIEW
       */
      function yield() {
          print $this->content;
      }

   }
