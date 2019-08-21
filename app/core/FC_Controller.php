<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FC_Controller extends MX_Controller{
	
	public $fcSystem;
	public $online;
	public $day_value;
	public $yesterday_value;
	public $all_value;
	public $fclang;
	public $fc_lang;
	function __construct(){
		parent::__construct();
		$this->load->library('cart');
		$this->load->helper('captcha');
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		/**
		 * Model
		 *
		 */
		$this->load->model(array(
			'Navigations/FrontendNavigationsMenus_Model',
			'Systems/FrontendSystems_Model',
			'Functions/BackendFunctions_Model',
			'Routers/FrontendRouters_Model',
			'Routers/BackendRouters_Model',
			'Supports/BackendSupports_Model',
			'Supports/BackendSupportsCatalogues_Model',
			'Articles/FrontendArticles_Model',
			'Articles/FrontendArticlesCatalogues_Model',
			'Gallerys/FrontendGallerys_Model',
			'Gallerys/FrontendGallerysCatalogues_Model',
			'Videos/FrontendVideos_Model',
			'Videos/FrontendVideosCatalogues_Model',
			'Products/FrontendProducts_Model',
			'Products/FrontendProductsCatalogues_Model',
			'Attributes/FrontendAttributes_Model',
			'Attributes/FrontendAttributesCatalogues_Model',
			'Attributes/BackendAttributes_Model',
			'Attributes/BackendAttributesCatalogues_Model',
			'Users/FrontendUsers_Model',
			'Dashboard/Autoload_Model',
			'Slides/FrontendSlides_Model',
			'tags/FrontendTags_Model',
			'address/Frontendaddress_Model',
			'supports/Frontendsupports_Model',
			'supports/FrontendSupportsCatalogues_Model',
			'mailsubricre/Frontendmailsubricre_Model',
			'comments/Frontendicons_model',
			'customers/FrontendCustomers_Model',
			'projects/FrontendProjectsCatalogues_Model',
			'projects/FrontendProjects_Model',
			'projects/BackendProjects_Model',
			'lichhoc/FrontendLichhocCatalogues_Model',
			'lichhoc/FrontendLichhoc_Model',
			'teachers/FrontendTeachers_Model',
		));

		/**
		 * Auth
		 *
		 */
		$auth = $this->commonbie->CheckAuth();
		// print_r($auth);die();
		if(isset($auth) && is_array($auth) && count($auth)){
			$this->config->set_item('fcUser', $auth);
		}

		$fclang = $this->commonbie->CheckLang();
		if(!isset($fclang) || !empty($fclang)){
			$this->config->set_item('fclang', $fclang);
		}
		else{
			$this->config->set_item('fclang', 'vietnamese');
		}
		

		$customer_auth = $this->commonbie->CheckCustomerAuth();
		if(isset($customer_auth) && is_array($customer_auth) && count($customer_auth)){
			$this->config->set_item('fcCustomer', $customer_auth);
		}

		//Nếu người dùng không đăng nhập thì affiliate 1 lần
		if(!isset($customer_auth) || is_array($customer_auth) == false || count($customer_auth) <= 0){
			$this->affiliate(); // Set cookie nếu có người dùng được giới thiệu
		}
		
		/**
		 * Systems
		 *
		 */


		$language = $this->input->get('lang');
		if(isset($language) && !empty($language)){
			$fc_lang = isset($_COOKIE['fc_lang'])?$_COOKIE['fc_lang']:NULL;
			if(isset($fc_lang) && !empty($fc_lang)){
				setcookie('fc_lang', $language, time() + 3600, '/');
				$this->config->set_item('fc_lang', $language);
				if ($language == $_COOKIE['fc_lang']) {
				}
				else{
					$this->cart->destroy();
				}
			}
			else
			{
				setcookie('fc_lang', 'vietnamese', time() + 3600, '/');
				$this->config->set_item('fc_lang', 'vietnamese');
			}
			redirect(BASE_URL);
		}
		else
		{
			$fc_lang = isset($_COOKIE['fc_lang'])?$_COOKIE['fc_lang']:NULL;
			if(isset($fc_lang) && !empty($fc_lang)){
				setcookie('fc_lang', $_COOKIE['fc_lang'], time() + 3600, '/');
				$this->config->set_item('fc_lang', $_COOKIE['fc_lang']);
			}
			else
			{
				setcookie('fc_lang', 'vietnamese', time() + 3600, '/');
				$this->config->set_item('fc_lang', 'vietnamese');
			}
		}
		
		$fc_lang = isset($_COOKIE['fc_lang'])?$_COOKIE['fc_lang']:NULL;
		if(isset($fc_lang) && !empty($fc_lang)){
			$this->lang->load('main_lang', $fc_lang);
		}
		else
		{
			$this->lang->load('main_lang', 'vietnamese');
		}
		
		$this->fcSystem = $this->FrontendSystems_Model->ReadAll($this->config->item('fc_lang'));
		$this->config->set_item('fcSystem', $this->fcSystem);

		/**
		 * Device
		 *
		 */
		$detect = $this->input->get('detect');
		if(isset($detect) && !empty($detect)){
			if(in_array($detect, array('tablet', 'mobile', 'desktop'))){
				setcookie('fc_device', $detect, time() + 30*24*3600, '/');
				$this->config->set_item('fcDevice', $detect);
			}
			else{
				setcookie('fc_device', 'desktop', time() + 30*24*3600, '/');
				$this->config->set_item('fcDevice', 'desktop');
			}
		}
		else{

			if(!isset($_COOKIE['fc_device']) || empty($_COOKIE['fc_device'])){
				require_once('plugins/mobile_detect.php');
				$detect = new Mobile_Detect;
				$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
				setcookie('fc_device', $deviceType, time() + 30*24*3600, '/');
				$this->config->set_item('fcDevice', $deviceType);
			}
			else{
				setcookie('fc_device', $_COOKIE['fc_device'], time() + 30*24*3600, '/');
				$this->config->set_item('fcDevice', $_COOKIE['fc_device']);
			}
		}

		// Thống kê truy cập 

		$counter_path_http = BASE_URL;
		$counter_expire = 300;

		$ignore = false; 

		$this->db->select('*')->from('counter_values');
		$row = $this->db->get()->row_array();
		// fill when empty
		
		if (!$row)
		{	  
			$_insert = array(
				'id' => 1,
				'day_id' => date("z"),
				'day_value' => 1,
				'yesterday_id' => (date("z")-1),
				'yesterday_value' => 0,
				'week_id' => date("W"),
				'week_value' => 1,
				'month_id' => date("n"),
				'month_value' => 1,
				'year_id' => date("Y"),
				'year_value' => 1,
				'all_value' => 1,
				'record_date' => gmdate('Y-m-d H:i:s', time() + 7*3600),
				'record_value' => 1,
			);

			$this->db->insert('counter_values', $_insert);

			$this->db->select('*')->from('counter_values');
			$row = $this->db->get()->row_array();

			$ignore = true;
		}   
	

		$day_id = $row['day_id'];
		$day_value = $row['day_value'];
		$yesterday_id = $row['yesterday_id'];
		$yesterday_value = $row['yesterday_value'];
		$week_id = $row['week_id'];
		$week_value = $row['week_value'];
		$month_id = $row['month_id'];
		$month_value = $row['month_value'];
		$year_id = $row['year_id'];
		$year_value = $row['year_value'];
		$all_value = $row['all_value'];
		$record_date = $row['record_date'];
		$record_value = $row['record_value'];

		$counter_agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? addslashes(trim($_SERVER['HTTP_USER_AGENT'])) : "";
		$counter_time = time();
		$counter_ip = trim(addslashes($_SERVER['REMOTE_ADDR'])); 

		// ignorore some bots
		if (substr_count($counter_agent, "bot") > 0)  {$ignore = true;}

		// delete free ips
		if ($ignore == false)
		{

			$sql = "DELETE FROM counter_ips WHERE unix_timestamp(NOW())-unix_timestamp(visit) > $counter_expire";
		 	$this->db->query($sql);
		}
		  
		// check for entry
		if ($ignore == false)
		{
			$sql = "select * from counter_ips where ip = '$counter_ip' and session = '".session_id()."'";
			$res = $this->db->query($sql)->num_rows();
			if ($res == 0)
			{
				// insert
				$sql = "INSERT INTO counter_ips (ip, visit, session) VALUES ('$counter_ip', NOW(), '".session_id()."')";
				$this->db->query($sql);
			}
			else
			{
				$ignore = true;
				$sql = "UPDATE counter_ips SET visit = NOW() WHERE ip = '$counter_ip' AND session = '".session_id()."'";
				$this->db->query($sql);
			}
		}

		// online?
		$this->db->select('*')->from('counter_ips');
		$online = $this->db->count_all_results();
		
		  
		// add counter
		if ($ignore == false)
		{     	  
			// yesterday
			if ($day_id == (date("z")-1)) 
			{
				$yesterday_value = $day_value; 
				$yesterday_id = (date("z")-1);
			}
			else
			{
				if ($yesterday_id != (date("z")-1))
				{
					$yesterday_value = 0; 
					$yesterday_id = date("z")-1;
				}
			}
			// day
			if ($day_id == date("z")) 
			{
				$day_value++; 
			}
			else 
			{
				$day_value = 1;
				$day_id = date("z");
			}

			// week
			if ($week_id == date("W")) 
			{
				$week_value++; 
			}
			else 
			{ 
				$week_value = 1;
				$week_id = date("W");
			}

			// month
			if ($month_id == date("n")) 
			{
				$month_value++; 
			}
			else 
			{
				$month_value = 1;
				$month_id = date("n");
			}

			// year
			if ($year_id == date("Y")) 
			{
				$year_value++; 
			}
			else 
			{
				$year_value = 1;
				$year_id = date("Y");
			}

			// all
			$all_value++;

			// neuer record?
			if ($day_value > $record_value)
			{
				$record_value = $day_value;
				$record_date = date("Y-m-d H:i:s");
			}

			// speichern und aufräumen
			$sql = "UPDATE counter_values SET day_id = '$day_id', day_value = '$day_value', yesterday_id = '$yesterday_id', yesterday_value = '$yesterday_value', week_id = '$week_id', week_value = '$week_value', month_id = '$month_id', month_value = '$month_value', year_id = '$year_id', year_value = '$year_value', all_value = '$all_value', record_date = '$record_date', record_value = '$record_value' where id = 1";
			$this->db->query($sql);
		}
	}
	public function affiliate(){
		$affiliate = '';
		$uf = $this->input->get('aff');
		if(!empty($uf)){
			$affiliate = $this->FrontendCustomers_Model->ReadByField('affiliate_id', $uf);
			if(isset($affiliate) && is_array($affiliate) && count($affiliate)){
				setcookie('affiliate', $uf, time() + 30*24*3600, '/');
			}
		}
		return $affiliate;
	}
}
