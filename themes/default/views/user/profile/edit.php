<?php if(Yii::app()->user->hasFlash('editMessage')): ?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">?</button>
    <?php echo Yii::app()->user->getFlash('editMessage'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-3">
        <div class="bs-sidebar affix">
            <!-- LeftMenu  -->
            <ul class="nav bs-sidenav">
                <li class="li-header"><span><?php echo Yii::t('user','Profile management'); ?></span></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile'); ?>"><?php echo Yii::t('user','My profile'); ?></a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('/user/profile/edit'); ?>"><?php echo Yii::t('user','Change profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/changepassword'); ?>"><?php echo Yii::t('user','Change password'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/delivaddress'); ?>"><?php echo Yii::t('user','Delivery address'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/myorders'); ?>"><?php echo Yii::t('user','My orders'); ?></a></li>
            </ul><!-- /LeftMenu -->
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-default" style="padding:10px;min-height:160px;">
            <h2 class="head"><?php echo Yii::t('user', 'Edit Profile'); ?></h2>
            <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
