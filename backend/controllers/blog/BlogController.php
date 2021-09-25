<?php

namespace backend\controllers\blog;

use backend\controllers\AppAdminController;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use Yii;
use backend\models\blog\Blog;
use backend\models\blog\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends AppAdminController
{
    public $type = 'blog';

    protected function isModerActive()
    {
        $actions =  [];
        return $this->isModer($actions);
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_blog_id =  $params['type']['type_blog_id'];

        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_blog_id' => $type_blog_id,
        ]);
    }

    /**
     * Displays a single Blog model.
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
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();

        $params = $this->getParams();
        $language = $params['language'];

        $params = $params['params'];

        if ($model->load(Yii::$app->request->post())) {
            $translationInput = Yii::$app->request->post('Translations');
            $model->name = $translationInput['field_name'][$language];
            $model->save();
            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, $this->type);
            Yii::$app->session->setFlash('success', 'Данные обновлены!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'translations' => $translations = null,
        ]);
    }

    /**
     * Updates an existing Blog model.
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

        $params = $params['params'];

        $translations = $this->getTranslationsList($model->id, $this->type);

        if ($model->load(Yii::$app->request->post())) {
            $translationInput = Yii::$app->request->post('Translations');
            $model->name = $translationInput['field_name'][$language];
            $model->save();
            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, $this->type);
            Yii::$app->session->setFlash('success', 'Данные обновлены!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'params' => $params,
            'language' => $language,
            'translations' => $translations,
        ]);
    }

    /**
     * Deletes an existing Blog model.
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
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
