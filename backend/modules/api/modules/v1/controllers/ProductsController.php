<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 25.09.2021
 * Time: 09:14
 * User: WyTcorporation, WyTcorp, WyTco
 */

namespace backend\modules\api\modules\v1\controllers;


use backend\controllers\AppAdminController;
use backend\models\translations\Translations;
use backend\models\products\Products;
use Yii;
use yii\helpers\Json;
use yii\web\Response;

class ProductsController extends AppAdminController

{

    public $enableCsrfValidation = false;

    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            // For cross-domain AJAX request
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to domains:
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Allow-Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', "DELETE"],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
                ],
            ],
        ]);
    }


    public function actionIndex($q = null, $id = null, $type = null)
    {

        try {
            $data = Yii::$app->request->post();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $params = $this->getParams();
            $language_id = $params['language_id'];
            $content_id = $params['content_id'];
            $type_products_id = $params['type']['type_products_id'];

            $getProducts = Translations::find()->where(['like', 'content', '%' . $q . '%', false])->andWhere(['language_id'=>$language_id,'content_id'=>$content_id,'type_id'=>$type_products_id])->asArray()->all();

            for ($x = 0; $x <= count($getProducts); $x++) {
                if ($getProducts[$x]['content'] != null) {
                    $Products[$x]['id'] = $getProducts[$x]['translation_id'];
                    $Products[$x]['text'] = $getProducts[$x]['content'];
                }
            }

            return ['results' => $Products];
            //return Json::encode(["code"=>200,"message"=>"OK",'data'=>$category]);
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'users-v1');
            print Json::encode($errors);
        }
    }

    public function actionGetProduct($id,$name)
    {

        try {
            $data = Yii::$app->request->post();

            Yii::$app->response->format = Response::FORMAT_JSON;


            $getProduct = Products::findOne($id);

            $Product['product_id'] =$id;
            $Product['name'] =$name;
            $Product['img'] =$getProduct->img;
            $Product['slug'] =$getProduct->slug;
            $Product['price'] =$getProduct->price;

            return $Product;
            //return Json::encode(["code"=>200,"message"=>"OK",'data'=>$category]);
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'users-v1');
            print Json::encode($errors);
        }
    }
}