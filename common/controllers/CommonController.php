<?php
namespace common\controllers;

use Yii;

class CommonController extends \yii\web\Controller {

    /**
     * Обычно при ajax запросе требуется вернуть только запрашиваемый view
     * этот параметр позволит вернуть весь контент сайта, если нужно
     * @var bool
     */
    public $onlycontent = false;

    public function beforeAction($action) {
        if (isset($_GET['onlycontent']) && $_GET['onlycontent']){
            $this->onlycontent = true;
        }

        return parent::beforeAction($action);
    }


    public function render($view,$params = []){
        if (Yii::$app->request->isAjax && $this->onlycontent){
            return parent::renderPartial($view,$params);
        }

        return parent::render($view,$params);
    }

//    public function renderPartial($view , $params = []){
//        if (Yii::$app->request->isAjax && $this->onlycontent){
//            return parent::renderPartial($view,$params);
//        }
//
//        return parent::renderPartial($view,$params);
//    }

    public function sendJsonData($jsonDataArray){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return \common\helpers\JsonData::current($jsonDataArray);
    }

    public function isJson(){
        if (isset($_REQUEST['json']) && $_REQUEST['json'] === 'true'){
            return true;
        }

        return false;
    }

}