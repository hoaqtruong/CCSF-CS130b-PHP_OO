<h3>Current To-do List (ver. 2)</h3>
<?php # Script 1.5 - view_tasks2.php

   ob_start();
/*	This page shows all existing tasks.
 *	A recursive function is used to show the 
 *	tasks as nested lists, as applicable.
 *	Tasks can now be marked as completed.
 */

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
		// Start with a checkbox!
        $todo = htmlentities(stripslashes($todo),ENT_QUOTES, 'utf-8');
		echo <<<EOT
<li><input type="checkbox" name="tasks[$task_id]" value="done" /> $todo
EOT;
			
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
include 'sqlite.inc';
//$dbc = @mysqli_connect ('localhost', 'root', '', 'cs130b') OR die ('<p>Could not connect to the database!</p></body></html>');

// Check if the form has been submitted:
if (isset($_POST['submitted']) && isset($_POST['tasks']) && is_array($_POST['tasks'])) {

	// Define the query:
	$q = "UPDATE tasks SET completed_at=datetime('now') WHERE id IN (";
	
	// Add each task ID:
	foreach ($_POST['tasks'] as $task_id => $v) {
		$q .= $task_id . ', ';
	}
	
	// Complete the query and execute:
	$q = substr($q, 0, -2) . ')';
	$r = $sqlite->query($q);

	// Report on the results:
	//if (mysqli_affected_rows($dbc) == count($_POST['tasks'])) {
	if ($sqlite->changes() == count($_POST['tasks'])) {
		echo '<p>The task(s) have been marked as completed!</p>';
	} else {
		echo '<p>Not all tasks could be marked as completed!</p>';
	}

} // End of submission IF.

// Retrieve all the uncompleted tasks:
$q = 'SELECT * FROM tasks WHERE completed_at="0000-00-00 00:00:00" ORDER BY parent_id, created_at ASC'; 
$r = $sqlite->query($q,SQLITE_ASSOC);

// Initialize the storage array:
$tasks = array();
$all = array();

//while (list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)) {
   foreach($r as $row) {
      $all[] = $row;
      extract($row);
      $task_id = $id;


	// Add to the array:
	$tasks[$parent_id][$task_id] =  $task;

}

// Send the first array element
// to the make_list() function:
if(!empty($tasks)) {
    if(isset($tasks[0])) {
// Make a form:
echo '<p>Check the box next to a task and click "Update" to mark a task as completed (it, and any subtasks, will no longer appear in this list).</p>
<form action="view_tasks2.php" method="post">
';

        make_list($tasks[0]);

// Complete the form:
        echo '<input name="submitted" type="hidden" value="true" />
<input name="submit" type="submit" value="Update" />
</form>
';

        print <<<END
<button>Toggle Array Structure</button>
<pre style="display:none;font-size:12px;">
END;
        var_dump($tasks);
        print '</pre>';
    }
    else {
       print 'Your To-Do List is empty.';
    }
}
$content = ob_get_clean();
include('template.inc');
include('include.php');

?>
