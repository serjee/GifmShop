<?php
/**
 * QiwiClass class - реализация REST протокола для Qiwi
 * Yii extension for working with API
 *
 * USAGE:
 * $api = new QiwiClass();
 * $response = $api->createBill($bill_id, $user, $amount);
 * echo $response['response']['result_code'];
 *
 * @author Bashkov Sergey <ser.bsh@gmail.com>
 * @copyright  Copyright (c) 2013 Bashkov S.
 * @version 1.0, 2013-10-02
 */

/**
 * Define the name of the config file
 */
define('CONFIG_FILE','qiwi.php');

class QiwiClass
{
    private $apiurl = 'https://w.qiwi.com/api/v2/prv/240964/bills/';

    private $username;

    private $password;

    /**
     * Инициализация
     *
     * @var $username string login
     * @var $password string user password
     * @var $data_format string data format (xml or json)
     * @var $ssl boolean define HTTP or SSL connection
     */
    public function __construct()
    {
        // initialize config
        $config = require(Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.CONFIG_FILE);
        $this->setConfig($config);
    }

    /**
     * Загрузка параметров из конфига
     * @param array $config Config parameters
     * @throws CException
     */
    private function setConfig($config)
    {
        if(!is_array($config))
            throw new CException("Configuration options must be an array!");

        foreach($config as $key=>$val)
        {
            $this->$key=$val;
        }
    }

    /**
     * Отправка PUT запроса
     *
     * @param string $bill_id ID of bill
     * @param array $data Request data
     * @throws Exception
     * @return mixed Array of result or Exception
     */
    private function putRequest($bill_id, $data)
    {
        // Массив с заголовками
        $headers = array(
            'Accept: text/json',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
        );

        // создаем временный файл
        $putData = tmpfile();

        // Записываем данные для передачи методом PUT во временный файл
        fwrite($putData, $data);

        // Перемещаемся к началу файла
        fseek($putData, 0);

        // Инициализируем CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiurl . $bill_id );
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Устанавливаем заголовки запроса и данные BASIC авторизации
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->username.":".$this->password);

        // Устанавливаем режим SSL-шифрования
        curl_setopt($curl, CURLOPT_SSLVERSION,3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        // Используем PUT метод, т.е. -XPUT
        curl_setopt($curl, CURLOPT_PUT, true);

        // Вместо POST используем эти установки
        curl_setopt($curl, CURLOPT_INFILE, $putData);
        curl_setopt($curl, CURLOPT_INFILESIZE, strlen($data));

        // Выполняем запрос
        $output = curl_exec($curl);

        // Закрываем (удаляем) временный файл
        fclose($putData);

        // Останавливаем CURL
        curl_close($curl);

        return json_decode($output);
    }

    /**
     * Отправка GET запроса от
     *
     * @param string $bill_id ID of bill
     * @throws Exception
     * @return mixed Array of result or Exception
     */
    private function getRequest($bill_id)
    {
        // Массив с заголовками
        $headers = array(
            'Accept: text/json',
        );

        // Инициализируем CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiurl . $bill_id );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Устанавливаем заголовки запроса и данные BASIC авторизации
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->username.":".$this->password);

        // Устанавливаем режим SSL-шифрования
        curl_setopt($curl, CURLOPT_SSLVERSION,3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        // Выполняем запрос
        $output = curl_exec($curl);

        // Останавливаем CURL
        curl_close($curl);

        return json_decode($output);
    }

    /**
     * Выставить счет пользователю
     *
     * @param $bill_id
     * @param $user
     * @param $amount
     * @param string $ccy
     * @param string $comment
     * @param string $lifetime
     * @param string $pay_source
     * @param string $prv_name
     * @return mixed
     * @internal param array output
     */
    public function createBill($bill_id, $user, $amount, $ccy='RUB', $comment='', $lifetime='+30 days', $pay_source='qw', $prv_name='DomCentre.com')
    {
        $date_str = date("Y-m-d|H:i:s",strtotime($lifetime));
        $date_arr = explode("|", $date_str);
        $putData =  'user='.urlencode('tel:'.$user).
                    '&amount='.urlencode($amount).
                    '&ccy='.urlencode($ccy).
                    '&comment='.urlencode($comment).
                    '&lifetime='.urlencode($date_arr[0]).'T'.urlencode($date_arr[1]).
                    '&pay_source='.urlencode($pay_source).
                    '&prv_name='.urlencode($prv_name);

        return $this->putRequest($bill_id, $putData);
    }

    /**
     * Проверка счета
     *
     * @param $bill_id
     * @return mixed
     * @internal param array output
     */
    public function statusBill($bill_id)
    {
        return $this->getRequest($bill_id);
    }
    
    /**
     * Получение логина
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->username;
    }
    
    /**
     * Получение пароля
     *
     * @return string
     */
    public function getPasswd()
    {
        return $this->password;
    }

    /*
        switch ($output->result->)
        {
            case '5' :
                throw new Exception('Неверный формат параметров запроса');
                break;

            case '13' :
                throw new Exception('Сервер занят, повторите запрос позже!');
                break;

            case '150' :
                throw new Exception('Ошибка авторизации!');
                break;

            case '210' :
                throw new Exception('Счет не найден!');
                break;

            case '215' :
                throw new Exception('Счет с таким ID уже существует!');
                break;

            case '241' :
                throw new Exception('Сумма слишком мала!');
                break;

            case '242' :
                throw new Exception('Сумма слишком велика!');
                break;

            case '298' :
                throw new Exception('Кошелек с таким номером не зарегистрирован!');
                break;

            case '300' :
                throw new Exception('Техническая ошибка!');
                break;

            default :
                return $output;
        }
        */

}