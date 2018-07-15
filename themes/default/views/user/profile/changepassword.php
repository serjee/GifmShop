<div class="row">
    <div class="col-lg-3">
        <div class="bs-sidebar affix">
            <!-- LeftMenu  -->
            <ul class="nav bs-sidenav">
                <li class="li-header"><span><?php echo Yii::t('user','Profile management'); ?></span></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile'); ?>"><?php echo Yii::t('user','My profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/edit'); ?>"><?php echo Yii::t('user','Change profile'); ?></a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('/user/profile/changepassword'); ?>"><?php echo Yii::t('user','Change password'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/delivaddress'); ?>"><?php echo Yii::t('user','Delivery address'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/myorders'); ?>"><?php echo Yii::t('user','My orders'); ?></a></li>
            </ul><!-- /LeftMenu -->
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-default" style="padding:10px;min-height:160px;">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'changepwd-form',
            'htmlOptions'=>array(
                'role'=>'form',
            ),
        )); ?>

            <h2 class="head"><?php echo Yii::t('user', 'Change Password'); ?></h2>

            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo Yii::t('user', 'Required fields');?>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo $form->labelEx($model2,'oldPassword',array('class'=>'control-label')); ?>
                        <?php echo $form->passwordField($model2,'oldPassword',array('class'=>'form-control')); ?>
                        <?php echo $form->error($model2,'oldPassword'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo $form->labelEx($model2,'password',array('class'=>'control-label')); ?>
                        <?php echo $form->passwordField($model2,'password',array('class'=>'form-control')); ?>
                        <?php echo $form->error($model2,'password'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo $form->labelEx($model2,'verifyPassword',array('class'=>'control-label')); ?>
                        <?php echo $form->passwordField($model2,'verifyPassword',array('class'=>'form-control')); ?>
                        <?php echo $form->error($model2,'verifyPassword'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo CHtml::submitButton(Yii::t('user', 'Save'),array('class'=>'btn btn-lg btn-success')); ?>
            </div>

        <?php $this->endWidget(); ?>
        <!-- form -->

        </div>
    </div>
</div>