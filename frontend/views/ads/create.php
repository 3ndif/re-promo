<?php
use frontend\widgets\ChoosePathForm;
//var_dump(Yii::$app->controller->onlycontent);die;
?>

<div id="create-ads" class="panel panel-info">
    <div class="panel-heading">Новое объявление</div>
    <div class="panel-body">
    <form id="my-awesome-dropzone" action="/new-ads" method="POST" enctype="multipart/form-data" >
        <div class="form-group validation">
            <select class="form-control" name="category">
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category->id?>"><?= $category->i18n->name?></option>
            <?php } ?>
            </select>
        </div>

        <div class="chooseway"></div>



        <div class="form-group validation">
            <label for="heading">Заголовок</label>
            <input id="heading" class="form-control" placeholder="..." type="text" name="title">
        </div>

        <div class="form-group validation">
            <label for="text">Описание</label>
            <textarea id="text" class="form-control"
                      placeholder="Опишите товар..."
                      type="text"
                      rows="8"
                      name="desc"></textarea>
        </div>

        <div class="form-group validation">
            <label>Стоимость</label>
            <div class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <input id="price" class="form-control" type="text" name="price">
                    </div>
                </div>
            </div>
        </div>

        <div id="img" class="form-group validation">
            <!--<input type="file" name="file" multiple/>-->
        </div>

        <div class="upload-gallery">

        <div id="dZUpload" class="dropzone">
<!--            <div class="dz-default dz-message">hello</div>-->
            <div class="btn btn-default dz-message">Загрузить</div>

        </div>

        <div id="previewzone"></div>
        </div>

        <div class="well">
            <p>
                Ваше объявление появится на сайте в ближайшие 15минут после проверки модератора,
                перед добавлением, вы можете <a>проверить</a> как будет ваше объявление
            </p>
            <div class="btn btn-default fulldata-form" data-input="#my-awesome-dropzone" data-link="/new-ads">Добавить</div>
        </div>
    </form>
    </div>
</div>

<div id="template-preview" style="display: none">
        <div class="dz-preview dz-file-preview dz-image-preview" id="dz-preview-template">
                <div class="dz-image"><img data-dz-thumbnail /></div>
                <div class="dz-details">
                    <div class="dz-filename"><span data-dz-name></span></div>
                    <div class="dz-size" data-dz-size></div>
                </div>
                <!--<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>-->
                <div class="dz-success-mark"><span>✔</span></div>
                <!--<div class="dz-error-mark"><span></span></div>-->
                <div class="dz-remove" data-dz-remove></div>
                <!--<div class="dz-error-message"><span data-dz-errormessage></span></div>-->
        </div>
</div>

<script type="text/javascript">
Core.onFullLoad(function(){

    rct.mount('chooseway',$('.chooseway')[0],{
        url: '/categories/json',

    })

});
</script>

<style>
    .col-canvas {
        border: 5px dashed #939393;
        height: 500px;
        overflow-y: hidden;
        overflow-x: auto;
    }

    .col-canvas .wrapper {
        list-style: none;
        white-space: nowrap;
    }

    .col-canvas .report-column {
        height: 460px;
        border: 2px solid #3f3f3f;
        background-color: #f2f2f2;
        margin-top: 5px;
        border-radius: 0px 3px 0px 3px;
        padding: 10px;
        width: 200px;
        display: -moz-inline-box;
        display: inline-block;
    }

    .report-column header {
        font-weight: bold;
        text-transform: capitalize;
        text-align: center;
        padding-bottom: 5px;
    }

      .list-cust .list-group-item:first-child {
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
    }

    .list-cust .list-group-item:last-child {
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
    }
    .list-cust .list-group-item {
       border-right:0px;
       border-left:0px;
    }
    .list-group :not(:first-child) {
        background-color: #EEE;

    }
</style>