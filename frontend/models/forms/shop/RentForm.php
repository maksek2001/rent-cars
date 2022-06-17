<?php

namespace frontend\models\forms\shop;

use common\models\shop\Car;
use common\models\shop\Rent;
use common\models\User;
use DateTime;
use DateTimeZone;
use yii\base\Model;

/**
 * Форма для аренды
 * @author Spirkov Maksim
 */
class RentForm extends Model
{
    const DAY_HOURS = 16;

    /** @var double */
    public $total_price;

    public $start_date;

    public $end_date;

    /** @var double */
    public $rental_price;

    /** @var string */
    public $email;

    public function attributeLabels()
    {
        return [
            'total_price' => 'Итоговая стоимость',
            'rental_price' => 'Почасовая стоимость',
            'start_date' => 'Начальная дата аренды',
            'end_date' => 'Конечная дата аренды',
            'email' => 'Ваш E-mail'
        ];
    }

    public function rules()
    {
        return [
            [['start_date', 'end_date', 'email', 'rental_price'], 'required', 'message' => 'Обязательное поле!'],
            ['email', 'email', 'message' => 'Некорректный E-mail'],
            [['rental_price'], 'double', 'message' => 'Введено не число'],
            ['start_date', 'validateStartDate'],
            ['end_date', 'validateEndDate']
        ];
    }

    public function validateStartDate($attribute)
    {
        $selected = new DateTime($this->start_date, new DateTimeZone('Europe/Samara'));
        $selected->modify("-4 hours");
        $today = new DateTime('now', new DateTimeZone('Europe/Samara'));

        if ($selected < $today) {
            $this->addError($attribute, 'Минимальное время, через которое можно забронировать автомобиль - 4 часа');
        }
    }

    public function validateEndDate($attribute)
    {
        $startDate = new DateTime($this->start_date, new DateTimeZone('Europe/Samara'));
        $selected = new DateTime($this->end_date, new DateTimeZone('Europe/Samara'));
        $today = new DateTime('now', new DateTimeZone('Europe/Samara'));

        if ($selected < $today || $selected <= $startDate) {
            $this->addError($attribute, 'Начальное время не должно быть раньше, чем через 4 часа от текущего');
        }
    }

    public function validateRentalPrice($car_id, $client)
    {
        $car = Car::findOne(['id' => $car_id]);
        if ($client == null) {
            return $car->rental_price == $this->rental_price;
        } else {
            return $car->rental_price == ($this->rental_price / 0.9);
        }
    }

    /**
     * Проверка на пристуствие VIP пользователей в массиве
     * @param array $rents
     */
    private function isVipInRents($rents): bool
    {
        foreach ($rents as $rent)
            if (User::findOne($rent['client_id'])->vip)
                return true;

        return false;
    }

    /**
     * @param int $client_id
     * @param int $car_id
     */
    private function createRent($client_id, $car_id): int
    {
        $rent = new Rent();

        $rent->client_id = $client_id;
        $rent->car_id = $car_id;
        $rent->total_price = $this->total_price;
        $rent->start_date = $this->start_date;
        $rent->end_date = $this->end_date;

        $rent->save(false);

        return $rent->id;
    }

    /**
     * Обновление статусов отменённых аренд
     * @param array $rents
     */
    private function updateStatuses($rents)
    {
        foreach ($rents as $rent)
            Rent::updateStatus($rent['id'], 'canceled_by_vip');
        // здесь можно сделать рассылку для пользователей
    }

    /**
     * @param User $client
     * @param int car_id
     * @param int $price
     */
    public function addRent($client, $car_id, $price): array
    {
        $this->total_price = $price;

        if (!$this->validate() || !$this->validateRentalPrice($car_id, $client))
            return [
                'code' => 'error',
                'response' => 'Введены неверные данные'
            ];

        $isNew = false;
        if ($client == null) {
            $newClient = new User();
            $result = $newClient->createNewClientByEmail($this->email);

            if (!$result['new'])
                return [
                    'code' => 'error',
                    'response' => 'Данный E-mail уже занят, если он ваш, то авторизуйтесь перед арендой'
                ];

            $isNew = $result['new'];
            $client = $result['client'];
        }

        $activeRents = Rent::getAllActiveRentsForCarByPeriod($this->start_date, $this->end_date, $car_id);

        if (count($activeRents) == 0) {
            $rentId = $this->createRent($client->id, $car_id);
            // здесь можно отправить сообщение на mail пользователю

            return [
                'code' => 'success',
                'response' => 'Вы арендовали автомобиль. Номер вашей аренды ' . $rentId . '.    ' .
                    'Вам отправлено сообщение на e-mail: ' . $this->email .
                    ($isNew ? ' Также был создан аккаунт. В качестве логина и пароля следует использовать ваш e-mail'
                        : ' Данная аренда теперь доступна в вашем личном кабинете')
            ];
        } else if ($client->vip) {

            if (!$this->isVipInRents($activeRents)) {
                $this->updateStatuses($activeRents);
                $rentId = $this->createRent($client->id, $car_id);
                // здесь можно отправить сообщение на mail пользователю

                return [
                    'code' => 'success',
                    'response' => 'Вы арендовали автомобиль. Номер вашей аренды ' . $rentId . '.    ' .
                        ' Вам отправлено сообщение на email: ' . $this->email
                ];
            }
        }

        return array(
            'code' => "error",
            'response' => "Данный период времени занят другими клиентами!"
        );
    }
}
