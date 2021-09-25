<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\CurrencyManager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Currencies';
$this->params['breadcrumbs'][] = $this->title;
$component = new CurrencyManager();

//список валют
$listCurrencies = $component->listCurrencies();
p($listCurrencies);

$offer = ['currency_code' => 'UAH', 'price' => 1, 'old_price' => 1];
//формирует цену по курсу
$showPrice = $component->showPrice($offer);
p($showPrice);


?>
<select name="currencies" id="currencies">
    <?= \backend\components\CurrencyWidget::widget() ?>
</select>

<script>
    $('#currencies').on('change', function (e) {
        e.preventDefault();
        var value = $(this).val();
        console.log(value);
        $.ajax({
            type: "POST",
            url: "/admin/api/v1/currency",
            data: {'value': value},
            success: function (msg) {
                console.log('success ' + msg);
                location.reload();
            },
            error: function (msg) {
                console.log('error ' + msg);
            }
        });
    });
</script>

<div class="currency-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Currency', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'symbol',
            'code',
            'rate',
            'decimal_places',
            'is_default',
            'sort',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
