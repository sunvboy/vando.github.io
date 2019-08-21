<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		$this->fclang = $this->config->item('fclang');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('BackendCoupon_Model'));
		$this->load->library('ConfigBie');
	}

	public function view($page = 1){
		$this->commonbie->Permissions(array(
			'uri' => 'coupon/backend/coupon/view'
		));
		$page = (int)$page;
		$config['total_rows'] = $this->BackendCoupon_Model->CountAll();
		if($config['total_rows'] > 0){
			$this->load->library('pagination');
			$config['base_url'] = base_url('coupon/backend/coupon/view');
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
			$data['listPagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$data['listCoupon'] = $this->BackendCoupon_Model->ReadAll(($page * $config['per_page']), $config['per_page']);	
		}
		$data['template'] = 'coupon/backend/coupon/view';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function create(){
		$this->commonbie->Permissions(array(
			'uri' => 'coupon/backend/coupon/create'
		));
		if($this->input->post('create')){
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('couponCode', 'Mã Voucher', 'trim|required');
			$this->form_validation->set_rules('couponTypeValue', 'Giá trị khuyến mại', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run()){
				$flag = $this->BackendCoupon_Model->Create($this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Thêm mới mã voucher thành công');
					redirect('coupon/backend/coupon/view');
				}
			}
		}
		$data['template'] = 'coupon/backend/coupon/create';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function update($id = 0){
		$this->commonbie->Permissions(array(
			'uri' => 'coupon/backend/coupon/update'
		));
		$id = (int)$id;
		$data['Detailcoupon'] = $this->BackendCoupon_Model->ReadByFeild($id);
		if(!isset($data['Detailcoupon']) && !is_array($data['Detailcoupon']) && count($data['Detailcoupon']) == 0){
			$this->session->set_flashdata('message-danger', 'Bản ghi không tồn tại');
			redirect_custom('coupon/backend/coupon/view');
		}
		$data['checkPurchase'] = $data['Detailcoupon']['requiresMinimumPurchase'];
		$data['checkAppliesTo'] = $data['Detailcoupon']['appliesTo'];
		$data['checkLimitTotalUse'] = $data['Detailcoupon']['limitTotalUse'];
		$data['checkScheduleEndDate'] = $data['Detailcoupon']['scheduleEndDate'];
		if($this->input->post('update')){
			$data['checkPurchase'] = $this->input->post('requiresMinimumPurchase');
			$data['checkAppliesTo'] = $this->input->post('appliesTo');
			$data['checkLimitTotalUse'] = $this->input->post('limitTotalUse');
			$data['checkScheduleEndDate'] = $this->input->post('scheduleEndDate');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', ' / ');
			$this->form_validation->set_rules('couponCode', 'Mã Voucher', 'trim|required');
			$this->form_validation->set_rules('couponTypeValue', 'Giá trị khuyến mại', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run()){
				$flag = $this->BackendCoupon_Model->Update($id, $this->fcUser);
				if($flag > 0){
					$this->session->set_flashdata('message-success', 'Cập nhật bản ghi thành công');
					redirect_custom('coupon/backend/coupon/view');
				}
			}
		}
		$data['template'] = 'coupon/backend/coupon/update';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}

	public function set($type = NULL, $id = 0){
		$redirect = $this->input->get('redirect');
		$id = (int)$id;
		$data['coupon'] = $this->BackendCoupon_Model->ReadByFeild($id);
		$temp[$type] = (($data['coupon'][$type] == 1)?0:1);
		$temp['userid_updated'] = $this->fcUser['id'];
		$temp['updated'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
		$this->db->where('id', $id);
		$this->db->update('coupon', $temp);
		redirect((!empty($redirect)) ? $redirect : 'coupon/backend/coupon/view');
	}

	// public function delete($id = 0){
	// $this->commonbie->Permissions(array(
	// 	'uri' => 'coupon/backend/coupon/delete'
	// ));
	// 	$id = (int)$id;
	// 	$data['Detailcoupon'] = $this->BackendCoupon_Model->read($id, $this->fclang);
	// 	if(!isset($data['Detailcoupon']) && !is_array($data['Detailcoupon']) && count($data['Detailcoupon']) == 0){
	// 		$this->session->set_flashdata('message-danger', ' không tồn tại');
	// 		redirect_custom('coupon/backend/coupon/view');
	// 	}
	// 	if($this->input->post('delete')){
	// 		$flag = $this->BackendCoupon_Model->delete($id);
	// 		if($flag > 0){
	// 			$this->session->set_flashdata('message-success', 'Xóa  thành công');
	// 			redirect('coupon/backend/coupon/view');
	// 		}
	// 	}
	// 	$data['template'] = 'coupon/backend/coupon/delete';
	// 	$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	// }

	public function _Check(){
		$couponCode = $this->input->post('couponCode');
		$count = $this->BackendCoupon_Model->CheckField('couponCode', $couponCode);
		if($count > 0){
			$this->form_validation->set_message('_Check','Mã Voucher đã tồn tại');
			return false;
		}
		return true;
	}
}
