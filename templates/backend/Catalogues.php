<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
		$this->load->library('nestedsetbie', array('table' => 'products_catalogues'));
	}

	public function View($id = 0, $page = 1){
		$id = (int)$id;
		$page = (int)$page;
		$seoPage = '';
		$DetailCatalogues = $this->FrontendProductsCatalogues_Model->ReadByField('id', $id);
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục sản phẩm không tồn tại');
			redirect(base_url());
		}
		$data['Breadcrumb'] = $this->FrontendProductsCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt']);
		$data['modules'] = 'products_catalogues';
		
		if($DetailCatalogues['rgt'] - $DetailCatalogues['lft'] > 1){
			
			$data['child'] = $this->FrontendProductsCatalogues_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, attributes',
				'table' => 'products_catalogues',
				'where' => array('publish' => 1,'trash' => 0,'parentid' => $DetailCatalogues['id']),
				'limit' => 10,
				'order_by' => 'order asc, id desc',
			), TRUE);
			if(isset($data['child']) && is_array($data['child']) && count($data['child'])){
				foreach($data['child'] as $keyChild => $valChild){
					$attribute_decode = json_decode($valChild['attributes'], TRUE);
					$data['child'][$keyChild]['attribute'] = $this->Autoload_Model->_get_where(array(
						'select' => 'id, title, slug, canonical',
						'table' => 'attributes',
						'where' => array('publish' => 1,'trash' => 0,'cataloguesid' => 3),
						'where_in' => $attribute_decode['attribute_catalogue'],
						'where_in_field' => 'id',
					), TRUE);
					
					$data['child'][$keyChild]['post'] = $this->FrontendProducts_Model->_read_condition(array(
						'modules' => 'products',
						'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`created`, `pr`.`price`, `pr`.`saleoff`, `pr`.`code`',
						'limit' => 5,
						'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
						'cataloguesid' => $valChild['id'],
					));
				}
				foreach($data['child'] as $key => $val){
					if(isset($val['post']) && is_array($val['post']) && count($val['post'])){
						foreach($val['post'] as $keyPost => $valPost){
							$data['child'][$key]['post'][$keyPost]['attributes'] = $this->FrontendProducts_Model->AttributesAllTheTime($valPost['id']);
						}
					}
				}
			}
			
			
			$data['canonical'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'products_catalogues');
			$data['template'] = 'products/frontend/catalogues/view';
		}else{
			

			
			$config['total_rows'] = $this->FrontendProducts_Model->_count(array(
				'select' => '`pr`.`id`',
				'modules' => 'products',
			), $DetailCatalogues);
			$config['base_url'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'products_catalogues', FALSE, TRUE);
			if($config['total_rows'] > 0){
				$this->load->library('pagination');
				$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
				$config['prefix'] = 'trang-';
				$config['first_url'] = $config['base_url'].$config['suffix'];
				$config['per_page'] = 24;
				$config['uri_segment'] = 2;
				$config['use_page_numbers'] = TRUE;
				$config['full_tag_open'] = '<div class="pagination"><ul class="uk-pagination uk-pagination-left">';
				$config['full_tag_close'] = '</ul></div>';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="uk-active"><a>';
				$config['cur_tag_close'] = '</a></li>';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['prev_tag_open'] = '<li>';
				$config['prev_tag_close'] = '</li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$this->pagination->initialize($config);
				$data['PaginationList'] = $this->pagination->create_links();
				$totalPage = ceil($config['total_rows']/$config['per_page']);
				$page = ($page <= 0)?1:$page;
				$page = ($page > $totalPage)?$totalPage:$page;
				$seoPage = ($page >= 2)?(' - Trang '.$page):'';
				if($page >= 2){
					$data['canonical'] = $config['base_url'].'/trang-'.$page.$this->config->item('url_suffix');
				}
				$page = $page - 1;
				$data['productsList'] = $this->FrontendProducts_Model->_view(array(
					'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`price`, `pr`.`saleoff`, `pr`.`code`',
					'modules' => 'products',
					'start' => ($page * $config['per_page']),
					'limit' => $config['per_page'],
				), $DetailCatalogues);
			}
			if(isset($data['productsList']) && is_array($data['productsList']) && count($data['productsList'])){
				foreach($data['productsList'] as $key => $val){
					$data['productsList'][$key]['attributes'] = $this->FrontendProducts_Model->AttributesAllTheTime($val['id']);
				}
			}
			$data['template'] = 'products/frontend/catalogues/child';
		}
		
		
		
		
		$data['meta_title'] = (!empty($DetailCatalogues['meta_title'])?$DetailCatalogues['meta_title']:$DetailCatalogues['title']).$seoPage;
		$data['meta_keyword'] = $DetailCatalogues['meta_keyword'];
		$data['meta_description'] = (!empty($DetailCatalogues['meta_description'])?$DetailCatalogues['meta_description']:cutnchar(strip_tags($DetailCatalogues['description']), 255)).$seoPage;
		$data['meta_images'] = !empty($DetailCatalogues['images'])?base_url($DetailCatalogues['images']):'';
		$data['DetailCatalogues'] = $DetailCatalogues;
		if(!isset($data['canonical']) || empty($data['canonical'])){
			$data['canonical'] = $config['base_url'].$this->config->item('url_suffix');
		}
		
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
}
