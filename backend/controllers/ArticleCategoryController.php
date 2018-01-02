<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 15:58
 */

namespace backend\controllers;
use backend\models\ArticleCategory;
use yii\data\Pagination;
class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $count = ArticleCategory::find()->count();
        $pageSize = 3;
        $page = new Pagination(
            [
                'pageSize' => $pageSize,
                'totalCount' => $count
            ]
        );
        $rows=ArticleCategory::find()->limit($page->limit)->offset($page->offset)->all();
        return $this->render('index',['rows'=>$rows,'page'=>$page]);
    }
    public function actionAdd()
    {
        $model=new ArticleCategory();
        $request=\Yii::$app->request;
        if($model->load($request->post())){
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        $model->is_help=1;
        return $this->render('add', ['model' => $model]);
    }
    public function actionEdit($id)
    {
        $model=ArticleCategory::findOne($id);
        $request=\Yii::$app->request;
        if($model->load($request->post())){
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    public function actionDel($id)
    {
        $row=ArticleCategory::findOne($id);
        $row->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect('index');
    }
}
