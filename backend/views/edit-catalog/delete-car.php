<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use common\widgets\Alert;

$this->title = 'Удаление автомобиля ';
?>
<div class="edit-form text-center  col-md-4">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'delete-car-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($deleteCarForm, 'car_id')->textInput(['autofocus' => true]) ?>

    <?= Html::submitButton('Удалить автомобиль', ['class' => 'btn btn-secondary']) ?>

    <?php ActiveForm::end(); ?>

</div>