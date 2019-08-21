<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BackendSlides_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$groupsid = $this->input->get('groupsid');
		if($groupsid > 0){
			$this->db->where(array('groupsid' => $groupsid));
		}
		$this->db->from('slides');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $lang = 'vietnamese'){
		$this->db->where(array('slides.trash' => 0, 'slides.alanguage' => $lang));
		$this->db->select('slides.*');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$groupsid = $this->input->get('groupsid');
		if($groupsid > 0){
			$this->db->where(array('groupsid' => $groupsid));
		}
		$this->db->from('slides');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function CountByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0));
		$this->db->from('slides');
		$this->db->where(array($field => $value));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0,  $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang));
		$this->db->from('slides');
		$this->db->where(array($field => $value));
		$this->db->order_by('order DESC, created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($param = null, $groupsid = 0, $lang = 'vietnamese'){
		$data = array(
			'title' => $param['title'],
			'url' => $param['url'],
			'description' => $param['description'],
			'image' => $param['image'],
			'order' => $param['order'],
			'groupsid' => $groupsid,
			'publish' => 1,
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'alanguage' => $lang,
		);
		$this->db->insert('slides', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0){
		$data = array(
			'title' => $param['title'],
			'url' => $this->input->post('url'),
			'description' => $this->input->post('description'),
			'image' => $this->input->post('image'),
			'order' => $this->input->post('order'),
			'groupsid' => $this->input->post('groupsid'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array($field => $value))->update('slides', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('slides', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0, $lang = 'vietnamese'){
		// $this->db->where(array($field => $value))->update('slides', array('trash' => 1));
		$this->db->delete('slides', array($field => $value, 'alanguage' => $lang));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

}
