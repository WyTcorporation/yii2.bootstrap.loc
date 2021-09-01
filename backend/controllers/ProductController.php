<?php

namespace backend\controllers;

use backend\models\Characteristics;
use backend\models\CharacteristicsProducts;
use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\controllers\AppAdminController;
use yii\base\Security;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AppAdminController
{

    protected function isModerActive()
    {
        $actions = [];
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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isPjax) {
            $data = Yii::$app->request->post('Product');

            foreach ($data as $item) {
                if (isset($item['change']) && !empty($item['change'])) {
                    $product = Product::findOne((int)$item['change']);
                    $product->name = $item['name'];
                    $product->price = (float)$item['price'];
                    $product->hit = $item['hit'];
                    $product->new = $item['new'];
                    $product->sale = $item['sale'];
                    if (isset($item['category_id'])) {
                        $product->category_id = (int)$item['category_id'];
                    };
                    $product->save();

                }
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchSession()
    {
        $name = '';
        $price = '';

        //Открываем сессию (нужна что бы после перехода на след страницу фильтр не сбрасывался)
        $session = Yii::$app->session;
        $session->open();

        $query = Product::find()->orderBy('id ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1,
            ],
        ]);

        if (Yii::$app->request->isPjax) {
            $data = Yii::$app->request->post();


            if (isset($data['reset']) && !empty($data['reset'])) {
                $name = '';
                $price = '';
                unset($_SESSION['name']);
                unset($_SESSION['price']);
            }

            if (isset($data['name']) && !empty($data['name'])) {
                $name = $data['name'];
                $_SESSION['name'] = $name;
            } elseif (!empty($data)) {
                unset($_SESSION['name']);
            }
            if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                $name = $_SESSION['name'];
            }

            if (isset($data['price']) && !empty($data['price'])) {
                $price = $data['price'];
                $_SESSION['price'] = $price;
            } elseif (!empty($data)) {
                unset($_SESSION['price']);
            }
            if (isset($_SESSION['price']) && !empty($_SESSION['price'])) {
                $price = $_SESSION['price'];
            }

            $query = Product::find()->orderBy('id ASC');

            if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                $query->andWhere(['like', 'name', $name]);
            }

            if (isset($_SESSION['price']) && !empty($_SESSION['price'])) {
                $query->andWhere(['like', 'price', $price]);
            }

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 1,
                ],
            ]);
        }
        return $this->render('search-session', compact('dataProvider', 'name', 'price'));
    }


    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $paramsLanguages = $this->getParamsLanguages();

        $params = Yii::$app->params['languages'];

        $language = Yii::$app->sourceLanguage;

        $model = new Product();

        $characteristicsProducts = new CharacteristicsProducts();

        if ($model->load(Yii::$app->request->post())) {

            $optionsNew = array_unique(array_diff(Yii::$app->request->post('characteristicsOptionsNew'), array('')));

            $optionsList = array_unique(array_diff(Yii::$app->request->post('characteristicsList'), array('')));

            if (count($paramsLanguages['params']) > 1) {
                $data = Yii::$app->request->post('Lang');
                $data2 = Yii::$app->request->post('Product');
                $model->name = $data['ru']['name'];
                $model->content = $data['ru']['content'];
                $model->keywords = $data['ru']['keywords'];
                $model->description = $data['ru']['description'];
                $model->price = str_replace(',','',$data2['price']);
                $model->characteristics = serialize($optionsList);
                $model->lang = serialize($data);
            }
            $model->save();

            if (isset($optionsNew) && !empty($optionsNew)) {
                foreach ($optionsNew as $optionNew) {
                    $characteristicsProductsNew = new CharacteristicsProducts();
                    $characteristicsProductsNew->product_id = $model->id;
                    $characteristicsProductsNew->characteristics_options_id = (int)$optionNew;
                    $characteristicsProductsNew->save();
                }
            }

            Yii::$app->session->setFlash('success', 'Создана!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'paramsLanguages' => $paramsLanguages,
            'characteristicsProducts' => $characteristicsProducts,
            'params' => $params,
            'language' => $language,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $paramsLanguages = $this->getParamsLanguages();

        $model = $this->findModel($id);

        $characteristicsProducts =  CharacteristicsProducts::find()->where(['product_id'=>$id])->all();

        $params = Yii::$app->params['languages'];

        $language = Yii::$app->sourceLanguage;

        if ($model->load(Yii::$app->request->post())) {

            //dd(Yii::$app->request->post());

            $optionsNew = array_unique(array_diff(Yii::$app->request->post('characteristicsOptionsNew'), array('')));

            $optionsList = array_unique(array_diff(Yii::$app->request->post('characteristicsList'), array('')));

            if (count($paramsLanguages['params']) > 1) {
                $data = Yii::$app->request->post('Lang');
                $data2 = Yii::$app->request->post('Product');
                $model->name = $data['ru']['name'];
                $model->content = $data['ru']['content'];
                $model->keywords = $data['ru']['keywords'];
                $model->description = $data['ru']['description'];
                $model->price = str_replace(',','',$data2['price']);
                $model->characteristics = serialize($optionsList);
                $model->lang = serialize($data);
            }
            $model->save();

            CharacteristicsProducts::deleteAll(['product_id' => $model->id]);

            if (isset($optionsNew) && !empty($optionsNew)) {
                foreach ($optionsNew as $optionNew) {
                    $characteristicsProductsNew = new CharacteristicsProducts();
                    $characteristicsProductsNew->product_id = $model->id;
                    $characteristicsProductsNew->characteristics_options_id = (int)$optionNew;
                    $characteristicsProductsNew->save();
                }
            }

            Yii::$app->session->setFlash('success', 'Обновлено!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'paramsLanguages' => $paramsLanguages,
            'characteristicsProducts' => $characteristicsProducts,
            'params' => $params,
            'language' => $language,

        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('error', 'Удаленно!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
