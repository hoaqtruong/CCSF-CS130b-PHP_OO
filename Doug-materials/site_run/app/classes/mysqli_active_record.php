<?php

//
// All of the code in this class is MySQLi specific.
//

// Try to keep this class and its dependencies self-contained.
if(!defined('DB_NAME')) {
	// All constant for database connection
    define('DB_NAME', 'test_mysqli'); 
	define('DB_HOST', 'localhost');
	define('DB_USR', 'root');
	define('DB_PWD', '1234');
    function table_exists($dbc,$table) {
        $sql = "SHOW CREATE TABLE ". mysqli_escape_string($table) ."'"; // I change this 

        $res = $dbc->query($sql);
        if($res->num_rows()) {  // I change this 
            return true;
        }
        return false;
    }

    define( 'CREATE_USERS_SQL',
            "create table users (
        id integer not null primary key,
        user_name text not null,
        first_name text not null,
        last_name text not null,
        email text not null,
        password text not null,
        created_at datetime not null)"
    );

    $dbc = new mysqli(DB_HOST, DB_USR, DB_PWD, DB_NAME);  // I change this 
    if(!table_exists($dbc,'users')) {
        $dbc->query(CREATE_USERS_SQL);
        // some dummy data for testing
        $dbc->query("INSERT INTO users values(NULL,'admin','Administrator','Administrator','admin@ccsf.edu','".sha1('ExtraSecret')."',datetime('now'))");
        $dbc->query("INSERT INTO users values(NULL,'test','Test','Test','test@ccsf.edu','".sha1('secret')."',datetime('now'))");
        $dbc->query("INSERT INTO users values(NULL,'doug','Douglas','Putnam','test@ccsf.edu','".sha1('secret')."',datetime('now'))");
    }
}

if(!class_exists('BASE')) {
    /**
     * The Base class provides some low level methods such as __get and __set
     * so that we can don't have to go through this hassle (did I show some
     * annoyance?) of creating these methods for other classes in our site.
     *
     * $Id: base.php,v 1.1.1.1 2008/03/11 20:52:42 somedude Exp $
     */
    class Base {
        protected $properties = array();
        function __get($name) {
            if (isset($this->properties[$name])) {
                return $this->properties[$name];
            } else {
                return null;
            }
        }
        function __set($name, $value) {
            if($name == 'password') {
                $this->properties[$name] = sha1($value);
            }
            else {
                $this->properties[$name] = $value;
            }
        }
    }
}

if(!class_exists('ActiveRecord')) {
    class ActiveRecord extends Base {
    }
}

// SQLITE Active Record class
class MySQLi_Active_Record extends Base {  // I change this 
    protected $fields = array();

    function __construct() {

        try {
            $this->dbc = new mysqli(DB_HOST, DB_USR, DB_PWD, DB_NAME);  // I change this 
        } catch(Exception $e) {
            die($e->getmessage());
        }

        // Determine table
        $this->table =  strtolower(str_replace('__','',get_class($this))) . 's';

        if(!$this->table_exists($this->dbc,$this->table)) {
            die('Database error: no table named ' . $this->table);
        }
        else {
            $sql = "PRAGMA table_info('{$this->table}')";
            $res = $this->dbc->query($sql);  // I change this 

            while($row = $res->fetch()) {
                $this->fields[] = $row['name'];
            }
        }
    }

    function table_exists($dbc,$table) {
        $sql = "SHOW CREATE TABLE ". mysqli_escape_string($table) ."'";  // I change this 

        $res = $dbc->query($sql);
        if($res->num_rows()) {
            return true;
        }
        return false;
    }
	

    /**
     * Handle virtual functions
     * @param <method> $method
     * @param <array> $args
     * @return <Sqlite_Active_Record>
     */
	 
	 // I changed all : this->dbc->query($sql,SQLITE_ASSOC); to this->dbc->query($sql); for compatible with mysqli
    function __call($method, $args) {
        if(stristr($method,'_by_page')) {
            $field = substr($str, strlen('find_'),strlen($str) - stripos($str,'_by_page'));
            if(!in_array($this->fields,$field)) return false;
            $sql = "SELECT * FROM " . $this->table ." WHERE $field = '{$args[0]}'";
            $res = $this->dbc->query($sql);

            $out = array();
            while($row = $res->fetch()) {
                $out[] = $row;
            }
        }
        elseif(stristr($method,'find_all') !== false) {
            $sql = "SELECT * FROM " . $this->table  . ' ORDER BY created_at DESC LIMIT 10' ;
            $res=$this->dbc->query($sql);
            $out = array();
            foreach($res as $row) {
                $tmp = new $this;
                foreach($this->fields as $f) {
                    $tmp->$f = $row[$f];
                }
                $out[] = $tmp;
            }
            return $out;
        }
        elseif(stristr($method,'find_by_')) {
            $field = substr($method,strlen('find_by_'));

            if($field == 'sql') {
                $res = $this->dbc->query($args[0]);
            }
            else {
                $sql = "SELECT * FROM " . $this->table ." WHERE $field = '{$args[0]}'";
                $res = $this->dbc->query($sql);
            }

            $out = array();
            while($row = $res->fetch()) {
                $tmp = new $this;
                foreach($this->fields as $f) {
                    $tmp->$f = $row[$f];
                }
                $out[] = $tmp;
            }
            if($field == 'id') return $out[0];
            return $out;
        }
    }

    function save() {
        // Manufacture CREATE or UPDATE sql
        // UPDATE
        if($this->id) {
            // This is an update
            $setpairs = array();
            foreach($this->fields as $f) {
                $setpairs[] = " $f='". $this->$f ."'";
            }
            if($this->password != $this->r->password) {
                $this->password = sha1($this->password);
            }

            $sql = 'UPDATE ' . $this->table . ' set ' .implode(',',$setpairs) . ' WHERE id = '. $this->id;
            return true;
        }


        // INSERT
        $sql = "INSERT INTO " . $this->table . "(";
        $keys = array();
        $values = array();

        foreach($this->fields as $f) {
            if($f == 'id') continue;
            $keys[] = $f;
            $values[] = mysqli_escape_string(htmlentities($this->$f));
        }

        $sql .= "id," . implode(",",$keys) . ") values(NULL, ";
        $kstring = array();
        $vstring = array();

        for($i=0;$i < count($keys); $i++ ) {
            $k = $keys[$i];
            $kstring[] = "'$k'";

            // The password needs to be encrypted with sha1();
            if($k == 'password') {
                $this->password = sha1($this->password);
            }

            if($k == 'id') {
                continue;
                $val = 'Null';
            }
            elseif($k == 'created_at' || $k == 'modified_at') {
                $val = "datetime('now')";
            }
            else {
                $val = "'" . mysqli_escape_string(htmlentities($this->$k)) . "'";
            }
            $vstring[] = $val;
        }
        $sql .= implode(',',$vstring).")";
        $this->dbc->query($sql);
        return true;
    }

    function fields() {
        return $this->fields;
    }
}

if(isset($argv) && $argv[0] == basename(__FILE__)) {
    $dbc = new mysqli(DB_HOST, DB_USR, DB_PWD, DB_NAME);
    if(!table_exists($dbc,'users')) {
        print 'Create a users table for testing.';
    }
    else {
        // A test Model for the users table
        class User extends MySQLi_Active_Record {
            function password($password) {
                $this->password = sha1($password);
            }
        }

        $t = new User;
        $u = $t->find_by_id(4);
        var_dump($u);
        exit;
        $fields = $u->fields();
        foreach($fields as $f) {
            print "$f\t{$u->$f}\n";
        }
        $t->password = 'this is top secret';
        $t->save();
    }
}

