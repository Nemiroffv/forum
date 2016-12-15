<?php
/**
 * Created by PhpStorm.
 * User: slava_s
 * Date: 14.12.2016
 * Time: 16:38
 */

namespace frontend\controllers;
use Yii;
use GuzzleHttp\Client;

use yii\helpers\Url;


class YandexController extends \yii\web\Controller
{
    public function actionYandex() {

        // создаем экземпляр класса
        $client = new Client();
        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://www.neurod.ru');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();
        // вывод страницы Яндекса в представление
        return $this->render('yandex', ['body' => $body]);
        
    }
}