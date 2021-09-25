<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 16.03.2020
 * Time: 12:15
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace frontend\controllers;

use backend\models\np\NpCities;
use backend\models\np\NpRegion;
use backend\models\orders\Orders;
use backend\models\orders\OrdersItems;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use common\models\User;
use Yii;
use backend\models\products\Products;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderItems;
use yii\base\BaseObject;
use frontend\models\LiqPay;

class CartController extends AppController
{
    public function actionAdd($id, $qty)
    {
//        $qty = (int)Yii::$app->request->get('qty');

        $product = Products::findOne($id);
        if (empty($product)) {
            return false;
        }

        $session = Yii::$app->session;
        $session->open();

        $cart = new Cart();

        $qty = !(int)$qty ? 1 : $qty;

        $cart->AddToCart($product, $qty);

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        $this->layout = false;

        $language = Yii::$app->language;

        return $this->render('cart-modal', compact('session', 'language'));
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem($id)
    {
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow()
    {
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView()
    {

        $this->setMeta(null, null, null, 'Магазин | Корзина');

        $language = Yii::$app->language;
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
        $type_id = Type::findOne(['type' => 'products'])->id;
        $user_role = Yii::$app->user->identity->role;
        $params = Yii::$app->params['languages'];


        $user = User::findOne(Yii::$app->user->id);

        $session = Yii::$app->session;
        $session->open();

        if (isset($session['cart']) && !empty($session['cart'])) {
            $new_array = array_values($session['cart']);

            $productList = null;
            for ($x=0;$x<=count($new_array);$x++) {
                if (isset($new_array[$x]) && !empty($new_array[$x])) {
                    $product = Products::findOne($new_array[$x]['id']);
                    $product->content_id = $content_id;
                    $product->language_id = $language_id;
                    $product->type_id = $type_id;
                    $name = $product->translation->content;
                    $productList['products'][$x]['id'] = $product->id;
                    $productList['products'][$x]['name'] = $name;
                    $productList['products'][$x]['price'] = $new_array[$x]['price'];
                    $productList['products'][$x]['qty'] = $new_array[$x]['qty'];
                    $productList['products'][$x]['img'] = $product->img;
                    $productList['products'][$x]['slug'] = $product->slug;
                }
            }
            $productList['cart.qty'] = $session['cart.qty'];
            $productList['cart.sum'] = $session['cart.sum'];
        }


        $order = new Orders();
        if (Yii::$app->request->isPjax) {
            if ($order->load(Yii::$app->request->post())) {

                $products = Yii::$app->request->post('Products');

                $orders = Yii::$app->request->post('Orders');

                if(!isset($orders['user_id'])) {
                    $order->user_id = 2;
                } else {
                    $order->user_id = $user->id;
                }

                $shipping_method = Yii::$app->request->post('shipping_method');

//                $getRegions = Yii::$app->request->post('getRegions');
//                $getCities = Yii::$app->request->post('getCities');
                $getWarehouses = Yii::$app->request->post('getWarehouses');

                if(isset($getWarehouses)) {
                    $order->address = $getWarehouses;
                }

                if ($shipping_method == 'pickup.pickup') {
                    $order->shipping = 1;
                } elseif ($shipping_method == 'npradio') {
                    $order->shipping = 2;
                }

                //Убрать после проверки liqpay
                $order->sum = 1;

                if ($order->save()) {
                    $this->saveOrderItems($products, $order->id);


                    Yii::$app->session->setFlash('success', Yii::t('frontend/flash', 'Your order is accepted'));

                    Yii::$app->mailer->compose('order', ['session' => $session])
                        ->setFrom(['wild.savedo@gmail.com' => 'name'])
                        ->setTo('wild.savedo@gmail.com')
                        ->setSubject('Заказ')
                        ->setTextBody('Текст сообщения')
                        ->setHtmlBody('<b>текст сообщения в формате HTML</b>')
                        ->send();

                    if ($orders['payment'] == 1){
                        $order_id = $order->id;
                    } else {
                        return $this->redirect('thanks');
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('frontend/flash', 'Order placement error'));
                }
            }
        }
        return $this->render('view', compact(
            'session',
            'order',
            'user',
            'order_id',
            'productList'
        ));
    }

    protected function saveOrderItems($items, $order_id)
    {
        $language = Yii::$app->language;
        for ($x = 0; $x <= count($items); $x++) {
            if (isset($items[$x]) && !empty($items[$x])) {
                $id = $items[$x]['id'];
                $qty = $items[$x]['qty'];
                $product = Products::findOne($id);

                $language_id = Languages::findOne(['code' => $language])->id;
                $content_id = Content::findOne(['content' => 'name'])->id;
                $type_id = Type::findOne(['type' => 'products'])->id;
                $product->content_id = $content_id;
                $product->language_id = $language_id;
                $product->type_id = $type_id;

                $name = $product->translation->content;;

                $order_item = new OrdersItems();
                $order_item->order_id = $order_id;
                $order_item->product_id = $id;
                $order_item->name = $name;
                $order_item->img = $product->img;
                $order_item->slug = $product->slug;
                $order_item->price = $product->price;
                $order_item->qty_item = $qty;
                $order_item->sum_item = $qty * $product->price;
                $order_item->save();
            }
        }
    }

    public function actionPayment($id)
    {
        $public_key = Yii::$app->params['liqpay_public_key'];
        $private_key = Yii::$app->params['liqpay_private_key'];
        $result_url = Yii::$app->params['liqpay_result_url'];
        $server_url = Yii::$app->params['liqpay_server_url'];

        $language = Yii::$app->language;

        $order = Orders::findOne($id);

        $liqpay = new LiqPay($public_key, $private_key);


        $html = $liqpay->cnb_form(array(
            'action' => 'pay',
            'amount' => $order->sum,
            'currency' => 'UAH',
            'language' => $language,
            'description' => 'Покупка № ' . $order->id,
            'order_id' => $order->id,
            'version' => '3',
            'paytypes' => 'card',
            'result_url' => $result_url,
            //'server_url' => $server_url,
        ));

        $array = array(
            'action' => 'pay',
            'amount' => $order->sum,
            'currency' => 'UAH',
            'public_key' => $public_key,
            'language' => $language,
            'description' => 'Покупка № ' . $order->id,
            'order_id' => $order->id,
            'version' => '3',
            'paytypes' => 'card',
            'result_url' => $result_url,
            //'server_url' => $server_url,
        );

        $data = base64_encode(json_encode($array));;

        $signature = $liqpay->cnb_signature($array);

        $this->layout = false;

        return $this->render('payment', compact('order', 'html', 'data', 'signature'));
    }

    public function actionThanks()
    {
        $language = Yii::$app->language;

        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');

        $this->setMeta(null, null, null, 'Магазин | Спасибо');

        return $this->render('thanks');
    }
}
