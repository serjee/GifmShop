// Один раз объявляем функцию, потом используем так, как в примере
jQuery.fn.exists = function() {
    return $(this).length;
}

// Переменная инициализации
var g_init = false;
// Месяцы для календаря
var months = ['января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];

// Функции не относящиеся к VK
$(document).ready(function() {

    // Проверяем поле даты, если не пустое, заполняем сегодняшним числом
    if ($('#date2').exists()) {
        $( "#to" ).datepicker({
            onSelect: function( selectedDate ) {
                var instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
                var datestamp = $.datepicker.parseDate('yy-mm-dd', selectedDate, instance.settings);
                var textdate = datestamp.getDate() + ' ' + months[datestamp.getMonth()];
                date.setDate(date.getDate() - 1);
                $('.date_end').val(selectedDate);
                $(this).val(textdate);
            }
        });

        var tmp = new Date();
        var date2 = $('#date2 .datepicker').datepicker("getDate");
        $('#date2 .datepicker').datepicker("option", "minDate", tmp);
        var textdate = tmp.getDate() + ' ' + months[tmp.getMonth()];
        $('#to').val(textdate);
    }

    // Показываем поле выбора друзей, если в форме выбрано "Для друзей"
    if($('#groupselect :selected').val() == 1) {
        $('.about_friends, .grouptr').slideToggle('slow');
        $('#group').val(1);
        //VK.callMethod('resizeWindow', 770, $('.wrapper').height());
    }
    $('#groupselect').change(function(){
        $('.about_friends, .grouptr').fadeToggle('slow', function(){
            if($('#groupselect').val() == 0)
                VK.callMethod('resizeWindow', 770, $('.wrapper').height());
        });
        $('#group').val() == 0 ? $('#group').val(1) : $('#group').val(0);
        setTimeout(function() {VK.callMethod('resizeWindow', 770, $('.wrapper').height());}, 70);
    });
});

// Инициализация вконтакте, если прошла, устанавливаем флаг TRUE
VK.init(function() {
    g_init = true;
});

// Ожидаем готовность загрузки страницы
$(document).ready(function() {
    setTimeout('init()', 100);

    // Инициализация API вконтакте
    VK.init(function() {
        // API initialization succeeded
        VK.callMethod("showInstallBox");

        VK.loadParams(document.location.href);
        var viewer_id = VK.params.viewer_id;

        // Подгоняем высоту IFrame под высоту окна приложения
//        var hframe = $('.wrapper').height();
//        VK.callMethod('resizeWindow', 840, hframe);

        //VK.api("friends.get",{"fields":"uid,first_name,nickname,last_name,photo"},friends_callback);
        //VK.addCallback("onBalanceChanged", balance_changed_callback);
        //VK.addCallback("onApplicationAdded", app_added_callback);
        //VK.addCallback("onSettingsChanged", app_settings_callback);
    }, function() {
        // API initialization failed
        // Can reload page here
    }, '5.23');

    // От кого публиковать не будет

});

// Функция инициализации приложения
function init()
{
    if (!g_init)
    {
        $('#message').html('Инициализация приложения...');
        setTimeout('init()', 100);
        return;
    }

    VK.loadParams(document.location.href);
//    var viewer_id = VK.params.viewer_id;

    //$('#message').html('Аудио файлы на вашей странице');
}

//function getaudio()
//{
//    VK.api('audio.get', {}, function (data) {
//        if (!data.response) return;
//
//        var html = '';
//        for (var i=0;i<data.response.count;i++)
//        {
//            html += '<a href="'+data.response[i].url+'">'+data.response[i].title+'</a>';
//        }
//
//        $('#auido').html(html);
//    });
//}

