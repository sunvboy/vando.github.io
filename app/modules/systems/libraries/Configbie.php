<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ConfigBie
{

    function __construct($params = NULL)
    {
        $this->params = $params;
    }

    // meta_title là 1 row -> seo_meta_title
    // contact_address
    // chưa có thì insert
    // có thì update
    public function system()
    {
        $data['homepage'] = array(
            'brandname' => array('type' => 'text', 'label' => 'Tên thương hiệu'),
            'company' => array('type' => 'text', 'label' => 'Tên công ty'),
            'logo' => array('type' => 'images', 'label' => 'Logo'),
            // 'slogan' => array('type' => 'images', 'label' => 'Logo Chân Trang'),
            // 'note' => array('type' => 'text', 'label' => 'Slogan'),
//			'logo1' => array('type' => 'dropdown', 'label' => 'Thời gian Sales', 'class' => 'select2', 'value'=> array('' => 'Chọn thời gian khuyến mãi', '1' => '24h', '5' => '5 Ngày', '10' => '10 Ngày')),
            'favicon' => array('type' => 'images', 'label' => 'Favicon'),
            'bocongthuong' => array('type' => 'images', 'label' => 'Ảnh bộ công thương'),
            'links_bocongthuong' => array('type' => 'text', 'label' => 'Link bộ công thương'),
            // 'cover' => array('type' => 'images', 'label' => 'Ảnh Cover gửi mail'),
            'website' => array('type' => 'dropdown', 'label' => 'Trạng thái website', 'value' => array('Mở cửa website', 'Đóng Website bảo trì')),
//			'slogan' => array('type' => 'dropdown', 'label' => 'Sản phẩm liên quan','value' => array('Không hiển thị','Có hiển thị')),
//			'note' => array('type' => 'dropdown', 'label' => 'Sản phẩm quan tâm','value' => array('Không hiển thị','Có hiển thị')),
            'note' => array('type' => 'editor', 'label' => 'Chương trình khuyến mại'),

        );
        $data['contact'] = array(
//            'address' => array('type' => 'text', 'label' => 'Địa chỉ 1'),
            // 'email2' => array('type' => 'text','label' => 'Địa chỉ 2'),
//            'time_lv' => array('type' => 'text', 'label' => 'Giờ làm việc'),
//            'phone' => array('type' => 'text', 'label' => 'Số điện thoại'),
//            'hotline' => array('type' => 'text', 'label' => 'Hotline'),
//            'fax' => array('type' => 'text', 'label' => 'Fax'),
            'email' => array('type' => 'text', 'label' => 'Địa chỉ Email'),
            'web' => array('type' => 'text', 'label' => 'Website'),
//            'tongdai' => array('type' => 'text', 'label' => 'Free Ship Topbar'),
//            'capcuu' => array('type' => 'editor', 'label' => 'Free Ship chi tiết SP'),
            // 'links_map' => array('type' => 'textarea', 'label' => 'Links bản đồ'),
//            'map' => array('type' => 'textarea', 'label' => 'Bản đồ'),
//            'contact' => array('type' => 'editor', 'label' => 'Trang liên hệ'),
        );
        $data['banner'] = array(
            'banner_1' => array('type' => 'images', 'label' => 'Banner trang chủ 1'),
            'banner_1l' => array('type' => 'text', 'label' => 'Banner trang chủ 1 links'),
            'banner_2' => array('type' => 'images', 'label' => 'Banner trang chủ 2'),
            'banner_2l' => array('type' => 'text', 'label' => 'Banner trang chủ 2 links'),
            'banner_3' => array('type' => 'images', 'label' => 'Banner mobile'),
            'banner_3l' => array('type' => 'text', 'label' => 'Banner mobile links'),

        );
        $data['services'] = array(
            'services_1' => array('type' => 'text', 'label' => 'Sản phẩm chính hãng'),
            'services_2' => array('type' => 'text', 'label' => 'Description sản phẩm'),
            'services_3' => array('type' => 'text', 'label' => 'Bảo hành sản phẩm'),
            'services_4' => array('type' => 'text', 'label' => 'Description bảo hành'),
            'services_5' => array('type' => 'text', 'label' => 'Miễn phí vận chuyển'),
            'services_6' => array('type' => 'text', 'label' => 'Description vận chuyển'),
        );
        $data['seo'] = array(
            'meta_title' => array('type' => 'text', 'label' => 'Meta Title'),
            'meta_keywords' => array('type' => 'text', 'label' => 'Meta Keyword'),
            'meta_description' => array('type' => 'text', 'label' => 'Meta Description'),
            'meta_image' => array('type' => 'images', 'label' => 'Meta Image'),
        );
        $data['social'] = array(

            'facebook' => array('type' => 'text', 'label' => 'Facebook'),
            'instagram' => array('type' => 'text', 'label' => 'Instagram'),
            'youtube' => array('type' => 'text', 'label' => 'Youtube'),
            'zalo' => array('type' => 'text', 'label' => 'Zalo'),
        );
        $data['HOTLINE'] = array(
            'goimuahang_title' => array('type' => 'text', 'label' => 'Gọi mua hàng'),
            'goimuahang_tv' => array('type' => 'text', 'label' => 'Thời gian làm việc'),
            'goimuahang_phone' => array('type' => 'text', 'label' => 'Số điện thoại'),
            'goimuahang_des' => array('type' => 'text', 'label' => 'Mô tả'),
            'khieunai_title' => array('type' => 'text', 'label' => 'GÓP Ý, KHIẾU NẠI'),
            'khieunai_tv' => array('type' => 'text', 'label' => 'Thời gian làm việc'),
            'khieunai_phone' => array('type' => 'text', 'label' => 'Số điện thoại'),
            'khieunai_des' => array('type' => 'text', 'label' => 'Mô tả'),

        );
        $data['shopnow'] = array(
            'title' => array('type' => 'text', 'label' => 'Tiêu đề'),
            'images' => array('type' => 'images', 'label' => 'Ảnh đại diện'),
            'links' => array('type' => 'text', 'label' => 'LInks'),
        );
        $data['common'] = array(
            'phiship' => array('type' => 'editor', 'label' => 'Phí Ship'),
            'doitra' => array('type' => 'editor', 'label' => 'Đổi trả'),
        );
        $data['UUDAI'] = array(
            'title' => array('type' => 'text', 'label' => 'Tiêu đề'),
            'description' => array('type' => 'text', 'label' => 'Mô tả'),
        );
        $data['script'] = array(
            'header' => array('type' => 'textarea', 'label' => 'Script đầu trang'),
            'body' => array('type' => 'textarea', 'label' => 'Script thân trang'),
        );
        // $data['construction'] =  array(
        // 	'menu_backround' => array('type' => 'text', 'label' => 'Màu nền Menu','class'=> 'jscolor'),
        // );
        // $data['loto'] =  array(
        // 	'thayboi' => array('type' => 'text', 'label' => 'Thầy bói phán'),
        // 	'nguoidep' => array('type' => 'text', 'label' => 'Người đẹp phán'),
        // );

        return $data;
    }
}