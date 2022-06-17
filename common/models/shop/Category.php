<?php

namespace common\models\shop;

/**
 * Категория
 * 
 * @property int $category_id
 * @property string $name
 * @property string $icon - название файла с иконкой
 * @property string $image - название файла с основным изображнием
 * 
 * @author Spirkov Maksim
 */
class Category extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{categories}}';
    }

    public static function getAllCategories()
    {
        return static::find()->all();
    }

    public static function getHeadCategories($count)
    {
        return static::find()->limit($count)->all();
    }


    public function create(): bool
    {
        return $this->save(false);
    }
}
