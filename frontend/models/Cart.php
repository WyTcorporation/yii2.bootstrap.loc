<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 16.03.2020
 * Time: 12:18
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace frontend\models;

use backend\models\categories\CategoriesPercent;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use Yii;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function AddToCart($product, $qty = 1)
    {
        $language = Yii::$app->language;
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
        $type_id = Type::findOne(['type' => 'products'])->id;

        $product->content_id = $content_id;
        $product->language_id = $language_id;
        $product->type_id = $type_id;

        $user_role = Yii::$app->user->identity->role;
        $percents = CategoriesPercent::find()->where(['categories_id' => $product->category_id,'role'=>$user_role])->one();

        if (isset($percents) && !empty($percents)) {
            $percent = $percents/100;
        } else {
            $percent = 0;
        }

        if (isset($_SESSION['cart'][$product->id])) {
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$product->id] = [
                'id' => $product->id,
                'name' => $product->translation->content,
                'price' => $product->price - ($product->price*$percent),
                'qty' => $qty,
                'img' => $product->img,
                'slug' => $product->slug,
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * ($product->price - ($product->price*$percent)) : $qty * ($product->price - ($product->price*$percent));
    }

    public function recalc($id)
    {
        if (!isset($_SESSION['cart'][$id])) return false;
        $gtyMinus = $_SESSION['cart'][$id]['qty'];
        $_SESSION['cart.qty'] -= $gtyMinus;
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.sum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
    }

}
