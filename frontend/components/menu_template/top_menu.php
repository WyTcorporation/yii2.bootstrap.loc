<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 02.09.2021
 * Time: 10:50
 * User: WyTcorporation
 */

?>
<li class="category_thumbnail">
    <a href="<?= \yii\helpers\Url::to(['category/view', 'slug' => $category['slug']]) ?>">
        <?= $category['name'] ?>
        <?php if (isset($category['childs'])): ?>
<!--            <span class="badge pull-right"><i class="fa fa-sort-down"></i></span>-->
        <?php endif; ?>
    </a>
    <?php if (isset($category['childs'])): ?>
        <ul class="hidden">
            <?= $this->getMenuHtml($category['childs']) ?>
        </ul>
    <?php endif; ?>
</li>

