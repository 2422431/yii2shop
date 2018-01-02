<?php
namespace backend\models;
use backend\models\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
/**
 * This is the model class for table "goods_category".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $intro
 * @property integer $p_id
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
//    public $nametext;
//    /**
//     * @inheritdoc
//     */
//    public static function tableName()
//    {
//        return 'goods_category';
//    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name'], 'required'],
            [['tree', 'lft', 'rgt', 'depth'], 'integer'],
            [['name', 'intro'], 'string', 'max' => 255],
                        [['p_id'],'default','value'=>0],
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
            'tree' => '树',
            'p_id' => '父级分类',
            'lft' => '左',
            'rgt' => '右',
            'depth' => '深度',
            'intro' => '简介',

        ];
    }
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}