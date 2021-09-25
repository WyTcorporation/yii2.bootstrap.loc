<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 07.09.2021
 * Time: 20:02
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $profile */
/* @var $user */

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Personal Area'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div id="account-edit" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-9">
            <h1><?= Yii::t('frontend', 'Viewed products'); ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => [
                'class' => 'form-horizontal'
            ]]); ?>

            <fieldset>
                <legend><?= Yii::t('frontend', 'Your account'); ?></legend>
                <?= $form->field($profile, 'user_id')->hiddenInput(['value' => $user->id])->label(false) ?>

                <?= $form->field($profile, 'firstname')->textInput(
                        ['autofocus' => true, 'class' => 'col-sm-10 profile','value'=> $profile->firstname ? $profile->firstname : $user->username  ]
                )->label('Имя, Отчество', ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($profile, 'lastname')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label(Yii::t('frontend', 'Surname'), ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($user, 'email')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label('E-Mail', ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($profile, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '(999)-999-99-99',
                    'options' => [
                        'class' => 'col-sm-10 profile'
                    ]
                ])->label(Yii::t('frontend', 'Telephone'), ['class' => 'col-sm-2 control-label']) ?>

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
        <aside id="column-right" class="col-sm-3 hidden-xs">
            <div class="list-group">
                <?= Html::a(Yii::t('frontend', 'my info'), ['profile/index'], ['class' => 'list-group-item']) ?>
                <?= Html::a(Yii::t('frontend', 'Change contact information'), ['profile/contact', 'id' => $user->id], ['class' => 'list-group-item active']) ?>
                <?= Html::a(Yii::t('frontend', 'password'), ['profile/password', 'id' => $user->id], ['class' => 'list-group-item']) ?>
                <?= Html::a(Yii::t('frontend', 'The address book'), ['profile/address', 'id' => $user->id], ['class' => 'list-group-item']) ?>
                <?= Html::a(Yii::t('frontend', 'Favorites'), ['wishlist/view', 'id' => $user->id], ['class' => 'list-group-item']) ?>
                <?= Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    Yii::t('frontend', 'Output').' (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                ). Html::endForm() ?>
            </div>
        </aside>
    </div>
</div>
