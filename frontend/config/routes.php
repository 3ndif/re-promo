<?php
return [
 //   ['class' => 'frontend\rules\url\CategoryUrlRule', 'connectionID' => 'db'],
//    '<action:(login|registration|logout)>' => 'auth/<action>',
    '/new-ads' => 'ads/create',
    /**
     * Класс правила ГОРОД
     */
    /*
    [
        'class' => 'frontend\rules\url\LocationUrlRule',
        'pattern' => '/<city:\w+>',
        'route' => 'site/index',
    ],
    /**
     * Класс правила КАТЕГОРИЯ/ГОРОД
     */
    /*
    [
        'class' => 'frontend\rules\url\LocationCategoryUrlRule',
        'pattern' => '/<category:[\w_\-]+>/<city:\w+>',
        'route' => 'categories/index',
        'defaults' => ['city' => null],
    ],
    /**
     * Класс правила ПРОДАТЬ/КАТЕГОРИЯ/ГОРОД
     */
//    [
//        'class' => 'frontend\rules\url\LocationCategoryUrlRule',
//        'pattern' => '/<placement:[\w_\-]+>/<category:\w+>/<city:\w+>',
//        'route' => 'categories/index',
//        'defaults' => ['city' => null],
//    ],
//
//    '/new-promo' => 'ads/create',
];