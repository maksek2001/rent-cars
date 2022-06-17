<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изменение основной информации';
?>
<div class="edit-form col-md-4 text-center">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin([
        'id' => 'client-info-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($clientInfoForm, 'fullname')->textInput(['autofocus' => true]) ?>


    <?= $form->field($clientInfoForm, 'sex')->dropDownList([
        '' => 'Не указан',
        'male' => 'Мужской',
        'female' => 'Женский'
    ]); ?>

    <?= $form->field($clientInfoForm, 'birth_date')->textInput(['type' => 'date']); ?>

    <?= Html::submitButton('Изменить данные', ['class' => 'btn btn-secondary']) ?>

    <?php ActiveForm::end(); ?>

</div>