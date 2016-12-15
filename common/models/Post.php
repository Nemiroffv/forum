<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $description
 * @property string $creator_id
 * @property string $topic_id
 * @property string $image
 * @property string $creation_date
 *
 * @property Topic $topic
 * @property User $creator
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'creator_id', 'topic_id'], 'required'],
            [['description'], 'string'],
            [['creator_id', 'topic_id'], 'integer'],
            [['creation_date'], 'safe'],
            [['image'], 'string', 'max' => 50],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'creator_id' => 'Creator ID',
            'topic_id' => 'Topic ID',
            'image' => 'Image',
            'creation_date' => 'Creation Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }
}
