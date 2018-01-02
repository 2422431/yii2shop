<?php
/* @var $this yii\web\View */
?>
<h1>商品列表</h1>

<a href="add" class="btn btn-primary col-md-1">添加商品</a>

    <!--搜索栏和价格范围 start-->
<form class="form-inline col-md-5 col-md-offset-6">
    <div class="form-group">
    <!--最低价的文本框-->
        <input type="text" class="form-control" id="min" placeholder="最低价"  style="width: 90px"> -
    </div>
    <div class="form-group">
        <!--最高价的文本框-->
        <input type="text" class="form-control" id="max" placeholder="最高价" style="width: 90px">
    </div>
    <!--搜索的商品文本框-->
    <div class="form-group">

        <input type="text" class="form-control" placeholder="请输入你要的商品..." id="find"  value="<?php echo $find;?>"  style="width: 200px">
    </div>
<!--    搜索按钮-->
    <a href="#" class="btn btn-default glyphicon glyphicon-search find" style="margin-bottom: 2px"></a>
</form>
<!--搜索栏和价格范围 end-->
    <div>&nbsp;</div>

<table class="table">

    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>商品编号</th>
        <th>所属分类</th>
        <th>所属品牌</th>
        <th>市场价</th>
        <th>本店价</th>
        <th>logo</th>
        <th>库存数量</th>
        <th>是否上架</th>
        <th>状态</th>
        <th>排序</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>

    <?php foreach($model as $row):?>

        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->sn?></td>
            <td><?=$row->cate->name?></td>
            <td><?=$row->brand->name?></td>
            <td><?=$row->market_price?></td>
            <td><?=$row->shop_price?></td>
            <td><img src="<?=$row->logo?>" alt="" height="40px"></td>
            <td><?=$row->stock?></td>
            <td><?php echo \backend\models\Goods::$online[$row->is_online]?></td>
            <td><?php echo \backend\models\Goods::$st[$row->status]?></td>
            <td><?=$row->sort?></td>
            <td><?=$row->createtime?></td>
            <td><a href="edit?id=<?=$row->id?>" class="glyphicon glyphicon-pencil" title="编辑"></a>&nbsp;&nbsp;&nbsp;<a href="del?id=<?=$row->id?>" class="glyphicon glyphicon-trash " title="删除">
                </a></td>
        </tr>


    <?php endforeach;?>

</table>


<?php
echo \yii\widgets\LinkPager::widget([
    'pagination' => $page
]);
?>

<?php
$js=<<<EOF
$(".find").click(function(){
   var find=$("#find").val();
   
   var min=$("#min").val();
   
   var max=$("#max").val();
   
   
   
   if(find){
   
   if(min && max){
   
      $(".find").attr("href","index?find="+find+"&min="+min+"&max="+max)
   }else{
   
      $(".find").attr("href","index?find="+find)
   }
   
   }else{
    
    $(".find").attr("href","index")
   
   }
   
   
   
})
EOF;
$this->registerJs($js);
?>
