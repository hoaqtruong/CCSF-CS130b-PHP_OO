<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>Add a Task</title>
</head>
<body>
<?php # Script 1.6 - add_task.php

/*	This page adds tasks to the tasks table.
 *	The page both displays and handles the form.
 *	
 */
 
// Connect to the database:
   include 'sqlite.inc';
//$dbc = @mysqli_connect ('localhost', 'root', '', 'cs130b') OR die ('<p>Could not connect to the database!</p></body></html>');

// Check if the form has been submitted:
if (isset($_POST['submitted']) && !empty($_POST['task'])) {

	// Sanctify the input...
	
	// The parent_id must be an integer:
	if (isset($_POST['parent_id'])) {
		$parent_id = (int) $_POST['parent_id'];
	} else {
		$parent_id = 0;
	}
	
	// Add the task to the database.
	$q = sprintf("INSERT INTO tasks (id,parent_id, task, created_at) VALUES (NULL,%d, '%s',datetime('now'))", $parent_id, sqlite_escape_string(htmlentities(stripslashes($_POST['task']),ENT_QUOTES,'UTF-8'))); 
	//$r = mysqli_query($dbc, $q);
	$r = $sqlite->query($q);
	
	// Report on the results:
	if ($sqlite->changes() == 1) {
		echo '<p>The task has been added!</p>';
	} else {
		echo '<p>The task could not be added!</p>';
	}

} // End of submission IF.

// Display the form:
echo '<form action="add_task2.php" method="post">
<fieldset>
<legend>Add a Task</legend>

<p>Task: <input name="task" type="text" size="60" maxlength="100" /></p>

<p>Parent Task: <select name="parent_id"><option value="0">None</option>
';

// Retrieve all the uncompleted tasks:
$q = 'SELECT id, parent_id, task FROM tasks WHERE completed_at="0000-00-00 00:00:00" ORDER BY created_at ASC'; 
//$r = mysqli_query($dbc, $q);
	$r = $sqlite->query($q);
//while (list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)) {
    foreach($r as $row) {
       $task_id = $row['id'];
       $parent_id = $row['parent_id'];
       $task = $row['task'];

	// Add to the select menu:
	echo "<option value=\"$task_id\">$task</option>\n";
	
}

echo '</select></p>

<input name="submitted" type="hidden" value="true" />
<input name="submit" type="submit" value="Add This Task" />

</fieldset>
</form>
';
include 'include.php';
?>
</body>
</html>
