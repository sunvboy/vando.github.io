<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendSystems_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
	}

	public function ReadAll($lang = 'vietnamese'){
		$this->db->select('*');
		$this->db->from('systems');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		$temp = NULL;

		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[$val['keyword']] = (($lang == 'vietnamese') ? $val['content'] : $val['content2']);			
			}
		}
		return $temp;
	}
}
