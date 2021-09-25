<?= (int)$this->params == (int)$category['id'] ? '<div class="hidden">active</div>' : ''; ?>

<li>
    <a class="list-group-item  <?= (int)$this->params == (int)$category['id'] ? 'active' : ''; ?>" href="<?= \yii\helpers\Url::to(['category/view', 'slug' => $category['slug']]) ?>">
        <?= $tab . $category['name'] ?>
    </a>
    <?php if (isset($category['childs'])): ?>
        <span class="badge pull-right <?= (int)$this->params == (int)$category['id'] ? 'active' : ''; ?>"><i class="fa <?= (int)$this->params == (int)$category['id'] ? 'fa-sort-down' : 'fa-sort-up'; ?>"></i></span>
    <?php endif; ?>
    <?php if (isset($category['childs'])): ?>
        <ul class="dropdown <?= (int)$this->params == (int)$category['id'] ? 'active' : ''; ?>">
            <?= $this->getMenuHtml($category['childs'], $tab . ' - ') ?>
        </ul>
    <?php endif; ?>
</li>
