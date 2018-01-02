<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 16:04
 */

namespace backend\controllers;
use backend\models\ArticleDetail;
class ArticleDetailController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAdd($id,$content)
    {
//        var_dump($id,$content);exit;
        $art=new ArticleDetail();
        $art->article_id=$id;
        $art->content=$content;
        $art->save();
        \Yii::$app->session->setFlash('success','添加成功');
        return $this->redirect(['article/index']);
    }
    public function actionEdit($id,$content){
        $art=ArticleDetail::findOne(['article_id'=>$id]);
        //  $art->article_id=$id;
        $art->content=$content;
        $art->save();
        \Yii::$app->session->setFlash('success','修改成功');
        return $this->redirect(['article/index']);
    }

}