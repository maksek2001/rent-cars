<?php

use yii\bootstrap5\NavBar;
use yii\helpers\Html;
?>

<header>
    <div class="main-header">
        <?php
        NavBar::begin([
            'brandLabel' => 'Rent Cars',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'header navbar navbar-expand-md navbar-primary fixed-top pt-3 pb-3',
            ],
        ]);
        ?>
        <ul id="w1" class="navbar-nav nav">
            <li class="nav-item">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <a class="nav-link" href="/frontend/web/authentication/registration">
                        Зарегистрироваться
                    </a>
                <?php else : ?>
                    <a class="nav-link" href="/frontend/web/office/main">
                        Личный кабинет
                        <img src="/public/icons/different/home.png" class='icon'>
                    </a>
                <?php endif; ?>
            </li>
            <li class="nav-item">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <a class="nav-link" href="/frontend/web/authentication/login">
                        Войти
                        <img src="/public/icons/different/login.png" class='icon'>
                    </a>
                <?php else : ?>
                    <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline']); ?>
                    <button type="submit" class="btn btn-link logout">
                        Выйти
                        (<?= Yii::$app->user->identity->username ?>)
                        <img src="/public/icons/different/logout.png" class='icon'>
                    </button>
                    <?= Html::endForm(); ?>
                <?php endif; ?>
            </li>
        </ul>
        <ul id="w2" class="navbar-nav right nav">
            <li class="nav-item">
                <a class="nav-link" href="/frontend/web/site/contacts">
                    Контакты
                    <img src="/public/icons/different/contacts.png" class='icon'>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/frontend/web/site/help">
                    О нас
                    <img src="/public/icons/different/help.png" class='icon'>
                </a>
            </li>
        </ul>
        <?php NavBar::end(); ?>
    </div>
</header>