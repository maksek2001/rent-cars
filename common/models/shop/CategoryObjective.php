<?php

namespace common\models\shop;

/**
 * Связка категории с подкатегорией
 * 
 * @property int $category_id
 * @property int $objective_id
 * 
 * @author Spirkov Maksim
 */
class CategoryObjective extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{categories_objectives}}';
    }

    public static function findObjectivesByCategoryId($category_id)
    {
        return static::find()
            ->select('objective_id')
            ->where(['category_id' => $category_id]);
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
