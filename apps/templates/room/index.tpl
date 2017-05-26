{include file="widget/nav.tpl"}


<div class="container">
    <div class="jumbotron">
        <h1>标题</h1>
        <p>详细</p>
    </div>
    <div class="row">
        {foreach from=$data item='item'}
            <div class="col-sm-4">
                <h3>房间名: {$item.name}</h3>
                <h6>创建人: {$item.creator_name}</h6>
                <h6>公告: {$item.notice}</h6>
                <h6>游戏类型: {$item.game_type}</h6>
            </div>
            {foreach from=$item key='key' item='vv'}
                {*{$key}*}
            {/foreach}
        {/foreach}

    </div>
</div>
