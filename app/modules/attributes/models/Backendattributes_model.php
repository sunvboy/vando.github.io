<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendAttributes_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		$cataloguesid = $this->input->get('cataloguesid');
		if($cataloguesid > 0){
			$this->db->where(array('cataloguesid' => $cataloguesid));
		}
		$this->db->from('attributes');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('attributes.trash' => 0));
		$this->db->select('*, (SELECT title FROM attributes_catalogues WHERE attributes_catalogues.id = attributes.cataloguesid) as attributes_catalogues_title');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\' OR content LIKE \'%'.$keyword.'%\')');
		}
		$cataloguesid = $this->input->get('cataloguesid');
		if($cataloguesid > 0){
			$this->db->where(array('cataloguesid' => $cataloguesid));
		}
		$this->db->from('attributes');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('attributes');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create(){
		$created = $this->input->post('created');
		$temp = explode('-', $created);
		$date = explode('/', trim($temp[1]));
		$created = $date[2].'-'.$date[1].'-'.$date[0].' '.trim($temp[0]).':00';
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'order' => $this->input->post('order'),
			'images' => $this->input->post('images'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'highlight' => $this->input->post('highlight'),
			'created' => $created,
		);
		$this->db->insert('attributes', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0){
		$created = $this->input->post('created');
		$temp = explode('-', $created);
		$date = explode('/', trim($temp[1]));
		$created = $date[2].'-'.$date[1].'-'.$date[0].' '.trim($temp[0]).':00';
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'cataloguesid' => $this->input->post('cataloguesid'),
			'order' => $this->input->post('order'),
			'images' => $this->input->post('images'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'highlight' => $this->input->post('highlight'),
			'created' => $created,
		);
		$this->db->where(array($field => $value))->update('attributes', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('attributes', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('attributes', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function InsertAttr($productsid = 0, $attr = ''){
		$temp = '';
		if(isset($attr) && is_array($attr) && count($attr)){
			foreach($attr as $key => $val){
				$temp[] = array(
					'productsid' => $productsid,
					'attrid' => $val,
				);
			}
		}
		if(isset($temp) && is_array($temp) && count($temp)){
			$this->db->insert_batch('attributes_relationship', $temp);
		}
	}

	public function DeleteAttr($productsid = 0){
		$this->db->where(array('productsid' => $productsid))->delete('attributes_relationship');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	
	
	public function ReadAtrributes($cataloguesid = 0){
		$this->db->select('*');
		$this->db->from('attributes');
		$this->db->where(array('publish' => 1,'trash' => 0,'cataloguesid' => $cataloguesid));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function AttributesChecked($productsid = 0){
		$this->db->select('productsid, attrid');
		$this->db->from('attributes_relationship');
		$this->db->where('productsid', $productsid);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		$temp = '';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[] = $val['attrid'];
			}
		}
		return $temp;
	}
	
}
