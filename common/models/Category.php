<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $techname
 * @property string $img
 * @property integer $active
 *
 * @property Ads[] $ads
 * @property Category $parent
 * @property Category[] $categories
 * @property CategoriesText[] $categoriesTexts
 */
class Category extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'active'], 'integer'],
            [['techname'], 'required'],
            [['techname'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],

            [['img'], 'image',  'mimeTypes' => 'png,jpg,jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'techname' => 'Techname',
            'img'   => 'Image',
            'active' => 'Active',
        ];
    }


    public function behaviors() {
        return [
            [
                'class' => \common\behaviors\I18n::className(),
                'relationName' => 'categoryText',
                'relationClassName' => CategoryText::className(),
            ],
        ];
    }

    public static function find(){
        return new scopes\CategoryQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['categories_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    public function getChildren(){
        return $this->hasMany(Category::className(),['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryTexts()
    {
        return $this->hasMany(CategoryText::className(), ['categories_id' => 'id']);
    }

    public function getIcon(){
        return $this->hasOne(File::className(), ['id' => 'icon_id'])
                    ->withExt()
                    ->andWhere(['is_deleted' => false]);
    }

    public function getIconUrl(){
        if (!$this->icon){
            $icon = $this->getIcon()->one();
        } else {
            $icon = $this->icon;
        }

        if (!$icon) {
            $filename = File::getFileDefault(File::ICON_DEFAULT);
        } else {
            $filename = $icon->getFilename();
        }

        return Yii::getAlias('@web/img/icons/'.$filename);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryText()
    {
        return $this->hasOne(CategoryText::className(), ['categories_id' => 'id']);
    }

    public function getImgUrl(){
        return Img::getPath(Img::ICON,$this->img);
    }

    public function upload()
    {
        $dir = Yii::getAlias('@app/web/img/icons');

        if ($this->validate()) {
            $rnd = rand(0,999999);  // generate random number between 0-999999
//            var_dump($this->imageFile);die;
            $fileName = "{$rnd}-{$this->imageFile->baseName}";
            $mimeType = $this->imageFile->type;
            $extension = $this->imageFile->extension;

            $fileExt = file\FileExt::find()
                            ->where(['ext' => $extension])
                            ->andWhere(['mime' => $mimeType])
                            ->one();

            if (!$fileExt){
                $fileExt = new file\FileExt();
                $fileExt->ext = $extension;
                $fileExt->mime = $mimeType;
                $fileExt->save();
            }

            $fileType = file\FileType::find()
                            ->where(['name' => 'Изображение'])
                            ->one();

            if (!$fileType){
                $fileExt = new file\FileType();
                $fileExt->name = 'Изображение';
                $fileExt->desc = 'Разные изображения';
                $fileExt->save();
            }

            $file = new File;
            $file->users_id = 4;
            $file->files_exts_id = $fileExt->id;
            $file->files_types_id = $fileType->id;
            $file->name = $fileName;
            $file->public = true;
            $file->save();
            var_dump(Yii::$app->user->id);die;
            $this->imageFile->name = $fileName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs("$dir/" . $this->imageFile->name);
            return true;
        } else {
            return false;
        }
    }
}
