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
    public $name;
    public $password;
    public $rememberMe;
    public function rules()
    {
        return [
            [['password','name'],'required'],
            ['rememberMe','safe']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'管理员',
            'password'=>'密码',
            'rememberMe'=>'记住密码'
        ];
    }
}