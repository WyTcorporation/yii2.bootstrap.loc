<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('frontend', 'Register Login');
$this->params['breadcrumbs'][] = $this->title;


?>

<div id="account-login" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="dsl-wrap">
                <div id="d_social_login">
                    <span id="d_social_login_main_label" class="dsl-label icons" style="font-size: 20px;    padding: 11px 4px;    margin: 2px;    margin-bottom: 10px;"><?= Yii::t('frontend', 'Register Login') ?></span>
                    <?= yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['site/auth'],
                        'popupMode' => true,
                        'options' => [
                                'class'=>'social'
                        ]
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="well">
                        <h2><?= Yii::t('frontend', 'New client') ?></h2>
                        <p><strong><?= Yii::t('frontend', 'registration') ?></strong></p>
                        <p><?= Yii::t('frontend', 'registrationText') ?></p>
                        <a href="<?= Url::to(['/signup']) ?>"
                           class="btn btn-primary"><?= Yii::t('frontend/buttons', 'proceedButton') ?></a></div>
                </div>
                <div class="col-sm-6">
                    <div class="well">
                        <h2><?= Yii::t('frontend', 'Registered customer') ?></h2>
                        <p><strong><?= Yii::t('frontend', 'Login to your Personal Account') ?></strong></p>

                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        <div style="color:#999;margin:1em 0">
                            <?= Html::a(Yii::t('frontend', 'Forgot your password?'), ['site/request-password-reset']) ?>.
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('frontend', 'To come in'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
