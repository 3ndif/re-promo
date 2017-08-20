<?php
/**
 * Форма для добавления и редактирования пунктов категорий
 * @var object $category - Объект редактируемой категории (пустой объект, если добавляем)
 * @var object $categoryGenerate - Объект из связанной модели сгерерированных категорий
 * @var string toUrl ссылку куда отправлять данные на обработку
 */

use yii\helpers\Url;
use yii\bootstrap\Html;
use backend\widgets\Form;
use yii\helpers\ArrayHelper;

$items = [
    'saveUrl' => $toUrl,
    'rows' => [
        [
            'panel-title' => 'Основныe данные',
            'attributes' => [
                ['name' => 'techname','type' => Form::INPUT_TEXT,'label' => 'Название','model'=>$category],
                ['name' => 'img','type' => Form::IMG,'label' => 'IMG','model'=>$category],
                ['name' => 'active','type' => Form::INPUT_CHECKBOX_INACTIVE,'label'=>'активность','model' => $category],
//                [
//                    'name' => 'placements',
//                    'type' => Form::MULTISELECT,
//                    'label'=>'Типы размещения объявлений',
//                    'model' => $category,
//
//                    'selectpicker' => [
//                      'values' => ArrayHelper::map($placements, 'id','_text.name'),
//                      'selected' => ArrayHelper::getColumn($category->placements,'id'),
//                      'options' => ['multiple' => true]
//                    ]
//                ],
            ]
        ],
        [
            'panel-title' => 'Сео данные',
            'attributes' => [
                ['name' => 'name','type' => Form::INPUT_TEXT,'label' => 'Название','model'=>$category->i18n],
                ['name' => 'url','type' => Form::INPUT_TEXT,'label' => 'URL','model'=>$category->i18n],
                ['name' => 'seo_title','type' => Form::INPUT_TEXT,'label' => 'SEO заголовок','model'=>$category->i18n],
                ['name' => 'seo_desc','type' => Form::INPUT_TEXT,'label' => 'SEO описание','model'=>$category->i18n],
                ['name' => 'seo_keywords','type' => Form::INPUT_TEXT,'label' => 'SEO ключевые слова','model'=>$category->i18n],
            ]
        ],
    ]
];

echo Form::widget($items);
?>