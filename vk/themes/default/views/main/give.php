<div class="content">
    <div class="admin">
        <div class="title3">Описание для сбора на новый подарок</div>
        <div class="left">
            <form action="" method="post" enctype="multipart/form-data" id="actionform">
                <div class="new_action">
                    <table id="edit_table">
                        <tbody><tr><td>Подарок для:</td><td class="inp"></td></tr>
                        <tbody><tr><td>Повод для сбора:</td><td class="inp"><input name="name" maxlength="60" type="text" id="name"></td></tr>
                        <tr><td>Подробное описание:</td><td class="inp"><textarea name="description" cols="" rows=""></textarea></td></tr>
                        <tr class="period choose_end_block"><td>Дата окончания:</td><td class="inp">
                                <div>
                                    <div class="select1" id="date2" style="z-index: 999;">
                                        <input type="text" class="datepicker" id="to" value="">
                                        <input name="date_end" type="text" value="0" class="settable date_end">
                                    </div>
                                </div>
                            </td></tr>
                        <tr><td></td><td class="align_left"><input type="checkbox" name="only_link" id="only_link"> Сделать акцию видимой только по прямой ссылке</td></tr>
                        <tr class="add_tr2 add_tr2">
                            <td>Скидываемся:</td>
                            <td class="inp">
                                <select id="groupselect">
                                    <option value="0">Со всеми</option>
                                    <option value="1">С друзьями</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="about_friends">
                    <div class="title3">Указать друзей для сбора голосов</div>
                    <div class="friends">Выбрано <span>0</span> друзей (<a href="#">выбрать</a>)</div>
                </div>
                <div class="about_money">
                    <div class="title3">Деньги на подарок</div>
                    <table>
                        <tbody>
                        <tr class="grouptr">
                            <td>Скидываемся по:</td>
                            <td class="inp"><input name="required_sum_group" id="required_sum_group" type="text" value=""> <p>голос.</p></td>
                        </tr>
                        <tr><td>Всего нужно собрать:</td>
                            <td class="inp"><input name="required_sum" id="required_sum" type="text" value=""> <p>голос.</p></td></tr>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" value="0" name="group" id="group">
                <input type="hidden" value="N" name="draft" id="draft">
                <div class="new_action_buttons"><a href="#" class="button2" id="publicbutton">Опубликовать</a>
                    <a href="#" class="button1" id="draftbutton">Сохранить черновик</a>
                </div>
            </form>
        </div>
    </div>
</div>