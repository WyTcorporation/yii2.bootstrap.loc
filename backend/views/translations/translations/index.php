<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\translations\TranslationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Translations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Translations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'language_id',
            'translation_id',
            'type_id',
            'content_id',
            //'content:ntext',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'created_ip',
            //'updated_ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
