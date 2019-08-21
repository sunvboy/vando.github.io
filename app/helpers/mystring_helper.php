<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('cutnchar')){
	function cutnchar($str = NULL, $n = 0){
		if(strlen($str) < $n) return $str;
		$html = substr($str, 0, $n);
		$html = substr($html, 0, strrpos($html,' '));
		return $html.'...';
	}
}

if(!function_exists('getthumb')){
	function getthumb($image = '', $thumb = TRUE){
		$image = !empty($image)?$image:'templates/not-found.png';
		if($thumb == TRUE){
			$image_thumb = str_replace('/uploads/images/', '/uploads/.thumbs/images/', $image);
			if (file_exists(dirname(dirname(dirname(__FILE__))).$image_thumb)){
				return $image_thumb;
			}
		}
		return $image;
	}
}

if(!function_exists('show_time')){
	function show_time($time, $type = 'H:i - d/m/Y'){
		return gmdate($type, strtotime($time) + 7*3600);
	}
}

if(!function_exists('gettime')){
	function gettime($time, $type = 'H:i - d/m/Y'){
		return gmdate($type, strtotime($time) + 7*3600);
	}
}

if(!function_exists('convertUtf8')){
	function convertUtf8($str = ''){
		$str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
		return $str;
	}
}

if(!function_exists('random')){
	function random($leng = 168, $char = FALSE){
		if($char == FALSE) $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
		else $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		mt_srand((double)microtime() * 1000000);
		$salt = '';
		for ($i=0; $i<$leng; $i++){
			$salt = $salt . substr($s, (mt_rand()%(strlen($s))), 1);
		}
		return $salt;
	}
}

if(!function_exists('password_encode')){
	function password_encode($password = '', $salt = ''){
		return md5(md5($password).$salt);
	}
}

if(!function_exists('encode_code_active')){
	function encode_code_active($customersid = '', $productsid = '', $salt = ''){
		return md5(md5($salt.$customersid).$productsid);
	}
}

if(!function_exists('getSystem')){
	function getSystem($var = ''){
		$CI =& get_instance();
		$system = $CI->config->item('fcSystem');
		return (isset($system[$var]) && !empty($system[$var]))?$system[$var]:'';
	}
}

if(!function_exists('convertPrice')){
	function convertPrice($price = ''){
		$ty = ($price / 1000000000);
		if($ty > 1){
			return round($ty, 1).' tỷ';
		}
		$tramtrieu = ($price / 100000000);
		if($tramtrieu > 1){
			return round($tramtrieu).' trăm triệu';
		}
		$chuctrieu = ($price / 10000000);
		if($chuctrieu > 1){
			return round($tramtrieu).' mươi triệu';
		}
		$trieu = ($price / 1000000);
		if($trieu > 1){
			return round($trieu).' triệu';
		}
		return $price;
	}
}

