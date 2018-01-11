<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 20:34
 */

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\models\Cart;
use yii\web\Controller;
use yii\web\Cookie;
class GoodsController extends Controller
{
    public $enableCsrfValidation=false;

    public function actionLists($id)
    {
        //当前分类
        $cate=Goods::find()->all();

        return $this->renderPartial('list',compact('cate'));
    }

    public function actionGoods($id)
    {
        $cate=Goods::findOne($id);
        return $this->render('goods',compact('cate'));

    }
//    添加购物车
    public function actionAddCart($id,$amount){
//        判断是否登录
        if (\Yii::$app->user->isGuest) {
            //没有登录 数据存到cookie
//            1取出cookie中的购物车的数据
            $cartOld = \Yii::$app->request->cookies->getValue('cart',[]);
            //判断$cartOld中是否有当前商品这个键值
            if (array_key_exists($id,$cartOld)) {
                //若有商品执行增加
                $cartOld[$id] = $cartOld[$id] + $amount;
            }else{
                //若没有商品，执行新增
                $cartOld[$id] = (int)$amount;
            }
            //设置cookie的存储对象
            $setCookie = \Yii::$app->response->cookies;

            //生成cookie对象
            $cookie = new Cookie([
                'name' => 'cart',
                'value' => $cartOld
            ]);
//            var_dump($cookie);exit;
//            var_dump($setCookie);exit;
            //添加一个cookie对象
            $setCookie->add($cookie);
            //找到购物车列表页这个方法
            return $this->redirect("cart-lists");
        }else{
            //登录了 数据存到数据库
            $cart=Cart::findOne(['goods_id'=>$id,'user_id'=>\Yii::$app->user->id]);

            if ($cart){
                $cart->amount+=$amount;
                $cart->save();
            }else{
                $addCart=new Cart();
                $addCart->goods_id=$id;
                $addCart->amount=$amount;
                $addCart->user_id=\Yii::$app->user->id;
                $addCart->save();
            }
            $this->redirect(['cart-lists']);

        }
    }
    //购物车列表页
    public function actionCartLists(){
        //判断是否登录
        if (\Yii::$app->user->isGuest) {
            //没有登录 数据存到cookie
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
//            var_dump($cart);exit;
                //取出cooki购物车的键
            $goodIds =array_keys($cart);
            //通过id把商品取出来
            $goods =Goods::find()->where(['in', 'id', $goodIds])->asArray()->all();
            foreach ($goods as $k => $good) {
                $goods[$k]['num'] = $cart[$good['id']];
            }
        }else{
            //登录了 数据存到数据库
            $carts=Cart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
            $goodId = [];
            foreach ($carts as $cart){
                $goodId[] = $cart['goods_id'];
            }
            $goods =Goods::find()->where(['in', 'id', $goodId])->asArray()->all();
            foreach ($goods as $k => $good) {
                $goods[$k]['num'] = Cart::findOne(['goods_id'=>$good['id'],'user_id'=> \Yii::$app->user->id])->amount;
            }
            //var_dump($goods);exit;

        }

        return $this->render('cart-list',compact('goods'));

    }

//    更新购物车
    public function actionUpdateCart($id,$amount){
        //var_dump($id,$amount);exit;
        if (\Yii::$app->user->isGuest) {
            //1. 取出购物车数据库
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            $cart[$id]=$amount;
            //1.1 得到设置COOKie的对象
            $setCookie = \Yii::$app->response->cookies;
            //1.2 生成一个COOKie对象
            $cookie = new Cookie([
                'name' => 'cart',
                'value' => $cart
            ]);
            //1.3 利用$setCookie添加一个Cookie对象
            $setCookie->add($cookie);
            return 1;
        }else{
            //数据库
            $cart=Cart::findOne(['goods_id'=>$id,'user_id'=> \Yii::$app->user->id]);

            $cart->amount=$amount;
//            var_dump($cart);exit;
            $cart->save();

        }
    }


    public function actionDelCart($id){
        if (\Yii::$app->user->isGuest) {
            //取出购物车数据库
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            unset($cart[$id]);
            // 得到设置COOKie的对象
            $setCookie = \Yii::$app->response->cookies;
            //生成一个COOKie对象
            $cookie = new Cookie([
                'name' => 'cart',
                'value' => $cart
            ]);
            //利用$setCookie添加一个Cookie对象
            $setCookie->add($cookie);
//            return $this->redirect('goods/cart-listsartLists');
        }else{
            //数据库
            if (Cart::findOne(['goods_id'=>$id,'user_id'=> \Yii::$app->user->id])->delete()) {
                return 1;
            }
        }
    }

}