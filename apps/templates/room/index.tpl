{include file="widget/nav.tpl"}


<div class="container">
    <div class="jumbotron">
        <h1>标题</h1>
        <p>详细</p>
    </div>
    <div class="row">
        {foreach from=$data item='item'}
            <div class="col-sm-4">
                <h3>房间名</h3>
            </div>
            {foreach from=$item key='key' item='vv'}
                {*{$key}*}
            {/foreach}
        {/foreach}

    </div>
</div>
