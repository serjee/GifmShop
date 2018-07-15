<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    'htmlOptions'=>array(
        'role'=>'form',
    ),
)); ?>

<div class="row">
    <div class="col-lg-2">
        <?php echo $form->textField($model,'id',array('class'=>'form-control','maxlength'=>50,'placeholder'=>Yii::t('admin', 'ID'))); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->textField($model, 'price', array('class'=>'form-control','maxlength'=>30,'placeholder'=>Yii::t('admin', 'Price'))); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->dropDownList($model, 'status', array(
                'NEW'=>Yii::t('admin', 'New order'),
                'PAYED'=>Yii::t('admin', 'Payed order'),
                'PROCESS'=>Yii::t('admin', 'Process order'),
                'SHIPPING'=>Yii::t('admin', 'Shipping order'),
                'SENT'=>Yii::t('admin', 'Sent order'),
                'DONE'=>Yii::t('admin', 'Done order'),
                'CANCELED'=>Yii::t('admin', 'Canceled order'),
                'DELETED'=>Yii::t('admin', 'Deleted order')
            ),array('class'=>'form-control')
        ); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->textField($model,'timestamp', array('class'=>'form-control','maxlength'=>20,'placeholder'=>Yii::t('admin', 'Time Create'))); ?>
    </div>
    <div class="col-lg-2">
        <?php echo CHtml::submitButton(Yii::t('admin', 'Search'), array('class'=>'btn btn-success')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<!-- search-form -->