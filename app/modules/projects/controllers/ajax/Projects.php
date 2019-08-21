<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends FC_Controller{
	
	private $location;
	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendProjects_Model',
			'FrontendProducts_Model',
			'tags/BackendTags_Model',
		));
		$this->load->library(array('configbie'));
	}
	public function check_vip(){
		$html = $error = '';
		$date = $this->input->post('data');
		$time_start = gmdate('Y-m-d', time() + 7*3600);
		$att = explode('-', $date);
		if (isset($att) && is_array($att)) {
			$start = strtotime($time_start);
			$stop = strtotime($date);
			if ($stop >= $start) {
				$days = ceil(($stop - $start)/(24*3600));
			}else{
				$days = 0;
			}
		}
		$html = $html.'<div class="uk-flex item-form uk-flex-middle">';
			$html = $html.'<div class="label-left bg_bg">';
				$html = $html.'<label class="label-label">Tổng ngày Vip</label>';
			$html = $html.'</div>';
			$html = $html.'<div class="label-right uk-width-1-1 bdl0">';
				$html = $html.'<label class="label-label">';
					$html = $html.''.$days.' Ngày. Thành tiền: <span class="red">'.number_format(($days*19500)).'</span> vnđ';
					$html = $html.'<input type="hidden" name="money" value="'.($days*19500).'" />';
				$html = $html.'</label>';
			$html = $html.'</div>';
		$html = $html.'</div>';
		echo json_encode(array(
			'flag' => TRUE,
			'html' => $html,
		));die();
	}

	public function check_package(){
		$html = '';
		$package = $this->input->post('package');
		$this->fcCustomer = $this->config->item('fcCustomer');
		$DetailUsers = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		if ($DetailUsers['money'] < $package) {
			$html = $html.'<div class="box-package">';
				$html = $html.'<div class="list-package uk-text-center">';
					$html = $html.'Số dư: <b class="red">'.(($DetailUsers['money'] == 0) ? 'Empty' : ''.number_format($DetailUsers['money']).'</b> vnđ').' (Không khả dụng)';
				$html = $html.'</div>';
				$html = $html.'<div class="list-package uk-text-center">';
					$html = $html.'Chi phí: <b class="red">'.number_format($package).'</b> vnđ'.'';
				$html = $html.'</div>';
				$html = $html.'<div class="list-package uk-text-center">';
					$html = $html.'Thanh Toán: <b class="red">'.number_format($package).'</b> vnđ'.'';
				$html = $html.'</div>';
			$html = $html.'</div>';
			$html = $html.'<div class="bg_list_package uk-text-center">';
				$html = $html.'Hoặc <a class="red" href="members/payment.html">Click</a> vào đây để tiến hành nạp tiền vào Ví';
			$html = $html.'</div>';
		}else{
			$html = $html.'<div class="box-package">';
				$html = $html.'<div class="list-package uk-text-center">';
					$html = $html.'Số dư: <b class="red">'.number_format($DetailUsers['money']).'</b> vnđ'.'';
				$html = $html.'</div>';
				$html = $html.'<div class="list-package uk-text-center">';
					$html = $html.'Chi phí: <b class="red">'.number_format($package).'</b> vnđ'.'';
				$html = $html.'</div>';
				$html = $html.'<div class="list-package uk-text-center">';
					$html = $html.'Thanh Toán: <b class="red">'.number_format($package).'</b> vnđ'.'';
				$html = $html.'</div>';
			$html = $html.'</div>';
			$html = $html.'<div class="list_package uk-text-center">';
				$html = $html.'<button class="btn-create-package" type="submit" name="create" value="action">Đồng ý thanh toán</button>';
			$html = $html.'</div>';
		}
		echo json_encode(array(
			'flag' => TRUE,
			'html' => $html,
		));die();
	}

	public function ajax_upload(){
		if (! empty($_FILES)) {

			$config['upload_path'] = './uploads/images/projects';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']     = '2048';
			$this->load->library('upload');

			$files = $_FILES;

			$number_of_file = count($_FILES['file']['name']);
			$errors = 0;
			$images_arr = array();
			for ($i=0; $i < $number_of_file ; $i++) { 

				$_FILES['file']['name'] = $files['file']['name'][$i];
				$_FILES['file']['type'] = $files['file']['type'][$i];
				$_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
				$_FILES['file']['error'] = $files['file']['error'][$i];
				$_FILES['file']['size'] = $files['file']['size'][$i];

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('file')) {
					$errors++;
				}
				else
				{
					$extra_info = $_FILES['file']['name'];
		        	$images_arr[] = removeutf8(preg_replace('/\s+/', '_', $extra_info));
				}

			}

			if ($errors > 0) {
				$errors = $errors . ' File(s) cannot be upload';
			}
			else
			{
				$errors = '';
			}

		    $html = '';
		    if(!empty($images_arr)){ 
			    foreach($images_arr as $image_src){ 
		            $html = $html .'<li class="list-group-item">';
		            	$html = $html .'<img src="/uploads/images/projects/'.$image_src.'" alt="'.$image_src.'" />';
		            	$html = $html .'<div class="pull-right">';
		            		$html = $html .'<a href="javascript:void(0)" data-file="/uploads/images/projects/'.$image_src.'" class="remove-file">';
		            			$html = $html .' <i class="fa fa-close" aria-hidden="true"></i>';
		            		$html = $html .' </a>';
		            	$html = $html .' </div>';
		            	$html = $html .'<input name="album[images][]" value="/uploads/images/projects/'.$image_src.'" type="hidden">';
						$html = $html .'<input name="album[title][]" value="" type="hidden">';
						$html = $html .'<input name="album[description][]" value="" type="hidden">';		           
		            $html = $html .' </li>';
				}
			}
			 // print_r($images_arr);
			echo json_encode(array(
				'error' => $errors,
				'html' => $html,
			));
		}
		elseif ($this->input->post('file_to_remove')) {
			$file_to_remove = $this->input->post('file_to_remove');
			unlink(".".$file_to_remove);
		}
		else
		{
			$this->listFile();
		}
	}
	public function check_fillter(){
		$post = $this->input->post('post');
		$post_array = explode('-', $post);
		$temp = '';
		$_cat_ = '';
		$_attribute_cat = '';
		$_str = '';

		if(isset($post_array) && is_array($post_array) && count($post_array)){
			$_cat_ = $this->BackendProjects_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, attributes',
				'table' => 'projects_catalogues',
				'where' => array('trash' => 0,),
				'where_in' => $post_array,
				'where_in_field' => 'id',
			), TRUE); 
		}
		
		if(isset($_cat_) && is_array($_cat_) && count($_cat_)){
			foreach($_cat_ as $key => $val){
				$attributes_decode = json_decode($val['attributes'], TRUE);
				$temp['attribute_catalogue'] = $attributes_decode['attribute_catalogue'];
				$temp['attribute'] = $attributes_decode['attribute'];
			}
		}
		if(count($temp['attribute_catalogue']) == 0 || $temp['attribute_catalogue'][0] == ''){
			$_str = $_str.'<label class="catalogueid">Bộ lọc';
				$_str = $_str.'<input name="cataloguesid" value="'.$post.'" type="hidden">';
			$_str = $_str.'</label>';
			echo json_encode(array(
				'flag' => FALSE,
				'html' => $_str,
			));
			die();
		}
	
		
		if(isset($_cat_) && is_array($_cat_) && count($_cat_)){
			$_attribute_cat = $this->BackendAttributes_Model->_get_where(array(
				'select' => 'id, title, keyword',
				'table' => 'attributes_catalogues',
				'where' => array('trash' => 0),
				'where_in' => $temp['attribute_catalogue'],
				'where_in_field' => 'id'
			), TRUE);
		}
		
		if(isset($_attribute_cat) && is_array($_attribute_cat) && count($_attribute_cat)){
			foreach($_attribute_cat as $key => $val){
				$_attribute_cat[$key]['attributes'] = $this->BackendAttributes_Model->_get_where(array(
					'select' => 'id, title',
					'table' => 'attributes',
					'where' => array('trash' => 0,'cataloguesid' => $val['id']),
				), TRUE);
			}
		}
		
		if(isset($_attribute_cat) && is_array($_attribute_cat) && count($_attribute_cat)){
			$_str = $_str.'<label class="catalogueid">Bộ lọc';
				$_str = $_str.'<input name="cataloguesid" value="'.$post.'" type="hidden">';
				$_str = $_str.'<input name="att" value="'.$post.'" class="check-box" type="radio">';
			$_str = $_str.'</label>';
			echo json_encode(array(
				'flag' => TRUE,
				'html' => $_str,
			));
			die();
		}else{
			$_str = $_str.'<label class="catalogueid">Bộ lọc';
				$_str = $_str.'<input name="cataloguesid" value="'.$post.'" type="hidden">';
			$_str = $_str.'</label>';
			echo json_encode(array(
				'flag' => FALSE,
				'html' => $_str,
			));
			die();
		}
	}
	//* LẤY ĐỊA ĐIỂM *//
	public function ajax_change_location(){
		$id = $this->input->post('id');
		$_html = '';
		$this->location = $this->BackendProjects_Model->location_dropdown(array(
			'where' => array('parentid' => $id),
		), true);
		if(isset($this->location) && is_array($this->location) && count($this->location)){
			foreach($this->location as $key => $val){
				$_html = $_html . '<option value="'.$key.'">'.$val.'</option>';
			}
		}
		echo json_encode(array(
			'html' => $_html,
		));
		die();
		
	}
	
	public function ajax_get_project_list(){
		$data['cityid'] = $this->input->post('cityid');
		$data['districtid'] = $this->input->post('districtid');
		$data['wardid'] = $this->input->post('wardid');
		$param['where'] = '';
		$_html = '';
	
		if($data['cityid'] > 0 && $data['districtid'] == 0){
			$param['where'] = array(
				'cityid' => $data['cityid'],
			);
		}else if($data['cityid'] > 0 && $data['districtid'] > 0 && $data['wardid']  == 0){
			$param['where'] = array(
				'cityid' => $data['cityid'],
				'districtid' => $data['districtid'],
			);
		}else if($data['cityid'] > 0 && $data['districtid'] > 0 && $data['wardid']  > 0){
			$param['where'] = array(
				'cityid' => $data['cityid'],
				'districtid' => $data['districtid'],
				'wardid' => $data['wardid'],
			);
		}else{
			echo $_html;die();
		}
		$param['where']['trash'] = 0;
		
		$listProject = $this->Autoload_Model->_get_where(array(
			'select' => 'id, title',
			'table' => 'places',
			'where' => $param['where'],
			'order_by' => 'title asc',
		), TRUE);
		
		if(isset($listProject) && is_array($listProject) && count($listProject)){
			$_html = $_html.'<option value="0">[Chọn dự án]</option>';
			foreach($listProject as $key => $val){
				$_html = $_html.'<option value="'.$val['id'].'">'.$val['title'].'</option>';
			}
		}else{
			$_html = $_html.'<option value="0">Không có dự án phù hợp</option>';
		}
		
		echo json_encode(array(
			'html' => $_html,
		)); die();
	}
	
	public function sort(){
		$data = NULL;
		$post = $this->input->post();
		foreach($post['order'] as $key => $val){
			$data[] = array(
				'id' => $key,
				'order' => $val,
			);
		}
		$flag = $this->BackendProjects_Model->UpdateBatchByField($data, 'id');
	}

	public function viewed(){
		$id = $this->input->post('id');
		if(!isset($_COOKIE['products_viewed_'.$id])){
			$flag = $this->FrontendProducts_Model->UpdateViewed('id', $id);
			setcookie('products_viewed_'.$id, 1, NULL, '/');
		}
	}
	public function createLink() {
		$link = $this->input->post('canonical');
		$link = slug($link);
	}
	public function sort_order() {
		sleep(0.5);
		$id = $this->input->post('id');
		$table = $this->input->post('table');
		$data = $this->input->post('number');
		if(isset($table) && !empty($table) && $id > 0) {
			$this->BackendProjects_Model->_update_sort_order($table, $id, $data);
		}
	}
	
	public function convert_commas_price(){
		$price = $this->input->post('price');
		$price_explode = explode('.',$price);
		if(count($price_explode) == 1){
			$price = (int)$price;
			
		}else{
			$price = str_replace('.','',$price);
			$price = (int)$price;
		}
		$price = str_replace(',','.',number_format($price));
		
		echo $price;die();
	}
	
	public function attributes(){
		$post = $this->input->post('post');
		$post_array = explode('-', $post);
		$temp = '';
		$_cat_ = '';
		$_attribute_cat = '';
		$_str = '';
		if(isset($post_array) && is_array($post_array) && count($post_array)){
			$_cat_ = $this->BackendProjects_Model->_get_where(array(
				'select' => 'id, title, slug, canonical, attributes',
				'table' => 'projects_catalogues',
				'where' => array('trash' => 0,),
				'where_in' => $post_array,
				'where_in_field' => 'id',
			), TRUE); 
		}
		
		if(isset($_cat_) && is_array($_cat_) && count($_cat_)){
			foreach($_cat_ as $key => $val){
				$attributes_decode = json_decode($val['attributes'], TRUE);
				$temp['attribute_catalogue'] = $attributes_decode['attribute_catalogue'];
				$temp['attribute'] = $attributes_decode['attribute'];
			}
		}
		if(count($temp['attribute_catalogue']) == 0 || $temp['attribute_catalogue'][0] == ''){
			echo $_str;die();
		}
	
		
		if(isset($_cat_) && is_array($_cat_) && count($_cat_)){
			$_attribute_cat = $this->BackendAttributes_Model->_get_where(array(
				'select' => 'id, title, keyword',
				'table' => 'attributes_catalogues',
				'where' => array('trash' => 0),
				'where_in' => $temp['attribute_catalogue'],
				'where_in_field' => 'id'
			), TRUE);
		}
		
		if(isset($_attribute_cat) && is_array($_attribute_cat) && count($_attribute_cat)){
			foreach($_attribute_cat as $key => $val){
				$_attribute_cat[$key]['attributes'] = $this->BackendAttributes_Model->_get_where(array(
					'select' => 'id, title',
					'table' => 'attributes',
					'where' => array('trash' => 0,'cataloguesid' => $val['id']),
				), TRUE);
			}
		}
		
		if(isset($_attribute_cat) && is_array($_attribute_cat) && count($_attribute_cat)){
			foreach($_attribute_cat as $key => $val){
				$_str = $_str.'<div class="form-group">';
					$_str = $_str.'<label class="col-sm-2 control-lanel">'.$val['title'].'</label>';
					$_str = $_str.'<div class="col-sm-10">';
					if(isset($val['attributes']) && is_array($val['attributes']) && count($val['attributes'])){
						$_str = $_str.'<div class="checkbox" style="padding:0;">';
						foreach($val['attributes'] as $keyAttr => $valAttr){
							if(isset($temp['attribute'][$val['keyword']]) && in_array($valAttr['id'], $temp['attribute'][$val['keyword']]) == false) continue;
							$_str = $_str.'<label class="tpInputLabel" style="width:168px;">';
								$_str = $_str.'<input name="attr['.$valAttr['id'].']" type="checkbox" class="tpInputCheckbox" value="'.$valAttr['id'].'" /><span>'.$valAttr['title'].'</span>';
							$_str = $_str.'</label>';
						}
						$_str = $_str.'</div>';
					}
					$_str = $_str.'</div>';
					$_str = $_str.'<script>$(document).ready(function() {$(".tpInputLabel").on("click", function() {if($(this).find(".tpInputCheckbox").is(":checked")) {$(this).addClass("checked");}else {$(this).removeClass("checked");}});});</script>';
				$_str = $_str.'</div>';
			}
		}
		echo $_str;die();
	}
	
	public function delete(){
		$error = true;
		$message = '';
		$id = $this->input->post('post');
		if(isset($id) && is_array($id) && count($id)){
			foreach($id as $key => $val){
				$DetailProducts = $this->BackendProjects_Model->ReadByField('id', $val);
				$flag = $this->BackendProjects_Model->DeleteByField('id', $val);
				if($flag > 0){
					if(!empty($DetailProducts['canonical'])){
						$this->BackendRouters_Model->Delete($DetailProducts['canonical'], 'products/frontend/products/view', $DetailProducts['id'], 'number');
					}
					$this->BackendProjects_Model->_delete_relationship('products', $val);
					$this->BackendTags_Model->DeleteByModule($val, 'products');
					$error = false;
					$message = 'Bản ghi đã được xóa thành công';
				}
			}
		}else{
			$message = 'Có lỗi trong quá trình xóa bản ghi, vui lòng kiểm tra lại';
		}
		echo json_encode(array(
			'error' => $error,
			'message' => $message,
		)); die();
	}
	
	public function fast_price_update(){
		$price = $this->input->post('price');
		$module = $this->input->post('module');
		$id = $this->input->post('id');
		$temp[$module] = $price;
		$this->db->where('id', $id);
		$this->db->update('projects', $temp);		
		echo $price;die();
	}
	
	
	
	
	public function filter(){
		
		$post = $this->input->post('post');
		$attribute = explode('-', $post);
		
		
		/* LẤY THEO DANH MỤC */
		$cataloguesid = $this->input->post('cataloguesid');
		$DetailCatalogues = $this->FrontendProductsCatalogues_Model->ReadByField('id', $cataloguesid);
		$object_catalogues = '';
		$objectid = $this->Autoload_Model->__catalogue(array('catalogue' => $DetailCatalogues));
		if(isset($objectid['objectid']) && is_array($objectid['objectid']) && count($objectid['objectid'])){
			foreach($objectid['objectid'] as $key => $val){
				$object_catalogues[] = $val;
			}
			$object_catalogues = array_unique($object_catalogues);
			$objectid = $object_catalogues;
		}
		/* LẤY THEO THUỘC TÍNH */
		$objectid_attribute = NULL;
		
		$objectid = $this->Autoload_Model->__attribute(array('attributeid' => $attribute));
		if(isset($objectid['objectid']) && is_array($objectid['objectid']) && count($objectid['objectid'])){
			foreach($objectid['objectid'] as $key => $val){
				$objectid_attribute[] = $val;
			}
			$objectid_attribute = array_unique($objectid_attribute);
			$objectid = $objectid_attribute;
		}
		
		
		
		if(is_array($object_catalogues) && is_array($objectid_attribute)){
			$objectid = array_intersect($object_catalogues, $objectid_attribute);
		}
		
		
		$page = $this->input->post('page');
		$temp_attribute['cataloguesid'] = $this->input->post('cataloguesid');
		$page = (int)$page;
		$config['total_rows'] = $this->FrontendProducts_Model->countajaxproduct($objectid);
		$result = '';
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] ='#" data-page="';
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 24;
			$config['cur_page'] = $page;
			$config['page'] = $page;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination mb30"><ul class="uk-pagination uk-pagination-right" id="ajax-pagination">';
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
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			// echo $page;die();
			$data['listProjects'] = $this->FrontendProducts_Model->viewajaxproduct(($page * $config['per_page']), $config['per_page'], $objectid);	
		}
		
		$html = '';
		if(isset($data['listProjects']) && is_array($data['listProjects']) && count($data['listProjects'])){
			$html = $html .'<ul class="uk-list uk-grid uk-grid-small uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 list-product" data-uk-grid-match="{target:\'.title\'}" itemscope itemtype="http://schema.org/ItemList">';
			foreach($data['listProjects'] as $key => $val){
				$title = $val['title'];
				$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
				$image = getthumb($val['images']);
				
				$html = $html.'<li class="mb10" >
									<div class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/Product">
										<a href="'.$href.'" title="'.$title.'" class="image img-scaledown"><img  src="'.$image.'" alt="'.$title.'" /></a>
										<h3 class="title" itemprop="name"><a href="'.$href.'" title="'.$title.'" itemprop="url">'.$title.'</a></h3>
										<div class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
											Giá  <span itemprop="price">'.str_replace(',','.',number_format($val['price'])).' <span itemprop="priceCurrency" content="USD">VNĐ</span></span>
										</div>
										<div class="cart">
											<a href="'.$href.'" title="'.$title.'" rel="nofollow">Mua hàng</a>
										</div>
									</div>
								</li>';
			}
			$html = $html.'</ul>'.$data['listPagination'];
		}
		
		echo json_encode(array(
			'html' => $html,
		));
		die();
	}
	
	public function listProject(){
		$page = $this->input->post('page');
		$page = (int)$page;
		$config['total_rows'] = $this->FrontendProjects_Model->count_all();
		if($config['total_rows'] > 0){
			
			$this->load->library('pagination');
			$config['base_url'] ='#" data-page="';
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['cur_page'] = $page;
			$config['page'] = $page;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination"><ul class="uk-pagination uk-pagination-left">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="uk-active"><a itemprop="relatedLink/pagination">';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['projectList'] = $this->FrontendProjects_Model->read_all(($page * $config['per_page']),$config['per_page']);
		}
		
		// echo $data['listPagination'];die();
		
		
		$html = '';
									
		if(isset($data['projectList']) && is_array($data['projectList']) && count($data['projectList'])){
			foreach($data['projectList'] as $key => $val){
				$data['projectList'][$key]['attribute'] = $this->FrontendProjects_Model->AttributesAllTheTime($val['id']);
			}
		}
	
		if(isset($data['projectList']) && is_array($data['projectList']) && count($data['projectList'])){
			foreach($data['projectList'] as $key => $val){
				$title = $val['title'];
				$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'projects');
				$image = getthumb($val['images']);
				$description = cutnchar(strip_tags($val['description']), 250);
				$created = show_time($val['created'], 'd/m/Y');
				$city = $this->Autoload_Model->_get_where(array(
					'select' => '*',
					'table' => 'province',
					'where' => array('id' => $val['districtid'])
				));
				$html = $html .'<tr>';
					$html =  $html . '<td><h3 class="title"><a href="'.$href.'" title="'.$title.'">'.$title.'</a></h3></td>';
					$html = $html .  '<td>'.$city['title'].'</td>';
					if(isset($val['attribute']) && is_array($val['attribute']) && count($val['attribute'])){
						foreach($val['attribute'] as $keyAttr => $valAttr){
							if($valAttr['keyword'] != 'loai-tin') continue;
							if(isset($valAttr['attr']) && is_array($valAttr['attr']) && count($valAttr['attr'])){
								foreach($valAttr['attr'] as $keyAttribute => $valAttribute){
									$html = $html . '<td>'.$valAttribute['title'].'</td>';
								}
							}
						}
					}
					$html = $html.'<td>'.$created.'</td>';
					$html = $html .'<td>'.$val['code'].'</td>';
					
				$html = $html .'</tr>';
			}
			$html = $html . '<tr class="ajax-pagination"><td colspan="3">'.$data['listPagination'].'<td></tr>';
		}
		echo json_encode(array(
			'html' => $html,
		));
		die();
	}
	
	
	
	public function listAttributeProject(){
		$page = $this->input->post('page');
		$moduleid = (int)$this->input->post('moduleid');
		// echo $moduleid;die();
		$page = (int)$page;
		$config['total_rows'] = $this->FrontendAttributes_Model->CountAllAtrributes($moduleid);
		// echo $config['total_rows'];die();
		if($config['total_rows'] > 0){
			
			$this->load->library('pagination');
			$config['base_url'] ='#" data-page="';
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 10;
			$config['cur_page'] = $page;
			$config['page'] = $page;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination"><ul class="uk-pagination uk-pagination-left">';
			$config['full_tag_close'] = '</ul></div>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="uk-active"><a itemprop="relatedLink/pagination">';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['projectList'] = $this->FrontendAttributes_Model->ReadAllAttribute($moduleid, ($page * $config['per_page']),$config['per_page']);
		}
		
		// echo $data['listPagination'];die();
		
		
		$html = '';
									
		if(isset($data['projectList']) && is_array($data['projectList']) && count($data['projectList'])){
			foreach($data['projectList'] as $key => $val){
				$data['projectList'][$key]['attribute'] = $this->FrontendProjects_Model->AttributesAllTheTime($val['id']);
			}
		}
	
		if(isset($data['projectList']) && is_array($data['projectList']) && count($data['projectList'])){
			foreach($data['projectList'] as $key => $val){
				$title = $val['title'];
				$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'projects');
				$image = getthumb($val['images']);
				$description = cutnchar(strip_tags($val['description']), 250);
				$created = show_time($val['created'], 'd/m/Y');
				$city = $this->Autoload_Model->_get_where(array(
					'select' => '*',
					'table' => 'province',
					'where' => array('id' => $val['districtid'])
				));
				$html = $html .'<tr>';
					$html =  $html . '<td><h3 class="title"><a href="'.$href.'" title="'.$title.'">'.$title.'</a></h3></td>';
					$html = $html .  '<td>'.$city['title'].'</td>';
					if(isset($val['attribute']) && is_array($val['attribute']) && count($val['attribute'])){
						foreach($val['attribute'] as $keyAttr => $valAttr){
							if($valAttr['keyword'] != 'loai-tin') continue;
							if(isset($valAttr['attr']) && is_array($valAttr['attr']) && count($valAttr['attr'])){
								foreach($valAttr['attr'] as $keyAttribute => $valAttribute){
									$html = $html . '<td>'.$valAttribute['title'].'</td>';
								}
							}
						}
					}
					$html = $html.'<td>'.$created.'</td>';
					$html = $html .'<td>'.$val['code'].'</td>';
					
				$html = $html .'</tr>';
			}
			$html = $html . '<tr class="ajax-pagination"><td colspan="3">'.$data['listPagination'].'<td></tr>';
		}
		echo json_encode(array(
			'html' => $html,
		));
		die();
	}
	
	
}

				