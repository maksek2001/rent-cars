<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use common\widgets\Alert;

$this->title = 'Добавление нового автомобиля ';
?>
<div class="edit-form text-center col-md-6">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'add-car-form',
        'options' => [
            'class' => 'justify-content-center',
            'enctype' => 'multipart/form-data'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($addCarForm, 'name')->textInput(['autofocus' => true]) ?>

    <?= $form->field($addCarForm, 'age')->textInput() ?>

    <?= $form->field($addCarForm, 'price')->textInput(); ?>

    <?= $form->field($addCarForm, 'rental_price')->textInput(); ?>

    <?= $form->field($addCarForm, 'transmission')->dropDownList($typesTransmission); ?>

    <?= $form->field($addCarForm, 'objective')->dropDownList($objectives) ?>

    <?= $form->field($addCarForm, 'power')->textInput(); ?>

    <?= $form->field($addCarForm, 'origin_country')->textInput(); ?>

    <?= $form->field($addCarForm, 'build_country')->textInput(); ?>

    <?= $form->field($addCarForm, 'image')->fileInput(); ?>

    <?= Html::submitButton('Добавить автомобиль', ['class' => 'btn btn-secondary']) ?>

    <?php ActiveForm::end(); ?>

</div>