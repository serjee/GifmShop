<div class="row">
    <div class="col-lg-3">
        <div class="bs-sidebar affix">
            <!-- LeftMenu  -->
            <ul class="nav bs-sidenav">
                <li class="li-header"><span><?php echo Yii::t('user','Profile management'); ?></span></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile'); ?>"><?php echo Yii::t('user','My profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/edit'); ?>"><?php echo Yii::t('user','Change profile'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/changepassword'); ?>"><?php echo Yii::t('user','Change password'); ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/user/profile/delivaddress'); ?>"><?php echo Yii::t('user','Delivery address'); ?></a></li>
                <li class="active"><a href="<?php echo Yii::app()->createUrl('/user/profile/myorders'); ?>"><?php echo Yii::t('user','My orders'); ?></a></li>
            </ul><!-- /LeftMenu -->
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-default" style="padding:10px;min-height:160px;">
            <h2 class="head"><?php echo Yii::t('user', 'Delivery address'); ?></h2>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'user-grid',
                'dataProvider'=>$model->search(),
                //'filter'=>$model,
                'summaryText'=>'',
                'emptyText'=>'У Вас пока нет заказов.',
                'itemsCssClass' => 'table table-striped',
                'pagerCssClass'=>'',
                'pager'=> array(
                    'header' => false,
                    'firstPageLabel' => '<<',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'lastPageLabel' => '>>',
                    'htmlOptions' => array(
                        'class' => 'pagination'
                    ),
                ),
                //'htmlOptions' => array('class' => 'filter'),
                'columns'=>array(
                    array(
                        'name'=>'id',
                        'type'=>'raw',
                        'value'=>'CHtml::link("#".$data->id, "/order/create/info/id/".$data->id)',
                    ),
                    array(
                        'name'=>'profile_id',
                        'value'=>'$data->getProfileById($data->profile_id)',
                    ),
                    array(
                        'name'=>'price',
                        'value'=>'$data->price." ".$data->currency',
                    ),
                    array(
                        'name'=>'status',
                        'value'=>'$data->getWordStatusById($data->status)',
                    ),
                    'timestamp',
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array
                        (
                            'view' => array
                            (
                                'label'=>'<span class="glyphicon glyphicon-zoom-in"></span>',
                                'imageUrl'=>false,
                                'url'=>'"/order/create/info/id/".$data->id',
                                'options'=>array('class'=>'btn btn-info btn-xs','title'=>Yii::t('user', 'View')),
                            ),

                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
