<?php
namespace Swoole\Exception;

/**
 * 模块不存在
 * Class NotFound
 * @package Swoole
 */
class NotFound extends \Exception
{

    // 自定义字符串输出的样式
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
