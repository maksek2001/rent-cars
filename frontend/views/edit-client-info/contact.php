<?php

use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изменение контактной информации';
?>
<div class="edit-form col-md-4 text-center">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php
    Alert::begin([
        'options' => [
            'class' => 'alert-error text-center justify-content-center',
        ],
    ]);
    ?>
    <?php Yii::$app->session->hasFlash('error') ?>

    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'contact-info-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>


    <?= $form->field($contactInfoForm, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($contactInfoForm, 'phone')->textInput() ?>

    <?= Html::submitButton('Изменить данные', ['class' => 'btn btn-secondary']) ?>

    <?php ActiveForm::end(); ?>

</div>