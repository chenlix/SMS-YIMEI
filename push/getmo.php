﻿<?php
define('NO_AUTH', 1);
//require $_SERVER['PHP_ROOT'] . 'init.inc.php';
if($_POST) {
    error_log(var_export($_POST,true));
}
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "当前使用的请求方式是GET\n<br>";
    echo "参数列表:" . var_export($_GET, true), "\n";
} else  {
    echo "当前使用的请求方式是POST\n<br>";
    echo "参数列表:" . var_export($_REQUEST, true), "\n";
}
$info = '<?xml version="1.0" encoding="UTF-8"?>
    <moList>
        <mo>
            <id>2011102109570100002</id>
            <mobile>13426113191</mobile>
            <smsContent><![CDATA[上行行测试]]></smsContent>
            <addSerial>01</addSerial>
            <channelNumber>10086</channelNumber>
            <sendTime>20110101232323</sendTime>
        </mo>
        <mo>
            <id>2011102109570100002</id>
            <mobile>13426113191</mobile>
            <smsContent><![CDATA[上行测试55]]></smsContent>
            <addSerial>01</addSerial>
            <channelNumber>10086</channelNumber>
            <sendTime>20110101232323</sendTime>
        </mo>
    </moList>';
$info = $_POST['moXml'] ? : '';

error_log($info, '3', '/tmp/getmo.log');
if(empty($info)) {
    error_log('################### empty data #########################');
    exit;
}
$xml = html_entity_decode($info);
$xmlParse = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
$smsup = new Smsup();
$msg = '感谢您的短信，此条信息为机器人回复。如有订车需求或其他需要，请详询客服4001111777或登录www.yongche.com。';
$emay = Emay::getInstance();
foreach($xmlParse as $key => $val) {
    $tmp = (array) $val;
    $cellphone = $tmp['mobile'];
    $content = $tmp['smsContent'];
    $sendTime = $tmp['sendTime'];
    $v = array('cellphone'=>$cellphone, 'content'=>$content, 'callback_time'=>strtotime($sendTime));
    $smsId = $smsup->insert($v);
    if($smsId) {
        $emay->sendSMS($cellphone,$msg);
    }
}

exit;
