<?php
$db = new SQLitedatabase('to_do.sqlite');

class tasktable {
	public $table_name = "tasks_level_0";
	public $id = null;
	public $parent_id = 0;
	public $task = "";
	public $completed_at = null;
	public $current_level = 0;
	
	function __construct($tbl_name) {
		$this->table_name = $tbl_name;
		$this->current_level = (int)substr($tbl_name,strrpos($tbl_name, "_"));
	}
	
	public function upper_level() {
		if($this->current_level != 0) {
			return $this->current_level-1;
		}
		return false;
	}
	
	public function lower_level() {
	$lower_table_name = "tasks_level_".$this->curent_level + 1;
	
	//if $lower_table_name has the first row, that means current_level has lower level
		$result = $db->query("SELECT task from {$lower_table_name} WHERE id = 1");
		if ($result == false ) {
			return false;
		} return $lower_table_name;
	}
	
	public function set_task($task) {
		$this->task = $task;
	}
	
	public function set_completed_at($datetime) {
		$this->completed_at = $datetime;
		
	}
	
	public function get_table_content() {
		$sql_result = "";		
		$sql_result = $db->query("SELECT * from " . $this->table_name);
		if ($sql_result) {
			$results = sqlite_fetch_array($sql_result);
			return $results;		
		}	
		return $results;
	}
	
	public function get_all_tasks($table_name) {
		$results = array();
		
		
		$$table_name = new tasktable($table_name);

		$tasks[$table_name] = $$table_name->table_content();
			
		$table_name = $$table_name->lower_level();
				
		while (!is_null($$table_name->lower_level())) {
			
		}
		$sql_result = $db->query("SELECT * from tasks_level_1");
		$results = sqlite_fetch_array($sql_result);
		return $results;	
	}
	
	function get_files_by_types($file_types = "jpg|gif|ppt|pdf", $recursive = true) {
	    $files = array();

	    $this->dir = rtrim($this->dir, "/") . '/';

	    $types = explode("|", strtolower($file_types));

	    $dh = opendir($this->dir) or die("Could not open $this->dir");
	    while(false !== ($f = readdir($dh))) {
	        if (strpos($f, '.') == 0) continue;
	        if (is_dir($this->dir . $f)) {
	            $files[] = get_files_by_types($dir. $f . '/', $file_types, true);
	        } else {
	            if(in_array(substr(strtolower($f), strrpos($f, ".") + 1), $types)) {
	                array_push($files, $f);
	            }
	        }
	    }
	    closedir($dh);
	    return $files;
	}
	
	
	
	
	
	
}
