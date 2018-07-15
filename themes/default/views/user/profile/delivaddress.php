<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript("formedit","
var zipcode = $('#OrdersAddress_zip_code');
if(zipcode.val() < 1) zipcode.val('');
",CClientScript::POS_READY);
?>

<?php if(Yii::app()->user->hasFlash('editMessage')): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">X</button>
        <?php echo Yii::app()->user->getFlash('editMessage'); ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-3">
        <div class="bs-sidebar affix">
            <!-- LeftMenu  -->
            <ul class="nav bs-sidenav">
                <li class="li-header"><span><?php echo Yii::t('user','Profile management'); ?></span></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile'); ?>"><?php echo Yii::t('user','My profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/edit'); ?>"><?php echo Yii::t('user','Change profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/changepassword'); ?>"><?php echo Yii::t('user','Change password'); ?></a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('/user/profile/delivaddress'); ?>"><?php echo Yii::t('user','Delivery address'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/myorders'); ?>"><?php echo Yii::t('user','My orders'); ?></a></li>
            </ul><!-- /LeftMenu -->
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-default" style="padding:10px;min-height:160px;">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'address-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'role'=>'form',
                ),
            )); ?>

            <h2 class="head"><?php echo Yii::t('user', 'Delivery address'); ?></h2>

            <div class="row">
                <div class="col-lg-6">
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_profile.png', Yii::t('user','Delivery profile'), array('style'=>'float:left;'));?>
                    <h3 class="h-order">Профиль?</h3>
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
                                        $("#OrdersAddress_zip_code").val("");
                                        $("#OrdersAddress_country_id").val("1").attr("selected",true);
                                        $("#OrdersAddress_city").val("");
                                        $("#OrdersAddress_address").val("");
                                        $("#OrdersAddress_recipient").val("");
                                        $("#OrdersAddress_comments").val("");
                                    } else {
                                        $("#OrdersAddress_zip_code").val(data.zip_code);
                                        $("#OrdersAddress_country_id").val(data.country_id).attr("selected",true);
                                        $("#OrdersAddress_city").val(data.city);
                                        $("#OrdersAddress_address").val(data.address);
                                        $("#OrdersAddress_recipient").val(data.recipient);
                                        $("#OrdersAddress_comments").val(data.comments);
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
            <div class="row">
                <div class="col-lg-3">
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_maps.png', Yii::t('user','To gift'), array('style'=>'float:left;'));?>
                    <h3 class="h-order">Индекс?</h3>
                    <p class="text-muted">получателя</p>
                    <?php echo $form->textField($model,'zip_code',array('class'=>'form-control input-lg','placeholder'=>Yii::t('user','Example: 123456'))); ?>
                    <?php echo $form->error($model,'zip_code'); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/order_icon/order_maps.png',Yii::t('user','To gift'), array('style'=>'float:left;'));?>
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
                <div class="col-lg-5">
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
                <?php echo CHtml::submitButton(Yii::t('user','Save'),array('class'=>'btn btn-lg btn-pink')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
