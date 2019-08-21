<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendArticles_Model extends FC_Model{

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
		
		$this->db->from('articles');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0, $_list_id = '', $param = '', $lang = 'vietnamese'){
		$this->db->where(array('articles.trash' => 0, 'articles.alanguage' => $lang));
		$this->db->select('articles.*, (SELECT fullname FROM users WHERE users.id = articles.userid_created) as fullname,(SELECT fullname FROM users WHERE users.id = articles.userid_updated) as fullname_update, (SELECT title FROM articles_catalogues WHERE articles.cataloguesid = articles_catalogues.id) as catalogue');
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
		$this->db->from('articles');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0));
		$this->db->from('articles');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($user = '', $catalogues = NULL, $albums = '', $data_date = '', $lang = 'vietnamese'){
		$created = $this->input->post('created');
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'catalogues' => json_encode($catalogues),
			'images' => $this->input->post('images'),
			'albums' => json_encode($albums),
			'event' => $this->input->post('event'),
			'date' => json_encode($data_date),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'content2' => $this->input->post('content2'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'publish' => $this->input->post('publish'),
			'highlight' => $this->input->post('highlight'),
			'isaside' => $this->input->post('isaside'),
			'isfooter' => $this->input->post('isfooter'),
			'date_start' => $this->input->post('date_start'),
			'time_start' => $this->input->post('time_start'),
			'supportid' => $this->input->post('supportid'),
			'address' => $this->input->post('address'),
			'created' => ((!empty($created)) ? $created : gmdate('Y-m-d H:i:s', time() + 7*3600)),
			'userid_created' => $user['id'],
			'alanguage' => $lang,
		);
		$this->db->insert('articles', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0, $user = '',  $catalogues = NULL, $albums = '', $data_date = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'catalogues' => json_encode($catalogues),
			'images' => $this->input->post('images'),
			'albums' => json_encode($albums),
			'event' => $this->input->post('event'),
			'date' => json_encode($data_date),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'content2' => $this->input->post('content2'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description'),
			'highlight' => $this->input->post('highlight'),
			'isaside' => $this->input->post('isaside'),
			'isfooter' => $this->input->post('isfooter'),
			'date_start' => $this->input->post('date_start'),
			'time_start' => $this->input->post('time_start'),
			'supportid' => $this->input->post('supportid'),
			'address' => $this->input->post('address'),
			'publish' => $this->input->post('publish'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_updated' => $user['id'],
		);
		$this->db->where(array($field => $value))->update('articles', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('articles', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('articles', array('canonical' => '', 'trash' => 1));
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
					'articlesid' => $id,
					'title' => $slide['title'][$key],
					'images' => $slide['images'][$key],
					'description' => $slide['description'][$key],
					'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				);
			}
			if(isset($data) && is_array($data) && count($data)){
				$result = $this->db->insert_batch('articles_photos', $data); 
				$this->db->flush_cache();
				return $result;
			}
		}
	}

	public function ReadPhotos($id = 0){
		$data = NULL;
		$this->db->select('*');
		$this->db->from('articles_photos');
		$this->db->where(array('articlesid' => $id));
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
		$this->db->where(array('articlesid' => $id))->delete('articles_photos');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByModule($id = 0, $colunm = 'id'){
		$data = NULL;
		$this->db->where(array('trash' => 0, 'publish' => 1, 'id' => $id));
		$this->db->select($colunm);
		$this->db->from('articles');
		$result = $this->db->get()->row_array();

		if(isset($result) && is_array($result) && count($result)){

			foreach($result as $key => $val){
				if ($key != $colunm && $val = '') continue;
				$data = json_decode($val, TRUE);
			}
		}
		$this->db->flush_cache();
		// print_r($data);die;
		return $data;
	}
}
