<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
