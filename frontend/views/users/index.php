<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="http://scriptjava.net/source/scriptjava/scriptjava.js"></script>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'auth_key',
            'password_hash',
            //'password_reset_token',
            // 'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'image',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


 <script>
function send(a) {
    $.ajax({
        url: 'http://wviewsforum.s-host.net/users/index',
        data: {test: 'Peredani dannie cherez AJAX', index: a},
        type: 'POST',
        success: function (res) {

            console.log(res);
        },
        error: function () {
            alert('Error!');
        }
    });
}
    


</script>
</div>

    <div class="rating">



        <span class="rating star0" onclick="send(1)"><img src="/images/star-off.png" title=""></span>
        <span class="rating star0" onclick="send(2)"><img src="/images/star-off.png" title=""></span>
        <span class="rating star0" onclick="send(3)"><img src="/images/star-off.png" title=""></span>
        <span class="rating star0" onclick="send(4)"><img src="/images/star-off.png" title=""></span>
        <span class="rating star0" onclick="send(5)"><img src="/images/star-off.png" title=""></span>




    </div>







<?php
//debug(Yii::$app->user->identity);



/*
<div id="result">Тут будет ответ от сервера</div><br /><br />
<div onclick="SendPost()"><img src="/images/stars.png"></div>

<script type="text/javascript">


    function SendPost() {

        //отправляю POST запрос и получаю ответ

        $$a({

            type:'post',//тип запроса: get,post либо head

            url:'views/users/index.php',//url адрес файла обработчика

            data:{'z':'1'},//параметры запроса
            async:true,

            response:'text',//тип возвращаемого ответа text либо xml

            success:function (data) {//возвращаемый результат от сервера

                $$('result',$$('result').innerHTML+'<br />'+data);

            }

        });
</script>



          <?php if(isset($_POST['z'])) {
            header("Content-type: text/txt; charset=UTF-8");
            if($_POST['z']=='1') {
                echo 'запрос POST успешно обработан, z = 1';
            }
            else {
                echo 'карявый POST запрос';
            }
        } ?>

*/

