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

use yii\helpers\ArrayHelper;
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
        $document =\phpQuery::newDocumentHTML($body);
        $imgs=$document['img'];
        $array=[];
        foreach ($imgs as $img) {
            // Note: $img must be used like "pq($img)"
          $pg=pq($img)->attr('src');
          array_push($array,$pg);
        }



        $title = $document->find(".news_title");

        return $this->render('yandex', ['array' => $array]);

    }
}
