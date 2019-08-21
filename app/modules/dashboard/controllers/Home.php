<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fcUser = $this->config->item('fcUser');
		if(!$this->fcUser) redirect('admin/login');
		$this->load->model(array('payments/BackendPayments_Model'));
	}

	public function Index(){
		/* THỐNG KÊ LƯỢT VÀO WEBSITE TRONG 2 TUẦN GẦN NHẤT */
		// $data['current_week'] = user_statistic('current');
		// $data['last_week'] = user_statistic('lastweek');
		/* ---------------------------------------------- */
		
		/* 5 sản phẩm được xem nhiều nhất */
		$product = '';
		$top_product = $this->FrontendProducts_Model->ReadByCondition(array('select' => 'id, viewed, title','where' => array('publish' => 1,'trash' => 0),'order_by' => 'viewed desc','limit' => 5));
		
		if(isset($top_product) && is_array($top_product) && count($top_product)){
			foreach($top_product as $key => $val){
				$product[] = array('label' => $val['title'],'value' => $val['viewed'],);
			}
		}
		$data['top_p'] = $product;
		/* ------------------------------- */
		
		/* THỐNG KÊ KẾT QUẢ KINH DOANH CÁC NĂM*/
		$statistic_info = '';
		for($i = 1; $i <= 12; $i++){
			if($i >= 1 && $i <= 3){$color = '#008ee4';}if($i >= 4 && $i<=6){$color = '#9b59b6';}if($i >=7 && $i<=9){$color = '#6baa01';}
			if($i >=10 && $i<=12){$color = '#e44a00';}
			$statistic_info[$i] = array(
				'label' => 'Tháng '.$i,
				'value' => $this->BackendPayments_Model->Statistic(array('month' => $i)),
				'color' => $color,
			);
		}
		$data['revenue'] =  $statistic_info;
		$data['result'] = array_values($data['revenue']);
		/* ------------------------------------------- */
		
		$data['template'] = 'dashboard/backend/home/index';
		$this->load->view('dashboard/backend/layouts/home', isset($data)?$data:NULL);
	}
	
	
	
}
