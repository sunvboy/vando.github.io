<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesDG extends FC_Controller
{
    public $action;

    public function __construct()
    {
        parent::__construct();
        $this->fcUser = $this->config->item('fcUser');
        $this->fclang = $this->config->item('fclang');

        if (!$this->fcUser) redirect('admin/login');
        $this->load->model(array(
            'BackendSalesDG_Model',
            'BackendProducts_Model',
            'routers/BackendRouters_Model',
        ));
        $this->load->library(array('configbie'));

    }

    public function View($page = 1)
    {
        $page = (int)$page;
        $config['total_rows'] = $this->BackendSalesDG_Model->CountAll();
        if ($config['total_rows'] > 0) {
            $this->load->library('pagination');
            $config['base_url'] = base_url('products/backend/salesDG/view');
            $config['suffix'] = $this->config->item('url_suffix') . (!empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '');
            $config['first_url'] = $config['base_url'] . $config['suffix'];
            $config['per_page'] = 10;
            $config['uri_segment'] = 5;
            $config['use_page_numbers'] = TRUE;
            $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $this->pagination->initialize($config);
            $data['ListPagination'] = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page <= 0) ? 1 : $page;
            $page = ($page > $totalPage) ? $totalPage : $page;
            $page = $page - 1;
            $data['Listproducts'] = $this->BackendSalesDG_Model->ReadAll(($page * $config['per_page']), $config['per_page']);
        }
        $data['template'] = 'products/backend/salesDG/view';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }
    public function Viewchotungsanpham($page = 1)
    {
        $page = (int)$page;
        $config['total_rows'] = $this->BackendSalesDG_Model->CountAllTungSanPham();
        if ($config['total_rows'] > 0) {
            $this->load->library('pagination');
            $config['base_url'] = base_url('products/backend/salesDG/view');
            $config['suffix'] = $this->config->item('url_suffix') . (!empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '');
            $config['first_url'] = $config['base_url'] . $config['suffix'];
            $config['per_page'] = 10;
            $config['uri_segment'] = 5;
            $config['use_page_numbers'] = TRUE;
            $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $this->pagination->initialize($config);
            $data['ListPagination'] = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page <= 0) ? 1 : $page;
            $page = ($page > $totalPage) ? $totalPage : $page;
            $page = $page - 1;
            $data['Listproducts'] = $this->BackendSalesDG_Model->ReadAllTungSanPham(($page * $config['per_page']), $config['per_page']);
        }
        $data['template'] = 'products/backend/salesDG/viewtungsanpham';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }
    public function viewsalesoluong($page = 1)
    {


        $page = (int)$page;
        $config['total_rows'] = $this->BackendSalesDG_Model->CountAllSoLuong();
        if ($config['total_rows'] > 0) {
            $this->load->library('pagination');
            $config['base_url'] = base_url('products/backend/salesDG/view');
            $config['suffix'] = $this->config->item('url_suffix') . (!empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '');
            $config['first_url'] = $config['base_url'] . $config['suffix'];
            $config['per_page'] = 10;
            $config['uri_segment'] = 5;
            $config['use_page_numbers'] = TRUE;
            $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $this->pagination->initialize($config);
            $data['ListPagination'] = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page <= 0) ? 1 : $page;
            $page = ($page > $totalPage) ? $totalPage : $page;
            $page = $page - 1;
            $data['Listproducts'] = $this->BackendSalesDG_Model->ReadAllSoLuong(($page * $config['per_page']), $config['per_page']);
        }
        $data['template'] = 'products/backend/salesDG/viewsoluong';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }
    public function updatesoluong($id = 0)
    {
        $id = (int)$id;
        $data['DetailProducts'] = $this->BackendSalesDG_Model->ReadByFieldSoLuong('id', $id);
        if (!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0) {
            $this->session->set_flashdata('message-danger', 'Không tồn tại');
            redirect_custom('products/backend/salesDG/viewsalesoluong');
        }
        if ($this->input->post('update')) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', ' / ');
            $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
            if($data['DetailProducts']['id']==1){
                $this->form_validation->set_rules('qty', 'Số lượng', 'trim|required');
                $this->form_validation->set_rules('saleoff', 'Phần trăm giảm giá', 'trim|required');
            }else if($data['DetailProducts']['id']==2){
                $this->form_validation->set_rules('saleoff', 'Phần trăm giảm giá', 'trim|required');

            }

            if ($this->form_validation->run($this)) {
                $this->BackendSalesDG_Model->UpdateByPostSoLuong($id);
                $this->session->set_flashdata('message-success', 'Cập nhật thành công');
                redirect_custom('products/backend/salesDG/viewsalesoluong');
            }
        }
        $data['template'] = 'products/backend/salesDG/updatesoluong';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }
    public function updatetungsanpham($id = 0)
    {
        $id = (int)$id;
        $data['DetailProducts'] = $this->BackendSalesDG_Model->ReadByFieldTungSanPham('id', $id);
        if (!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0) {
            $this->session->set_flashdata('message-danger', 'Không tồn tại');
            redirect_custom('products/backend/salesDG/viewsalesoluong');
        }
        if ($this->input->post('update')) {
            $time = date('Y-m-d H:i:s');


            $saleoff = $this->input->post('saleoff');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', ' / ');
            $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');

            if ($this->form_validation->run($this)) {
                $this->BackendSalesDG_Model->UpdateByPostTungSanPham($id);
                //trả về giá cũ trước khi cập nhập giá mới
                $ReadAllSale = $this->Autoload_Model->_get_where(array(
                    'select' => 'id, tmp_saleoff_tungsanpham',
                    'table' => 'products',
                    'where' => array('publish' =>1, 'trash' => 0),
                    'where_in' => explode('-', $data['DetailProducts']['id_combo']),
                    'where_in_field' => 'id',
                    'order_by' => 'id desc, order asc'
                ),TRUE);
                foreach ($ReadAllSale as $key=>$items) {
                    $ReadByFieldProducts = $this->BackendSalesDG_Model->ReadByField('id',$items['id'], $this->fclang );
                    $this->BackendSalesDG_Model->_update(array(
                        'table' => 'products',
                        'where' => array('id' =>  $items['id']),
                        'data' => array(
                            'saleoff' => $items['tmp_saleoff_tungsanpham'],
                            'tmp_tungsanpham' => $items['tmp_tungsanpham'],
                        )
                    ));
                }
                //end
                //kiểm tra chương trình có đang chạy hay không
                $listitems_products = explode('-',$this->input->post('id_combo'));
                if(($this->input->post('time_start') <= $time) && ($this->input->post('time_end') >= $time) &&  ($this->input->post('publish') ==1) ){
                    foreach($listitems_products as $key=>$val){
                        $DetailProducts = $this->BackendProducts_Model->ReadByField('id', $val, $this->fclang);
                        $this->BackendSalesDG_Model->_update(array(
                            'table' => 'products',
                            'where' => array('id' => $DetailProducts['id']),
                            'data' => array(
                                'saleoff' => $saleoff[$key],
                                'tmp_tungsanpham' => $saleoff[$key],
                            )
                        ));
                    }
                }else{
                    foreach($listitems_products as $key=>$val){
                        $DetailProducts = $this->BackendProducts_Model->ReadByField('id', $val, $this->fclang);
                        $this->BackendSalesDG_Model->_update(array(
                            'table' => 'products',
                            'where' => array('id' => $DetailProducts['id']),
                            'data' => array(
                                'saleoff' =>  $DetailProducts['tmp_saleoff_tungsanpham'],
                                'tmp_tungsanpham' => $saleoff[$key],
                            )
                        ));
                    }
                }

                //end



                $this->session->set_flashdata('message-success', 'Cập nhật thành công');
                redirect_custom('products/backend/salesDG/viewsalesoluong');
            }
        }
        $data['template'] = 'products/backend/salesDG/updatetungsanpham';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }

    public function Create()
    {

        if ($this->input->post('create')) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', ' / ');
            $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
            $this->form_validation->set_rules('saleoff', 'Giá là', 'trim|required|callback__Zero');
            if ($this->form_validation->run($this)) {
                $resultid = $this->BackendSalesDG_Model->Create();
                if ($resultid > 0) {
                    //lưu giá tạm
                    $time = date('Y-m-d H:i:s');
                    $list_products = explode('-', $this->input->post('id_combo'));
                    if(($this->input->post('time_start') <= $time) && ($this->input->post('time_end') >= $time) &&  ($this->input->post('publish') ==1) ){
                        $temp = '';
                        foreach ($list_products as $items) {
                            $temp[] = array(
                                'saleid' => $resultid,
                                'productsid' => $items,
                            );
                            $this->BackendSalesDG_Model->_update(array(
                                'table' => 'products',
                                'where' => array('id' =>  $items),
                                'data' => array(
                                    'saleoff' => (int)str_replace('.','', $this->input->post('saleoff')),
                                    'saleoff_tmp' => (int)str_replace('.','', $this->input->post('saleoff')),
                                )
                            ));
                        }
                        $this->BackendSalesDG_Model->create_batch(array('data' => $temp, 'table' => 'products_sale_relationship'));
                    }else{
                        $temp = '';
                        foreach ($list_products as $items) {
                            $temp[] = array(
                                'saleid' => $resultid,
                                'productsid' => $items,
                            );
                            $ReadByFieldProducts = $this->BackendSalesDG_Model->ReadByFieldProducts('id',$items );
                            $this->BackendSalesDG_Model->_update(array(
                                'table' => 'products',
                                'where' => array('id' =>  $items),
                                'data' => array(
                                    'saleoff' => $ReadByFieldProducts['saleoff_tmp_saleoff'],
                                    'saleoff_tmp' => (int)str_replace('.','', $this->input->post('saleoff'))
                                )
                            ));
                        }
                        $this->BackendSalesDG_Model->create_batch(array('data' => $temp, 'table' => 'products_sale_relationship'));
                    }
                    //end lưu giá tạm
                    $canonical = slug($this->input->post('canonical'));
                    if (!empty($canonical)) {
                        $this->BackendRouters_Model->Create($canonical, 'products/frontend/salesDG/view', $resultid, 'number');
                    }
                    $this->session->set_flashdata('message-success', 'Thêm sản phẩm thành công');
                    redirect('products/backend/salesDG/view');
                }
            }

        }
        $data['template'] = 'products/backend/salesDG/create';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }

    public function Update($id = 0)
    {
        $id = (int)$id;
        $data['DetailProducts'] = $this->BackendSalesDG_Model->ReadByField('id', $id);
        if (!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0) {
            $this->session->set_flashdata('message-danger', 'sản phẩm không tồn tại');
            redirect_custom('products/backend/salesDG/view');
        }
        if ($this->input->post('update')) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', ' / ');
            $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
            $this->form_validation->set_rules('saleoff', 'Giá là', 'trim|required|callback__Zero');


            if ($this->form_validation->run($this)) {

                $flag = $this->BackendSalesDG_Model->UpdateByPost('id', $id, $this->fcUser);
                if ($flag > 0) {
                    //trả về giá cũ trước khi cập nhập giá mới
                    $ReadAllSale = $this->BackendSalesDG_Model->ReadAllSale(array('saleid'=>$id));
                    foreach ($ReadAllSale as $key=>$items) {
                        $ReadByFieldProducts = $this->BackendSalesDG_Model->ReadByFieldProducts('id',$items['productsid'] );
                        $this->BackendSalesDG_Model->_update(array(
                            'table' => 'products',
                            'where' => array('id' =>  $items['productsid']),
                            'data' => array(
                                'saleoff' => $ReadByFieldProducts['saleoff_tmp_saleoff'],
                            )
                        ));
                    }

                    //end


                    //lưu giá tạm
                    $time = date('Y-m-d H:i:s');
                    $list_products = explode('-', $this->input->post('id_combo'));
                    if(($this->input->post('time_start') <= $time) && ($this->input->post('time_end') >= $time) &&  ($this->input->post('publish') ==1) ){
                        $temp = '';
                        foreach ($list_products as $items) {
                            $temp[] = array(
                                'saleid' => $id,
                                'productsid' => $items,
                            );
                            $this->BackendSalesDG_Model->_update(array(
                                'table' => 'products',
                                'where' => array('id' =>  $items),
                                'data' => array(
                                    'saleoff' => (int)str_replace('.','', $this->input->post('saleoff')),
                                    'saleoff_tmp' => (int)str_replace('.','', $this->input->post('saleoff')),
                                )
                            ));
                        }
                        $this->BackendSalesDG_Model->_delete_batch_sale('saleid', $id, 'products_sale_relationship');
                        $this->BackendSalesDG_Model->create_batch(array('data' => $temp, 'table' => 'products_sale_relationship'));
                    }else{
                        $temp = '';
                        foreach ($list_products as $items) {
                            $temp[] = array(
                                'saleid' => $id,
                                'productsid' => $items,
                            );
                            $ReadByFieldProducts = $this->BackendSalesDG_Model->ReadByFieldProducts('id',$items );
                            $this->BackendSalesDG_Model->_update(array(
                                'table' => 'products',
                                'where' => array('id' =>  $items),
                                'data' => array(
                                    'saleoff' => $ReadByFieldProducts['saleoff_tmp_saleoff'],
                                    'saleoff_tmp' => (int)str_replace('.','', $this->input->post('saleoff'))
                                )
                            ));
                        }
                        $this->BackendSalesDG_Model->_delete_batch_sale('saleid', $id, 'products_sale_relationship');
                        $this->BackendSalesDG_Model->create_batch(array('data' => $temp, 'table' => 'products_sale_relationship'));
                    }


                    //end lưu giá tạm
                    $canonical = slug($this->input->post('canonical'));
                    if (!empty($canonical)) {
                        $this->BackendRouters_Model->Delete($canonical, 'products/frontend/salesDG/view', $id, 'number');
                        $this->BackendRouters_Model->Create($canonical, 'products/frontend/salesDG/view', $id, 'number');
                    } else {
                        $this->BackendRouters_Model->Delete($canonical, 'products/frontend/salesDG/view', $id, 'number');
                    }

                }
                $this->session->set_flashdata('message-success', 'Cập nhật sản phẩm thành công');
                redirect_custom('products/backend/salesDG/view');
            }

        }
        $data['template'] = 'products/backend/salesDG/update';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }
    public function Update_50($id = 0)
    {
        $id = (int)$id;
        $data['DetailProducts'] = $this->BackendSalesDG_Model->ReadByField('id', $id);
        if (!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0) {
            $this->session->set_flashdata('message-danger', 'sản phẩm không tồn tại');
            redirect_custom('products/backend/salesDG/view');
        }
        if ($this->input->post('update')) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', ' / ');
            $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('canonical', 'Canonical', 'trim|callback__Canonical');
            $this->form_validation->set_rules('saleoff', 'Phầm trăm giảm giá', 'trim|required|callback__Zero');


            if ($this->form_validation->run($this)) {

                $flag = $this->BackendSalesDG_Model->UpdateByPost_50('id', $id, $this->fcUser);
                if ($flag > 0) {
                    //trả về giá cũ trước khi cập nhập giá mới
                    $ReadAllSale = $this->BackendSalesDG_Model->ReadAllSale(array('saleid'=>$id));
                    foreach ($ReadAllSale as $key=>$items) {
                        $this->BackendSalesDG_Model->_update(array(
                            'table' => 'products',
                            'where' => array('id' =>  $items['productsid']),
                            'data' => array(
                                'active_phamtramgiamgia' => 0,
                            )
                        ));
                    }
                    //end
                    //lưu giá tạm
                    $time = date('Y-m-d H:i:s');
                    $list_products = explode('-', $this->input->post('id_combo'));
                    if(($this->input->post('time_start') <= $time) && ($this->input->post('time_end') >= $time) &&  ($this->input->post('publish') ==1) ){
                        $temp = '';
                        foreach ($list_products as $items) {
                            $temp[] = array(
                                'saleid' => $id,
                                'productsid' => $items,
                            );
                            $this->BackendSalesDG_Model->_update(array(
                                'table' => 'products',
                                'where' => array('id' =>  $items),
                                'data' => array(
                                    'active_phamtramgiamgia' => 1,
                                    'tmp_active_phamtramgiamgia' => (int)$this->input->post('saleoff'),
                                )
                            ));
                        }
                        $this->BackendSalesDG_Model->_delete_batch_sale('saleid', $id, 'products_sale_relationship');
                        $this->BackendSalesDG_Model->create_batch(array('data' => $temp, 'table' => 'products_sale_relationship'));
                    }else{
                        $temp = '';
                        foreach ($list_products as $items) {
                            $temp[] = array(
                                'saleid' => $id,
                                'productsid' => $items,
                            );
                            $this->BackendSalesDG_Model->_update(array(
                                'table' => 'products',
                                'where' => array('id' =>  $items),
                                'data' => array(
                                    'active_phamtramgiamgia' => 0,
                                    'tmp_active_phamtramgiamgia' => (int)$this->input->post('saleoff'),
                                )
                            ));
                        }
                        $this->BackendSalesDG_Model->_delete_batch_sale('saleid', $id, 'products_sale_relationship');
                        $this->BackendSalesDG_Model->create_batch(array('data' => $temp, 'table' => 'products_sale_relationship'));
                    }


                    //end lưu giá tạm
                    $canonical = slug($this->input->post('canonical'));
                    if (!empty($canonical)) {
                        $this->BackendRouters_Model->Delete($canonical, 'products/frontend/salesDG/view', $id, 'number');
                        $this->BackendRouters_Model->Create($canonical, 'products/frontend/salesDG/view', $id, 'number');
                    } else {
                        $this->BackendRouters_Model->Delete($canonical, 'products/frontend/salesDG/view', $id, 'number');
                    }

                }
                $this->session->set_flashdata('message-success', 'Cập nhật sản phẩm thành công');
                redirect_custom('products/backend/salesDG/view');
            }

        }
        $data['template'] = 'products/backend/salesDG/update_50';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }

    public function Delete($id = 0)
    {
        $id = (int)$id;
        $data['DetailProducts'] = $this->BackendSalesDG_Model->ReadByField('id', $id);
        if (!isset($data['DetailProducts']) && !is_array($data['DetailProducts']) && count($data['DetailProducts']) == 0) {
            $this->session->set_flashdata('message-danger', 'Không tồn tại');
            redirect_custom('products/backend/salesDG/view');
        }
        if ($this->input->post('delete')) {
            $flag = $this->BackendSalesDG_Model->DeleteByField('id', $id);
            if ($flag > 0) {
                if (!empty($data['DetailProducts']['canonical'])) {
                    $this->BackendRouters_Model->Delete($data['DetailProducts']['canonical'], 'products/frontend/salesDG/view', $data['DetailProducts']['id'], 'number');
                }
                $this->session->set_flashdata('message-success', 'Xóa thành công');
                redirect('products/backend/salesDG/view');
            }
        }
        $data['template'] = 'products/backend/salesDG/delete';
        $this->load->view('dashboard/backend/layouts/home', isset($data) ? $data : NULL);
    }

    public function _Canonical()
    {
        $canonical = slug($this->input->post('canonical'));
        $canonical_original = slug($this->input->post('canonical_original'));
        if (empty($canonical)) {
            return TRUE;
        }
        if ($canonical != $canonical_original) {
            $count = $this->BackendRouters_Model->count($canonical);
            if ($count > 0) {
                $this->form_validation->set_message('_Canonical', 'Canonical đã tồn tại');
                return FALSE;
            }
        }
        return TRUE;
    }
    public function _Zero()
    {
        $saleoff = (int)str_replace('.','', $this->input->post('saleoff'));
        if ($saleoff > 0) {
            return TRUE;
        }else{
            $this->form_validation->set_message('_Zero', 'Giá sale phải lớn hơn 0');
            return FALSE;
        }
        return TRUE;
    }
    public function set($type = NULL, $id = 0)
    {
        $redirect = $this->input->get('redirect');
        $id = (int)$id;
        $data['products'] = $this->BackendSalesDG_Model->ReadByField('id', $id);
        if ($data['products']['publish'] == 0) {
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id, title, images, price, saleoff, saleoff_tmp,saleoff_tmp_saleoff',
                'table' => 'products',
                'where' => array('publish' =>1, 'trash' => 0),
                'where_in' => explode('-', $data['products']['id_combo']),
                'where_in_field' => 'id',
                'order_by' => 'id desc, order asc'
            ),TRUE);
            if(isset($result) && is_array($result) && count($result)) {
                foreach ($result as $key => $val) {

                    $ReadByFieldProducts = $this->BackendSalesDG_Model->ReadByFieldProducts('id',$val['id'] );
                    $this->BackendSalesDG_Model->_update(array(
                        'table' => 'products',
                        'where' => array('id' =>  $val['id']),
                        'data' => array(
                            'saleoff' => $ReadByFieldProducts['saleoff_tmp'],
                        )
                    ));
                }
            }

        }else if($data['products']['publish'] == 1){
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id, title, images, price, saleoff, saleoff_tmp,saleoff_tmp_saleoff',
                'table' => 'products',
                'where' => array('publish' =>1, 'trash' => 0),
                'where_in' => explode('-', $data['products']['id_combo']),
                'where_in_field' => 'id',
                'order_by' => 'id desc, order asc'
            ),TRUE);
            if(isset($result) && is_array($result) && count($result)) {
                foreach ($result as $key => $val) {
                    $ReadByFieldProducts = $this->BackendSalesDG_Model->ReadByFieldProducts('id',$val['id'] );
                    $this->BackendSalesDG_Model->_update(array(
                        'table' => 'products',
                        'where' => array('id' =>  $val['id']),
                        'data' => array(
                            'saleoff' => $ReadByFieldProducts['saleoff_tmp_saleoff'],
                        )
                    ));
                }
            }
        }

        $temp[$type] = (($data['products'][$type] == 1) ? 0 : 1);
        $this->db->where('id', $id);
        $this->db->update('products_sale', $temp);
        redirect((!empty($redirect)) ? $redirect : 'products/backend/salesDG/view');
    }
    public function set_50($type = NULL, $id = 0)
    {
        $redirect = $this->input->get('redirect');
        $id = (int)$id;
        $data['products'] = $this->BackendSalesDG_Model->ReadByField('id', $id);
        if ($data['products']['publish'] == 0) {
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id, title,active_phamtramgiamgia,tmp_active_phamtramgiamgia',
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
                        'where' => array('id' =>  $val['id']),
                        'data' => array(
                            'active_phamtramgiamgia' => 1,
                        )
                    ));
                }
            }

        }else if($data['products']['publish'] == 1){
            $result = $this->Autoload_Model->_get_where(array(
                'select' => 'id, title,active_phamtramgiamgia,tmp_active_phamtramgiamgia',
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
                        'where' => array('id' =>  $val['id']),
                        'data' => array(
                            'active_phamtramgiamgia' => 0,
                        )
                    ));
                }
            }
        }

        $temp[$type] = (($data['products'][$type] == 1) ? 0 : 1);
        $this->db->where('id', $id);
        $this->db->update('products_sale', $temp);
        redirect((!empty($redirect)) ? $redirect : 'products/backend/salesDG/view');
    }
    public function setsoluong($type = NULL, $id = 0){
        $redirect = $this->input->get('redirect');
        $id = (int)$id;
        $data['products'] = $this->BackendSalesDG_Model->ReadByFieldSoLuong('id', $id);
        $temp[$type] = (($data['products'][$type] == 1) ? 0 : 1);
        $this->db->where('id', $id);
        $this->db->update('products_sale_soluong', $temp);
        redirect((!empty($redirect)) ? $redirect : 'products/backend/salesDG/viewsalesoluong');
    }
}
