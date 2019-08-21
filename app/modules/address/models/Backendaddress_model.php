<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendAddress_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function create($user = '', $lang = 'vietnamese'){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'size' => $this->input->post('size'),
			'attachs' => $this->input->post('attachs'),
			'type' =>  $this->input->post('type'),
			'typeoff' =>  $this->input->post('typeoff'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'alanguage' => $lang,
			'userid_created' => $user['id'],
		);
		$this->db->insert('address', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0, $user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'size' => $this->input->post('size'),
			'attachs' => $this->input->post('attachs'),
			'type' =>  $this->input->post('type'),
			'typeoff' =>  $this->input->post('typeoff'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id']
		);
		$this->db->where(array('id' => $id))->update('address', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update_field($param = NULL, $id = 0){
		$this->db->where(array('id' => $id))->update('address', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function countall($lang = 'vietnamese', $typeoff = 0){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang, 'typeoff' => $typeoff));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR message LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('address');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0, $lang = 'vietnamese', $typeoff = 0){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang, 'typeoff' => $typeoff));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR message LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('address');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0, $lang = 'vietnamese'){
		$this->db->where(array('address.trash' => 0, 'address.alanguage' => $lang));
		$this->db->select('address.*');
		$this->db->from('address');
		$this->db->where(array('address.id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function delete($id = 0){
		$this->db->where(array('id' => $id))->delete('address');
		// $this->db->where(array('id' => $id))->update('address', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function CountMessage($param = NULL){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('address');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByField($param = NULL, $limit = 5){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('address');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadByCondition($param = '', $flag = FALSE){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? (int)$param['limit'] : 0);
		
		
		$this->db->select($param['select']);
		$this->db->from('address');
		$this->db->where($param['where']);
		if($param['limit'] > 0){
			$this->db->limit($param['limit'], 0);
		}
		
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		
		return $result;
	}
	
	public function Dropdown($type = 0){
		$this->db->where(array('trash' => 0,'publish'=>1, 'type' => $type));
		$result = $this->db->select('id, title')->from('address')->order_by('title ASC')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = NULL;
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}
	
}