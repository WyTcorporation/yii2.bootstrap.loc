<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('frontend', 'registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Yii::t('frontend', 'registration') ?>
<div id="account-register" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-12">
            <h1><?= Yii::t('frontend', 'registration') ?></h1>
            <p><?= Yii::t('frontend', 'If you are already registered, go to the page') ?> <a href="<?= Url::to(['/login']) ?>"><?= Yii::t('frontend', 'authorization') ?></a>.
            </p>

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'options' => [
                    'class' => 'form-horizontal'
                ]]); ?>

            <fieldset id="account">
                <legend><?= Yii::t('frontend', 'Basic data') ?></legend>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'col-sm-10'])->label(Yii::t('frontend', 'Your name'), ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '(999)-999-99-99',
                    'options' => [
                        'class' => 'col-sm-10'
                    ]
                ])->label(Yii::t('frontend', 'Telephone'), ['class' => 'col-sm-2 control-label']) ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'class' => 'col-sm-10'])->label('E-Mail', ['class' => 'col-sm-2 control-label']) ?>

            </fieldset>
            <fieldset>
                <legend><?= Yii::t('frontend', 'your password') ?></legend>

                <?= $form->field($model, 'password')->passwordInput(['class' => 'col-sm-10'])->label(Yii::t('frontend', 'password'), ['class' => 'col-sm-2 control-label']) ?>

            </fieldset>

            <div class="buttons">
                <div class="pull-right">
                    <?= Yii::t('frontend', 'agreement') ?>
                    <input type="checkbox" checked name="agree" value="1">
                    <?= Html::submitButton(Yii::t('frontend/buttons', 'proceedButton'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= Yii::t('frontend', 'Privacy Policy') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= Yii::t('frontend', 'Privacy Policy Text') ?>
            </div>
        </div>
    </div>
</div>
