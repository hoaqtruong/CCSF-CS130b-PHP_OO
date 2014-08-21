#!/opt/php/bin/php

<?php

include('setup.inc');

//FUNCTION--------------------------

$dir = SITE_ROOT;


function write_file($file_name, $dir) {
	
	if(file_exists($dir.$file_name)) {
	
		  $message = $dir.$file_name . " already exists. Do you want to overwrite it [Y/N]";
		  	      print $message;
		  	      flush();
		  	      ob_flush();
		  	      $confirmation = trim( fgets( STDIN ) );
	  	
		      if ( $confirmation !== 'y' ) {
		      	break;
		      }
	
	} else {
	  		
		fwrite($dir.$file_name);
	}
	
}

//--------------------------
// mkdir -p app/{models,classes,config,controllers,views,views/layouts}

if(file_exists(SITE_ROOT. 'generate')) {
	chmod(SITE_ROOT. 'generate', 755);
}
$arguments = array();



if (isset($_SERVER['argv'])) {
	$arguments = $_SERVER['argv'];
	var_dump ($arguments);


	// foreach ($argument as $f) {
	// 	
	// 	// if (strpos($f, "models_" !== FALSE)) {
	// 	// 				
	// 	// }
	// 	
	// 	write_file($f, $d);
	// 	
	// 	
	// 
	// 
	// 
	// 
	// }

}