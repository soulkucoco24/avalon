<?php
namespace Swoole\Database;
use Swoole;

/**
 * PDO数据库封装类
 * @package SwooleExtend
 * @author Tianfeng.Han
 *
 */
class PdoDB extends \PDO implements Swoole\IDatabase
{
	public $debug = false;
    protected $config;

    /**
     * @var \PDOStatement
     */
    protected $lastStatement;

	function __construct($db_config)
	{
        $this->config = $db_config;
	}

    /**
     * 连接到数据库
     */
    function connect()
    {
        $db_config = &$this->config;
        $dsn = $db_config['dbms'] . ":host=" . $db_config['host'] . ";dbname=" . $db_config['name'];

        if (!empty($db_config['persistent']))
        {
            parent::__construct($dsn, $db_config['user'], $db_config['passwd'], array(\PDO::ATTR_PERSISTENT => true));
        }
        else
        {
            parent::__construct($dsn, $db_config['user'], $db_config['passwd']);
        }
        if ($db_config['setname'])
        {
            parent::query('set names ' . $db_config['charset']);
        }
        $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

	/**
	 * 执行一个SQL语句
	 * @param string $sql 执行的SQL语句
     * @return \PDOStatement
     */
    public final function query($sql,$type=1,$params=[])
    {
        if($type == 2){
            return $this->queryLine($sql,$params);
        }
        if ($this->debug)
        {
            echo "$sql<br />\n<hr />";
        }
        $res = parent::query($sql) or \Swoole\Error::info(
            "SQL Error",
            implode(", ", $this->errorInfo()) . "<hr />$sql"
        );
        $this->lastStatement = $res;
        //非查询语句直接返回结果
        if ($sql[0] !== 's')
        {
            return !empty($res);
        }
        return $res;
    }

    /**
     * 执行一个参数化SQL语句,并返回一行结果
     * @param string $sql 执行的SQL语句
     * @param  mixed $_     [optional]
     * @return mixed
     */
    public final function queryLine($sql, $_,$type=2)
    {
        $params = func_get_args();
        if ($this->debug)
        {
            var_dump($params);
        }
        array_shift($params);
        $stm = $this->prepare($sql);
        if ($stm->execute($params[0]))
        {
            if($type == 1){
                $ret = $stm->fetch(\PDO::FETCH_OBJ);
            }else{
                $ret = $stm->fetch();
            }

            $stm->closeCursor();
            return $ret;
        }
        else
        {
            \Swoole\Error::info("SQL Error", implode(", ", $this->errorInfo()) . "<hr />$sql");
            return false;
        }
    }

    /**
     * 执行一个参数化SQL语句,并返回所有结果
     * @param string $sql 执行的SQL语句
     * @param  mixed $_     [optional]
     * @return mixed
     */
    public final function &queryAll($sql, $_,$type=2)
    {
        $params = func_get_args();
        if ($this->debug)
        {
            var_dump($params);
        }
        array_shift($params);
        $stm = $this->prepare($sql);
        if ($stm->execute($params[0]))
        {
            if($type == 1){
                $ret = $stm->fetchAll(\PDO::FETCH_OBJ);
            }else{
                $ret = $stm->fetchAll();
            }
            $stm->closeCursor();
            return $ret;
        }
        else
        {
            \Swoole\Error::info("SQL Error", implode(", ", $this->errorInfo()) . "<hr />$sql");
            return false;
        }
    }

    /**
     * 执行一个参数化SQL语句
     * @param string $sql 执行的SQL语句
     * @param  mixed $_     [optional]
     * @return int          last insert id
     */
    public final function execute($sql, $_)
    {
        $params = func_get_args();
        if ($this->debug)
        {
            var_dump($params);
        }
        array_shift($params);
        $stm = $this->prepare($sql);
        if ($stm->execute($params))
        {
            return $this->lastInsertId();
        }
        else
        {
            \Swoole\Error::info("SQL Error", implode(", ", $this->errorInfo()) . "<hr />$sql");
            return false;
        }
    }

    /**
     * 获取错误码
     */
    function errno()
    {
        $this->errorCode();
    }

    /**
     * 获取受影响的行数
     * @return int
     */
    function getAffectedRows()
    {
        return $this->lastStatement ? $this->lastStatement->rowCount() : false;
    }

    function __destruct() {}
    /**
	 * 关闭连接，释放资源
	 * @return null
	 */
	function close()
	{
$this->__destruct();
//		unset($this);
	}

    function quote($str, $paramtype = NULL /*暂时没用 为了不报错*/)
    {
        $safeStr = parent::quote($str);
        return substr($safeStr, 1, strlen($safeStr) - 2);
    }
}
