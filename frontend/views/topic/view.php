<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\base\Object;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\models\Rating;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php
if($propusk)
{
    $prop=$propusk;
    $mesege='Ваш голос учтен';

}


//echo 'Рейтинг с базы-'.$sum.'<br>'.'Всего голосов с базы-'.$ch.'<br>'.$mesege.'Ваш последний голос-'.$d;

?>



<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<?php /*
<script>
    $(document).ready(function() {
            $('#rating1').click(function() {


                var s=$.get('http://wviewsforum.s-host.net/topic/go?id='.id,"json");
                console.log(s);
            });
    });
</script>

*/?>
<?php $id=$model->id;
?>
<script>
    $(document).ready(function() {
        $('#rating1').click(function() {

           $.getJSON( "/topic/go?id="+<?php echo $id ?>, function( data ) {
               console.log(data.percents);
               $("#vstavka").css("width", data.percents+"px");
               $("#vstavka1").html(data.percents+"%");
               $("#rezult").html(data.rezult);
           })});})
</script>




<script type="text/javascript" src="http://scriptjava.net/source/scriptjava/scriptjava.js"></script>

<script>

    function send(a) {
$.ajax({
url: 'http://wviewsforum.s-host.net/topic/view?id='.id,
data: {index: a},
type: 'POST',
error: function () {
alert('Error!');
}
});
}
function go(b){

  if (b==1){

     // document.getElementById("lol1").style.backgroundImage="url(http://wviewsforum.s-host.net/images/star-on.png)";

      document.getElementById("rating1").innerHTML="<div><img src='/images/fo1.png'</div>";


  }
  if(b==2){



      document.getElementById("rating1").innerHTML="<div><img src='/images/fo2.png'</div>";
  }
    if(b==3){



        document.getElementById("rating1").innerHTML="<div><img src='/images/fo3.png'</div>";
    }
    if(b==4){



        document.getElementById("rating1").innerHTML="<div><img src='/images/fo.png'</div>";

    }

    if(b==5){



        document.getElementById("rating1").innerHTML="<div><img src='/images/fo5.png'</div>";






    }

}

</script>




<?php  Pjax::begin(['id' => 'new_relode']) ?>
<?php $form = ActiveForm::begin(['method'=>'post']); ?>

<div class="rating" id="rating1" style="width: 90px;" >


    <span class="rating star0" id="lol5" onclick="send(5);go(5);"><img src="/images/star-off.png" title=""></span>
    <span class="rating star0" id="lol4" onclick="send(4);go(4);"><img src="/images/star-off.png" title=""></span>
    <span class="rating star0" id="lol3" onclick="send(3);go(3);"><img src="/images/star-off.png" title=""></span>
    <span class="rating star0" id="lol2" onclick="send(2);go(2);"><img src="/images/star-off.png" title=""></span>
    <span class="rating star0" id="lol1" onclick="send(1);go(1);"><img src="/images/star-off.png" title=""></span>


</div>
Всего голосов
<span id="rezult"><?php echo $ch?></span>


<div style="border: 2px ridge black;width:100px">
    <?php $id=$model->id;?>

    <div id="vstavka" style="width:<?php echo $sum*20 ?>px;background-color: red">
    <b id="vstavka1"><?php echo ($sum*20).'%' ?> </b>
</div>

</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<?php

if($d>0){

}
        $this->registerJs('go('.$d.')');



?>

<?php if(Yii::$app->user->isGuest){
    $this->registerJs('go('.round($sum).')');

}  ?>


<div class="topic-view">

    <h1><?= $this->title ?></h1>

    <p>


        <?= (Yii::$app->user->id==$model->creator_id
        //or $b->username==$c->profile['name']
    )?Html::a('Редактирование поста', ['update', 'id' => $model->id],
            ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->id==$model->creator_id )?Html::a('Удалить пост', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <div>
        <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="//yastatic.net/share2/share.js"></script>
        <div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir"></div>
    </div>
<?php ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'creator_id',
                'value' => $model->creator->username,
                'label'=>''

            ],
            'creation_date',
            [   'attribute'=>'image',
                'value'=>$model->creator->id==3?Html::img(Yii::getAlias('/'.'images/topic/sfw/1.jpg')):
                    Html::img(Yii::getAlias(Yii::$app->params['images']['topic']['webPath']) . '/' . \common\components\IdToPath::get($model->id, null, true, false, true) . '/b_' .$model->image),
                'format'=>'html'
            ],
            [    'attribute'=>'content',
                'value'=>$model->content,
                'format'=>'html'
            ]

        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'description',
                'format' => 'html',
                'filter' => false,
                'contentOptions'=>['style'=>'width: 350px;']
            ],
            [
                'attribute' => 'creator_id',
                'value' => function($data){
                    return Html::img(Yii::getAlias(Yii::$app->params['images']['user']['webPath']) . '/'
                        . \common\components\IdToPath::get($data->creator->id, null, true, false, true) . '/s_' .$data->creator->image).$data->creator->username . ' в ' . substr($data->creation_date, 0, -3);
                },
                'filter' => false,
                'format'=>'html'
            ],
        ],
    ]); ?>


    <?= (!Yii::$app->user->isGuest)?$this->render('_formPost', [
        'model' => $modelPost,
    ]):'Чтобы оставить сообщение вам нужно авторизироваться!' ?>


<?php /*
    <?php  Pjax::begin(['id' => 'new_relode']) ?>
    <?php $form = ActiveForm::begin(['method'=>'post']); ?>
    <div class="comment-point">
        <div class="cp-content">
            <div class="point-stars">
                <div class='starrr' id='star2'></div>
                <br />
                <input name="value" id="input-21c" value="5" type="number" class="rating" min=0 max=10 step=0.5 data-size="xl" data-stars="10">
            </div>
        </div>
    </div>

    <div class="cc-bottom">
        <?= Html::submitButton(Yii::t('app','Проголосовать'),['class'=>"ccb-button",'id'=>'commentsubmit',' data-commentfilmid'=>"887"]); ?>



</div>

<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
*/?>



