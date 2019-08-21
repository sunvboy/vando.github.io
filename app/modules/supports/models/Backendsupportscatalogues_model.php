<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendSupportsCatalogues_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function countall(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('supports_catalogues');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->where(array('supports_catalogues.trash' => 0));
		$this->db->select('supports_catalogues.*, (SELECT COUNT(supports.id) FROM supports WHERE supports.cataloguesid = supports_catalogues.id) as count_supports');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('supports_catalogues');
		$this->db->order_by('created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('supports_catalogues');
		$this->db->where(array('id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function readcat($id = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('supports_catalogues');
		$this->db->where(array('id' => $id))->limit(1, 0);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function create(){
		$data = array(
			'title' => $this->input->post('title'),
			'address' => $this->input->post('address'),
			'hotline' => $this->input->post('hotline'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('supports_catalogues', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0){
		$data = array(
			'title' => $this->input->post('title'),
			'address' => $this->input->post('address'),
			'hotline' => $this->input->post('hotline'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array('id' => $id))->update('supports_catalogues', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function dropdown(){
		$this->db->where(array('trash' => 0));
		$result = $this->db->select('id, title')->from('supports_catalogues')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = '- Chọn nhóm hỗ trợ trực tuyến -';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}

	public function delete($id = 0){
		// $this->db->where(array('id' => $id))->delete('supports_catalogues');
		$this->db->where(array('id' => $id))->update('supports_catalogues', array('trash' => 1));
		$result = $this->db->affected_rows();
		// $this->db->where(array('receiverid' => $id))->delete('supports');
		$this->db->where(array('cataloguesid' => $id))->update('supports', array('trash' => 1));
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadByCondition($param = '', $flag = FALSE){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? (int)$param['limit'] : 0);
		
		
		$this->db->select($param['select']);
		$this->db->from('supports_catalogues');
		$this->db->where($param['where']);
		if($param['limit'] > 0){
			$this->db->limit($param['limit'], 0);
		}
		
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		
		return $result;
	}
	

}
