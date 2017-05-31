{include file="widget/nav.tpl"}

{*<script src="https://cdnjs.cloudflare.com/ajax/libs/numeric/1.2.6/numeric.js"></script>*}
{*<script src="/plugin/black-hole.js"></script>*}
{*<script>*}
    {*BlackHole.blackHoleifyImage('canvas_placeholder', 'http://7xn4jv.com1.z0.glb.clouddn.com/yinhe.jpg')*}
{*</script>*}

{*<div>*}
    {*<head>头部</head>*}
    {*<h2>用户信息: <?= isset($user) ? print_r($user):''; ?></h2>*}
    {*<h1>数据: <?= isset($data) ? print_r($data):''; ?></h1>*}
    {*<h3>底部</h3>*}
    {*<a href="/user/login"> 去登录 </a>*}
{*</div>*}

{*<div id="canvas_placeholder">*}
{*</div>*}



<div class="view">
    <div class="carousel slide" id="carousel-52109">
        <ol class="carousel-indicators">
            <li class="" data-slide-to="0" data-target="#carousel-52109"></li>
            <li data-slide-to="1" data-target="#carousel-52109" class="active"></li>
            {*<li data-slide-to="2" data-target="#carousel-52109" class=""></li>*}
        </ol>
        <div class="carousel-inner">
            {*<div class="item">*}
                {*<img alt="">*}
                {*<div class="carousel-caption" id="canvas_placeholder">*}
                    {*<h4>First Thumbnail label</h4>*}
                    {*<p>*}

                    {*</p>*}
                {*</div>*}
            {*</div>*}
            <div class="item active">
                <img alt="" src="http://7xn4jv.com1.z0.glb.clouddn.com/yinhe.jpg">
                <div class="carousel-caption">
                    <h4>Second Thumbnail label</h4>
                    <p>
                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                    </p>
                </div>
            </div>
            <div class="item">
                <img alt="" src="http://7xn4jv.com1.z0.glb.clouddn.com/yinhe.jpg">
                <div class="carousel-caption">
                    <h4>Third Thumbnail label</h4>
                    <p>
                        Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                    </p>
                </div>
            </div>
        </div>

        <a class="left carousel-control" href="#carousel-52109" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-52109" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>