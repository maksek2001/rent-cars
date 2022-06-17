<?php

namespace common\models\shop;

/**
 * Автомобиль
 * 
 * @property int $id
 * @property string $name
 * @property double $age
 * @property int $price
 * @property int $rental_price
 * @property string $image - название файла с изображением
 * @property string $transmission ('Механическая','Автоматическая','Роботизированная','Вариативная')
 * @property int $power
 * @property string $origin_country
 * @property string $build_country
 * 
 * @author Spirkov Maksim
 */
class Car extends \yii\db\ActiveRecord
{
    public const TYPES_TRANSMISSION = [
        'Механическая' => 'Механическая',
        'Автоматическая' => 'Автоматическая',
        'Роботизированная' => 'Роботизированная',
        'Вариативная' => 'Вариативная'
    ];

    public static function tableName()
    {
        return '{{cars}}';
    }

    public static function findByIds($ids)
    {
        return static::find()
            ->where(['in', 'id', $ids]);
    }

    public static function findMinRentalPriceByIds($ids)
    {
        return static::find()->where(['in', 'id', $ids])->min('rental_price');
    }

    public static function getHeadCars($count)
    {
        return static::find()->limit($count)->all();
    }

    public static function getAllCars()
    {
        return static::find()->all();
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
