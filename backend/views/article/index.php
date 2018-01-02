<?php
/* @var $this yii\web\View */
?>
    <h1>文章列表</h1>

    <a href="add" class="btn btn-success">添加文章</a>


    <table class="table">

        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>分类</th>
            <th>简介</th>
            <th>状态</th>
            <th>排序</th>
            <th>录入时间</th>
            <th>操作</th>
        </tr>


        <?php foreach($rows as $row):?>

            <tr>
                <td><?=$row->id?></td>
                <td><?=$row->name?></td>

                <td><?=$row->category->name?></td>
                <td><?=$row->intro?></td>
                <td><?=\backend\models\Article::$statuslist[$row->status]?></td>
                <td><?=$row->sort?></td>
                <td><?=date('Y-m-d H:i:s',$row->inputtime)?></td>
                <td><a href="edit?id=<?=$row->id?>" class="btn btn-primary">修改</a>
                    <a href="del?id=<?=$row->id?>" class="btn btn-danger">删除</a>
                    <a href="show?id=<?=$row->id?>" class="btn btn-info">查看详情</a>


                </td>
            </tr>
        <?php endforeach;?>
    </table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination' => $page
]);
?>