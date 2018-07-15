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
        <?php echo $form->textField($model, 'amount', array('class'=>'form-control','maxlength'=>30,'placeholder'=>Yii::t('admin', 'Price'))); ?>
    </div>
    <div class="col-lg-2">
        <?php echo $form->dropDownList($model, 'state', array(
                'I'=>'Иницилизирован',
                'P'=>'Преордер',
                'R'=>'Результат',
                'S'=>'Выполнен',
                'F'=>'Ошибка'
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