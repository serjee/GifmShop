<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('admin', 'Orders Management');?></h1>

<hr />
<?php echo Yii::t('admin', 'Messages of fast filter');?>

<?php echo CHtml::link(Yii::t('admin', 'Show extend search'),'#',array('class'=>'search-button btn btn-warning')); ?>
<div class="search-form" style="display:none;">
    <?php $this->renderPartial('_search',array(
        'model'=>$model,
    )); ?>
</div><!-- search-form -->
<hr />
<br>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'itemsCssClass' => 'table table-striped',
    'htmlOptions' => array('class' => 'filter'),
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
    'columns'=>array(
        array(
            'name'=>'id',
            'type'=>'raw',
            'value'=>'CHtml::link("#".$data->id, "/admin/main/view/id/".$data->id)',
        ),
        array(
            'name'=>'user_id',
            'type'=>'raw',
            'value'=>'CHtml::link($data->user_id, "/admin/user/update/id/".$data->user_id)',
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
            'filter'=>array(
                'NEW'=>Yii::t('admin', 'New order'),
                'PAYED'=>Yii::t('admin', 'Payed order'),
                'PROCESS'=>Yii::t('admin', 'Process order'),
                'SHIPPING'=>Yii::t('admin', 'Shipping order'),
                'SENT'=>Yii::t('admin', 'Sent order'),
                'DONE'=>Yii::t('admin', 'Done order'),
                'CANCELED'=>Yii::t('admin', 'Canceled order'),
                'DELETED'=>Yii::t('admin', 'Deleted order')
            ),
        ),
        'timestamp',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}&nbsp;&nbsp;{update}',
            'buttons'=>array
            (
                'view' => array
                (
                    'label'=>'<span class="glyphicon glyphicon-zoom-in"></span>',
                    'imageUrl'=>false,
                    'url'=>'"/admin/main/view/id/".$data->id',
                    'options'=>array('class'=>'btn btn-info btn-xs','title'=>Yii::t('admin', 'View')),
                ),
                'update' => array
                (
                    'label'=>'<i class="glyphicon glyphicon-pencil"></i>',
                    'imageUrl'=>false,
                    'options'=>array('class'=>'btn btn-xs btn-primary','title'=>Yii::t('admin', 'Edit')),
                ),
            ),
        ),
    ),
)); ?>