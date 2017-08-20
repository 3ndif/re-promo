<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Params;
use yii\helpers\Url;
use common\helpers\JsonData;

class ParamsController extends \backend\controllers\BaseController {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actionIndex(){
        $params = Params::find()
                        ->withI18n()
                        ->all();

        return $this->render('index.php',[
            'params' => $params
        ]);
    }

    public function actionCreate(){
        $params = new Params;

        $toUrl = Url::toRoute(['save']);

        return $this->render('form',[
            'model' => $params,
            'toUrl' => $toUrl
        ]);
    }

    public function actionSave($id = null) {
        $post = Yii::$app->request->post();

        if ($id){
            $params = Params::findOne($id);
        } else {
            $params = new Params;
        }

        if ($params->load(Yii::$app->request->post())) {

            if($params->save()){
                return $this->sendJsonData([
                    JsonData::SUCCESSMESSAGE => "\"{$params->techname}\" успешно сохранено",
                    JsonData::REFRESHPAGE => '',
                ]);
            }
        }

        return $this->sendJsonData([
            JsonData::SHOW_VALIDATION_ERRORS_INPUT => $params->getErrors(),
        ]);
    }
}