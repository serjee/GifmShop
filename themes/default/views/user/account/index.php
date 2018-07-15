<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="h-header-top-null"><?php echo Yii::t('user', 'Login');?></h2>

                <p class="text-muted"><?php echo Yii::t('user', 'Please fill out the following form with your login credentials');?></p>

                <?php $form1=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                    'htmlOptions'=>array(
                        'role'=>'form',
                    ),
                ));?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $form1->labelEx($model_login,'email',array('class'=>'control-label')); ?>
                            <?php echo $form1->textField($model_login,'email',array('class'=>'form-control input-lg')); ?>
                            <?php echo $form1->error($model_login,'email',array('class'=>'help-block')); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $form1->labelEx($model_login,'password',array('class'=>'control-label')); ?>
                            <?php echo $form1->passwordField($model_login,'password',array('class'=>'form-control input-lg')); ?>
                            <?php echo $form1->error($model_login,'password',array('class'=>'help-block')); ?>
                        </div>
                    </div>
                </div>

                <div class="checkbox">
                    <?php echo $form1->label($model_login,$form1->checkBox($model_login,'rememberMe').' '.Yii::t('user', 'Remember me next time'),array('for'=>' Login Form Remember Me')); ?>
                    <?php echo $form1->error($model_login,'rememberMe'); ?>
                </div>

                <div class="form-group footer-bottom-null">
                    <div class="row">
                        <div class="col-lg-3">
                            <?php echo CHtml::submitButton(Yii::t('user', 'Auth'),array('class'=>'btn btn-success btn-lg')); ?>
                        </div>
                        <div class="col-lg-9" style="line-height:45px;">
                            <a href="<?=Yii::app()->createUrl('/user/account/recovery') ?>"><?php echo Yii::t('user', 'Lost password');?>?</a>
                        </div>
                    </div>
                </div>

                <?php $this->endWidget(); ?>
                <!-- form -->
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="h-header-top-null"><?php echo Yii::t('user', 'Registration');?></h2>

                <?php if(Yii::app()->user->hasFlash('registrationMessage')): ?>
                    <div class="success">
                        <?php echo Yii::app()->user->getFlash('registrationMessage'); ?>
                    </div>
                <?php else: ?>

                    <p class="text-muted"><?php echo Yii::t('user', 'Please fill out the following form with your registration credentials');?></p>

                    <?php $form2=$this->beginWidget('CActiveForm', array(
                        'id'=>'reg-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions'=>array(
                            'role'=>'form',
                        ),
                    )); ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo $form2->labelEx($model_reg,'email',array('class'=>'control-label')); ?>
                                <?php echo $form2->textField($model_reg,'email',array('class'=>'form-control input-lg')); ?>
                                <?php echo $form2->error($model_reg,'email',array('class'=>'help-block')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo $form2->labelEx($model_reg,'password',array('class'=>'control-label')); ?>
                                <?php echo $form2->passwordField($model_reg,'password',array('class'=>'form-control input-lg')); ?>
                                <?php echo $form2->error($model_reg,'password',array('class'=>'help-block')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo $form2->labelEx($model_reg,'confirmPassword',array('class'=>'control-label')); ?>
                                <?php echo $form2->passwordField($model_reg,'confirmPassword',array('class'=>'form-control input-lg')); ?>
                                <?php echo $form2->error($model_reg,'confirmPassword',array('class'=>'help-block')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php $this->widget('CCaptcha', array('clickableImage'=>true, 'buttonLabel'=>CHtml::image(Yii::app()->theme->baseUrl.'/web/img/refresh.png'),'imageOptions'=>array('class'=>'capcha-image', 'alt'=>'Картинка с кодом валидации', 'title'=>'Чтобы обновить картинку, нажмите по ней') )); ?>
                                <?php echo $form2->textField($model_reg,'verifyCode',array('class'=>'form-control input-lg','placeholder'=>Yii::t('user', 'Enter Code'))); ?>
                                <?php echo $form2->error($model_reg,'verifyCode',array('class'=>'help-block')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group footer-bottom-null">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo CHtml::submitButton(Yii::t('user', 'Registration'),array('class'=>'btn btn-lg btn-success')); ?>
                            </div>
                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                    <!-- form -->
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>