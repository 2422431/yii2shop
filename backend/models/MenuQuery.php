<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 15:25
 */

namespace backend\models;


namespace backend\models;
use creocoder\nestedsets\NestedSetsQueryBehavior;
class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}