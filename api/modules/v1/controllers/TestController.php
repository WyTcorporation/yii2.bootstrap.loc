<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 28.08.2021
 */

namespace api\modules\v1\controllers;

use backend\models\Category;
use yii\rest\ActiveController;

class TestController extends ActiveController
{

    public $modelClass = '@backend\models\Category';

    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $result = $modelClass::find()
            ->all();
        return $result;
    }

}