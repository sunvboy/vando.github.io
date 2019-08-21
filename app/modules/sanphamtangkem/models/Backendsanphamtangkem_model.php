<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendSanphamtangkem_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function create($user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'images' => $this->input->post('images'),
			'publish' => $this->input->post('publish'),
			'trash' => 0,
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user['id'],

		);
		$this->db->insert('products_sanphamtangkem', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update($id = 0, $user = ''){
		$data = array(
			'title' => $this->input->post('title'),
			'images' => $this->input->post('images'),
			'publish' => $this->input->post('publish'),
			'userid_updated' => $user['id']
		);
		$this->db->where(array('id' => $id))->update('products_sanphamtangkem', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function update_field($param = NULL, $id = 0){
		$this->db->where(array('id' => $id))->update('products_sanphamtangkem', $param);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function countall(){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('products_sanphamtangkem');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function view($start = 0, $limit = 0){
		$this->db->where(array('trash' => 0));
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->from('products_sanphamtangkem');
		$this->db->order_by('id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read($id = 0){
		$this->db->where(array('products_sanphamtangkem.trash' => 0));
		$this->db->select('products_sanphamtangkem.*');
		$this->db->from('products_sanphamtangkem');
		$this->db->where(array('products_sanphamtangkem.id' => $id))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function delete($id = 0){
		$this->db->where(array('id' => $id))->delete('products_sanphamtangkem');
//		 $this->db->where(array('id' => $id))->update('Sanphamtangkem', array('trash' => 1));
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByField($param = NULL){
		$this->db->where(array('trash' => 0));
		if(isset($param) && is_array($param) && count($param)){
			$this->db->where($param);
		}
		$this->db->from('products_sanphamtangkem');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function Dropdown(){
		$this->db->where(array('trash' => 0,'publish'=>1));
		$result = $this->db->select('id, title')->from('products_sanphamtangkem')->order_by('title ASC')->get()->result_array();
		$this->db->flush_cache();
		$dropdown[] = '-- [ Chọn sản phẩm ] --';
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				$dropdown[$val['id']] = $val['title'];
			}
		}
		return $dropdown;
	}
	
}