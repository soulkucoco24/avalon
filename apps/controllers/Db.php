<?php
namespace App\Controller;
use Swoole;

class Db extends Swoole\Controller
{
    function apt_test()
    {
        $apt = new Swoole\SelectDB($this->db);
        $apt->from('users');
        $apt->equal('id', 1);
        $res = $apt->getall();
        var_dump($res);
    }

    function obtest()
    {
        try{
            //        $res = $this->db->fetchAll("SELECT * FROM user WHERE nick_name LIKE ?",['%波%']);
//        $res = $this->db->fetchOne("SELECT * FROM user WHERE nick_name LIKE ?",['%波%']);
            $res = $this->db->insert(['account'=>'www1','real_name'=>'测试是','nick_name'=>'禅语','pwd'=>'3'],'user');
            echo "</br>";
            var_dump($res);
            return \Swoole\Error::info('sdfsdfsdf','sdfsdf');
        }catch (\Exception $e) {
            var_dump($e->getMessage());
        }

    }

    function tables()
    {
        /**
         * master database
         */
        $tables = $this->db->query("show tables")->fetchall();
        var_dump($tables);

        /**
         * other
         */
        $tables = $this->db("huya")->query("show tables")->fetchall();
        var_dump($tables);
    }

    function put()
    {
        $model = Model('User');
        $id = $model->put(['name' => 'swoole', 'level' => 5, 'mobile' => '19999990000']);
        echo "insert id = $id\n";
    }

    function get()
    {
        $model = Model('User');
        $user = $model->get(1);

        # 增加观察者
        $user->attach(new \App\Observer\DbExecute());

        /**
         * 修改mobile 为 13800008888
         */
        $user->mobile = '18948735886';
        $user->save();

        //删除此条记录
        //$user->delete();
    }

    function gets()
    {
        /**
         * @var $model \App\Model\User
         */
        $model = Model('User');
        //level = 5
//        $gets['id'] = $_GET['s'];
        $gets['where'][]  = 'id > '.$_GET['s'].'';
        //$gets['where'][] = array('id', '>', $_GET['s']);
        //仅获取数据
        var_dump($model->gets($gets));
        echo ($this->db->getSql());

        //分页
        $gets['page'] = empty($_GET['page'])?1:intval($_GET['page']);
        $gets['pagesize'] = 5;
        $pager = null;
        $list = $model->gets($gets, $pager);

        foreach($list as $li)
        {
            echo "{$li['id']}: {$li['name']}<br/>\n";
        }
        //上一页/下一页
        echo $pager->render();
    }

    function codb()
    {
        $ret1 = $this->codb->query("show tables");
        $ret2 = $this->codb->query("desc user_login");

        $this->codb->wait(1.0);

        var_dump($ret1->result->fetchall());
        var_dump($ret2->result->fetchall());
    }
}