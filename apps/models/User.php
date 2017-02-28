<?php
namespace App\Model;
use Swoole;

class User extends Swoole\Model
{
    /**
     * 表名
     * @var string
     */
    public $table = 'users';

    function findFrist($id)
    {
        return ['name'=>'test'];
    }
    
}