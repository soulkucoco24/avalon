<?php
namespace App\Controller;
use Swoole;

class Room extends Swoole\Controller
{
	function __construct($swoole)
    {
        parent::__construct($swoole);
        Swoole::$php->session->start();
        Swoole\Auth::loginRequire();
    }

    function index()
    {
        return $this->assign('data',['room_id'=>1,'game_type'=>'langren'])->display('room/main.tpl');
    }

}