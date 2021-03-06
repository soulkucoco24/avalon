<?php
namespace Swoole;
use Library\Helper\RedisRoom;

/**
 * 所有Swoole应用类的基类
 * Class Ojbect
 *
 * @package Swoole
 * @property Database            $db
 * @property Client\CoMySQL      $codb
 * @property IFace\Cache         $cache
 * @property Upload              $upload
 * @property Component\Event     $event
 * @property Session             $session
 * @property Template            $tpl
 * @property \Redis              $redis
 * @property \MongoClient        $mongo
 * @property Config              $config
 * @property Http\PWS            $http
 * @property Log                 $log
 * @property Log                 $dblog
 * @property Auth                $user
 * @property URL                 $url
 * @property Limit               $limit
 * @property Request             $request
 * @property Response            $response
 *
 * @method Database              db
 * @method \MongoClient          mongo
 * @method \redis                redis
 * @method IFace\Cache           cache
 * @method URL                   url
 * @method Client\CoMySQL        codb
 * @method Platform\Linux os
 */
class Object
{
    /**
     * @var \Swoole
     */
    public $swoole;

    /**
     * @var \Library\Helper\RedisRoom
     */
    public $redisRoom;

    function __construct()
    {
        $this->redisRoom = RedisRoom::self();
    }

    function __get($key)
    {
        return $this->swoole->$key;
    }

    function __call($func, $param)
    {
        return call_user_func_array([$this->swoole, $func], $param);
    }
}