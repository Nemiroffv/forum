<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = 'Create Topic';
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="topic-create">

    <h1><?= Html::encode($this->title) ?></h1>




    <?php $model->name=Yii::$app->request->post()['name']; ?>
    <?php $model->content=Yii::$app->request->post()['content']; ?>


    <?php
    $img=Yii::$app->request->post()['image'];


    $imagine = new Imagine\Gd\Imagine();
    $mode    = Imagine\Image\ImageInterface::THUMBNAIL_INSET;
    $size    = new Imagine\Image\Box(600, 600);

    $imagine->open('images/sfw/'.$img)
        ->thumbnail($size, $mode)
        ->save('images/sfw/'.$img)
    ;


    ?>




    <?= $this->render('@app/views/topic/_form', [
        'model' => $model,
        'img'=>$img,
    ]) ?>

</div>