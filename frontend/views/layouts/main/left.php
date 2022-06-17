<?php

use yii\helpers\Html;
?>

<div class="shop-left">
    <nav>
        <ul class="topmenu">
            <?php
            if (isset($this->context->menu)) foreach ($this->context->menu->categories as $category) : ?>
                <li>
                    <a href="/frontend/web/catalog/category?category_id=<?= Html::encode($category->id) ?>">
                        <p class="down">
                            <?php if ($category->icon) : ?>
                                <img src="/public/icons/categories/<?= $category->icon ?>" class='menu-icon'>
                            <?php else : ?>
                                <img src="/public/icons/categories/default-car.png" class='menu-icon'>
                            <?php endif; ?>
                            <?= $category->name ?>
                        </p>
                    </a>
                    <ul class="submenu">
                        <?php if (isset($this->context->menu->objectives[$category->id])) foreach ($this->context->menu->objectives[$category->id] as $objective) : ?>
                            <li>
                                <a href='/frontend/web/catalog/main?objective_id=<?= Html::encode($objective->id) ?>' class="menu-a">
                                    <img src="/public/icons/categories/default-car.png" class='menu-icon'>
                                    <p class='action'>
                                        <?= Html::encode($objective->name) ?>
                                    </p>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <br>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>