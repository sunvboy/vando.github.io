<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendNavigationsPositions_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('navigations_positions');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $lang = 'vietnamese'){
		$this->db->where(array('navigations_positions.trash' => 0));
		$this->db->select('navigations_positions.*, (SELECT COUNT(navigations_menus.id) FROM navigations_menus WHERE navigations_menus.positionsid = navigations_positions.id AND navigations_menus.alanguage = \''.$lang.'\') as count_navigations');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('navigations_positions');
		$this->db->order_by('id ASC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('navigations_positions');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function CountByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('navigations_positions');
		$this->db->where(array($field => $value));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'canonical' => slug($this->input->post('canonical')),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('navigations_positions', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0, $user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'canonical' => slug($this->input->post('canonical')),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('navigations_positions', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('navigations_positions', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('navigations_positions', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->where(array('parentid' => $id))->update('navigations', array('trash' => 1));
		$this->db->flush_cache();
		return $result;
	}

	public function Dropdown(){
		$this->db->where(array('trash' => 0, 'publish' => 1));
		$result = $this->db->select('id, title')->from('navigations_positions')->order_by('order ASC, title asc')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = '- Chọn Vị Trí -';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}

}
