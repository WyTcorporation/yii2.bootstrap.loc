<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Characteristics */

$name = unserialize($model->name);
$firstKey = current($params);
$this->title = $name[$firstKey];

$this->params['breadcrumbs'][] = ['label' => 'Characteristics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="characteristics-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name',
                'value' =>  function($model){
                    $name = unserialize($model->name);
                    $params = Yii::$app->params['languages'];
                    $firstKey = current($params);
                    return $name[$firstKey];
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'filter_status',
                'value' => function ($data) {
                    return $data->filter_status == 1 ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>';
                },
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
