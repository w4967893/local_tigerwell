<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome';
$route['404_override'] = '';//404页面
$route['translate_uri_dashes'] = FALSE;
$route['auth/login'] = 'Home/LoginController/login';//登录
$route['auth/logout'] = 'Home/LoginController/logout';//退出登录
$route['auth/register'] = 'Home/RegisteredController/register';//注册

$route['customer/apply'] = 'Home/ApplyController/apply';//申请试用
$route['customer/userChange'] = 'Home/ChangeMoneyController/userChange';//获取用户资金变动记录
$route['goods/list'] = 'Home/GoodsController/gList';//获取商品列表
$route['order/buy'] = 'Home/OrderController/buy';//购买生成订单

$route['alipay/index'] = 'Home/PayController/alipay';//支付宝
$route['alipay/synchronous'] = 'Home/PayController/synchronous';//支付宝同步回调
$route['alipay/synchronous'] = 'Home/PayController/synchronous';//支付宝异步回调


//后端api
$route['admin/login'] = 'admin/LoginController/index';//登录

$route['admin/auth/login'] = 'admin/LoginController/login';//登录
$route['admin/auth/logout'] = 'admin/LoginController/logout';//退出登录

$route['admin/order/list'] = 'admin/OrderController/oList';//获取订单列表

$route['admin/customer/info'] = 'admin/CustomerController/info';//获取客户列表
$route['admin/customer/resetPassword'] = 'admin/CustomerController/resetPassword';//重置密码


