<?php defined('BASEPATH') OR exit('No direct script access allowed');
if(!function_exists('tag_highlight')){
	function tag_highlight(){
		$CI =& get_instance();
		return $CI->FrontendTags_Model->ReadAllByField('highlight', 1);
	}
}