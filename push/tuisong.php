<?php
header("Content-Type: text/html; charset=UTF-8");
$info = $_POST['moXml'];

$xml = html_entity_decode($info);
$xmlParse = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
print_r($xmlParse);
foreach($xmlParse as $key => $val) {
    $tmp = (array) $val;
    echo $cellphone = $tmp['mobile'].'<br>';
    echo $content = $tmp['smsContent'].'<br>';
    echo $sendTime = $tmp['sendTime'].'<br>';
    echo '<br><br><br>';

}
