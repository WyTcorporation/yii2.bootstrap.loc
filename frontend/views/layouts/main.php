<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php if (Yii::$app->params['closeRobots'] == 'yes'): ?>
        <meta name="robots" content="noindex, nofollow"/>
        <meta name="googlebot" content="noindex, nofollow"/>
        <meta name="yandex" content="none"/>
    <?php endif; ?>

    <?php if (isset(Yii::$app->session['contacts'][0]['adwords']) && !empty(Yii::$app->session['contacts'][0]['adwords'])): ?>
        <?= Yii::$app->session['contacts'][0]['adwords'] ?>
    <?php endif; ?>

</head>
<body>

<?php $this->beginBody() ?>

<?= $this->render('header/header', []); ?>

<div class="content">

    <div class="container">
        <?= Alert::widget() ?>
    </div>

    <?= $content ?>
</div>
<?= $this->render('carousel', []); ?>
<?= $this->render('footer', []); ?>


<div class="modal fade" id="top_zvor_dzvinok" tabindex="-1" role="dialog" aria-labelledby="top_zvor_dzvinok"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=  Yii::t('frontend/buttons', 'backCall'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_call_back" action="#">
                    <div class="form-group">
                        <label for="cb_telephone"><?=  Yii::t('frontend/buttons', 'yourPhoneNumber'); ?></label>
                        <?=
                        \yii\widgets\MaskedInput::widget([
                            'name' => 'telephone',
                            'mask' => '(999)-999-99-99',
                            'id' => 'cb_telephone',
                            'options' => [
                                   'placeholder' => Yii::t('frontend/buttons', 'yourPhoneNumber'),
                                'class'=>'form-control'
                            ]
                        ]);
                        ?>
                        <input name="product" type="hidden" class="form-control" id="cb_product"
                               placeholder="Ваш телефон" value="">
                    </div>
                    <div class="notice_wrapper"></div>
                    <div class="form-group text-right">
                        <button id="callback"
                                type="button" class="btn reset btn-green">
                            <?=  Yii::t('frontend/buttons', 'sendButton'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


