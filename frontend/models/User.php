<?php
namespace frontend\models;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $mobile 手机号
 * @property int $login_ip 登录IP
 */
class User extends \yii\db\ActiveRecord
{
    public $password;//密码
    public $rePassword;//确认密码
    public $captcha;//手机验证码
    public $checkCode;//验证码
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password','rePassword', 'mobile'], 'required'],
            ['rePassword','compare','compareAttribute' => 'password'],
            [['username'], 'unique'],
            ['checkCode','captcha','captchaAction' =>'/user/captcha' ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'mobile' => '手机号',
            'login_ip' => '登录IP',
        ];
    }

    //自动生成时间
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT=>['created_at','updated_at'],
                    self::EVENT_BEFORE_UPDATE=>['updated_at']
                ]
            ]
        ];
    }
}