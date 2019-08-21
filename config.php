<?php
header('Content-Type: text/html; charset=utf-8');

date_default_timezone_set('Asia/Ho_Chi_Minh');
define('BACKEND_DIRECTORY', 'admin');
define('BASE_URL', 'http://vando.local/');
// define('CODE', md5(BASE_URL));
define('CODE', 'fc_');
define('FC_ENCRYPTION', '_'.sprintf("%u", crc32(BASE_URL)));
define('FCSEO', 0);
define('FCCOMPRESS', 0);
define('FCSUFFIX', '.html');

define('FC_UPLOAD', '/uploads/images/');
define('FCDBHOST', 'localhost');
define('FCDBUSER', 'root');
define('FCDBPASS', '');
define('FCDBNAME', 'vando');
//echo md5('thietkewebchuanseo'.BASE_URL.md5('mycms.vn-tamphat.edu.vn-0904720388'));die;
