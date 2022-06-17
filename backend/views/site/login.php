<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use common\widgets\Alert;

$this->title = 'Панель администратора ' . Yii::$app->name;
?>
<div class="edit-form col-md-4 text-center">
    <h3><?= Html::encode($this->title) ?></h3>

    <p>Пожалуйста, заполните поля для авторизации</p>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($loginForm, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($loginForm, 'password')->passwordInput() ?>

    <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-secondary']) ?>


    <?php ActiveForm::end(); ?>

</div>