<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 02.09.2021
 * Time: 08:24
 * User: WyTcorporation
 */

use yii\helpers\Url;

?>
<div id="search" class="input-group">

    <form method="get" action="<?= Url::to(['category/search']) ?>">
        <input id="search_field" class="form-control input-lg" type="text" name="search" placeholder="<?=  Yii::t('frontend', 'Search'); ?> ..." />
    </form>

    <ul class="dropdown-menu"></ul>
    <ul class="dropdown-menu"></ul>
    <div class="search_run">
    </div>
</div>