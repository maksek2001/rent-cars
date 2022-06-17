<?php

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <div class="main-header">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'header navbar navbar-expand-md navbar-primary fixed-top pt-3 pb-3',
                ],
            ]);
            ?>
            <?php if (!Yii::$app->user->isGuest) : ?>
                <ul id="w1" class="navbar-nav nav">
                    <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline']); ?>
                    <button type="submit" class="btn btn-link logout">
                        Выйти
                        (<?= Yii::$app->user->identity->username ?>)
                        <img src="/public/icons/different/logout.png" class='icon'>
                    </button>
                    <?= Html::endForm(); ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/backend/web/site/index">
                            Главная
                            <img src="/public/icons/different/home.png" class='icon'>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/backend/web/edit-catalog/main">
                            Управление каталогом
                            <img src="/public/icons/different/edit.png" class='icon'>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
            <?php NavBar::end(); ?>
        </div>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container-fluid main-container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <?= $this->render('main/footer.php'); ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>