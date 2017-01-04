<?php
/**
 * File for MainController class
 */
namespace app\components;

use common\models\AuthAssignment;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\validators\StringValidator;
use yii\web\Application;

/**
 * Class MainController
 * @package app\components
 * @author Yurii Gugnin <yurii.gugnin@p-product.com>
 */
class MainController extends Controller
{

    protected function uploadImage($model, $imageField, $old_image = '', $quality = 80){

        if ($image = \yii\web\UploadedFile::getInstance($model, $imageField)) { //$imageField -'image'

            $name = $image->getBaseName();// image 00555.jpg

            $max = $this->getMaxLenght($model, $imageField);  //50 ?

            $ext = $image->extension;  //jpg

            if(strlen($name . '.' . $ext) > $max){
                $name = substr($name, 0, $max - strlen($ext) - 1); //больше 50? обрезаем
            }
            $model->image = $name . '.' . $ext; //00555.jpg

            $imagePath = Yii::getAlias(\common\components\IdToPath::get($model->id,
                Yii::getAlias(Yii::$app->params['images'][$model->tableName()]['path']), true, true)); ///images/topic\9\3

            if ($image->saveAs($imagePath . DIRECTORY_SEPARATOR . $name . '.' . $ext)) {

                $sizes = Yii::$app->params['images'][$model->tableName()]['sizes']; //массив всех sizes c params

                foreach ($sizes as $prefix => $size) {  //
                    \yii\imagine\Image::thumbnail($imagePath . DIRECTORY_SEPARATOR . $name . '.' . $ext,
                        (int)$size[0], (int)$size[1])->save(Yii::getAlias($imagePath . DIRECTORY_SEPARATOR .
                        $prefix . '_' . $name . '.' . $ext, [$quality]));
                }
                if ($name != $old_image && $old_image) {
                    unlink($imagePath . DIRECTORY_SEPARATOR . $old_image);
                    foreach ($sizes as $prefix => $size) {
                        unlink($imagePath . DIRECTORY_SEPARATOR . $prefix . '_' . $old_image);
                    }
                }

                $model->save(false);
            }
        } else {
            if ($old_image) {
                $model->image = $old_image;
                $model->save(false);
            }
        }
    }

    protected function deleteImage($model, $imageField, $image){
        $imagePath = Yii::getAlias(\common\components\IdToPath::get($model->id, Yii::getAlias(Yii::$app->params['images'][$model->tableName()]['path']), true, true));

        $sizes = Yii::$app->params['images'][$model->tableName()]['sizes'];
        unlink($imagePath . DIRECTORY_SEPARATOR . $image);
        foreach ($sizes as $prefix => $size) {
            unlink($imagePath . DIRECTORY_SEPARATOR . $prefix . '_' . $image);
        }
        return \common\components\IdToPath::removePath($model->id, Yii::getAlias(Yii::$app->params['images'][$model->tableName()]['path']));

    }

    private function getMaxLenght($model, $name){
        $validators = $model->getValidators();
        if($validators){
            foreach($validators as $validator){
                if($validator instanceof StringValidator && (isset($validator->max) && !is_null($validator->max)) &&  (array_search($name, $validator->attributes) !== false)){
                    return $validator->max;
                }
            }
        }
        return null;
    }


}