<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendLichhoc_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($lang = 'vietnamese'){
		$this->db->where(array('alanguage' => $lang));
		$keyword = $this->input->get('keyword');
		$cataloguesid = (int)$this->input->get('cataloguesid');

		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		
		$this->db->from('lichhoc_time');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $lang = 'vietnamese'){
		$this->db->where(array('lichhoc_time.alanguage' => $lang));
		$this->db->select('lichhoc_time.*, (SELECT fullname FROM users WHERE users.id = lichhoc_time.userid_created) as fullname,(SELECT fullname FROM users WHERE users.id = lichhoc_time.userid_updated) as fullname_update, (SELECT title FROM lichhoc_date WHERE lichhoc_time.cataloguesid = lichhoc_date.id) as catalogue');
		$keyword = $this->input->get('keyword');

		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}

		$this->db->from('lichhoc_time');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('alanguage' => $lang));
		$this->db->from('lichhoc_time');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = '', $lang = 'vietnamese'){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'time' => $this->input->post('time'),
			'content' => $this->input->post('content'),
			'phone' => $this->input->post('phone'),
			'price' => $this->input->post('price'),
			'address' => $this->input->post('address'),
			'date' => $this->input->post('date'),
			'publish' => $this->input->post('publish'),
			'ishome' => $this->input->post('ishome'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
			'alanguage' => $lang,
		);
		$this->db->insert('lichhoc_time', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0, $user = '',  $catalogues = NULL){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'time' => $this->input->post('time'),
			'content' => $this->input->post('content'),
			'phone' => $this->input->post('phone'),
			'price' => (int)$this->input->post('price'),
			'address' => $this->input->post('address'),
			'date' => $this->input->post('date'),
			'publish' => $this->input->post('publish'),
			'ishome' => $this->input->post('ishome'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('lichhoc_time', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('lichhoc_time', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('lichhoc_time', array('canonical' => '', 'trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function InsertPhotos($id = 0){
		$slide = $this->input->post('slide');
		if(isset($slide['images']) && is_array($slide['images']) && count($slide['images'])){
			$data = NULL;
			foreach($slide['images'] as $key => $val){
				if(empty($slide['images'][$key])) continue;
				$data[] = array(
					'lichhoc_timeid' => $id,
					'title' => $slide['title'][$key],
					'images' => $slide['images'][$key],
					'description' => $slide['description'][$key],
					'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				);
			}
			if(isset($data) && is_array($data) && count($data)){
				$result = $this->db->insert_batch('lichhoc_time_photos', $data); 
				$this->db->flush_cache();
				return $result;
			}
		}
	}

	public function ReadPhotos($id = 0){
		$data = NULL;
		$this->db->select('*');
		$this->db->from('lichhoc_time_photos');
		$this->db->where(array('lichhoc_timeid' => $id));
		$result = $this->db->get()->result_array();
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$data[] = $val;
			}
		}
		$this->db->flush_cache();
		return $data;
	}

	public function DeletePhotos($id = 0){
		$this->db->where(array('lichhoc_timeid' => $id))->delete('lichhoc_time_photos');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
}
