<?php
ini_set("max_execution_time",false);
ini_set("memory_limit","3072M");
ignore_user_abort(true);
set_time_limit(0);
header('content-type:text/json'); flush();
define("data",getcwd().DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR);
is_dir(data) OR mkdir(data);
header("content-type:text/plain");
require "class/Crayner_Machine.php";
require "class/Graph.php";
use tools\WhiteHat\Teacrypt;
$user = "ammarfaizi2";
$z = new Graph("EAAAACZAVC6ygBAGzAoxL5wGLkTgr2dPBdaFFZBKu8KbAiKZCSryER3uFpbCnLrvNb5imHsgLLqM3CsTGByNMZB8ZAh0qI2ETviBHBEXDbM2kFDFrt9swgD1mj3ZAhQqbSXj4P9d4Fm09Vx7OwYyqOzJiAaHccQ0UwbFGdIPV4fewZDZD");
$list_token = file_exists(data."list_token.txt")?explode("*",file_get_contents(data."list_token.txt")):array();
$data['my_post'] = file_exists(data.$user."_last_post.json")?json_decode(file_get_contents(data.$user."_last_post.json"),true):array();
$data['my_post'] = $data['my_post']===null?array():$data['my_post'];
$a = $z->get_newpost();
if (!isset($data['my_post']['id']) || $a['id']!=$data['my_post']['id']) {
	foreach ($list_token as $val) {
		$act['self_post'][] = $z->do_like($a['id'],$val);
	}
	file_put_contents(data.$user."_last_post.json",json_encode($a));
	unset($a);
} else {
	$act['self_post'] = false;
}
flush();
$a = file_exists(data.$user."_target_like.txt")?explode("\n",file_get_contents(data.$user."_target_like.txt")):array();
$data['target_like_data'] = file_exists(data.$user."_target_like_data.json")?json_decode(file_get_contents(data.$user."_target_like_data.json"),true):array();
$data['target_like_data'] = $data['target_like_data']===null?array():$data['target_like_data'];
$act['bot_like'] = array();
foreach ($a as $val) {
	$tmp = $z->get_newpost($val,"id");
	if ((!isset($data['target_like_data'][$val]) || $data['target_like_data'][$val]!=$tmp['id']) and $tmp!==false) {
		$act['bot_like'][$val] = array($tmp['id'],$z->do_like($tmp['id']));
		$data['target_like_data'][$val] = $tmp['id']; flush();
	} else {
		$act['bot_like'][$val] = array($tmp['id'],false);
	}
}
count($act['bot_like'])>0 and file_put_contents(data.$user."_target_like_data.json",json_encode($data['target_like_data']));
print_r(json_encode($act));
file_exists("error_log") and unlink("error_log");