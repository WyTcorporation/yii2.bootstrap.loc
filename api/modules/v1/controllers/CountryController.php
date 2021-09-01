<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country';

    protected function verbs() {
        $verbs = parent::verbs();
        $verbs =  [
            'index' => ['GET', 'POST', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH']
        ];
        return $verbs;
    }

    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $result = $modelClass::find()
            ->where(['>', 'population', 70000000])
            ->all();
        return $result;
    }

    public function actionNew2()
    {
        $modelClass = $this->modelClass;
        $result = $modelClass::find()
            ->where(['>', 'population', 70000000])
            ->all();
        return $result;
    }

    public function actionNew()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $query = $modelClass::find();
        if (!empty($filter)) {
            $query->andWhere($filter);
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }
}


