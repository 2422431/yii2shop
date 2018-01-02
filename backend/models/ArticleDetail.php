<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 16:09
 */


namespace backend\models;
use Yii;


class ArticleDetail extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'article_detail';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'integer'],
            [['content'], 'string'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => '文章id',
            'content' => '文章内容',
        ];
    }

}