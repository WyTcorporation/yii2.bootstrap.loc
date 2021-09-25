<?php

namespace backend\controllers\characteristics;

use backend\controllers\AppAdminController;
use backend\models\characteristics\CharacteristicsOptions;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use backend\models\translations\Type;
use Yii;
use backend\models\characteristics\Characteristics;
use backend\models\characteristics\CharacteristicsSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CharacteristicsController implements the CRUD actions for Characteristics model.
 */
class CharacteristicsController extends AppAdminController
{
    public $type = 'characteristics';

    protected function isModerActive()
    {
        $actions =  [];
        return $this->isModer($actions);
    }

    /**
     * Lists all Characteristics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        $searchModel = new CharacteristicsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_characteristics_id' => $type_characteristics_id,
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

        $params = $this->getParams();
        $language = $params['language'];
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        return $this->render('view', [
            'model' => $this->findModel($id),
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_characteristics_id' => $type_characteristics_id,
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

        $params = $this->getParams();
        $params = $params['params'];

        $translation = new Translations();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $translationInput = Yii::$app->request->post('Translation');
            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput,$translation_id,$this->type);
            if ($result) {
                Yii::$app->session->setFlash('success', 'Создана!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }
        $translations = null;
        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'translation' => $translation,
            'translations' => $translations,
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

        $params = $this->getParams();
        $language = $params['language'];
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        $params = $params['params'];

        $translation = new Translations();

        $translations = $this->getTranslationsList($model->id,$this->type);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $translationInput = Yii::$app->request->post('Translation');
            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput,$translation_id,$this->type);
            if ($result) {
                Yii::$app->session->setFlash('success', 'Создана!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'params' => $params,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_characteristics_id' => $type_characteristics_id,
            'translation' => $translation,
            'translations' => $translations,
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

        throw new NotFoundHttpException(Yii::t('app/error', 'The requested page does not exist.'));
    }
}
