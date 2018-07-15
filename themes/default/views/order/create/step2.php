<div class="panel panel-default">
    <div class="panel-body">

        <h1 class="h-header-top-null"><span style="color:#2e2e2e;"><span class="pink-text">Шаг 2 из <?php echo (Yii::app()->user->isGuest)?'3':'2';?></span> - оформление подарка</span></h1>
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

        <h2 class="head">Кому его отправить?</h2>

        <?php if (!Yii::app()->user->isGuest) { ?>
        <div class="row">
            <div class="col-lg-6">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_profile.png', Yii::t('user','Delivery profile'), array('style'=>'float:left;'));?>
                <h3 class="h-order">Профиль?</h3>
                <p class="text-muted">для доставки подарка на указанный адрес</p>
                <?php echo $form->dropDownList($model,'id',
                    CMap::mergeArray(array(0=>Yii::t('user','Create new delivery profile')),CHtml::listData(OrdersAddress::model()->findAll('user_id=:user_id', array(':user_id'=>Yii::app()->user->id)),'id','recipient')),
                    array(
                        'ajax' => array(
                            'type'=>'post',
                            'url'=>$this->createUrl('/user/profile/getaddressinfo'),
                            'dataType'=>'json',
                            'data'=>array(
                                'profile_id'=> 'js:this.value',
                                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                            ),
                            'success'=>'function(data) {
                                    if (data === null) {
                                        $("#Step2Form_zip_code").val("");
                                        $("#Step2Form_country_id").val("1").attr("selected",true);
                                        $("#Step2Form_city").val("");
                                        $("#Step2Form_address").val("");
                                        $("#Step2Form_recipient").val("");
                                        $("#Step2Form_comments").val("");
                                    } else {
                                        $("#Step2Form_zip_code").val(data.zip_code);
                                        $("#Step2Form_country_id").val(data.country_id).attr("selected",true);
                                        $("#Step2Form_city").val(data.city);
                                        $("#Step2Form_address").val(data.address);
                                        $("#Step2Form_recipient").val(data.recipient);
                                        $("#Step2Form_comments").val(data.comments);
                                    }
                                }',
                        ),
                        'class' => 'form-control input-lg',
                    )
                );
                echo $form->error($model,'id');
                ?>
            </div>
        </div>
        <hr>
        <?php } else { ?>
            <?php echo $form->hiddenField($model,'id',array('value'=>0)); ?>
        <?php } ?>
        <div class="row">
            <div class="col-lg-3">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_maps.png', Yii::t('user','To gift'), array('style'=>'float:left;'));?>
                <h3 class="h-order">Индекс?</h3>
                <p class="text-muted">получателя</p>
                <?php echo $form->textField($model,'zip_code',array('class'=>'form-control input-lg','placeholder'=>Yii::t('user','Example: 123456'))); ?>
                <?php echo $form->error($model,'zip_code'); ?>
            </div>
            <div class="col-lg-3">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_maps.png', Yii::t('user','Category gift'), array('style'=>'float:left;'));?>
                <h3 class="h-order">Страна?</h3>
                <p class="text-muted">для доставки</p>
                <?php echo $form->dropDownList($model,'country_id',Chtml::listData(Country::model()->findAll(array('select'=>'id,name_ru')),'id','name_ru'),array('class'=>'form-control input-lg')); ?>
                <?php echo $form->error($model,'country_id'); ?>
            </div>
            <div class="col-lg-3">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_maps.png', Yii::t('user','To gift'), array('style'=>'float:left;'));?>
                <h3 class="h-order">Город?</h3>
                <p class="text-muted">для доставки</p>
                <?php echo $form->textField($model,'city',array('class'=>'form-control input-lg','placeholder'=>Yii::t('user','Example: Moscow'))); ?>
                <?php echo $form->error($model,'city'); ?>
            </div>
            <div class="col-lg-3">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_maps.png', Yii::t('user','To gift'), array('style'=>'float:left;'));?>
                <h3 class="h-order">Адрес?</h3>
                <p class="text-muted">для доставки</p>
                <?php echo $form->textArea($model,'address',array('rows'=>3,'class'=>'form-control','placeholder'=>Yii::t('user','Example: Broome Street 15, New York'))); ?>
                <?php echo $form->error($model,'address'); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-4">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_whom2.png', Yii::t('user','To gift'), array('style'=>'float:left;'));?>
                <h3 class="h-order">Получатель?</h3>
                <p class="text-muted">фамилия с полными инициалами</p>
                <?php echo $form->textField($model,'recipient',array('class'=>'form-control input-lg','placeholder'=>Yii::t('user','Example: Ivanov Ivan Ivanovich'))); ?>
                <?php echo $form->error($model,'recipient'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_about.png', Yii::t('user','To gift'), array('style'=>'float:left;'));?>
                <h3 class="h-order">Комментарий?</h3>
                <p class="text-muted">к этому заказу</p>
                <?php echo $form->textArea($model,'comments',array('rows'=>3,'class'=>'form-control','placeholder'=>Yii::t('user','Notice: If you wish to provide additional information'))); ?>
                <?php echo $form->error($model,'comments'); ?>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <?php echo CHtml::submitButton(((Yii::app()->user->isGuest)?Yii::t('user','Next step'):Yii::t('user','Create order')),array('class'=>'btn btn-lg btn-pink')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>
