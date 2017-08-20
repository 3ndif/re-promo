<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Category;
use common\helpers\JsonData;
use yii\helpers\Url;

/**
 * Site controller
 */
class CategoriesController extends BaseController
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
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
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($id = null)
    {
        $categories = null;
        $categoryParent = new Category;

        if (! $id) {
            $categories = Category::getMainCategories();

        } else {
            $categoryParent = Category::findOne($id);

            $categories = $categoryParent->getChildren()->all();
        }

        return $this->render('index',compact('categoryParent','categories'));
    }

    public function actionUpdate($id) {

        $category = Category::findOne($id);
        $text = $category->categoryText;

        $categoriesText = $text ? $text : new \common\models\CategoryText;

        $toUrl = Url::toRoute(['save','id' => $category->id]);

        return $this->renderAjax('form',compact('category','categoriesText', 'toUrl'));
    }

    public function actionCreate($parent_id = null) {
        $category = new Category();
        $category->parent_id = $parent_id;
        $categoriesText = new \common\models\CategoryText();

        $toUrl = Url::toRoute(['save','parentID' => $parent_id]);

        return $this->renderAjax('form',  compact('category','categoriesText','toUrl'));
    }

    public function actionSave($id = null, $parentID = null) {
        $post = Yii::$app->request->post();

        if ($id){
            $category = Category::findOne($id);
        } else {
            $category = new Category;
            $category->parent_id = $parentID;
        }

        if ($category->load(Yii::$app->request->post())) {
                if($category->save()){
                    return $this->sendJsonData([
                        JsonData::SUCCESSMESSAGE => "\"{$category->techname}\" успешно сохранено",
                        JsonData::REFRESHPAGE => '',
                    ]);
                }
        }

        return $this->sendJsonData([
            JsonData::SHOW_VALIDATION_ERRORS_INPUT => $category->getErrors(),
        ]);
    }

    public function actionDelete($id){

        $category = Category::findOne($id);
        $category->delete();

        return $this->sendJsonData([
                    JsonData::SUCCESSMESSAGE => "\"{$category->techname}\" успешно удалено",
                    JsonData::REFRESHPAGE => '',
        ]);
    }

    public function actionSaveLang($id,$languages_id){
        $category = Category::find()
                        ->where(['id' => $id])
                        ->withI18n($languages_id)
                        ->one();

        if ($this->isJson()){
            $text = $category->i18n;
            $text->categories_id = $category->id;
            $text->languages_id = $languages_id;
            $text->load(Yii::$app->request->post());

            if ($text->save()){
                return $this->sendJsonData([
                    JsonData::SUCCESSMESSAGE => "\"{$category->techname}\" успешно сохранено",
                    JsonData::REFRESHPAGE => '',
                ]);
            }

            return $this->sendJsonData([
                JsonData::SHOW_VALIDATION_ERRORS_INPUT => \yii\widgets\ActiveForm::validate($text),
            ]);
        }

        return $this->render('savelang',[
            'category' => $category,
        ]);
    }

    public function actionIcon($id){
        $result = [];

        if (isset($_FILES['file'])){
            $category = Category::findOne($id);
            $file = new \common\models\File();
            $file->imageFile = \yii\web\UploadedFile::getInstanceByName('file');
            $file = $file->uploadFileAndSave();

            if (!$file->hasErrors()){
                $category->icon_id = $file->id;
                $category->save();
            } else {
                $result = [
                    JsonData::ERROR => $file->getErrors(),
                ];
            }

        } else {
            $category = Category::findOne($id);
            $icon = $category->getIcon()->one();

            if ($icon){
                $iconDir = \common\models\Img::getIconDir();

                $result = [
                    JsonData::COMPLETED => [
                        'name' => $icon->getFilename(),
                        'type' => $icon->getMimeType(),
                        'size' => $icon->getFileSize($iconDir)
                    ]
                ];
            }
        }

        return $this->sendJsonData($result);
    }
}