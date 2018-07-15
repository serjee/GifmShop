<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::t('admin', 'View order'); ?></h3>
    </div>
    <div class="panel-body">
        <?php if(Yii::app()->user->hasFlash('updateOrder')): ?>
            <div class="alert alert-success">
                <?php echo Yii::app()->user->getFlash('updateOrder'); ?>
            </div>
        <?php endif; ?>
        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width:180px;">Номер заказа:</th>
                <td>#<?php echo $data->id;?></td>
            </tr>
            <tr>
                <th>Статус заказа:</th>
                <td><?php echo $data->getWordStatusById($data->status);?></td>
            </tr>
            <tr>
                <th>Сумма заказа:</th>
                <td><?php echo number_format($data->price, 0, ',', ' ') . ' ' . $data->getCurrencyByCode($data->currency);?></td>
            </tr>
            <tr>
                <th>Дата заказа:</th>
                <td><?php echo $data->timestamp;?></td>
            </tr>
            <tr>
                <th>Почтовый ID:</th>
                <td><?php echo $data->mail_id;?></td>
            </tr>
            <tr>
                <th>Ваше сообщение:</th>
                <td><?php echo $data->msg_to_user;?></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <h4>Пожелания пользователя</h4>
        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width:180px;">Категория:</th>
                <td>
                    <?php
                    if($data->category_id > 0)
                    {
                        $catModel = Categories::model()->findByPk($data->category_id);
                        echo $catModel->name_ru;
                    } else { echo 'Неважно'; }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Кому:</th>
                <td><?php echo $data->getWhomByCode($data->whom); ?></td>
            </tr>
            <tr>
                <th>Возраст:</th>
                <td>
                    <?php
                    if($data->age > 0)
                        echo $data->age;
                    else
                        echo 'Неважно';
                    ?>
                </td>
            </tr>
            <tr>
                <th>Увлечения:</th>
                <td><?php echo $data->hobbies; ?></td>
            </tr>
            <tr>
                <th>О себе:</th>
                <td><?php echo $data->about; ?></td>
            </tr>
            <tr>
                <th>Подарок от:</th>
                <td><?php echo $data->prize_from; ?></td>
            </tr>
            <tr>
                <th>Текст на открытке:</th>
                <td><?php echo $data->message; ?></td>
            </tr>
            </tbody>
        </table>

            </tbody>
        </table>
    </div>
</div>