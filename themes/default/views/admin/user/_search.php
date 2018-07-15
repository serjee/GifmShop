<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    'htmlOptions'=>array(
        'role'=>'form',
    ),
)); ?>

<div class="row">
    <div class="col-lg-2">
        <?php echo $form->textField($model,'email',array('class'=>'form-control','maxlength'=>50,'placeholder'=>Yii::t('admin', 'E-mail'))); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->dropDownList($model, 'role', array('ADMIN'=>Yii::t('admin', 'Admin'), 'MODERATOR'=>Yii::t('admin', 'Moderator'), 'USER'=>Yii::t('admin', 'User')),array('class'=>'form-control')); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->textField($model,'time_update',array('class'=>'form-control','maxlength'=>30,'placeholder'=>Yii::t('admin', 'Time Update'))); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->dropDownList($model,'enabled',array('0'=>Yii::t('admin', 'No active'), '1'=>Yii::t('admin', 'Active')),array('class'=>'form-control')); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->textField($model,'ip',array('class'=>'form-control','maxlength'=>20,'placeholder'=>Yii::t('admin', 'IP address'))); ?>
    </div>
    <div class="col-lg-2">
        <?php echo CHtml::submitButton(Yii::t('admin', 'Search'), array('class'=>'btn btn-success')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<!-- search-form -->