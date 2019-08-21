<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tungsanpham extends FC_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'BackendProducts_Model',
            'BackendSalesDG_Model',
            'FrontendProducts_Model',
            'tags/BackendTags_Model',
            'customers/FrontendCustomers_Model'
        ));
        $this->load->library(array('configbie'));
        $this->fcUser = $this->config->item('fcUser');
        $this->fc_lang = $this->config->item('fc_lang');
        $this->fcCustomer = $this->config->item('fcCustomer');
    }
    public function searchtungsanpham(){
        $keyword = $this->input->post('keyword');
        $id = $this->input->post('id');
        $prdid = $this->input->post('prdid');
        $html = '';
        if (!empty($keyword)) {
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id, title, slug, canonical, images, description, price, saleoff, status,tmp_tungsanpham',
                'table' => 'products',
                'keyword' => $keyword,
                'where' => array('publish' =>1, 'trash' => 0, 'parentid' => 0, 'id !=' => $prdid),
                'where_not_in' => explode('-', $id),
                'where_not_in_field' => 'id',
                'order_by' => 'id desc, order asc'
            ),TRUE);

            if(isset($result) && is_array($result) && count($result)) {
                $html .= '<table class="table" id="diagnosis-list">';
                $html .= '<thead><tr>';
                $html .= '<th>Tiêu đề</th>';
                $html .= '<th>Giá sản phẩm được sale</th>';
                $html .= '<th>Tình trạng</th>';
                $html .= '<th></th>';
                $html .= '</tr>';
                $html .= '</thead><tbody>';
                foreach ($result as $key => $val) {
                    $image = getthumb($val['images']);
                    $description = cutnchar(strip_tags($val['description']), 250);
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
                    $html .= '<div class="description">'.$description.'</div>';
                    $html .= '<div class="meta">';
                    $html .= $pri_sale.((!empty($price) && !empty($saleoff) && $price > $saleoff) ? $pri_old : '');
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</article>';
                    $html .= '</td>';
                    $html .= '<td><input type="text" value="'.$val['tmp_tungsanpham'].'" placeholder="Giá cả sản phẩm được sale" class="form-control" name="saleoff[]"></td>';
                    $html .= '<td style="text-align:center"><span class="btn '.((!empty($val['status']==1)) ? 'btn-success' : 'btn-danger').'">'.$this->configbie->data('status', $val['status']).'</span></td>';
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
    public function settungsan($type = NULL, $id = 0)
    {
        $redirect = $this->input->get('redirect');
        $id = (int)$id;
        $data['products'] = $this->BackendSalesDG_Model->ReadByFieldTungSanPham('id', $id);

        if ($data['products']['publish'] == 0) {
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id,tmp_tungsanpham,saleoff',
                'table' => 'products',
                'where' => array('publish' =>1, 'trash' => 0),
                'where_in' => explode('-', $data['products']['id_combo']),
                'where_in_field' => 'id',
                'order_by' => 'id desc, order asc'
            ),TRUE);
            if(isset($result) && is_array($result) && count($result)) {
                foreach ($result as $key => $val) {
                    $this->BackendSalesDG_Model->_update(array(
                        'table' => 'products',
                        'where' => array('id' => $val['id']),
                        'data' => array(
                            'saleoff' => $val['tmp_tungsanpham'],
                        )
                    ));
                }
            }

        }else if($data['products']['publish'] == 1){
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id,tmp_tungsanpham,saleoff,tmp_saleoff_tungsanpham',
                'table' => 'products',
                'where' => array('publish' =>1, 'trash' => 0),
                'where_in' => explode('-', $data['products']['id_combo']),
                'where_in_field' => 'id',
                'order_by' => 'id desc, order asc'
            ),TRUE);
            if(isset($result) && is_array($result) && count($result)) {
                foreach ($result as $key => $val) {
                    if($val['tmp_saleoff_tungsanpham'] != 0){
                        $this->BackendSalesDG_Model->_update(array(
                            'table' => 'products',
                            'where' => array('id' => $val['id']),
                            'data' => array(
                                'saleoff' => $val['tmp_saleoff_tungsanpham'],
                            )
                        ));
                    }

                }

            }
        }

        $temp[$type] = (($data['products'][$type] == 1) ? 0 : 1);
        $this->db->where('id', $id);
        $this->db->update('products_sale_tungsanpham', $temp);
        redirect((!empty($redirect)) ? $redirect : 'products/backend/salesDG/viewtungsanpham');
    }

}