<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 16:08
 */

namespace backend\models;namespace backend\models;
use Yii;

class ArticleCategory extends \yii\db\ActiveRecord
{
    public static $help=[0=>'否',1=>'是'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'sort', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['intro'], 'string', 'max' => 255],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'intro' => '文章简介',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '是否帮助类分类',
        ];
    }

}