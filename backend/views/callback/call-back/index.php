<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\callback\CallBackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Call Backs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="call-back-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

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

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}'

            ],
        ],
    ]); ?>


</div>
