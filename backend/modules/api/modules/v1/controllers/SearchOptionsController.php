<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 28.08.2021
 */

namespace backend\modules\api\modules\v1\controllers;


use backend\controllers\AppAdminController;
use backend\models\CharacteristicsOptions;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\helpers\Json;
use Yii;
use yii\web\Response;

class SearchOptionsController extends Controller

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
                    'Access-Control-Request-Method' => ['POST', 'GET'],
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
            $data = Yii::$app->request->get();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $params = Yii::$app->params['languages'];

            $language = Yii::$app->sourceLanguage;

            $characteristicsOptions = CharacteristicsOptions::find()->where(['characteristics_id'=>$data['id']])->all();

            foreach ($characteristicsOptions as $characteristicsOption) {
                $array[$characteristicsOption->id] = unserialize($characteristicsOption->name)[$language];
            }

//            return Json::encode(["code" => 200, "message" => "OK", 'data' => $data['id']]);
            return $array;
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'statistics-v1');
            print Json::encode($errors);
        }

    }

}