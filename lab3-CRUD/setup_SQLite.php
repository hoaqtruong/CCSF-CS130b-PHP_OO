<?php
// //Create a new SQLdatabase named to_do
 $db = new SQLiteDatabase('to_do.sqlite');
// 
//Create a table

$sql1 = 'CREATE table tasks_level_1 (

   id integer primary key, --INTEGER Primary Keys  auto increment

   parent_id integer not null,

   task text not null,

   created_at datetime not null,

   completed_at datetime)';


$sql2 = 'CREATE table tasks_level_2 (

   id integer primary key, --INTEGER Primary Keys  auto increment

   parent_id integer not null,

   task text not null,

   created_at datetime not null,

   completed_at datetime)';


$sql3 = 'CREATE table tasks_level_3 (

   id integer primary key, --INTEGER Primary Keys  auto increment

   parent_id integer not null,

   task text not null,

   created_at datetime not null,

   completed_at datetime)';


@$db->query($sql1);
@$db->query($sql2);
@$db->query($sql3);

$db->query("INSERT INTO tasks_level_1 values(NULL,0,'planning for my parents'' trip', datetime('now'),null)");
$db->query("INSERT INTO tasks_level_1 values(NULL,0,'create psychology page on hoatruong.com', datetime('now'),null)");
$db->query("INSERT INTO tasks_level_1 values(NULL,0,'buying wacom cintiq 21UX', datetime('now'),null)");


// CRUD  INSERT

//$db->query("INSERT INTO tasks values(NULL,0,'this''s a test', datetime('now'),datetime('now'))");

//$res = $db->query('SELECT * FROM tasks WHERE id < 5');
 $res = $db->query('SELECT * FROM tasks_level_1 LIMIT 3, 3');
foreach($res as $r)
 {
    print $r['task'];
	echo "<br />";
 }




