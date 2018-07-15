<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'role'=>'form',
        'enctype'=>'multipart/form-data',
    ),
)); ?>

    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo Yii::t('user', 'Required fields');?>        
    </div>

	<div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <?php echo $form->labelEx($model,'firstname'); ?>
                <?php echo $form->textField($model,'firstname',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
                <?php echo $form->error($model,'firstname'); ?>
            </div>
        </div>
	</div>

	<div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <?php echo $form->labelEx($model,'lastname'); ?>
                <?php echo $form->textField($model,'lastname',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
                <?php echo $form->error($model,'lastname'); ?>
            </div>
        </div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'uimage'); ?><br>
        <?php
        if ($model->uimage)
        {
            echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/users/'.$model->user_id.'/'.CHtml::encode($model->uimage), $model->firstname.' '.$model->lastname, array('class' => 'img-polaroid'));
            echo "<br>".CHtml::link(Yii::t('user', 'Delete photo'), array('/user/profile/deletephoto'));
        } else {
            echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/nophoto.png', $model->firstname.' '.$model->lastname, array('class' => 'img-polaroid'));
        }
        echo "<br>";
        ?>
        <?php echo $form->fileField($model, 'uimage'); ?>
		<span class="help-inline"><?php echo $form->error($model,'uimage'); ?></span>
	</div>

	<div class="form-group">
        <div class="row">
            <div class="col-lg-6">
                <?php echo $form->labelEx($model,'about'); ?>
                <?php echo $form->textArea($model,'about',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
                <?php echo $form->error($model,'about'); ?>
            </div>
        </div>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Save'),array('class'=>'btn btn-lg btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
<!-- form -->