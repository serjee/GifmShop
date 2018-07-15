<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('admin', 'Edit delivery'); ?></h3>
    </div>
    <div class="panel-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'address-form',
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array(
                'role'=>'form',
                'class'=>'form-horizontal',
            ),
        )); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model,'zip_code',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textField($model,'zip_code',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'zip_code'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'country_id',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->dropDownList($model,'country_id',Chtml::listData(Country::model()->findAll(array('select'=>'id,name_ru')),'id','name_ru'),array('class'=>'form-control','options'=>array($model->country_id=>array('selected'=>true)))); ?>
                <?php echo $form->error($model,'country_id'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'city',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textField($model,'city',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'city'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'address',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textArea($model,'address',array('rows'=>3,'class'=>'form-control')); ?>
                <?php echo $form->error($model,'address'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'comments',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textArea($model,'comments',array('rows'=>3,'class'=>'form-control')); ?>
                <?php echo $form->error($model,'comments'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'recipient',array('class'=>'col-sm-4 control-label')); ?>
            <div class="col-sm-8">
                <?php echo $form->textField($model,'recipient',array('class'=>'form-control')); ?>
                <?php echo $form->error($model,'recipient'); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <?php echo CHtml::submitButton(Yii::t('admin', 'Save'), array('class'=>'btn btn-success btn-lg')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
        <!-- form -->
    </div>
</div>