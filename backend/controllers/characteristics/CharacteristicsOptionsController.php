<?php

namespace backend\controllers\characteristics;

use backend\controllers\AppAdminController;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use Yii;
use backend\models\characteristics\CharacteristicsOptions;
use backend\models\characteristics\CharacteristicsOptionsSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CharacteristicsOptionsController implements the CRUD actions for CharacteristicsOptions model.
 */
class CharacteristicsOptionsController extends AppAdminController
{
    public $type = 'characteristics-options';

    protected function isModerActive()
    {
        $actions =  [];
        return $this->isModer($actions);
    }

    /**
     * Lists all CharacteristicsOptions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_characteristics_options_id =  $params['type']['type_characteristics_options_id'];
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        $searchModel = new CharacteristicsOptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_characteristics_id' => $type_characteristics_id,
            'type_characteristics_options_id' => $type_characteristics_options_id,
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
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_characteristics_options_id =  $params['type']['type_characteristics_options_id'];
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        return $this->render('view', [
            'model' => $this->findModel($id),
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_characteristics_id' => $type_characteristics_id,
            'type_characteristics_options_id' => $type_characteristics_options_id,
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

        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_characteristics_options_id =  $params['type']['type_characteristics_options_id'];
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        $params = $params['params'];

        $translation = new Translations();

        $type_id = $type_characteristics_id;

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

        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'type_id' => $type_id,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'translation' => $translation,
            'translations' => $translations = null,
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

        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_characteristics_options_id =  $params['type']['type_characteristics_options_id'];
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        $params = $params['params'];

        $translation = new Translations();

        $type_id = $type_characteristics_id;

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
            'type_id' => $type_id,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'translation' => $translation,
            'translations' => $translations,
            'type_characteristics_options_id' => $type_characteristics_options_id,
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

        throw new NotFoundHttpException(Yii::t('app/error', 'The requested page does not exist.'));
    }
}
