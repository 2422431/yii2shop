<?php

namespace backend\controllers;
use backend\models\AuthItem;
use function Sodium\add;

class PermissionController extends \yii\web\Controller
{
    //显示列表
    public function actionIndex()
    {
        //实例化rbac组件
        $authManager=\Yii::$app->authManager;
        //显示权限 把所有的权限查出来
        $permissios=$authManager->getPermissions();
        return $this->render('index',compact('permissios'));
    }
        //添加列表
    public function actionAdd(){
        //实例化AuthItem
        $model= new AuthItem();
        $request=\Yii::$app->request;
        if($model->load($request->post())&& $model->validate()){
            //实例化RBAC组件
            $authManager=\Yii::$app->authManager;
            //创建一个权限
            $permission=$authManager->createPermission($model->name);
            //添加描述
            $permission->description=$model->description;
            //添加权限
            $authManager->add($permission);
            \Yii::$app->session->setFlash("success","创建".$model->description."成功");
            return $this->redirect(['index']);
        }
        return $this->render('add', ['model' => $model]);
    }

    //编辑
    public function actionEdit($name)
    {
        //实例化authManager组件
        $auth = \Yii::$app->authManager;
        //找到需要修改的权限
        $model = AuthItem::findOne($name);
        //判断是不是POST提交
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //  var_dump($model);exit;
            /*$permission=$auth->createPermission('goods/index');
                 $permission->description="商品列表";
                 $auth->add($permission);*/
            //1. 找到对应权限
            $permission = $auth->getPermission($model->name);
            // var_dump($permission);exit;
            if ($permission){
                //2.设置权限
                $permission->description = $model->description;
                //3.添加入库
                if ($auth->update($name,$permission)) {
                    \Yii::$app->session->setFlash("success", '修改权限' . $model->name . "成功");
                    //4.跳列表页
                    return $this->redirect(['index']);
                }
            }else{
                \Yii::$app->session->setFlash("danger", '不能修改名称' . $model->name );
                //刷新
                return $this->refresh();
            }
        }
        //var_dump($model->errors);exit;
        /*$permission=$auth->createPermission('goods/index');
        $permission->description="商品列表";
        $auth->add($permission);*/
        return $this->render('edit', compact('model'));
    }

//    删除权限
    public function actionDel($name){
        $auth=\Yii::$app->authManager;
        //找到要删除的权限的对象
        $permission=$auth->getPermission($name);
        //删除权限
        if($auth->remove($permission)){
            \Yii::$app->session->setFlash("success","删除".$name."成功");
            return $this->redirect(['index']);
        }
    }





}
