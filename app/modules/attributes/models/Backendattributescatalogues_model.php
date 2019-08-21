<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendAttributesCatalogues_Model extends FC_Model{

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
		$this->db->from('attributes_catalogues');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('attributes_catalogues.trash' => 0));
		$this->db->select('attributes_catalogues.*, (SELECT COUNT(attributes.id) FROM attributes WHERE attributes.cataloguesid = attributes_catalogues.id AND trash = 0) as count_attributes');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('attributes_catalogues');
		$this->db->order_by('order ASC, id desc');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('attributes_catalogues');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Create(){
		$data = array(
			'title' => $this->input->post('title'),
			'keyword' => slug($this->input->post('keyword')),
			'modules' => $this->input->post('modules'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('attributes_catalogues', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateByPost($field = '', $value = 0){
		$data = array(
			'title' => $this->input->post('title'),
			'keyword' => slug($this->input->post('keyword')),
			'modules' => $this->input->post('modules'),
			'order' => $this->input->post('order'),
			'description' => $this->input->post('description'),
			'publish' => $this->input->post('publish'),
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->where(array($field => $value))->update('attributes_catalogues', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('attributes_catalogues', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}

	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('attributes_catalogues', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->where(array('cataloguesid' => $value))->update('attributes', array( 'trash' => 1));
		$this->db->where('uri = \'attributes/frontend/attributes/view\' AND param IN (SELECT id FROM attributes WHERE cataloguesid = '.$value.')')->delete('routers');
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAllByField($field = '', $value = 0, $select = 'id, title, slug, canonical, order'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		$this->db->from('attributes_catalogues');
		$this->db->where(array($field => $value));
		$result = $this->db->order_by('order ASC, id DESC')->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function AttributesCataloguesList($flag = TRUE){
		$this->db->select('*');
		$this->db->from('attributes_catalogues');
		$this->db->where('trash', 0);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		$temp[0] = '[Chọn danh mục cha]';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[$val['id']] = $val['title'];
			}
		}
		return (($flag == TRUE) ? $temp : $result);
	}

}
