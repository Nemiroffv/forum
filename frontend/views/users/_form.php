<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?php $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?php $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php $form->field($model, 'status')->textInput() ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <?php



$photosc=Yii::$app->user->identity['photo_big'];
    if($model->image){echo Html::img(Yii::getAlias(Yii::$app->params['images']['user']['webPath']) . '/' .
        \common\components\IdToPath::get($model->id) . '/b_' .$model->image); 'Аватарка';}
        else echo Html::img($photosc);

        ?>
    <?= $form->field($model, 'image')->fileInput() ?>
    <?php  //echo $model->image ? $form->field($model, 'update_image')->checkBox(['label' => 'Update Image']) : '' ?>

    <?php  echo $model->image ? $form->field($model, 'delete_image')->checkBox(['label' => 'Delete Image']) : '' ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
