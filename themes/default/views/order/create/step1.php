<div class="panel panel-default">
    <div class="panel-body">

    <h1 class="h-header-top-null"><span style="color:#2e2e2e;"><span class="pink-text">Шаг 1 из <?php echo (Yii::app()->user->isGuest)?'3':'2';?></span> - оформление подарка</span></h1>
    <hr />

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'order-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'role'=>'form',
        ),
    )); ?>

    <h2 class="head">Каким он должен быть?</h2>

    <div class="row">
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_money.png', 'Цена подарка', array('style'=>'float:left;'));?>
            <h3 class="h-order">Сколько?</h3>
            <p class="text-muted">Вы готовы пожертвовать на подарок?</p>
            <?php
                $modelPrice = Prices::model()->findAll(array('select'=>'id,price_ru'));
                echo $form->dropDownList($model,'price',CMap::mergeArray(array(/*0=>'Всего Рубль!'*/),Chtml::listData($modelPrice,'id', function($modelPrice){ return number_format($modelPrice->price_ru, 0, '.', ' ').' руб.'; })),array('class'=>'form-control input-lg','options'=>array('1'=>array('selected'=>true))));
            ?>
            <?php echo $form->error($model,'price'); ?>
        </div>
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_catalog.png', 'Категория подарка', array('style'=>'float:left;'));?>
            <h3 class="h-order">Какой?</h3>
            <p class="text-muted">подарк Вы ожидаете</p>
            <?php echo $form->dropDownList($model,'category_id',CMap::mergeArray(array(0=>'Любой'),Chtml::listData(Categories::model()->findAll(array('select'=>'id,name_ru')),'id','name_ru')),array('class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model,'category_id'); ?>
        </div>
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_whom.png', 'Кому подарк', array('style'=>'float:left;'));?>
            <h3 class="h-order">Кому?</h3>
            <p class="text-muted">Вы дарите подарок</p>
            <?php echo $form->dropDownList($model, 'whom',
                array('ALL'=>'Неважно', 'MAN'=>'Мужчине', 'WOMAN'=>'Женщине', 'CHILDBOY'=>'Ребёнку-мальчику','CHILDGIRL'=>'Ребёнку-девочке' ),
                array('class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model,'whom'); ?>
        </div>
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_age.png', 'Кому подарк', array('style'=>'float:left;'));?>
            <h3 class="h-order">Возраст?</h3>
            <p class="text-muted">того, для кого этот подарок</p>
            <?php echo $form->textField($model,'age',array('class'=>'form-control input-lg','placeholder'=>'Пример: 19')); ?>
            <?php echo $form->error($model,'age'); ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_hobby.png', 'Кому подарк', array('style'=>'float:left;'));?>
            <h3 class="h-order">Увлечения?</h3>
            <p class="text-muted">человека, для которого этот подарок</p>
            <?php echo $form->textArea($model,'hobbies',array('rows'=>4,'class'=>'form-control','placeholder'=>'Чтобы мы смогли подобрать сюрприз по вкусу, заполните это поле.')); ?>
            <?php echo $form->error($model,'hobbies'); ?>
        </div>
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_about.png', 'Кому подарк', array('style'=>'float:left;'));?>
            <h3 class="h-order">Расскажите?</h3>
            <p class="text-muted">о пожеланиях и ожиданиях</p>
            <?php echo $form->textArea($model,'about',array('rows'=>4,'class'=>'form-control','placeholder'=>'Чтобы мы смогли подобрать сюрприз совсем-совсем по вкусу, заполните это поле.')); ?>
            <?php echo $form->error($model,'about'); ?>
        </div>
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_otkr.png', 'Кому подарк', array('style'=>'float:left;'));?>
            <h3 class="h-order">Открытка?</h3>
            <p class="text-muted">с Вашим текстом или с нашим</p>
            <?php echo $form->textArea($model,'message',array('rows'=>4,'class'=>'form-control','placeholder'=>'Ваш текст либо Ваши пожелания, чтобы мы составили его сами! Не заполняйте, если открытка не нужна!')); ?>
            <?php echo $form->error($model,'message'); ?>
        </div>
        <div class="col-lg-3">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_name.png', 'Кому подарк', array('style'=>'float:left;'));?>
            <h3 class="h-order">От кого?</h3>
            <p class="text-muted">будет указано в открытке</p>
            <?php echo $form->textField($model,'prize_from',array('class'=>'form-control input-lg','placeholder'=>'Пример: Дед Мороз')); ?>
            <?php echo $form->error($model,'prize_from'); ?>
            <p class="text-muted">а также, от этого поля будет зависеть и оформление открытки!</p>
        </div>
    </div>
    <hr>
    <div class="text-center">
        <?php echo CHtml::submitButton('Следующий шаг',array('class'=>'btn btn-lg btn-pink')); ?>
    </div>

    <?php $this->endWidget(); ?>

    </div>
</div>