<?php
namespace App\Observer;

/**
 * db执行sql的时候记录sql到dblog中
 * Class DbExecute
 * @package App\Observer
 */
class DbExecute implements \SplObserver
{

    # 观察者:dblog
    function update(\SplSubject $o)
    {
        $sql = $o->getSql();
        $params = $o->getSqlParam();

        #
        $noLogUrl = [];
        if( isset($_GET['_url']) && in_array($_GET['_url'],$noLogUrl)) {
            return;
        }else {
            foreach($params as $key => $value)
            {
                if( preg_match('/(\:'.$key.')/',$sql))
                    $sql = str_replace(":".$key,$value, $sql);
                else
                    $sql = str_replace("?",$value,$sql);
            }

            # 过滤 ` 号
            $sql = str_replace('`','',$sql);

            \Swoole::$php->dblog->info('执行SQL: '.$sql);
        }
    }

}