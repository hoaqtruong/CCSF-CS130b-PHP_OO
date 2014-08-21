<?php
class Predecessor {
    const NAME = 'Predecessor';
    function __construct() 
    {
        print "In " . self::NAME . " constructor.\n";
    }
}


// OOP FEATURES
// Encapsulation
// Inheritance  ***
//   gets the methods and the public and protected attributes
// Polymorphism
 
class Descendent extends Predecessor {
    const NAME = 'Descendent';
    function __construct()
    {
        parent::__construct();
        print "In " . self::NAME . " constructor.";
    }
}
$desc = new Descendent();
?>

