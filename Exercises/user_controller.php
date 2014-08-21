<?php

    /**
     * The User Controller
     */
    class UserController extends ApplicationController {

        function __construct($request) {
            // If we overwrite the constructor, we have to call 
            // the parent::__construct() method to set up the environment.
            parent::__construct($request);
        }
        function index() {
            $this->for_view = 'Hello from the ' . __CLASS__ . ':' . __METHOD__;
        }

        function login() {
            $this->for_view = 'Hello from the ' . __CLASS__ . ':' . __METHOD__;
        }

        function admin() {
            $u = new User;
            $fields = $u->fields();
            $this->fields = array();
            foreach($fields as $f) {
                if($f == 'id' || $f == 'created_at') continue;
                $this->fields[] = $f;
            }

            $this->users = $u->find_all();
        }

        /**
         * Register a new user
         */
        function register() {  // user/register.html
            // We'll try an exception here, just for fun.
            try {
                if(!empty($_POST)) {
                    // Create a new user object. The user.php file
                    // is in the models directory.

                    $u = new User;
                    // We have to check whether the user alredy exists.
                    $res = $u->find_by_user_name(trim($_POST['user_name']));

                    // If $res is empty, the user does not exist, so 
                    // we have to create it. We'll use the $u instance.
                    if(empty($res)) {
                        $fields = $u->fields();
                        foreach($fields as $f) {
                            // The id and created_at timestamp are auto-generated.
                            if($f == 'id') continue;
                            if($f == 'created_at') continue;
                            $u->$f = trim(htmlentities($_POST[$f],ENT_QUOTES,'utf-8'));
                        }
                        if($u->save()) {
                            // If this transaction is successful, go to the registered
                            // page and print more information.
                            header('Location: ?_r=user/registered');
                            exit;
                        }
                    }
                    else {
                        // We shouldn't every end up here, but if we do, 
                        // throw an exception.
                        throw(new Exception('User is already registered'));
                    }
                }
            } catch(Exception $e) {
                header('Location: ?_r=user/already_registered');
                exit;
            }
        }
    }

