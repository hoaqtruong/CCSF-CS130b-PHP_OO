<?php
   error_reporting(E_ALL);
   class ContactInfo {
         private $name = "";
         private $height = "";
         private $weight = "";
         private $age = "";
         private $address = "";
         private $city = "";
         private $state = "";
         private $telephone = "";
         private $email = "";

         // Semi magic functions
         function __set($name,$value) {
            $this->$name = $value;
         }

         // Reflection or Introspection
         function __get($name) {
            $vars = get_class_vars(__CLASS__);
            if(isset($vars[$name])) {
               return ucwords($this->$name);
            }
            return false;
         }
         function __tostring() {
            return 'I am a contactinfo object';
         }
   }
//   $c = new ContactInfo;
//   $c->name = 'Joe';
   /*
   $c->setName('Joe');
   print $c->getName();
   */
 //  print $c->name;


   $data = parse_ini_file('names.txt');

   $fields = array('name','height','weight','age','address','city','state','telephone','email');
   $contacts = array();

   foreach($data as $d) { 
      $o = new ContactInfo;
      foreach($fields as $f) {
         $o->$f = array_shift($d);
      }
      $contacts[] = $o;
   }

   $rows = '';
   foreach($contacts as $c) {
      $rows .= '<tr>';
      foreach($fields as $f) {
         $rows .= '<td>'. $c->$f. '</td>';
      }
      $rows .= '</tr>'."\n";
   }
?>
<html>
   <head><title>Contact Info Class</head>
   <body>
      <table border="1" cellpadding="4">
         <?php echo $rows;?>
      </table>
   </body>
</html>
