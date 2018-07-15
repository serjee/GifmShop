<!-- fire plugin onDocumentReady -->
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript("slideshow","
$(function() {
    $('#carousel').elastislide();
});
",CClientScript::POS_HEAD);
?>

<div id="carousel-example-generic" class="carousel slide" xmlns="http://www.w3.org/1999/html">
    <div class="carousel-inner">
        <div class="item active">
            <a href="/order/create/"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/banners/banner1.png', '');?></a>
        </div>
    </div>
</div>

<hr>

<div class="panel panel-default">
    <div class="panel-body" style="text-align:center;">

    <h1 class="h-header-top-null"><span style="color:#ff9999;">Gifm.RU</span> - это СЮРПРИЗЫ по принципу "Кот в Мешке"!</h1>
    <h3 class="h-header-top-null">специальный проект от <a href="http://itlike.ru/" target="_blank">интернет-магазина готовых подарков "ItLike.RU"</a> для людей,<br>которые обожают сюрпризы и желают рискнуть, заказав "Кота в Мешке"! :)</h3><hr>
    <p class="lead">С удовольствием подберем подарок и сделаем приятный сюрприз для Вас, Ваших родных и друзей!<br>Вы не узнаете то, что мы Вам отправим до тех пор, пока не получите посылку!</p>
    <div class="row" style="text-align:left;">
        <div class="col-lg-3">
            <div class="media">
                <span class="pull-left">
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/money.png', '');?>
                </span>
                <div class="media-body">
                    <h4 class="media-heading">Выберите стоимость</h4>
                    И укажите категорию Вашего подарка!
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="media">
                <span class="pull-left">
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/contact.png', '');?>
                </span>
                <div class="media-body">
                    <h4 class="media-heading">Расскажите о себе</h4>
                    Чтобы нам лучше понять Ваши ожидания!
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="media">
                <span class="pull-left">
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/messages.png', '');?>
                </span>
                <div class="media-body">
                    <h4 class="media-heading">Напишите сообщение</h4>
                    Для открытки! Или мы подберем его сами!
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="media">
                <span class="pull-left">
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/wood.png', '');?>
                </span>
                <div class="media-body">
                    <h4 class="media-heading">Оформите заказ</h4>
                    И оплатите! А мы красиво упакуем и доставим!
                </div>
            </div>
        </div>
    </div>
    <p style="padding-top:20px;"><a href="<?php echo $this->createUrl('order/create');?>" class="btn btn-lg btn-pink" href="#">Получить Сюрприз</a></p>
    <p><script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="link" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug,gplus,surfingbird"></div></p>
    
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body" style="text-align:center;">
        <h2 class="h-header-top-null">Некоторые примеры готовых подарков нашего интернет-магазина</h2>
        <div class="row">
            <div class="col-lg-12">
                <ul id="carousel" class="elastislide-list">
                    <?php
                    $xml = simplexml_load_file(Yii::getPathOfAlias('webroot').'/upload/specoffers/specoffers.xml');
                    foreach($xml->children() as $key)
                    {
                        $imagePath = Yii::app()->baseUrl.'/upload/specoffers/'.$key->image;
                        echo '<li><a href="'.$key->url.'" target="_blank">'.CHtml::image($imagePath, $key->name, array("class"=>"specoffers-img")).'</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>