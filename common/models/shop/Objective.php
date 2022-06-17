<?php

namespace common\models\shop;

/**
 * Подкатегория
 * 
 * @property int $id
 * @property string $name
 * 
 * @author Spirkov Maksim
 */
class Objective extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{objectives}}';
    }

    public static function findByIds($ids)
    {
        return static::find()
            ->where(['in', 'id', $ids])
            ->all();
    }

    public static function getAllObjectives()
    {
        return static::find()->all();
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
