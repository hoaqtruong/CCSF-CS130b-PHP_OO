<?php
/**
 * Some SQL
 */

// Function to check if a table already exists.
if(!function_exists('table_exists')) {
    function table_exists($dbc,$table)
    {
        $sql = "SELECT name FROM sqlite_master
        WHERE type='table'
        AND name='". sqlite_escape_string($table) ."'";

        $res = $dbc->query($sql);
        if($res->numRows()) {
            return true;
        }
        return false;
    }
}

$tasks_db = 'tasks.db';
if(!defined('CREATE_TASKS_SQL')) {
    define('CREATE_TASKS_SQL', 
        "CREATE table tasks (
        id integer primary key,  -- INTEGER Primary Keys are auto increment
        parent_id integer not null,
        task text not null,
        created_at datetime not null,
        completed_at datetime default '0000-00-00 00:00:00')"
    );
}

if(!defined('CREATE_TASKS_SQL')) {
    define('CHECK_FOR_EXISTING_TASKS_TABLE_SQL',
        "SELECT name FROM sqlite_master
        WHERE type='table'
        AND name='tasks'"
);
}

if(!defined('CREATE_TASKS_SQL')) {
    define('CHECK_FOR_EXISTING_IMAGES_TABLE_SQL',
        "SELECT name FROM sqlite_master
        WHERE type='table'
        AND name='images'"
    );
}

if(!defined('CREATE_TASKS_SQL')) {
    define('CREATE_IMAGES_SQL',
        "CREATE table images (
        id integer primary key,
        name text not null,
        directory text not null,
        title text,
        url text,
        thumbnail_url text,
        created_at datetime,
        created_by text,
        caption  text)"
    );
}

/**
 * Open the database
 */
$sqlite = new SQLiteDatabase($tasks_db);

$res = @$sqlite->query(CHECK_FOR_EXISTING_TASKS_TABLE_SQL);

/* If not, create it */
if(!table_exists($sqlite,'tasks')) {
   
    @$sqlite->query(CREATE_TASKS_SQL);

    // Insert some test data.
    $sqlite->query("INSERT INTO tasks values(NULL, 0,'Feed dogs.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 0,'Watch TV.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 1,'Walk dogs.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 2,'Set up recorder to tape Project Runway.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 4,'While I''m there, borrow one of his spare 6-packs.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 4,'Borrow $400 from brother-in-law to buy shirt.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 4,'Order that Commes Des Garcons t-shirt I''ve had my eye on.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 3,'Hey, catch a few Z''s.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 3,'Drink a few brewskis.', datetime('now'),'0000-00-00 00:00:00')");
    $sqlite->query("INSERT INTO tasks values(NULL, 3,'Go look for a job when his dang hangover wears off...', datetime('now'),'0000-00-00 00:00:00')");
    $res = $sqlite->query('SELECT * FROM tasks');
}

// Create a procedural interface for those who prefer it. 
// This line is included to provide compatibility with those
// who decide to user the procedural interface.
$dbc = sqlite_open($tasks_db);