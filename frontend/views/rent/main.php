<?php

use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Аренда автомобиля';
?>
<div class="edit-form text-center">
    <h4 style="margin-bottom: 10px;"><?= Html::encode($this->title) ?></h4>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'rent-form',
        'options' => [
            'class' => 'arenda-car justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?php if (!$auth) : ?>
        <p class='warning'>
            Обязательно ознакомьтесь с условиями аренды, прежде чем арендовать автомобиль!<br>
            <u>Ссылка на условия находится в правом верхнем углу ("О нас").</u>
        </p>
    <?php endif; ?>
    <div class="rent-data">
        <?= $form->field($rentForm, 'email')->textInput(['value' => Html::encode($client->email), 'class' => 'date rent-input', 'id' => 'email']); ?>

        <?= $form->field($rentForm, 'rental_price')->textInput(['value' => Html::encode($car->rental_price), 'class' => 'date rent-input disabled-input', 'id' => 'rental-price', 'readonly' => true]); ?>

        <?= $form->field($rentForm, 'start_date')->textInput(['type' => 'datetime-local', 'class' => 'date rent-input', 'id' => 'start-date']); ?>

        <?= $form->field($rentForm, 'end_date')->textInput(['type' => 'datetime-local', 'class' => 'date rent-input', 'id' => 'end-date']); ?>

        <?= HTML::button('Рассчитать стоимость', ['id' => 'calculate-price', 'class' => 'btn btn-secondary rent']); ?>

        <?= $form->field($rentForm, 'total_price')->textInput(['class' => 'price rent-input', 'name' => 'total_price', 'id' => 'total-price', 'readonly' => true]); ?>

        <?= Html::submitButton('Арендовать автомобиль', ['class' => 'btn btn-secondary rent', 'id' => 'rent', 'disabled' => true]) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>