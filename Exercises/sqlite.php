<?php

   $sql = 'CREATE table tasks (

      id integer primary key, --INTEGER Primary Keys  auto increment

      parent_id integer not null,

      task text not null,

      created_at datetime not null,

      completed_at datetime)';


  $db = new SQLiteDatabase('thisisatest.sqlite');

  // Create the table 
  @$db->query($sql);
  // CRUD  INSERT
  $db->query("INSERT INTO tasks values(NULL,0,'this''s a test', datetime('now'),datetime('now'))");

  //$res = $db->query('SELECT * FROM tasks WHERE id < 5');
  $res = $db->query('SELECT * FROM tasks LIMIT 3, 3');

  foreach($res as $r)
  {
     print $r['created_at'];
  }

