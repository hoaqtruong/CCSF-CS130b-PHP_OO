<?php
require('tasktable.php');

$tasks_0 = new tasktable ("tasks_level_0");
$content = $tasks_0->table_content();
var_dump($content);


//get data from database
// static $table_name = "tasks_level_0";
// $tasks = array();
// 
// 
// 
// 
// 	
// 	do {
// 
// 			
// 			$$table_name = new tasktable($table_name);
// 
// 			$tasks[$table_name] = $$table_name->table_content();
// 			
// 			$table_name = $$table_name->lower_level();
// 
// 			for ($i=0; $i< count($tasks); $i++) {
// 		
// 				while (!is_null($$table_name->lower_level())) {
// 					
// 					$$table_name = new tasktable($table_name);
// 
// 					$tasks[$table_name] = $$table_name->table_content();
// 
// 					$table_name = $$table_name->lower_level();
// 			
// 				}
// 				break;
// 			}			
// 		
// 			
// 			for ($j=0; $j< count($tasks[$i]); $j++) {
// 				
// 					if (!is_null($$table_name->lower_level())) {
// 						
// 					}
// 					
// 					break;
// 			}
// 			
// 				if (!is_null($$table_name->lower_level())) {
// 					
// 					for ()
// 					
// 
// 					$lower_table = new tasktable($table_name);
// 					$lower_tasks = $lower_table->table_content();
// 					$tasks[$i] = $lower_tasks;					
// 						
// 
// 				} else {
// 					
// 					break;
// 				}
// 			
// 		}
// 	}
// 	 
// 
// 	
// 
// 
// 		
// 	}
// 	while (!is_null($$table_name->lower_level()))
// 	
// }
// if(!is_null($tasks_0->lower_level())) {
// 	$lower_level_table = $tasks_level_0->lower_level();
// 	$lower_level_table = new tasktable($tasks_0->lower_level());
// 	$($tasks_level_0."_content") = $$tasks_level_0->lower_level()
// }
// break;
// $tasks_level_1 = new tasktable("tasks_level_1");
// $tasks_level_1 = new tasktable("tasks_level_1");
// 
// 
// 
// if (isset($_GET['submit']) && trim($_GET['']) {
// 	$parent_id = $_GET['parent_id'];
// 	$parent_id = $_GET['parent_id'];
// }


?> -->
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>Add a Task</title>
</head>
<body>
<form action="add_task.php" method="post">
<fieldset>
<legend>Add a Task</legend>

<p>Task: <input name="task" type="text" size="60" maxlength="100" /></p>

<p>Parent Task: <select name="parent_id"><option value="0">None</option>
<option value="10">Go look</option>
<option value="1">Feed dogs.</option>
</select></p>

<input name="submitted" type="hidden" value="true" />
<input name="submit" type="submit" value="Add This Task" />

</fieldset>
</form>
<h3>Current To-Do List</h3>

<ul>
<li>Watch TV.</li>
<li>Feed dogs.</li>
<li>Walk dogs.</li>
</ul><br />

<a href="view_tasks.php">view tasks</a> 
<a href="view_tasks2.php">view tasks 2</a> 
<a href="add_task.php">add task</a> 
<a href="add_task2.php">add task 2</a> 
<br />
<a href="?rdb=1">Restore Database</a>
</body>
</html>
