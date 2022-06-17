<?php

use yii\helpers\Html;

$this->title = Yii::$app->name;
?>
<div class="main-info">
    <div style="display:inline-flex; width: 100%;">
        <div class="left-block">
            <div class="w3-content w3-display-container">
                <?php if ($cars != NULL) : ?>
                    <?php foreach ($cars as $car) : ?>
                        <img class="mySlides slider-img" src="/public/images/cars/<?= Html::encode($car->image) ?>" alt="<? Html::encode($car->name) ?>">
                    <?php endforeach; ?>
                    <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width: 100%;">
                        <div class="w3-left w3-hover-text-orange" onclick="plusDivs(-1)">&#10094;</div>
                        <div class="w3-right w3-hover-text-orange" onclick="plusDivs(1)">&#10095;</div>
                        <?php for ($i = 1; $i <= count($cars); $i++) : ?>
                            <span class="w3-badge demo w3-border w3-transparent w3-hover-white" onclick="currentDiv(<?= $i ?>)"></span>
                        <?php endfor ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php $this->registerJsFile('js/animateImages.js'); ?>
        </div>
        <div class="right-block">
            <h4 class="custom-h">
                <strong>Акции </strong>
                <img src="/public/icons/different/sale.png" class='menu-icon'>
            </h4>
            <ul style="list-style: none; margin-left: 0; padding: 15px;">
                <li>
                    <img src="/public/icons/different/sale-10.png" class='menu-icon'>
                    Скидка 10% на аренду автомобилей после регистрации и авторизации
                </li>
                <li>
                    <img src="/public/icons/different/sale-li.png" class='menu-icon'>
                    Стоимость одного дня приравнивается по цене к 16-ти часам (при аренде на 17-24 ч. эта акция работает так же)
                </li>
            </ul>
        </div>
    </div>
    <div class="down-block">
        <h4 class="custom-h">
            <strong>Актуальные предложения </strong>
            <img src="/public/icons/different/sale.png" class='menu-icon'>
        </h4>
        <div class="slider">
            <div class="slider-win">
                <div class="slider-container">
                    <?php if (isset($categories)) foreach ($categories as $category) : ?>
                        <div class="slider-item">
                            <a href="/frontend/web/catalog/category?category_id=<?= Html::encode($category->id) ?>" class="item-info">
                                <div class="item-left">
                                    <?php if ($category->image) : ?>
                                        <img class="item-img" src="/public/images/categories/<?= Html::encode($category->image) ?>" width="100%" height="100%" />
                                    <?php else : ?>
                                        <img class="item-img" src="/public/images/categories/default.jfif" width="100%" height="100%" />
                                    <?php endif; ?>
                                </div>
                                <div class="item-right">
                                    <p class="item-name"> <?= Html::encode($category->name) ?></p>
                                    <strong class="item-price">
                                        <?php if (isset($categoryPrices[$category->id])) : ?>
                                            от <?= $categoryPrices[$category->id] ?> ₽/час
                                        <?php else : ?>
                                            цены не указаны
                                        <?php endif; ?>
                                    </strong>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="slider-control">
                <div id="sl-prev" class="sl-btn">
                    &#10094;
                </div>
                <div id="sl-next" class="sl-btn">
                    &#10095;
                </div>
            </div>
        </div>
    </div>
</div>