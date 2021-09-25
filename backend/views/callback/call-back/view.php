<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\callback\CallBack */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Call Backs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="call-back-view">

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

            'telephone',
            'product_name',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    if ($data->status == 1) {
                        $action = '<span class="text-success">'.Yii::t('backend/buttons', 'Yes').'</span>';
                    } else {
                        $action = '<span class="text-danger">'.Yii::t('backend/buttons', 'No').'</span>';
                    }
                    return $action;
                },
                'format' => 'raw'
            ],

        ],
    ]) ?>

</div>
