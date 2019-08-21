<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendGallerys_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll($_list_id = '', $param = '', $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang));
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
		
		$this->db->from('gallerys');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $_list_id = '', $param = '', $lang = 'vietnamese'){
		$this->db->where(array('gallerys.trash' => 0, 'gallerys.alanguage' => $lang));
		$this->db->select('gallerys.*, (SELECT fullname FROM users WHERE users.id = gallerys.userid_created) as fullname,(SELECT fullname FROM users WHERE users.id = gallerys.userid_updated) as fullname_update, (SELECT title FROM gallerys_catalogues WHERE gallerys.cataloguesid = gallerys_catalogues.id) as catalogue');
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
		$this->db->from('gallerys');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'alanguage' => $lang));
		$this->db->from('gallerys');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = '', $catalogues = NULL, $albums = NULL, $lang = 'vietnamese'){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'catalogues' => json_encode($catalogues),
			'images' => $this->input->post('images'),
			'albums' => json_encode($albums),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'highlight' => $this->input->post('highlight'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],
			'alanguage' => $lang,
		);
		$this->db->insert('gallerys', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0, $user = '',  $catalogues = NULL, $albums = NULL){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'catalogues' => json_encode($catalogues),
			'images' => $this->input->post('images'),
			'albums' => json_encode($albums),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'highlight' => $this->input->post('highlight'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('gallerys', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('gallerys', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('gallerys', array('canonical' => '', 'trash' => 1));
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
					'gallerysid' => $id,
					'title' => $slide['title'][$key],
					'images' => $slide['images'][$key],
					'description' => $slide['description'][$key],
					'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				);
			}
			if(isset($data) && is_array($data) && count($data)){
				$result = $this->db->insert_batch('gallerys_photos', $data); 
				$this->db->flush_cache();
				return $result;
			}
		}
	}

	public function ReadPhotos($id = 0){
		$data = NULL;
		$this->db->select('*');
		$this->db->from('gallerys_photos');
		$this->db->where(array('gallerysid' => $id));
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
		$this->db->where(array('gallerysid' => $id))->delete('gallerys_photos');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
}
