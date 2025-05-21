<?php
const ATTR = [
    0 => 'Size',
    1 => 'Topping',
    2 => 'Mức đá',
    3 => 'Mức đường'
];
const PROMOTION_TYPE = [
    'PERCENT' => 'Giảm %',
    'ORDER' => 'Giảm tiền',
    'PRODUCT' => 'Tặng sản phẩm'
];
const PRODUCT_GIFT = [
    'SAME' => 'Sản phẩm cùng loại',
    'LIST' => 'Sản phẩm trong danh sách',
    'ANY' => 'Sn phẩm tự chọn'
];
const PAYMENT_METHOD = [
    1 => 'Tiền mặt',
    2 => 'Chuyển khoản',
    3 => 'Credit Card',
    99 => 'N/A'
];
const DRINK = [
    'TẠI TIỆM',
    'MANG ĐI',
    'SHIP'
];
date_default_timezone_set("Asia/Ho_Chi_Minh");
$dev_data = array('id'=>'-1','firstname'=>'Developer','lastname'=>'','username'=>'taptatpaptatp','password'=>'5da283a2d990e8d8512cf967df5bc0d0','last_login'=>'','date_updated'=>'','date_added'=>'');
if(!defined('base_url')) define('base_url','https://skun.store/');
if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
// if(!defined('dev_data')) define('dev_data',$dev_data);
if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
if(!defined('DB_USERNAME')) define('DB_USERNAME',"skun_admin");
if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"OHlOIGlFIF%yvrC^");
if(!defined('DB_NAME')) define('DB_NAME',"skun_store");
?>
