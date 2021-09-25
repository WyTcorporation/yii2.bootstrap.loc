<?php

namespace backend\controllers\products;

use backend\controllers\AppAdminController;
use backend\models\characteristics\CharacteristicsProducts;
use backend\models\products\ProductsModels;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use Yii;
use backend\models\products\Products;
use backend\models\products\ProductsSearch;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends AppAdminController
{
    public $type = 'products';

    protected function isModerActive()
    {
        $actions = [];
        return $this->isModer($actions);
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {

        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id = $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];
        $type_categories_id = $params['type']['type_categories_id'];
        $type_products_models_id = $params['type']['type_products_models_id'];

        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_id' => $type_products_id,
            'type_categories_id' => $type_categories_id,
            'type_products_models_id' => $type_products_models_id,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id = $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];
        $type_categories_id = $params['type']['type_categories_id'];
        $type_products_models_id = $params['type']['type_products_models_id'];

        return $this->render('view', [
            'model' => $this->findModel($id),
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_products_id' => $type_products_id,
            'type_categories_id' => $type_categories_id,
            'type_products_models_id' => $type_products_models_id,
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        $params = $this->getParams();
        $language = $params['language'];
        $content_id = $params['content_id'];
        $type_characteristics_id = $params['type']['type_characteristics_id'];
        $type_categories_id = $params['type']['type_categories_id'];
        $type_products_models_id = $params['type']['type_products_models_id'];

        $params = $params['params'];

        $translation = new Translations();

        $language_id = Languages::findOne(['code' => $language])->id;

        $productsModelsTypeId = $type_products_models_id;
        $categoriesTypeId = $type_categories_id;
        $characteristicsTypeId = $type_characteristics_id;

        if ($model->load(Yii::$app->request->post())) {

            $translationInput = Yii::$app->request->post('Translations');
            $model->name = $translationInput['field_name'][$language];
            $model->save();

            $characteristicsOptionsSelect = Yii::$app->request->post('characteristicsOptionsSelect');
            if (isset($characteristicsOptionsSelect) && !empty($characteristicsOptionsSelect)) {
                for ($x = 0; $x <= count($characteristicsOptionsSelect); $x++) {
                    $id = $characteristicsOptionsSelect[$x];
                    $newCharacteristicsProducts = new CharacteristicsProducts();
                    $newCharacteristicsProducts->characteristics_options_id = $id;
                    $newCharacteristicsProducts->product_id = $model->id;
                    $newCharacteristicsProducts->save();
                }
            }

            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, $this->type);
            if ($result) {
                Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Created!'));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error!'));
            }
        }
        $optionArray = null;
        $translations = null;
        $characteristicsOptionsTypeId = null;
        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'language_id' => $language_id,
            'productsModelsTypeId' => $productsModelsTypeId,
            'categoriesTypeId' => $categoriesTypeId,
            'characteristicsTypeId' => $characteristicsTypeId,
            'content_id' => $content_id,
            'translation' => $translation,
            'characteristicsOptionsTypeId' => $characteristicsOptionsTypeId,
            'optionArray' => $optionArray,
            'translations' => $translations,
        ]);
    }

    /**
     * Updates an existing Products model.
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
        $content_id = $params['content_id'];
        $type_products_id = $params['type']['type_products_id'];
        $type_characteristics_id = $params['type']['type_characteristics_id'];
        $type_categories_id = $params['type']['type_categories_id'];
        $type_products_models_id = $params['type']['type_products_models_id'];
        $type_characteristics_options_id = $params['type']['type_characteristics_options_id'];

        $params = $params['params'];

        $translation = new Translations();

        $translations = $this->getTranslationsList($model->id, $this->type);

        $productsModelsTypeId = $type_products_models_id;
        $categoriesTypeId = $type_categories_id;
        $characteristicsTypeId = $type_characteristics_id;
        $characteristicsOptionsTypeId = $type_characteristics_options_id;

        $characteristicsProducts = CharacteristicsProducts::find()->where(['product_id' => $model->id])->all();

        $optionArray = null;
        if (isset($characteristicsProducts) && !empty($characteristicsProducts)) {
            for ($x = 0; $x <= count($characteristicsProducts); $x++) {
                if (isset($characteristicsProducts[$x]) && !empty($characteristicsProducts[$x])) {
                    $characteristicsProducts[$x]->characteristicsOptions->type_id = $characteristicsOptionsTypeId;
                    $characteristicsProducts[$x]->characteristicsOptions->language_id = $language_id;
                    $characteristicsProducts[$x]->characteristicsOptions->content_id = $content_id;
                    $characteristicsProducts[$x]->characteristicsOptions->characteristics->type_id = $characteristicsTypeId;
                    $characteristicsProducts[$x]->characteristicsOptions->characteristics->language_id = $language_id;
                    $characteristicsProducts[$x]->characteristicsOptions->characteristics->content_id = $content_id;
                    $optionArray[$characteristicsProducts[$x]->characteristicsOptions->characteristics->id]['characteristic']['id'] = $characteristicsProducts[$x]->characteristicsOptions->characteristics->id;
                    $optionArray[$characteristicsProducts[$x]->characteristicsOptions->characteristics->id]['characteristic']['name'] = $characteristicsProducts[$x]->characteristicsOptions->characteristics->translation->content;
                    $optionArray[$characteristicsProducts[$x]->characteristicsOptions->characteristics->id]['characteristic']['option'][$characteristicsProducts[$x]->id]['id'] = $characteristicsProducts[$x]->characteristicsOptions->id;
                    $optionArray[$characteristicsProducts[$x]->characteristicsOptions->characteristics->id]['characteristic']['option'][$characteristicsProducts[$x]->id]['name'] = $characteristicsProducts[$x]->characteristicsOptions->translation->content;
                }
            }
        }

        if ($model->load(Yii::$app->request->post())) {

            $translationInput = Yii::$app->request->post('Translations');

            $model->name = $translationInput['field_name'][$language];
            $model->save();

            $characteristicsOptionsNew = Yii::$app->request->post('characteristicsOptionsNew');
            $characteristicsOptionsSelect = Yii::$app->request->post('characteristicsOptionsSelect');
            $result = array_values(array_unique(array_merge($characteristicsOptionsNew, $characteristicsOptionsSelect)));
            if (isset($result) && !empty($result)) {
                $delete = CharacteristicsProducts::deleteAll(['product_id' => $model->id]);
                for ($x = 0; $x <= count($result); $x++) {
                    $id = $result[$x];
                    if ($id != '') {
                        $newCharacteristicsProducts = new CharacteristicsProducts();
                        $newCharacteristicsProducts->characteristics_options_id = $id;
                        $newCharacteristicsProducts->product_id = $model->id;
                        $newCharacteristicsProducts->save();
                    }
                }
            }
            $model->name = $translationInput['field_name'][$language];
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
            'language_id' => $language_id,
            'type_products_id' => $type_products_id,
            'productsModelsTypeId' => $productsModelsTypeId,
            'categoriesTypeId' => $categoriesTypeId,
            'characteristicsTypeId' => $characteristicsTypeId,
            'characteristicsOptionsTypeId' => $characteristicsOptionsTypeId,
            'content_id' => $content_id,
            'translation' => $translation,
            'translations' => $translations,
            'optionArray' => $optionArray,
        ]);
    }

    /**
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/error', 'The requested page does not exist.'));
    }

    public function actionSearchSession()
    {
        $name = '';
        $price = '';

        //Открываем сессию (нужна что бы после перехода на след страницу фильтр не сбрасывался)
        $session = Yii::$app->session;
        $session->open();

        $query = Products::find()->orderBy('id ASC');

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

            $query = Products::find()->orderBy('id ASC');

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
}
