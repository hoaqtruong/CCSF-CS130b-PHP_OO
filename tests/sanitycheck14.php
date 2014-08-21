<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sanity Check 14</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="Hoa" content="QuizWeek14">
	<!-- Date: 2010-04-30 -->
</head>
<body>
	
	
	<?php

	$level = 0; 
	$char_data = "";
	$d = array();
	$tagName = "";
	$count_item = 0;

	// create the XML parser handler 
	$xml = xml_parser_create('UTF-8'); 

	// set handlers 
	xml_set_element_handler($xml, 'start_handler', 'end_handler'); 
	xml_set_character_data_handler($xml, 'char_data_handler'); 


	/* 
	* handler for start tags 
	*/ 
		function start_handler($xml, $tag, $attributes) { 
			global $level;  global $tagName; global $count_item;

				/* Save tag name for later use as key of tag value when runing function char_data_handler() */
					 $tagName = $tag;

				/* Count # of item to put each item in an subarray of $d */
					if ($tag == "ITEM") {
						$count_item++;
					}

				/* Get attributes of the current tag if needed*/ 
					// foreach($attributes as $key => $value) { 
					// 	print " $key='$value'"; 
					// } 

			/* increase indentation level */ 
			$level++; 
		}

		function end_handler($xml, $tag) { 
			global $level; global $tagName;

			/* empty $tagName at closing tag */ 
			$tagName = Null;

			/* decrease indentation level */ 
			$level--; 

		}


		function char_data_handler($xml, $data) { 
			global $tagName; global $d; global $count_item;

			if (trim($data) != "") {
				$d[$count_item][strtolower($tagName)] = $data;
			}

		} 

		// parse the whole file in one run 
		xml_parse($xml, file_get_contents('vinyl.xml'));
		// echo "<pre>";
		// print_r($d);
		// echo "</pre>";

		/* PRINT TABLE */


		$output = '<table style="background-color: #F3EFE0; border: 3px solid #B1B1B1;" >';
		$output .= '<caption style="font-size: 30px; font-weight: bold; color: #660033;border-bottom: 4px dotted #D6BF86; " >Vinyl</caption>';
		$output .= "<tr>";
		foreach ($d[1] as $title => $value) {
			if ($title != "item" && $title != "") {
				$output .= '<th style="border: 1px solid #D6BF86; color: #587058; padding: 5px; background-color: #D5E1DD" >'.$title."</th>";			
			}
		}
		$output .= "</tr>";
		for ($i = 1; $i <= count($d); $i++) {
		$output .= "<tr>";		
			foreach ($d[$i] as $v) {
				if ($v != "item" && $v != "") {
					$output .= '<td style="border: 1px solid #D6BF86; color: #666666; padding: 5px; background-color: DEE0D5;" >'.$v."</td>";
				}

			}
		$output .= "</tr>";
		}
		
		$output .= "</table>";

	echo $output;
		?>

</body>
</html>








