<?php

namespace backend\controllers\pages;

use backend\controllers\AppAdminController;
use backend\models\translations\Translations;
use Yii;
use backend\models\pages\Pages;
use backend\models\pages\PagesSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends AppAdminController
{

    public $type = 'pages';

    protected function isModerActive()
    {
        $actions = [];
        return $this->isModer($actions);
    }

    /**
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_pages_id = $params['type']['type_pages_id'];

        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_pages_id' => $type_pages_id,
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $params = $this->getParams();
        $language = $params['language'];
        $content = $this->getTranslationsList($id,$this->type);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'language' => $language,
            'content' => $content
        ]);
    }

    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();

        $params = $this->getParams();
        $language = $params['language'];

        $params = $params['params'];

        $translation = new Translations();

        if ($model->load(Yii::$app->request->post())) {

            $translationInput = Yii::$app->request->post('Translations');
            $model->name = $translationInput['field_name'][$language];
            $model->save();

            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, $this->type);
            if ($result) {
                Yii::$app->session->setFlash('success',  Yii::t('backend/flash', 'Created!'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error!'));
            }
        }

        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'translation' => $translation,
            'translations' => $translations = null,
        ]);
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $translation = new Translations();

        $params = $this->getParams();
        $language = $params['language'];
        $type = $params['type']['type_pages_id'];
        $params = $params['params'];
        $model->type_id = $type;

        $translations = $this->getTranslationsList($model->id, $this->type);

        foreach ($params as $key => $value) {
            $field_name[$value] = $translations[$value]['name']->content;
            $field_content[$value] = $translations[$value]['content']->content;
            $field_keywords[$value] = $translations[$value]['keywords']->content;
            $field_description[$value] = $translations[$value]['description']->content;
        }
        $translation->field_name = $field_name;
        $translation->field_content = $field_content;
        $translation->field_keywords = $field_keywords;
        $translation->field_description = $field_description;

        if ($model->load(Yii::$app->request->post())) {
            $translationInput = Yii::$app->request->post('Translations');
            $model->name = $translationInput['field_name'][$language];
            $model->save();

            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, $this->type);
            if ($result) {
                Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Created!'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error!'));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'params' => $params,
            'language' => $language,
            'translation' => $translation,
            'translations' => $translations,

        ]);
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/pages/index']);
    }

    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/error', 'The requested page does not exist.'));
    }
}
