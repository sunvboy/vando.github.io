<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendFunctions_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function create(){
		$data = array(
			'title' => $this->input->post('title'),
			'keyword' => slug($this->input->post('keyword')),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('functions', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0){
		$data = array(
			'title' => $this->input->post('title'),
			'keyword' => slug($this->input->post('keyword')),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array('id' => $id))->update('functions', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update_field($param = NULL, $id = 0){
		$this->db->where(array('id' => $id))->update('functions', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function countall(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' )');
		}
		$this->db->from('functions');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' )');
		}
		$this->db->from('functions');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0){
		$this->db->where(array('functions.trash' => 0));
		$this->db->select('functions.*');
		$this->db->from('functions');
		$this->db->where(array('functions.id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('functions');
		$this->db->where(array('id' => $id))->update('functions', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function CountFunctions($param = NULL){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('functions');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByField($param = NULL, $limit = 5){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('functions');
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
		$this->db->from('functions');
		$this->db->where($param['where']);
		if($param['limit'] > 0){
			$this->db->limit($param['limit'], 0);
		}
		
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		
		return $result;
	}
	
	public function Dropdown(){
		$this->db->select('*');
		$this->db->from('functions');
		$this->db->where(array('publish' => 1,'trash' => 0));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		$temp = '';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[] = $val['keyword'];
			}
		}
		return $temp;
	}
	

}