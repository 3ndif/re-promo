<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
USE common\controllers\CommonController;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoriesController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'img');

            if($model->validate()){
                if ($model->imageFile && $model->upload()) {
                    $model->img = $model->imageFile->name;
                }

                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'img');
            if($model->validate()){
                if ($model->imageFile && $model->upload()) {
                    $model->img = $model->imageFile->name;
                }
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
                'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionJson(){
        $categories_id = Yii::$app->request->post('data_id');

//        $categories = Category::find()
//                            ->withI18n()
//                            ->asArray()
//                            ->all();
//            $c = \yii\helpers\ArrayHelper::index($categories, 'id');
//        $x = \yii\helpers\ArrayHelper::toArray($categories,[
//            'common\models\Category' => [
//                'i18n' => function($model){
//                    return $model->id;
//                }
//            ]
//        ]);
//        \yii\helpers\ArrayHelper::multisort($c, 'techname');
//        var_dump($c);die;

//        foreach ($categories as $category){
//            $category;
//        }

        if ($categories_id){
        $category = Category::findOne($categories_id);
        } else {
            $category = Category::getTopCategories(false);
        }

        $accessData = [
            'id',
            'parent_id',
            'i18n' => [
                'name',
            ]
        ];

        $data = [];

        if ($category){
            $childs = is_array($category) ? $category : $category->getChildren()->all();
//            return \frontend\widgets\ChoosePathForm::widget();

            foreach ($childs as $child){
                foreach($accessData as $key => $field) {
                    if (is_array($field)){
                        $relationData = $child->$key;
                        $data[$key] = [];
                        foreach($field as $relationField){
                            $data[$key][$relationField] = $relationData->{$relationField};
                        }
                    } else {
                        $data[$field] = $child->{$field};
                    }
                }
            }

            return json_encode([$data]);
        }

        return json_encode(['error']);
    }
}
