<div class="row-fluid">
    <div class="span12">
        <div class="pay_head">Оплата через платежную систему QIWI Wallet</div>

<?php if(Yii::app()->user->hasFlash('error')) { ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php } elseif(Yii::app()->user->hasFlash('success')) { ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php } else { ?>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'choosePayment',
        'htmlOptions'=>array('class'=>'form'),
    ));
    echo $form->hiddenField($model,'order_id',array('value'=>$order->id));
    ?>

    <div class="form-group">
        <label class="required">Укажите Ваш телефон в системе QIWI Wallet</label>
        <div class="row">
            <div class="col-lg-6">
                <?php echo $form->textField($model,'phone',array('class'=>'form-control','placeholder'=>'Пример: +71234567890')); ?>
                <span class="help-inline"><?php echo $form->error($model,'phone'); ?></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo CHtml::submitButton('Выставить мне счет',array('class'=>'btn btn-lg btn-success')); ?>
    </div>
    <?php $this->endWidget(); ?>

<?php } ?>
    </div>
</div>