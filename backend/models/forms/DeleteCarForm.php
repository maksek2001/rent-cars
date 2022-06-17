<?php

namespace backend\models\forms;

use common\models\shop\Car;
use yii\base\Model;

/**
 * Форма для удаления автомобиля
 * @author Spirkov Maksim
 */
class DeleteCarForm extends Model
{

    /** @var int */
    public $car_id;

    public function attributeLabels()
    {
        return [
            'car_id' => 'ID автомобиля'
        ];
    }

    public function rules()
    {
        return [
            [['car_id'], 'required', 'message' => 'Обязательное поле!'],
            ['car_id', 'double', 'message' => 'Введено не число']
        ];
    }

    public function deleteCar(): ?string
    {
        if (!$this->validate())
            return false;

        $car = Car::findOne($this->car_id);
        $image = null;
        if ($car) {
            $image = $car->image;
            $car->delete();
            // связь автомобиль - подкатегория удаляется благодаря настройке БД
        }
        return $image;
    }
}
