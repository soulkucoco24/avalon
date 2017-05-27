<?php
namespace App\Controller;
use Swoole;

class User extends Swoole\Controller
{
    function login()
    {
        //已经登录了，跳转到
        if( $this->user->isLogin()) {
            $this->http->redirect('/user/home/');
            return;
        }

        if( $this->request->has('password') && $this->request->has('username'))
        {
            $isOk = $this->user->login(trim($_POST['username']), $_POST['password']);
            if($isOk) {
                // cache 记录
                $refer = $this->request->get('refer');

                empty($refer) && $refer='/user/home';

                $this->http->redirect($refer);
                return;
            }else
                echo "登录失败";

        }
        else
        {
            $this->display('user/login.tpl');
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
        Swoole\Auth::loginRequire();

        // var_dump($this->user->getUserInfo());
        // $this->showTrace();
        $this->assign('user',$this->user->getUserInfo())->display('user/personal.tpl');
    }

    function logout()
    {
//        $this->is_ajax = true;
        echo '已登出';
        $isOk = $this->user->logout();
        return $this->http->redirect('/');
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