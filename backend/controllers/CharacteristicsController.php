<?php

namespace backend\controllers;

use backend\models\CharacteristicsOptions;
use backend\models\CharacteristicsProducts;
use Yii;
use backend\models\Characteristics;
use backend\models\CharacteristicsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CharacteristicsController implements the CRUD actions for Characteristics model.
 */
class CharacteristicsController extends AppAdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Characteristics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CharacteristicsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Characteristics model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $params = Yii::$app->params['languages'];

        $language = Yii::$app->sourceLanguage;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'params' => $params,
            'language' => $language,
        ]);
    }

    /**
     * Creates a new Characteristics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Characteristics();

        $params = Yii::$app->params['languages'];

        $language = Yii::$app->sourceLanguage;

        if ($model->load(Yii::$app->request->post())) {

            if (count($params) >= 1) {
                $names = $model->name;
                $filter_status = $model->filter_status;

                for ($i = 0; $i < count($names[$language]); $i++) {
                    foreach ($params as $value) {
                        if ($names[$value][$i]) {
                            $results[$i]['status'] = $filter_status[$i];
                            $results[$i]['name'][$value] = trim($names[$value][$i]);
                        }
                    }
                }

                if (isset($results) && !empty($results)) {
                    foreach ($results as $result) {
                        $newCharacteristics = new Characteristics();
                        $newCharacteristics->name = serialize($result['name']);
                        $newCharacteristics->filter_status = $result['status'];
                        $newCharacteristics->save();
                    }
                }
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'language' => $language,
        ]);
    }

    /**
     * Updates an existing Characteristics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $params = Yii::$app->params['languages'];

        $language = Yii::$app->sourceLanguage;

        if ($model->load(Yii::$app->request->post())) {
            if (count($params) >= 1) {
                $names = $model->name;
                $filter_status = $model->filter_status;

                for ($i = 0; $i < count($names[$language]); $i++) {
                    foreach ($params as $value) {
                        if ($names[$value][$i]) {
                            $results[$i]['status'] = $filter_status[$i];
                            $results[$i]['name'][$value] = trim($names[$value][$i]);
                        }
                    }
                }

                if (isset($results) && !empty($results)) {
                    foreach ($results as $key=>$result) {
                        if($key === 0) {
                            $newCharacteristics = Characteristics::findOne($model->id);
                        } else {
                            $newCharacteristics = new Characteristics();
                        }
                        $newCharacteristics->name = serialize($result['name']);
                        $newCharacteristics->filter_status = $result['status'];
                        $newCharacteristics->save();
                    }
                }
            }

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'params' => $params,
            'language' => $language,
        ]);
    }

    /**
     * Deletes an existing Characteristics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $optionsProducts = CharacteristicsOptions::find()->where(['characteristics_id' => $id])->all();

        foreach ($optionsProducts as $optionsProduct) {
            foreach ($optionsProduct->characteristicsProducts as $characteristicsProduct){
                $characteristicsProduct->delete();
            }
            $optionsProduct->delete();
        }

        $this->findModel($id)->delete();


        return $this->redirect(['index']);
    }

    /**
     * Finds the Characteristics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Characteristics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Characteristics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
