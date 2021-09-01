<?php

namespace backend\controllers;

use Yii;
use backend\controllers\AppAdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Chat;
use common\models\User;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CalculatorController extends AppAdminController
{

    protected function isModerActive()
    {
        $actions =  ['calculator'];
        return $this->isModer($actions);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionCalculator()
    {

        return $this->render('calculator');
    }
    public function actionIndex()
    {

        return $this->render('index');
    }

}
