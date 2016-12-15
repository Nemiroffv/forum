<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property string $id
 * @property string $idtopic
 * @property string $iduser
 * @property integer $reit
 *
 * @property Topic $idtopic0
 * @property User $iduser0
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtopic', 'iduser', 'reit'], 'required'],
            [['idtopic', 'iduser'], 'integer'],
            [['reit'],'safe'],
           [['iduser'], 'safe'],
           // [['idtopic'], 'unique'],
            [['idtopic'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['idtopic' => 'id']],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['iduser' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idtopic' => 'Idtopic',
            'iduser' => 'Iduser',
            'reit' => 'Reit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtopic0()
    {
        return $this->hasOne(Topic::className(), ['id' => 'idtopic']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIduser0()
    {
        return $this->hasOne(User::className(), ['id' => 'iduser']);
    }
}
