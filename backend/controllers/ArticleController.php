<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 16:02
 */

namespace backend\controllers;
use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;


class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $count = Article::find()->count();
        $pageSize = 3;
        $page = new Pagination(
            [
                'pageSize' => $pageSize,
                'totalCount' => $count
            ]
        );
        $rows=Article::find()->limit($page->limit)->offset($page->offset)->all();
        return $this->render('index',['rows'=>$rows,'page'=>$page]);
    }
    public function actionAdd()
    {
        $model=new Article();
        $cate=ArticleCategory::find()->all();
        $options = ArrayHelper::map($cate, 'id', 'name');
        if($model->load(\Yii::$app->request->post())){
            $model->validate();
            $model->save();
            $id=\Yii::$app->db->getLastInsertID();
            $art=new ArticleDetail();
            $art->article_id=$id;
            $art->content=$model->content;
            $art->save();
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect('index');
        }
        $model->status=1;
        return $this->render('add', ['model' => $model,'cate'=>$options]);
    }
    public function actionEdit($id){
        $model=Article::findOne($id);
        $cate=ArticleCategory::find()->all();
        $art=ArticleDetail::findOne(['article_id'=>$id]);
//        $art=$art->content;
        $options = ArrayHelper::map($cate, 'id', 'name');
        if($model->load(\Yii::$app->request->post())){
//            var_dump(111,$model->content);exit;
            $model->validate();
            $art->content=$model->content;
            $model->save();
            $art->save();
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(["index"]);
//            return $this->redirect(["article-detail/edit?content=$model->content&id=$id"]);
        }
        return $this->render('edit', ['model' => $model,'cate'=>$options,'art'=>$art->content]);
    }
    public function actionDel($id)
    {
        $row=Article::findOne($id);
        $row->delete();
        $art=ArticleDetail::findOne(['article_id'=>$id]);
        $art->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect('index');
    }
    public function actionShow($id)
    {
        $row=Article::findOne($id);
        $art=ArticleDetail::findOne(['article_id'=>$id]);
        $art=$art->content;
//        var_dump($art);
        return $this->render('show',['row'=>$row,'art'=>$art]);
    }


}