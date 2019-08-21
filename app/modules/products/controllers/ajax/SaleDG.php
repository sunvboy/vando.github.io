<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SaleDG extends FC_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model(array(
            'BackendSalesDG_Model',
            'routers/BackendRouters_Model',
        ));
        $this->load->library(array('configbie'));
        $this->fcUser = $this->config->item('fcUser');
        $this->fc_lang = $this->config->item('fc_lang');
        $this->fcCustomer = $this->config->item('fcCustomer');
    }

    public function search(){
        $keyword = $this->input->post('keyword');
        $id = $this->input->post('id');
        $prdid = $this->input->post('prdid');
        $html = '';
        if (!empty($keyword)) {
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id, title, images, price, saleoff',
                'table' => 'products',
                'keyword' => $keyword,
                'where' => array('parentid' =>0,'publish' =>1, 'trash' => 0, 'id !=' => $prdid),
                'where_not_in' => explode('-', $id),
                'where_not_in_field' => 'id',
                'order_by' => 'id desc, order asc'
            ),TRUE);

            if(isset($result) && is_array($result) && count($result)) {
                $html .= '<table class="table" id="diagnosis-list">';
                $html .= '<thead><tr>';
                $html .= '<th>Tiêu đề</th>';
                $html .= '<th>#</th>';
                $html .= '</tr>';
                $html .= '</thead><tbody>';
                foreach ($result as $key => $val) {
                    $image = getthumb($val['images']);
                    $price = $val['price'];
                    $saleoff = $val['saleoff'];
                    if ($price > 0) {
                        $pri_old = '<span class="span-gia">'.str_replace(',', '.', number_format($price)).' đ<span>';
                    }else{
                        $pri_old  = '';
                    }
                    if ($saleoff > 0) {
                        $pri_sale = str_replace(',', '.', number_format($saleoff)).' đ';
                    }else{
                        $pri_sale  = 'Liên hệ';
                    }
                    $html .= '<tr class="add-item" data-id="'.$val['id'].'">';
                    $html .= '<td style="width:650px;">';
                    $html .= '<article class="article-view-1 text-left">';
                    $html .= '<div class="col-sm-2 thumb">';
                    $html .= '<div class="tp-cover"><img  src="'.$image.'" alt="'.$val['title'].'" /></div>';
                    $html .= '</div>';
                    $html .= '<div class="col-sm-10">';
                    $html .= '<div class="title">'.$val['title'].'</div>';
                    $html .= '<div class="meta">';
                    $html .= $pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '');
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</article>';
                    $html .= '</td>';
                    $html .= '<td class="text-right">';
                    $html .= '<div class="btn btn-default data-active" data-id="'.$val['id'].'">';
                    $html .= '<span class="fa fa-trash"></span>';
                    $html .= '</div>';
                    $html .= '</td>';
                    $html .= '</tr>';
                }
                $html .= '</table>';
            }
        }
        echo json_encode(array('html'=>$html));die;
    }
    public function sort_order() {
        sleep(0.5);
        $id = $this->input->post('id');
        $table = 'products_sale';
        $data = $this->input->post('number');
        if(isset($table) && !empty($table) && $id > 0) {
            $this->Autoload_Model->_update_sort_order($table, $id, $data);
        }
    }
}
