<?php
/* @var $this yii\web\View */
?>
    <h1>文章分类列表</h1>

    <a href="add" class="btn btn-success">添加分类</a>

    <table class="table">

        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>简介</th>
            <th>排序</th>
            <th>是否帮助类</th>
            <th>操作</th>
        </tr>


        <?php foreach($rows as $row):?>

            <tr>
                <td><?=$row->id?></td>
                <td><?=$row->name?></td>
                <td><?=$row->intro?></td>
                <td><?=$row->sort?></td>
                <td><?=\backend\models\ArticleCategory::$help[$row->is_help]?></td>
                <td><a href="edit?id=<?=$row->id?>" class="btn btn-primary">修改</a>
                    <a href="del?id=<?=$row->id?>" class="btn btn-danger">删除</a>


                </td>
            </tr>
        <?php endforeach;?>
    </table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination' => $page
]);
?>