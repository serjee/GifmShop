<div class="container">
    <p>
        <?=Yii::t('admin', 'Powered by');?> <a rel="nofollow" href="http://<?=Yii::t('admin', 'www.yiilite.com');?>" target="_blank" title="<?=Yii::t('admin', 'Company Name');?>"><?=Yii::t('admin', 'www.yiilite.com');?></a><br />
        <!-- for debug -->
        <?=Yii::t('admin', 'Generate time');?>: <?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?>s. <?=Yii::t('admin', 'Memory used');?>: <?=round(memory_get_peak_usage()/(1024*1024),2)."Mb"?><br />
        <!-- /for debug -->
    </p>
</div>