<?php
/* @var $this yii\web\View */
?>
<?=\yii\bootstrap\Html::a('添加权限',['add'],['class'=>'btn btn-primary'])?>
<h1>权限列表</h1>
<table class="table">
    <tr>
        <th>权限名称</th>
        <th>权限描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($permissios as $permission):?>

        <tr>
            <td>

                <?php
                echo strpos($permission->name,"/")?"---":"";
                ?><?=$permission->name?>
            </td>
            <td>

                <?=$permission->description?>
            </td>
            <td>
                <?php
                echo  \yii\bootstrap\Html::a("编辑",['edit','name'=>$permission->name],['class'=>'btn btn-info btn-sm']);
                echo  \yii\bootstrap\Html::a("删除",['del','name'=>$permission->name],['class'=>'btn btn-success btn-sm']);
                ?>
            </td>
        </tr>


    <?php endforeach;?>
</table>
