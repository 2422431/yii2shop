<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/31
 * Time: 15:56
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    //记住我,默认勾选
    public $rememberMe = true;
    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['rememberMe'],'safe']
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>"用户名",
            'password'=>'密码',
            'rememberMe'=>'记住密码？'
        ];
    }
}