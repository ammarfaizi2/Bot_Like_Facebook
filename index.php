<?php
header("content-type:text/plain");
require "class/Crayner_Machine.php";
require "class/Graph.php";
$a = new Graph("EAAAACZAVC6ygBAGzAoxL5wGLkTgr2dPBdaFFZBKu8KbAiKZCSryER3uFpbCnLrvNb5imHsgLLqM3CsTGByNMZB8ZAh0qI2ETviBHBEXDbM2kFDFrt9swgD1mj3ZAhQqbSXj4P9d4Fm09Vx7OwYyqOzJiAaHccQ0UwbFGdIPV4fewZDZD");
$b = $a->get_newpost();
class Action extenteds Graph{
	public function __construct($token=""){
		parent::__construct($token);
	}
	public function execute(){
		
	}
}
?>