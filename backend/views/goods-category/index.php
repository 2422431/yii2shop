<?php
/* @var $this yii\web\View */
?>
    <a href="add" class="btn btn-success">添加分类</a>

    <h1>商品分类列表</h1>

<?php foreach ($cates as $cate): if($cate->p_id==0){?>

    <div class="panel-group"  role="tablist" aria-multiselectable="false">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?=$cate->id?>">
                <h5 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$cate->id?>"  aria-controls="collapse<?=$cate->id?>" >
                        <?=$cate->name?>
                    </a>

                    <div align="right"> <a href="edit?id=<?=$cate->id?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>||<a href="del?id=<?=$cate->id?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>
                </h5>
            </div>

            <div id="collapse<?=$cate->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$cate->id?>">

                <?php  foreach($cates as $childcate): if($childcate->p_id==$cate->id){?>
                    <div class="panel-body">


                        <h5 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$childcate->id?>"  aria-controls="collapse<?=$childcate->id?>">
                                <?php
                                echo  str_repeat("&nbsp;",$childcate->depth*5);
                                echo  $childcate->name
                                ?>
                            </a>
                        </h5>


                        <div align="right"> <a href="edit?id=<?=$childcate->id?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>||<a href="del?id=<?=$childcate->id?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>

                    </div>



                    <div id="collapse<?=$childcate->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$childcate->id?>">

                        <?php  foreach($cates as $childcateaa): if($childcateaa->p_id==$childcate->id){?>
                            <div class="panel-body">


                                <h5 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$childcateaa->id?>" aria-expanded="false" aria-controls="collapse<?=$childcateaa->id?>">
                                        <?php
                                        echo  str_repeat("&nbsp;",$childcateaa->depth*5);
                                        echo  $childcateaa->name
                                        ?>
                                    </a>
                                </h5>


                                <div align="right"> <a href="edit?id=<?=$childcateaa->id?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>||<a href="del?id=<?=$childcateaa->id?>" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>

                            </div>

                            <div id="collapse<?=$childcateaa->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$childcateaa->id?>">

                                <?php  foreach($cates as $childcateaabb): if($childcateaabb->p_id==$childcateaa->id){?>
                                    <div class="panel-body">


                                        <h5 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$childcateaabb->id?>" aria-expanded="false" aria-controls="collapse<?=$childcateaabb->id?>">
                                                <?php
                                                echo  str_repeat("&nbsp;",$childcateaabb->depth*5);
                                                echo  $childcateaabb->name
                                                ?>
                                            </a>
                                        </h5>

                                        <div align="right"> <a href="edit?id=<?=$childcateaabb->id?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a>||<a href="del?id=<?=$childcateaabb->id?>" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>


                                    </div>

                                <?php }; endforeach;?>


                            </div>

                        <?php }; endforeach;?>


                    </div>

                <?php }; endforeach;?>


            </div>
        </div>
    </div>

<?php  }; endforeach;?>