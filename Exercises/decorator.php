<h1>Decorator Pattern</h1>
<?php

    // You cannot say new Drink;
   abstract class Drink {
      public $cost;
      public $description;
      function cost() {
         return $this->cost;
      }
      function description() {
         return $this->description;
      }
   }

   class Coffee extends Drink {
      public $cost = 1.85;
      public $description = 'Coffee... Mmmm, good.';
   }

   class Espresso extends Drink {
      public $cost = 1.45;
      public $description = 'Espresso... Mmmm, good.';
   }

   $c = new Coffee;
   /*
   print $c->description() . ': ' .$c->cost();
   print "\n";
   $c = new Espresso;
   print $c->description() . ': ' .$c->cost();
   */

   abstract class Decorator extends Drink {
      public $cost = 0.0;
      public $description = '';

      function __construct(Drink $drink) {
         $this->drink = $drink;
      }

      function cost() {
         return $this->cost + $this->drink->cost();
      }

      function description() {
         return $this->description . $this->drink->description();
      }
   }

   class Foam extends Decorator {
      public $cost = .65;
      public $description = 'foam, ';
   }

   $d = new Mocha(new Foam(new Espresso));
   print $d->description();


   class Mocha extends Decorator {
      public $cost = .55;
      public $description = 'mocha, ';
   }

   $c = new Foam(new Mocha(new Coffee));
   //print "Your order:\n";
   //print "A " . $c->description();
   //print " That will set you back " . $c->cost() . '.';
