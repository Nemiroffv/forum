<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'content')->widget(CKEditor::className(),[
        'editorOptions' => [
            'options' => ['rows' => 6],
            //'preset' => 'basic',
            'clientOptions'=>[
                'enterMode' => 2,
                'forceEnterMode'=>false,
                'shiftEnterMode'=>1
            ]
        ],
    ])->label('Поместите текст топика сюда'); ?>

    <?php echo $model->image ? Html::img(Yii::getAlias(Yii::$app->params['images']['topic']['webPath']) . '/' . \common\components\IdToPath::get($model->id) . '/b_' .$model->image)  : '';?>
    <?= $form->field($model, 'image')->fileInput() ?>

    <?php echo $model->image ? $form->field($model, 'delete_image')->checkBox(['label' => 'Delete Image']) : '' ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
