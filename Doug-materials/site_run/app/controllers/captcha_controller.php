<?php

require_once(CLASSES . 'captcha.php');

class captchaController extends ApplicationController {	
    function __construct(Request $request) {	
		$this->r = $request;
    }
	
	function yield() {
		$captcha = new captcha();
	    
	    switch($captcha->validate_submit())
	    {
	        // was submitted and has valid keys
	        case 1:
	            // PUT IN ALL YOUR STUFF HERE //
	                    echo "<p><br>Congratulation. You will get the resource now.";
	                    echo "<br><br><a href=\"index.php?_r=captcha\">New DEMO</a></p>";
	            break;


	        // was submitted with no matching keys, but has not reached the maximum try's
	        case 2:
	            echo $captcha->display_form();
	            break;


	        // was submitted, has bad keys and also reached the maximum try's
	        case 3:
	            //if(!headers_sent() && isset($captcha->badguys_url)) header('location: '.$captcha->badguys_url);
	                    echo "<p><br>Reached the maximum try's of ".$captcha->maxtry." without success!";
	                    echo "<br><br><a href=\"index.php?_r=captcha\">New DEMO</a></p>";
	            break;


	        // was not submitted, first entry
	        default:
	            echo $captcha->display_form();
	            break;

	    }
	}
}
?>