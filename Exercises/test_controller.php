<?php

    if(!defined('UNITTEST')) {
        define('UNITTEST','/users/dputnam/public_html/php/simpletest/');
    }
    require_once UNITTEST.'unit_tester.php';
    require_once UNITTEST.'reporter.php';

    // ?_r=tests/ecards
    class testsController extends ApplicationController {

        function index() {}

        function itunes() {

        }

        function users() {}

        function ecards() {
           ob_start();
           $test = &new TestOfEcards();
           $test->run(new HtmlReporter());
           $this->test_output = ob_get_clean();
        }

        function active_record()
        {
           ob_start();
           $test = &new TestSqliteDB();
           $test->run(new HtmlReporter());
           $this->test_output = ob_get_clean();
        }

        function source() {
           ob_start();
           highlight_file(__FILE__); 
           $this->source = ob_get_clean();
        }
    }

    class testSqliteDB extends UnitTestCase {
        function setUp() {
           $this->dbFile = dirname(__FILE__).'/test.sqlite';
           @unlink($this->dbFile);
           $this->ar = new SqliteDB($this->dbFile);
        }

        function testExecute() {
           $this->ar->execute("SELECT 1 as one");
        }

        function testTrue() {
           $this->assertTrue(true);
        }
        function testGetClass() {
           $this->assertIsA($this->ar,'SqliteDB', 'Testing for valid SqliteDB object'); 
        }
        function testCreateDatabase() {
           $this->ar->connect();
           $this->assertTrue(file_exists($this->dbFile), "Checking for the database");;
        }
        function testCreateTable() {
           $dbc = $this->ar->dbc;
           $dbc->query(CREATE_USERS_SQL);
           $this->assertTrue(table_exists($dbc,'users'));
        }

        function tearDown() {
           @unlink($this->dbFile);
        }
    }

    class SqliteDB {
       function __construct($db=null) {
          if($db) {
                $this->db = $db;
          }
          $this->connect();
       }
       function connect() {
          $this->dbc = new SqliteDatabase($this->db);
          return $this->dbc;
       }
       function execute($sql) {
            $this->dbc->query($sql);
       }
    }

    // Unit testing classes
    class TestOfEcards extends UnitTestCase {
        // setup() 

        function setUp() {
            // All controllers need a Request object
            $this->ecard = new EcardsController(Registry::get('request'));
            $f = @fopen('sometestfile','w');
        }

        function testCreateNewEcard() {
           $this->assertEqual('ecardsController',get_class($this->ecard));
        }

        function testForTrue() {
           $this->assertTrue(false);
        }

        // check againts a known count of 37
        function testCountOfEcards() {
           $this->ecard->setimageDir('san_francisco_days/');
           $this->assertEqual(37,count($this->ecard->readImages()));
        }

        // Clean up our mess
        function teardown() {
            // clean any files you've created, close database handles, etc.
            @unlink('sometestfile');
        }
    }

    // Singleton Pattern
    /*
    class DBConnection {
       // the special feature is that there can be only
       // one instance of this class.

       static private $dbc = null;

       private function __construct() {} 

       static public connect()
       {
          if(is_null(self::$dbc)) {
             self::$dbc = mysqli_connect('localhost','user','password','database');
          }
          return self::$dbc;
       }
    }

    $dbc = DBConnection::connect();
    $dbc1 = DBConnection::connect();
    $dbc2 = DBConnection::connect();
    $dbc3 = DBConnection::connect();
    $dbc4 = DBConnection::connect();
    $dbc10 = DBConnection::connect();
    
    class Color {
       function __construct() {
          $this->dbc = DBConnect::connect();
       }
    }
    class Red extends Cars{
       function __construct() {
          $this->dbc = DBConnect::connect();
       }
    }
    class Blue extend Fish{
       function __construct() {
          $this->dbc = DBConnect::connect();
       }
    }
    */
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

/**
 * Open the database
 */
$sqlite_db = 'cs130b.db';
$sqlite = new SQLiteDatabase($sqlite_db);

if(!table_exists($sqlite,'users')) {
    @$sqlite->query(CREATE_USERS_SQL);
    $sqlite->query("INSERT INTO users values(NULL,'admin','Administrator','Administrator','admin@ccsf.edu','".sha1('ExtraSecret')."',datetime('now'))");
    $sqlite->query("INSERT INTO users values(NULL,'test','Test','Test','test@ccsf.edu','".sha1('secret')."',datetime('now'))");
    $sqlite->query("INSERT INTO users values(NULL,'doug','Douglas','Putnam','test@ccsf.edu','".sha1('secret')."',datetime('now'))");
}
/*

$dirs = array('louise_brooks','anna_may_wong','san_francisco_days','ravens','ravens2','vinyl');
if(! table_exists($sqlite, 'images')) {
    $sqlite->query(CREATE_IMAGES_SQL);
    foreach($dirs as $d) {
    $image_dir = "/users/dputnam/public_html/images/$d";
    $url = '/~dputnam/images/'.$d;
    $dh = opendir($image_dir);
    print "Processing: $image_dir\n";
    while($f = readdir($dh)) { 
        if(is_dir($image_dir . $f)) continue;
        if(stristr($f, '.jpg') || stristr($f,'.gif') || stristr($f,'.png')) {
           print '.';
            $sqlite->query("INSERT INTO images values(NULL, '$f', '$image_dir', '".strtoupper($f)."', '$url/$f','$url/thumbs/$f',datetime('now'), 'doug putnam', 'no caption')");
        }
    }
 }
}
$res = $sqlite->query("SELECT * FROM images", SQLITE_ASSOC);
foreach($res as $image) {
  print '<img src="'.$image['thumbnail_url'].'" alt="" />';
}

$dbc = sqlite_open($sqlite_db);
if(isset($_GET['start_over']) && $_GET['start_over'] == 1) {
    include 'start_over.php';
}  
*/
