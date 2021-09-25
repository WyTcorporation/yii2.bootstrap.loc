<?php

namespace backend\controllers\products;

use backend\controllers\AppAdminController;
use backend\models\translations\Translations;
use Yii;
use backend\models\products\ProductsModels;
use backend\models\products\ProductsModelsSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsModelsController implements the CRUD actions for ProductsModels model.
 */
class ProductsModelsController extends AppAdminController
{
    public $type = 'products-models';

    protected function isModerActive()
    {
        $actions =  [];
        return $this->isModer($actions);
    }
    /**
     * Lists all ProductsModels models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_products_models_id = $params['type']['type_products_models_id'];;


        $searchModel = new ProductsModelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_models_id' => $type_products_models_id,
        ]);
    }

    /**
     * Displays a single ProductsModels model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_products_models_id = $params['type']['type_products_models_id'];

        return $this->render('view', [
            'model' => $this->findModel($id),
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_models_id' => $type_products_models_id,
        ]);
    }

    /**
     * Creates a new ProductsModels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsModels();

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

        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'translation' => $translation,
        ]);
    }

    /**
     * Updates an existing ProductsModels model.
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
        $type_products_models_id = $params['type']['type_products_models_id'];

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
            'type_products_models_id' => $type_products_models_id,
            'translation' => $translation,
            'translations' => $translations,
        ]);
    }

    /**
     * Deletes an existing ProductsModels model.
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
     * Finds the ProductsModels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsModels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsModels::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
