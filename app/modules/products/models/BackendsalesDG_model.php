<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendSalesDG_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}
	public function CountAll(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\'');
		}
		$this->db->from('products_sale');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadAll($start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');

		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\'');
		}
		$this->db->from('products_sale');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function CountAllTungSanPham(){
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\'');
		}
		$this->db->where('id',2);
		$this->db->from('products_sale_tungsanpham');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadAllTungSanPham($start = 0, $limit = 0){
		$keyword = $this->input->get('keyword');

		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\'');
		}
		$this->db->where('id',2);

		$this->db->from('products_sale_tungsanpham');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function CountAllSoLuong(){
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\'');
		}
		$this->db->from('products_sale_soluong');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadAllSoLuong($start = 0, $limit = 0){
		$keyword = $this->input->get('keyword');

		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\'');
		}
		$this->db->from('products_sale_soluong');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);

		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadAllSale($param = ''){
		$this->db->where($param);
		$this->db->from('products_sale_relationship');
		$this->db->order_by('id DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('products_sale');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByFieldSoLuong($field = '', $value = 0){
		$this->db->from('products_sale_soluong');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByFieldTungSanPham($field = '', $value = 0){
		$this->db->from('products_sale_tungsanpham');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByFieldProducts($field = '', $value = 0){
		$this->db->select('id,saleoff,saleoff_tmp,saleoff_tmp_saleoff');
		$this->db->where(array('trash' => 0,'publish' => 1));
		$this->db->from('products');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function Create(){
		$saleoff = (int)str_replace('.','', $this->input->post('saleoff'));

		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'images' => $this->input->post('images'),
			'saleoff' => $saleoff,
			'id_combo' => $this->input->post('id_combo'),
			'publish' => $this->input->post('publish'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_description' => $this->input->post('meta_description'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'order' =>  $this->input->post('order'),
			'time_start' =>  $this->input->post('time_start'),
			'time_end' =>  $this->input->post('time_end'),
			'trash' => 0,
		);
		$this->db->insert('products_sale', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}
	public function UpdateByPost($field = '', $value = 0){
		$saleoff = (int)str_replace('.','', $this->input->post('saleoff'));
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'images' => $this->input->post('images'),
			'saleoff' => $saleoff,
			'id_combo' => $this->input->post('id_combo'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_description' => $this->input->post('meta_description'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'order' =>  $this->input->post('order'),
			'time_start' =>  $this->input->post('time_start'),
			'publish' => $this->input->post('publish'),

			'time_end' =>  $this->input->post('time_end'),
		);
		$this->db->where(array($field => $value))->update('products_sale', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function UpdateByPost_50($field = '', $value = 0){
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'canonical' => slug($this->input->post('canonical')),
			'images' => $this->input->post('images'),
			'phantram' => $this->input->post('saleoff'),
			'id_combo' => $this->input->post('id_combo'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_description' => $this->input->post('meta_description'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'order' =>  $this->input->post('order'),
			'time_start' =>  $this->input->post('time_start'),
			'publish' => $this->input->post('publish'),

			'time_end' =>  $this->input->post('time_end'),
		);
		$this->db->where(array($field => $value))->update('products_sale', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function UpdateByPostSoLuong($id){
		$data = array(
			'title' => $this->input->post('title'),
			'qty' => $this->input->post('qty'),
			'saleoff' => $this->input->post('saleoff'),
			'time_start' =>  $this->input->post('time_start'),
			'time_end' =>  $this->input->post('time_end'),
		);
		$this->db->where(array('id' => $id))->update('products_sale_soluong', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function UpdateByPostTungSanPham($id){
		$data = array(
			'title' => $this->input->post('title'),
			'time_start' =>  $this->input->post('time_start'),
			'time_end' =>  $this->input->post('time_end'),
			'id_combo' =>  $this->input->post('id_combo'),
			'publish' =>  $this->input->post('publish'),
			'saleoff' => json_encode($this->input->post('saleoff')),
		);
		$this->db->where(array('id' => $id))->update('products_sale_tungsanpham', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function UpdateByPostProducts($field = '', $value = 0,$data){

		$this->db->where(array($field => $value))->update('products', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function UpdateBatchByField($data = NULL, $field = 'id'){
		$result = $this->db->update_batch('products_sale', $data, $field); 
		$this->db->flush_cache();
		return $result;
	}
	public function DeleteByField($field = '', $value = 0){
		$this->db->where(array($field => $value))->update('products_sale', array('canonical' => '', 'trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	public function Dropdown(){
		$this->db->select('*');
		$this->db->from('products_sale');
		$result = $this->db->get()->result_array();
		$temp = '';
		$temp[0] = '--Chọn--';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$temp[$val['id']] = $val['title'];
			}
		}
		return $temp;
	}
	public function _delete_batch_sale($field = '', $value = '', $table = ''){
		$this->db->where($field, $value)->delete($table);
		$this->db->flush_cache();
	}
}
