<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendProjects_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($_list_id = '', $param = ''){
		$keyword = $this->input->get('keyword');
		$cataloguesid = (int)$this->input->get('cataloguesid');
		if($param['userid'] > 0){
			$this->db->where('userid_created', $param['userid']);
		}
		$userid = (int)$this->input->get('userid');
		if($userid > 0){
			$this->db->where('userid_created', $userid);
		}
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		if(isset($_list_id) && is_array($_list_id) && count($_list_id)){
			$this->db->where_in('id', $_list_id);
		}
		if($cataloguesid > 0 && empty($_list_id)){
			return 0;
		}
		if(isset($param['where']) && $param['where'] != '' ){
			$this->db->where($param['where']);
		}
		$this->db->where(array('projects.trash' => 0));
		$this->db->from('projects');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $_list_id = '', $param = ''){
		
		$this->db->select('projects.*, (SELECT fullname FROM customers WHERE customers.id = projects.userid_created) as fullname,(SELECT fullname FROM users WHERE users.id = projects.userid_updated) as fullname_update, (SELECT title FROM projects_catalogues WHERE projects.cataloguesid = projects_catalogues.id) as catalogue');
		$keyword = $this->input->get('keyword');
		$userid = (int)$this->input->get('userid');
		if($param['userid'] > 0){
			$this->db->where('userid_created', $param['userid']);
		}
		if($userid > 0){
			$this->db->where('userid_created', $userid);
		}
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		if(isset($_list_id) && is_array($_list_id) && count($_list_id)){
			$this->db->where_in('id', $_list_id);
		}
		if(isset($param['where']) && $param['where'] != '' ){
			$this->db->where($param['where']);
		}
		$this->db->where(array('projects.trash' => 0));
		$this->db->from('projects');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('projects');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = '', $catalogues = NULL, $albums = ''){
		$price = $this->input->post('price');
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => (int)$this->input->post('cataloguesid'),
			'code' => $this->input->post('code'),
			'filterid' => (int)$this->input->post('att'),
			'cityid' => (int)$this->input->post('cityid'),
			'districtid' => (int)$this->input->post('districtid'),
			'wardid' => (int)$this->input->post('wardid'),
			'projectid' => (int)$this->input->post('projectid'),
			'address' => $this->input->post('address'),
			'catalogues' => json_encode($catalogues),
			'images' => $this->input->post('images'),
			'area' => (float)$this->input->post('area'),
			'floor' => (int)$this->input->post('floor'),
			'price' => $price,
			'measure' => (int)$this->input->post('measure'),
			'type' => (int)$this->input->post('type'),
			'albums' => json_encode($albums),
			'order' => (int)$this->input->post('order'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'map' => htmlspecialchars($this->input->post('map')),
			'publish' => $this->input->post('publish'),
			'highlight' => $this->input->post('highlight'),
			'ishome' => $this->input->post('ishome'),
			'isaside' => $this->input->post('isaside'),
			'outofdate' => $this->input->post('outofdate'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('projects', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0, $user = '',  $catalogues = NULL, $albums){
		$price = $this->input->post('price');
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => (int)$this->input->post('cataloguesid'),
			'code' => $this->input->post('code'),
			'filterid' => (int)$this->input->post('att'),
			'cityid' => (int)$this->input->post('cityid'),
			'districtid' => (int)$this->input->post('districtid'),
			'wardid' => (int)$this->input->post('wardid'),
			'projectid' => (int)$this->input->post('projectid'),
			'address' => $this->input->post('address'),
			'catalogues' => json_encode($catalogues),
			'images' => $this->input->post('images'),
			'area' => (float)$this->input->post('area'),
			'floor' => (int)$this->input->post('floor'),
			'price' => $price,
			'measure' => (int)$this->input->post('measure'),
			'type' => (int)$this->input->post('type'),
			'albums' => json_encode($albums),
			'order' => (int)$this->input->post('order'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'map' => htmlspecialchars($this->input->post('map')),
			'publish' => $this->input->post('publish'),
			'highlight' => $this->input->post('highlight'),
			'ishome' => $this->input->post('ishome'),
			'isaside' => $this->input->post('isaside'),
			'outofdate' => $this->input->post('outofdate'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('projects', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('projects', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('projects', array('canonical' => '', 'trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	public function delete_attribute($id = 0){
		$this->db->where(array('projectsid' => $id));
		$this->db->delete('attributes_relationship');
	}
	
	public function Dropdown(){
		$this->db->select('id, title');
		$this->db->from('projects');
		$this->db->where(array(
			'publish' => 1,
			'trash' => 0,
		));
		$this->db->order_by('title asc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		$temp = '';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[$val['id']] = $val['title'];
			}
		}
		return $temp;
	}
	
	public function location_dropdown($param = '', $root = true){
		$this->db->select('*');
		$this->db->from('province');
		if(isset($param['where'])){
			$this->db->where($param['where']);
		}
		$this->db->order_by('order desc, title asc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		if($root == true){
			$_listDropdown[0] = '[ Chọn địa chỉ ]';
		}
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$_listDropdown[$val['id']] = $val['title'];
			}
		}
		return $_listDropdown;
	}
	
	public function read_location($id = 0){
		$this->db->select('*');
		$this->db->from('province');
		$this->db->where('id', $id);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result['title'];
	}
	public function read_place($id = 0){
		$this->db->select('*');
		$this->db->from('places');
		$this->db->where('id', $id);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result['title'];
	}
}
