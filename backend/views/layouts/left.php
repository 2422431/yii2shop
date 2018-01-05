<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/<?=Yii::$app->user->identity->logo?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>欢迎您<?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>



        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                 'items' => mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id),
/*                'items' => [
                    ['label' => '后台菜单栏', 'options' => ['class' => 'header']],

                    [
                        'label' => '商品管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '添加商品', 'icon' => 'window-minimize', 'url' => ['/goods/add'],],
                            ['label' => '商品列表', 'icon' => 'window-minimize', 'url' => ['/goods/index'],],
                            ['label' => '商品分类', 'icon' => 'window-minimize', 'url' => ['/goods-category'],],

                        ],
                    ],

                    ['label' => '品牌管理', 'icon' => 'share', 'url' => ['/brand/index']],


                    [
                        'label' => '文章管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章分类', 'icon' => 'file-code-o', 'url' => ['/article-category'],],
                            ['label' => '文章添加', 'icon' => 'dashboard', 'url' => ['/article/add'],],
                            ['label' => '文章列表', 'icon' => 'dashboard', 'url' => ['/article/index'],],

                        ],
                    ],


                    [
                        'label' => '管理员',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '管理员列表', 'icon' => 'user-circle', 'url' => ['/admin/index'],],
                            ['label' => '管理员添加', 'icon' => 'user-circle', 'url' => ['/admin/add'],],
                        ],
                    ],

                    [
                        'label' => '权限管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '权限列表', 'icon' => 'user-circle', 'url' => ['/permission/index'],],
                            ['label' => '权限添加', 'icon' => 'user-circle', 'url' => ['/permission/add'],],
                        ],
                    ],

                    [
                        'label' => '角色管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '角色列表', 'icon' => 'user-circle', 'url' => ['/role'],],
                            ['label' => '角色添加', 'icon' => 'user-circle', 'url' => ['/role/add'],],
                        ],
                    ],

                    ['label' => '登录', 'icon' => 'share', 'url' => ['admin/login']],
                    [
                        'label' => 'Some tools',
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
                ],*/
            ]
        ) ?>

    </section>

</aside>
