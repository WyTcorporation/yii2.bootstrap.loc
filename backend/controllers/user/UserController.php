<?php

namespace backend\controllers\user;

use backend\controllers\AppAdminController;
use backend\models\user\UserProfile;
use backend\models\user\User;
use Yii;
use backend\models\user\UserSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AppAdminController
{
    public $type = 'user';

    protected function isModerActive()
    {
        $actions =  [];
        return $this->isModer($actions);
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $profile = new UserProfile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $userProfile = Yii::$app->request->post('UserProfile');
            $profile->user_id = $model->id;
            $profile->phone = $userProfile['phone'];
            $profile->firstname = $userProfile['firstname'];
            $profile->lastname = $userProfile['lastname'];
            $profile->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'profile' => $profile,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $profile = $this->findModelUserProfile($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $userProfile = Yii::$app->request->post('UserProfile');
            $profile->user_id = $model->id;
            $profile->phone = $userProfile['phone'];
            $profile->firstname = $userProfile['firstname'];
            $profile->lastname = $userProfile['lastname'];
            $profile->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'profile' => $profile,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelUserProfile($id)
    {
        if (($profile = UserProfile::findOne(['user_id'=>$id])) !== null) {
            return $profile;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
