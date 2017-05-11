<?php
$log['master'] = array(
    'type' => 'FileLog',
    'file' => WEBPATH . '/storage/logs/avalon.log',
);

$log['test'] = array(
    'type' => 'EchoLog',
    'file' => WEBPATH . '/logs/test.log',
);

$log['db'] = array(
    'type' => 'FileLog',
    'file' => WEBPATH . '/storage/logs/db.log',
);

return $log;