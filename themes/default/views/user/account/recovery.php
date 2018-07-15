<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="h-header-top-null"><?php echo Yii::t('user', 'Restore Password'); ?></h2>

                <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
                <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
                </div>
                <?php else: ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recovery-form',
    'htmlOptions'=>array(
        'class'=>'form-signin',
    ),
)); ?>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <?php echo $form->labelEx($model, 'email', array('class'=>'control-label')); ?>
                <?php echo $form->textField($model, 'email', array('class'=>'form-control input-lg')); ?>
                <?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
            </div>
        </div>
	</div>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <?php $this->widget('CCaptcha', array('clickableImage'=>true, 'buttonLabel'=>CHtml::image(Yii::app()->theme->baseUrl.'/web/img/refresh.png'),'imageOptions'=>array('class'=>'capcha-image', 'alt'=>'Картинка с кодом валидации', 'title'=>'Чтобы обновить картинку, нажмите по ней') )); ?>
                <?php echo $form->textField($model,'verifyCode',array('class'=>'form-control input-lg','placeholder'=>Yii::t('user', 'Enter Code'))); ?>
                <?php echo $form->error($model,'verifyCode',array('class'=>'help-block')); ?>
            </div>
        </div>
	</div>

    <div class="form-group">
		<?php echo CHtml::submitButton(Yii::t('user', 'Restore'), array('class'=>'btn btn-lg btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
<!-- form -->

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>