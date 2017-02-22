<?php
define('DEBUG', 'on');
define("WEBPATH", realpath(__DIR__ . '/../'));
require dirname(__DIR__) . '/vendor/swoole_web/lib_config.php';

//设置PID文件的存储路径
Swoole\Network\Server::setPidFile(__DIR__ . '/http_server.pid');
/**
 * 显示Usage界面
 * php app_server.php start|stop|reload
 */
Swoole\Network\Server::start(function ()
{
    $AppSvr = new Swoole\Protocol\HttpServer();
    $AppSvr->loadSetting(__DIR__.'/swoole.ini'); //加载配置文件
    $AppSvr->setDocumentRoot(__DIR__.'/../public');
    $AppSvr->setLogger(new Swoole\Log\EchoLog(true)); //Logger

    Swoole\Error::$echo_html = false;

    $server = Swoole\Network\Server::autoCreate('xdd.cn', 8088);
    $server->setProtocol($AppSvr);
    //$server->daemonize(); //作为守护进程
    $server->run(array('worker_num' => 2, 'max_request' => 5000, 'log_file' => WEBPATH.'/storage/logs/swoole_http.log'));
});