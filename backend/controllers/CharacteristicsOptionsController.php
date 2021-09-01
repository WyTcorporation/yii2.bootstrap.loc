<?php

namespace backend\controllers;

use Yii;
use backend\models\CharacteristicsOptions;
use backend\models\CharacteristicsOptionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CharacteristicsOptionsController implements the CRUD actions for CharacteristicsOptions model.
 */
class CharacteristicsOptionsController extends Controller
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
     * Lists all CharacteristicsOptions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CharacteristicsOptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $params = Yii::$app->params['languages'];

        $language = Yii::$app->sourceLanguage;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
            'language' => $language,
        ]);
    }

    /**
     * Displays a single CharacteristicsOptions model.
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
     * Creates a new CharacteristicsOptions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CharacteristicsOptions();

        $params = Yii::$app->params['languages'];

        $language = Yii::$app->sourceLanguage;

        if ($model->load(Yii::$app->request->post())) {

            if (count($params) >= 1) {
                $names = $model->name;
                $characteristics_id = $model->characteristics_id;

                for ($i = 0; $i < count($names[$language]); $i++) {
                    foreach ($params as $value) {
                        if ($names[$value][$i]) {
                            $results[$i]['name'][$value] = trim($names[$value][$i]);
                        }
                    }
                }

                if (isset($results) && !empty($results)) {
                    foreach ($results as $result) {
                        $newCharacteristics = new CharacteristicsOptions();
                        $newCharacteristics->name = serialize($result['name']);
                        $newCharacteristics->characteristics_id = $characteristics_id;
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
     * Updates an existing CharacteristicsOptions model.
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
                $characteristics_id = $model->characteristics_id;

                for ($i = 0; $i < count($names[$language]); $i++) {
                    foreach ($params as $value) {
                        if ($names[$value][$i]) {
                            $results[$i]['name'][$value] = trim($names[$value][$i]);
                        }
                    }
                }

                if (isset($results) && !empty($results)) {
                    foreach ($results as $key=>$result) {
                        if($key === 0) {
                            $newCharacteristics = CharacteristicsOptions::findOne($model->id);
                        } else {
                            $newCharacteristics = new CharacteristicsOptions();
                        }
                        $newCharacteristics->name = serialize($result['name']);
                        $newCharacteristics->characteristics_id = $characteristics_id;
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
     * Deletes an existing CharacteristicsOptions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CharacteristicsOptions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CharacteristicsOptions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CharacteristicsOptions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
