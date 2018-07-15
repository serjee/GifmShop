<div class="panel panel-default">
    <div class="panel-body">

        <h1 class="h-header-top-null"><span style="color:#2e2e2e;"><span class="pink-text">Шаг 3 из 3</span> - оформление подарка</span></h1>
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
        ));
        echo $form->hiddenField($model,'order_id',array('value'=>Yii::app()->user->getState('temp_order_id')));
        echo $form->hiddenField($model,'order_hash',array('value'=>Yii::app()->user->getState('temp_order_hash')));
        ?>

        <h2 class="head">3. Выши данные?</h2>
        <div class="row">
            <div class="col-lg-4">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_name.png', 'Кому подарк', array('style'=>'float:left;'));?>
                <h3 class="h-order">Имя?</h3>
                <p class="text-muted">как к Вам обращаться</p>
                <?php echo $form->textField($model,'name',array('class'=>'form-control input-lg','placeholder'=>'Пример: Константин')); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_email.png', 'Кому подарк', array('style'=>'float:left;'));?>
                <h3 class="h-order">E-mail?</h3>
                <p class="text-muted">для уведомлений о заказе</p>
                <?php echo $form->textField($model,'email',array('class'=>'form-control input-lg','placeholder'=>'Пример: konstantin@gifm.ru')); ?>
                <?php echo $form->error($model,'email'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_phone.png', 'Кому подарк', array('style'=>'float:left;'));?>
                <h3 class="h-order">Телефон?</h3>
                <p class="text-muted">чтобы мы могли связаться с Вами</p>
                <?php echo $form->textField($model,'phone',array('class'=>'form-control input-lg','placeholder'=>'Пример: +7 495 1234567')); ?>
                <?php echo $form->error($model,'phone'); ?>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <?php echo CHtml::submitButton('Оформить заказ',array('class'=>'btn btn-lg btn-pink')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>
