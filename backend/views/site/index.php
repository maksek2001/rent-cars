<?php

use yii\helpers\Html;

const STATUSES_MESSAGE = [
    'active' => 'Активна',
    'canceled_by_vip' => 'Отменена VIP-клиентом',
    'canceled_by_yourself' => 'Отменена самим клиентом',
    'completed' => 'Завершена',
    'overdue' => 'Просрочена',
    'pending' => 'В ожидании завершения'
];

$this->title = Yii::$app->name;

?>

<div class="rents block-info">
    <div class="filter-block">
        <div class="inner-filter-block-left">
            <p>по статусу:</p>
            <select id="status-select" class="form-control">
                <option value="">Любой</option>
                <?php foreach (STATUSES_MESSAGE as $status => $message) : ?>
                    <option value="<?= $status ?>"><?= $message ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="inner-filter-block-right">
            <p>по цене</p>
            <div class="filter-price">
                <input class="filter-input form-control" id="start-price" placeholder="Минимум">
                <input class="filter-input form-control" id="end-price" placeholder="Максимум">
            </div>
        </div>
    </div>
    <div class="base-rent-block">
        <br>
        <p>по дате и времени (берётся полный период аренды)</p>
        <div class="filter-block">
            <input class="filter-input form-control" id="start-date" type="datetime-local">
            <input class="filter-input form-control" id="end-date" type="datetime-local">
        </div>
    </div>
    <div class="base-rent-block">
        <button class="filter btn btn-primary" id="filter">Фильтровать</button>
    </div>
    <div id="rents">
        <?php if (isset($allRents)) foreach ($allRents as $rent) : ?>

            <?php if ($rent->status == 'active' && new DateTime($rent->start_date, new DateTimeZone('Europe/Samara')) < new DateTime('now', new DateTimeZone('Europe/Samara'))) {
                $rent->status = 'indeterminated';
            } ?>

            <div class="panel-info" data-price="<?= Html::encode($rent->total_price) ?>" data-status="<?= Html::encode($rent->status) ?>" data-start-date="<?= Html::encode($rent->start_date) ?>" data-end-date="<?= Html::encode($rent->end_date) ?>">
                <div class="info-control">
                    <div class="left-info">
                        <p class="rent-id">
                            <img src="/public/icons/different/rent.png" class='middle-icon'>&nbsp;&nbsp;
                            <strong><u>Аренда</u> #<?= Html::encode($rent->id) ?></strong>
                        </p>
                        <p class="rent-period info-text">
                            <img src="/public/icons/different/history.png" class='middle-icon'>&nbsp;&nbsp;&nbsp;
                            <?= Html::encode($rent->start_date) . " &nbsp; - &nbsp; " . Html::encode($rent->end_date) ?>
                        </p>
                        <div>
                            <?php if ($rent->status == 'active' || $rent->status == 'pending') : ?>
                                <img src="/public/icons/different/check-mark.png" class='middle-icon'>&nbsp;&nbsp;&nbsp;
                                <?= Html::a('Завершить аренду', "/backend/web/site/complete-rent?rent_id=$rent->id", [
                                    'class' => 'info-text cancel',
                                    'data' => [
                                        'confirm' => 'Вы действительно хотите завершить аренду?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                        <div class="info-text rent-client-info">
                            <details>
                                <summary class="summary-shop">
                                    <img src="/public/icons/different/account.png" class='middle-icon'>&nbsp;&nbsp;&nbsp;
                                    Информация о клиенте
                                </summary>
                                <div class="client-info-main">
                                    <strong class="info-header">Основная информация</strong>
                                    <div class="client-info">
                                        <p class='text'><strong>ФИО:</strong> &nbsp;&nbsp;
                                            <?= $clientsInfo[$rent->client_id]->fullname ? Html::encode($clientsInfo[$rent->client_id]->fullname) : 'Не указано' ?>
                                        </p>
                                        <p class='text'><strong>Пол:</strong> &nbsp;&nbsp;
                                            <?= ($clientsInfo[$rent->client_id]->sex == 'male') ? 'Мужской' : 'Женский' ?>
                                        </p>
                                        <p class='text'><strong>Дата рождения:</strong> &nbsp;&nbsp;
                                            <?= $clientsInfo[$rent->client_id]->birth_date ? Html::encode($clientsInfo[$rent->client_id]->birth_date) : 'Не указана' ?>
                                        </p>
                                    </div>
                                    <strong class="info-header">Контактная информация</strong>
                                    <div class="client-info">
                                        <p class='text'>
                                            <img src="/public/icons/different/mail.png" class='icon'> &nbsp;&nbsp;
                                            <strong>
                                                <?= Html::encode($clientsContacts[$rent->client_id]->email) ?>
                                            </strong>
                                        </p>
                                        <p class='text'>
                                            <img src="/public/icons/different/phone.png" class='icon'> &nbsp;&nbsp;
                                            <strong>
                                                <?= $clientsContacts[$rent->client_id]->phone ? Html::encode($clientsContacts[$rent->client_id]->phone) : 'Не указан' ?>
                                            </strong>
                                        </p>
                                    </div>
                                    <strong class="info-header">Паспортные данные</strong>
                                    <div class="client-info">
                                        <p class='text'><strong>Серия:</strong> &nbsp;&nbsp;
                                            <?= $clientsPassports[$rent->client_id]->serie ? Html::encode($clientsPassports[$rent->client_id]->serie) : 'Не указана' ?>
                                        </p>
                                        <p class='text'><strong>Номер:</strong> &nbsp;&nbsp;
                                            <?= $clientsPassports[$rent->client_id]->number ? Html::encode($clientsPassports[$rent->client_id]->number) : 'Не указан' ?>
                                        </p>
                                        <p class='text'><strong>Дата выдачи:</strong> &nbsp;&nbsp;
                                            <?= $clientsPassports[$rent->client_id]->issue_date ? Html::encode($clientsPassports[$rent->client_id]->issue_date) : 'Не указана' ?>
                                        </p>
                                        <p class='text'><strong>Кем выдан:</strong> &nbsp;&nbsp;
                                            <?= $clientsPassports[$rent->client_id]->issue_organization ? Html::encode($clientsPassports[$rent->client_id]->issue_organization) : 'Организация не указана' ?>
                                        </p>
                                        <p class='text'><strong>Код подразделения:</strong> &nbsp;&nbsp;
                                            <?= $clientsPassports[$rent->client_id]->organization_code ? Html::encode($clientsPassports[$rent->client_id]->organization_code) : 'Не указан' ?>
                                        </p>
                                    </div>
                                    <strong class="info-header">Водительское удостоверение</strong>
                                    <div class="client-info">
                                        <p class='text'><strong>Серия:</strong> &nbsp;&nbsp;
                                            <?= $clientsLicenses[$rent->client_id]->serie ? Html::encode($clientsLicenses[$rent->client_id]->serie) : 'Не указана' ?>
                                        </p>
                                        <p class='text'><strong>Номер:</strong> &nbsp;&nbsp;
                                            <?= $clientsLicenses[$rent->client_id]->number ? Html::encode($clientsLicenses[$rent->client_id]->number) : 'Не указан' ?>
                                        </p>
                                        <p class='text'><strong>Дата выдачи:</strong> &nbsp;&nbsp;
                                            <?= $clientsLicenses[$rent->client_id]->issue_date ? Html::encode($clientsLicenses[$rent->client_id]->issue_date) : 'Не указана' ?>
                                        </p>
                                        <p class='text'><strong>Дата окончания действия:</strong> &nbsp;&nbsp;
                                            <?= $clientsLicenses[$rent->client_id]->expiration_date ? Html::encode($clientsLicenses[$rent->client_id]->expiration_date) : 'Не указана' ?>
                                        </p>
                                    </div>
                                </div>
                            </details>
                        </div>
                        <a class="info-text rent-car" href="/frontend/web/catalog/car?car_id=<?= Html::encode($rent->car_id) ?>" target="_blank">
                            <img src="/public/icons/different/car-black.png" class='menu-icon'>
                            Перейти к выбранному автомобилю
                        </a>
                    </div>
                    <div class="right-info">
                        <p class="rent-price">
                            <strong>
                                <?= Html::encode($rent->total_price) ?> ₽
                            </strong>
                        </p>
                        <p class="rent-status rent-<?= $rent->status ?>">
                            <?= STATUSES_MESSAGE[$rent->status] ? Html::encode(STATUSES_MESSAGE[$rent->status]) : 'Особый' ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php $this->registerJsFile('/backend/web/js/filter.js'); ?>
</div>