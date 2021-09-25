<?php
$user = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
?>

<aside class="main-sidebar">

    <section class="sidebar">
        <?php if($user['superAdmin']->name == 'superAdmin') : ?>
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?php endif; ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    //['label' => 'Мое меню', 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend/links', 'Home'), 'icon' => 'file-code-o', 'url' => ['/site/index']],
                    [
                        'label' => Yii::t('backend/links', 'Categories'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('backend/links', 'Category list'), 'icon' => 'file-code-o', 'url' => ['/categories/categories/index'],],
                            ['label' => Yii::t('backend/links', 'Create a category'), 'icon' => 'file-code-o', 'url' => ['/categories/categories/create'],],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend/links', 'Characteristics'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('backend/links', 'Characteristic list'), 'icon' => 'file-code-o', 'url' => ['/characteristics/characteristics/index'],],
                            ['label' => Yii::t('backend/links', 'Create characteristic'), 'icon' => 'file-code-o', 'url' => ['/characteristics/characteristics/create'],],
                            ['label' => Yii::t('backend/links', 'Option List'), 'icon' => 'file-code-o', 'url' => ['/characteristics/characteristics-options/index'],],
                            ['label' => Yii::t('backend/links', 'Create Option'), 'icon' => 'file-code-o', 'url' => ['/characteristics/characteristics-options/create'],],
                            ['label' => Yii::t('backend/links', 'Model List'), 'icon' => 'file-code-o', 'url' => ['/products/products-models/index'],],
                            ['label' => Yii::t('backend/links', 'Create Model'), 'icon' => 'file-code-o', 'url' => ['/products/products-models/create'],],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend/links', 'Products'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('backend/links', 'Product list'), 'icon' => 'file-code-o', 'url' => ['/products/products/index'],],
                            ['label' => Yii::t('backend/links', 'Dynamic search'), 'icon' => 'file-code-o', 'url' => ['products/products/search-session'],'visible' => $user['superAdmin']->name == 'superAdmin' ? true : false,],
                            ['label' => Yii::t('backend/links', 'Create a product'), 'icon' => 'file-code-o', 'url' => ['/products/products/create'],],
                            ['label' => Yii::t('backend/links', 'Comments'), 'icon' => 'file-code-o', 'url' => ['/products/products-comments/index'],],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend/links', 'Orders'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('backend/links', 'Order list'), 'icon' => 'file-code-o', 'url' => ['/orders/orders/index'],],
                            ['label' => Yii::t('backend/links', 'Create order'), 'icon' => 'file-code-o', 'url' => ['/orders/orders/create'],],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend/links', 'News'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' =>  Yii::t('backend/links', 'News List'), 'icon' => 'file-code-o', 'url' => ['/blog/blog/index'],],
                            ['label' => Yii::t('backend/links', 'Create news'), 'icon' => 'file-code-o', 'url' => ['/blog/blog/create'],],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend/links', 'Pages'),
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('backend/links', 'List of pages'), 'icon' => 'file-code-o', 'url' => ['/pages/pages/index'],],
                            ['label' => Yii::t('backend/links', 'Create a page'), 'icon' => 'file-code-o', 'url' => ['/pages/pages/create'],],
                        ],
                    ],
                    ['label' => 'Call Back', 'icon' => 'file-code-o', 'url' => ['/callback/call-back/index']],
                    ['label' => Yii::t('backend/links', 'Users'), 'icon' => 'file-code-o', 'url' => ['/user/user/index']],
                    [
                        'label' => Yii::t('backend/links', 'Settings'),
                        'icon' => 'share',
                        'url' => '#',
                        //'visible' => $user['superAdmin']->name == 'superAdmin' ? true : false,
                        'items' => [
                            ['label' => Yii::t('backend/links', 'Languages'), 'icon' => 'file-code-o', 'url' => ['/options/options/languages'],],
                            ['label' => Yii::t('backend/links', 'Import / Excel'), 'icon' => 'file-code-o', 'url' => ['/csv/excel'],],
                            ['label' => Yii::t('backend/links', 'Shop'), 'icon' => 'file-code-o', 'url' => ['/options/options/shop'],],
                            ['label' => Yii::t('backend/links', 'Promotions'), 'icon' => 'file-code-o', 'url' => ['/options/options/stock'],],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend/links', 'Settings'),
                        'icon' => 'share',
                        'url' => '#',
                        'visible' => $user['superAdmin']->name == 'superAdmin' ? true : false,
                        'items' => [
                            [
                                'label' => Yii::t('backend/links', 'Setting up Translations'),
                                'icon' => 'share',
                                'url' => '#',
                                'items' => [
                                    ['label' => Yii::t('backend/links', 'Type'), 'icon' => 'file-code-o', 'url' => ['/translations/type/index'],],
                                    ['label' => Yii::t('backend/links', 'Content'), 'icon' => 'file-code-o', 'url' => ['/translations/content/index'],],
                                    ['label' => Yii::t('backend/links', 'Languages'), 'icon' => 'file-code-o', 'url' => ['/translations/languages/index'],],
                                    ['label' => Yii::t('backend/links', 'Translations'), 'icon' => 'file-code-o', 'url' => ['/translations/translations/index'],],
                                ],
                            ],
                            [
                                'label' => Yii::t('backend/links', 'Setting options'),
                                'icon' => 'share',
                                'url' => '#',
                                'items' => [
                                    ['label' => Yii::t('backend/links', 'Options'), 'icon' => 'file-code-o', 'url' => ['/options/options/index'],],
                                    ['label' => Yii::t('backend/links', 'Create Option'), 'icon' => 'file-code-o', 'url' => ['/options/options/create'],],
                                ],
                            ],
                            [
                                'label' => Yii::t('backend/links', 'Setting currencies'),
                                'icon' => 'share',
                                'url' => '#',
                                'items' => [
                                    ['label' => Yii::t('backend/links', 'Currency'), 'icon' => 'file-code-o', 'url' => ['/currency/currency/index'], ],
                                    ['label' => Yii::t('backend/links', 'Create currency'), 'icon' => 'file-code-o', 'url' => ['/currency/currency/create'],],
                                ],
                            ],

                        ],
                    ],

                    [
                        'label' => 'Мои Приколы',
                        'visible' => $user['superAdmin']->name == 'superAdmin' ? true : false,
                        'icon' => 'times',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Парсинг',
                                'icon' => 'share',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Парсинг yandex 1', 'icon' => 'file-code-o', 'url' => ['/yandex/yandex'],],
                                    ['label' => 'Парсинг yandex 2', 'icon' => 'file-code-o', 'url' => ['/yandex/yandex-news'],],
                                    ['label' => 'Парсинг yandex 3', 'icon' => 'file-code-o', 'url' => ['/yandex/yandex-news-list'],],
                                ],
                            ],
                            ['label' => 'Видео', 'icon' => 'file-code-o', 'url' => ['/site/video']],
                            ['label' => 'Записи', 'url' => ['/notes/index']],
                            ['label' => 'CSV', 'url' => ['/csv/index']],
                            ['label' => 'Чат', 'url' => ['/chat/index']],
                            ['label' => 'Шкафы', 'url' => ['/cupboard/index']],
                            ['label' => 'Калькуляторы', 'url' => ['/site/calculator']],
                        ],
                    ],
                    [
                        'label' => 'Опции',
                        'visible' => $user['superAdmin']->name == 'superAdmin' ? true : false,
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
