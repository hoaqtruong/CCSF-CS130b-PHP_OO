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
			if(!empty($_POST)) {
								  
				$u = new User;
				// check whether the user alredy exists.
				$res = $u->find_by_user_name(trim($_POST['user_name']));

				// If $res is empty, the user does not exist, so 
				// we have to create it. We'll use the $u instance.
				if(empty($res)) {                       
					header('Location: ?_r=user/register');
					exit;
				}
				else {					
					$u = $res[0];
					
					if (sha1(sha1($_POST['password'])) === $u->password)  {
						setcookie('php_lab_status', 'login');
						setcookie('php_lab_passwd', $u->password);
						setcookie('php_lab_first_name', $u->first_name);
						setcookie('php_lab_last_name', $u->last_name);
						setcookie('php_lab_full_name', $u->first_name . ' ' . $u->last_name);
						setcookie('php_lab_email', $u->email);
						setcookie('php_lab_user_name', $u->user_name);
						
						header('Location: http://www.hoatruong.com/');
						exit;
					}
				}
			}           
        }
		
		function logout() {
            setcookie('php_lab_status', '');
			setcookie('php_lab_passwd', '');
			setcookie('php_lab_first_name', '');
			setcookie('php_lab_last_name', '');
			setcookie('php_lab_full_name', '');
			setcookie('php_lab_email', '');
			setcookie('php_lab_user_name', '');
			
			header('Location: ');
			exit;
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

    }
