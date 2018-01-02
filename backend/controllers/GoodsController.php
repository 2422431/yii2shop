<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use flyok666\qiniu\Qiniu;
use backend\models\GoodsIntro;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
class GoodsController extends \yii\web\Controller
{
    public function actionIndex($find="",$min="",$max="")
    {
//        var_dump($max,$min);exit;
        if($find!=""){
            $cates=GoodsCategory::find()->asArray()->all();
            foreach ($cates as $k=>$v){
                if($find==$v['name']){
                    $cateid= $v['id'];
                    $count = Goods::find()->andWhere(['cate_id'=>$cateid])->count();
                    $pageSize = 3;
                    $page = new Pagination(
                        [
                            'pageSize' => $pageSize,
                            'totalCount' => $count
                        ]
                    );
                    $model=Goods::find()->andWhere(['like','cate_id',$cateid])->limit($page->limit)->offset($page->offset)->all();
                    return $this->render('index',['model'=>$model,'page'=>$page,'find'=>$find]);
                }
            }
            $brand=Brand::find()->asArray()->all();
            foreach ($brand as $k=>$v){
                if($find==$v['name']){
                    $brandid= $v['id'];
                    $count = Goods::find()->Where(['like','brand_id',$brandid])->count();
                    $pageSize = 3;
                    $page = new Pagination(
                        [
                            'pageSize' => $pageSize,
                            'totalCount' => $count
                        ]
                    );
                    $model=Goods::find()->andWhere(['like','brand_id',$brandid])->limit($page->limit)->offset($page->offset)->all();
                    return $this->render('index',['model'=>$model,'page'=>$page,'find'=>$find]);
                }
            }
            $count = Goods::find()->andWhere(['or',['like','name',$find],['like','sn',$find],['like','market_price',$find],['like','shop_price',$find]])->count();
            $pageSize = 3;
            $page = new Pagination(
                [
                    'pageSize' => $pageSize,
                    'totalCount' => $count
                ]
            );
            $model=Goods::find()->andWhere(['or',['like','name',$find],['like','sn',$find],['like','market_price',$find],['like','shop_price',$find]])->limit($page->limit)->offset($page->offset)->all();
            return $this->render('index',['model'=>$model,'page'=>$page,'find'=>$find]);
        }else{
            $count = Goods::find()->count();
            $pageSize = 3;
            $page = new Pagination(
                [
                    'pageSize' => $pageSize,
                    'totalCount' => $count
                ]
            );
            $model=Goods::find()->limit($page->limit)->offset($page->offset)->all();
            return $this->render('index',['model'=>$model,'page'=>$page,'find'=>'']);
        }
    }

    public function actionAdd(){

        $model=new Goods();
        $intro=new GoodsIntro();
        $gallery=new GoodsGallery();
        $cates=GoodsCategory::find()->orderBy('tree','lft')->asArray()->all();
        $count=count($cates);
        for($i=0;$i<$count;$i++){
            $cates[$i]['nametest']=str_repeat('-',$cates[$i]['depth']*5).$cates[$i]['name'];
        }

        $cates=ArrayHelper::map($cates,'id','nametest');
        $brands=Brand::find()->all();
        $brands=ArrayHelper::map($brands,'id','name');

        $request=\Yii::$app->request;
        if ($request->isPost){
            $dayCount=new GoodsDayCount();
            $model->load($request->post());
            $time=GoodsDayCount::findOne(["day"=>date('Ymd')]);

            if ($time){
                $time->count=$time->count+1;
                $time->save();
                $nowcount=$time->count;
            }else{
                $dayCount->day=date('Ymd');
                $dayCount->count=1;

                $dayCount->save();
                $nowcount=$dayCount->count;
            }
            $nowcount='0000'.$nowcount;
            $nowcount=substr($nowcount,-5,5);
            //保存货号
            $model->sn=date('Ymd').$nowcount;
            $model->save(false);
            $intro->load($request->post());
            $intro->goods_id=$model->id;
            $intro->save();
            $gallery->load($request->post());
            foreach ($model->imgFile as $img ){
                $gallery->goods_id=$model->id;
                $gallery->path=$img;
                $gallery->save();
                $gallery=new GoodsGallery();
                $gallery->load($request->post());
            }
            \Yii::$app->session->setFlash('success',"商品添加成功");
            return $this->redirect(['index']);
        }
        return $this->render('add',['intro' => $intro, 'gallery' => $gallery, 'model' => $model,'cates'=>$cates,'brands'=>$brands]);
    }

    public function actionUpload()
    {

        $config = [
            'accessKey' => '5oL6adBOpKWxbuDgKtRz9M8yAU5wBAm_wAaEx1xM',//AK
            'secretKey' => 'T_FO0rpYEi3rkmTtWtrehZsPG5Pcqogcxt3jPQJJ',//SK
            'domain' => 'http://p1pt17ot5.bkt.clouddn.com',//临时域名
            'bucket' => 'php080301',//空间名称
            'area' => Qiniu::AREA_HUANAN//区域

        ];

        $qiniu = new Qiniu($config);

        $key = time();

        $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
        $url = $qiniu->getLink($key);

        $info=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url
        ];
        echo   Json::encode($info);

    }


//    public function actionEdit($id){
//        $model=Goods::findOne($id);
//        $intro=GoodsIntro::find()->andWhere(['goods_id'=>$id])->one();
//        $gallery=GoodsGallery::find()->where(['goods_id'=>$id])->all();
//        foreach ($gallery as $gallerys){
//            $model->imgFile[]=$gallerys->path;
//        }
//            $cates=GoodsGallery::find()->orderBy('tree,lft')->asArray()->all();
//
//            $count=count($cates);
//            for ($i=0;$i<$count;$i++){
//                $cates[$i]['nametest']=str_repeat('-',$cates[$i]['depth']*5).$cates[$i]['name'];
//            }
//            $cates=ArrayHelper::map($cates,'id','nametest');
//            $brands=Brand::find()->all();
//            $brands=ArrayHelper::map($brands,'id','name');
//            $request=\Yii::$app->request;
//            if ($request->isPost){
//                $model->load($request->post());
//                foreach ($gallery as$gallerys){
//                    $gallerys->delete();
//                }
//                $model->save();
//                $intro->load($request->post());
//                $intro->goods_id=$model->id;
//                $intro->save();
//                $gallerynum=count($model->imgFile);
//                for ($i=0;$i<$gallerynum;$i++){
//                    $gallerynum1=new GoodsGallery();
//                    $gallerynum1->goods_id=$model->id;
//                    $gallerynum1->path=$model->imgFile[$i];
//                    $gallerynum1->save();
//                }
//                \Yii::$app->session->setFlash('success',"修改商品成功");
//                return $this->redirect(['index']);
//            }
//
//        return $this->render('edit', ['intro' => $intro, 'model' => $model,'cates'=>$cates,'brands'=>$brands]);
//
//    }


    public function actionEdit($id){

//        $model=new Goods();
        $model=Goods::findOne($id);
//        $intro=new GoodsIntro();
        $intro=GoodsIntro::findOne($id);
        $goodsImgs=GoodsGallery::find()->where(['goods_id'=>$id])->asArray()->all();

        $model->imgFile=array_column($goodsImgs,'path');



        $gallery=new GoodsGallery();
        $cates=GoodsCategory::find()->orderBy('tree','lft')->asArray()->all();
        $count=count($cates);
        for($i=0;$i<$count;$i++){
            $cates[$i]['nametest']=str_repeat('-',$cates[$i]['depth']*5).$cates[$i]['name'];
        }

        $cates=ArrayHelper::map($cates,'id','nametest');
        $brands=Brand::find()->all();
        $brands=ArrayHelper::map($brands,'id','name');

        $request=\Yii::$app->request;
        if ($request->isPost){
            $dayCount=new GoodsDayCount();
            $model->load($request->post());
            $time=GoodsDayCount::findOne(["day"=>date('Ymd')]);

            if ($time){
                $time->count=$time->count+1;
                $time->save();
                $nowcount=$time->count;
            }else{
                $dayCount->day=date('Ymd');
                $dayCount->count=1;

                $dayCount->save();
                $nowcount=$dayCount->count;
            }
            $nowcount='0000'.$nowcount;
            $nowcount=substr($nowcount,-5,5);
            //保存货号
            $model->sn=date('Ymd').$nowcount;
            $model->save();
            $intro->load($request->post());
            $intro->goods_id=$model->id;
            $intro->save();
            $gallery->load($request->post());

            $gallerynum=count($gallery->path);

            for ($i=0;$i<$gallerynum;$i++){
                $gallery->goods_id=$model->id;
                $gallery->path=$gallery->path[$i];
                $gallery->save();
                $gallery=new GoodsGallery();
                $gallery->load($request->post());
            }
            \Yii::$app->session->setFlash('success',"商品修改成功");
            return $this->redirect(['index']);
        }
        return $this->render('add',['intro' => $intro, 'gallery' => $gallery, 'model' => $model,'cates'=>$cates,'brands'=>$brands]);
    }


//    删除的方法
        public function actionDel($id){
        $model=Goods::findOne($id);
        $gallery=GoodsGallery::find()->andWhere(['goods_id'=>$id])->all();
        $intro=GoodsIntro::findOne($id);

        $model->delete();
        foreach ($gallery as $pic){
            $pic->delete();
        };
        $intro->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect('index');
        }

}
