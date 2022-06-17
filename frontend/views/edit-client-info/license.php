<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Изменение данных водительского удостоверения';
?>
<div class="edit-form col-md-4 text-center">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin([
        'id' => 'license-info-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($licenseInfoForm, 'serie')->textInput(['autofocus' => true]) ?>

    <?= $form->field($licenseInfoForm, 'number')->textInput() ?>

    <?= $form->field($licenseInfoForm, 'issue_date')->textInput(['type' => 'date']); ?>

    <?= $form->field($licenseInfoForm, 'expiration_date')->textInput(['type' => 'date']); ?>

    <?= Html::submitButton('Изменить данные', ['class' => 'btn btn-secondary']) ?>

    <?php ActiveForm::end(); ?>

</div>