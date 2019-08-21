<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		$this->load->model(array(
			'slides/FrontendSlides_Model',
			'address/Frontendaddress_Model',
			'idea/FrontendIdea_Model',
			'products/FrontendSaleDG_Model'
		));
		$this->load->library(array('lichhoc/configbie'));
		$this->load->library('google');
		$this->load->library('facebook');
		$this->fcCustomer = $this->config->item('fcCustomer');
	}

	public function Index($page = 1){
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}

		/* -------------------------- */
		// Xóa cache  
		$this->cache->clean();

		$data['ReadByFieldTungSanPham'] = $this->FrontendSaleDG_Model->ReadByFieldTungSanPham('id',2);
		//var_dump($data['ReadByFieldTungSanPham']);die;

		if (!$products_saleoff_time  = $this->cache->get('products_saleoff_time ')) {
			$time_stop = $this->fcSystem['homepage_logo1'];
			if (!empty($time_stop)) {
				$data['time_start'] = gmdate('Y-m-d H:i:s', time() + 7*3600 + ($time_stop*24*3600) - 62);
				$products_saleoff_time  = $this->FrontendProducts_Model->_get_where(array(
		            'select' => 'id, title, slug, canonical, images, description, price, saleoff, saleoff_time',
		            'table' => 'products',
		            'where' => array('trash' => 0,'publish' => 1, 'highlight' => 1,  'parentid' => 0, 'alanguage' => ''.$this->fc_lang.''),
		            'limit' => 10,
		            'order_by' => 'order asc, id desc',
		        ), TRUE);
		        $data['products_saleoff_time'] = $products_saleoff_time ;
				$this->cache->save('products_saleoff_time ', $products_saleoff_time , 300);
			}
		}else{
			$data['products_saleoff_time'] = $products_saleoff_time ;
		}

		// if (!$products_hot = $this->cache->get('products_hot')) {
		// 	$products_hot = $this->FrontendProducts_Model->_get_where(array(
	 //            'select' => 'id, title, slug, canonical, images, price, saleoff',
	 //            'table' => 'products',
	 //            'where' => array('trash' => 0,'publish' => 1, 'highlight' => 1, 'alanguage' => ''.$this->fc_lang.''),
	 //            'limit' => 6,
	 //            'order_by' => 'order asc, id desc',
	 //        ), TRUE);
	 //        $data['products_hot'] = $products_hot;
		// 	$this->cache->save('products_hot', $products_hot, 300);
		// }else{
		// 	$data['products_hot'] = $products_hot;
		// }

		$data['product_catalog_ao'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
			'select' => 'id, title, slug, canonical, images, limit_home, limit_parent, lft, rgt',
			'where' => array('trash' => 0,'publish' => 1, 'ishome' => 1, 'alanguage' => ''.$this->fc_lang.''),
			'limit' => 1,
			'order_by' => 'order asc, id desc'
		));
		if(isset($data['product_catalog_ao'] ) && is_array($data['product_catalog_ao'] ) && count($data['product_catalog_ao'] )){
			foreach($data['product_catalog_ao']  as $key => $val) {
				$data['product_catalog_ao'] [$key]['post'] = $this->FrontendProducts_Model->_read_condition(array(
					'modules' => 'products',
					'select' => '`pr`.`albums`,`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`, `pr`.`tmp_active_phamtramgiamgia`, `pr`.`active_phamtramgiamgia`',
					'where' => '`pr`.`parentid` = 0 AND `pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 8,
					'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
					'cataloguesid' => $val['id'],
				));
				$data['product_catalog_ao'][$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
					'select' => 'id, title, slug, canonical, images, lft, rgt, limit_home',
					'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''),
					'limit' => 5,
					'order_by' => 'order asc, id desc',
				));
			}
		}
		$data['product_catalog_quan'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
			'select' => 'id, title, slug, canonical, images, limit_home, limit_parent, lft, rgt',
			'where' => array('trash' => 0,'publish' => 1, 'highlight' => 1, 'alanguage' => ''.$this->fc_lang.''),
			'limit' => 1,
			'order_by' => 'order asc, id desc'
		));
		if(isset($data['product_catalog_quan'] ) && is_array($data['product_catalog_quan'] ) && count($data['product_catalog_quan'] )){
			foreach($data['product_catalog_quan']  as $key => $val) {
				$data['product_catalog_quan'] [$key]['post'] = $this->FrontendProducts_Model->_read_condition(array(
					'modules' => 'products',
					'select' => '`pr`.`albums`,`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`, `pr`.`tmp_active_phamtramgiamgia`, `pr`.`active_phamtramgiamgia`',
					'where' => '`pr`.`parentid` = 0 AND `pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 8,
					'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
					'cataloguesid' => $val['id'],
				));
				$data['product_catalog_quan'][$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
					'select' => 'id, title, slug, canonical, images, lft, rgt, limit_home',
					'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''),
					'limit' => 5,
					'order_by' => 'order asc, id desc',
				));
			}
		}
		$data['product_catalog_sanphamnoibat1'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
			'select' => 'id, title, slug, canonical, images, limit_home, limit_parent, lft, rgt',
			'where' => array('trash' => 0,'publish' => 1, 'isaside' => 1, 'alanguage' => ''.$this->fc_lang.''),
			'limit' => 1,
			'order_by' => 'order asc, id desc'
		));
		if(isset($data['product_catalog_sanphamnoibat1'] ) && is_array($data['product_catalog_sanphamnoibat1'] ) && count($data['product_catalog_sanphamnoibat1'] )){
			foreach($data['product_catalog_sanphamnoibat1']  as $key => $val) {
				$data['product_catalog_sanphamnoibat1'] [$key]['post'] = $this->FrontendProducts_Model->_read_condition(array(
					'modules' => 'products',
					'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`, `pr`.`tmp_active_phamtramgiamgia`, `pr`.`active_phamtramgiamgia`',
					'where' => '`pr`.`parentid` = 0 AND `pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 4,
					'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
					'cataloguesid' => $val['id'],
				));

			}
		}
		$data['product_catalog_sanphamnoibat2'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
			'select' => 'id, title, slug, canonical, images, limit_home, limit_parent, lft, rgt',
			'where' => array('trash' => 0,'publish' => 1, 'isfooter' => 1, 'alanguage' => ''.$this->fc_lang.''),
			'limit' => 1,
			'order_by' => 'order asc, id desc'
		));
		if(isset($data['product_catalog_sanphamnoibat2'] ) && is_array($data['product_catalog_sanphamnoibat2'] ) && count($data['product_catalog_sanphamnoibat2'] )){
			foreach($data['product_catalog_sanphamnoibat2']  as $key => $val) {
				$data['product_catalog_sanphamnoibat2'] [$key]['post'] = $this->FrontendProducts_Model->_read_condition(array(
					'modules' => 'products',
					'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`, `pr`.`tmp_active_phamtramgiamgia`, `pr`.`active_phamtramgiamgia`',
					'where' => '`pr`.`parentid` = 0 AND `pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
					'limit' => 4,
					'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
					'cataloguesid' => $val['id'],
				));

			}
		}

//		if (!$product_catalog = $this->cache->get('product_catalog')) {
//			$product_catalog = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
//				'select' => 'id, title, slug, canonical, images, limit_home, limit_parent, lft, rgt',
//				'where' => array('trash' => 0,'publish' => 1, 'ishome' => 1, 'alanguage' => ''.$this->fc_lang.''),
//				'limit' => 3,
//				'order_by' => 'order asc, id desc'
//			));
//			if(isset($product_catalog) && is_array($product_catalog) && count($product_catalog)){
//				foreach($product_catalog as $key => $val){
//					// Danh mục con
//					$product_catalog[$key]['child'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
//						'select' => 'id, title, slug, canonical, images, lft, rgt, limit_home',
//						'where' => array('trash' => 0,'publish' => 1, 'parentid' => $val['id'], 'alanguage' => ''.$this->fc_lang.''),
//						'limit' => ((!empty($val['limit_parent'])) ? $val['limit_parent'] : 3),
//						'order_by' => 'order asc, id desc',
//					));
//					// Sản phẩm thuộc danh mục con
//					if(isset($product_catalog[$key]['child']) && is_array($product_catalog[$key]['child']) && count($product_catalog[$key]['child'])){
//						foreach($product_catalog[$key]['child'] as $keyp => $valp){
//							$product_catalog[$key]['child'][$keyp]['post'] = $this->FrontendProducts_Model->_read_condition(array(
//								'modules' => 'products',
//								'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`',
//								'where' => '`pr`.`parentid` = 0 AND `pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
//								'limit' => ((!empty($valp['limit_home'])) ? $valp['limit_home'] : 8),
//								'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
//								'cataloguesid' => $valp['id'],
//							));
//						}
//					}
//					// Sản phẩm thuộc danh mục lớn
//					$product_catalog[$key]['post'] = $this->FrontendProducts_Model->_read_condition(array(
//						'modules' => 'products',
//						'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`price`, `pr`.`saleoff`, `pr`.`count_order`',
//						'where' => '`pr`.`parentid` = 0 AND `pr`.`trash` = 0 AND `pr`.`publish` = 1  AND `pr`.`alanguage` = \''.$this->fc_lang.'\'',
//						'limit' => ((!empty($val['limit_home'])) ? $val['limit_home'] : 8),
//						'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
//						'cataloguesid' => $val['id'],
//					));
//				}
//			}
//			$data['product_catalog'] = $product_catalog;
//			$this->cache->save('product_catalog', $product_catalog, 300);
//		}else{
//			$data['product_catalog'] = $product_catalog;
//		}




		if (!$CountAllTags = $this->cache->get('CountAllTags')) {
			$CountAllTags = $this->FrontendTags_Model->ReadTagsCondition(array('highlight' => 1), 9);
			$data['CountAllTags'] = $CountAllTags;
			$this->cache->save('CountAllTags', $CountAllTags, 300);
		}else{
			$data['CountAllTags'] = $CountAllTags;
		}

		
		$data['meta_title'] = $this->fcSystem['seo_meta_title'];
		$data['meta_keyword'] = $this->fcSystem['seo_meta_keywords'];
		$data['meta_description'] = $this->fcSystem['seo_meta_description'];
		$data['template'] = 'homepage/frontend/home/index';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}

	
	public function Sitemap($type = 'html'){
		$data['ArticlesNews'] = $this->FrontendArticles_Model->ReadAllForSitemap($this->fc_lang, 0, 0, 100 );
		$data['ArticlesCatalogues'] = $this->FrontendArticlesCatalogues_Model->ReadAllForSitemap($this->fc_lang);
		$this->load->view('homepage/frontend/home/sitemap_'.$type, isset($data)?$data:NULL);
	}
	public function email(){
		$data['email'] = $this->input->post('email');
		$data['message'] = 'Đăng ký nhận phiếu giảm giá'; 
		if(isset($data) && is_array($data) && count($data)){
			$this->db->insert('contacts', $data);
			$result = $this->db->affected_rows();
			$this->db->flush_cache();
		}
		if($result > 0){
			echo 'Gửi đăng kí thành công, chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất';die();
		}
	}
	
	public function Active_code($page = 1){
		$page = (int)$page;
		$data['meta_title'] = 'Đăng ký trực tuyến';
		$data['meta_keywords'] = '';
		$data['meta_description'] = '';

		if($this->input->post('create')){

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('fullname', 'Họ và tên', 'trim|required');
			$this->form_validation->set_rules('phone', 'Số đện thoại', 'trim|required|is_natural');
			$this->form_validation->set_rules('cityid', 'Tỉnh / Thành phố', 'trim|callback__City');
			$this->form_validation->set_rules('register', 'Nơi đăng ký', 'trim|required');
			$this->form_validation->set_rules('register-2', 'Nơi nhập học', 'trim|required');
			if ($this->form_validation->run($this)){
				$resultid = $this->Frontendmailsubricre_Model->Create_arr();
				if($resultid > 0){
					$this->session->set_flashdata('message-success', 'Cảm ơn bạn đã đăng ký nhóm của chúng tôi! Chúng tôi sẽ liên lạc với bạn ngay.');
					redirect('dang-ky-truc-tuyen');
				}
			}
		}
		
		$data['template'] = 'homepage/frontend/home/active_code';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	public function _City() {
		$cityid = $this->input->post('cityid');
		if(!isset($cityid) || $cityid == 0 || $cityid == '') {
			$this->form_validation->set_message('_City','Tỉnh / Thành phố trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
	public function _Degree() {
		$degree = $this->input->post('degree');
		if(!isset($degree) || $degree == 0 || $degree == '') {
			$this->form_validation->set_message('_Degree','Trình độ học vấn trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
	public function _Form() {
		$form = $this->input->post('form');
		if(!isset($form) || $form == 0 || $form == '') {
			$this->form_validation->set_message('_Form','Hình thức làm việc trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
	public function _Money() {
		$money = $this->input->post('money');
		if(!isset($money) || $money == 0 || $money == '') {
			$this->form_validation->set_message('_Money','Mức lương trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
	public function _Classify() {
		$classify = $this->input->post('classify');
		if(!isset($classify) || $classify == 0 || $classify == '') {
			$this->form_validation->set_message('_Classify','Xếp loại tốt nghiệp trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
}
