<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BackendTrafix_Model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function CountAll(){
		$where = '';
		$customersid = (int)$this->input->get('customersid');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$where = ' AND (customers.email LIKE \'%'.$keyword.'%\' OR customers.fullname LIKE \'%'.$keyword.'%\' OR products.title LIKE \'%'.$keyword.'%\') ';
		}
		$result = $this->db->query('SELECT COUNT(*) AS `numrows` FROM `products_trafix_affiliate` JOIN `customers` ON `customers`.`affiliate_id` = `products_trafix_affiliate`.`affiliate_id` JOIN `products` ON `products`.`id` = `products_trafix_affiliate`.`productsid` WHERE `customers`.`id` = '.$customersid.''.$where.' GROUP BY `products_trafix_affiliate`.`productsid`')->num_rows();
		$this->db->flush_cache();
		return $result;
	}

	public function ReadAll($start = 0, $limit = 0){
		$where = '';
		$customersid = (int)$this->input->get('customersid');
		$keyword = $this->input->get('keyword');
		if(!empty($keyword)){
			$keyword = $this->db->escape_like_str($keyword);
			$where = ' AND (customers.email LIKE \'%'.$keyword.'%\' OR customers.fullname LIKE \'%'.$keyword.'%\' OR products.title LIKE \'%'.$keyword.'%\') ';
		}
		$result = $this->db->query('SELECT `products_trafix_affiliate`.`affiliate_id`, `customers`.`email`, `customers`.`fullname`, `products_trafix_affiliate`.`productsid`, `products`.`title`, COUNT(`products_trafix_affiliate`.`productsid`) as total FROM `products_trafix_affiliate` JOIN `customers` ON `customers`.`affiliate_id` = `products_trafix_affiliate`.`affiliate_id` JOIN `products` ON `products`.`id` = `products_trafix_affiliate`.`productsid` WHERE `customers`.`id` = '.$customersid.''.$where.' GROUP BY `products_trafix_affiliate`.`productsid`')->result_array();
		$this->db->flush_cache();
		return $result;
	}
}
