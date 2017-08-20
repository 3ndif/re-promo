<?php
namespace frontend\controllers;

use Yii;
use common\models\Ads;
use common\helpers\JsonData;

class AdsController extends \common\controllers\CommonController {
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate(){
        $categories = \frontend\models\Category::getTopCategories(9999);
        
        if (Yii::$app->request->post()){
            var_dump($_POST);
            var_dump($_FILES);die;
            return $this->sendJsonData([
                JsonData::SHOW_VALIDATION_ERRORS_INPUT => ['price' => ['Ошибка','Ошибка 2']],
//                JsonData::REFRESHPAGE => '',
            ]);
        }

        return $this->render('create',[
            'categories' => $categories
        ]);
    }

    public function actionUpdate(){

    }

    public function delete(){

    }
}