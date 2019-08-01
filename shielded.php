<?php
/**
 *
 * test.php(屏蔽地方IP)
 *
 * @package      	.....
 * @author          ....
 * @copyright     	Copyright (c) 2008-2013  (http://www..com)
 * @license         .....
 * @version        	ICP 4444$
 */
header("Content-type: text/html; charset=utf-8");
$verification = '广东省';//需要屏蔽省份的IP
$ip = $_SERVER['REMOTE_ADDR'];//获取访客IP
$antecedents = $_SERVER['HTTP_REFERER'];//访客来路地址
$result = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);//IP数据库来自淘宝。
$address = json_decode($result,true);
//判断访客是否属于广东省，是否来自百度，是否来自谷歌
if($address['data']['region'] == $verification && strpos($antecedents, 'baidu') === false && strpos($antecedents, 'google') === false){
		sleep(86400);//设置一个999999秒。看他们有没有这么好耐心。
		Header("HTTP/1.1 204 No Content");
		exit;
}