<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php echo $model->image ? Html::img(Yii::getAlias(Yii::$app->params['images']['topic']['webPath']) . '/'
        . \common\components\IdToPath::get($model->id) . '/b_' .$model->image)  : '';?>
    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => [
            'options' => ['rows' => 6],
            //'preset' => 'basic',
            'clientOptions'=>[
                'enterMode' => 2,
                'forceEnterMode'=>false,
                'shiftEnterMode'=>1
            ]
        ],
    ])->label('Ответ'); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


</div>
    <?php ActiveForm::end(); ?>

</div>
