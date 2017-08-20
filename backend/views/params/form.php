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
                ['name' => 'techname','type' => Form::INPUT_TEXT,'label' => 'Название','model'=>$model],
                ['name' => 'active','type' => Form::INPUT_CHECKBOX_INACTIVE,'label'=>'Активность','model' => $model],
                ['name' => 'required','type' => Form::INPUT_CHECKBOX_INACTIVE,
                    'label'=>'Обязательный параметр','model' => $model],
            ]
        ],
        [
            'panel-title' => 'Сео данные',
            'attributes' => [
                ['name' => 'name','type' => Form::INPUT_TEXT,'label' => 'Название','model'=>$model->i18n],
            ]
        ],
    ]
];

echo Form::widget($items);
?>