<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'role'=>'form',
    ),
)); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'email'); ?>
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50,'placeholder'=>Yii::t('admin', 'E-mail'),'class'=>'form-control input-lg')); ?>
                </div>
                <?php echo $form->error($model,'email',array('class'=>'text-error')); ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'password'); ?>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <?php echo $form->textField($model,'password',array('maxlength'=>32,'placeholder'=>Yii::t('admin', 'Password'),'class'=>'form-control input-lg','value'=>'')); ?>
                </div>
                <?php if(!$model->isNewRecord) echo '<p class="muted small">'.Yii::t('admin', 'If you no want to change password').'</p>'; ?>
                <?php echo $form->error($model,'password',array('class'=>'text-error')); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'role'); ?>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-registration-mark"></span></span>
                    <?php echo $form->dropDownList($model, 'role', array('ADMIN'=>Yii::t('admin', 'Admin'), 'MODERATOR'=>Yii::t('admin', 'Moderator'), 'USER'=>Yii::t('admin', 'User')),array('class'=>'form-control input-lg')); ?>
                </div>
                <?php echo $form->error($model,'role',array('class'=>'text-error')); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->labelEx($model,'enabled'); ?>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-eye-close"></span></span>
                    <?php echo $form->dropDownList($model, 'enabled', array('0'=>Yii::t('admin', 'No active'), '1'=>Yii::t('admin', 'Active')),array('class'=>'form-control input-lg')); ?>
                </div>
                <?php echo $form->error($model,'enabled',array('class'=>'text-error')); ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group text-center">
		        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Save'), array('class'=>'btn btn-success btn-lg')); ?>
            </div>
        </div>
	</div>

<?php $this->endWidget(); ?>
<!-- form -->