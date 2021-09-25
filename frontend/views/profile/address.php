<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 08.09.2021
 * Time: 06:55
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $address */
/* @var $user */

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Personal Area'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div id="account-address" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-12">
            <h2><?= Yii::t('frontend', 'Adding an address'); ?></h2>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => [
                'class' => 'form-horizontal'
            ]]); ?>

            <fieldset>
                <legend><?= Yii::t('frontend', 'Your account'); ?></legend>
                <?= $form->field($address, 'user_id')->hiddenInput(['value' => $user->id])->label(false) ?>

                <?= $form->field($address, 'firstname')->textInput(
                    ['autofocus' => true, 'class' => 'col-sm-10 profile','value'=> $address->firstname ? $address->firstname : $user->username  ]
                )->label('Имя, Отчество', ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($address, 'lastname')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label(Yii::t('frontend', 'Surname'), ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($address, 'company')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label(Yii::t('frontend', 'Company'), ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($address, 'address_1')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label(Yii::t('frontend', 'Address 1'), ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($address, 'address_2')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label(Yii::t('frontend', 'Address 2'), ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($address, 'city')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label(Yii::t('frontend', 'City'), ['class' => 'col-sm-2 control-label']) ?>

            </fieldset>

            <div class="buttons clearfix">
                <div class="pull-left">
                    <?= Html::a(Yii::t('frontend/buttons', 'backButton'), ['profile/index'], ['class' => 'btn btn-default']) ?>
                </div>
                <div class="pull-right">
                    <?= Html::submitButton(Yii::t('frontend/buttons', 'proceedButton'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
