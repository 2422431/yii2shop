<?php
namespace backend\controllers;
use backend\models\GoodsCategory;
use yii\helpers\ArrayHelper;
class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $cate=GoodsCategory::find()->all();
        return $this->render('index',['cates'=>$cate]);
    }
    public function actionAdd()
    {
        $model=new GoodsCategory();
        $cates=GoodsCategory::find()->orderBy('tree,lft')->asArray()->all();
        $count=GoodsCategory::find()->count();
//        echo $count;exit;
        for($i=0;$i<$count;$i++){
            $cates[$i]['nametest']=str_repeat('-',($cates[$i]['depth']+1)*($cates[$i]['depth']+4)).$cates[$i]['name'];
        }
        $cates=ArrayHelper::map($cates,"id","nametest");
//        $cates[0]='顶级分类';
        if($model->load(\Yii::$app->request->post())){
            if($model->p_id==0){
                $model->makeRoot();
            }else{
                $pcate=GoodsCategory::findOne(['id'=>$model->p_id]);
                $model->prependTo($pcate);
            }
            \Yii::$app->session->setFlash(
                'success','添加分类成功'
            );
            return $this->redirect(['index']);
        }
//        $model->p_id=0;
        return $this->render('add', ['model' => $model,'cates'=>$cates]);
    }
    public function actionEdit($id)
    {
        $model=GoodsCategory::findOne($id);
        $cates=GoodsCategory::find()->andWhere('tree !=:tree or lft < :lft ', [':tree'=>$model->tree,':lft'=>$model->lft])->orderBy('tree,lft')->asArray()->all();
        $count=count($cates);
        for($i=0;$i<$count;$i++){
            $cates[$i]['nametest']=str_repeat('-',$cates[$i]['depth']*5).$cates[$i]['name'];
        }
        $cates=ArrayHelper::map($cates,"id","nametest");
        if($model->load(\Yii::$app->request->post())){
            $model->save();
            \Yii::$app->session->setFlash(
                'success','修改分类成功'
            );
            return $this->redirect(['index']);
        }
        return $this->render('add', ['model' => $model,'cates'=>$cates]);
    }
    public function actionDel($id)
    {
        $child=GoodsCategory::find()->andWhere(['p_id'=>$id])->all();
//        var_dump($child);exit;
        if($child){
            \Yii::$app->session->setFlash('danger','该分类下存在子分类，不可删除');
            return $this->redirect(['index']);
        }else{
            $model=GoodsCategory::findOne($id);
            $model->deleteWithChildren();
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect(['index']);
        }
    }
}