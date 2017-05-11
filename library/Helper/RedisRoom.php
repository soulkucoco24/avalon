<?php

namespace Library\Helper;

//use Library\Helper\TreeHelper;
use Swoole\Object;

/**
 * 关于游戏房间的redis操作类
 * auth: haibo && shuai
 * Class RedisRoom
 * @package Library\Helper
 */
class RedisRoom
{
    CONST USR_COLUMN = 'id,avatarpicurl,contactName,contactNumber,enterpriseid,mobile,real_name,telephone_number,usertype,invite_userid,avatarpicurl,enterprise_licence,unverify_enterprisename,join_company_time';

    //  --------------      cache  key  的定义  ---------
    CONST PREFIX = "room:";  // user 信息


    CONST ET = 3600;  // userLogin cache 时效


    /**
     * @var RedisRoom
     */
    static private $p;

    /**
     * @var \Redis
     */
    public $redis;

    private function __construct()
    {
    }

    static function self()
    {
        if( !self::$p) {
            self::$p = new RedisRoom;
            self::$p->redis = \Swoole::$php->redis;  //这里的赋值很奇怪。。。
        }

        return self::$p;
    }


    /**
     * DATA Struct:
     * {
     *  'info' => $user_model,
     *  'info_flush' => false,
     *
     *  'role_ids' => [],
     *  'role_flush' => false,
     *
     *  'menu' => [],
     *  'token' => '',
     *  'invalidToken' => [],
     *  'et' => ''
     * }
     *
     */


    /**
     * 功能: 获取房间信息
     * @param $num
     * @return array
     */
    function roomInfo($num)
    {
        $info = $this->redis->hGetAll(self::PREFIX.$num);
        return $info;
    }

    function alterRoomInfo($num, $info)
    {

    }



}