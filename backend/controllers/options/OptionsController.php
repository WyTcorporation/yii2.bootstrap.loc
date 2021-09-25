<?php

namespace backend\controllers\options;

use backend\controllers\AppAdminController;
use backend\models\shop\StockSearch;
use backend\models\shop\Shop;
use backend\models\shop\Stock;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use Yii;
use backend\models\options\Options;
use backend\models\options\OptionsSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OptionsController implements the CRUD actions for Options model.
 */
class OptionsController extends AppAdminController
{
    protected function isModerActive()
    {
        $actions = [];
        return $this->isModer($actions);
    }

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    public function actionUpdateStock($id)
    {
        $params = $this->getParams();
        $language = $params['language'];
        $params = $params['params'];

        $model = Stock::findOne($id);

        $translations = $this->getTranslationsList($model->id, 'stock');

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $translationInput = Yii::$app->request->post('Translations');
            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, 'stock');
            Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Updated!'));
        }
        return $this->render('update-stock', [
            'model' => $model,
            'params' => $params,
            'translations' => $translations,
            'language' => $language,
        ]);

    }

    public function actionStock()
    {

        $params = $this->getParams();

        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_stock_id =  $params['type']['type_stock_id'];
        $params = $params['params'];

        $searchModel = new StockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Stock();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $translationInput = Yii::$app->request->post('Translations');
            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, 'stock');
            Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Updated!'));
        }
        return $this->render('stock', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'params' => $params,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_stock_id' => $type_stock_id,
            //'translations' => $translations,
        ]);

    }

    public function actionShop()
    {
        $params = $this->getParams();
        $language = $params['language'];
        $type_options_id = $params['type']['type_options_id'];
        $params = $params['params'];

        $model = Shop::findOne(1);

        if (!isset($model) && empty($model)) {
            $model = new Shop();
        }

        $options = Options::findOne(['type_id' => $type_options_id, 'status' => 1, 'active' => 1]);
        if (!isset($options) && empty($options)) {
            $options = new Shop();
        }
        $options->active = 1;
        $options->status = 1;
        $options->type_id = $type_options_id;

        $translations = $this->getTranslationsList($model->id, 'shop');

        $model->array['phone'] = unserialize($model->phones);
        $model->array['date'] = unserialize($model->date);
        $model->array['address'] = $model->address;
        $model->array['location'] = $model->location;
        $model->array['email'] = $model->email;

        if ($model->load(Yii::$app->request->post())) {
            $shop = Yii::$app->request->post('Shop')['array'];
            $translationInput = Yii::$app->request->post('Translations');
            $model->phones = serialize($shop['phone']);
            $model->address = $shop['address'];
            $model->email = $shop['email'];
            $model->location = $shop['location'];
            $model->date = serialize($shop['date']);
            $model->save();
            $options->content = Yii::$app->request->post('Options')['content'];
            $options->save();

            $translation_id = $model->id;
            $result = $this->setTranslation($translationInput, $translation_id, 'shop');

            Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Updated!'));
            return $this->refresh();
        }

        return $this->render('shop', [
            'model' => $model,
            'options' => $options,
            'params' => $params,
            'translations' => $translations,
        ]);
    }

    /**
     * Lists all Options models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Options model.
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
     * Creates a new Options model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Options();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Options model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Options model.
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

    public function actionLanguages()
    {

        $sourceLanguage = Yii::$app->sourceLanguage;

        $languages = Languages::find()->all();

        $model = Options::findOne(1);

        if ($model->load(Yii::$app->request->post())) {
            $data_languages = Yii::$app->request->post('Options');
            //Сохраняем статус языков
            $active_multilanguages = $data_languages['status'];
            $model->status = $active_multilanguages;
            $model->save();
            if ((int)$active_multilanguages == 1) {
                $selected_languages = $data_languages['multilanguages'];
                $languages = Languages::updateAll(['active' => 0]);
                foreach ($selected_languages as $item) {
                    $language = Languages::findOne($item);
                    $language->active = 1;
                    $language->update();
                }
            } else {
                foreach ($languages as $item) {
                    $item->active = 0;
                    $item->update();
                    $language = Languages::findOne(['code' => $sourceLanguage]);
                    $language->active = 1;
                    $language->update();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Updated!'));
            return $this->redirect('dashboard');
        }

        return $this->render('languages', compact('languages', 'model'));
    }

    /**
     * Finds the Options model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Options the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Options::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/error', 'The requested page does not exist.'));
    }
}
