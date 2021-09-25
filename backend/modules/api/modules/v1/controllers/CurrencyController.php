<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 06.09.2021
 * Time: 20:00
 * User: WyTcorporation
 */

namespace backend\modules\api\modules\v1\controllers;


use backend\controllers\AppAdminController;
use common\models\Currency;
use yii\web\Controller;
use yii\helpers\Json;
use Yii;
use yii\web\Response;

class CurrencyController extends Controller
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
                    'Access-Control-Request-Method' => ['POST', 'GET','PUT',"DELETE"],
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

            $currency = Currency::find()->where(['code'=>$data['value']])->asArray()->one();

            $session = Yii::$app->session;
            $session['currency'] = $currency;

            return ["code" => 200, "message" => "OK", 'data' => $session['currency']];
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'callBack-v1');
            print Json::encode($errors);
        }

    }

}
