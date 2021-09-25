<?php

namespace backend\controllers\products;

use backend\controllers\AppAdminController;
use Yii;
use backend\models\products\ProductsComments;
use backend\models\products\ProductsCommentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsCommentsController implements the CRUD actions for ProductsComments model.
 */
class ProductsCommentsController extends AppAdminController
{
    protected function isModerActive()
    {
        $actions =  [];
        return $this->isModer($actions);
    }

    /**
     * Lists all ProductsComments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];;

        $searchModel = new ProductsCommentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_id' => $type_products_id,
        ]);
    }

    /**
     * Displays a single ProductsComments model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_id' => $type_products_id,
        ]);
    }

    /**
     * Creates a new ProductsComments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsComments();

        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_id' => $type_products_id,
        ]);
    }

    /**
     * Updates an existing ProductsComments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //dd(Yii::$app->request->post());
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_id' => $type_products_id,
        ]);
    }

    /**
     * Deletes an existing ProductsComments model.
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
     * Finds the ProductsComments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsComments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsComments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
