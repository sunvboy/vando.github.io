<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends FC_Controller{
	
	public $action;
	
	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array(
			'BackendProducts_Model',
			'BackendProductsCatalogues_Model',
			'BackendProductsChapter_Model',
			'tags/BackendTags_Model',
			'routers/BackendRouters_Model',
			'teachers/BackendTeachers_Model'
		));
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'products_catalogues'));
		
		$this->action = array(
			'publish' => 'Xuất bản',
			'highlight' => 'Nổi bật'
		);
		
	}

	public function View($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/products/view'
		));
		$page = (int)$page;
		$products_id = '';
		$userid = 0;
		$where = '';
		$cataloguesid = $this->input->get('cataloguesid');
		$filter = $this->input->get('filter');
		if($cataloguesid > 0){
			$products_id = catalogues_relationship($cataloguesid, 'products', array('BackendProducts','BackendProductsCatalogues'), 'products_catalogues');
		}
		if(in_array('products/backend/products/limit', $this->fcUser['group']) == FALSE){
			$userid = $this->fcUser['id'];
		}
		if(isset($this->action[$filter])){
			$where = array($filter => 1);
		}else{
			$prefix = substr($filter, 2);
			if(!empty($prefix)){
				$where = array($prefix.'<=' => 0);
			}
		}
		$config['total_rows'] = $this->BackendProducts_Model->CountAll($products_id, array('userid' => $userid,'where' => $where), $this->fclang);
		// echo $this->db->last_query();die;
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('products/backend/products/view');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
			$config['full_tag_close'] = '</ul>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['ListPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['Listproducts'] = $this->BackendProducts_Model->ReadAll(($page * $config['per_page']), $config['per_page'], $products_id, array('userid' => $userid, 'where' => $where), $this->fclang);	
		}
		$data['template'] = 'products/backend/products/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Create(){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/products/create'
		));
		if($this->input->post('create')){
			$attr = $this->input->post('attr');
			$data['tagsid'] = $this->input->post('tagsid');
			$data['avatar'] = $this->input->post('images');
			$data['type_aff'] = $this->input->post('type_aff');
			$data['catalogue'] = $this->input->post('catalogue'); // mảng danh mục
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'sản phẩm', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim|required');
			$this->form_validation->set_rules('saleoff', 'Giá sản phẩm', 'trim|required');
			// $this->form_validation->set_rules('content', 'Nội dung', 'trim|required');
			if ($this->form_validation->run($this)){

				// Đa Phiên bản

				// $option = $this->input->post('option');
				// $attributes_data = '';
				// if(isset($option['title']) && is_array($option['title'])  && count($option['title'])) {
				// 	foreach ($option['title'] as $key => $val) {
				// 		$attributes_data[] = array('title' => $val); 
				// 	}
				// }
				// if(isset($attributes_data) && is_array($attributes_data)  && count($attributes_data) && isset($option['attribute']) && is_array($option['attribute']) && count($option['attribute']) && isset($option['stt']) && is_array($option['stt']) && count($option['stt']) && isset($option['count']) && is_array($option['count']) && count($option['count'])) {
				// 	foreach ($attributes_data as $key => $val) {
				// 		$attributes_data[$key]['attribute'] = $option['attribute'][$key];
				// 		$attributes_data[$key]['stt'] = $option['stt'][$key];
				// 		$attributes_data[$key]['count'] = $option['count'][$key];
				// 	}
				// }

				// print_r($attributes_data);die;

				// Triết khấu Affilate
				$discount = $this->input->post('discount');
				$discount_data = '';
				if(isset($discount['level']) && is_array($discount['level'])  && count($discount['level'])) {
					foreach ($discount['level'] as $key => $val) {
						$discount_data[] = array('level' => $val); 
					}
				}
				if(isset($discount_data) && is_array($discount_data)  && count($discount_data) && isset($discount['count']) && is_array($discount['count']) && count($discount['count'])) {
					foreach ($discount_data as $key => $val) {
						$discount_data[$key]['count'] = $discount['count'][$key];
					}
				}

				// Phí vận chuyển
				$shipcode = $this->input->post('shipcode');
				$shipcode_data = '';
				if(isset($shipcode['shop']) && is_array($shipcode['shop'])  && count($shipcode['shop'])) {
					foreach ($shipcode['shop'] as $key => $val) {
						$shipcode_data[] = array('level' => $val); 
					}
				}
				if(isset($shipcode_data) && is_array($shipcode_data)  && count($shipcode_data) && isset($shipcode['inner']) && is_array($shipcode['inner']) && count($shipcode['inner'])&& isset($shipcode['outner']) && is_array($shipcode['outner']) && count($shipcode['outner'])) {
					foreach ($shipcode_data as $key => $val) {
						$shipcode_data[$key]['inner'] = $shipcode['inner'][$key];
						$shipcode_data[$key]['outner'] = $shipcode['outner'][$key];
					}
				}
				//albums ảnh
				$album = $this->input->post('album');
				$album_data = '';
				if(isset($album['images']) && is_array($album['images'])  && count($album['images'])) {
					foreach ($album['images'] as $key => $val) {
						$album_data[] = array('images' => $val); 
					}
				}

				//end albums ảnh
				//size
				$albumsize = $this->input->post('albumsize');
				$album_data_size = '';
				if(isset($albumsize['title']) && is_array($albumsize['title'])  && count($albumsize['title'])) {
					foreach ($albumsize['title'] as $key => $val) {
						$album_data_size[] = array('title' => $val);
					}
				}
				if(isset($album_data_size) && is_array($album_data_size)  && count($album_data_size)
					&& isset($albumsize['saleoff']) && is_array($albumsize['saleoff']) && count($albumsize['saleoff'])
					&& isset($albumsize['chieucao']) && is_array($albumsize['chieucao']) && count($albumsize['chieucao'])
					&& isset($albumsize['cannang']) && is_array($albumsize['cannang']) && count($albumsize['cannang'])
					&& isset($albumsize['sodovong']) && is_array($albumsize['sodovong']) && count($albumsize['sodovong'])) {
						foreach ($album_data_size as $key => $val) {
							$album_data_size[$key]['saleoff'] = $albumsize['saleoff'][$key];
							$album_data_size[$key]['chieucao'] = $albumsize['chieucao'][$key];
							$album_data_size[$key]['cannang'] = $albumsize['cannang'][$key];
							$album_data_size[$key]['sodovong'] = $albumsize['sodovong'][$key];
						}
				}
				$items_sizes = json_encode($album_data_size);
				$list_items_sizes = json_decode($items_sizes,TRUE);
				//end size
				//color
				$albumcolor = $this->input->post('albumcolor');
				$album_data_color = '';
				if(isset($albumcolor['images']) && is_array($albumcolor['images'])  && count($albumcolor['images'])) {
					foreach ($albumcolor['images'] as $key => $val) {
						$album_data_color[] = array('images' => $val);
					}
				}
				if(isset($album_data_color) && is_array($album_data_color)  && count($album_data_color) && isset($albumcolor['title']) && is_array($albumcolor['title']) && count($albumcolor['title'])&& isset($albumcolor['images_0']) && is_array($albumcolor['images_0']) && count($albumcolor['images_0']) && isset($albumcolor['images_1']) && is_array($albumcolor['images_1']) && count($albumcolor['images_1']) && isset($albumcolor['images_2']) && is_array($albumcolor['images_2']) && count($albumcolor['images_2'])&& isset($albumcolor['images_3']) && is_array($albumcolor['images_3']) && count($albumcolor['images_3']) && isset($albumcolor['images_4']) && is_array($albumcolor['images_4']) && count($albumcolor['images_4'])&& isset($albumcolor['images_5']) && is_array($albumcolor['images_5']) && count($albumcolor['images_5']) && isset($albumcolor['images_6']) && is_array($albumcolor['images_6']) && count($albumcolor['images_6'])&& isset($albumcolor['images_7']) && is_array($albumcolor['images_7']) && count($albumcolor['images_7'])&& isset($albumcolor['images_8']) && is_array($albumcolor['images_8']) && count($albumcolor['images_8'])&& isset($albumcolor['images_9']) && is_array($albumcolor['images_9']) && count($albumcolor['images_9'])) {
					foreach ($album_data_color as $key => $val) {
						$album_data_color[$key]['title'] = $albumcolor['title'][$key];
						for($i=0;$i<=9;$i++){
							$album_data_color[$key]['images_'.$i.''] = $albumcolor['images_'.$i.''][$key];
						}
					}
				}
				$items_colors = json_encode($album_data_color);
				$list_items_colors = json_decode($items_colors,TRUE);
				//end color
				$resultid = $this->BackendProducts_Model->Create($this->fcUser,$data['catalogue'], $album_data,$album_data_size,$album_data_color, $shipcode_data, $this->fclang);
				if($resultid > 0){
					//thêm router
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Create($canonical, 'products/frontend/products/view', $resultid, 'number');
					}
					//end
					//thêm mảng danh mục
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'products',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendProducts_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					//end
					//thêm vào bảng size
					$size = '';
					foreach($list_items_sizes as $key=>$val){
						if($val['saleoff'] != ''){
							$saleoff_sale = $val['saleoff'];
						}else{
							$saleoff_sale = '';
						}
						$size[] = array(
							'title' => trim($val['title']),
							'saleoff' => trim($saleoff_sale),
							'chieucao' => trim($val['chieucao']),
							'cannang' => trim($val['cannang']),
							'sodovong' => trim($val['sodovong']),
							'productsid' => $resultid,
							'modules' => 'products',
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendProducts_Model->create_batch(array('data' => $size,'table' => 'products_size'));
					//end
					//thêm vào bảng color
					$color = '';
					foreach($list_items_colors as $key=>$val){

						$color[] = array(
							'title' => trim($val['title']),
							'images' => $val['images'],
							'productsid' => $resultid,
							'modules' => 'products',
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
							'images_0' => $val['images_0'],
							'images_1' => $val['images_1'],
							'images_2' => $val['images_2'],
							'images_3' => $val['images_3'],
							'images_4' => $val['images_4'],
							'images_5' => $val['images_5'],
							'images_6' => $val['images_6'],
							'images_7' => $val['images_7'],
							'images_8' => $val['images_8'],
							'images_9' => $val['images_9'],
						);
					}
					$this->BackendProducts_Model->create_batch(array('data' => $color,'table' => 'products_color'));
					//end
					//thêm tag
					$this->BackendTags_Model->InsertByModule($resultid, 'products');
					//end
					//thêm bộ lọc
					$this->BackendAttributes_Model->InsertAttr($resultid, $attr);
					//end thêm bộ lọc
					// Thêm bản ghi thuộc tính cho phiên bản sản phẩm
					// $this->BackendProducts_Model->CreateAttr($resultid, $attributes_data);
					// Thêm bản ghi triết khấu cho tk Affiliate mới
					$this->BackendProducts_Model->CreateAff($resultid, $discount_data);
					// Xóa cache Frontend
					$this->cache->clean();
					$this->session->set_flashdata('message-success', 'Thêm sản phẩm mới thành công');
					redirect('products/backend/products/view');
				}
			}
			$_attribute_cat = '';
			$radio_cat_checked = $this->input->post('cataloguesid');
			$data['attr'] = $this->input->post('attr');
			$cat_checked = $this->BackendProductsCatalogues_Model->ReadByField('id', $radio_cat_checked, $this->fclang);
			$cat_checked = json_decode($cat_checked['attributes'], TRUE);
			$data['cat_checked'] = $cat_checked;
		}
		
		$data['attribute_catalogues'] = $this->BackendAttributesCatalogues_Model->AttributesCataloguesList(FALSE);
		if(isset($data['attribute_catalogues']) && is_array($data['attribute_catalogues']) && count($data['attribute_catalogues'])){
			foreach($data['attribute_catalogues'] as $key => $val){
				$data['attribute_catalogues'][$key]['attributes'] = $this->BackendAttributes_Model->ReadAtrributes($val['id']);
			}
		}
		
		$data['template'] = 'products/backend/products/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Read($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/products/read'
		));
		$id = (int)$id;
		$data['DetailProducts'] = $this->BackendProducts_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0){
			$this->session->set_flashdata('message-danger', 'sản phẩm không tồn tại');
			redirect_custom('products/backend/products/view');
		}
		$data['template'] = 'products/backend/products/read';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/products/update'
		));
		$id = (int)$id;
		$data['DetailProducts'] = $this->BackendProducts_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0){
			$this->session->set_flashdata('message-danger', 'sản phẩm không tồn tại');
			redirect_custom('products/backend/products/view');
		}
		$data['tagsid'] = $this->BackendTags_Model->ReadByModule($id, 'products');
		$data['catalogue'] = json_decode($data['DetailProducts']['catalogues'], TRUE);
		$catalogues = $this->input->post('catalogue');
		if($this->input->post('update')){
			$attr = $this->input->post('attr');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'sản phẩm', 'trim|required');
			$this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
			$this->form_validation->set_rules('cataloguesid', 'Breadcrumb', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Danh mục cha', 'trim|callback__Catalogue');
			$this->form_validation->set_rules('description', 'Mô tả', 'trim|required');
			// $this->form_validation->set_rules('content', 'Nội dung', 'trim|required');
			if ($this->form_validation->run($this)){

				// Thuộc tính thêm cho sản phẩm

//				$attr_advanced = $this->input->post('option');
//				$check_att_advanced = $this->input->post('check_att_advanced');
//				$attr_advanced_data = '';
//				if(isset($attr_advanced['title']) && is_array($attr_advanced['title'])  && count($attr_advanced['title'])) {
//					foreach ($attr_advanced['title'] as $key => $val) {
//						$attr_advanced_data[] = array('title' => $val);
//					}
//				}
//				if(isset($attr_advanced_data) && is_array($attr_advanced_data)  && count($attr_advanced_data) && isset($attr_advanced['attribute']) && is_array($attr_advanced['attribute']) && count($attr_advanced['attribute'])) {
//					foreach ($attr_advanced_data as $key => $val) {
//						$attr_advanced_data[$key]['attribute'] = $attr_advanced['attribute'][$key];
//						$attr_advanced_data[$key]['productsid'] = $data['DetailProducts']['id'];
//						if (isset($attr_advanced['id']) && is_array($attr_advanced['id']) && count($attr_advanced['id']) && !empty($attr_advanced['id'])) {
//							$attr_advanced_data[$key]['id'] = $attr_advanced['id'][$key];
//						}
//					}
//				}

				// Ghi thuộc tính cho sản phẩm
				
//				$version = $this->input->post('version');
//				$version_data = '';
//				if(isset($version['title']) && is_array($version['title'])  && count($version['title'])) {
//					foreach ($version['title'] as $key => $val) {
//						$version_data[] = array('title' => $val);
//					}
//				}
//				if(isset($version_data) && is_array($version_data)  && count($version_data) && isset($version['quantity']) && is_array($version['quantity']) && count($version['quantity']) && isset($version['count_order']) && is_array($version['count_order']) && count($version['count_order']) && isset($version['sku']) && is_array($version['sku']) && count($version['sku'])) {
//					foreach ($version_data as $key => $val) {
//						$version_data[$key]['productsid'] = $data['DetailProducts']['id'];
//						$version_data[$key]['price'] = $version['price'][$key];
//						$version_data[$key]['sku'] = $version['sku'][$key];
//						$version_data[$key]['saleoff'] = $version['saleoff'][$key];
//						$version_data[$key]['quantity'] = $version['quantity'][$key];
//						$version_data[$key]['count_order'] = $version['count_order'][$key];
//						if (isset($version['id']) && is_array($version['id']) && count($version['id']) && !empty($version['id'])) {
//							$version_data[$key]['id'] = $version['id'][$key];
//						}
//					}
//				}


				// Triết khấu Affiliate
				$discount = $this->input->post('discount');
				$discount_data = '';
				if(isset($discount['level']) && is_array($discount['level'])  && count($discount['level'])) {
					foreach ($discount['level'] as $key => $val) {
						$discount_data[] = array('level' => $val); 
					}
				}
				if(isset($discount_data) && is_array($discount_data)  && count($discount_data) && isset($discount['count']) && is_array($discount['count']) && count($discount['count'])) {
					foreach ($discount_data as $key => $val) {
						$discount_data[$key]['count'] = $discount['count'][$key];
					}
				}

				// Phí vận chuyển
				$shipcode = $this->input->post('shipcode');
				$shipcode_data = '';
				if(isset($shipcode['shop']) && is_array($shipcode['shop'])  && count($shipcode['shop'])) {
					foreach ($shipcode['shop'] as $key => $val) {
						$shipcode_data[] = array('shop' => $val); 
					}
				}
				if(isset($shipcode_data) && is_array($shipcode_data)  && count($shipcode_data) && isset($shipcode['inner']) && is_array($shipcode['inner']) && count($shipcode['inner'])&& isset($shipcode['outner']) && is_array($shipcode['outner']) && count($shipcode['outner'])) {
					foreach ($shipcode_data as $key => $val) {
						$shipcode_data[$key]['inner'] = $shipcode['inner'][$key];
						$shipcode_data[$key]['outner'] = $shipcode['outner'][$key];
					}
				}
				$album = $this->input->post('album');
				$album_data = '';
				if(isset($album['images']) && is_array($album['images'])  && count($album['images'])) {
					foreach ($album['images'] as $key => $val) {
						$album_data[] = array('images' => $val); 
					}
				}
				if(isset($album_data) && is_array($album_data)  && count($album_data) && isset($album['title']) && is_array($album['title']) && count($album['title']) && isset($album['description']) && is_array($album['description']) && count($album['description'])) {
					foreach ($album_data as $key => $val) {
						$album_data[$key]['title'] = $album['title'][$key];
						$album_data[$key]['description'] = $album['description'][$key];
					}
				}
				//size
				$albumsize = $this->input->post('albumsize');
				$album_data_size = '';
				if(isset($albumsize['title']) && is_array($albumsize['title'])  && count($albumsize['title'])) {
					foreach ($albumsize['title'] as $key => $val) {
						$album_data_size[] = array('title' => $val);
					}
				}
				if(isset($album_data_size) && is_array($album_data_size)  && count($album_data_size)
					&& isset($albumsize['saleoff']) && is_array($albumsize['saleoff']) && count($albumsize['saleoff'])
					&& isset($albumsize['chieucao']) && is_array($albumsize['chieucao']) && count($albumsize['chieucao'])
					&& isset($albumsize['cannang']) && is_array($albumsize['cannang']) && count($albumsize['cannang'])
					&& isset($albumsize['sodovong']) && is_array($albumsize['sodovong']) && count($albumsize['sodovong'])) {
					foreach ($album_data_size as $key => $val) {
						$album_data_size[$key]['saleoff'] = $albumsize['saleoff'][$key];
						$album_data_size[$key]['chieucao'] = $albumsize['chieucao'][$key];
						$album_data_size[$key]['cannang'] = $albumsize['cannang'][$key];
						$album_data_size[$key]['sodovong'] = $albumsize['sodovong'][$key];
					}
				}

				//end size
				//color
				$albumcolor = $this->input->post('albumcolor');
				$album_data_color = '';
				if(isset($albumcolor['images']) && is_array($albumcolor['images'])  && count($albumcolor['images'])) {
					foreach ($albumcolor['images'] as $key => $val) {
						$album_data_color[] = array('images' => $val);
					}
				}


				if(isset($album_data_color) && is_array($album_data_color)  && count($album_data_color)

					&& isset($albumcolor['title']) && is_array($albumcolor['title']) && count($albumcolor['title'])
					&& isset($albumcolor['images_0']) && is_array($albumcolor['images_0']) && count($albumcolor['images_0'])
					&& isset($albumcolor['images_1']) && is_array($albumcolor['images_1']) && count($albumcolor['images_1'])
					&& isset($albumcolor['images_2']) && is_array($albumcolor['images_2']) && count($albumcolor['images_2'])
					&& isset($albumcolor['images_3']) && is_array($albumcolor['images_3']) && count($albumcolor['images_3'])
					&& isset($albumcolor['images_4']) && is_array($albumcolor['images_4']) && count($albumcolor['images_4'])
					&& isset($albumcolor['images_5']) && is_array($albumcolor['images_5']) && count($albumcolor['images_5'])
					&& isset($albumcolor['images_6']) && is_array($albumcolor['images_6']) && count($albumcolor['images_6'])
					&& isset($albumcolor['images_7']) && is_array($albumcolor['images_7']) && count($albumcolor['images_7'])
					&& isset($albumcolor['images_8']) && is_array($albumcolor['images_8']) && count($albumcolor['images_8'])
					&& isset($albumcolor['images_9']) && is_array($albumcolor['images_9']) && count($albumcolor['images_9'])


				) {
					foreach ($album_data_color as $key => $val) {
						$album_data_color[$key]['title'] = $albumcolor['title'][$key];
						for($i=0;$i<=9;$i++){
							$album_data_color[$key]['images_'.$i.''] = $albumcolor['images_'.$i.''][$key];
						}
					}
				}
				//end color
				$items_sizes = json_encode($album_data_size);
				$list_items_sizes = json_decode($items_sizes,TRUE);
				$items_colors = json_encode($album_data_color);
				$list_items_colors = json_decode($items_colors,TRUE);
				$flag = $this->BackendProducts_Model->UpdateByPost('id', $id, $this->fcUser, $catalogues, $album_data,$album_data_size,$album_data_color, $shipcode_data);
				if($flag > 0){
					//mảng danh mục
					$temp = '';
					foreach($catalogues as $key => $val){
						$temp[] = array(
							'modules' => 'products',
							'modulesid' => $id,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendProducts_Model->_delete_batch('modulesid', $id,'catalogues_relationship','products');
					$this->BackendProducts_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					//end mảng danh mục
					//mảng size
					$size = '';
					foreach($list_items_sizes as $key=>$val){
						if($val['saleoff'] != ''){
							$saleoff_sale = $val['saleoff'];
						}else{
							$saleoff_sale = '';
						}
						$size[] = array(
							'title' => trim($val['title']),
							'saleoff' => trim($saleoff_sale),
							'chieucao' => trim($val['chieucao']),
							'cannang' => trim($val['cannang']),
							'sodovong' => trim($val['sodovong']),
							'productsid' => $id,
							'modules' => 'products',
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					$this->BackendProducts_Model->_delete_batch('productsid', $id,'products_size','products');
					$this->BackendProducts_Model->create_batch(array('data' => $size,'table' => 'products_size'));
					//end mảng size
					//thêm vào bảng color
					$color = '';
					foreach($list_items_colors as $key=>$val){

						$color[] = array(
							'title' => trim($val['title']),
							'images' => $val['images'],
							'productsid' => $id,
							'modules' => 'products',
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
							'images_0' => $val['images_0'],
							'images_1' => $val['images_1'],
							'images_2' => $val['images_2'],
							'images_3' => $val['images_3'],
							'images_4' => $val['images_4'],
							'images_5' => $val['images_5'],
							'images_6' => $val['images_6'],
							'images_7' => $val['images_7'],
							'images_8' => $val['images_8'],
							'images_9' => $val['images_9'],

						);
					}
					$this->BackendProducts_Model->_delete_batch('productsid', $id,'products_color','products');

					$this->BackendProducts_Model->create_batch(array('data' => $color,'table' => 'products_color'));
					//end
					$canonical = slug($this->input->post('canonical'));
					if(!empty($canonical)){
						$this->BackendRouters_Model->Delete($canonical, 'products/frontend/products/view', $id, 'number');
						$this->BackendRouters_Model->Create($canonical, 'products/frontend/products/view', $id, 'number');
					}else{
						$this->BackendRouters_Model->Delete($canonical, 'products/frontend/products/view', $id, 'number');
					}
					$this->BackendTags_Model->DeleteByModule($id, 'products');
					$this->BackendTags_Model->InsertByModule($id, 'products');
					$this->BackendAttributes_Model->DeleteAttr($id);
					$this->BackendAttributes_Model->InsertAttr($id, $attr);

					// Xóa bản ghi triết khấu cho tk Affiliate
					$this->BackendProducts_Model->DeleteAff($id);
					// Thêm bản ghi triết khấu cho tk Affiliate mới
					$this->BackendProducts_Model->CreateAff($id, $discount_data);

					// Chuyển trạng thái các thuộc tính sản phẩm sang trạng thái bị xóa
//					$this->BackendProducts_Model->Update_TrashAttrAdvanced($id);
//					$this->BackendProducts_Model->DeleteAdvancedRelation($id);
//					if (!empty($check_att_advanced)) {
//						// Cập nhật bản ghi thuộc tính sản phẩm
//						$this->BackendProducts_Model->CreateAttrAdvanced($attr_advanced_data);
//						$this->BackendProducts_Model->CreateAdvancedRelation($version_data, $this->fclang);
//					}

					// Xóa cache Frontend
					$this->cache->clean();

					$this->session->set_flashdata('message-success', 'Cập nhật sản phẩm thành công');
					redirect_custom('products/backend/products/view');
				}
			}
			$_attribute_cat = '';
			$radio_cat_checked = $this->input->post('cataloguesid');
			$data['attr'] = $this->input->post('attr');
			$cat_checked = $this->BackendProductsCatalogues_Model->ReadByField('id', $radio_cat_checked, $this->fclang);
			$cat_checked = json_decode($cat_checked['attributes'], TRUE);
			$data['cat_checked'] = $cat_checked;
		}
		
		$_static_cat_checked = $this->BackendProductsCatalogues_Model->ReadByField('id', $data['DetailProducts']['cataloguesid'], $this->fclang);
		
		$_static_cat_checked = json_decode($_static_cat_checked['attributes'], TRUE);
		$data['_static_cat_checked'] = $_static_cat_checked;
		// print_r($data['_static_cat_checked']);die();

		// Lấy danh sách chapter và page của bài giảng
		$data['chapter_arr'] = $this->BackendProductsChapter_Model->ReadByFieldArrChapter('productsid', $id);
		if (isset($data['chapter_arr']) && is_array($data['chapter_arr']) && count($data['chapter_arr'])) {
			foreach ($data['chapter_arr'] as $key => $val) {
				$data['chapter_arr'][$key]['page'] = $this->BackendProductsChapter_Model->ReadByFieldArrPage('chapterid', $val['id']);
			}
		}
		
		$data['attribute_catalogues'] = $this->BackendAttributesCatalogues_Model->AttributesCataloguesList(FALSE);
		if(isset($data['attribute_catalogues']) && is_array($data['attribute_catalogues']) && count($data['attribute_catalogues'])){
			foreach($data['attribute_catalogues'] as $key => $val){
				$data['attribute_catalogues'][$key]['attributes'] = $this->BackendAttributes_Model->ReadAtrributes($val['id']);
			}
		}
		$data['attribute_checked'] = $this->BackendAttributes_Model->AttributesChecked($id);
		if (!is_array($data['attribute_checked']) || count($data['attribute_checked']) < 0) {
			$data['attribute_checked'] = array('100000');
		}
		$data['template'] = 'products/backend/products/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function Delete($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'products/backend/products/delete'
		));
		$id = (int)$id;
		$data['DetailProducts'] = $this->BackendProducts_Model->ReadByField('id', $id, $this->fclang);
		if(!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0){
			$this->session->set_flashdata('message-danger', 'sản phẩm không tồn tại');
			redirect_custom('products/backend/products/view');
		}
		if($this->input->post('delete')){
			$flag = $this->BackendProducts_Model->DeleteByField('id', $id);
			if($flag > 0){
				if(!empty($data['DetailProducts']['canonical'])){
					$this->BackendRouters_Model->Delete($data['DetailProducts']['canonical'], 'products/frontend/products/view', $data['DetailProducts']['id'], 'number');
				}
				$this->BackendProducts_Model->_delete_relationship('products', $id);
				$this->BackendTags_Model->DeleteByModule($id, 'products');
				$this->BackendProducts_Model->delete_attribute($id);
				
				$this->session->set_flashdata('message-success', 'Xóa sản phẩm thành công');
				redirect('products/backend/products/view');
			}
		}
		$data['template'] = 'products/backend/products/delete';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function _Canonical(){
		$canonical = slug($this->input->post('canonical'));
		$canonical_original = slug($this->input->post('canonical_original'));
		if(empty($canonical)){
			return TRUE;
		}
		if($canonical != $canonical_original){
			$count = $this->BackendRouters_Model->count($canonical);
			if($count > 0){
				$this->form_validation->set_message('_Canonical', 'Canonical đã tồn tại');
				return FALSE;
			}
		}
		return TRUE;
	}
	public function _Catalogue() {
		$catalogue = $this->input->post('catalogue');
		if(!isset($catalogue) || count($catalogue) == 0 || !is_array($catalogue)) {
			$this->form_validation->set_message('_Catalogue','Danh mục cha trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['products'] = $this->BackendProducts_Model->ReadByField('id', $id, $this->fclang);
		$temp[$type] = (($data['products'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('products', $temp);
		redirect((!empty($redirect)) ? $redirect : 'products/backend/products/view');
	}
}
