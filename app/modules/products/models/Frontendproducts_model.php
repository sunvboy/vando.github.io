<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendProducts_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}
	//-----------------------------------------------------
	// Count All
	//-----------------------------------------------------
	public function Count($lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'publish' => 1, 'alanguage' => $lang));
		$this->db->from('products');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// All
	//-----------------------------------------------------
	public function All( $start = 0, $limit = 0, $lang = 'vietnamese'){
		$keyword = $this->input->get('key');
		$this->db->where(array('trash' => 0, 'publish' => 1, 'alanguage' => $lang));
		$this->db->from('products');
		$this->db->order_by('order asc, id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	
	//-----------------------------------------------------
	// Xem chi tiết bài viết
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0));
		$this->db->from('products');
		$this->db->where(array($field => $value, 'alanguage' => $lang))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadByFieldArr($array= ''){
		$this->db->where(array('trash' => 0, 'publish' => 1));
		$this->db->from('products');
		$this->db->where($array)->order_by('id desc')->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Cập nhật lượt xem bài viết
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array($field => $value, 'alanguage' => $lang))->set('viewed', 'viewed+1', FALSE)->update('products');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cùng chủ đề
	//-----------------------------------------------------
	public function ReadByTags($id = 0, $tags = NULL, $limit = 6, $select = 'products.id, products.title, products.slug, products.canonical, products.images, products.description, products.viewed, products.created, products_catalogues.id as cat_id, products_catalogues.title as cat_title, products_catalogues.slug as cat_slug, products_catalogues.canonical as cat_canonical'){
		if(isset($tags) && is_array($tags) && count($tags)){
			// Danh sách tag
			$tagid = '';
			foreach($tags as $key => $val){
				$tagid = $tagid . $val['id'].', ';
			}
			$tagid = substr($tagid, 0, -2);
			$this->db->select($select);
			$this->db->where(array('products.trash' => 0, 'products.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
			// Khác bài hiện tại
			$this->db->where(array('products.id !=' => $id));
			$this->db->where('products.id IN (SELECT modulesid FROM tags_relationship WHERE modules = \'products\' AND tagsid IN ('.$tagid.'))');
			$this->db->from('products');
			$this->db->join('products_catalogues', 'products.cataloguesid = products_catalogues.id');
			$this->db->limit($limit, 0);
			$this->db->order_by('products.created DESC');
			$result = $this->db->get()->result_array();
			$this->db->flush_cache();
			return $result;
		}
	}

	//-----------------------------------------------------
	// Xem bài viết cho sitemap
	//-----------------------------------------------------
	public function ReadAllForSitemap($cataloguesid = 0, $lft = 0, $rgt = 0, $id = 0, $limit = 5, $select = 'products.id, products.title, products.slug, products.canonical, products.images, products.description, products.viewed, products.created, products_catalogues.id as cat_id, products_catalogues.title as cat_title, products_catalogues.slug as cat_slug, products_catalogues.canonical as cat_canonical'){
		$this->db->select($select);
		$this->db->where(array('products.trash' => 0, 'products.created <=' => gmdate('Y-m-d H:i:s', time() + 7*3600)));
		$this->db->join('products_catalogues', 'products.cataloguesid = products_catalogues.id');
		if($cataloguesid > 0){
			if($rgt - $lft == 1){
				$this->db->where(array('products.cataloguesid' => $cataloguesid));
			}
			else{
				$this->db->where('(products.cataloguesid IN (SELECT id FROM products_catalogues WHERE lft >= '.$lft.' AND rgt <= '.$rgt.'))');
			}
		}
		$this->db->from('products');
		$this->db->limit($limit, 0);
		$this->db->order_by('products.created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Đếm bài viết cho tag
	//-----------------------------------------------------
	public function CountAllTags($id = 0, $modules = 'products'){
		$this->db->where(array('modules' => $modules, 'tagsid' => $id));
		$this->db->from('tags_relationship');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Xem bài viết cho tag
	//-----------------------------------------------------
	public function ReadAllTags($id = 0, $modules = 'products', $start = 0, $limit = 10, $select = 'products.id, products.title, products.slug, products.canonical, products.images, products.description, products.viewed, products.created, products_catalogues.id as cat_id, products_catalogues.title as cat_title, products_catalogues.slug as cat_slug, products_catalogues.canonical as cat_canonical'){

		$this->db->select($select);
		$this->db->from('tags_relationship');
		$this->db->join('products', 'tags_relationship.modulesid = products.id');
		$this->db->join('products_catalogues', 'products.cataloguesid = products_catalogues.id');
		$this->db->where(array('tags_relationship.modules' => $modules, 'tags_relationship.tagsid' => $id));
		$this->db->order_by('products.order ASC, products.created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	//-----------------------------------------------------
	// Lấy thuộc tính tag cho bài viết
	//-----------------------------------------------------
	public function ReadAllTagsbyProducts($id = 0, $modules = 'products', $start = 0, $limit = 10, $select = 'tags.id, tags.title, tags.slug, tags.canonical'){
		$this->db->select($select);
		$this->db->from('tags');
		$this->db->join('tags_relationship', 'tags_relationship.tagsid = tags.id');
		$this->db->join(''.$modules.'', ''.$modules.'.id = tags_relationship.modulesid');
		$this->db->where(array('tags_relationship.modules' => $modules, 'tags_relationship.modulesid' => $id));
		$this->db->order_by(''.$modules.'.order ASC, '.$modules.'.created DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
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
		$this->db->from('products');
		$this->db->where('trash', 0);
		$this->db->where($param['where']);
		if($param['lft'] > 0 && $param['rgt'] > 0){
			$this->db->where('(products.cataloguesid IN (SELECT id FROM products_catalogues WHERE lft >= '.$param['lft'].' AND rgt <= '.$param['rgt'].'))');
		}
		$this->db->limit($param['limit'], 0);
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

// Lấy thuộc tính của sản phẩm
	
	public function AttributesAllTheTime($productsid  = 0){
  		$attributesCatalogues =  $this->AttributesCatalogues(); // kết quả : ra danh sách các danh mục thuộc tính;
  		if(isset($attributesCatalogues) && is_array($attributesCatalogues) && count($attributesCatalogues)){
   			foreach($attributesCatalogues as $key => $val){
    			$attributesCatalogues[$key]['attr'] = $this->Attributes($productsid, $val['id']);
   			}
  		}
  		return $attributesCatalogues;
 	}
 
 
 	public function Attributes($productsid = 0, $catid = 0){
		$this->db->select('attributes.id, attributes.title, attributes.slug, attributes.canonical');
		$this->db->from('attributes');
		$this->db->where(array('attributes.trash' => 0,'attributes.cataloguesid' => $catid,'attributes_relationship.productsid' => $productsid));
		$this->db->join('attributes_relationship','attributes.id = attributes_relationship.attrid');
		$result = $this->db->get()->result_array();
  		return $result;
 	}
 
 	//Lấy ra danh mục thuộc tính
 	public function AttributesCatalogues(){
  		$this->db->select('id, title, keyword');
  		$this->db->from('attributes_catalogues');
  		$this->db->where(array('trash' => 0));
  		$result = $this->db->get()->result_array();
  		$this->db->flush_cache();
  		return $result;
 	}
	
	public function countajaxproduct($attribute = '', $cataloguesid = 0, $lang = 'vietnamese'){
  		$attribute['query'] = '';
	  	$attribute['total'] = 0;
	  	$relationship['query'] = '';
	  	if(isset($attribute) && is_array($attribute) && count($attribute)){
	   		foreach($attribute as $key => $val){
	    		if($val == '') continue;
	    		$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`attrid` = '.$val):(' OR `att`.`attrid` = '.$val));
	    		$attribute['total'] = $attribute['total'] + 1; 
	   		}
	  	}
		$attribute['query'] = (!empty($attribute['query'])?' AND ('.$attribute['query'].')':'');
		$attribute['having'] = (($attribute['total'] > 0)?(' HAVING `total` = '.$attribute['total']):'');
  
  		if($cataloguesid > 0){
   			$catalogue = $this->_get_where(array(
			    'select' => 'id, title, lft, rgt',
			    'table' => 'products_catalogues',
			    'where' => array('publish' => 1, 'trash' => 0, 'alanguage' => $lang, 'id' => $cataloguesid),
   			));
   			if($catalogue['rgt'] - $catalogue['lft'] > 1){
    			$_list_child = $this->_get_where(array(
		     	'select' => 'id, title',
		     	'table' => 'products_catalogues',
		     	'where' => array('publish' => 1,'trash' => 0,'lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']),
    			), TRUE);
	   		}
	   		if(isset($_list_child) && is_array($_list_child) && count($_list_child)){
	    		foreach($_list_child as $key => $val){
	     			$relationship['query'] = $relationship['query'].(empty($relationship['query'])?('`rls`.`cataloguesid` = '.$val['id']):(' OR `rls`.`cataloguesid` = '.$val['id']));
	    		}
	   		}
	   		else
	   		{
	    		$relationship['query'] = $relationship['query'].(empty($relationship['query'])?('`rls`.`cataloguesid` = '.$catalogue['id']):(' OR `rls`.`cataloguesid` = '.$catalogue['id']));
	   		}
	  	}
	  	$relationship['query'] = (!empty($relationship['query'])?' AND ('.$relationship['query'].')':'');
	  
	 
	  	$count = $this->db->query('
	   		SELECT `pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `att`.`productsid`, COUNT(`productsid`) as `total`
			FROM `attributes_relationship` as `att`
	   		INNER JOIN `products` as `pr` ON `pr`.`id` = `att`.`productsid`
	   		INNER JOIN `catalogues_relationship` as `rls` ON `pr`.`cataloguesid`
	   		WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`id` = `rls`.`modulesid` AND `rls`.`modules` = \'products\' AND `att`.`productsid` = `pr`.`id`'.$attribute['query'].$relationship['query'].' GROUP BY `att`.`productsid`'.$attribute['having'].' ORDER BY `pr`.`id`'.(isset($order_by) ? $order_by : 'desc').' ')->num_rows();
	  		$this->db->flush_cache();
	  		return $count;
 	}
 
 	public function viewajaxproduct($start = 0, $limit = 0, $attribute = '', $cataloguesid = 0, $lang = 'vietnamese'){
	  	$attribute['query'] = '';
	  	$attribute['total'] = 0;
	  	$relationship['query'] = '';
	  	if(isset($attribute) && is_array($attribute) && count($attribute)){
	   		foreach($attribute as $key => $val){
	    		if($val == '') continue;
	    		$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`attrid` = '.$val):(' OR `att`.`attrid` = '.$val));
	    		$attribute['total'] = $attribute['total'] + 1; 
	   		}
	  	}

  		$attribute['query'] = (!empty($attribute['query'])?' AND ('.$attribute['query'].')':'');
  		$attribute['having'] = (($attribute['total'] > 0)?(' HAVING `total` = '.$attribute['total']):'');
  
  		if($cataloguesid > 0){
   			$catalogue = $this->_get_where(array(
    			'select' => 'id, title, lft, rgt',
			    'table' => 'products_catalogues',
			    'where' => array('publish' => 1, 'alanguage' => $lang, 'trash' => 0, 'id' => $cataloguesid),
   			));
   			if($catalogue['rgt'] - $catalogue['lft'] > 1){
    			$_list_child = $this->_get_where(array(
		     		'select' => 'id, title',
		     		'table' => 'products_catalogues',
		     		'where' => array('publish' => 1,'trash' => 0,'lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']),
    			), TRUE);
  			}
   			if(isset($_list_child) && is_array($_list_child) && count($_list_child)){
    			foreach($_list_child as $key => $val){
     				$relationship['query'] = $relationship['query'].(empty($relationship['query'])?('`rls`.`cataloguesid` = '.$val['id']):(' OR `rls`.`cataloguesid` = '.$val['id']));
    			}
		   	}
		   	else
		   	{
    			$relationship['query'] = $relationship['query'].(empty($relationship['query'])?('`rls`.`cataloguesid` = '.$catalogue['id']):(' OR `rls`.`cataloguesid` = '.$catalogue['id']));
   			}
  		}
	  	$relationship['query'] = (!empty($relationship['query'])?' AND ('.$relationship['query'].')':'');
	  	$count = $this->db->query('
			SELECT `pr`.`active_phamtramgiamgia`,  `pr`.`tmp_active_phamtramgiamgia`,  `pr`.`albums`, `pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`,  `att`.`productsid`, COUNT(`productsid`) as `total`
			FROM `attributes_relationship` as `att`
			INNER JOIN `products` as `pr` ON `pr`.`id` = `att`.`productsid`
			INNER JOIN `catalogues_relationship` as `rls` ON `pr`.`cataloguesid`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`id` = `rls`.`modulesid` AND `rls`.`modules` = \'products\' AND `att`.`productsid` = `pr`.`id`'.$attribute['query'].$relationship['query'].' GROUP BY `att`.`productsid`'.$attribute['having'].' ORDER BY `pr`.`id`'.(isset($order_by) ? $order_by : 'desc').' LIMIT '.($start * $limit).', '.$limit.' ')->result_array();
			$this->db->flush_cache();
			return $count;
 	}
}
