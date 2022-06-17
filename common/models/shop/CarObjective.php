<?php

namespace common\models\shop;

/**
 * Связка автомобиля с подкатегорией
 * 
 * @property int $car_id
 * @property int $objective_id
 * 
 * @author Spirkov Maksim
 */
class CarObjective extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{cars_objectives}}';
    }

    public static function findCarIdsByObjectiveId($objective_id)
    {
        return static::find()
            ->select('car_id')
            ->where(['objective_id' => $objective_id]);
    }

    public static function findCarIdsByObjectiveIds($ids)
    {
        return static::find()
            ->select('car_id')
            ->where(['in', 'objective_id', $ids]);
    }

    public static function findAllObjectivesForCar($car_id)
    {
        return static::find()
            ->select('objective_id')
            ->where(['car_id' => $car_id]);
    }

    public function create(): bool
    {
        return $this->save(false);
    }
}
