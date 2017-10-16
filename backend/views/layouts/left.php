<?php
use mdm\admin\components\Helper;
?>
<aside class="main-sidebar">

    <section class="sidebar">
    <?php if(Helper::checkRoute('/booking/validation')): ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu sidebar-collapse'],
                'items' => [
                    // ['label' => 'Home', 'url' => ['/site/index']],
                    ['label'    => 'Content','icon'=>'dashboard', 'url' => ['/content/index']],
                    ['label'    => 'Booking','icon' => 'book', 'url' => '/booking/index'],
                    ['label'    => 'Validate','icon' => 'check-square', 'url' => ['/booking/validation']],
                    // ['label' => 'Avb Template', 'url' => ['/avaibility-template/index']],
                    ['label'    => 'Trip/Schedule','icon'=>'calendar', 'url' => ['/trip/index']],
                    
                    // ['label' => 'Price List', 'url' => ['/season-price/index']],
                    ['label'    => 'Season Price','icon'=>'money', 'url' => ['/set-season/index']],
                    ['label'    => 'Company', 'icon'=>'flag', 'url' => ['/company/index']],
                    ['label'    => 'Boat','icon'=>'ship', 'url' => ['/boat/index']],
                    ['label'    => 'Harbor/Port','icon'=>'ship', 'url' => ['/harbor/index']],
                    ['label'    => 'Route','icon'=>'code-fork', 'url' => ['/route/index']],
                    
                    ['label'    => 'Est Time','icon'=>'clock-o', 'url' => ['/estimation-time/index']],
                    ['label'    => 'Shuttle Area','icon'=>'map', 'url' => ['/shuttle-area/index']],
                    // ['label' => 'Location','icon'=>'map-marker', 'url' => ['/shuttle-location/index']],
                    // ['label' => 'Price','icon'=>'money', 'url' => ['/shuttle-price/index']],
                    
                    ['label'    => 'Change Password','icon'=>'lock', 'url' => ['/admin/user/change-password']],
                    [
                        'label' => 'Dev tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'User',
                                'icon' => 'user',
                                'url' => '#',
                                'items' => [
                                    ['label'    => 'User', 'url' => ['/admin/user']],
                                    ['label'    => 'Route', 'url' => ['/admin/route']],
                                    ['label'    => 'Role', 'url' => ['/admin/role']],
                                    ['label'    => 'Assignment', 'url' => ['/admin/assignment']],
                                    
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
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            
                        ], 'visible' => Helper::checkRoute('/*')
                    ],
                ],
            ]
        ) ?>
    <?php elseif(Helper::checkRoute('/booking/index')): ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu sidebar-collapse'],
                'items' => [
                    ['label' => 'Booking','icon' => 'book', 'url' => '/booking/index'],
                    ['label' => 'Trip/Schedule','icon'=>'calendar', 'url' => ['/trip/index']],
                    ['label' => 'Change Password','icon'=>'lock', 'url' => ['/admin/user/change-password']],
                ],
            ]
        ) ?>
    <?php elseif(Helper::checkRoute('/content/*')): ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu sidebar-collapse'],
                'items' => [
                    ['label' => 'Content','icon' => 'book', 'url' => '/content/index'],
                    ['label' => 'Change Password','icon'=>'lock', 'url' => ['/admin/user/change-password']],
                ],
            ]
        ) ?>
    <?php endif; ?>
    </section>

</aside>
