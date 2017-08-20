<?php
use yii\helpers\Html;
use common\models\Img;

$img = Img::getPath(Img::ICON,$attribute['model']->img);
?>

<?= Html::beginTag('div', ['class' => 'form-group row validation-errors']);?>

<?= Html::tag('label',$attribute['label'],['class' => 'col-xs-2 col-form-label']);?>

<div class="col-xs-10">
    <div class="react-component">
    </div>

<!--    <div class="dropzone dropzone-component">
        <div class="dz-message btn btn-default"><span>Загрузить</span></div>
    </div>-->
    <?php echo '';/*\kato\DropZone::widget([
       'options' => [
           'url' => 'categories/upload',
           'maxFilesize' => '2',
           'dictDefaultMessage' => 'Загрузите изображение',
           'acceptedFiles' => 'image/*',
           'dictInvalidFileType'=>'Допускаются только .png, .jpg .jpeg',
           'dictMaxFilesExceeded' => "You can only upload upto 5 images",
           'addRemoveLinks' => 'true',
           'dictRemoveFile' => "Delete",
           'dictCancelUploadConfirmation' => "Are you sure to cancel upload?",
           'init' => new \yii\web\JsExpression("function(file){"
                   . 'var mockFile = { name: "pet.png", size: 12345 };'
                   . 'this.options.addedfile.call(this, mockFile);'
                   . 'this.options.thumbnail.call(this, mockFile, "img/icons/pet.png");'
                   . "}")
       ],
       'clientEvents' => [
           'complete' => "function(file){console.log(file)}",
           'success' => "function(file,response){console.log(response)}",
           'removedfile' => "function(file){alert(file.name + ' is removed')}",
       ],
   ]);*/?>
</div>

<!--<div class="dropzone-component">-->
        <!--<div class="dz-message btn btn-default"><span>Загрузить</span></div>-->
    <!--</div>-->
<?= Html::endTag('div');?>

<script type="text/javascript">

Core.onFullLoad(function(){
    rct.mount('react-dropzone',$('.react-component')[0],{
        dir: 'img/icons',
        djsConfig: {
            url: '<?php echo yii\helpers\Url::toRoute(['categories/icon','id' => $attribute['model']->id])?>',
        }
//        dropzoneSelector: 'div.dropzone'
    });
});
</script>