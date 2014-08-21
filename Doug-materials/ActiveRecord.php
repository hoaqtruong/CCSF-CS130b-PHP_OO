<?php
    /**
     * Notes:
     *    Depends on Base and ActiveRecord, which are included in this file.
     *    See example at bottom of file for usage.
     */


     // SETUP
// {{{1
// Define a database if not defined as DB_FILE.
if(!defined('DB_FILE')) {
    define('DB_FILE',dirname(__FILE__).'/sqlite.db');
}

// Create the database functions and active record class
// if they are missing
if(!function_exists('table_exists')) {
    function table_exists($dbc,$table) {

        $sql = "SELECT * FROM sqlite_master
                WHERE type='table'
                AND name='". sqlite_escape_string(strtolower($table)) ."'";

        $res = $dbc->query($sql);
        if($res->numRows()) {
            return true;
        }
        return false;
    }
}

// Define functions and class dependencies
if(!class_exists('BASE')) {
    /**
     * The Base class provides some low level methods such as __get and __set
     * and runs sha1() when the password is set.
     *
     * NOTE:
     *   Variables should be protected visibility. Otherwise these
     *   methods will not be invoked.
     */
    class Base {

        function __get($name) {
            if (isset($this->$name)) {
                return $this->$name;
            } else {
                return null;
            }
        }

        function __set($name, $value) {
            // Look for the password being updated.
            if($name == 'password') {
                $this->set_password($value);
            }
            else {
                $this->$name = $value;
            }
        }

        function set_password($value) {
            $this->password = sha1($value);
        }
    }
}
if(!class_exists('ActiveRecord')) {
    // The ActiveRecord class contains a utility function.
    class ActiveRecord extends Base {
        static function table_exists($dbc,$table) {
            $sql = "SELECT * FROM sqlite_master
                    WHERE type='table'
                    AND name='". sqlite_escape_string($table) ."'";

            $res = $dbc->query($sql);
            if($res->numRows()) {
                return true;
            }
            return false;
        }
    }
}

// SQLite_Active_Record Class
class SQLite_Active_Record extends ActiveRecord {

    protected $fields = array();
    protected $dbc;
    protected $table;
    protected $password;

    // The constructor is specific to the SQLite database.
    function __construct() {
        $this->dbc = new SQLiteDatabase(DB_FILE);
        $this->table = strtolower(get_class($this)) . 's';

        if(!table_exists($this->dbc,$this->table)) {
            die('Database error: no table named ' . $this->table);
        }
        else {
            $sql = "PRAGMA table_info('{$this->table}')";
            $res = $this->dbc->query($sql,SQLITE_ASSOC);

            while($row = $res->fetch()) {
                $this->fields[] = $row['name'];
            }
        }
    }

    function __call($method, $args) {
        $more = '';
        if(!empty($args)) {
            $more = $args[0];
        }
        // Not a valid field in table

        if(stristr($method,'_by_page')) {
            $field = substr($str, strlen('find_'),strlen($str) - stripos($str,'_by_page'));
            $sql = "SELECT * FROM " . $this->table    . ' ORDER BY created_at DESC LIMIT 10' ;
        }
        elseif(stristr($method,'find_all') !== false) {
            if(!$more) $more = ' ORDER BY created_at DESC LIMIT 10';
            $sql = "SELECT * FROM " . $this->table ;
            $res=$this->dbc->query($sql, SQLITE_ASSOC);
            $out = array();
            foreach($res as $row) {
                $tmp = new $this;
                foreach($this->fields as $f) {
                    $tmp->$f = $row[$f];
                }
                $out[] = $tmp;
            }
        }
        elseif(stristr($method,'find_by_')) {
            $field = substr($method,strlen('find_by_'));

            // Abandon bogus requests.
            if(!in_array($field,$this->fields)) return false;

            if($field == 'sql') {
                $res = $this->dbc->query($args[0],SQLITE_ASSOC);
            }
            else {
                $sql = "SELECT * FROM " . $this->table ." WHERE $field = '{$args[0]}'";
                $res = $this->dbc->query($sql,SQLITE_ASSOC);
            }

            $out = array();
            while($row = $res->fetch()) {
                $tmp = new $this;
                foreach($this->fields as $f) {
                    $tmp->$f = $row[$f];
                }
                $out[] = $tmp;
            }
        }
        return $out;
    }

    function save() {
        // CREATE OR UPDATE
        if($this->id) {
            // This is an update
            $setpairs = array();
            foreach($this->fields as $f) {
                $setpairs[] = " $f='". $this->$f ."'";
            }

            $sql = 'UPDATE ' . $this->table . ' set ' .implode(',',$setpairs) . ' WHERE id = '. $this->id;
            $this->dbc->query($sql);
            return;
        }

        $sql = "INSERT INTO " . $this->table . "(";
        $keys = array();
        $values = array();

        foreach($this->fields as $f) {
            if($f == 'id') continue;
            $keys[] = $f;
            $values[] = SQLITE_ESCAPE_STRING(htmlentities($this->$f));
        }

        $sql .= "id," . implode(",",$keys) . ") values(NULL, ";
        $kstring = array();
        $vstring = array();
        for($i=0;
        $i < count($keys);
        $i++ ) {
            $k = $keys[$i];
            $kstring[] = "'$k'";
            if($k == 'id') {
                continue;
                $val = 'Null';
            }
            elseif($k == 'created_at') {
                $val = "datetime('now')";
            }
            else {
                $val = "'" . SQLITE_ESCAPE_STRING(htmlentities($this->$k)) . "'";
            }
            $vstring[] = $val;
        }
        $sql .= implode(',',$vstring).")";
        $this->dbc->query($sql);
        return true;
    }

    function delete() {
        $sql = 'DELETE FROM '. $this->table . ' WHERE id = ' . $this->id;
        print 'Deleting . ' .$this->user_name . "\n";
        $this->dbc->query($sql);
    }

    protected function fields() {
        return $this->fields;
    }
}

// SQLITE Active Record class tests.
// These tests are to be run on the command line. This
// code will be ignored otherwise.

if($argv[0] == basename(__FILE__)) {
    class User extends SQLITE_ACTIVE_RECORD {
    }
    $t = new User();

    $u = $t->find_all();
    $count = 0;
    foreach($u as $user) {
        $user->password = substr($user->password,0,8) . $count;
        $user->first_name = 'joe';
        $user->save();
        $user->delete();
        $count += 1;
    }

    class Exam extends SQLITE_ACTIVE_RECORD {
    }
}

