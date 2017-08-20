<?php

/* @var $this yii\web\View */

$this->title = 'Объявления - Уфа';
?>
<div class="ads-list">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <div id="custom-search-input">
        <div class="input-group col-md-12">
            <input type="text" class="  search-query form-control" placeholder="Search" />
            <span class="input-group-btn">
                <button class="btn btn-danger" type="button">
                    <span class=" glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
<?php for ($i=0; $i<10;$i++){?>
    <div class="media">
        <a class="pull-left" href="#">
        <img class="media-object" src="http://placekitten.com/150/150">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="#">ЖК Монитор BenQ E2000WA с Гарантией на 3 Месяца </a> | <span class="price">10000$</span></h4>
            <div class="media-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate.</div>
                <ul class="list-inline list-unstyled">
                            <li><span><i class="glyphicon glyphicon-calendar"></i> 2 days, 8 hours </span></li>
                    <li>|</li>
                <span><i class="glyphicon glyphicon-comment"></i> 2 comments</span>
                    <li>|</li>
                    <li>
                       <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                    </li>
                    <li>|</li>
                </ul>
        </div>
    </div>
<?php } ?>
</div>