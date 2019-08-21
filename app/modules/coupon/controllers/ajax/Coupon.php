<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'products/BackendProducts_Model',
			'products/BackendProductsCatalogues_Model',
		));
		$this->load->library(array('ConfigBie'));
		$this->fcUser = $this->config->item('fcUser');
		$this->fc_lang = $this->config->item('fc_lang');
		$this->fcCustomer = $this->config->item('fcCustomer');
	}
	public function create_coupon(){
		$html = strtoupper(substr(md5(random().time()), 0, 10));
		echo json_encode(array('html' => $html)); die();
	}
	public function load_collections(){
		$html = '';
		$keyword = $this->input->post('keyword');
		$id = $this->input->post('id');
		$arr = explode('-', $id);
	    $catalogues = $this->BackendProducts_Model->_get_where(array(
	    	'select' => 'id, title, images',
	    	'table' => 'products_catalogues',
	    	'where' => array('trash' => 0, 'publish' => 1),
	    	'order_by' => 'order asc, id desc',
	    	'keyword' => $keyword,
	    ), TRUE);
	    if (isset($catalogues) && is_array($catalogues) && count($catalogues)) {
	    	$html .= '<div class="box-body">';
		    	$html .= '<ul class="next-list next-list-collections js-results-list">';
		    	foreach ($catalogues as $key => $val) {
		    		$html .= '<li data-id="'.$val['id'].'" class="li-root '.((in_array($val['id'], $arr)) ? 'active not_chose' : '').'">';
				        $html .= '<div class="mt-flex mt-flex-middle mt-flex-space-between">';
	                        $html .= '<div class="ui-stack-item ui-stack-item--fill">'.$val['title'].'</div>';
	                        $html .= '<div class="ui-stack-item v-v hide">Đã thêm vào khuyến mãi</div>';
	                    $html .= '</div>';
				    $html .= '</li>';
		    	}
		    $html .= '</div>';
	    }
	    echo json_encode(array('html' => $html)); die();
	}

	public function load_products(){
		$html = '';
		$keyword = $this->input->post('keyword');
		$id = $this->input->post('id');
		$arr = explode('-', $id);
	    $catalogues = $this->BackendProducts_Model->_get_where(array(
	    	'select' => 'id, title, images, price, saleoff, parentid, quantity',
	    	'table' => 'products',
	    	'where' => array('trash' => 0, 'publish' => 1),
	    	'order_by' => 'order asc, id desc',
	    	'keyword' => $keyword,
	    ), TRUE);
	    $catalogues = recursive($catalogues);
	    if (isset($catalogues) && is_array($catalogues) && count($catalogues)) {
	    	$html .= '<div class="box-body">';
		    	$html .= '<ul class="next-list next-list-products js-results-list">';
		    	foreach ($catalogues as $key => $val) {
		    		$html .= '<li data-id="'.$val['id'].'" class="li-root pen_root '.((in_array($val['id'], $arr)) ? 'active not_chose' : '').'">';
				        $html .= '<div class="mt-flex mt-flex-middle mt-flex-space-between">';
	                        $html .= '<div class="ui-stack-item ui-stack-item--fill">'.$val['title'].'</div>';
	                        $html .= '<div class="ui-stack-item v-v mt-flex mt-flex-middle mt-flex-right">';
	                        	$html .= '<div class="ui-stack-item">'.((!empty($val['quantity'])) ? 'Số lượng: <span class="type--warning">'.$val['quantity'].'</span>' : 'Hết hàng').'</div>';
	                        	$html .= '<div class="ui-stack-item">'.((!empty($val['saleoff'])) ? str_replace('', '', number_format($val['saleoff'])).' đ' : 'Liên hệ').'</div>';
                         	$html .= '</div>';
	                    $html .= '</div>';
				    $html .= '</li>';
				    if (isset($val['child']) && is_array($val['child']) && count($val['child'])) {
                    	foreach ($val['child'] as $key => $vals) {
                    		$html .= '<li data-id="'.$vals['id'].'" class="li-child li-root '.((in_array($vals['id'], $arr)) ? 'active not_chose' : '').'">';
                    		 	$html .= '<div class="">';
			                        $html .= '<div class="ui-stack-item ui-stack-item--fill">'.$vals['title'].'</div>';
		                         	$html .= '<div class="ui-stack-item v-v mt-flex mt-flex-middle">';
			                        	$html .= '<div class="ui-stack-item">'.((!empty($vals['quantity'])) ? 'Số lượng: <span class="type--warning">'.$vals['quantity'].'</span>' : 'Hết hàng').'</div>';
			                        	$html .= '<div class="ui-stack-item"><font>'.((!empty($vals['saleoff'])) ? str_replace(',', '.', number_format($vals['saleoff'])).' đ' : 'Liên hệ').'</font></div>';
		                         	$html .= '</div>';
			                    $html .= '</div>';
			                $html .= '</li>';
	                    }
                    }
		    	}
		    $html .= '</div>';
	    }
	    echo json_encode(array('html' => $html)); die();
	}
}