<?php
header('content-type:text/json'); flush();
define("data",getcwd().DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR);
is_dir(data) OR mkdir(data);
header("content-type:text/plain");
require "class/Crayner_Machine.php";
require "class/Graph.php";
include "class/tools/WhiteHat/Teacrypt.php";
use tools\WhiteHat\Teacrypt;
$z = new Graph("EAAAACZAVC6ygBAGzAoxL5wGLkTgr2dPBdaFFZBKu8KbAiKZCSryER3uFpbCnLrvNb5imHsgLLqM3CsTGByNMZB8ZAh0qI2ETviBHBEXDbM2kFDFrt9swgD1mj3ZAhQqbSXj4P9d4Fm09Vx7OwYyqOzJiAaHccQ0UwbFGdIPV4fewZDZD");
// me
$name = "ammarfaizi2";
$data['list_token']=file_exists(data."list_token.txt")?explode("*",file_get_contents(data."list_token.txt")):array();
if (!file_exists(data.$name."_info.json")) {
	file_put_contents(data.$name."_info.json",$z->get_userinfo("me","id,first_name,last_name",true));
}
$data['userinfo']=json_decode(file_get_contents(data.$name."_info.json"),true);
$data['current_post']=file_exists(data.$name."_last_post.json")?json_decode(file_get_contents(data.$name."_last_post.json"),true):array("message"=>null,"id"=>null);
$data['new_post']=$z->get_newpost();
if ($data['current_post']['id']!=$data['new_post']['id']) {
	foreach ($data['list_token'] as $q) {
		$act['self_post'][]=$z->do_like($data['new_post']['id'],$q);
	}
	file_put_contents(data.$name."_last_post.json",json_encode($data['new_post']));
} else {
	$act['self_post']=false;
}flush();
// out like
!file_exists(data.$name."_target_like.txt") AND file_put_contents(data.$name."_target_like.txt","") AND $data['target_like']=array() OR $data['target_like']=explode("\n",file_get_contents(data.$name."_target_like.txt"));
!file_exists(data.$name."_target_like_data.json") AND $data['target_like_data']=array() OR $data['target_like_data']=json_decode(file_get_contents(data.$name."_target_like_data.json"),true);
foreach ($data['target_like'] as $q) {
	$data['new_target'][$q] = $z->get_newpost($q);
	if (!isset($data['target_like_data'][$q]['id']) OR $data['new_target'][$q]['id']!=$data['target_like_data'][$q]['id']) {
		$act['do_like'][$q]=$z->do_like($data['new_target'][$q]['id']);
		$data['target_like_data'][$q]=$data['new_target'][$q];
	}
}
file_put_contents(data.$name."_target_like_data.json",json_encode($data['target_like_data']));
print_r(json_encode($act));
flush();
exit();
?>