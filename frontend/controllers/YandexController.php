<?php
/**
 * Created by PhpStorm.
 * User: slava_s
 * Date: 14.12.2016
 * Time: 16:38
 */

namespace frontend\controllers;
use common\components\IdToPath;
use Yii;
use GuzzleHttp\Client;
use common\models\Post;
use common\models\PostSearch;
use common\models\Rating;
use common\models\Topic;
use common\models\TopicSearch;
use app\components\MainController;
use Imagine\Imagick\Imagine;



use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class YandexController extends MainController
{
    public function actionYandex() {

        // создаем экземпляр класса
        $client = new Client();


        // отправляем запрос к странице Яндекса
        $res = $client->request('GET', 'http://www.sfw.so');
        // получаем данные между открывающим и закрывающим тегами body
        $body = $res->getBody();


        // вывод страницы Яндекса в представление
        $document =\phpQuery::newDocumentHTML($body);

      //  echo iconv("windows-1251", "utf-8", $document);



    //   $imgs=$document['img'];
        $array=[];
        $content=$document->find('.news_id');

       // $content=$document->find('img, div.news_title');
       // $cont=$content->find('span.news_title_red');
        $c=0;
        foreach ($content as $cont) {
              $c++;
            $pq=pq($cont)->find('img')->attr('src');
              $pg['img']=$pq;
     pq($cont)->find('img')->attr('src');


           // file_put_contents('C:/Temp1'.pq($cont)->find('img')->attr('src'), file_get_contents('http://www.neurod.ru/'));
          //  file_put_contents('Http://neurod.ru'.pq($cont)->find('img')->attr('src'),
         //   $puth='C:/Temp1'.pq($cont)->find('img')->attr('src');
         //file_put_contents($puth,file_get_contents('http://neurod.ru' .pq($cont)->find('img')->attr('src')));
       //     file_get_contents('http://neurod.ru'.pq($cont)->find('img')->attr('src')));


            // $z=pq($cont)->find('.img-responsive')->text();
           // $pg['tema']=$z;

                $pg['tema']=pq($cont)->find('img')->attr('alt');
            $pg['text']=pq($cont)->find('b')->text();
                $array[$c]=$pg;
            }






        return $this->render('yandex', ['array' => $array]);

    }
    public function actionSport(){

file_put_contents('cookie.txt','');
//$html=$this->request('https://www.reddit.com/login');
        $post=[
            'op'=>'login',
            'dest'=>'https://www.reddit.com/',
            'user'=>'nemiroffv',
            'passwd'=>'.ggb2504',
        ];
       $html=$this->request('https://www.reddit.com/post/login',$post);
        return $this->render('sport',['html'=>$html]);

    }



    function request( $url,$postdata=null ,$cookiefile='forum/frontend/cookie.txt' )
    {
  $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36)');
        curl_setopt($ch,CURLOPT_COOKIEJAR,$cookiefile);
        curl_setopt($ch,CURLOPT_COOKIEFILE,$cookiefile);

        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

        if($postdata){
            curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        }
        $html=curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    public function actionCreate()
    {
        $model = new Topic();

        //$id=User::find()->where(['identify'=>Yii::$app->user->id])->all();
        // foreach ($id as $key){
        //    $creator=$key->id;
        //}




        $model->creator_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->uploadImage($model, 'image',$model->image.'.jpg' );



            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}
