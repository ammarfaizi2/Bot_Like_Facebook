<?php
/**
* @author Ammar F. <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
* @license RedAngel PHP Concept 2017
* @package Auto Like
*/
class Graph extends Crayner_Machine
{
	const GRAPH = "https://graph.facebook.com/";
	private $token;
	public function __construct($token=""){
		$this->token = urlencode($token);
	}
	/**
	*	@param string
	*	@return string
	*/
	public function get_userinfo($user="me",$get=null,$json=false){
		$a = $json===true?$this->qurl(self::GRAPH.urlencode($user)."/?fields=".($get===null?"id":$get)."&access_token=".$this->token):json_decode($this->qurl(self::GRAPH.urlencode($user)."/?fields=".($get===null?"id":$get)."&access_token=".$this->token),true);
		return $get===null?(empty($a)?false:$a['id']):$a;
	}
	/**
	*	@param string
	*	@return mixed
	*/
	public function get_newpost($user="me",$fields=null){
		$a = json_decode($this->qurl(self::GRAPH.urlencode($user)."/feed?limit=1&fields=".($fields!==null?$fields:"id,message")."&access_token=".$this->token),true);
		if (empty($a)) {
			return false;
		}
		if ($fields===null) {
			$rt['message'] = isset($a['data'][0]['message'])?$a['data'][0]['message']:null;
		}
		if (isset($a['data'][0]['id'])) {
			$a['data'][0]['id'] = explode("_",$a['data'][0]['id']);
			$rt['id'] = end($a['data'][0]['id']);
		} else {
			$rt = false;
		}
		return $rt;
	}
	/**
	*	@param mixed,string
	*	@return mixed
	*/
	public function do_like($id,$token=null){
		$token = $token===null?$this->token:$token;
		if (is_array($id)) {
			foreach ($id as $val) {
				$rt[]=$this->qurl(self::GRAPH.$val."/likes?method=post&access_token=".$token);
			}
		} else {
			$rt = $this->qurl(self::GRAPH.$id."/likes?method=post&access_token=".$token);
		}
		return $rt;
	}
}
?>