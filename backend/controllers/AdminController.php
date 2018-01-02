<?php
namespace backend\controllers;
use backend\models\Admin;
use backend\models\LoginFrom;
use yii\web\UploadedFile;
class AdminController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = Admin::find()->all();
        //显示视图
        return $this->render("index",['model'=>$model]);
    }
    public function actionLogin(){
        //实例表单模型
        $model=new \backend\models\LoginForm();
        //判断是不是post
        $request=\Yii::$app->request;
        IF($request->isPost){
            //数据绑定
            $model->load($request->post());
            if($model->validate()){
                //根据用户名对象查出来
                $admin=Admin::findOne(['username'=>$model->username]);
                if($admin){
                    if(\Yii::$app->security->validatePassword($model->password,$admin->password_reset_token));
                    //执行登陆
                    \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);
                    //追加最后登录的时间
                    $admin->last_login_time=time();
                    $admin->save();
                    //跳转
                    \Yii::$app->session->setFlash("success",'登录成功');
                    return $this->redirect('index');


                }else{
                    //密码错误
                    $model->addError('password',"密码错误");
                }
            }else{
                //不存在  提示没有用户名
                $model->addError('username',"用户名不存在");
            }
        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
    public function actionAdd()
    {
        $admin = new Admin();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            if ($admin->load($request->post())) {
                if ($admin->validate()) {
                    //自动登陆令牌
                    $admin->auth_key.rand(1000,2000).rand(0,255);
                    //追加ip
                    $admin->last_login_ip =\Yii::$app->request->userIP;
                    //追加注册时间
                    $admin->add_time = time();
//                    //追加最后登陆时间
//                    $admin->last_login_time = time();
                    //加密
                    $admin->password_reset_token = \Yii::$app->security->generatePasswordHash($admin->password_reset_token);
                    //随机字符串
                    $admin->auth_key = \Yii::$app->security->generateRandomString();
                    var_dump($admin->getErrors());
                    $admin->save();
                    \Yii::$app->session->setFlash('success', '注册成功');
                    //跳转
                    return     $this->redirect(['admin/index']);
                }else{
                    var_dump( $admin->getErrors());exit;
                }
            }
        }
        return $this->render('add', ['model' => $admin]);
    }
//编辑
    public function actionEdit($id)
    {
        $admin =Admin::findOne($id);
        $request = \Yii::$app->request;
        if ($request->isPost) {
            if ($admin->load($request->post())) {
                if ($admin->validate()) {
                    //自动登陆令牌
                    $admin->auth_key.rand(1000,2000).rand(0,255);
                    //追加ip
                    $admin->last_login_ip =\Yii::$app->request->userIP;
                    //追加注册时间
                    $admin->add_time = time();
                    //追加最后登陆时间
                    $admin->last_login_time = time();
                    //加密
                    $admin->password_reset_token = \Yii::$app->security->generatePasswordHash($admin->password_reset_token);
                    //随机字符串
                    $admin->auth_key = \Yii::$app->security->generateRandomString();
                    var_dump($admin->getErrors());
                    $admin->save();
                    \Yii::$app->session->setFlash('success', '修改成功');
                    //跳转
                    return     $this->redirect(['admin/index']);
                }else{
                    var_dump( $admin->getErrors());exit;
                }
            }
        }
        return $this->render('add', ['model' => $admin]);
    }
    public function actionDel($id){
        //创造对象
        $model=Admin::findOne($id);
        //删除
        $model->delete();
        //跳转
        return $this->redirect(['admin/index']);
    }
    public function actionUpload(){
  // var_dump($_FILES);exit;
  //得到上传文件的实例对象
        $file=UploadedFile::getInstanceByName("file");
//        var_dump($file);exit;
        if ($file) {
            //路径
            $path="images/admin/upload/".time().".".$file->extension;
//            var_dump($path);exit;
            //移动图片
            if ($file->saveAs($path,false)) {
                // {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}

                $result=[
                    'code'=>0,
                    'url'=>"/".$path,
                    'attachment'=>$path

                ];
                return json_encode($result);
            }

        }







    }

}