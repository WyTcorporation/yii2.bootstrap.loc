<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 11.09.2021
 * Time: 11:47
 * User: WyTcorporation
 */

namespace frontend\controllers;

use backend\models\orders\Orders;
use Yii;

use yii\web\HttpException;

class OrdersController extends AppController
{
    public function actionIndex($id)
    {
        $language = Yii::$app->language;

        $params = Yii::$app->params['languages'];

        $shopTitle = Yii::$app->params['shopTitle'];

        $this->setMeta(null, null, null, $shopTitle . ' Заказы');

        $orders = Orders::find()->where(['user_id'=>$id])->orderBy('id DESC')->all();

        return $this->render('index', [
            'orders'=>$orders,
            'language'=>$language,
            'params'=>$params,
        ]);
    }

}