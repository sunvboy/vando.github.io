<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends FC_Controller{

	public function __construct(){
		parent::__construct();
		/* KIỂM TRA TÌNH TRẠNG WEBSITE */
		$this->load->model(array(
			'projects/BackendProjects_Model',
			'attributes/BackendAttributes_Model',
		));
		$this->fc_lang = $this->config->item('fc_lang');
		$this->load->library(array('configbie'));
		$this->fcCustomer = $this->config->item('fcCustomer');
		if($this->fcSystem['homepage_website'] == 1){
			echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
		}
		/* -------------------------- */
	}
	public function History(){
		if (!isset($this->fcCustomer) && !is_array($this->fcCustomer) && count($this->fcCustomer) == 0) {
			$this->session->set_flashdata('message-danger', 'Bạn phải đăng nhập để sử dụng tính năng này!');
			redirect('members/login');
		}
		$DetailUsers = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		$data['list_payment'] = $this->FrontendCustomers_Model->ReadAllFieldPayment(array('customersid'=>$this->fcCustomer['id']));

		$data['meta_title'] = 'Lịch sử nạp tiền vào tài khoản';
		$data['DetailUsers'] = $DetailUsers;
		$data['template'] = 'projects/frontend/projects/history';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}

	public function Payment(){
		if (!isset($this->fcCustomer) && !is_array($this->fcCustomer) && count($this->fcCustomer) == 0) {
			$this->session->set_flashdata('message-danger', 'Bạn phải đăng nhập để sử dụng tính năng này!');
			redirect('members/login');
		}
		$DetailUsers = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		$data['list_payment'] = $this->FrontendCustomers_Model->ReadAllFieldPayment(array('customersid'=>$this->fcCustomer['id'],'trash' => 0));

		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|callback__AuthLogin');
			$this->form_validation->set_rules('money', 'Tiền nạp', 'trim|required');
			$this->form_validation->set_rules('bank_name', 'Ngân hàng', 'trim|required');
			$this->form_validation->set_rules('bank_number', 'Số TK ngân hàng', 'trim|required');
			$this->form_validation->set_rules('bank_code', 'Tên TK ngân hàng', 'trim|required');
			$this->form_validation->set_rules('message', 'Nội dung', 'trim|required');
			if ($this->form_validation->run($this)){
				$flag = $this->FrontendCustomers_Model->Createpayment($this->fcCustomer['id']);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Bạn gửi yêu cầu nạp tiền thành công!.');
					redirect('members/payment');
				}
			}
		}

		$data['meta_title'] = 'Nạp tiền vào tài khoản';
		$data['DetailUsers'] = $DetailUsers;
		$data['template'] = 'projects/frontend/projects/payment';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	public function Register(){
		if (!isset($this->fcCustomer) && !is_array($this->fcCustomer) && count($this->fcCustomer) == 0) {
			$this->session->set_flashdata('message-danger', 'Bạn phải đăng nhập để sử dụng tính năng này!');
			redirect('members/login');
		}
		$DetailUsers = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('package', 'Gói đăng tin', 'trim|is_natural_no_zero');
			if ($this->form_validation->run($this)){
				// date_default_timezone_set('Asia/Ho_Chi_Minh');
				$package = $this->input->post('package');
				$money = $DetailUsers['money'] - $package;
				$time_start = gmdate('Y-m-d H:i:s', time() + 7*3600);
				if ($DetailUsers['time_finish'] <= $time_start) {
					switch ($package) {
						case '199000':
							$note = '1 tháng';
							$thang = (((date("m", time()) + 1) <= 12) ? (date("m", time()) + 1) : ((date("m", time()) + 1) - 12));
							$nam = (((date("m", time()) + 1) <= 12) ? (date("Y", time())) : ((date("Y", time()) + 1)));
							$time_finish = ''.$nam.'-'.$thang.'-'.date("d", time()).' '.date("H", time()).':'.date("i", time()).':'.date("s", time()).'';
							break;
						case '520000':
							$note = '3 tháng';
							$thang = (((date("m", time()) + 3) <= 12) ? (date("m", time()) + 3) : ((date("m", time()) + 3) - 12));
							$nam = (((date("m", time()) + 3) <= 12) ? (date("Y", time())) : ((date("Y", time()) + 1)));
							$time_finish =  ''.$nam.'-'.$thang.'-'.date("d", time()).' '.date("H", time()).':'.date("i", time()).':'.date("s", time()).'';
							break;
						case '990000':
							$note = '6 tháng';
							$thang = (((date("m", time()) + 6) <= 12) ? (date("m", time()) + 6) : ((date("m", time()) + 6) - 12));
							$nam = (((date("m", time()) + 6) <= 12) ? (date("Y", time())) : ((date("Y", time()) + 1)));
							$time_finish =  ''.$nam.'-'.$thang.'-'.date("d", time()).' '.date("H", time()).':'.date("i", time()).':'.date("s", time()).'';
							break;
						case '1900000':
							$note = '1 năm';
							$time_finish =  ''.(date("Y", time()) + 1).'-'.date("m", time()).'-'.date("d", time()).' '.date("H", time()).':'.date("i", time()).':'.date("s", time()).'';
							break;
						default:
							$note = '';
							$time_finish = '0000-00-00 00:00:00';
							break;
					}
				}else{
					$time_start = $DetailUsers['time_start'];
					$time_finish = $DetailUsers['time_finish'];
					$time = strtotime($time_finish);
					switch ($package) {
						case '199000':
							$note = '1 tháng';
							$thang = (((date("m", $time) + 1) <= 12) ? (date("m", $time) + 1) : ((date("m", $time) + 1) - 12));
							$nam = (((date("m", $time) + 1) <= 12) ? (date("Y", $time)) : ((date("Y", $time) + 1)));
							$time_finish = ''.$nam.'-'.$thang.'-'.date("d", $time).' '.date("H", $time).':'.date("i", $time).':'.date("s", $time).'';
							break;
						case '520000':
							$note = '3 tháng';
							$thang = (((date("m", $time) + 3) <= 12) ? (date("m", $time) + 3) : ((date("m", $time) + 3) - 12));
							$nam = (((date("m", $time) + 3) <= 12) ? (date("Y", $time)) : ((date("Y", $time) + 1)));
							$time_finish = ''.$nam.'-'.$thang.'-'.date("d", $time).' '.date("H", $time).':'.date("i", $time).':'.date("s", $time).'';
							break;
						case '990000':
							$note = '6 tháng';
							$thang = (((date("m", $time) + 6) <= 12) ? (date("m", $time) + 6) : ((date("m", $time) + 6) - 12));
							$nam = (((date("m", $time) + 6) <= 12) ? (date("Y", $time)) : ((date("Y", $time) + 1)));
							$time_finish = ''.$nam.'-'.$thang.'-'.date("d", $time).' '.date("H", $time).':'.date("i", $time).':'.date("s", $time).'';
							break;
						case '1900000':
							$note = '1 năm';
							$time_finish = ''.(date("Y", time()) + 1).'-'.date("m", time()).'-'.date("d", $time).' '.date("H", $time).':'.date("i", $time).':'.date("s", $time).'';
							break;
						default:
							$note = '';
							$time_finish = '0000-00-00 00:00:00';
							break;
					}
				}

				$resultid = $this->FrontendCustomers_Model->UpdateByField('id', $this->fcCustomer['id'], array('money' => $money, 'time_start' => $time_start, 'time_finish' => $time_finish));

				if($resultid > 0){
					$this->session->set_flashdata('message-success', 'Bạn đã đăng ký dịch vụ đăng tin không giới hạn trong <span class="red">'.$note.'</span> thành công. Hạn ngày đăng tin của bạn là: <span class="red">'.$time_finish.'</span>. Bây giờ bạn có thể sử dụng dịch vụ này. Chúc bạn thành công!.');
					redirect('members/dang-tin');
				}
			}
		}
		$data['DetailUsers'] = $DetailUsers;
		$data['template'] = 'projects/frontend/projects/register';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}

	public function Search($page = 0){
		$page = (int)$page;
		$id = (int)$this->input->get('projects');
		$DetailCatalogues = $this->FrontendProjectsCatalogues_Model->ReadByField('id', $id);
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$DetailCatalogues = '';
		}

		$arr = '';
		$str = $_GET;
		if(isset($str) && is_array($str)  && count($str)) {
			unset($str['projects']);
			foreach ($str as $key => $val) {
				if ($val != 0 || $val != ''){
					if ($key == 'title'){
						$arr .= ' AND `pr`.`'.$key.'` LIKE  \'%'.$val.'%\'';
					}elseif ($key == 'p_start'){
						$arr .= ' AND `pr`.`price` >=  '.$val.'';
					}elseif ($key == 's_start'){
						$arr .= ' AND `pr`.`area` >=  '.$val.'';
					}elseif ($key == 's_finish'){
						$arr .= ' AND `pr`.`area` <=  '.$val.'';
					}else{
						$arr .= ' AND `pr`.`'.$key.'` = '.$val.'';
					}
				}
			}
		}

		$config['total_rows'] = $this->FrontendProjects_Model->CountSearch(array(
			'select' => '`pr`.`id`',
			'where' => $arr,
			'modules' => 'projects',
		), $DetailCatalogues, $this->fc_lang);

		$config['base_url'] =  rewrite_url('project-search', '','', '', FALSE, TRUE);
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 20;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination" itemscope itemtype="http://schema.org/SiteNavigationElement/Pagination"><ul class="uk-pagination uk-pagination-left">';
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
			$data['PaginationList'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$seoPage = ($page >= 2)?(' - Trang '.$page):'';
			if($page >= 2){
				$data['canonical'] = $config['base_url'].'/trang-'.$page.$this->config->item('url_suffix');
			}
			$page = $page - 1;
			$data['projectsList'] = $this->FrontendProjects_Model->ReadSearch(array(
				'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`content`, `pr`.`price`, `pr`.`created`, `pr`.`measure`, `pr`.`cataloguesid`, `pr`.`area`, `pr`.`projectid`, `pr`.`wardid`, `pr`.`districtid`, `pr`.`isaside`',
				'modules' => 'projects',
				'where' => $arr,
				'order_by' => '`pr`.`isaside` desc, `pr`.`order` asc, `pr`.`id` desc ',
				'start' => ($page * $config['per_page']),
				'limit' => $config['per_page'],
			), $DetailCatalogues, $this->fc_lang );
		}

		$data['prd_arr'] = isset($_COOKIE['fc_prd'])?json_decode($_COOKIE['fc_prd']):NULL;
		$data['template'] = 'projects/frontend/projects/search';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	public function View($id = 0){
		$id = (int)$id;
		$DetailProjects = $this->FrontendProjects_Model->ReadByField('id', $id);
		if(!isset($DetailProjects) && !is_array($DetailProjects) && count($DetailProjects) == 0){
			$this->session->set_flashdata('message-danger', 'tin đăng không tồn tại');
			redirect(base_url());
		}
		$DetailCatalogues = $this->FrontendProjectsCatalogues_Model->ReadByField('id', $DetailProjects['cataloguesid']);
		if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
			$this->session->set_flashdata('message-danger', 'Danh mục tin đăng không tồn tại');
			redirect(base_url());
		}
		/* Lưu cookie sản phẩm đã xem */
		$prd_arr = isset($_COOKIE['fc_prd'])?$_COOKIE['fc_prd']:NULL;
		$arr_cookie = NULL;
	  	$arr_cookie = isset($prd_arr)?json_decode($prd_arr):NULL;
	  	$arr_cookie[] = $id;
		$arr_cookie = array_unique($arr_cookie);
		setcookie('fc_prd', json_encode($arr_cookie), time() + 3600, '/');


		$this->Autoload_Model->_update(array(
			'where' => array('id' => $id),
			'table' => 'projects',
			'data' => array('viewed' => $DetailProjects['viewed'] + 1),
		));
		
		$data['Breadcrumb'] = $this->FrontendProjectsCatalogues_Model->Breadcrumb($DetailCatalogues['lft'], $DetailCatalogues['rgt']);

		$data['User_post'] = $this->FrontendCustomers_Model->ReadByField('id', $DetailProjects['userid_created']);
		
		$data['TagsList'] = $this->FrontendTags_Model->ReadByModule($id, 'projects');
		
		$cataloguesid = $this->FrontendProjects_Model->_get_where(array(
			'select' => 'cataloguesid',
			'table' => 'catalogues_relationship',
			'where' => array(
				'modulesid' => $id,
				'modules' => 'projects',
			),
		), TRUE);
		
		$data['attribute'] = $this->FrontendProjects_Model->AttributesAllTheTime($id);
		// print_r($data['attribute']);die();
		
		$data['module'] = 'projects';
		$data['moduleid'] = $DetailProjects['id'];
		
		
		$data['projects_same'] = $this->FrontendProjects_Model->_read_condition(array(
			'modules' => 'projects',
			'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`content`, `pr`.`price`, `pr`.`created`, `pr`.`measure`, `pr`.`cataloguesid`, `pr`.`area`, `pr`.`projectid`, `pr`.`wardid`, `pr`.`districtid`, `pr`.`isaside` ',
			'where' => '`pr`.`trash` = 0 AND `pr`.`publish` = 1',
			'limit' => 4,
			'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
		), $cataloguesid);
		
		
		$data['vip'] = $this->FrontendProjects_Model->_read_condition(array(
			'modules' => 'projects',
			'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`content`, `pr`.`price`, `pr`.`created`, `pr`.`measure`, `pr`.`cataloguesid`, `pr`.`area`, `pr`.`projectid`, `pr`.`wardid`, `pr`.`districtid`',
			'where' => '`pr`.`trash` = 0  AND `pr`.`isaside` = 1 AND  `pr`.`publish` = 1',
			'limit' => 10,
			'order_by' => '`pr`.`order` asc, `pr`.`id` desc',
		), $cataloguesid);
		
		$data['prd_arr'] = isset($_COOKIE['fc_prd'])?json_decode($_COOKIE['fc_prd']):NULL;
		// print_r($data['prd_arr']);die;
		$data['meta_title'] = !empty($DetailProjects['meta_title'])?$DetailProjects['meta_title']:$DetailProjects['title'];
		$data['meta_keyword'] = $DetailProjects['meta_keyword'];
		$data['meta_description'] = !empty($DetailProjects['meta_description'])?$DetailProjects['meta_description']:cutnchar(strip_tags($DetailProjects['description']), 255);
		$data['meta_images'] = !empty($DetailProjects['images'])?base_url($DetailProjects['images']):'';
		$data['DetailProjects'] = $DetailProjects;
		$data['DetailCatalogues'] = $DetailCatalogues;
		$data['canonical'] = rewrite_url($DetailProjects['canonical'], $DetailProjects['slug'], $DetailProjects['id'], 'projects', TRUE, TRUE);
		$data['template'] = 'projects/frontend/projects/view';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	
	public function location($districtid = 0, $wardid = 0, $page = 1){
		$district = $this->Autoload_Model->_get_where(array(
			'select' => '*',
			'table' => 'province',
			'where' => array('id' => $districtid)
		));
		$ward = $this->Autoload_Model->_get_where(array(
			'select' => '*',
			'table' => 'province',
			'where' => array('id' => $wardid)
		));
		
		$config['total_rows'] = $this->FrontendProjects_Model->count_all_location($districtid,$wardid);
		$uri = $this->uri->segment(1);
		$config['base_url'] = base_url().$uri;
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['suffix'] = $this->config->item('url_suffix').(!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
			$config['prefix'] = 'trang-';
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config['per_page'] = 20;
			$config['uri_segment'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<div class="pagination" itemscope itemtype="http://schema.org/SiteNavigationElement/Pagination"><ul class="uk-pagination uk-pagination-left">';
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
			$data['PaginationList'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$seoPage = ($page >= 2)?(' - Trang '.$page):'';
			if($page >= 2){
				$data['canonical'] = $config['base_url'].'/trang-'.$page.$this->config->item('url_suffix');
			}
			$page = $page - 1;
			$data['projectsList'] = $this->FrontendProjects_Model->read_all_location(($page * $config['per_page']),$config['per_page'], $districtid, $wardid);
		}
		
		if(isset($data['projectsList']) && is_array($data['projectsList']) && count($data['projectsList'])){
			foreach($data['projectsList'] as $key => $val){
				$data['projectsList'][$key]['attribute'] =  $this->FrontendProducts_Model->AttributesAllTheTime($val['id']);
			}
		}	
		$meta_title = 'Bất động sản tại '.$ward['title'].' '.$district['title'];
		$data['meta_title'] = $meta_title;
		$data['meta_keyword'] = $meta_title;
		$data['meta_description'] = $meta_title;
		
		
		$data['template'] = 'projects/frontend/catalogues/view_location';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	public function Create(){
		if (!isset($this->fcCustomer) && !is_array($this->fcCustomer) && count($this->fcCustomer) == 0) {
			$this->session->set_flashdata('message-danger', 'Bạn phải đăng nhập để sử dụng tính năng này!');
			redirect('members/login');
		}
		$data['DetailUsers'] = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		if($this->input->post('create')){
			$isaside = $this->input->post('isaside');
			$money = $this->input->post('money');
			$attr = $this->input->post('attr');
			$data['catalogue'] = $this->input->post('catalogue'); // mảng danh mục
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('title', 'Tiêu đề đăng bài', 'trim|required');
			$this->form_validation->set_rules('catalogue', 'Loại bất động sản', 'trim|callback__Catalogue');
			$this->form_validation->set_rules('description','Thông tin liên hệ', 'trim|required');
			$this->form_validation->set_rules('content', 'Nội dung', 'trim|required');
			$this->form_validation->set_rules('isaside', 'Loại tin', 'trim|callback__CheckVip');
			if ($this->form_validation->run($this)){
				$album = $this->input->post('album');
				$album_data = '';
				$images_ = '';
				if(isset($album['images']) && is_array($album['images'])  && count($album['images'])) {
					foreach ($album['images'] as $key => $val) {
						if ($key == 0) { $images_ = $val; }
						$album_data[] = array('images' => $val); 
					}
				}
				if(isset($album_data) && is_array($album_data)  && count($album_data) && isset($album['title']) && is_array($album['title']) && count($album['title']) && isset($album['description']) && is_array($album['description']) && count($album['description'])) {
					foreach ($album_data as $key => $val) {
						$album_data[$key]['title'] = $album['title'][$key];
						$album_data[$key]['description'] = $album['description'][$key];
					}
				}

				$resultid = $this->FrontendProjects_Model->Create($this->fcCustomer['id'], $data['catalogue'], $album_data, $images_);
				if($resultid > 0){
					$temp = '';
					foreach($data['catalogue'] as $key => $val){
						$temp[] = array(
							'modules' => 'projects',
							'modulesid' => $resultid,
							'cataloguesid' => $val,
							'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
						);
					}
					if ($isaside == 1) {
						$money = $data['DetailUsers']['money'] - $money;
						$result = $this->FrontendCustomers_Model->UpdateByField('id', $this->fcCustomer['id'], array('money' => $money));
					}
					$this->BackendProjects_Model->create_batch(array('data' => $temp,'table' => 'catalogues_relationship'));
					$this->BackendAttributes_Model->InsertAttr($resultid, $attr);
					$this->session->set_flashdata('message-success', 'Đăng tin mới thành công');
					redirect('members/dang-tin');
				}
			}
		}

		$data['DetailCatalogues'] = $this->FrontendProjectsCatalogues_Model->ReadByCondition(array('select' => 'id, title, parentid, slug, canonical, images, lft, rgt','where' => array('trash' => 0,'publish' => 1), 'order_by' => 'order asc, id asc'));

		$data['meta_title'] = 'Đăng tin bất động sản';
		$data['meta_keyword'] = '';
		$data['meta_description'] = '';
		$data['meta_images'] = '';
		$data['canonical'] = 'members/dang-tin';
		$data['template'] = 'projects/frontend/projects/create';
		$this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
	}
	public function _Catalogue() {
		$catalogue = $this->input->post('catalogue');
		if(!isset($catalogue) || count($catalogue) == 0 || !is_array($catalogue) || $catalogue[0] == '') {
			$this->form_validation->set_message('_Catalogue','Loại Bất Động Sản trường bắt buộc');
			return FALSE;
		}
		return TRUE;
	}
	public function _CheckVip() {
		$DetailUsers = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		$isaside = $this->input->post('isaside');
		$month = gmdate('m', time() + 7*3600);
		$year = gmdate('Y', time() + 7*3600);
		$money = $this->input->post('money');
		$count_month = $this->FrontendProjects_Model->CountFieldArrCuss(array('created >=' => ''.$year.'-'.$month.'-01 00:00:00', 'userid_created' => $this->fcCustomer['id']));
		if(!isset($isaside) || $isaside == '') {
			$this->form_validation->set_message('_CheckVip','Loại tin đăng phải được chọn');
			return FALSE;
		}
		if (isset($isaside) && $isaside == 1 && $DetailUsers['money'] < $money) {
			$this->form_validation->set_message('_CheckVip','Số dư khả dụng để đăng tin Vip của bạn không đủ');
			return FALSE;
		}
		if ($count_month >= 3) {
			$this->form_validation->set_message('_CheckVip','Tài khoản của bạn chưa được đăng ký gói đăng tin không giới hạn. Số bài đăng trong tháng đã đạt giới hạn. Vui lòng đăng ký gói đăng tin không giới hạn để có thể đăng nhiều hơn.');return FALSE;
			return FALSE;
		}
		return TRUE;
	}	
	public function _AuthLogin(){
		$password = $this->input->post('password');
		$customer = $this->FrontendCustomers_Model->ReadByField('id', $this->fcCustomer['id']);
		if(!isset($customer) || is_array($customer) == FALSE || count($customer) == 0){
			$this->form_validation->set_message('_AuthLogin', 'Tài khoản không tồn tại');
			return FALSE;
		}
		$password_encode = password_encode($password, $customer['salt']);
		if($customer['password'] != $password_encode){
			$this->form_validation->set_message('_AuthLogin', 'Mật khẩu không đúng');
			return FALSE;
		}
		return TRUE;
	}
}
