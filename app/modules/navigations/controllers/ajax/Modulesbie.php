<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModulesBie extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->fclang = $this->config->item('fclang');
	}

	public function load(){
		$modules = strtolower($this->input->post('modules'));
		if(in_array($modules, array('articles_catalogues', 'products_catalogues','gallerys_catalogues','videos_catalogues'))){
			$this->load->library('nestedsetbie', array('table' => $modules));
			$data = $this->nestedsetbie->dropdown();
			if(isset($data) && is_array($data) && count($data)){
				$str = '';
				foreach($data as $key => $val){
					$str = $str . '<option value="'.$key.'">'.$val.'</option>';
				}
				echo $str;
			}
		}
	}

	public function loadparantid($positions = 0, $key = '', $modules = 0){
		$modules = strtolower($this->input->post('positionsid'));
		$dropdown = '';

		$dropdown = $dropdown . '<option value="0">-- Chọn Menu --</option>';
		$dropdown .= loadparantid($positions, '', $modules, $this->fclang);
		
		echo $dropdown;


	}

	public function loadsub(){
		$modules = strtolower($this->input->post('parentid'));
		if ($modules != 0) {
			for($i = 1; $i <= 15; $i++){ ?>
				<div class="hidden"><?php echo form_input('modulesid'.$i, set_value('modulesid'.$i), 'id="txtId'.$i.'"');?></div>
				<div class="form-group">
					<label class="col-sm-2 control-label">(<?php echo $i;?>)</label>
					<div class="col-sm-3">
						<?php echo form_input('title'.$i, set_value('title'.$i), 'class="form-control input-dotted" id="txtTitle'.$i.'" placeholder="Tên menu '.$i.'"');?>
					</div>
					<div class="col-sm-5">
						<?php echo form_input('href'.$i, set_value('href'.$i), 'class="form-control input-dotted" id="txtHref'.$i.'" placeholder="Đường dẫn '.$i.'"');?>
					</div>
					<div class="col-sm-2">
						<?php echo form_input('order'.$i, set_value('order'.$i), 'class="form-control input-dotted" id="txtOrder'.$i.'" placeholder="Sắp xếp '.$i.'"');?>
					</div>
				</div>
				<?php 
			} 
		}
	}

	public function loaditem(){
		$modules = $this->input->post('modules');
		$modulesid = $this->input->post('modulesid');
		if(in_array($modules, array('Articles_Catalogues', 'Products_Catalogues', 'Gallerys_Catalogues','Videos_Catalogues'))){
			$model = 'Backend'.str_replace('_', '', $modules).'_Model';
			$this->load->model(array(current(explode('_', $modules)).'/'.$model));
			$data = $this->$model->ReadAllByField('parentid', $modulesid);
			foreach($data as $key => $val){
				$data[$key]['href'] = rewrite_url($val['canonical'], $val['slug'], $val['id'], strtolower($modules));
			}
			echo json_encode($data);
		}
	}
	
}
