<?php

namespace frontend\models\forms\edit_user_info;

use yii\base\Model;
use common\models\user_info\ClientInformation;

/**
 * Форма основной информации клиента
 * @author Spirkov Maksim
 */
class ClientInfoForm extends Model
{

    /** @var string */
    public $fullname;

    /** @var string */
    public $sex;

    public $birth_date;

    public function attributeLabels()
    {
        return [
            'fullname' => 'ФИО',
            'sex' => 'Пол',
            'birth_date' => 'Дата рождения'
        ];
    }

    public function rules()
    {
        return [
            [['fullname', 'sex', 'birth_date'], 'required', 'message' => 'Обязательное поле!']
        ];
    }

    /**
     * Обновление основной информации
     */
    public function updateInfo($client_id): bool
    {
        if (!$this->validate())
            return false;

        $clientInfo = ClientInformation::findOne($client_id);

        if (!$clientInfo) {
            $clientInfo = new ClientInformation();
            $clientInfo->client_id = $client_id;
        }

        $clientInfo->fullname = $this->fullname;
        $clientInfo->sex = $this->sex;
        $clientInfo->birth_date = $this->birth_date;

        return $clientInfo->save(false);
    }
}
