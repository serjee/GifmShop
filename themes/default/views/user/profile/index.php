<?php if(Yii::app()->user->hasFlash('editMessage')): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo Yii::app()->user->getFlash('editMessage'); ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-3">
        <div class="bs-sidebar affix">
            <!-- LeftMenu  -->
            <ul class="nav bs-sidenav">
                <li class="li-header"><span><?php echo Yii::t('user','Profile management'); ?></span></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('/user/profile'); ?>"><?php echo Yii::t('user','My profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/edit'); ?>"><?php echo Yii::t('user','Change profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/changepassword'); ?>"><?php echo Yii::t('user','Change password'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/delivaddress'); ?>"><?php echo Yii::t('user','Delivery address'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/myorders'); ?>"><?php echo Yii::t('user','My orders'); ?></a></li>
            </ul><!-- /LeftMenu -->
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-default" style="padding:10px;min-height:160px;">
            <div style="float:left;">
            <?php
            if ($model->uimage) {
                echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/users/'.$model->user_id.'/'.CHtml::encode($model->uimage), $model->firstname.' '.$model->lastname, array('class' => 'img-polaroid'));
            } else {
                echo CHtml::image(Yii::app()->theme->baseUrl.'/web/img/nophoto.png', $model->firstname.' '.$model->lastname, array('class' => 'img-polaroid'));
            }
            ?>
            </div>
            <div style="margin-left:160px;">
                <p style="font-size:22px;"><strong>
                <?php
                    if($model->firstname == '' && $model->lastname == '')
                        echo str_replace("{linkname}", '<a href='.Yii::app()->createUrl('/user/profile/edit').'>'.Yii::t('user','Edit field').'</a>', Yii::t('user','Your name [{linkname}]'));
                    else
                        echo $model->firstname . ' ' . $model->lastname;
                ?>
                </strong></p>
                <p>
                <?php
                    if ($model->about == '')
                        echo str_replace("{linkname}", '<a href='.Yii::app()->createUrl('/user/profile/edit').'>'.Yii::t('user','Edit field').'</a>', Yii::t('user','About you [{linkname}]'));
                    else
                        echo $model->about;
                ?>
                </p>
            </div>
        </div>
    </div>
</div>

