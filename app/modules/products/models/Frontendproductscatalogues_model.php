<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendProductsCatalogues_Model extends FC_Model{

	public function __construct(){
		parent::__construct();
	}


	public function Search($param = '', $catalogue = '',  $start = 0, $limit = 0, $lang = 'vietnamese'){

		$attribute['query'] = '';
		
		$keyword = $this->input->get('key');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$attribute['query'] = $attribute['query'].' AND (`pr`.`title`  LIKE \'%'.$keyword.'%\')';
		}

		$price_to = (int)str_replace('.','',$this->input->get('price_to'));
		$price_to = (int)str_replace(',', '', $price_to);
		if(!empty($price_to) && $price_to != 0){
			$attribute['query'] = $attribute['query'].' AND `pr`.`saleoff` >= \''.$price_to.'\'';
		}

		$price_from = (int)str_replace('.','',$this->input->get('price_from'));
		$price_from = (int)str_replace(',', '', $price_from);
		if(!empty($price_from) && $price_from != 0){
			$attribute['query'] = $attribute['query'].' AND `pr`.`saleoff` =< \''.$price_from.'\'';
		}

		if (isset($catalogue) && is_array($catalogue) && count($catalogue)) {
			if($catalogue['rgt'] - $catalogue['lft'] > 1){
				$_list_child = $this->_get_where(array(
					'select' => 'id, title',
					'table' => 'products_catalogues',
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
		}
		$attribute['query'] = (!empty($attribute['query'])?' '.$attribute['query'].'':'');
		
		$data = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `products` as `pr`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \'products\' AND `att`.`modulesid` = `pr`.`id`'.$attribute['query'].'
 			GROUP BY `att`.`modulesid`
			ORDER BY '.((!empty($param['order_by'])) ? $param['order_by'] : '`pr`.`order` asc, `pr`.`id` desc').'
			LIMIT '.($param['start']).', '.$param['limit'].'
		')->result_array();
		$this->db->flush_cache();
		return $data;
	}
	
	//-----------------------------------------------------
	// Tìm kiếm
	//-----------------------------------------------------
	public function Countsearch($param = '',$catalogue = '', $lang = 'vietnamese'){

		$attribute['query'] = '';
		
		$keyword = $this->input->get('key');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$attribute['query'] = $attribute['query'].' AND (`pr`.`title`  LIKE \'%'.$keyword.'%\')';
		}

		$code = $this->input->get('address');
		if(!empty($code)){
			$code = $this->db->escape_like_str($code);
			$attribute['query'] = $attribute['query'].' AND (`pr`.`code`  LIKE \'%'.$code.'%\')';
		}

		$price_to = (int)str_replace('.','',$this->input->get('price_to'));
		$price_to = (int)str_replace(',', '', $price_to);
		if(!empty($price_to) && $price_to != 0){
			$attribute['query'] = $attribute['query'].' AND `pr`.`saleoff` >= \''.$price_to.'\'';
		}

		$price_from = (int)str_replace('.','',$this->input->get('price_from'));
		$price_from = (int)str_replace(',', '', $price_from);
		if(!empty($price_from) && $price_from != 0){
			$attribute['query'] = $attribute['query'].' AND `pr`.`saleoff` =< \''.$price_from.'\'';
		}

		if (isset($catalogue) && is_array($catalogue) && count($catalogue)) {
			if($catalogue['rgt'] - $catalogue['lft'] > 1){
				$_list_child = $this->_get_where(array(
					'select' => 'id, title',
					'table' => 'products_catalogues',
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
		}

		$attribute['query'] = (!empty($attribute['query'])?' '.$attribute['query'].'':'');
		$count = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `products` as `pr`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \'products\' AND `att`.`modulesid` = `pr`.`id`'.$attribute['query'].'
 			GROUP BY `att`.`modulesid`
			ORDER BY `pr`.`id` asc
		')->num_rows();
		$this->db->flush_cache();
		return $count;
	}

	public function Count($lang = 'vietnamese'){
		$this->db->where(array('trash' => 0, 'publish' => 1, 'alanguage' => $lang, 'parentid' => 0));
		$this->db->from('products_catalogues');
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// All
	//-----------------------------------------------------
	public function All( $start = 0, $limit = 0, $lang = 'vietnamese'){
		$keyword = $this->input->get('key');
		$this->db->where(array('trash' => 0, 'publish' => 1, 'alanguage' => $lang, 'parentid' => 0));
		$this->db->from('products_catalogues');
		$this->db->order_by('order asc, id DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	//-----------------------------------------------------
	// Xem chi tiết danh mục
	//-----------------------------------------------------
	public function ReadByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0));
		$this->db->from('products_catalogues');
		$this->db->where(array($field => $value, 'alanguage' => $lang))->limit(1, 0);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}

	
	public function ReadByFieldArr($field = '', $limit = 0){
		$this->db->where(array('trash' => 0));
		$this->db->from('products_catalogues');
		$this->db->where($field);
		if($limit > 0){
			$this->db->limit($limit, 0);
		}
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	//-----------------------------------------------------
	// Cập nhật lượt xem danh mục
	//-----------------------------------------------------
	public function UpdateViewed($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array($field => $value, 'alanguage' => $lang))->set('viewed', 'viewed+1', FALSE)->update('products_catalogues');
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Hiển thị danh mục theo field
	//-----------------------------------------------------
	public function ReadAllByField($field = '', $value = 0, $lang = 'vietnamese'){
		$this->db->where(array('trash' => 0));
		$this->db->from('products_catalogues');
		$this->db->where(array($field => $value, 'alanguage' => $lang));
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Hiển thị cấu trúc Breadcrumb
	//-----------------------------------------------------
	public function Breadcrumb($lft = 0, $rgt = 0, $lang = 'vietnamese', $select = 'id, title, slug, canonical, lft, rgt'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0, 'alanguage' => $lang));
		$this->db->where(array(
			'lft <=' => $lft,
			'rgt >=' => $rgt,
		));
		$this->db->from('products_catalogues');
		$this->db->order_by('lft ASC, order ASC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}

	//-----------------------------------------------------
	// Hiển thị danh mục theo cấp con
	//-----------------------------------------------------
	public function ReadAllByAutoSub($catalogues = NULL){
		$this->db->where(array('trash' => 0));
		$this->db->from('products_catalogues');
		if($catalogues['rgt'] - $catalogues['lft'] == 1){
			$this->db->where(array('parentid' => $catalogues['parentid']));
		}
		else{
			$this->db->where(array('parentid' => $catalogues['id']));
		}
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}


	//-----------------------------------------------------
	// Xem danh mục cho sitemap
	//-----------------------------------------------------
	public function ReadAllForSitemap($select = 'id, title, slug, canonical, images, description, created'){
		$this->db->select($select);
		$this->db->where(array('trash' => 0));
		$this->db->from('products_catalogues');
		$this->db->order_by('created DESC');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	public function ReadByCondition($param = '', $flag = FALSE){
		$param['select'] = ((isset($param['select'])) ? $param['select'] : 'id, title, slug, canonical');
		$param['where'] = ((isset($param['where'])) ? $param['where'] : '');
		$param['order_by'] = ((isset($param['order_by'])) ? $param['order_by'] : 'id desc');
		$param['limit'] = ((isset($param['limit'])) ? (int)$param['limit'] : 0);
		
		
		$this->db->select($param['select']);
		$this->db->from('products_catalogues');
		$this->db->where($param['where']);
		if($param['limit'] > 0){
			$this->db->limit($param['limit'], 0);
		}
		
		$this->db->order_by($param['order_by']);
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		if($flag == TRUE){
			if(isset($result) && is_array($result) && count($result)){
				foreach($result as $key => $val){
					$result[$key]['post'] = $this->ReadArticles($val['id']);
				}
			}
		}
		return $result;
	}
	
	public function ReadArticles($cataloguesid = 0){
		$this->db->select('id, title, slug, canonical, images, description, created');
		$this->db->where(array('trash' => 0,'cataloguesid' => $cataloguesid));
		$this->db->from('articles');
		$this->db->limit(4, 0);
		$this->db->order_by('order asc, id desc');
		$result = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $result;
	}
	

}
