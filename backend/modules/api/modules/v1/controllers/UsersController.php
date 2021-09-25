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
use backend\models\user\User;
use Yii;
use yii\helpers\Json;
use yii\web\Response;

class UsersController extends AppAdminController

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

            $getUsers = User::find()->where(['like', 'username', '%' . $q . '%', false])->asArray()->all();

            for ($x = 0; $x <= count($getUsers); $x++) {
                if ($getUsers[$x]['username'] != null) {
                    $Users[$x]['id'] = $getUsers[$x]['id'];
                    $Users[$x]['text'] = $getUsers[$x]['username'];

                }
            }

            return ['results' => $Users];
            //return Json::encode(["code"=>200,"message"=>"OK",'data'=>$category]);
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'users-v1');
            print Json::encode($errors);
        }

    }
}