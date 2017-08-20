<?php
/**
 * Класс реализует вывод форматированного перевода для текущей записи
 *
 * @example $object->i18n->attribute
 *
 */

namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;
use yii\base\Exception;

/**
 * Поведение для получения значения аттрибута в зависимсоит от языка
 * ```
 *
 * @property ActiveRecord $owner
 */
class I18n extends Behavior
{

    /**
     * Название связи используемой для перевода
     */
    public $relationName = '';

    public $relationClassName = '';

    /**
     * Поле используемое для перевода
     */
    public $field = 'name';

    public function getI18n(){
        return $this->owner->{$this->relationName}
                ? $this->owner->{$this->relationName}
                : Yii::createObject($this->relationClassName);
    }

    public function getI18nAll(){
       return $this->owner->{$this->relationName."s"};
    }

}