<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BackendSystems_Model extends CI_Model{
	
	private $fcUser;

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
	}

	public function Create($lang = 'vietnamese'){
		$_post = $this->input->post('config');
		if(isset($_post) && is_array($_post) && count($_post)){
			foreach($_post as $key => $val){
				$data = NULL;
				$data['keyword'] = $key;
				$data[''.(($lang == 'vietnamese') ? 'content' : 'content2').''] = $val;
				$flag = $this->Check($key);
				if($flag == FALSE){
					$data['userid_created'] = $this->fcUser['id'];
					$data['created'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
					$this->db->insert('systems', $data);
					$result = $this->db->affected_rows();
				} else {
					$data['userid_updated'] = $this->fcUser['id'];
					$data['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
					$this->db->where(array('keyword' => $key))->update('systems', $data);
					$result = $this->db->affected_rows();
				}
			}
		}
		return $result;
	}

	public function Check($keyword = ''){
		$this->db->select('keyword');
		$this->db->from('systems');
		$this->db->where(array('keyword' => $keyword));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return (($result >= 1) ? TRUE : FALSE);
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
