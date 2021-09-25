<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 06.09.2021
 * Time: 17:53
 * User: WyTcorporation
 */

namespace backend\modules\api\modules\v1\controllers;

use backend\controllers\AppAdminController;
use backend\models\callback\CallBack;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\helpers\Json;
use Yii;
use yii\web\Response;

class CallBackController extends Controller

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

    protected function Params()
    {
        $params = Yii::$app->params['languages'];
        $language = Yii::$app->sourceLanguage;
        return ['params' => $params, 'languages' => $language];
    }

    public function actionIndex()
    {

        try {
            $data = Yii::$app->request->post();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $telephone = $data['telephone'];

            $product = $data['product'];

            $callBack = new CallBack();
            $callBack->telephone = (string)$telephone;
            if (!$product && $product == '') {
                $callBack->product_name = 'Обратный звонок';
            } else {
                $callBack->product_name = $product;
            }

            $callBack->save();

            return ["code" => 200, "message" => "OK", 'data' => $callBack];
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'callBack-v1');
            print Json::encode($errors);
        }

    }

    public function actionSearch($q = null, $id = null, $type = null)
    {

        try {
            $data = Yii::$app->request->post();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $getCallBack = CallBack::find()->where(['like', 'product_name', '%' . $q . '%', false])->asArray()->all();

            for ($x = 0; $x <= count($getCallBack); $x++) {
                if ($getCallBack[$x]['product_name'] != null) {
                    $CallBack[$x]['id'] = $getCallBack[$x]['id'];
                    $CallBack[$x]['text'] = $getCallBack[$x]['product_name'];

                }
            }

            return ['results' => $CallBack];
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'callBack-v1');
            print Json::encode($errors);
        }

    }
}