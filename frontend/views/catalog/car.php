<?php

use yii\helpers\Html;

$this->title = Yii::$app->name;
?>
<div class="category-container">
    <div class='car'>
        <a href="../public/images/cars/<?= Html::encode($car->image) ?>" target='_blank'>
            <img class='car-image' src="/public/images/cars/<?= Html::encode($car->image) ?>" alt='изображение автомобиля'>
        </a>
        <div class="car-info-container">
            <p class='car-number'>Автомобиль №<?= Html::encode($car->id) ?></p>
            <p class='car-name'><?= Html::encode($car->name) ?></p>
            <div class="car-control">
                <p class='price'> Стоимость аренды: <?= Html::encode($car->rental_price) ?> ₽/час</p>
                <p class='arenda'>
                    <a class='a-button' href="../rent/main?car_id=<?= $car->id ?>">
                        Арендовать
                    </a>
                </p>
            </div>
            <div class="car-info">
                <div class="left-info">
                    <p> <u>Мощность:</u>
                        <?= $car->power ? Html::encode($car->power) . ' л.с.' : 'Не указана' ?>
                    </p>
                    <p> <u>Время эксплуатации (в годах):</u>
                        <?= $car->age ? Html::encode($car->age) : 'Не указано' ?>
                    </p>
                    <p> <u>Страна изготовления:</u>
                        <?= $car->origin_country ? Html::encode($car->origin_country) : 'Не указана' ?>
                    </p>
                </div>
                <div class="right-info">
                    <p> <u>Страна сборки:</u>
                        <?= $car->build_country ? Html::encode($car->build_country) : 'Не указана' ?>
                    </p>
                    <p> <u>Стоимость:</u>
                        <?= $car->price ? Html::encode($car->price) . ' руб' : 'Не указана' ?>
                    </p>
                    <p> <u>Трансмиссия:</u>
                        <?= $car->transmission ? Html::encode($car->transmission) : 'Не указана' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>