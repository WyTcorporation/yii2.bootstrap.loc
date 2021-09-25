<?php

namespace backend\controllers\categories;

use backend\controllers\AppAdminController;
use backend\models\categories\CategoriesCharacteristics;
use backend\models\categories\CategoriesPercent;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use backend\models\translations\Type;
use Yii;
use backend\models\categories\Categories;
use backend\models\categories\CategoriesSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends AppAdminController
{
    public $type = 'categories';

    protected function isModerActive()
    {
        $actions = [];
        return $this->isModer($actions);
    }

    /**
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {

        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_categories_id = $params['type']['type_categories_id'];;
        $type_characteristics_id =  $params['type']['type_characteristics_id'];

        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_categories_id' => $type_categories_id,
            'type_characteristics_id' => $type_characteristics_id,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $params = $this->getParams();
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_categories_id = $params['type']['type_categories_id'];;
        $type_characteristics_id =  $params['type']['type_characteristics_id'];;

        return $this->render('view', [
            'language_id' => $language_id,
            'content_id' => $content_id,
            'type_categories_id' => $type_categories_id,
            'type_characteristics_id' => $type_characteristics_id,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();

        $params = $this->getParams();
        $language = $params['language'];
        $language_id = $params['language_id'];
        $content_id =  $params['content_id'];
        $type_id =  $params['type']['type_characteristics_id'];
        $params = $params['params'];

        $percent = new CategoriesPercent();

        $categoriesCharacteristics = new CategoriesCharacteristics();

        if ($model->load(Yii::$app->request->post())) {

            $categoriesPercent = Yii::$app->request->post('CategoriesPercent')['array'];
            $categoriesCharacteristics = Yii::$app->request->post('CategoriesCharacteristics')['array'];
            $translationInput = Yii::$app->request->post('Translations');
            $model->name = $translationInput['field_name'][$language];
            if ($model->save()) {
                if (isset($categoriesPercent) && !empty($categoriesPercent)) {
                    for ($x = 1; $x <= count($categoriesPercent); $x++) {
                        $percentNew = new CategoriesPercent();
                        $percentNew->categories_id = $model->id;
                        $percentNew->role = $x;
                        $percentNew->content = $categoriesPercent[$x];
                        $percentNew->save();
                    }
                }
                if (isset($categoriesCharacteristics) && !empty($categoriesCharacteristics)) {
                    for ($x = 0; $x <= count($categoriesCharacteristics); $x++) {
                        $categoriesCharacteristicsNew = new CategoriesCharacteristics();
                        $categoriesCharacteristicsNew->categories_id = $model->id;
                        $categoriesCharacteristicsNew->characteristics_id = $categoriesCharacteristics[$x];
                        $categoriesCharacteristicsNew->save();
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
            } else {
                Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error! Not saved!'));
            }
        }
        $translations = null;
        return $this->render('create', [
            'model' => $model,
            'params' => $params,
            'percent' => $percent,
            'language_id' => $language_id,
            'type_id' => $type_id,
            'content_id' => $content_id,
            'categoriesCharacteristics' => $categoriesCharacteristics,
            'translations' => $translations,
        ]);
    }

    /**
     * Updates an existing Categories model.
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
        $type_id =  $params['type']['type_characteristics_id'];
        $params = $params['params'];

        $percents = CategoriesPercent::find()->where(['categories_id' => $model->id])->all();

        $x = 1;
        $percent = null;
        foreach ($percents as $percent) {
            $array[$x] = $percent->content;
            $x++;
            $percent->array = $array;
        }

        $categoriesCharacteristics = CategoriesCharacteristics::find()->where(['categories_id' => $model->id])->all();;

        foreach ($categoriesCharacteristics as $categoriesCharacteristic) {
            $arraies[$categoriesCharacteristic->characteristics_id] = $categoriesCharacteristic->characteristics_id;
        }

        $categoriesCharacteristics = new CategoriesCharacteristics();
        $categoriesCharacteristics->array = $arraies;

        $translations = $this->getTranslationsList($model->id, $this->type);

        if ($model->load(Yii::$app->request->post())) {

            $categoriesPercent = Yii::$app->request->post('CategoriesPercent')['array'];
            $categoriesCharacteristics = Yii::$app->request->post('CategoriesCharacteristics')['array'];
            $translationInput = Yii::$app->request->post('Translations');
            $model->name = $translationInput['field_name'][$language];
            if ($model->save()) {
                if (isset($categoriesPercent) && !empty($categoriesPercent)) {
                    for ($x = 1; $x <= count($categoriesPercent); $x++) {
                        $percentNew = CategoriesPercent::findOne(['categories_id' => $model->id, 'role' => $x]);
                        if (!isset($percentNew) && empty($percentNew)) {
                            $percentNew = new CategoriesPercent();
                        }
                        $percentNew->categories_id = $model->id;
                        $percentNew->role = $x;
                        $percentNew->content = $categoriesPercent[$x];
                        $percentNew->save();
                    }
                }
                if (isset($categoriesCharacteristics) && !empty($categoriesCharacteristics)) {
                    $delete = CategoriesCharacteristics::deleteAll(['categories_id' => $model->id]);
                    for ($x = 0; $x <= count($categoriesCharacteristics); $x++) {
                        $categoriesCharacteristicsNew = new CategoriesCharacteristics();
                        $categoriesCharacteristicsNew->categories_id = $model->id;
                        $categoriesCharacteristicsNew->characteristics_id = $categoriesCharacteristics[$x];
                        $categoriesCharacteristicsNew->save();
                    }
                }

                $translation_id = $model->id;
                $result = $this->setTranslation($translationInput, $translation_id, $this->type);
                if ($result) {
                    Yii::$app->session->setFlash('success', Yii::t('backend/flash', 'Updated!'));
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error!'));
                }
            } else {
                Yii::$app->session->setFlash('error', Yii::t('backend/flash', 'Error! Not saved!'));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'params' => $params,
            'percent' => $percent,
            'language' => $language,
            'language_id' => $language_id,
            'type_id' => $type_id,
            'content_id' => $content_id,
            'categoriesCharacteristics' => $categoriesCharacteristics,
            'translations' => $translations,
        ]);
    }

    /**
     * Deletes an existing Categories model.
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
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app/error', 'The requested page does not exist.'));
    }
}
