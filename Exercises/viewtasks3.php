<?php ob_start(); ?>
<h3>Current To-Do List</h3>
<?php # Script 1.3 - view_tasks.php

/*	This page shows all existing tasks.
 *	A recursive function is used to show the 
 *	tasks as nested lists, as applicable.
 */

///
///
/// Using SQLite instead of MySQL
///
///
include 'sqlite.inc';

// Function for displaying a list.
// Receives one argument: an array.
function make_list ($parent) {

	// Need the main $tasks array:
	global $tasks;

	// Start an ordered list:
	echo '<ol>';
	
	// Loop through each subarray:
	foreach ($parent as $task_id => $todo) {
		
		// Display the item:
		echo "<li>" . htmlentities(stripslashes($todo));
			
		// Check for subtasks:
		if (isset($tasks[$task_id])) { 
			
			// Call this function:
			make_list($tasks[$task_id]);
			
		}
			
		// Complete the list item:
		echo '</li>';
	
	} // End of FOREACH loop.
	
	// Close the ordered list:
	echo '</ol>';

} // End of make_list() function.


// Connect to the database:
//$dbc = @mysqli_connect ('localhost', 'root', '', 'cs130b') OR die ('<p>Could not connect to the database!</p></body></html>');

// Retrieve all the uncompleted tasks:
$q = 'SELECT id, parent_id, task 
FROM tasks 
WHERE completed_at="0000-00-00 00:00:00" 
ORDER BY parent_id, created_at ASC'; 

//$r = mysqli_query($dbc, $q);
$r = sqlite_query($dbc, $q, SQLITE_ASSOC);

// Initialize the storage array:
$tasks = array();

//while (list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)) {
while ( $row = sqlite_fetch_array($r,SQLITE_NUM)) {
    list($task_id, $parent_id, $task) = $row;
  //  $task_id = $row['id'];
   // $parent_id = $row['parent_id'];
    //$task = $row['task'];

	// Add to the array:
	$tasks[$parent_id][$task_id] =  $task;
}

// For debugging:
//echo '<pre>' . print_r($tasks,1) . '</pre>';

// Send the first array element
// to the make_list() function:

if(!empty($tasks)) {
   if(isset($tasks[0])) {
      make_list($tasks[0]);


print <<<END
<button>Toggle Array Structure</button>
<pre style="display:none;font-size:12px;">
END;
var_dump($tasks);
print '</pre>';

}
else {
   print 'Your To-Do List is empty. <a href="?start_over=1">Start over?</a>';
}
}

$content = ob_get_clean();
include 'template.inc';
include 'include.php';
?>
