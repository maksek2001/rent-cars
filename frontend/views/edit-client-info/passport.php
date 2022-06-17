<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изменение паспортных данных';
?>
<div class="edit-form col-md-4 text-center">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin([
        'id' => 'passport-info-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($passportInfoForm, 'serie')->textInput(['autofocus' => true]) ?>

    <?= $form->field($passportInfoForm, 'number')->textInput() ?>

    <?= $form->field($passportInfoForm, 'issue_date')->textInput(['type' => 'date']); ?>

    <?= $form->field($passportInfoForm, 'issue_organization')->textInput(); ?>

    <?= $form->field($passportInfoForm, 'organization_code')->textInput(); ?>

    <?= Html::submitButton('Изменить данные', ['class' => 'btn btn-secondary']) ?>

    <?php ActiveForm::end(); ?>

</div>