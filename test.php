<?php
set_time_limit(0);

header("Content-Type: text/html; charset=UTF-8");

/**
 * 定义程序绝对路径
 */
define('SCRIPT_ROOT',  dirname(__FILE__).'/');
require_once SCRIPT_ROOT.'include/Client.php';
//echo SCRIPT_ROOT;exit;

/**
 * 网关地址
 */
$gwUrl = 'http://sdk999ws.eucp.b2m.cn:8080/sdk/SDKService';

/**
 * 序列号,请通过亿美销售人员获取
 */
$serialNumber = '9SDK-EMY-0999-JFTUP';

/**
 * 密码,请通过亿美销售人员获取
 */
$password = '088442';

/**
 * 登录后所持有的SESSION KEY，即可通过login方法时创建
 */
$sessionKey = '088442';

/**
 * 连接超时时间，单位为秒
 */
$connectTimeOut = 5;

/**
 * 远程信息读取超时时间，单位为秒
 */
$readTimeOut = 10;

/**
$proxyhost		可选，代理服务器地址，默认为 false ,则不使用代理服务器
$proxyport		可选，代理服务器端口，默认为 false
$proxyusername	可选，代理服务器用户名，默认为 false
$proxypassword	可选，代理服务器密码，默认为 false
 */
$proxyhost = false;
$proxyport = false;
$proxyusername = false;
$proxypassword = false;

$client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
/**
 * 发送向服务端的编码，如果本页面的编码为GBK，请使用GBK
 */
$client->setOutgoingEncoding("UTF-8");

//sendSMS();         //发送短信

sendVoice();        //发送短信验证码

//getReport();

/**
 * 短信发送 用例
 */
function sendSMS()
{
    global $client;
    /**
     * 下面的代码将发送内容为 test 给 159xxxxxxxx 和 159xxxxxxxx
     * $client->sendSMS还有更多可用参数，请参考 Client.php
     */
    $statusCode = $client->sendSMS(array('18616396309'), '房品汇短信发送', '', '', 'UTF-8');
    echo "处理状态码:".$statusCode;
}

/**
 * 发送语音验证码 用例
 */
function sendVoice()
{
    global $client;
    /**
     * 下面的代码将发送验证码123456给 159xxxxxxxx
     * $client->sendSMS还有更多可用参数，请参考 Client.php
     */
    $statusCode = $client->sendVoice(array('18616396309'),"7xg5kw");
    echo "处理状态码:".$statusCode;
}

/**
 * 接收状态报告 用例
 */
function getReport()
{
    global $client;
    $reportResult = $client->getReport();
    echo "返回数量:".count($reportResult);
    foreach($reportResult as $report)
    {
        //$report 是位于 Client.php 里的 report 对象
        // 实例代码为直接输出
        echo "errorCode:".$report->getErrorCode();
        echo "状态报告值:".$report->getReportStatus();
        echo "通道号:".$report->getServiceCodeAdd();
        echo "手机号:".$report->getMobile();
        echo "发送时间:".$report->getSubmitDate();
        echo "接收时间:".$report->getReceiveDate();
        echo "短信ID:".$report->getSeqID();


        // 状态报告务必要保存,加入业务逻辑代码,如：保存数据库，写文件等等
    }

}
?>
