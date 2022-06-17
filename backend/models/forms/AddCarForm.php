<?php

namespace backend\models\forms;

use common\models\shop\Car;
use common\models\shop\CarObjective;
use yii\base\Model;

/**
 * Форма для добавления нового автомобиля
 * @author Spirkov Maksim
 */
class AddCarForm extends Model
{

    /** @var string */
    public $name;

    /** @var int */
    public $age;

    /** @var int */
    public $price;

    /** @var int */
    public $rental_price;

    /** @var UploadedFile */
    public $image;

    /** @var string */
    public $transmission;

    /** @var int */
    public $objective;

    /** @var int $power */
    public $power;

    /** @var string */
    public $origin_country;

    /** @var string */
    public $build_country;


    public function attributeLabels()
    {
        return [
            'name' => 'Название автомобиля',
            'age' => 'Время эксплуатации (в годах)',
            'price' => 'Цена',
            'rental_price' => 'Стомость аренды за час',
            'transmission' => 'Трансмиссия',
            'objective' => 'Подкатегория',
            'image' => 'Изображение',
            'power' => 'Мощность',
            'origin_country' => 'Страна изготовления',
            'build_country' => 'Страна сборки'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'age', 'price', 'rental_price', 'transmission', 'objective', 'power', 'origin_country', 'build_country'], 'required', 'message' => 'Обязательное поле!'],
            [['age', 'price', 'rental_price', 'power'], 'double', 'message' => 'Введено не число']
        ];
    }

    /**
     * @param string $image - путь до изображения
     */
    public function addCar($image): bool
    {
        if (!$this->validate())
            return false;

        $car = new Car();

        $car->name = $this->name;
        $car->age = $this->age;
        $car->price = $this->price;
        $car->rental_price = $this->rental_price;
        $car->image = $image;
        $car->transmission = $this->transmission;
        $car->power = $this->power;
        $car->origin_country = $this->origin_country;
        $car->build_country = $this->build_country;

        $car->create();

        $car_objective = new CarObjective();
        $car_objective->car_id = $car->id;
        $car_objective->objective_id = $this->objective;

        $car_objective->create();

        return true;
    }
}
