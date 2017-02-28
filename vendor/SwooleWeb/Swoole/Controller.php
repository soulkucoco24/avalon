<?php
namespace Swoole;
/**
 * Controller的基类，控制器基类
 */
class Controller extends Object
{
    public $is_ajax = false;

    /**
     * 是否对GET/POST/REQUEST/COOKIE参数进行转意
     * @var bool
     */
    public $if_filter = true;

    protected $tpl_var = array();
    protected $template_dir;
    protected $traceInfo = array();
    protected $model;
    protected $config;

    function __construct(\Swoole $swoole)
    {
        $this->swoole = $swoole;
        $this->model = $swoole->model;
        $this->config = $swoole->config;
        $this->template_dir = \Swoole::$app_path . '/templates/';
        if (!defined('TPL_PATH'))
        {
            define('TPL_PATH', $this->template_dir);
        }
        if ($this->if_filter)
        {
            Filter::request();
        }
        $swoole->__init();
    }

    /**
     * 跟踪信息
     * @param $title
     * @param $value
     */
    protected function trace($title, $value = '')
    {
        if (is_array($title))
        {
            $this->traceInfo = array_merge($this->traceInfo, $title);
        }
        else
        {
            $this->traceInfo[$title] = $value;
        }
    }

    function fetch($tpl_file ='')
    {
        ob_start();
        $this->display($tpl_file);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    function value($array, $key, $default = '', $intval = false)
    {
        if (isset($array[$key]))
        {
            return $intval ? intval($array[$key]) : $array[$key];
        }
        else
        {
            return $default;
        }
    }

    /**
     * 输出JSON字串
     * @param string $data
     * @param int    $code
     * @param string $message
     *
     * @return string
     */
    function json($data = '', $code = 0, $message = '')
    {
        $json = array('code' => $code, 'message' => $message, 'data' => $data);
        if (!empty($_REQUEST['jsonp']))
        {
            $this->http->header('Content-type', 'application/x-javascript');
            return $_REQUEST['jsonp'] . "(" . json_encode($json) . ");";
        }
        else
        {
            $this->http->header('Content-type', 'application/json');
            return json_encode($json);
        }
    }

    function message($code = 0, $msg = 'success')
    {
        $ret = array('code' => $code, 'message' => $msg);
        return $this->is_ajax ? $ret : json_encode($ret);
    }

    function assign($key, $value)
    {
        $this->tpl_var[$key] = $value;
    }

    /**
     * render template file, then display it.
     * @param string $tpl_file
     */
    function display($tpl_file ='')
    {
        if (empty($tpl_file))
        {
            $tpl_file = strtolower($this->swoole->env['mvc']['controller']).'/'.strtolower($this->swoole->env['mvc']['view']).'.php';
        }
        if (!is_file($this->template_dir.$tpl_file))
        {
            Error::info('template error', "template file[".$this->template_dir.$tpl_file."] not found");
        }
        extract($this->tpl_var);
        include $this->template_dir.$tpl_file;
    }

    /**
     * 显示运行时间和内存占用
     *
     * @return string
     */
    protected function showTime()
    {
        $runtime = $this->swoole->runtime();
        // 显示运行时间
        $showTime = '执行时间: ' . $runtime['time'];
        // 显示内存占用
        $showTime .= ' | 内存占用:' . $runtime['memory'];
        return $showTime;
    }

    /**
     * 显示运行时间和内存占用
     *
     * @return string
     */
    protected function showStress()
    {
        // $runtime = $this->swoole->runtime();

        $stress = '登录总人数: ' . 2;
        $stress .= ' | TCP请求频率峰值:' . '70'.'/min';
        $stress .= ' | worker总数:' . '5';
        $stress .= ' | worker等待时间峰值:' . '5'.'s';
        return $stress;
    }

    /**
     * 显示跟踪信息
     * @return string
     */
    public function showTrace()
    {
        $_trace =   array();
        $included_files = get_included_files();

        // 系统默认显示信息
        if (!empty($this->request->server['SCRIPT_NAME']))
        {
            $_trace['请求脚本'] = $this->request->server['SCRIPT_NAME'];
        }

        $_trace['请求方法'] = $this->swoole->env['mvc']['controller'].'/'.$this->swoole->env['mvc']['view'];
        $_trace['USER_AGENT'] = $this->request->server['HTTP_USER_AGENT'];
        $_trace['HTTP版本'] = $this->request->server['SERVER_PROTOCOL'];
        $_trace['请求时间'] = date('Y-m-d H:i:s', $this->request->server['REQUEST_TIME']);

        if (isset($_SESSION))
        {
            $_trace['SESSION_ID'] = session_id();
        }
        if ($this->swoole->db instanceof \Swoole\Database)
        {
            $_trace['读取数据库'] = $this->swoole->db->read_times . '次';
            $_trace['写入数据库'] = $this->swoole->db->write_times . '次';
        }
        $_trace['加载文件数目'] = count($included_files);
        $_trace['PHP执行占用'] = $this->showTime();
        
        $_trace['压力与稳定性(目前是写死的)'] = $this->showStress();
        $_trace = array_merge($this->traceInfo, $_trace);

        // 调用Trace页面模板
        $html = <<<HTMLS
<style type="text/css">
#swoole_trace_content  {
font-family:        Consolas, Courier New, Courier, monospace;
font-size:          14px;
background-color:   #fff;
margin:             40px;
color:              #000;
border:             #999 1px solid;
padding:            20px 20px 12px 20px;
}
</style>
    <div>
        <fieldset style="margin:5px;">
        <div style="overflow:auto;text-align:left;">
HTMLS;
        $html .= "<a href='".Tool::url_merge('_show_request', '1')."'>显示请求参数</a> |
        <a href='".Tool::url_merge('_show_session', '1')."'>显示会话信息</a> |
        <a href='".Tool::url_merge('_show_files', '1')."'>显示加载的PHP文件</a>
        <hr/>";
        foreach ($_trace as $key => $info)
        {
            $html .= $key . ' : ' . $info . BL;
        }
        if (!empty($this->request->get['_show_files']))
        {
            //输出包含的文件
            $html .= '加载的文件：' . BL."<pre style='color: #666'>";
            foreach ($included_files as $file)
            {
                $html .= $file . "\n";
            }
            $html .= "</pre>";
        }
        $html .= "</div></fieldset>";
        $html .= "</div>";

        if (!empty($this->request->get['_show_request']))
        {
            $output = '<fieldset style="margin:5px;"><div style="overflow:auto;text-align:left;">';
            $request = $this->swoole->request;
            $output .= "<h2>HEADER:</h2>".Tool::dump($request->header);
            $output .= "<h2>SERVER:</h2>".Tool::dump($request->server);
            if (!empty($request->files))
            {
                $output .= "<h2>FILE:</h2>".Tool::dump($request->files);
            }
            if (!empty($request->cookie))
            {
                $output .= "<h2>COOKIES:</h2>".Tool::dump($request->cookie);
            }
            if (!empty($request->get))
            {
                $output .= "<h2>GET:</h2>".Tool::dump($this->swoole->request->get);
            }
            if (!empty($request->post))
            {
                $output .= "<h2>POST:</h2>".Tool::dump($request->post);
            }

            $html .= $output."</div></fieldset>";
        }

        if (!empty($this->request->get['_show_session']))
        {
            $output = '<fieldset style="margin:5px;"><div style="overflow:auto;text-align:left;">';
            $this->session->start();
            $output .= "<h2>SESSION:</h2>" . Tool::dump($this->swoole->request->session);
            $html .= $output."</div></fieldset>";
        }

        return $html;
    }

    function __destruct()
    {
        $this->swoole->__clean();
    }
}
