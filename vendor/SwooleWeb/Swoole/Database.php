<?php
namespace Swoole;
/**
 * 数据库基类
 * @author Tianfeng.Han
 * @package SwooleSystem
 * @subpackage database
 */
use Swoole\Component\Observer;

/**
 * Database Driver接口
 * 数据库驱动类的接口
 * @author Tianfeng.Han
 *
 */
interface IDatabase
{
	function query($sql);
	function connect();
	function close();
	function lastInsertId();
    function getAffectedRows();
    function errno();
    function quote($str);
}
/**
 * Database Driver接口
 * 数据库结果集的接口，提供2种接口
 * fetch 获取单条数据
 * fetch 获取全部数据到数组
 * @author Tianfeng.Han
 */
interface IDbRecord
{
	function fetch();
	function fetchall();
}

/**
 * Database类，处理数据库连接和基本的SQL组合
 * 提供4种接口，query  insert update delete
 * @method connect
 * @method close
 * @method quote $str
 * @method errno
 */
class Database extends Observer
{
	public $debug = false;
	public $read_times = 0;
	public $write_times = 0;

    /**
     * @var IDatabase
     */
	public $_db = null;
    /**
     * @var \Swoole\SelectDB
     */
    public $db_apt = null;

    protected $lastSql = '';
    protected $lastSqlParam = [];

	const TYPE_MYSQL   = 1;
	const TYPE_MYSQLi  = 2;
	const TYPE_PDO     = 3;
    const TYPE_CLMysql = 4;

    function __construct($db_config)
    {
        switch ($db_config['type'])
        {
            case self::TYPE_MYSQL:
                $this->_db = new Database\MySQL($db_config);
                break;
            case self::TYPE_MYSQLi:
                $this->_db = new Database\MySQLi($db_config);
                break;
            case self::TYPE_CLMysql:
                $this->_db = new Database\CLMySQL($db_config);
                break;
            default:
                $this->_db = new Database\PdoDB($db_config);
                break;
        }
        $this->db_apt = new SelectDB($this);
    }

    /**
     * 初始化参数
     */
    function __init()
    {
        $this->check_status();
        $this->db_apt->init();
        $this->read_times = 0;
        $this->write_times = 0;
    }

    /**
     * 检查连接状态，如果连接断开，则重新连接
     */
    function check_status()
    {
        if (!$this->_db->ping())
        {
            $this->_db->close();
            $this->_db->connect();
        }
    }

    /**
     * 启动事务处理
     * @return bool
     */
    function start()
    {
        if ($this->query('set autocommit = 0') === false)
        {
            return false;
        }
        return $this->query('START TRANSACTION');
    }

	/**
	 * 提交事务处理
	 * @return bool
	 */
	function commit()
	{
        if ($this->query('COMMIT') === false)
        {
            return false;
        }
        $this->query('set autocommit = 1');
        return true;
	}

	/**
	 * 事务回滚
	 * @return bool
	 */
	function rollback()
	{
        if ($this->query('ROLLBACK') === false)
        {
            return false;
        }
        $this->query('set autocommit = 1');
		return true;
	}

    /**
     * 执行一条SQL语句
     * @param $sql
     * @return \Swoole\Database\MySQLiRecord
     */
    public function query($sql)
    {
        if ($this->debug)
        {
            echo "$sql<br />\n<hr />";
        }
        $this->read_times += 1;

        $ret = $this->_db->query($sql);
        $this->updateLastSql($sql);

        return $ret;
    }

    /**
     * 执行一条SQL语句
     * @param $sql
     * @return \Swoole\Database\MySQLiRecord
     */
    public function fetchAll($sql,$param=[],$type=2)
    {
        if ($this->debug)
        {
            echo "$sql<br />\n<hr />";
            echo json_encode($param);
        }
        $this->read_times += 1;


        $ret = &$this->_db->queryAll($sql,$param,$type);
        $this->updateLastSql($sql, $param);

        return $ret;
    }

    /**
     * 执行一条SQL语句
     * @param $sql
     * @return \Swoole\Database\MySQLiRecord
     */
    public function fetchOne($sql,$param=[],$type=2)
    {
        if ($this->debug)
        {
            echo "$sql<br />\n<hr />";
            echo json_encode($param);
        }
        $this->read_times += 1;

        $result = $this->_db->queryLine($sql,$param,$type);
        $this->updateLastSql($sql, $param);

        return empty($result)?false:$result;
    }

	/**
	 * 插入$data数据库的表$table，$data必须是键值对应的，$key是数据库的字段，$value是对应的值
	 * @param $data
	 * @param $table
	 * @return int
	 */
    public function insert($data, $table)
    {
        $this->db_apt->init();
        $this->db_apt->from($table);
        $this->write_times += 1;

        return $this->db_apt->insert($data);
    }

    /**
	 * 从$table删除一条$where为$id的记录
	 * @param $id
	 * @param $table
	 * @param $where
	 * @return \mysqli_result
	 */
    public function delete($id, $table, $where = 'id')
    {
        if (func_num_args() < 2)
        {
            Error::info('SelectDB param error', 'Delete must have 2 paramers ($id,$table) !');
        }
        $this->db_apt->init();
        $this->db_apt->from($table);
        $this->write_times += 1;

        $ret = $this->query("delete from $table where $where='$id'");
        $this->updateLastSql("delete from $table where $where='$id'");

        return $ret;
    }

    /**
     * 执行数据库更新操作，参数为主键ID，值$data，必须是键值对应的
     * @param int $id 主键ID
     * @param array $data 数据
     * @param string $table 表名
     * @param string $where 其他字段
     * @return int $n     SQL语句的返回值
     */
    public function update($id, $data, $table, $where = 'id')
    {
        if (func_num_args() < 3)
        {
            echo Error::info('SelectDB param error', 'Update must have 3 paramers ($id,$data,$table) !');
            return false;
        }
        $this->db_apt->init();
        $this->db_apt->from($table);
        $this->db_apt->where("$where='$id'");
        $this->write_times += 1;

        $ret =  $this->db_apt->update($data);
        $this->updateLastSql("更新$table: id:$id".var_export($data,true));

        return $ret;
    }

	/**
	 * 根据主键获取单条数据
	 * @param $id
	 * @param $table
	 * @param $primary
	 * @return array
	 */
    public function get($id, $table, $primary = 'id')
    {
        $this->db_apt->init();
        $this->db_apt->from($table);
        $this->db_apt->where("$primary='$id'");

        $ret = $this->db_apt->getone();
        $this->updateLastSql("get $table id:$id");

        return $ret;
    }

    /**
     * 获取最近一次执行的SQL语句
     * @return string
     */
    function getSql(){
        return $this->lastSql;
    }

    function getSqlParam(){
        return $this->lastSqlParam;
    }

    private function updateLastSql($sql, $param=[]) {
        $this->lastSql = $sql;
        $this->lastSqlParam = $param;
        $this->notify();
    }

    /**
     * 调用$driver的自带方法
     * @param $method
     * @param array $args
     * @return mixed
     */
    function __call($method, $args = [])
    {
//        $this->db_log
        return call_user_func_array([$this->_db, $method], $args);
    }
}
