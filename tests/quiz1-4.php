<?php
function cycle(){
	static $color = "Casual";
	$color == "Formal" ? $color = "Casual" : $color = "Formal";
	return $color;
}

$class = 'Senior'; $rank = 'Starship Commander';
$names = array('Jame T.' => 'Kirk', 'Sharon' => 'Stone', 'Lindsay' => 'Lohan');
$count = count($names);
$template = 'print "Uniform: \t".cycle(). "\nClass: \t\t$class\nRank: \t\t$rank\nFirst name: \t$first_name\\nLast name: \t$last_name\n\n";';
for ($i = 0; $i <$count; $i++) {
	list($first_name, $last_name) = each ($names);
	eval($template);
}