<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $cate_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_online
 * @property integer $status
 * @property integer $sort
 * @property string $createtime
 */
class Goods extends \yii\db\ActiveRecord
{
    //设置属性
    public static $online=[0=>"未上架",1=>"已上架"];
    public static $st=[0=>"隐藏",1=>"显示"];
    public $imgFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','market_price','shop_price','stock'], 'required'],
            [['cate_id', 'brand_id', 'stock', 'is_online', 'status', 'sort'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'logo'], 'string', 'max' => 255],
            [['sn'], 'string', 'max' => 15],
            [['imgFile'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '商品编号',
            'logo' => 'logo',
            'cate_id' => '商品分类',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_online' => '是否上架',
            'status' => '商品状态',
            'sort' => '排序',
            'createtime' => '创建时间',
        ];
    }
    //注入行为
    public function behaviors()
    {
        return [
            [

                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT=>['createtime'],
                ],

            ]
        ];
    }

    public function getCate(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'cate_id']);
    }

    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }

    //得到商品详情 1对1
    public function getIntro(){
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }
    //得到商品对应的所有图片  1对多
    public function getImages(){
        return $this->hasMany(GoodsGallery::className(),['goods_id'=>'id']);
    }

}
