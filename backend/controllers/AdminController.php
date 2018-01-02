<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/31
 * Time: 15:59
 */

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\helpers\ArrayHelper;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $rows=Admin::find()->all();
        return $this->render('index',['rows'=>$rows]);
    }
    public function actionAdd()
    {
        $model=new Admin();
        $request=\Yii::$app->request;
        $auth=\Yii::$app->authManager;
        $roles=$auth->getRoles();
        $roles= ArrayHelper::map($roles,'name','description');
        if($request->isPost){
            $model->load($request->post());
            $model->create_time=time();
            $model->password=\Yii::$app->security->generatePasswordHash($model->password);
            $model->take=\Yii::$app->security->generateRandomString();
            if($model->validate()){
                $model->save();
                if($model->roles){
                    foreach ($model->roles as $role){
                        $auth->assign($auth->getRole($role),$model->id);
                    }
                }
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add', ['model' => $model,'roles'=>$roles]);
    }
    public function actionLogin()
    {
        $model=new LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $admin=Admin::findOne(['name'=>$model->name]);
            if($admin!=null){
                if(  \Yii::$app->security->validatePassword($model->password,$admin->password)){
                    \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);
                    $admin->last_login_time=time();
                    $admin->last_login_ip= \Yii::$app->request->userIP;
                    $admin->save();
                    return $this->redirect(['admin/index']);
                }else{
                    $model->addError('password','密码错误');
                }
            }else{
                $model->addError('name','该用户不存在');
            }
        }
        return $this->render('login', ['model' => $model]);
    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
    public function actionDel($id)
    {
        $model=Admin::findOne($id);
        $model->delete();
        $auth=  \Yii::$app->authManager;
        $auth->revokeAll($model->id);
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['index']);
    }
    public function actionEdit($id)
    {
        $model=Admin::findOne($id);
        //new一个组件对象用于操作rbac
        $auth=  \Yii::$app->authManager;
        //查询出数据库中的所有角色
        $roles= $auth->getRoles();
        //转换需要的数组格式用于视图显示多选框
        $ro=ArrayHelper::map($roles,'name','description');
        //查出当前用户的所有角色
        $r=$auth->getRolesByUser($id);
        //转换为需要的数组格式
        $r=array_keys($r);
//        if($r!=null){
        //遍历当前的用户角色，赋值给model的role属性，用于回显
        foreach ($r as $rr){
            $model->roles[]= $rr;
        }
//        }
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->create_time=time();
            $model->password=\Yii::$app->security->generatePasswordHash($model->password);
            $model->take=\Yii::$app->security->generateRandomString();
            if($model->validate()){
                $model->save();
                //删除当前用户原有角色
                $auth->revokeAll($model->id);
                if($model->roles){
                    //循环给当前用户重新添加角色
                    foreach ($model->roles as $role){
                        $auth->assign($auth->getRole($role),$model->id);
                    }
                }
                return $this->redirect(['index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        };
        return $this->render('add', ['model' => $model,'roles'=>$ro]);
    }

}