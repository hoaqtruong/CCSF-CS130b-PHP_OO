<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
    
        <title>Test Suite</title>
        <style type="text/css" media="screen">
            .failure {margin-top:.5em;padding:1em;background-color:white;color:black;border:solid 1px red; }
            #unit-tests h1 { font-size: 20px; color: white;background:navy;padding:.5em;}
        </style>
    </head>
    <body>
        <h1>Test Driven Development Exercise</h1>
        <p>

        <ol>
            <li>Write a test that fails (red).</li>
            <li>Write the minimum code needed to pass the test (green).</li>
            <li>Repeat</li>
        </ol>
        </p>
        <div id="unit-tests">
<?php
    require 'setup.inc'; 
    require_once SIMPLETEST.'unit_tester.php';
    require_once SIMPLETEST.'reporter.php';

//    class Request2 {
//        function parse() {
//            $this->controller = 'users';
//        }
//    }

    class TestEntireCodeBase extends UnitTestCase {

        function __construct() {
            $this->UnitTestCase('Running Test Suite');
        }

        function setup() {
            // _r is the key to the controller/action/id value
            $_REQUEST['_r'] = 'users/show/99';
            $this->r = new Request2();
        }

        function teardown() {
        }

        function testRequest2Class() {
            $this->assertIsa(new Request2(),'Request2');
            $this->assertIsa($this->r,'Request2');
        }

        function testRequest2Controller() {
            $this->assertTrue(empty($this->r->controller), 'Expected to see ""');
        }
        function testRequest2Parse() {
            $this->r->parse();
            $this->assertEqual('users',$this->r->controller,'Expected to see "users"');
            $this->assertEqual('show',$this->r->action,'Expected to see "show"'.':'.$this->r->action);
            $this->assertEqual(99,(int)$this->r->id,'Expected to see "show"'.':'.$this->r->id);
        }
    }

    $test = new TestEntireCodeBase('Testing Entire MVC Code Base');
    $test->run(new HTMLReporter());
?>
</div>
    </body>
</html>
