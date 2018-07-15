<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('admin', 'View delivery'); ?></h3>
    </div>
    <div class="panel-body">
        <?php if(Yii::app()->user->hasFlash('updateAdress')): ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('updateAdress'); ?>
            </div>
        <?php endif; ?>
        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width:140px;">Индекс:</th>
                <td><?php echo $data->zip_code;?></td>
            </tr>
            <tr>
                <th>Страна:</th>
                <td>
                    <?php
                    if($data->country_id > 0)
                    {
                        $countModel = Country::model()->findByPk($data->country_id);
                        echo $countModel->name_ru;
                    } else { echo 'Не задана'; }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Город:</th>
                <td><?php echo $data->city;?></td>
            </tr>
            <tr>
                <th>Адрес:</th>
                <td><?php echo $data->address;?></td>
            </tr>
            <tr>
                <th>Получатель:</th>
                <td><?php echo $data->recipient;?></td>
            </tr>
            <tr>
                <th>Комментарий:</th>
                <td><?php echo $data->comments;?></td>
            </tr>
            </tbody>
        </table>
        <p><a href="http://www.russianpost.ru/autotarif/SelautotarifRus.aspx" target="_blank">Рассчитать стоимость почтовых отправлений по России</a>.</p>
        <p><a href="http://www.russianpost.ru/autotarif/Selautotarif.aspx" target="_blank">Расчитать стоимость Международных почтовых отрпавлений</a>.</p>
    </div>
</div>