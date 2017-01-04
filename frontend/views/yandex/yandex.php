
<?php
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\grid\GridView;


$array2=[];
$c=0;




//unset($array2[13]);

$h=0;
//$puth='C:/Temp1'.pq($cont)->find('img')->attr('src');
//file_put_contents($puth,file_get_contents('http://neurod.ru' .pq($cont)->find('img')->attr('src')));
foreach ($array as $key){
    $h++;
    //mkdir('C:/Temp1'.$h, 0777, true);
   // chmod('C:/Temp1'.$h, 0777);
    //chmod('C:/Temp1'.$h, 0777);
    $puth='C:/OpenServer/OpenServer/domains/forum/frontend/web/images/sfw/'.$h.'.jpg';

    file_put_contents($puth,file_get_contents('http://sfw.so' .$key['img']));

}
 ?>
<div class="topic-form">


<?php for($i=1;$i<count($array);$i++) {

   echo Html::a('Опубликовать тему', ['create'],
        ['class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
                'params' => [
                    'name' => $array[$i]['tema'],
                    'content' => $array[$i]['text'],
                    'image'=> $array[$i]['img'],
                    'i'=>$i.'.jpg'
                ],
            ]]);

   echo Html::img('/images/sfw/'.$i.'.jpg', ['style' => 'width: 150px']);
    echo '<div style="color:red">'.$array[$i]['tema'].'</div>'."<br>";
    echo $array[$i]['text'].'<br>'.'<br>'.'<br>';
}
?>






