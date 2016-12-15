<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "topic".
 *
 * @property string $id
 * @property string $name
 * @property string $image
 * @property string $creator_id
 * @property string $creation_da
 *
 * @property Post[] $posts
 * @property User $creator
 */
class Topic extends \yii\db\ActiveRecord
{
    public $delete_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'creator_id'], 'required'],
            ['content','string'],
            [['creator_id'], 'integer'],
            [['creation_date', 'delete_image'], 'safe'],
            [['name', 'image'], 'string', 'max' => 50],
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
            'name' => 'Name',
            'image' => 'Image',
            'creator_id' => 'Creator ID',
            'creation_date' => 'Creation Date',
            'content'=>'content'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }
}
