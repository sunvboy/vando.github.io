<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendProjects_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountSearch($param = '', $catalogue = '', $lang = 'vietnamese'){
		$param['select'] = (isset($param['select'])) ? $param['select'] : '';
		$attribute['query'] = '';
		if (isset($catalogue) && is_array($catalogue) && count($catalogue)) {
			if($catalogue['rgt'] - $catalogue['lft'] > 1){
				$_list_child = $this->_get_where(array(
					'select' => 'id, title',
					'table' => $param['modules'].'_catalogues',
					'where' => array('publish' => 1, 'alanguage' => $lang, 'trash' => 0,'lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']),
				), TRUE);
			}
			if(isset($_list_child) && is_array($_list_child) && count($_list_child)){
				foreach($_list_child as $key => $val){
					$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`cataloguesid` = '.$val['id']):(' OR `att`.`cataloguesid` = '.$val['id']));
				}
			}else{
				$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`cataloguesid` = '.$catalogue['id']):(' OR `att`.`cataloguesid` = '.$catalogue['id']));
			}
			$attribute['query'] = (!empty($attribute['query'])?' AND ('.$attribute['query'].')':'');
		}
		$count = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `'.$param['modules'].'` as `pr`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \''.$param['modules'].'\' AND `att`.`modulesid` = `pr`.`id` '.$attribute['query'].' '.$param['where'].'
 			GROUP BY `att`.`modulesid`
			ORDER BY `pr`.`id` asc
		')->num_rows();
		$this->db->flush_cache();
		return $count;
	}

	public function ReadSearch($param = '', $catalogue = '', $lang = 'vietnamese'){
		$param['select'] = (isset($param['select'])) ? $param['select'] : '';
		$attribute['query'] = '';
		if (isset($catalogue) && is_array($catalogue) && count($catalogue)) {
			if($catalogue['rgt'] - $catalogue['lft'] > 1){
				$_list_child = $this->_get_where(array(
					'select' => 'id, title',
					'table' => $param['modules'].'_catalogues',
					'where' => array('publish' => 1, 'alanguage' => $lang, 'trash' => 0,'lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']),
				), TRUE);
			}
			if(isset($_list_child) && is_array($_list_child) && count($_list_child)){
				foreach($_list_child as $key => $val){
					$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`cataloguesid` = '.$val['id']):(' OR `att`.`cataloguesid` = '.$val['id']));
				}
			}else{
				$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`cataloguesid` = '.$catalogue['id']):(' OR `att`.`cataloguesid` = '.$catalogue['id']));
			}
			$attribute['query'] = (!empty($attribute['query'])?' AND ('.$attribute['query'].')':'');
		}
		$result = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `'.$param['modules'].'` as `pr`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \''.$param['modules'].'\' AND `att`.`modulesid` = `pr`.`id` '.$attribute['query'].' '.$param['where'].'
 			GROUP BY `att`.`modulesid`
			ORDER BY '.((!empty($param['order_by'])) ? $param['order_by'] : '`pr`.`order` asc, `pr`.`id` desc').'
			LIMIT '.($param['start']).', '.$param['limit'].'
		')->result_array();
		$this->db->flush_cache();
		return $result;
	}


	public function Create($user = '', $catalogue = NULL, $album = '', $images_ = ''){
		$price = $this->input->post('price');
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'cataloguesid' => (int)$this->input->post('cataloguesid'),
			'code' => $this->input->post('code'),
			'cityid' => (int)$this->input->post('cityid'),
			'districtid' => (int)$this->input->post('districtid'),
			'wardid' => (int)$this->input->post('wardid'),
			'projectid' => (int)$this->input->post('projectid'),
			'address' => $this->input->post('address'),
			'catalogues' => json_encode($catalogue),
			'area' => (float)$this->input->post('area'),
			'floor' => (int)$this->input->post('floor'),
			'price' => $price,
			'albums' => json_encode($album),
			'measure' => (int)$this->input->post('measure'),
			'type' => (int)$this->input->post('type'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'publish' => 0,
			'outofdate' => $this->input->post('outofdate').' '.$this->input->post('outohor').':00',
			'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user,
			'isaside' => $this->input->post('isaside'),
			'images' => $images_,
		);
		$this->db->insert('projects', $data);
		$result = $this->db->affected_rows();
		if($result > 0){
			$result = $this->db->insert_id();
		}
		$this->db->flush_cache();
		return $result;
	}

	public function Update($user = '', $catalogue = NULL, $album = '', $images_ = '', $field = 'id', $value = ''){
		$price = $this->input->post('price');
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => slug($this->input->post('title')),
			'cataloguesid' => (int)$this->input->post('cataloguesid'),
			'code' => $this->input->post('code'),
			'cityid' => (int)$this->input->post('cityid'),
			'districtid' => (int)$this->input->post('districtid'),
			'wardid' => (int)$this->input->post('wardid'),
			'projectid' => (int)$this->input->post('projectid'),
			'address' => $this->input->post('address'),
			'catalogues' => json_encode($catalogue),
			'area' => (float)$this->input->post('area'),
			'floor' => (int)$this->input->post('floor'),
			'price' => $price,
			'albums' => json_encode($album),
			'measure' => (int)$this->input->post('measure'),
			'type' => (int)$this->input->post('type'),
			'description' => $this->input->post('description'),
			'content' => $this->input->post('content'),
			'updated' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'userid_created' => $user,
			'isaside' => $this->input->post('isaside'),
			'images' => $images_,
		);
		$this->db->where(array($field => $value))->update('projects', $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	//-----------------------------------------------------
	// Xem chi tiết bài viết
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('projects');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByFieldArrCus($array = ''){
		$this->db->where(array('trash' => 0));
		$this->db->from('projects');
		$this->db->where($array)->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function CountReadByFieldArr($field = '', $value = 0){
		$keyword = $this->input->get('keyword');
		$type = $this->input->get('type');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		if(!empty($type)){
			$type = (int)$this->db->escape_like_str($type);
			$this->db->where('(width = \''.$type.'\')');
		}
		$this->db->where(array('trash' => 0));
		$this->db->from('projects');
		$this->db->where(array($field => $value));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	
	public function CountFieldArrCuss($array = ''){
		$this->db->where(array('trash' => 0));
		$this->db->from('projects');
		$this->db->where($array);
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByFieldArr($field = '', $value = 0, $start = 0, $limit = 0){
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}
		$this->db->where(array('trash' => 0));
		$this->db->from('projects');
		$this->db->where(array($field => $value));
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Cập nhật lượt xem bài viết
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0){
		$this->db->where(array($field => $value))->set('viewed', 'viewed+1', FALSE)->update('projects');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cùng chủ đề
	//-----------------------------------------------------
	public function ReadByTags($id = 0, $tags = NULL, $limit = 6, $select = 'projects.id, projects.title, projects.slug, projects.canonical, projects.images, projects.description, projects.viewed, projects.created, projects_catalogues.id as cat_id, projects_catalogues.title as cat_title, projects_catalogues.slug as cat_slug, projects_catalogues.canonical as cat_canonical'){
		if(isset($tags) && is_array($tags) && count($tags)){
			// Danh sách tag
			$tagid = '';
			foreach($tags as $key => $val){
				$tagid = $tagid . $val['id'].', ';
			}
			$tagid = substr($tagid, 0, -2);
			$this->db->select($select);
			$this->db->where(array('projects.trash' => 0, 'projects.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
			// Khác bài hiện tại
			$this->db->where(array('projects.id !=' => $id));
			$this->db->where('projects.id IN (SELECT modulesid FROM tags_relationship WHERE modules = \'projects\' AND tagsid IN ('.$tagid.'))');
			$this->db->from('projects');
			$this->db->join('projects_catalogues', 'projects.cataloguesid = projects_catalogues.id');
			$this->db->limit($limit, 0);
			$this->db->order_by('projects.created DESC');
			$result = $this->db->get()->result_array();
			$this->db->flush_cache();
			return $result;
		}
	}


	
	public function AttributesAllTheTime($projectsid  = 0){
		$attributesCatalogues =  $this->AttributesCatalogues(); // kết quả : ra danh sách các danh mục thuộc tính;
		if(isset($attributesCatalogues) && is_array($attributesCatalogues) && count($attributesCatalogues)){
			foreach($attributesCatalogues as $key => $val){
				$attributesCatalogues[$key]['attr'] = $this->Attributes($projectsid, $val['id']);
			}
		}
		return $attributesCatalogues;
	}

	
	public function count_all(){
		$this->db->select('id');
		$this->db->from('projects');
		$this->db->where(array('publish' => 1,'trash' => 0));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	
	public function read_all($start = 0, $limit = 0){
		$this->db->select('projects.*, (SELECT fullname FROM users WHERE users.id = projects.userid_created) as fullname,(SELECT fullname FROM users WHERE users.id = projects.userid_updated) as fullname_update, (SELECT title FROM projects_catalogues WHERE projects.cataloguesid = projects_catalogues.id) as catalogue');
		$keyword = $this->input->get('keyword');
		$userid = (int)$this->input->get('userid');
	
		$this->db->where(array('projects.trash' => 0,'projects.publish' => 1));
		$this->db->from('projects');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function Attributes($projectsid = 0, $catid = 0){
		$this->db->select('attributes.id, attributes.title, attributes.slug, attributes.canonical');
		$this->db->from('attributes');
		$this->db->where(array('attributes.trash' => 0,'attributes.cataloguesid' => $catid,'attributes_relationship.productsid' => $projectsid));
		$this->db->join('attributes_relationship','attributes.id = attributes_relationship.attrid');
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function ReadByCondition($param = ''){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? $param['limit'] : 5);
		$param['lft'] = ((isset($param['lft'])) ? $param['lft'] : 0);
		$param['rgt'] = ((isset($param['rgt'])) ? $param['rgt'] : 0);
		
		$this->db->select($param['select']);
		$this->db->from('projects');
		$this->db->where('trash', 0);
		$this->db->where($param['where']);
		if($param['lft'] > 0 && $param['rgt'] > 0){
			$this->db->where('(projects.cataloguesid IN (SELECT id FROM projects_catalogues WHERE lft >= '.$param['lft'].' AND rgt <= '.$param['rgt'].'))');
		}
		$this->db->limit($param['limit'], 0);
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	//Lấy ra danh mục thuộc tính
	public function AttributesCatalogues(){
		$this->db->select('id, title, keyword');
		$this->db->from('attributes_catalogues');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function countajaxproduct($objectid = ''){
		$this->db->select('id');
		$this->db->from('projects');
		$this->db->where(array(
			'publish' => 1,
			'trash' => 0,
		));
		$this->db->where_in('id', $objectid);
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}
	
	public function viewajaxproduct($start = 0, $limit = 0,$objectid = '' ){
		$this->db->where(array('trash' => 0,'publish' => 1));
		$this->db->select('id, title, slug, canonical, images, price, saleoff, description, created');
		
		$this->db->from('projects');
		$this->db->where_in('id', $objectid);
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	
	
	public function count_all_location($districtid = 0, $wardid = 0){
		$this->db->select('id');
		$this->db->from('projects');
		$this->db->where(array('publish' => 1,'trash' => 0,'districtid' => $districtid,'wardid' => $wardid));
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}
	
	public function read_all_location($start = 0, $limit = 0, $districtid = 0, $wardid = 0){
		$this->db->select('projects.*, (SELECT fullname FROM users WHERE users.id = projects.userid_created) as fullname,(SELECT fullname FROM users WHERE users.id = projects.userid_updated) as fullname_update, (SELECT title FROM projects_catalogues WHERE projects.cataloguesid = projects_catalogues.id) as catalogue');
		$keyword = $this->input->get('keyword');
		$userid = (int)$this->input->get('userid');
	
		$this->db->where(array('projects.trash' => 0,'projects.publish' => 1,'projects.districtid' => $districtid,'projects.wardid' => $wardid));
		$this->db->from('projects');
		$this->db->order_by('order DESC, created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	public function read_location($id = 0){
		$this->db->select('*');
		$this->db->from('province');
		$this->db->where('id', $id);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result['title'];
	}
	public function read_place($id = 0){
		$this->db->select('*');
		$this->db->from('places');
		$this->db->where('id', $id);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result['title'];
	}
	
}
