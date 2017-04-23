<?php
namespace App\Controller;
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
        var_dump( get_class_vars('\Redis').'为啥不显示呢');
        echo "</pre>";
    }

    function event()
    {
        echo "event trigger\n";
        $res = $this->event->trigger("hello", array($this->redis->getIncreaseId('queue'), "hello world", __DIR__));
        echo "event trigger\n";
    }

}