<?php
class Server
{
    private $serv;
    public $timer_count = 0;

    public function __construct() {
        $this->serv = new swoole_server("127.0.0.1", 9501);
        $this->serv->set([
            'worker_num' => 8,
            'task_worker_num' => 2,
            'daemonize' => false,

            'log_file' => './swoole_server1.log',

            'heartbeat_check_interval' => 30,   // 每30s检测一次
            'heartbeat_idle_time' => 60, //60s未传数据则断开
        ]);

        $this->serv->on('Start', array($this, 'onStart'));
        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Close', array($this, 'onClose'));

        $this->serv->on('task', [$this,'onTask']);
        $this->serv->on('finish', [$this,'onFinish']);

        try {
            $this->serv->start();
        } catch (Exception $e) {
            echo $e->getMessage();exit;
        }
        
    }

    public function onStart( $serv ) {
        echo "Start\n";
    }

    public function onConnect( $serv, $fd, $from_id ) {
        $serv->send( $fd, "Hello {$fd}!" );
    }

    public function onReceive( swoole_server $serv, $fd, $from_id, $data ) {
        switch ($data) {
            case 'timer':
                $str = "Say ";
                $time_id = swoole_timer_tick(2000, [$this,'onTimer']);
                echo " timer: time_id-$time_id\n";
                break;
            case 'task':
                
                $serv->task($data , -1); 
                break;
            case 'db':
                break;
            case 'redis':
                break;

            case 'byebye':
                $serv->close($fd);
                break;
            default:
                echo "new msg from client[$fd] : $data\n";
                break;
        }

        $serv->send($fd, $data);
    }

    public function onClose( $serv, $fd, $from_id ) {
        echo "Client {$fd} close connection\n";
    }

    public function onTimer($timer_id) {
        echo "tick-2000ms $this->timer_count\n";
        $this->timer_count++;
    }

    public function onTask(swoole_server $serv, $task_id, $from_id, $data) {
        echo "task start with data $data \n";
        sleep(3);
        echo "task end\n";
        return 1;
    }

    public function onFinish(swoole_server $serv, $task_id, $data) {
        echo "task on finish \n";
        return 1;
    }

}

// 启动服务器
$server = new Server();