<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'attribute' => 'phone',
                'value' =>  function($model){
                   if(isset($model->userProfiles) && !empty( $model->userProfiles)){
                       return  $model->userProfiles->phone;
                   }
                    return '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],
            'email:email',
            [
                'attribute' => 'role',
                'filter' => [0 => Yii::t('backend', 'Retail'), 1 => Yii::t('backend', 'Small wholesale'), 2 => Yii::t('backend', 'Wholesale')],
                'value' =>  function($model){
                    if ($model->role == 0) {
                        $role = '<span class="text-danger">'.Yii::t('backend', 'Retail').'</span>';
                    } elseif ($model->role == 1) {
                        $role = '<span class="text-success">'.Yii::t('backend', 'Small wholesale').'</span>';
                    } elseif ($model->role == 2) {
                        $role = '<span class="text-primary">'.Yii::t('backend', 'Wholesale').'</span>';
                    } elseif ($model->role == 3) {
                        $role = '<span class="text-warning">'.Yii::t('backend', 'Administration').'</span>';
                    }
                    return $role ? $role : '<span class="text-danger">' . Yii::t('backend', 'Not found') . '</span>';
                },
                'format' => 'html'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
