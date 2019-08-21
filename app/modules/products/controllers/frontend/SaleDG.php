<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SaleDG extends FC_Controller{

    public function __construct(){
        parent::__construct();
        $this->fc_lang = $this->config->item('fc_lang');
        $this->fcCustomer = $this->config->item('fcCustomer');
        if($this->fcSystem['homepage_website'] == 1){
            echo '<img src="'.base_url().'templates/backend/images/close.jpg'.'" style="width:100%;" />';die();
        }
        $this->load->library(array('configbie'));
        $this->load->model(array(
            'products/FrontendSaleDG_Model',
        ));
    }
    public function View($id = 0){
        $id = (int)$id;
        $seoPage = '';
        $DetailCatalogues = $this->FrontendSaleDG_Model->ReadByField('id', $id );
        if(!isset($DetailCatalogues) && !is_array($DetailCatalogues) && count($DetailCatalogues) == 0){
            $this->session->set_flashdata('message-danger', 'Không tồn tại chương trình sale');
            redirect(base_url());
        }
        $data['productsList'] = $this->Autoload_Model->_get_where(array(
            'select' => 'id, title,slug,canonical,description,count_order,highlight,psale, images, price, saleoff,active_phamtramgiamgia,tmp_active_phamtramgiamgia',
            'table' => 'products',
            'where' => array('publish' =>1, 'trash' => 0),
            'where_in' => explode('-', $DetailCatalogues['id_combo']),
            'where_in_field' => 'id',
            'order_by' => 'order asc,id desc'
        ),TRUE);
        $data['meta_title'] = (!empty($DetailCatalogues['meta_title'])?$DetailCatalogues['meta_title']:$DetailCatalogues['title']).$seoPage;
        $data['meta_keyword'] = $DetailCatalogues['meta_keyword'];
        $data['meta_description'] = (!empty($DetailCatalogues['meta_description'])?$DetailCatalogues['meta_description']:'').$seoPage;
        $data['meta_images'] = !empty($DetailCatalogues['images'])?base_url($DetailCatalogues['images']):'';
        $data['canonical'] = rewrite_url($DetailCatalogues['canonical'], $DetailCatalogues['slug'], $DetailCatalogues['id'], 'products_sale', TRUE, TRUE);
        $data['DetailCatalogues'] = $DetailCatalogues;
        $data['template'] = 'products/frontend/saleDG/view';
        $this->load->view('homepage/frontend/layouts/home', isset($data)?$data:NULL);
    }
}
