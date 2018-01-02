<?php
/* @var $this yii\web\View */
?>
<?=\yii\bootstrap\Html::a('添加管理员',['admin/add'],['class'=>'btn btn-primary'])?>&nbsp;

<table class="table">
    <tr>
        <th>id</th>
        <th>管理员</th>
        <th>头像</th>
        <th>邮箱</th>
        <th>添加时间</th>
        <th>最后登陆时间</th>
        <th>最后登陆ip</th>
        <th>操作</th>
    </tr>
    <?php foreach ($model as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=\yii\bootstrap\Html::img("/".$model->logo,['height'=>50])?></td>
            <td><?=$model->email?></td>
            <td><?=date('Y-m-d H:i:s',$model->add_time)?></td>
            <td><?=date('Y-m-d H:i:s',$model->last_login_time)?></td>
            <td><?=$model->last_login_ip?></td>
            <td> <?php
                echo   \yii\bootstrap\Html::a("编辑管理员",['admin/edit','id'=>$model->id],['class'=>'btn btn-info btn-sm']);
                echo   \yii\bootstrap\Html::a("删除",['admin/del','id'=>$model->id],['class'=>'btn btn-danger btn-sm']);
                ?>
            </td>
        </tr>


    <?php endforeach;   ?>

</table>