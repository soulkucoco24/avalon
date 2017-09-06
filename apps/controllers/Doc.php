<?php
namespace App\Controller;
use Library\Helper\RedisRoom;
use Swoole;

class Doc extends Swoole\Controller
{
    function __beforeAction()
    {
        // echo __METHOD__."\n";
    }

    function __afterAction()
    {
        // echo __METHOD__."\n";
    }

    function ajax()
    {
        $this->is_ajax = true;
        return ['data'=>'bo'];
    }



    function redis()
    {
        $keys = $this->redis->keys('*');
        $ss = new \Redis();

        echo "php-redis \n";
        echo "<pre> 函数:";
        var_dump($keys);
        print_r(get_class_methods($ss));
        echo "</pre>";
        echo "<pre> 变量:";
        var_dump( get_class_vars('\Redis'));
        echo "</pre>";
    }

    function redis1()
    {
        $res = $this->db->fetchAll("SELECT * from room");
        foreach($res as $v) {
            $isOk = $this->redis->hMset('room:'.$v['id'], $v);
//            var_dump($isOk);
        }

        $v = $this->redis->hGetAll('room:1');
//        var_dump($v);

//        $ss = RedisRoom::getInstance();
var_dump($this->redisRoom->roomInfo(1));
    }


    # 危险的接口 目前测试期才会用啊
    function object() {
        if( $this->request->get('pass') != 'sb')
            return ;

        $p = $this->request->get('p');
        if( strstr($p,'del') !== false) {
            $this->log($p.'!!!!!!!!');
            return ;
        }
        if( strstr($p,'exec') !== false) {
            $this->log($p.'!!!!!!!!');
            return ;
        }
        if( strstr($p,'query') !== false) {
            $this->log($p.'!!!!!!!!');
            return;
        }
        if( strstr($p,'exit') !== false) {
            $this->log($p.'!!!!!!!!');
            return;
        }

        eval('var_dump($this->'.$p.');');
    }

    function event()
    {
        echo "event trigger\n";
        $res = $this->event->trigger("hello", [$this->redis->getIncreaseId('queue'), "hello world", __DIR__]);
        echo "event trigger\n";
    }

    function log()
    {
        $this->dblog->info('sdfdsgdfg');
        $this->log->info('sdfdsg111dfg');

    }

    function ss() {
        return $this->assign('data','ShadowSocks还没弄......')->display('/static.tpl');
    }

    function gamerule() {
        return $this->assign('data','STATIC_RULE_AVALON')->display('/static.tpl');
    }

}