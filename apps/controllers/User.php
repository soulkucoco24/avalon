<?php
namespace App\Controller;
use Swoole;

class User extends Swoole\Controller
{
    function login()
    {
        //已经登录了，跳转到
        if ($this->user->isLogin())
        {
            $this->http->redirect('/user/home/');
            return;
        }
        if (!empty($_POST['password']))
        {
            $r = $this->user->login(trim($_POST['username']), $_POST['password']);
            if($r)
            {
                // cache 记录
                $this->http->redirect('/user/home/');
                return;
            }
            else
            {
                echo "登录失败";
            }
        }
        else
        {
            $this->display('user/login.php');
        }
    }

    //注册
    function register()
    {
        if (!empty($_POST['username'])){
            $result = $this->user->register($_POST);
            if(!$result){
                throw new \Exception('注册失败');
            }
            $this->http->redirect('/user/login');
        }else{
            $this->display('user/register.php');
        }



    }

    function home()
    {
        var_dump($_SESSION);
        Swoole\Auth::loginRequire();
        $this->showTrace();
    }

    function logout()
    {
        $this->is_ajax = true;
        $isOk = $this->user->logout();
        return ['msg'=>'已登出','err_code'=>0];
    }


    function getInfo()
    {
        $uid = $this->request->get('id','int');
    }

    function index()
    {
        echo 'index ';
    }
}