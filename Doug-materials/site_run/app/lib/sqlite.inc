<?php
/**
 * Some SQL
 */

/**
 the shutup operator
 if(! $dbc = @sqlite_open('/etc/database.db')) {
 die('Oops. My bad! Come back tomorrow.');
 }

 */

function table_exists($dbc,$table) {
    $sql = "SELECT name FROM sqlite_master
    WHERE type='table'
    AND name='". sqlite_escape_string($table) ."'";

    $res = $dbc->query($sql);
    if($res->numRows()) {
        return true;
    }
    return false;
}

/**
 * Open the database
 */
$sqlite_db = 'cs130b.db';
$sqlite = new SQLiteDatabase($sqlite_db);

// Example of inserts
/*
if(!table_exists($sqlite,'users')) {
    @$sqlite->query(CREATE_USERS_SQL);
    $sqlite->query("INSERT INTO users values(NULL,'admin','Administrator','Administrator','admin@ccsf.edu','".sha1('ExtraSecret')."',datetime('now'))");
    $sqlite->query("INSERT INTO users values(NULL,'test','Test','Test','test@ccsf.edu','".sha1('secret')."',datetime('now'))");
    $sqlite->query("INSERT INTO users values(NULL,'doug','Douglas','Putnam','test@ccsf.edu','".sha1('secret')."',datetime('now'))");
}
*/
