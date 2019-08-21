<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('recursive')){
 	function recursive($array = '', $parentid = 0, $keyt = 'child'){
  		$temp = '';
  		if(isset($array) && is_array($array) && count($array)){
   			foreach($array as $key => $val){
    			if($val['parentid'] == $parentid){
     				$temp[] = $val;
     				if(isset($temp) && is_array($temp) && count($temp)){
      					foreach($temp as $keyTemp => $valTemp){
       						$temp[$keyTemp][$keyt] = recursive($array, $valTemp['id']);
      					}
     				}
    			}
   			}
 	 	}
  	return $temp;
 	}
}

if(!function_exists('loadparantid')){
	function loadparantid($positions = 0, $keyt = '', $modules, $lang = 'vietnamese'){
		$CI =& get_instance();
		$dropdown = '';
		$keyt = $keyt.'|---';
		$CI->db->where(array('publish' => 1, 'parentid' => $positions, 'positionsid' => $modules, 'alanguage' => $lang));
		$result = $CI->db->select('id, title')->from('navigations_menus')->order_by('order ASC, title asc')->get()->result_array();
		// $result = $this->db->affected_rows();
		$CI->db->flush_cache();
		
		if(isset($result) && is_array($result) && count($result)){
			foreach($result as $key => $val){
				if ($modules == $val['id']) {
					$sl = 'selected';
					$dis = 'disabled="";';
				}
				else
				{
					$sl = $dis = '';
				}
				$dropdown = $dropdown . '<option '.$sl.' '.$dis.' value="'.$val['id'].'">'.$keyt.$val['title'].'</option>';
				$dropdown .= loadparantid($val['id'], $keyt, $modules, $lang);
			}
		}
		return $dropdown;
	}
}
if(!function_exists('showcatidgoc')){
	function showcatidgoc($id, $parentid, $table ='') {
	    $CI =& get_instance();
	    $titlecat ="";
	    if ($parentid != 0) {
	        $result = $CI->db->select('id, parentid')->from(''.$table.'_catalogues')->where(array('id' => $parentid))->get()->result_array();
	        if(isset($result) && is_array($result) && count($result)){
	            foreach($result as $key => $val){
		            if($val['parentid'] != 0) {
		                $titlecat = showcatidgoc($val['id'], $val['parentid'], $table);
		            }
		            else
		            {
		                $titlecat = $val['id'];
		            }
		        }
	        }
	    }
	    else
	    {
	        $titlecat = $id;
	    }
	    return $titlecat;
	}
}

if(!function_exists('show_item_menu')){
	function show_item_menu($item = ''){
		if(isset($item) && is_array($item) && count($item)){ ?>
			<ul class="uk-list uk-clearfix subMenus">
				<?php foreach($item as $key => $valss){ ?>
					<li>
						<a href="<?php echo $valss['href']; ?>" title="<?php echo $valss['title']; ?>">
						<?php echo $valss['title']; ?></a>
						<?php  
							if(isset($valss['child']) && is_array($valss['child']) && count($valss['child'])){
								show_item_menu($valss['child']); 
							} 
						?>
					</li>
				<?php } ?>
			</ul>
		<?php }
	}
}
if(!function_exists('navigations_array')){
	function navigations_array($positions = 'main', $lang = 'vietnamese'){
		$CI =& get_instance();
		$Menus = $CI->FrontendNavigationsMenus_Model->ReadAllByField($positions, $lang);
		if(isset($Menus) && is_array($Menus) && count($Menus)){
			$Menus = recursive($Menus);
		}		return $Menus;
	}
}

if(!function_exists('navigations')){
	function navigations($positions = 'main-menu', $style = 'main-menu'){
		$CI =& get_instance();
		$Menus = $CI->FrontendNavigationsMenus_Model->ReadAllByField($positions);
		if(isset($Menus) && is_array($Menus) && count($Menus)){
			$Menuid = NULL;
			foreach($Menus as $key => $val){
				$Menuid[] = $val['id'];
			}
			$MenusItems = $CI->FrontendNavigationsMenus_Model->ReadAllItemsByField($Menuid);
		}
		
		$String = '';
		if(isset($Menus) && is_array($Menus) && count($Menus)){
			foreach($Menus as $keyMenus => $valMenus){
				$TempMenusItems = '';
				if(isset($MenusItems) && is_array($MenusItems) && count($MenusItems)){
					foreach($MenusItems as $keyMenusItems => $valMenusItems){
						if($valMenus['id'] != $valMenusItems['menusid']) continue;
						$TempMenusItems = $TempMenusItems . '<li class="l2"><a href="'.$valMenusItems['href'].'" title="'.htmlspecialchars($valMenusItems['title']).'" class="l2">'.$valMenusItems['title'].'</a>';
					}
					$TempMenusItems = (!empty($TempMenusItems)?('<ul class="l2 uk-nav uk-nav-navbar uk-dropdown uk-dropdown-navbar">'.$TempMenusItems.'</ul>'):'');
				}
				$String = $String . (!empty($TempMenusItems)?'<li class="l1 uk-parent" data-uk-dropdown>':'<li class="l1">');
				$String = $String . '<a href="'.$valMenus['href'].'" title="'.htmlspecialchars($valMenus['title']).'" class="l1">'.$valMenus['title'].'</a>';
				$String = $String . $TempMenusItems;
				$String = $String . '</li>';
			}
		}
		$String = (!empty($String)?('<ul class="l1 uk-navbar-nav uk-hidden-small">'.$String.'</ul>'):'');
		return $String;
	}
}