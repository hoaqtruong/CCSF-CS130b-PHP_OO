<?php
error_reporting(E_ALL);
$students_array = array(
'dputnam:*:4185:208:douglas putnam,,,:/users/dputnam:/usr/bin/bash',
'bauyeung:*:20825:580:bauyeung:/students/bauyeung:/usr/bin/bash',
'dchen25:*:20917:580:dchen25:/students/dchen25:/usr/bin/bash',
'kwu19:*:20955:580:kwu19:/students/kwu19:/usr/bin/bash',
'adatta:*:21432:580:adatta:/students/adatta:/usr/bin/bash',
'htruong3:*:20269:578:htruong3:/students/htruong3:/usr/bin/ksh',
'wlam:*:26021:552:wlam:/students/wlam:/usr/bin/bash',
'mcheng11:*:23578:579:mcheng11:/students/mcheng11:/usr/bin/bash',
'mbeltra3:*:24589:571:mbeltra3:/students/mbeltra3:/usr/bin/bash',
'fxie:*:24839:555:fxie,,,:/students/fxie:/usr/bin/bash',
'etolpygo:*:25985:577:etolpygo:/students/etolpygo:/usr/bin/bash',
'jyu55:*:25932:579:jyu55:/students/jyu55:/usr/bin/bash',
'stilton:*:26046:579:stilton:/students/stilton:/usr/bin/bash',
'mschultz:*:24760:576:mschultz:/students/mschultz:/usr/bin/bash',
'dspitzer:*:25579:568:dspitzer:/students/dspitzer:/usr/bin/bash',
'ekim4:*:26579:574:ekim4:/students/ekim4:/usr/bin/bash',
'kfujisak:*:23767:570:kfujisak:/students/kfujisak:/usr/bin/bash',
'avoss:*:22727:577:avoss:/students/avoss:/usr/bin/bash',
'wdour:*:23903:570:wdour:/students/wdour:/usr/bin/bash',
'ecaruso1:*:27282:573:ecaruso1:/students/ecaruso1:/usr/bin/bash',
'asantani:*:27838:579:asantani:/students/asantani:/usr/bin/bash',
'mmir:*:24301:580:mmir:/students/mmir:/usr/bin/bash',
'jyip10:*:25035:579:jyip10:/students/jyip10:/usr/bin/bash',
'vlequang:*:29125:579:vlequang:/students/vlequang:/usr/bin/bash',
'sdell:*:23540:579:sdell:/students/sdell:/usr/bin/bash',
'jcash:*:25802:580:jcash:/students/jcash:/usr/bin/bash',
'mdixon4:*:25857:580:mdixon4:/students/mdixon4:/usr/bin/bash',
'apatter3:*:28898:579:apatter3:/students/apatter3:/usr/bin/ksh',
'jfaria:*:24280:580:jfaria:/students/jfaria:/usr/bin/bash',
'dmak3:*:24821:573:dmak3:/students/dmak3:/usr/bin/bash',
'dkeesey:*:26252:580:dkeesey:/students/dkeesey:/usr/bin/bash'
);

//Create a Student class with seven attributes: user_name, password, user_id, group_id, user_information, home_directory, and shell.

class Student {
	public $user_name;
	public $password;
	public $user_id;
	public $group_id;
	public $user_information;
	public $home_directory;
	public $shell;
	function __construct($user_name, $password, $user_id, $group_id, $user_information, $home_directory, $shell) {
		$this->user_name = $user_name;
		$this->password = $password;
		$this->user_id = $user_id;
		$this->group_id = $group_id;
		$this->user_information = $user_information;
		$this->home_directory = $home_directory;
		$this->shell = $shell;
	}
}

//Using the $students_array, for each class member extract seven values by splitting the line into 7 elements and use each element to populate the attributes of each Student instance.
//Collect the Students instances into an array.
$attributes = array("user_name", "password", "user_id", "group_id", "user_information", "home_directory", "shell");
$students = array();
foreach ($students_array as $v) {
	$student_info = explode(':', $v);
	$name = $student_info[0];
	$$name = new Student ($student_info[0],$student_info[1],$student_info[2],$student_info[3],$student_info[4],$student_info[5],$student_info[6]);
	$students[] = $$name;
}


//Using foreach, print all of the attributes of each Student instance in an HTML table, something like this example: http://hills.ccsf.edu/~dputnam/cs130b/students.php

$output = '<table style="margin:auto;">';
$output .= '<caption style="font-size:300%;">Students.php</caption>';
$output .= "<tr>";
	foreach ($attributes as $a) {
		$output .= '<th style="padding : 0.2em 0.3em; border: 1px solid gray">' . $a . "</th>";
	}
$output .= "</tr>";
	foreach ($students as $s) {

		$output .= "<tr>";
		foreach ($attributes as $att) {
			$output .= '<td style="padding : 0.2em 0.3em; border: 1px solid gray">';
			$output .= $s->$att;
			$output .= "</td>";
		}
		$output .= "</tr>";
	}
$output .= "</table>";

echo $output;
//Put your script into your HILLS php/cs130b directory so that it will be visible online at: http://hills.ccsf.edu/~yourname/cs130b/students.php
