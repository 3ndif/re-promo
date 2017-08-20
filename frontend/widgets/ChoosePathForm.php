<?php
namespace frontend\widgets;

/*
 * Виджет выбора категорий при добавлении объявления
 */

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper as AH;
use yii\base\Widget;

/**
 * @var array $accessible
 * @var object/array $data
 * @var object/function $value
 */
class ChoosePathForm extends Widget {

    /**
     * @var array Доступные поля
     * @example ['id','name','i18n' => []]
     */
    public $accessible = [];

    /**
     * @type object
     * OR
     * @type array of objects
     */
    public $data = null;

    /**
     *
     * @type function
     * OR
     * $type string
     */
    public $value = 'name';

    private $htmlSingleBlocks = '';

    public function run(){
        return $this->exec();
    }

    private function exec(){
        $data = $this->data;
        $html = '';

        if (is_array($data)){
            foreach ($data as $object){
                $this->setHtmlSingleElement($object);
            }
        } else {
            $html = $this->setHtmlSingleElement($data);
        }

        return $this->getHtml();
    }

    private function getHtml(){
        return str_replace("{singleBlocks}", $this->htmlSingleBlocks, $this->htmlMainBlock());
    }

    private function htmlMainBlock(){

        return "<div class=\"col-canvas\">
                <ul class=\"wrapper\">
                    <li class=\"report-column\">
                        <header>Выберите категорию</header>
                        <div>
                            <div class=\"list-group list-cust\">
                            {singleBlocks}
                            </div>
                        </div>
                    </li>
                </ul>
                </div>";
    }

    private function setHtmlSingleElement($object){
        $this->htmlSingleBlocks .=
                    "<a href=\"javascript:void(0)\" class=\"list-group-item\" data-id=\"<?= $object->id?>\">
                    {$this->getValue($object)}
                    </a>";
    }

    private function getValue($object){

        if ($this->value instanceof \Closure){
            return call_user_func($this->value, $object);
        }

        return $object->{$this->value};
    }

}

