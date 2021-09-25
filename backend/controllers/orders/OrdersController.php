<?php

namespace backend\controllers\orders;

use backend\controllers\AppAdminController;
use backend\models\orders\OrdersItems;
use backend\models\products\Products;
use Yii;
use backend\models\orders\Orders;
use backend\models\orders\OrdersSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends AppAdminController
{
    protected function isModerActive()
    {
        $actions = [];
        return $this->isModer($actions);
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id = $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];


        $OrdersItems = new  OrdersItems();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $products = Yii::$app->request->post('products');

            $orders_id = $model->id;
            if (isset($products) && !empty($products)) {
                $products = array_values($products);
                for ($x = 0; $x <= count($products); $x++) {
                    if (isset($products[$x]) && !empty($products[$x])) {
                        $OrdersItems = new  OrdersItems();
                        $product = Products::findOne($products[$x]['product_id']);
                        $product->language_id = $language_id;
                        $product->content_id = $content_id;
                        $product->type_id = $type_products_id;
                        $OrdersItems->order_id = $orders_id;
                        $OrdersItems->product_id = $product->id;
                        $OrdersItems->name = $product->translation->content;
                        $OrdersItems->img = $product->img;
                        $OrdersItems->slug = $product->slug;
                        $OrdersItems->price = $product->price;
                        $OrdersItems->qty_item = (int)$products[$x]['qty_item'];
                        $OrdersItems->sum_item = (int)$products[$x]['qty_item'] * (int)$product->price;
                        $OrdersItems->save();
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Created!'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
            Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error!'));
        }

        return $this->render('create', [
            'model' => $model,
            'OrdersItems' => $OrdersItems,
        ]);
    }

    /**
     * Updates an existing Orders model.
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
        $content_id = $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];

        $OrdersItems = new  OrdersItems();

        if ($model->load(Yii::$app->request->post())) {

            $model->save();
            $products = Yii::$app->request->post('products');

            $orders_id = $model->id;
            if (isset($products) && !empty($products)) {
                $products = array_values($products);
                for ($x = 0; $x <= count($products); $x++) {
                    if (isset($products[$x]) && !empty($products[$x])) {
                        $OrdersItems = OrdersItems::findOne(['product_id'=>$products[$x]['product_id'],'order_id'=>$orders_id]);
                        if (!isset($OrdersItems) && empty($OrdersItems)) {
                            $OrdersItems = new OrdersItems();
                        }
                        $product = Products::findOne($products[$x]['product_id']);
                        $product->language_id = $language_id;
                        $product->content_id = $content_id;
                        $product->type_id = $type_products_id;
                        $OrdersItems->order_id = $orders_id;
                        $OrdersItems->product_id = $product->id;
                        $OrdersItems->name = $product->translation->content;
                        $OrdersItems->img = $product->img;
                        $OrdersItems->slug = $product->slug;
                        $OrdersItems->price = $product->price;
                        $OrdersItems->qty_item = (int)$products[$x]['qty_item'];
                        $OrdersItems->sum_item = (int)$products[$x]['qty_item'] * (int)$product->price;
                        $OrdersItems->save();
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Created!'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
            Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error!'));
        }

        return $this->render('update', [
            'model' => $model,
            'OrdersItems' => $OrdersItems,
        ]);
    }

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/error', 'The requested page does not exist.'));
    }
}
