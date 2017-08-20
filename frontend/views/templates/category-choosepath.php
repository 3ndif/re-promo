<div class="col-canvas">
<ul class="wrapper">
    <li class="report-column">
        <header>Выберите категорию</header>
        <div>
            <div class="list-group list-cust">
                <?php foreach ($categories as $category) { ?>
                <a href="javascript:void(0)" class="list-group-item" data-id="<?= $category->id?>">
                    <?= $category->i18n->name?>
                </a>
                <?php } ?>
            </div>
        </div>
    </li>
</ul>
</div>

<script type="text/javascript">
Core.onFullLoad(function(){
    $('body').on('click','.report-column .list-group-item',function(){
        var $this = $(this),
            data_id = $this.attr('data-id')

        $.ajax({
            type: "POST",
            url: '/categories/json',
            data: {
                data_id: data_id
            },
            dataType: 'html',
            success: function (data) {

            }
        })
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