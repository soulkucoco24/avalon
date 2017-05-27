{include file="widget/head.tpl"}

{*todo变色导航写的这么艰辛*}
{literal}
    <script type="text/javascript">
//    function(){
        $('#dropdown-menu li').click(function(){
            alert('sdfsdf');
        this.addClass("active").siblings().removeClass("active");
        });
//    };
</script>
{/literal}

<ul class="nav nav-pills nav-justified">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
            我 <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/user/home">个人中心</a></li>
            <li><a href="/user/login">登录</a></li>
            <li><a href="/user/logout">登出</a></li>
            <li class="divider"></li>
            <li><a href="/user/addbug">提交Bug</a></li>
        </ul>
    </li>
</ul>

<ul class="nav nav-pills nav-justified">
    <li><a href="/">首页</a></li>
    <li {*class="active">*}><a href="/room/index">桌游</a></li>
    <li><a href="/doc/ss">SS服务</a></li>
    {*todo跳转写的这么艰辛*}
    <li><a href=javascript:window.location.href=window.location.host.replace('www','http://garden') >空间站</a></li>
</ul><br><br><br>