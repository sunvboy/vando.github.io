<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BackendSlidesGroups_Model extends CI_Model{

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
		$this->db->from('slides_groups');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $lang = 'vietnamese'){
		$this->db->where(array('slides_groups.trash' => 0));
		$this->db->select('slides_groups.*, (SELECT COUNT(slides.image) FROM slides WHERE slides.groupsid = slides_groups.id AND slides.trash = 0 AND slides.alanguage = \''.$lang.'\') as count_slides, (SELECT fullname FROM users WHERE users.id = slides_groups.userid_created) as user_created, (SELECT fullname FROM users WHERE users.id = slides_groups.userid_updated) as user_updated');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('slides_groups');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('slides_groups');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'href' => $this->input->post('href'),
			'keyword' => $this->input->post('keyword'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
		);
		$this->db->insert('slides_groups', $data);
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
			'keyword' => $this->input->post('keyword'),
			'href' => $this->input->post('href'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('slides_groups', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('slides_groups', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('slides_groups', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->where(array('groupsid' => $id))->update('slides', array('trash' => 1));
		$this->db->flush_cache();
		return $result;
	}

}
