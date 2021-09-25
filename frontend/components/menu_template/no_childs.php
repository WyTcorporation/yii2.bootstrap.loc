<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 02.09.2021
 * Time: 16:00
 * User: WyTcorporation
 */
?>

<li>
    <a <?php if (isset($category['childs'])): ?>class="list-group-item" <?php endif; ?> href="<?= \yii\helpers\Url::to(['category/view', 'slug' => $category['slug']]) ?>">
        <?= $category['name'] ?>
    </a>
    <?php if (isset($category['childs'])): ?>
        <span class="badge pull-right"><i class="fa fa-sort-up"></i></span>
    <?php endif; ?>
</li>

