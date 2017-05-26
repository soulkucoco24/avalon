{include file="widget/nav.tpl"}

<head>头部</head>
<h2>用户信息: <?= isset($user) ? print_r($user):''; ?></h2>
<h1>数据: <?= isset($data) ? print_r($data):''; ?></h1>
<h3>底部</h3>

<script type="text/javascript"  src="/room/room.js">
    console.log(<?= json_encode($data)?>);
</script>