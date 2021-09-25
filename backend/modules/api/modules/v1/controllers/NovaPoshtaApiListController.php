<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 08.09.2021
 * Time: 10:37
 * User: WyTcorporation
 */

namespace backend\modules\api\modules\v1\controllers;

use backend\controllers\AppAdminController;
use backend\models\np\NpCities;
use backend\models\np\NpRegion;
use backend\models\np\NpWarehouses;
use LisDev\Delivery\NovaPoshtaApi2;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\helpers\Json;
use Yii;
use yii\web\Response;


class NovaPoshtaApiListController extends Controller

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

    public function actionRegions($q = null, $id = null, $type = null)
    {

        try {
            $data = Yii::$app->request->get();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $language = Yii::$app->language;

            $params = Yii::$app->params['languages'];

//            $novaposhtaApiKey = Yii::$app->params['novaposhtaApiKey'];
//            //https://github.com/lis-dev/nova-poshta-api-2
//            $np = new NovaPoshtaApi2(
//                $novaposhtaApiKey,
//                $language, // Язык возвращаемых данных: ru (default) | ua | en
//                FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
//                'curl' // Используемый механизм запроса: curl (defalut) | file_get_content
//            );
//
//            $getAreas = $np->getAreas();
//
//            foreach ($params as $key => $value) {
//                for ($x = 0; $x <= count($getAreas['data']); $x++) {
//                    if ($getAreas['data'][$x]['Description'] != null) {
//                        if ('ua' == $value) {
//                            $Areas[$x]['name'][$value] = $getAreas['data'][$x]['Description'];
//                        } else {
//                            $Areas[$x]['name'][$value] = $getAreas['data'][$x]['DescriptionRu'];
//                        }
//                        $Areas[$x]['Ref'] = $getAreas['data'][$x]['Ref'];
//                        $Areas[$x]['AreasCenter'] = $getAreas['data'][$x]['AreasCenter'];
//                    }
//                }
//            }
//
//            foreach ($Areas as $Area) {
//                $areasNews = new NpRegion();
//                $areasNews->name = serialize($Area['name']);
//                $areasNews->Ref = $Area['Ref'];
//                $areasNews->AreasCenter = $Area['AreasCenter'];
//                $areasNews->save();
//            }

            $getAreas = NpRegion::find()->where(['like', 'name', '%' . $q . '%', false])->asArray()->all();

            for ($x = 0; $x <= count($getAreas); $x++) {
                if ($getAreas[$x]['name'] != null) {
                    $Areas[$x]['id'] = $getAreas[$x]['Ref'];
                    if (unserialize($getAreas[$x]['name'])[$language] == null) {
                        $Areas[$x]['text'] = unserialize($getAreas[$x]['name'])[$language];
                    } else {
                        $Areas[$x]['text'] = unserialize($getAreas[$x]['name'])[Yii::$app->sourceLanguage];
                    }
                }
            }

            return ['results' => $Areas];
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'callBack-v1');
            print Json::encode($errors);
        }
    }


    public function actionCities($q = null, $id = null, $name = null)
    {

        try {
            $data = Yii::$app->request->get();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $language = Yii::$app->language;

            $params = Yii::$app->params['languages'];

//            set_time_limit(500);
//
//            $novaposhtaApiKey = Yii::$app->params['novaposhtaApiKey'];
//            //https://github.com/lis-dev/nova-poshta-api-2
//            $np = new NovaPoshtaApi2(
//                $novaposhtaApiKey,
//                $language, // Язык возвращаемых данных: ru (default) | ua | en
//                FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
//                'curl' // Используемый механизм запроса: curl (defalut) | file_get_content
//            );
//           // $getCities = $np->getCity($q,$type);
//
//            $getCities = $np->getCities();
//
//                        foreach ($params as $key => $value) {
//                for ($x = 0; $x <= count($getCities['data']); $x++) {
//                    if ($getCities['data'][$x]['Description'] != null) {
//                        if ('ua' == $value) {
//                            $Cities[$x]['name'][$value] = is_array(explode(' ',$getCities['data'][$x]['Description'])) ? explode(' ',$getCities['data'][$x]['Description'])[0] : $getCities['data'][$x]['Description'];
//                        } else {
//                            $Cities[$x]['name'][$value] = is_array(explode(' ',$getCities['data'][$x]['DescriptionRu'])) ? explode(' ',$getCities['data'][$x]['DescriptionRu'])[0] : $getCities['data'][$x]['DescriptionRu'];
//                        }
//                        $Cities[$x]['Ref'] = $getCities['data'][$x]['Ref'];
//                        $Cities[$x]['Region'] = $getCities['data'][$x]['Area'];
//                    }
//                }
//            }
//
//            foreach ($Cities as $Citie) {
//                $areasNews = new NpCities();
//                $areasNews->name = serialize($Citie['name']);
//                $areasNews->Ref = $Citie['Ref'];
//                $areasNews->Region = $Citie['Region'];
//                $areasNews->save();
//            }

            $getCities = NpCities::find()->where(['like', 'name', '%' . $q . '%', false])->andWhere(['Region' => $id])->asArray()->all();

            for ($x = 0; $x <= count($getCities); $x++) {
                if ($getCities[$x]['name'] != null) {
                    $Cities[$x]['id'] = $getCities[$x]['Ref'];
                    if (unserialize($getCities[$x]['name'])[$language] == null) {
                        $Cities[$x]['text'] = unserialize($getCities[$x]['name'])[$language];
                    } else {
                        $Cities[$x]['text'] = unserialize($getCities[$x]['name'])[Yii::$app->sourceLanguage];
                    }
                }
            }

            return ['results' => $Cities];
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'callBack-v1');
            print Json::encode($errors);
        }
    }

    public function actionWarehouses($q = null, $region_id = null, $region_name = null, $city_id = null, $city_name = null)
    {

        try {
            $data = Yii::$app->request->post();

            Yii::$app->response->format = Response::FORMAT_JSON;

            $language = Yii::$app->language;

            $params = Yii::$app->params['languages'];

            set_time_limit(500);

            $novaposhtaApiKey = Yii::$app->params['novaposhtaApiKey'];
            //https://github.com/lis-dev/nova-poshta-api-2
            $np = new NovaPoshtaApi2(
                $novaposhtaApiKey,
                $language, // Язык возвращаемых данных: ru (default) | ua | en
                FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
                'curl' // Используемый механизм запроса: curl (defalut) | file_get_content
            );

//            $sender_city = $np->getCity('Белгород-Днестровский', 'Одесская');
            $city = $np->getCity($city_name, $region_name);
            $getWarehouses = $np->getWarehouses($city['data'][0]['Ref']);

            $status = false;
            for ($x = 0; $x <= count($getWarehouses['data']); $x++) {
                $test = NpWarehouses::findOne(['CityRef' => $getWarehouses['data'][$x]['CityRef']]);
                if (isset($test) && !empty($test)) {
                    $status = true;
                    break;
                }
            }

            if ($status == false) {
                foreach ($params as $key => $value) {
                    for ($x = 0; $x <= count($getWarehouses['data']); $x++) {
                        if ($getWarehouses['data'][$x]['Description'] != null) {
                            if ('ua' == $value) {
                                $Warehouse[$x]['name'][$value] = $getWarehouses['data'][$x]['Description'];
                            } else {
                                $Warehouse[$x]['name'][$value] = $getWarehouses['data'][$x]['DescriptionRu'];
                            }
                            $Warehouse[$x]['Ref'] = $getWarehouses['data'][$x]['Ref'];
                            $Warehouse[$x]['CityRef'] = $getWarehouses['data'][$x]['CityRef'];
                        }
                    }
                }
                foreach ($Warehouse as $Warehouses) {
                    $areasNews = new NpWarehouses();
                    $areasNews->name = serialize($Warehouses['name']);
                    $areasNews->Ref = $Warehouses['Ref'];
                    $areasNews->CityRef = $Warehouses['CityRef'];
                    $areasNews->save();
                }
                $status = true;
            }

            if ($status == true) {
                $getWarehouses = NpWarehouses::find()->where(['like', 'name', '%' . $q . '%', false])->andWhere(['CityRef' => $city_id])->asArray()->all();
                for ($x = 0; $x <= count($getWarehouses); $x++) {
                    if ($getWarehouses[$x]['name'] != null) {
                        $Warehouses[$x]['id'] = $getWarehouses[$x]['Ref'];
                        if (unserialize($getWarehouses[$x]['name'])[$language] == null) {
                            $Warehouses[$x]['text'] = unserialize($getWarehouses[$x]['name'])[$language];
                        } else {
                            $Warehouses[$x]['text'] = unserialize($getWarehouses[$x]['name'])[Yii::$app->sourceLanguage];
                        }
                    }
                }
            }

            return ['results' => $Warehouses];
        } catch (\Exception $e) {
            $errors = ['message' => $e->getMessage(), 'code' => $e->getCode(), 'line' => $e->getLine(), 'file' => $e->getFile(), 'data' => \Yii::$app->request->get()];
            \Yii::error($errors, 'callBack-v1');
            print Json::encode($errors);
        }
    }
}