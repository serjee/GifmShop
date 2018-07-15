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

    <h1><?php echo Yii::t('admin', 'Transaction Management');?></h1>
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
            'header'=>'Пользователь',
            'name'=>'user_id',
            'type'=>'raw',
            'value'=>'CHtml::link($data->user_id, "/admin/user/update/id/".$data->user_id)',
        ),
        array(
            'header'=>'Заказ',
            'name'=>'id',
            'type'=>'raw',
            'value'=>'CHtml::link("#".$data->id, "/admin/main/view/id/".$data->id)',
        ),
        array(
            'header'=>'Сумма заказа',
            'name'=>'amount',
            'value'=>'$data->amount." ".$data->currency',
        ),
        array(
            'header'=>'Плат. система',
            'name'=>'pay_system',
            'value'=>'$data->pay_system',
        ),
        array(
            'header'=>'Статус',
            'name'=>'state',
            'value'=>'$data->state',
            'filter'=>array(
                'I'=>'Иницилизирован',
                'P'=>'Преордер',
                'R'=>'Результат',
                'S'=>'Выполнен',
                'F'=>'Ошибка'
            ),
        ),
        array(
            'header'=>'Дата',
            'name'=>'timestamp',
            'value'=>'$data->timestamp',
        ),
    ),
)); ?>