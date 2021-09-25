<?php

/* @var $shops */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('frontend', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;

?>

<div id="information-contact" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-12">
            <h1><?= Yii::t('frontend', 'Contacts'); ?></h1>
            <div>
                <div class="row" style="font-family: Arial;">
                    <?php if (isset($shops) && !empty($shops)): ?>
                        <?php foreach ($shops as $shop) : ?>
                            <div class="col-md-4">
                                <p style="font-size: 22px; color:#397b21;font-weight: bold;font-family: Arial Black;">
                                    <u><?= $shop['name'] ?></u>
                                </p>
                                <?php if (isset($shop['phones']) && !empty($shop['phones'])): ?>
                                    <?php foreach ($shop['phones'] as $phone) : ?>
                                        <p style="font-size: 15px;">
                                            <img src="/images/tel.png"
                                                 style="width: 25px;"
                                            >&nbsp; <?= $phone ?><br></p>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <p style="font-size: 15px;">
                                    <img src="/images/mail.png"
                                         style="width: 25px;"
                                    >&nbsp; &nbsp;<?= $shop['email']; ?></p>
                                <?php if (isset($shop['date']) && !empty($shop['date'])): ?>
                                    <p style="font-size: 15px;">
                                        <img src="/images/work.jpg"
                                             style="width: 25px;"
                                        >
                                    <span style="text-align: left;position: absolute;left: 50px;">
                                        <?php foreach ($shop['date'] as $key => $date) : ?>
                                            <?= $key; ?>  <?= $date; ?>
                                        <?php endforeach; ?>
                                    </span>
                                    </p>
                                <?php endif; ?>
                            </div>
                    <div class="col-md-8">
                        <?= $shop['location']; ?>
                    </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>

            </div>
            <div style="margin: 20px 0;">

            </div>
        </div>
    </div>
</div>