<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendSlides_Model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->model(array('slides/FrontendSlidesGroups_Model'));
	}
	
	public function CountAll($keyword = 0, $lang = 'vietnamese'){
		$slide_group = $this->ReadGroupSlide($keyword, $lang);
		$this->db->where(array('groupsid' => $slide_group['id'], 'trash' => 0, 'alanguage' => $lang));
		$this->db->from('slides');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($keyword = 0, $start = 0, $limit = 0, $lang = 'vietnamese'){
		$slide_group = $this->ReadGroupSlide($keyword, $lang);
		$this->db->where(array('slides.groupsid' => $slide_group['id'], 'slides.trash' => 0, 'slides.alanguage' => $lang));
		$this->db->select('slides.*');

		$this->db->from('slides');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function get_slide_by_group_keyword($keyword = 0) {
		$group = $this->FrontendSlidesGroups_Model->get_by_keyword($keyword);
		if( isset($group) && is_array($group) && count($group) ) {
			$this->db->select('title, url, description, image');
			$this->db->from('slides');
			$this->db->where(array('trash' => 0,'publish' => 1, 'groupsid' => $group['id']));
			$this->db->order_by('order ASC, id DESC');
			$result = $this->db->get()->result_array();
			$this->db->flush_cache();
			return $result;
		}
		return null;
	}
	public function Read($keyword = '', $lang = 'vietnamese', $limit = 0){
		$slide_group = $this->ReadGroupSlide($keyword, $lang);
		$this->db->select('*');
		$this->db->from('slides');
		$this->db->where(array('groupsid' => $slide_group['id'], 'alanguage' => $lang, 'publish' => 1));
		if ($limit != 0) {
			$this->db->limit($limit, 0);
		}
		$this->db->order_by('order ASC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
		
	}
	public function ReadGroupSlide($keyword = '', $lang = 'vietnamese'){
		$this->db->select('*');
		$this->db->from('slides_groups');
		$this->db->where(array('keyword' => $keyword, 'publish' => 1));
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
}