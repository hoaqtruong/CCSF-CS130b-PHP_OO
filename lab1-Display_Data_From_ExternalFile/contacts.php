<?php

error_reporting(E_ALL);

// Load data from contact.txt
$field_names = array("name", "height", "weight", "age", "address", "city", "state", "phone", "email");
$data = parse_ini_file("contact.txt", true);
$contact_info = array();

//compile an associate array[fname][attributes]
for ($i = 1; $i <= 3; $i++) {
	$name = ""; $pos =""; $fname ="";	$d = array();

	$name = $data["name".$i]['fields'.$i][0];
	$pos = strpos($name, " ");
	$fname = strtolower(substr($name, 0, $pos));

	for ($j = 0; $j < count($field_names); $j++) {
		$key = $field_names[$j];
		$value = $data["name".$i]['fields'.$i][$j];
		if ($key == "height") {
			$value = str_replace("-", "'", $value). '"';
		}
		if ($key == "weight") {
			$value = str_replace("lb", " lb", $value);
		}
		$d[$key] = $value;
	}
	$contact_info[$fname] = $d;	
}

class ContactInfo {
	private $fname="", $name="", $height="", $weight="", $age="", $address="", $city="", $state="", $phone="", $email="";
	function __construct($name, $height, $weight, $age, $address, $city, $state, $phone, $email) {
		$this->name = $name;
		$this->height = $height;
		$this->weight = $weight;
		$this->age = $age;
		$this->address = $address;
		$this->city = $city;
		$this->state = $state;
		$this->phone = $phone;
		$this->email = $email;		
	}
	public function get_name() {
		return $this->name;
	}
	public function get_height() {
		return $this->height;
	}
	public function get_weight() {
		return $this->weight;
	}
	public function get_age() {
		return $this->age;
	}
	public function get_address() {
		return $this->address;
	}
	public function get_city() {
		return $this->city;
	}
	public function get_state() {
		return $this->state;
	}
	public function get_phone() {
		return $this->phone;
	}
	public function get_email() {
		return $this->email;
	}
	
	public function display_info() {
		echo "<table>";
		echo '<caption><em>Contact</em></caption>';
		echo '<tr><th>Name:</th><td>'. $this->get_name() .'</td></tr>';
		echo '<tr><th>Height:</th><td>'. $this->get_height() .'</td></tr>';
		echo '<tr><th>Weight:</th><td>'. $this->get_weight() .'</td></tr>';
		echo '<tr><th>Age:</th><td>'. $this->get_age() .'</td></tr>';
		echo '<tr><th>Address:</th><td>'. $this->get_address() .'</td></tr>';
		echo '<tr><th>City:</th><td>'. $this->get_city() .'</td></tr>';
		echo '<tr><th>state:</th><td>'. $this->get_state() .'</td></tr>';
		echo '<tr><th>Phone:</th><td>'. $this->get_phone() .'</td></tr>';
		echo '<tr><th>Email:</th><td>'. $this->get_email() .'</td></tr>';		
		echo "</table><br />";
	}
	

}
//loop through $contact_info in order to create new ContactInfo object 
$contact_obj_array = array();

foreach($contact_info as $key => $value){
	
	$$key = new ContactInfo( $value['name'], $value['weight'], $value['height'], $value['age'], $value['address'], $value['city'], $value['state'], $value['phone'], $value['email']); 

	$contact_obj_array[] = $$key;
}
//display each ContactInfo obj through a loop
foreach($contact_obj_array as $v) {
	echo $v->display_info();
}
