<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('redirect_custom')){
	function redirect_custom($default = NULL){
		$CI =& get_instance();
		$redirect = $CI->input->get('redirect');
		if(isset($redirect) && !empty($redirect)){
			redirect($redirect);
		}
		redirect($default);
	}
}

if(!function_exists('removeutf8')){
	function removeutf8($value = NULL){
		$chars = array(
			'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
			'e' =>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
			'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
			'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
			'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
			'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
			'd'	=>	array('đ','Đ'),
		);
		foreach ($chars as $key => $arr)
			foreach ($arr as $val)
				$value = str_replace($val, $key, $value);
		return $value;
	}
}

if(!function_exists('slug')){
	function slug($value = NULL){	
		$value = removeutf8($value);
		$value = str_replace('-', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '-', trim($value)));
	}
}

if(!function_exists('rewrite_url')){
	function rewrite_url($canonical = '', $slug = '', $id = 0, $modules = 'articles_catalogues', $suffix = TRUE, $fulllink = FALSE, $aff = FALSE){
		$CI =& get_instance();
		$domain = ($fulllink == TRUE)?BASE_URL:'';
		$keys = $CI->input->get('keys');
		$customers = $CI->config->item('fcCustomer');
		$mod = '';
		if(in_array($modules, array('articles_tags'))){
			$mod = 'tags/';
		}
		if(!empty($canonical)){
			if ($modules == 'tags') {
				return ($suffix == TRUE)?($domain.'tags/'.$mod.$canonical.FCSUFFIX):($domain.'tags/'.$mod.$canonical);
			}else{
				return (($suffix == TRUE)?($domain.$mod.$canonical.FCSUFFIX):($domain.$mod.$canonical)).(($aff == TRUE) ? '' : ((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : ''));
			} 
		}
		$id = ($id == 0)?'':$id;
		switch(strtolower($modules)){
			case 'attributes': return (($suffix == TRUE)?($domain.$slug.'-att'.$id.FCSUFFIX):($domain.$slug.'-att'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'articles_catalogues': return (($suffix == TRUE)?($domain.$slug.'-ac'.$id.FCSUFFIX):($domain.$slug.'-ac'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'articles': return (($suffix == TRUE)?($domain.$slug.'-a'.$id.FCSUFFIX):($domain.$slug.'-a'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'gallerys_catalogues': return (($suffix == TRUE)?($domain.$slug.'-gc'.$id.FCSUFFIX):($domain.$slug.'-gc'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'gallerys': return (($suffix == TRUE)?($domain.$slug.'-g'.$id.FCSUFFIX):($domain.$slug.'-g'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'videos_catalogues': return (($suffix == TRUE)?($domain.$slug.'-vc'.$id.FCSUFFIX):($domain.$slug.'-vc'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'videos': return (($suffix == TRUE)?($domain.$slug.'-v'.$id.FCSUFFIX):($domain.$slug.'-v'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');

			case 'products_overview': return (($suffix == TRUE)?($domain.'overview/'.$slug.'-ov'.$id.FCSUFFIX):($domain.'overview/'.$slug.'-ov'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'products_lecture': return (($suffix == TRUE)?($domain.'lecture/'.$slug.'-learn'.$id.FCSUFFIX):($domain.'lecture/'.$slug.'-learn'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');

			case 'products_catalogues': return (($suffix == TRUE)?($domain.$slug.'-pc'.$id.FCSUFFIX):($domain.$slug.'-pc'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'products': return (($suffix == TRUE)?($domain.$slug.'-p'.$id.FCSUFFIX):($domain.$slug.'-p'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			

			case 'tags': return (($suffix == TRUE)?($domain.'tags/'.$slug.'-tag'.$id.FCSUFFIX):($domain.'tags/'.$slug.'-tag'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'projects_catalogues': return (($suffix == TRUE)?($domain.$slug.'-jc'.$id.FCSUFFIX):($domain.$slug.'-jc'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'projects': return (($suffix == TRUE)?($domain.$slug.'-j'.$id.FCSUFFIX):($domain.$slug.'-j'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'address': return (($suffix == TRUE)?($domain.$slug.'-ad'.$id.FCSUFFIX):($domain.$slug.'-ad'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			
			case 'teachers': return (($suffix == TRUE)?($domain.$slug.'-te'.$id.FCSUFFIX):($domain.$slug.'-te'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
			case 'products_sale': return (($suffix == TRUE)?($domain.$slug.'-ps'.$id.FCSUFFIX):($domain.$slug.'-ps'.$id)).((isset($customers) && is_array($customers) && count($customers)) ? '?aff='.$customers['affiliate_id'].'' : '');
		}
	}
}