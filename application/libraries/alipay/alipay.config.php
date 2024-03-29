<?php
/* *
 * 配置文件
 * 版本：3.4
 * 修改日期：2016-03-08
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，登陆https://globalprod.alipay.com/order/myOrder.htm, see partner id
//$alipay_config['partner']		= '2088101122136241';//测试id
$alipay_config['partner']		= '2088721091337030';

// MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://globalprod.alipay.com/order/myOrder.htm, see key
//$alipay_config['key']			= '760bdzec6y9goq7ctyx96ezkz78287de';//测试key
$alipay_config['key']			= 'fsopv74o90j4kirbntwexe0cwpvrt80n';

// 服务器异步通知页面路径  需http(s)://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['notify_url'] = "http://商户网址/create_forex_trade-PHP-UTF-8/notify_url.php";

// 页面跳转同步通知页面路径 需http(s)://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['return_url'] = "http://www.alipay.com";

//签名方式
$alipay_config['sign_type']    = strtoupper('MD5');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验,在verify_nofity中使用
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'https';
		
// 产品类型，无需修改
$alipay_config['service'] = "create_forex_trade";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>