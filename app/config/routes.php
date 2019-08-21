<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'homepage/home/index';
$route['404_override'] = '';

$route[BACKEND_DIRECTORY] = 'dashboard/home/index';
$route[BACKEND_DIRECTORY.'/login'] = 'users/backend/auth/login';
$route[BACKEND_DIRECTORY.'/recovery'] = 'users/backend/auth/recovery';

// Customers
$route['register'] = 'customers/frontend/auth/register';
$route['login'] = 'customers/frontend/auth/login';
$route['login-google'] = 'customers/ajax/auth/Login_google';
$route['login-fbcallback'] = 'customers/ajax/auth/fbcallback';
$route['xac-minh$'] = 'customers/ajax/auth/verify';
$route['logout'] = 'customers/ajax/auth/logout';
$route['quen-mat-khau'] = 'customers/manage/manage/recovery';
$route['my-profile'] = 'customers/manage/manage/information';
$route['thay-doi-mat-khau'] = 'customers/manage/manage/password';



$route['my-lesson$'] = 'customers/manage/manage/lesson';
$route['my-affiliate$'] = 'customers/manage/manage/affiliate';
$route['my-order/trang-([0-9]+)$'] = 'customers/manage/manage/order/$1';

$route['my-order$'] = 'customers/manage/manage/order';
$route['my-order-detail$'] = 'customers/manage/manage/order_detail';
$route['my-coint$'] = 'customers/manage/manage/coint';


/* Đặt mua */
$route['dat-mua'] = 'products/frontend/cart/payment';
$route['dat-mua-thanh-cong'] = 'products/frontend/cart/success';
$route['vnpay-create-payment'] = 'products/frontend/cart/vnpay_create_payment';
$route['vnpay-return'] = 'products/frontend/cart/vnpay_return';
$route['inquiry'] = 'products/frontend/cart/inquiry';
/* ------------------------------------------------*/

$route['lich-hoc/trang-([0-9]+)$'] = 'lichhoc/frontend/catalogues/view/$2';
$route['lich-hoc$'] = 'lichhoc/frontend/catalogues/view';
$route['([a-zA-Z0-9/-]+)-lh([0-9]+)$'] = 'lichhoc/frontend/lichhoc/view/$2';

$route['kich-hoat-code$'] = 'homepage/home/active_code';

// teachers
$route['([a-zA-Z0-9/-]+)-te([0-9]+)$'] = 'teachers/frontend/teachers/view/$2';

//Tag
$route['tags/([a-zA-Z0-9/-]+)-tag([0-9]+)$'] = 'tags/frontend/articles/view/$2';

/*mailsubricre*/
$route['mailsubricre$'] = 'mailsubricre/frontend/mailsubricre/create';

// Sitemap
$route['sitemap'] = 'homepage/home/sitemap';
$route['sitemap.xml'] = 'homepage/home/sitemap/xml';

//Attributes
$route['([a-zA-Z0-9/-]+)-att([0-9]+)/trang-([0-9]+)$'] = 'attributes/frontend/attributes/view/$2/$3';
$route['([a-zA-Z0-9/-]+)-att([0-9]+)$'] = 'attributes/frontend/attributes/view/$2';

// Frontend Articles
$route['([a-zA-Z0-9/-]+)-ac([0-9]+)/trang-([0-9]+)$'] = 'articles/frontend/catalogues/view/$2/$3';
$route['([a-zA-Z0-9/-]+)-ac([0-9]+)$'] = 'articles/frontend/catalogues/view/$2';
$route['([a-zA-Z0-9/-]+)-a([0-9]+)$'] = 'articles/frontend/articles/view/$2';


//Introducts
$route['introducts'] = 'articles/frontend/introducts/view';

// Frontend Projects
$route['([a-zA-Z0-9/-]+)-qh([0-9]+)px([0-9]+)/trang-([0-9]+)$'] = 'projects/frontend/projects/location/$2/$3/$4';
$route['([a-zA-Z0-9/-]+)-qh([0-9]+)px([0-9]+)$'] = 'projects/frontend/projects/location/$2/$3';

$route['([a-zA-Z0-9/-]+)-jc([0-9]+)/trang-([0-9]+)$'] = 'projects/frontend/catalogues/view/$2/$3';
$route['([a-zA-Z0-9/-]+)-jc([0-9]+)$'] = 'projects/frontend/catalogues/view/$2';

$route['([a-zA-Z0-9/-]+)-j([0-9]+)$'] = 'projects/frontend/projects/view/$2';
$route['members/dang-tin$'] = 'projects/frontend/projects/create';

$route['project-search/trang-([0-9]+)$'] = 'projects/frontend/projects/search/$2';
$route['project-search$'] = 'projects/frontend/projects/search/';

$route['dang-ky-dang-tin-tron-goi$'] = 'projects/frontend/projects/register/';
$route['members/payment$'] = 'projects/frontend/projects/payment/';
$route['members/history$'] = 'projects/frontend/projects/history/';

// $route['tim-kiem/trang-([0-9]+)$'] = 'articles/frontend/search/view/$1';
// $route['tim-kiem'] = 'articles/frontend/search/view';

// Frontend Gallerys
$route['([a-zA-Z0-9/-]+)-gc([0-9]+)/trang-([0-9]+)$'] = 'gallerys/frontend/catalogues/view/$2/$3';
$route['([a-zA-Z0-9/-]+)-gc([0-9]+)$'] = 'gallerys/frontend/catalogues/view/$2';
$route['([a-zA-Z0-9/-]+)-g([0-9]+)$'] = 'gallerys/frontend/gallerys/view/$2';

// Frontend Videos
$route['([a-zA-Z0-9/-]+)-vc([0-9]+)/trang-([0-9]+)$'] = 'videos/frontend/catalogues/view/$2/$3';
$route['([a-zA-Z0-9/-]+)-vc([0-9]+)$'] = 'videos/frontend/catalogues/view/$2';
$route['([a-zA-Z0-9/-]+)-v([0-9]+)$'] = 'videos/frontend/videos/view/$2';

// Frontend Products
$route['khoa-hoc/trang-([0-9]+)$'] = 'products/frontend/home/view/$2';
$route['khoa-hoc$'] = 'products/frontend/home/view';

$route['([a-zA-Z0-9/-]+)-pc([0-9]+)/trang-([0-9]+)$'] = 'products/frontend/catalogues/view/$2/$3';
$route['([a-zA-Z0-9/-]+)-pc([0-9]+)$'] = 'products/frontend/catalogues/view/$2';
$route['([a-zA-Z0-9/-]+)-p([0-9]+)$'] = 'products/frontend/products/view/$2';
$route['([a-zA-Z0-9/-]+)-ps([0-9]+)$'] = 'products/frontend/saleDG/view/$2';

$route['overview/([a-zA-Z0-9/-]+)-ov([0-9]+)$'] = 'products/frontend/products/overview/$2';
$route['learning/lecture-([0-9]+)$'] = 'products/frontend/products/learning/$1';

//Frontend Address
$route['documents/trang-([0-9]+)$'] = 'address/frontend/address/index/$2';
$route['documents$'] = 'address/frontend/address/index';
$route['([a-zA-Z0-9/-]+)-ad([0-9]+)$'] = 'address/frontend/address/view/$2';


// Frontend Cart
$route['cart$'] = 'products/frontend/cart/view';
$route['payment$'] = 'products/frontend/cart/payment';
$route['step$'] = 'products/frontend/cart/step';


// Contacts 
$route['feedback$'] = 'contacts/frontend/contacts/view2';
$route['lien-he$'] = 'contacts/frontend/contacts/view';
$route['them-lien-he$'] = 'contacts/frontend/contacts/create';

//DAi lys
$route['dai-ly$'] = 'dailys/frontend/dailys/view';
$route['cartsale$'] = 'products/frontend/cart/cartsale';

//Tìm kiếm
// $route['tim-kiem-nang-cao'] = 'products/frontend/advancedsearch/view';

$route['tim-kiem/trang-([0-9]+)$'] = 'products/frontend/search/view/$1';
$route['tim-kiem'] = 'products/frontend/search/view';

// Routers
$route['^([a-zA-Z0-9-]+)/trang-([0-9]+)$'] = 'homepage/routers/index/$1/$2';
$route['^([a-zA-Z0-9-]+)$'] = 'homepage/routers/index/$1';


$route['translate_uri_dashes'] = FALSE;
