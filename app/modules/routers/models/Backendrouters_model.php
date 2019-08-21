<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendRouters_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function Count($canonical = ''){
		$crc32 = sprintf("%u", crc32($canonical));
		$this->db->where(array('trash' => 0));
		$cataloguesid = $this->input->get('cataloguesid');
		$this->db->where(array(
			'crc32' => $crc32
		));
		$this->db->from('routers');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function Create($canonical = '', $uri = '', $param = '', $type = ''){
		$data = array(
			'canonical' => $canonical,
			'crc32' => sprintf("%u", crc32($canonical)),
			'uri' => $uri,
			'param' => $param,
			'type' => $type,
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
		);
		$this->db->insert('routers', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function Delete($canonical = '', $uri = '', $param = '', $type = ''){
		$this->db->where(array(
			'uri' => $uri,
			'param' => $param,
			'type' => $type,
		))->delete('routers');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function Read($canonical = ''){
		$crc32 = sprintf("%u", crc32($canonical));
		$this->db->where(array('trash' => 0));
		$this->db->from('routers');
		$this->db->where(array('crc32' => $crc32))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

}
