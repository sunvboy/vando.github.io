<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendNavigationsMenus_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($lang = 'vietnamese'){
		$this->db->select('navigations_menus.id');
		$this->db->from('navigations_menus');

		$this->db->join('navigations_positions', 'navigations_menus.positionsid = navigations_positions.id');

		$keyword = $this->input->get('keyword');
		$this->db->where(array('navigations_menus.alanguage' => $lang, 'navigations_positions.publish' => 1));
		
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(navigations_menus.title LIKE \'%'.$keyword.'%\')');
		}
		$positionsid = $this->input->get('positionsid');
		if($positionsid > 0){
			$this->db->where(array('navigations_menus.positionsid' => $positionsid));
		}

		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($lang = 'vietnamese'){

		$this->db->select('navigations_menus.*, (SELECT COUNT(a.id) FROM navigations_menus as a WHERE navigations_menus.id = a.parentid) as count_menus_items, (SELECT fullname FROM users WHERE users.id = navigations_menus.userid_created) as fullname, (SELECT title FROM navigations_positions WHERE navigations_positions.id = navigations_menus.positionsid) as positions');

		$this->db->join('navigations_positions', 'navigations_menus.positionsid = navigations_positions.id');

		$this->db->where(array('navigations_menus.alanguage' => $lang, 'navigations_positions.publish' => 1));
		$keyword = $this->input->get('keyword');
		// $this->db->where(array('parentid' => $start));
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(navigations_menus.title LIKE \'%'.$keyword.'%\')');
		}
		$positionsid = $this->input->get('positionsid');
		if($positionsid > 0){
			$this->db->where(array('navigations_menus.positionsid' => $positionsid));
		}
		$this->db->from('navigations_menus');
		$this->db->order_by('navigations_menus.order ASC, navigations_menus.created DESC');
		// $this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->from('navigations_menus');
		$this->db->where(array($field => $value, 'alanguage' => $lang))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = '', $lang = 'vietnamese'){
		$data = array(
			'title' => $this->input->post('title'),
			'parentid' => $this->input->post('parentid'),
			'href' => $this->input->post('href'),
			'positionsid' => $this->input->post('positionsid'),
			'order' => $this->input->post('order'),
			'modules' => $this->input->post('modules'),
			'modulesid' => (int)$this->input->post('modulesid'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
			'description' => $this->input->post('description'),
			'alanguage' => $lang,
		);
		$this->db->insert('navigations_menus', $data);
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
			'href' => $this->input->post('href'),
			'parentid' => $this->input->post('parentid'),
			'positionsid' => $this->input->post('positionsid'),
			'order' => $this->input->post('order'),
			'modules' => $this->input->post('modules'),
			'modulesid' => (int)$this->input->post('modulesid'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'description' => $this->input->post('description'),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('navigations_menus', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('navigations_menus', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->delete('navigations_menus');
		// if($field == 'id'){
		// 	$this->db->where(array('menusid' => $value))->delete('navigations_menus_items');
		// }
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function Dropdown(){
		$this->db->where(array('publish' => 1));
		$result = $this->db->select('id, title')->from('navigations_menus')->order_by('order ASC, title asc')->get()->result_array();
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
