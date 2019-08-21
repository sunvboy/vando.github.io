<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fc_lang = $this->config->item('fc_lang');
		$this->fcCustomer = $this->config->item('fcCustomer');
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		$this->load->library(array('configbie'));
		/* -------------------------- */
	}

	public function View($id = 0){
		$id = (int)$id;
		$DetailProducts = $this->FrontendProducts_Model->ReadByField('id', $id, $this->fc_lang );
		if(!isset($DetailProducts) && !is_array($DetailProducts) && count($DetailProducts) == 0){
			$this->session->set_flashdata('message-danger',  $this->lang->line('error_products_detail'));
			redirect(base_url());
		}
		$DetailCatalogues = $this->FrontendProductsCatalogues_Model->ReadByField('id', $DetailProducts['cataloguesid'], $this->fc_lang );
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger',  $this->lang->line('error_products_catalogues'));
			redirect(base_url());
		}

		//Trafix Affiliate
	 	$affiliate = (isset($_COOKIE['affiliate'])) ? $_COOKIE['affiliate'] : '';
	 	if (!empty($affiliate)) {
	 		$affiliate_customers = $this->FrontendCustomers_Model->ReadByField('affiliate_id', $affiliate);
	 		if(isset($affiliate_customers) && is_array($affiliate_customers) && count($affiliate_customers)){
				// Nếu tồn tại mã Affilte của thành viên thường
				// Cập nhật lượt traffix 
				// 
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				$remote_addr = $_SERVER['REMOTE_ADDR'];
				// Kiểm tra thông tin người dùng truy cập, Nếu IP truy cập và sp truy cập đã tồn tại bỏ qua quá trình cập nhật trafix
				$check_trafix = $this->FrontendProducts_Model->_read(array(
					'table' => 'products_trafix_affiliate',
					'where' => array('remote_addr' => $remote_addr, 'productsid' => $DetailProducts['id'], 'affiliate_id' => $affiliate)
				));
				if (!isset($check_trafix) && !is_array($check_trafix) && count($check_trafix) == 0) {
					$insert_trafix = $this->FrontendProducts_Model->_create(array(
						'table' => 'products_trafix_affiliate',
						'data' => array(
							'affiliate_id' => $affiliate,
							'productsid' => $DetailProducts['id'],
							'user_agent' => $user_agent,
							'remote_addr' => $remote_addr,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						),
					));
				}
			}
	 	}
		// 
		
		// UPdate Feild
		$this->FrontendProducts_Model->UpdateViewed('id', $DetailProducts['id'], $this->fc_lang);
		$data['Breadcrumb'] = $this->FrontendProductsCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt'], $this->fc_lang);
		$data['TagsList'] = $this->FrontendTags_Model->ReadByModule($id, 'products');

		$data['idgoc'] = showcatidgoc($DetailCatalogues['id'], $DetailCatalogues['parentid'], 'products');
		$data['parentid_cat'] = $this->FrontendGallerysCatalogues_Model->ReadAllByField('parentid', $data['idgoc'], $this->fc_lang);
		
		$data['products_cat'] = $this->FrontendProductsCatalogues_Model->ReadByCondition(array(
            'select' => 'id, title, slug, canonical, description, lft, rgt, parentid',
            'where' => array('trash' => 0,'publish' => 1, 'alanguage' => ''.$this->fc_lang.''),
            'order_by' => 'order asc, id desc',
        ));

		$cataloguesid = $this->FrontendProducts_Model->_get_where(array(
			'select' => 'cataloguesid',
			'table' => 'catalogues_relationship',
			'where' => array(
				'modulesid' => $id,
				'modules' => 'products',
			),
		), TRUE);
		
		$data['products_same'] = $this->FrontendProducts_Model->_read_condition(array(
			'modules' => 'products',
			'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`,`pr`.`price`, `pr`.`saleoff`, `pr`.`psale`, `pr`.`description`, `pr`.`count_order`',
			'where' => '`pr`.`trash` = 0 AND `pr`.`id` != '.$id.' AND `pr`.`publish` = 1 AND `pr`.`alanguage` = \''.$this->fc_lang .'\'',
			'limit' => 6,
			'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
		), $cataloguesid);

		$data['products_care'] = $this->FrontendProducts_Model->_get_where(array(
            'select' => 'id, title, slug, canonical, images, price, saleoff, count_order',
            'table' => 'products',
            'where' => array('trash' => 0,'publish' => 1, 'alanguage' => ''.$this->fc_lang.''),
            'limit' => 8,
            'order_by' => 'rand()',
        ), TRUE);

        $data['module'] = 'products';
        $data['moduleid'] = $DetailProducts['id'];

		$data['urlbl'] = rewrite_url($DetailProducts['canonical'], $DetailProducts['slug'], $DetailProducts['id'], 'products');
		$data['meta_title'] = !empty($DetailProducts['meta_title'])?$DetailProducts['meta_title']:$DetailProducts['title'];
		$data['meta_keyword'] = $DetailProducts['meta_keyword'];
		$data['meta_description'] = !empty($DetailProducts['meta_description'])?$DetailProducts['meta_description']:cutnchar(strip_tags($DetailProducts['description']), 255);
		$data['meta_images'] = !empty($DetailProducts['images'])?base_url($DetailProducts['images']):'';
		$data['DetailProducts'] = $DetailProducts;
		$data['DetailCatalogues'] = $DetailCatalogues;
		$data['canonical'] = rewrite_url($DetailProducts['canonical'], $DetailProducts['slug'], $DetailProducts['id'], 'products', TRUE, TRUE);
		$data['template'] = 'products/frontend/products/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
		
	}
}
