<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FC_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	
	public function create_batch($data = ''){
		if(isset($data['data']) && is_array($data['data']) && count($data['data'])){
			$this->db->insert_batch($data['table'], $data['data']);
			$result = $this->db->affected_rows();
			return $result;
		}
	}
	
	public function _delete_batch($field = '', $value = '', $table = '', $modules = ''){
		$this->db->where('modules', $modules);
		$this->db->where($field, $value)->delete($table);
		$this->db->flush_cache();
	}
	
	
	public function _catalogues_relationship($cataloguesid = 0, $modules = 'articles') {
		$this->db->select('modulesid');
		$this->db->from('catalogues_relationship');
		$this->db->where(array('cataloguesid' => $cataloguesid, 'modules' => $modules));
		$catalogues = $this->db->get()->result_array();
		$this->db->flush_cache();
		return $catalogues;
	}

	public function _countTable($param = NULL){
		$this->db->from($param['table']);
		$this->db->where($param['where']);
		$result = $this->db->count_all_results();
		$this->db->flush_cache();
		return $result;
	}

	public function _update_sort_order($table = '', $id = 0, $order = NULL) {
		$data['order'] = $order;
		$this->db->where(array('id' => $id))->update($table, $data);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	public function _delete_relationship($modules = '', $modulesid = ''){
		$this->db->where(array('modules' => $modules,'modulesid' => $modulesid));
		$this->db->delete('catalogues_relationship');
		$this->db->flush_cache();
	}
	
	/* CRUD  */
	// đọc dữ liệu
	public function _read($param = NULL){

		$param['select'] = isset($param['select'])?$param['select']:'';
		if(!empty($param['select'])){
			$this->db->select($param['select']);
		}

		$param['where'] = isset($param['where'])?$param['where']:NULL;
		if(isset($param['where']) && is_array($param['where']) && count($param['where'])){
			$this->db->where($param['where']);
		}

		if(isset($param['orderby']) && !empty($param['orderby'])){
			$this->db->order_by($param['orderby']);
		}

		$this->db->limit(1, 0);
		$this->db->from($param['table']);
		$result = $this->db->get()->row_array();
		$this->db->flush_cache();
		return $result;
	}
	
	
	
	public function _create($param = NULL){
		$this->db->insert($param['table'], $param['data']);
		$result = $this->db->affected_rows();

		if($result > 0){
			$objectid = $this->db->insert_id();
			$this->db->flush_cache();
		}
		return $objectid;
	}
	
	// cập nhật dữ liệu
	public function _update($param = NULL){

		$param['where'] = isset($param['where'])?$param['where']:NULL;
		if(isset($param['where']) && is_array($param['where']) && count($param['where'])){
			$this->db->where($param['where']);
		}

		$this->db->update($param['table'], $param['data']);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function _delete($param = ''){
		if(isset($param['where']) && is_array($param['where']) && count($param['where'])){
			$this->db->where($param['where']);
		}
		$this->db->update($param['table'], $param['data']);
		$result = $this->db->affected_rows();
		$this->db->flush_cache();
		return $result;
	}
	
	
	
	/* get_data */
	
	public function _get_where_param($param = ''){
		$result = '';
		if(isset($param['select']) && $param['select'] != ''){
			$this->db->select($param['select']);
		}
		if(isset($param['table']) && !empty($param['table'])){
			$this->db->from($param['table']);
		}
		if(isset($param['where']) && is_array($param['where']) && count($param['where'])){
			$this->db->where($param['where']);
			$this->db->where('trash', 0);
		}
		if(isset($param['where_in']) && is_array($param['where_in']) && isset($param['where_in_field']) && !empty($param['where_in_field'])){
			$this->db->where_in($param['where_in_field'], $param['where_in']);
		}
		if(isset($param['order_by']) && !empty($param['order_by'])){
			$this->db->order_by($param['order_by']);
		}
		if(isset($param['limit']) && !empty($param['limit'])){
			$this->db->limit($param['limit'], 0);
		}
		if(isset($param['type']) && !empty($param['type'])){
			if($param['type'] == 'row'){
				$result = $this->db->get()->row_array();
			}else if($param['type'] == 'array'){
				$result = $this->db->get()->result_array();
			}
		}
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function _get_where($param = '', $flag = FALSE){
		$param['table'] = isset($param['table']) ? $param['table'] : '';
		$param['select'] = isset($param['select']) ? $param['select'] : 'id';
		
		
		$this->db->select($param['select']);
		$this->db->from($param['table']);
		
		if(isset($param['keyword']) && !empty($param['keyword'])){
			$keyword = $this->db->escape_like_str($param['keyword']);
			$this->db->where('(title LIKE \'%'.$keyword.'%\')');
		}

		if(isset($param['where']) && is_array($param['where']) && count($param['where'])){
			$this->db->where($param['where']);
		}
		if(isset($param['limit']) && $param['limit'] > 0){
			$this->db->limit($param['limit'], 0);
		}
		if(isset($param['order_by']) && !empty($param['order_by'])){
			$this->db->order_by($param['order_by']);
		}
		if(isset($param['where_in']) && is_array($param['where_in']) && count($param['where_in']) && isset($param['where_in_field']) && $param['where_in_field'] != ''){
			$this->db->where_in($param['where_in_field'], $param['where_in']);
		}

		if(isset($param['where_not_in']) && is_array($param['where_not_in']) && count($param['where_not_in']) && isset($param['where_not_in_field']) && $param['where_not_in_field'] != ''){
			$this->db->where_not_in($param['where_not_in_field'], $param['where_not_in']);
		}
		
		if($flag == FALSE){
			$result = $this->db->get()->row_array();
		}else{
			$result = $this->db->get()->result_array();
		}
		$this->db->flush_cache();
		return $result;
	}
	
	
	public function _count($param = '', $catalogue = '', $lang = 'vietnamese'){
		$param['select'] = (isset($param['select'])) ? $param['select'] : '';
		$attribute['query'] = '';
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
		$count = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `'.$param['modules'].'` as `pr`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \''.$param['modules'].'\' AND `att`.`modulesid` = `pr`.`id`'.$attribute['query'].'
 			GROUP BY `att`.`modulesid`
			ORDER BY `pr`.`id` asc
		')->num_rows();
		$this->db->flush_cache();
		return $count;
	}
	
	public function _view($param = '', $catalogue = '', $lang = 'vietnamese'){
		$param['select'] = (isset($param['select'])) ? $param['select'] : ''; 
		$attribute['query'] = '';
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
		$data = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `'.$param['modules'].'` as `pr`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \''.$param['modules'].'\' AND `att`.`modulesid` = `pr`.`id`'.$attribute['query'].'
 			GROUP BY `att`.`modulesid`
			ORDER BY '.((!empty($param['order_by'])) ? $param['order_by'] : '`pr`.`order` asc, `pr`.`id` desc').'
			LIMIT '.($param['start']).', '.$param['limit'].'
		')->result_array();
		$this->db->flush_cache();
		return $data;
	}
	
	public function _vieworder($param = '', $catalogue = '', $lang = 'vietnamese'){
		$param['select'] = (isset($param['select'])) ? $param['select'] : '';
		$attribute['query'] = '';
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
		$data = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `'.$param['modules'].'` as `pr`
			WHERE `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \''.$param['modules'].'\' AND `att`.`modulesid` = `pr`.`id`'.$attribute['query'].'
		')->result_array();
		$this->db->flush_cache();
		return $data;
	}

		public function _viewajax($param = '', $catalogue = '', $lang = 'vietnamese'){
		$param['select'] = (isset($param['select'])) ? $param['select'] : '';
		$attribute['query'] = '';
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
		$data = $this->db->query('
			SELECT '.$param['select'].'
			FROM `catalogues_relationship` as `att`
			INNER JOIN `'.$param['modules'].'` as `pr`
			WHERE '.$param['where'].' AND `pr`.`trash` = 0 AND `pr`.`alanguage` = \''.$lang.'\' AND `pr`.`publish` = 1 AND `att`.`modules` = \''.$param['modules'].'\' AND `att`.`modulesid` = `pr`.`id`'.$attribute['query'].'
		')->result_array();
		$this->db->flush_cache();
		return $data;
	}
	
	public function _read_condition($param = '', $cataloguesid = ''){
		$result = '';
		$param['select'] = ((isset($param['select'])) ? $param['select'] : '');
		$param['limit'] = ((isset($param['limit'])) ? $param['limit'] : 5);
		$attribute['query'] = '';
		if(isset($param['where']) && $param['where'] != ''){
			$str_where = $param['where'];
		}
		if(isset($param['order_by']) && $param['order_by'] != ''){
			$order_by = $param['order_by'];
		}
		if(!isset($cataloguesid) || is_array($cataloguesid) == FALSE || count($cataloguesid) == 0 ){
			if($param['cataloguesid'] > 0){
				$catalogue = $this->_get_where(array(
					'select' => 'id, title, lft, rgt',
					'table' => $param['modules'].'_catalogues',
					'where' => array('publish' => 1, 'trash' => 0,'id' => $param['cataloguesid']),
				));
				
				if($catalogue['rgt'] - $catalogue['lft'] > 1){
					$_list_child = $this->_get_where(array(
						'select' => 'id, title',
						'table' => $param['modules'].'_catalogues',
						'where' => array('publish' => 1,'trash' => 0,'lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']),
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
		}else{
			foreach($cataloguesid as $key => $val){
				$attribute['query'] = $attribute['query'].(empty($attribute['query'])?('`att`.`cataloguesid` = '.$val['cataloguesid']):(' OR `att`.`cataloguesid` = '.$val['cataloguesid']));
			}
		}
		$attribute['query'] = (!empty($attribute['query'])?' AND ('.$attribute['query'].')':'');
			$result = $this->db->query('
				SELECT '.$param['select'].'
				FROM `catalogues_relationship` as `att`
				INNER JOIN `'.$param['modules'].'` as `pr`
				WHERE `pr`.`trash` = 0 AND `pr`.`publish` = 1 AND `att`.`modules` = \''.$param['modules'].'\' AND `att`.`modulesid` = `pr`.`id`'.$attribute['query'].(!empty($str_where) ? ' AND '.$str_where:'').'
				GROUP BY `att`.`modulesid`
				ORDER BY '.$param['order_by'].'
				LIMIT '.$param['limit'].'
			')->result_array();
			$this->db->flush_cache();
		
		return $result;
	}
	
	
}
