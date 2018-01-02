<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 16:06
 */

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Article extends \yii\db\ActiveRecord
{
    public $content;
    public static $statuslist=[0=>'隐藏',1=>'显示'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'sort','status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['intro'], 'string', 'max' => 255],
            [['content'],'required']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名',
            'category_id' => '分类id',
            'intro' => '文章简介',
            'sort' => '排序',
            'inputtime' => '录入时间',
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['inputtime'],
                ],
            ]
        ];
    }
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(),['id'=>'category_id']);
    }

}