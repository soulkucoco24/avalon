<?php
$log['master'] = array(
    'type' => 'FileLog',
    'file' => WEBPATH . '/storage/logs/avalon.log',
    'dir_prefix' => WEBPATH . '/storage/logs/log_',
    'enable_cache' => false,
    'date' => true,
);

$log['test'] = array(
    'type' => 'EchoLog',
    'file' => WEBPATH . '/logs/test.log',
);

$log['db'] = array(
    'type' => 'FileLog',
    'file' => WEBPATH . '/storage/logs/db.log',
    'dir_prefix' => WEBPATH . '/storage/logs/db_',
    'enable_cache' => false,
    'date' => true,
);

return $log;