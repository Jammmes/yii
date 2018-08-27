<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id ИД
 * @property string $name Название события
 * @property string $start_at Начало события
 * @property string $end_at Окончание события
 * @property string $created_at Запись создана
 * @property string $updated_at Запись  изменена
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_at', 'end_at', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Название события',
            'start_at' => 'Начало события',
            'end_at' => 'Окончание события',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись  изменена',
        ];
    }
}
