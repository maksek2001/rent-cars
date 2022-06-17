<?php

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

const STATUSES_MESSAGE = [
    'active' => 'Активна',
    'canceled_by_vip' => 'Отменена VIP-клиентом',
    'canceled_by_yourself' => 'Отменена вами',
    'completed' => 'Завершена',
    'overdue' => 'Просрочена',
    'pending' => 'В ожидании завершения'
];

const SEX = [
    'male' => 'Мужской',
    'female' => 'Женский'
];

$this->title = 'Личный кабинет ' . Yii::$app->name;
?>
<div class="office-container">
    <div class="user-info block-info">
        <div class="panel-info">
            <div class="info-control">
                <h5><strong>Аккаунт <img src="/public/icons/different/account.png" class='middle-icon'></strong></h5>
            </div>
            <p class='info-text'>Тип аккаунта: &nbsp;&nbsp;<strong><?= $this->context->vip ? 'VIP' : 'Базовый' ?></strong> </p>
        </div>
        <div class="contacts-info panel-info">
            <div class="info-control">
                <h5>
                    <strong><u>Контактная информация</u>
                        <img src="/public/icons/different/office-contacts.png" class='middle-icon'>
                    </strong>
                    <a class="edit" href="../edit-client-info/contact">Изменить</a>
                </h5>
            </div>
            <div class="info">
                <p class='info-text'>
                    <img src="/public/icons/different/mail.png" class='middle-icon'> &nbsp;&nbsp;
                    <strong><?= Html::encode($client->email) ?></strong>
                </p>
                <p class='info-text'>
                    <img src="/public/icons/different/phone.png" class='middle-icon'> &nbsp;&nbsp;
                    <strong>
                        <?= $client->phone ? Html::encode($client->phone) : 'Не указан' ?>
                    </strong>
                </p>
            </div>
        </div>
        <div class="panel-info">
            <div class="info-control">
                <h5>
                    <strong><u>Основная информация</u>
                        <img src="/public/icons/different/article.png" class='middle-icon'>
                    </strong>
                    <a class="edit" href="../edit-client-info/main">Изменить</a>
                </h5>
            </div>
            <div class="info">
                <p class='info-text'><strong>ФИО:</strong> &nbsp;&nbsp;
                    <?= $clientInfo->fullname ? Html::encode($clientInfo->fullname) : 'Не указано' ?>
                </p>
                <p class='info-text'><strong>Пол:</strong> &nbsp;&nbsp;
                    <?= SEX[$clientInfo->sex] ? Html::encode(SEX[$clientInfo->sex]) : 'Не указан' ?>
                </p>
                <p class='info-text'><strong>Дата рождения:</strong> &nbsp;&nbsp;
                    <?= $clientInfo->birth_date ? Html::encode($clientInfo->birth_date) : 'Не указана' ?>
                </p>
            </div>
        </div>
        <div class="panel-info">
            <div class="info-control">
                <h5>
                    <strong><u>Паспорт</u>
                        <img src="/public/icons/different/passport.png" class='middle-icon'>
                    </strong>
                    <a class="edit" href="../edit-client-info/passport">Изменить</a>
                </h5>
            </div>
            <div class="info">
                <p class='info-text'><strong>Серия:</strong> &nbsp;&nbsp;
                    <?= $passportInfo->serie ? Html::encode($passportInfo->serie) : 'Не указана' ?>
                </p>
                <p class='info-text'><strong>Номер:</strong> &nbsp;&nbsp;
                    <?= $passportInfo->number ? Html::encode($passportInfo->number) : 'Не указан' ?>
                </p>
                <p class='info-text'><strong>Дата выдачи:</strong> &nbsp;&nbsp;
                    <?= $passportInfo->issue_date ? Html::encode($passportInfo->issue_date) : 'Не указана' ?>
                </p>
                <p class='info-text'><strong>Кем выдан:</strong> &nbsp;&nbsp;
                    <?= $passportInfo->issue_organization ? Html::encode($passportInfo->issue_organization) : 'Организация не указана' ?>
                </p>
                <p class='info-text'><strong>Код подразделения:</strong> &nbsp;&nbsp;
                    <?= $passportInfo->organization_code ? Html::encode($passportInfo->organization_code) : 'Не указан' ?>
                </p>
            </div>
        </div>
        <div class="panel-info">
            <div class="info-control">
                <h5>
                    <strong> <u>Водительское удостоверение</u>
                        <img src="/public/icons/different/license.png" class='large-icon'>
                    </strong>
                    <a class="edit" href="../edit-client-info/license">Изменить</a>
                </h5>
            </div>
            <div class="info">
                <p class='info-text'><strong>Серия:</strong> &nbsp;&nbsp;
                    <?= $licenseInfo->serie ? Html::encode($licenseInfo->serie) : 'Не указана' ?>
                </p>
                <p class='info-text'><strong>Номер:</strong> &nbsp;&nbsp;
                    <?= $licenseInfo->number ? Html::encode($licenseInfo->number) : 'Не указан' ?>
                </p>
                <p class='info-text'><strong>Дата выдачи:</strong> &nbsp;&nbsp;
                    <?= $licenseInfo->issue_date ? Html::encode($licenseInfo->issue_date) : 'Не указана' ?>
                </p>
                <p class='info-text'><strong>Дата окончания действия:</strong> &nbsp;&nbsp;
                    <?= $licenseInfo->expiration_date ? Html::encode($licenseInfo->expiration_date) : 'Не указана' ?>
                </p>
            </div>
        </div>
    </div>
    <div class="user-rents block-info">
        <?php if (isset($rents)) foreach ($rents as $rent) : ?>
            <div class="panel-info">
                <div class="info-control">
                    <div class="left-info">
                        <p class="rent-id">
                            <img src="/public/icons/different/rent.png" class='middle-icon'>&nbsp;&nbsp;
                            <strong><u>Аренда</u> #<?= Html::encode($rent->id) ?></strong>
                        </p>
                        <p class="rent-period info-text">
                            <img src="/public/icons/different/history.png" class='middle-icon'>&nbsp;&nbsp;&nbsp;
                            <?= $rent->start_date . " &nbsp; - &nbsp; " . Html::encode($rent->end_date) ?>
                        </p>
                        <div>
                            <?php if ($rent->status == 'active') : ?>
                                <img src="/public/icons/different/cancel.png" class='middle-icon'>&nbsp;&nbsp;&nbsp;
                                <?= Html::a('Отменить аренду', "cancel-rent?rent_id=$rent->id", [
                                    'class' => 'info-text cancel',
                                    'data' => [
                                        'confirm' => 'Вы действительно хотите отменить аренду?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                        <a class="info-text rent-car" href="../catalog/car?car_id=<?= Html::encode($rent->car_id) ?>" target="_blank">
                            <img src="/public/icons/different/car-black.png" class='menu-icon'>
                            Перейти к выбранному автомобилю
                        </a>
                    </div>
                    <div class="right-info">
                        <p class="rent-price">
                            <strong>
                                <?= $rent->total_price ?> ₽
                            </strong>
                        </p>
                        <p class="rent-status rent-<?= $rent->status ?>">
                            <?= STATUSES_MESSAGE[$rent->status] ? Html::encode(STATUSES_MESSAGE[$rent->status]) : 'Особый' ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <nav">
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,

                'options' => [
                    'class' => 'pagination justify-content-center',
                ],
                'pageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item next',
                'prevPageCssClass' => 'page-item prev',
            ]);
            ?>
            </nav>
    </div>
</div>