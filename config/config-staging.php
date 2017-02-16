<?php

return [

    //hello
    'database' => array(
        'adapter' => 'Mysql',
        'host' =>  '123.59.59.233',
        'username' => 'root',
        'password' => 'S12p_w99Q',
        'dbname' => 'phalcon_test',
    ),

//    'database' => array(
//        'adapter' => 'Mysql',
//        'host' =>  '119.254.108.200:4042',
//        'username' => 'read_user',
//        'password' => 'sdf@_df-3E',
//        'dbname' => 'phalcon',
//    ),

//    'database' => array(
//        'adapter' => 'Mysql',
//        'host' =>  '119.254.108.200:4041',
//        'username' => 'xddwrite',
//        'password' => 'fe34_3-sd',
//        'dbname' => 'phalcon',
//    ),

    'mongodb' => array(
//        'sock' =>  'mongodb://bao:12345678@123.59.59.233:8015',
        'sock' =>  'mongodb://bao:12345678@123.59.59.233:8015/tianhe',
        'dbname' => 'tianhe',
    ),


    //  mongoUser:12345678@123.59.59.233:8015/tianhe



// aliyun oss
    'aliyunoss' =>  [
        'accessKey' => 'AyagbNgOnp0Gf3lf',
        'secretKey' => 'KUb7IwLdTi9BlXzEtfsT8B8zu5jOpV',
        'endpoint' =>'http://oss-cn-beijing.aliyuncs.com',
    ],

    'redis' => array(
        'ip'        => '127.0.0.1',
        'port'      => '6379',
        'lifetime'  => 10800,
        'cookie_lifetime'  => 10800,
    ),

    'jpush_alias_prefix' => 'debug_',//hello_
];
