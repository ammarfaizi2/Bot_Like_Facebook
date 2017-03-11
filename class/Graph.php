<?php
/**
* @author Ammar F. <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
* @license RedAngel PHP Concept 2017
* @package Auto Like
*/
class Graph extends Crayner_Machine{
	const GRAPH = "https://graph.facebook.com/";
	private $token;
	public function __construct($token=""){
		$this->token = urlencode($token);
	}
	protected function get_newpost($user="me"){
		$a = json_decode($this->qurl(self::GRAPH.urlencode($user)."/feed?limit=1&fields=id,message&access_token=".$this->token),true);
		if (empty($a)) {
			return false;
		}
		$rt['message'] = isset($a['data'][0]['message'])?$a['data'][0]['message']:null;
		!isset($a['data'][0]['id']) AND $rt = false OR $rt['id']=$a['data'][0]['id'];
		return $rt;
	}
}
?>