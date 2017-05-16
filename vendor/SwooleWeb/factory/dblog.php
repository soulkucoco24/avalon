<?php
global $php;
$config = $php->config['log'];
if (empty($config['db']))
{
    throw new Swoole\Exception\Factory("log->db is not found.");
}
$conf = $config['db'];
if (empty($conf['type']))
{
    $conf['type'] = 'EchoLog';
}
$class = 'Swoole\\Log\\' . $conf['type'];
$log = new $class($conf);
if (!empty($conf['level']))
{
    $log->setLevel($conf['level']);
}
return $log;