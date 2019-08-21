<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogues extends FC_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model(array(
			'BackendProductsCatalogues_Model',
			'FrontendProductsCatalogues_Model'
		));
		$this->fc_lang = $this->config->item('fc_lang');
		$this->load->library(array('configbie'));
		$this->load->library('nestedsetbie', array('table' => 'products_catalogues'));
	}

	public function sort(){
		$data = NULL;
		$post = $this->input->post();
		foreach($post['order'] as $key => $val){
			$data[] = array(
				'id' => $key,
				'order' => $val,
			);
		}
		$flag = $this->BackendProductsCatalogues_Model->UpdateBatchByField($data, 'id');
		if($flag > 0){
			$this->nestedsetbie->Get('level ASC, order ASC');
			$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
			$this->nestedsetbie->Action();
		}
	}

	public function viewed(){
		$id = $this->input->post('id');
		if(!isset($_COOKIE['products_catalogues_viewed_'.$id])){
			$flag = $this->FrontendProductsCatalogues_Model->UpdateViewed('id', $id, $this->fc_lang);
			setcookie('products_catalogues_viewed_'.$id, 1, NULL, '/');
		}
	}
	public function createLink() {
		$link = $this->input->post('canonical');
		$link = slug($link);
		echo $link;
	}
	public function ajax() {
		$pricepost = $this->input->post('price');
		$category = $this->input->post('category');
		$pricee = explode(' - ', $pricepost);
		$price1 = intval(str_replace('.', '', $pricee[0]));
		$price2 = intval(str_replace('.', '', $pricee[1]));

		$DetailCatalogues = $this->FrontendProductsCatalogues_Model->ReadByField('id', $category, $this->fc_lang);


		$data['productsList'] = $this->FrontendProducts_Model->_viewajax(array(
				'select' => '`pr`.`id`, `pr`.`title`, `pr`.`slug`, `pr`.`canonical`, `pr`.`images`, `pr`.`description`, `pr`.`price`, `pr`.`saleoff`',
				'modules' => 'products',
				'where' => ' (`pr`.`saleoff` BETWEEN '.$price1.'  AND '.$price2.')',
			), $DetailCatalogues);

		$html = '';

		if(isset($data['productsList']) && is_array($data['productsList']) && count($data['productsList'])){ 
			$html = $html . '<ul class="uk-grid lib-grid-0 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-3 listProduct" data-uk-grid-match="{target: ".product-1 .product-title"}">';
			foreach($data['productsList'] as $key => $val) {
				$title = $val['title'];
				$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'products');
				$image = getthumb($val['images']);
				$saleoff = $val['saleoff'];
				$price = $val['price'];
				if ($price > 0) {
					$giaold = str_replace(',', '.', number_format($price)).' '.$this->lang->line('products_currency');
				}
				else
				{
					$giaold = '';
				}
				if ($saleoff > 0) {
					$gia = str_replace(',', '.', number_format($saleoff)).' '.$this->lang->line('products_currency');
				}
				else
				{
					$gia = $this->lang->line('contact');
				}
				if ($saleoff < $price) {
					$sale = '<span class="price-percent-reduction">'.ceil((($saleoff - $price)/$price)*100).'%</span>';
				}
				else
				{
					$sale = '';
				}
				$html = $html . '<li class="product-item p15 mb30">';
					$html = $html . '<div class="product-1 skin-1">';
						$html = $html . '<div class="product-thumb img-slide">';
							$html = $html . '<a class="product-image img-scaledown" href="'.$href.'">';
								$html = $html . '<img src="'.$image.'" alt="'.$title.'">';
							$html = $html . '</a>';
						$html = $html . '</div>';
						$html = $html . '<div class="prid_item">';
							$html = $html . '<h3 class="product-title"><a href="'.$href.'" title="'.$title.'">'.$title.'</a></h3>';
						$html = $html . '</div>';
						$html = $html . '<div class="name_price_km">';
							$html = $html . '<div class="price_view text-center">';
								$html = $html . '<span class="product-price">'.$gia.'</span>';
							$html = $html . '</div>';
							$html = $html . '<div class="action">';
								$html = $html . '<a class="btn-btn-addtocart ajax-addtocart" href="" data-quantity="1" title="'.$this->lang->line('products_add_cart').'" data-id="'.$val['id'].'" data-price="'.$saleoff.'">'.$this->lang->line('buy_now').'</a>';
							$html = $html . '</div>';
						$html = $html . '</div>';
					$html = $html . '</div>';
				$html = $html . '</li>';
			}
			$html = $html . '</ul>';
		} 
		else
		{
			$html =  $html . $this->lang->line('products_no_data');
		}
		$priceposts = '<b>'.$this->lang->line('price').':</b><a href="javascript:;">'.$pricepost.'</a>';
		$categorytitle = '<b>Danh mục:</b><a href="javascript:;">'.$DetailCatalogues['title'].'</a>';
		echo json_encode(array(
			'html' => $html,
			'price' => $priceposts,
			'category' => $categorytitle,
		));
	}
}
