<?php
class Database
{
    // Store the single instance of Database

    private static $sqlite;

    private function __construct() {}

    public static function getConnection($filename){

        if (!self::$sqlite) {
 
           self::$sqlite = new SQLiteDatabase($filename);

        }//end if

        return self::$sqlite;

    }//end function getConnection()

}//end class Database

$sqlite = Database::getConnection("data.sql"); 