<?php
namespace App\Controller;
use Swoole;

class Rome extends Swoole\Controller
{
    function index()
    {
        return $this->display('index.tpl.php');
    }

}