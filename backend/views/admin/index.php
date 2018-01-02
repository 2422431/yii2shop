<?php
/* @var $this yii\web\View */
?>
<h1>管理员列表</h1>

<table class="table">

    <tr>
        <th>ID</th>
        <th>管理员</th>
        <th>注册时间</th>
        <th>角色</th>
        <th>令牌</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>
    </tr>

    <?php
    foreach ($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=date('Y-m-d H:i:s',$row->create_time)?></td>
            <td>
                <?php
                $roles=Yii::$app->authManager->getRolesByUser($row->id);
                foreach ($roles as $role){
                    echo $role->description."/";
                }
                ?>


            </td>
            <td><?=$row->take?></td>
            <td><?php if($row->last_login_time!=null){echo date('Y-m-d H:i:s',$row->last_login_time);}?></td>
            <td><?=$row->last_login_ip?></td>
            <td><a href="edit?id=<?=$row->id?>" title="编辑" class="glyphicon glyphicon-edit"></a>&nbsp;<a href="del?id=<?=$row->id?>" class="glyphicon glyphicon-trash" title="删除"></a></td>
        </tr>
    <?php endforeach;?>
</table>