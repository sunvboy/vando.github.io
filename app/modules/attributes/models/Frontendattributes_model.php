<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendAttributes_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	//-----------------------------------------------------
	// Đếm số bài viết
	// Nếu $cataloguesid == 0 thì đếm All bài viết
	// Nếu $cataloguesid > 0 và $rgt - $lft == 1 thì đếm bài viết của danh mục hiện tại
	// Nếu $cataloguesid > 0 và $rgt - $lft > 1 thì đếm bài viết của danh mục hiện tại và các danh mục con
	//-----------------------------------------------------
	public function CountAllAtrributes($id){
		$attribute['query'] = '';
		$attribute['total'] = 0;
		if($id > 0){
			$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`attrid` = '.$id):(' OR `att`.`attrid` = '.$id));
			$attribute['total'] = $attribute['total'] + 1;
		}
		$attribute['query'] = (!empty($attribute['query'])?' AND ('.$attribute['query'].')':'');
		$attribute['having'] = (($attribute['total'] > 0)?(' HAVING `total` = '.$attribute['total']):'');
		
		$mode = $this->input->get('mode');
		if($mode > 0){
			$string_where = '`pr`.`mobileversion` = '.$mode.''; 
		}
		$flows = $this->input->get('flows');
		
		if($flows > 0){
			$str_where = '`pr`.`productsflowsid` = '.$flows.''; 
		}
		$count = $this->db->query('
			SELECT `pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `att`.`productsid`, COUNT(`productsid`) as `total`
			FROM `attributes_relationship` as `att`
			INNER JOIN `products` as `pr`
			WHERE `pr`.`trash` = 0 AND `att`.`productsid` = `pr`.`id`'.$attribute['query'].(!empty($str_where) ? ' AND '.$str_where:'').(!empty($string_where) ? ' AND '.$string_where:'').'
 			GROUP BY `att`.`productsid`'.$attribute['having'].'
			ORDER BY `pr`.`id`'.(isset($order_by) ? $order_by : 'desc').'
		')->num_rows();
		$this->db->flush_cache();
		return $count;
		
	}

	//-----------------------------------------------------
	// Hiển thị bài viết
	// Nếu $cataloguesid == 0 thì hiển thị All bài viết
	// Nếu $cataloguesid > 0 và $rgt - $lft == 1 thì hiển thị bài viết của danh mục hiện tại
	// Nếu $cataloguesid > 0 và $rgt - $lft > 1 thì hiển thị bài viết của danh mục hiện tại và các danh mục con
	//-----------------------------------------------------
	public function ReadAllAttribute($id, $start = 0, $limit = 10){
		$this->db->where(array('trash' => 0));
		$attribute['query'] = '';
		$attribute['total'] = 0;
		if($id > 0){
			$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`attrid` = '.$id):(' OR `att`.`attrid` = '.$id));
			$attribute['total'] = $attribute['total'] + 1;
		}
		$attribute['query'] = (!empty($attribute['query'])?' AND ('.$attribute['query'].')':'');
		$attribute['having'] = (($attribute['total'] > 0)?(' HAVING `total` = '.$attribute['total']):'');
		$mode = $this->input->get('mode');
		if($mode > 0){
			$string_where = '`pr`.`mobileversion` = '.$mode.''; 
		}
		$flows = $this->input->get('flows');
		
		if($flows > 0){
			$str_where = '`pr`.`productsflowsid` = '.$flows.''; 
		}
		$data = $this->db->query('
			SELECT `pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`,`pr`.`price`, `pr`.`saleoff`,`pr`.`created`, `att`.`productsid`, COUNT(`productsid`) as `total`
			FROM `attributes_relationship` as `att`
			INNER JOIN `products` as `pr`
			WHERE `pr`.`trash` = 0 AND `att`.`productsid` = `pr`.`id`'.$attribute['query'].(!empty($str_where) ? ' AND '.$str_where:'').(!empty($string_where) ? ' AND '.$string_where:'').'
 			GROUP BY `att`.`productsid`'.$attribute['having'].'
			ORDER BY `pr`.`order` DESC, `pr`.`id` DESC
			LIMIT '.($start * $limit).', '.$limit.'
		')->result_array();
		$this->db->flush_cache();
		return $data;
	}

	//-----------------------------------------------------
	// Xem chi tiết bài viết
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0){
		$this->db->where(array('trash' => 0, 'created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->from('attributes');
		$this->db->where(array($field => $value))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	
	public function ReadByFieldArr($field = '', $limit = 0, $flag = TRUE, $count = TRUE){
		$this->db->select('*');
		$this->db->where($field);
		$this->db->where('trash', 0);
		$this->db->from('attributes');
		$this->db->order_by('order asc, id asc');
		if($limit > 0){
			$this->db->limit($limit, 0);
		}
		if($flag == TRUE){
			$result = $this->db->get()->result_array();
		}else{
			$result = $this->db->get()->row_array();
		}
		$this->db->flush_cache();
		if($count == TRUE){
			foreach($result as $key => $val){
				$result[$key]['total_product'] = $this->CountProductsByAttr($val['id']);
			}
		}
		return $result;
	}
	
	public function CountProductsByAttr($attrid = 0){
		$this->db->select('productsid');
		$this->db->from('attributes_relationship');
		$this->db->where('attrid', $attrid);
		$count = $this->db->count_all_results();
		$this->db->flush_cache();
		return $count;
	}
	
	//-----------------------------------------------------
	// Cập nhật lượt xem bài viết
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0){
		$this->db->where(array($field => $value))->set('viewed', 'viewed+1', FALSE)->update('attributes');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cùng chủ đề
	//-----------------------------------------------------
	public function ReadByTags($id = 0, $tags = NULL, $limit = 6, $select = 'attributes.id, attributes.title, attributes.slug, attributes.canonical, attributes.images, attributes.description, attributes.viewed, attributes.created, attributes_catalogues.id as cat_id, attributes_catalogues.title as cat_title, attributes_catalogues.slug as cat_slug, attributes_catalogues.canonical as cat_canonical'){
		if(isset($tags) && is_array($tags) && count($tags)){
			// Danh sách tag
			$tagid = '';
			foreach($tags as $key => $val){
				$tagid = $tagid . $val['id'].', ';
			}
			$tagid = substr($tagid, 0, -2);
			$this->db->select($select);
			$this->db->where(array('attributes.trash' => 0, 'attributes.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
			// Khác bài hiện tại
			$this->db->where(array('attributes.id !=' => $id));
			$this->db->where('attributes.id IN (SELECT modulesid FROM tags_relationship WHERE modules = \'attributes\' AND tagsid IN ('.$tagid.'))');
			$this->db->from('attributes');
			$this->db->join('attributes_catalogues', 'attributes.cataloguesid = attributes_catalogues.id');
			$this->db->limit($limit, 0);
			$this->db->order_by('attributes.created DESC');
			$result = $this->db->get()->result_array();
			$this->db->flush_cache();
			return $result;
		}
	}

	//-----------------------------------------------------
	// Xem bài viết cho sitemap
	//-----------------------------------------------------
	public function ReadAllForSitemap($cataloguesid = 0, $lft = 0, $rgt = 0, $id = 0, $limit = 5, $select = 'attributes.id, attributes.title, attributes.slug, attributes.canonical, attributes.images, attributes.description, attributes.viewed, attributes.created, attributes_catalogues.id as cat_id, attributes_catalogues.title as cat_title, attributes_catalogues.slug as cat_slug, attributes_catalogues.canonical as cat_canonical'){
		$this->db->select($select);
		$this->db->where(array('attributes.trash' => 0, 'attributes.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->join('attributes_catalogues', 'attributes.cataloguesid = attributes_catalogues.id');
		if($cataloguesid > 0){
			if($rgt - $lft == 1){
				$this->db->where(array('attributes.cataloguesid' => $cataloguesid));
			}
			else{
				$this->db->where('(attributes.cataloguesid IN (SELECT id FROM attributes_catalogues WHERE lft >= '.$lft.' AND rgt <= '.$rgt.'))');
			}
		}
		$this->db->from('attributes');
		$this->db->limit($limit, 0);
		$this->db->order_by('attributes.created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Đếm bài viết cho tag
	//-----------------------------------------------------
	public function CountAllTags($id = 0, $modules = 'attributes'){
		$this->db->where(array('trash' => 0, 'created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->where(array('modules' => $modules, 'tagsid' => $id));
		$this->db->from('tags_relationship');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cho tag
	//-----------------------------------------------------
	public function ReadAllTags($id = 0, $modules = 'attributes', $start = 0, $limit = 10, $select = 'attributes.id, attributes.title, attributes.slug, attributes.canonical, attributes.images, attributes.description, attributes.viewed, attributes.created, attributes_catalogues.id as cat_id, attributes_catalogues.title as cat_title, attributes_catalogues.slug as cat_slug, attributes_catalogues.canonical as cat_canonical'){
		$this->db->where(array('attributes.trash' => 0, 'tags_relationship.trash' => 0, 'attributes.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->select($select);
		$this->db->from('tags_relationship');
		$this->db->join('attributes', 'tags_relationship.modulesid = attributes.id');
		$this->db->join('attributes_catalogues', 'attributes.cataloguesid = attributes_catalogues.id');
		$this->db->where(array('tags_relationship.modules' => $modules, 'tags_relationship.tagsid' => $id));
		$this->db->order_by('attributes.order ASC, attributes.created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function ProductsFlowsList($productsflowsid = ''){
		$flows = json_decode($productsflowsid, TRUE);
		$this->db->select('*');
		$this->db->from('products_flows');
		$this->db->where_in('id', $flows);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

}
