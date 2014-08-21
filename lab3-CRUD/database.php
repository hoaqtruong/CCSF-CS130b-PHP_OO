<?php
require_once("initialize.php");

class SQLiteDatabase {
	
	global $database;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	
  function __construct() {
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
  }


	
	public function escape_value( $value ) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	// "database-neutral" methods
  public function fetch_array($result_set) {
    return sqlite_fetch_array($result_set);
  }
  
  public function num_rows($result_set) {
   return sqlite_num_rows($result_set);
  }
  
  public function insert_id() {
    // get the last id inserted over the current db connection
    return sqlite_last_insert_rowid($database);
  }

  // public function field_name() {
  //   // get the last id inserted over the current db connection
  //   return sqlite_field_name($database);
  // }
  // 
  // public function get_column() {
  //   // get the last id inserted over the current db connection
  //   return sqlite_column($database);
  // }

	private function confirm_query($result) {
		if (!$result) {
	    $output = "Database query failed: " . sqlite_error_string(sqlite_last_error($database)) . "<br /><br />";
	    //$output .= "Last SQL query: " . $this->last_query;
	    die( $output );
		}
	}
	
	//CRUD functions

	
}

//$database = new SQLiteDatabase();
//$db =& $database;

?>