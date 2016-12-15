<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Post;
use yii\widgets\Menu;
use common\models\Topic;
use yii\di\ServiceLocator;
use yii\base\Object;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сказки ';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div><?php

    $test=Topic::find()->all();

   // foreach ($test as $key) {

  //      echo Menu::widget([

   //         'items' => [
 //               ['label' => $key->name, 'url' => \yii\helpers\Url::toRoute(['/topic/view']) . '?id=' . $key->id]

  //          ],


  //      ]);
 //   }
    ?>
</div>
<div class="topic-index">


    <?php

    // echo $this->render('_search', ['model' => $searchModel]);
  $session=Yii::$app->session;
    $session->open();
    $session->set('a',33);


    ?>
    <?php
    $id1=User::find()->where(['identify'=>Yii::$app->user->id])->all();
    foreach ($id1 as $key){
        $creator=$key->id;
    }

    $id=Yii::$app->user->id;
    if(!is_numeric($id)){
        $id=$creator;
}
    ?>
    <div><?= (!Yii::$app->user->id==$model->creator_id)?
            Html::a('Редактировать профиль', ['users/update','id'=>$id], ['class' => 'btn btn-success']):''

        ?> </div>

    <p>
        <?= (!Yii::$app->user->id==$model->creator_id)?
            Html::a('Создать тему', ['create'], ['class' => 'btn btn-success']):'Для создания темы Вам нужно зарегистрироваться ' ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['id' => $model->id, 'onclick' => 'document.location="'.\yii\helpers\Url::toRoute(['/topic/view']) . '?id=' . $model->id.'";'];
        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value'=>function($data){
        //var_dump(Yii::getAlias(Yii::$app->params['images']['topic']['webPath']) . '/' . \common\components\IdToPath::get($data->id) . '/b_' .$data->image);die();
                    //$id=str_replace(".","/",$data->id/10);

                    return '<h1 style="color: red;">'.$data->name.'</h1>'.'<br>'.Html::img(Yii::getAlias(Yii::$app->params['images']['topic']['webPath']) .
                        '/' . \common\components\IdToPath::get($data->id, null, true, false, true) . '/b_' .$data->image);

                  // return $data->name.'<br>'.Html::img(Yii::getAlias(Yii::$app->params['images']['topic']['webPath']) . '/' . $id . '/b_' .$data->image);

                },
                'format' => 'html',
                'label'=>'Имя топика'
            ],
            [
                'attribute' => 'creator_id',
                'value' => function($data){
                    $test=Post::find()->where(['creator_id'=>$data->creator->id])->all();
                    $test1=count($test);

                     return '<h3>'.$data->creator->username.'</h3>'.'<br>'.Html::img(Yii::getAlias(Yii::$app->params['images']['user']['webPath']) . '/'
                        . \common\components\IdToPath::get($data->creator->id, null, true, false, true) . '/s_' .$data->creator->image).
                     '<br>'.'Сообщений-('.$test1.')'.'<br>'.'Вход -'.date( 'Y : M : d (h.i)',($data->creator->logged_at));


                },
                'format'=>'html',
                'label'=>'Юзер'

            ],
            [
                'attribute' => 'creation_date',
                'value' => function($data){
                    return substr($data->creation_date, 0, -3);
                }
            ],
           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
