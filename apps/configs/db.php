<?php
$db['master'] = array(
    'type'       => Swoole\Database::TYPE_PDO,
    'host'       => "127.0.0.1",
    'port'       => 3306,
    'dbms'       => 'mysql',
    'engine'     => 'InnoDB',
    'user'       => "root",
    'passwd'     => "linow57132855",
    'name'       => "avalon",
    'charset'    => "utf8",
    'setname'    => true,
    'persistent' => false, //MySQL长连接
    'use_proxy'  => false,  //启动读写分离Proxy
    // 'slaves'     => array(
    //     array('host' => '127.0.0.1', 'port' => '3307', 'weight' => 100,),
    //     array('host' => '127.0.0.1', 'port' => '3308', 'weight' => 99,),
    //     array('host' => '127.0.0.1', 'port' => '3309', 'weight' => 98,),
    // ),
);

# 从数据库
$db['slave'] = array(
    'type'       => Swoole\Database::TYPE_PDO,
    'host'       => "127.0.0.1",
    'port'       => 3306,
    'dbms'       => 'mysql',
    'engine'     => 'InnoDB',
    'user'       => "root",
    'passwd'     => "linow57132855",
    'name'       => "live",
    'charset'    => "utf8",
    'setname'    => true,
    'persistent' => false, //MySQL长连接
);

return $db;